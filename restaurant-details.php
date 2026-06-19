<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

$restaurant = null;
$reviews = [];
$average_rating = null;
$restaurant_id = $_GET['id'] ?? 0;

if ($restaurant_id) {
    try {
        // Fetch restaurant details
        $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = ?");
        $stmt->execute([$restaurant_id]);
        $restaurant = $stmt->fetch();

        if ($restaurant) {
            // Fetch reviews for the restaurant
            $stmt = $pdo->prepare("SELECT r.*, COUNT(l.id) AS like_count,
                                   EXISTS(SELECT 1 FROM review_likes rl WHERE rl.review_id = r.id AND rl.user_id = ?) AS liked_by_me
                                   FROM reviews r
                                   LEFT JOIN review_likes l ON l.review_id = r.id
                                   WHERE r.restaurant_id = ?
                                   GROUP BY r.id
                                   ORDER BY r.created_at DESC");
            $stmt->execute([current_user()['id'] ?? 0, $restaurant_id]);
            $reviews = $stmt->fetchAll();

            // Calculate average rating
            $stmt = $pdo->prepare("SELECT AVG(rating) AS average_rating FROM reviews WHERE restaurant_id = ?");
            $stmt->execute([$restaurant_id]);
            $result = $stmt->fetch();
            $average_rating = $result['average_rating'];
        }

    } catch (PDOException $e) {
        echo "<p class=\"error-message\">Error fetching restaurant details: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

if (!$restaurant): ?>
    <p class="error-message">Restaurant not found.</p>
<?php else: ?>
    <section class="detail-hero container">
        <div class="detail-hero-media">
            <img src="assets/images/<?= htmlspecialchars($restaurant['image'] ?? 'modern-dark-placeholder.jpg') ?>" alt="<?= htmlspecialchars($restaurant['name']) ?>">
        </div>
        <div class="detail-hero-content">
            <p class="eyebrow">Restaurant profile</p>
            <h2><?= htmlspecialchars($restaurant['name']) ?></h2>
            <div class="detail-meta">
                <span><?= htmlspecialchars($restaurant['cuisine_type']) ?></span>
                <span><?= htmlspecialchars($restaurant['location']) ?></span>
                <span><?= htmlspecialchars($restaurant['opening_hours']) ?></span>
            </div>
            <p class="detail-description"><?= htmlspecialchars($restaurant['description']) ?></p>

            <?php if ($average_rating): ?>
                <p class="average-rating"><?= htmlspecialchars(number_format($average_rating, 1)) ?> <span>&#9733;</span> Average Rating</p>
            <?php else: ?>
                <p class="average-rating">No reviews yet.</p>
            <?php endif; ?>

            <div class="actions">
                <?php if (is_logged_in()): ?>
                    <a href="submit-review.php?restaurant_id=<?= htmlspecialchars($restaurant['id']) ?>&restaurant_name=<?= urlencode($restaurant['name']) ?>" class="button-primary">Submit a Review</a>
                <?php endif; ?>
                <?php if (is_admin()): ?>
                    <a href="edit-restaurant.php?id=<?= htmlspecialchars($restaurant['id']) ?>" class="button-secondary">Edit Restaurant</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="reviews-section container">
        <div class="section-heading">
            <h3>Customer Reviews</h3>
            <p>Recent feedback from diners.</p>
        </div>
        <div class="reviews-list">
            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card">
                        <div class="review-card-header">
                            <div>
                                <p class="review-author"><?= htmlspecialchars($review['customer_name']) ?></p>
                                <p class="timestamp">Reviewed on: <?= htmlspecialchars($review['created_at']) ?></p>
                            </div>
                            <span class="rating-pill"><?= htmlspecialchars($review['rating']) ?> &#9733;</span>
                        </div>
                        <p class="review-email"><?= htmlspecialchars($review['email']) ?></p>
                        <p class="review-text"><?= nl2br(htmlspecialchars($review['review'])) ?></p>
                        <div class="review-actions">
                            <span class="rating-pill muted"><?= (int)$review['like_count'] ?> likes</span>
                            <?php if (is_logged_in() && (current_user()['id'] ?? null) != $review['user_id']): ?>
                                <form action="toggle-like.php" method="POST" class="inline-form">
                                    <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id']) ?>">
                                    <input type="hidden" name="restaurant_id" value="<?= htmlspecialchars($restaurant['id']) ?>">
                                    <button type="submit" class="button-secondary"><?= !empty($review['liked_by_me']) ? 'Unlike' : 'Like' ?></button>
                                </form>
                            <?php endif; ?>
                            <?php if (is_logged_in() && ((current_user()['id'] ?? null) == $review['user_id'] || is_admin())): ?>
                                <form action="delete-review.php" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                    <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id']) ?>">
                                    <input type="hidden" name="restaurant_id" value="<?= htmlspecialchars($restaurant['id']) ?>">
                                    <button type="submit" class="button-delete">Delete Review</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No reviews for this restaurant yet.</p>
                    <?php if (is_logged_in()): ?>
                        <a href="submit-review.php?restaurant_id=<?= htmlspecialchars($restaurant['id']) ?>&restaurant_name=<?= urlencode($restaurant['name']) ?>" class="button-primary">Be the first to submit one</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>

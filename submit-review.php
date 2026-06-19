<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();
require_once 'includes/header.php';

$restaurant_id = $_GET['restaurant_id'] ?? null;
$restaurant_name = $_GET['restaurant_name'] ?? '';
$word_limit = 500;

$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_id = $_POST['restaurant_id'] ?? null;
    $restaurant_name = trim($_POST['restaurant_name'] ?? '');
    $currentUser = current_user();
    $customer_name = trim($currentUser['name'] ?? '');
    $email = trim($currentUser['email'] ?? '');
    $rating = $_POST['rating'] ?? '';
    $review_message = trim($_POST['review_message'] ?? '');
    $review_word_count = str_word_count($review_message);

    // PHP Validation
    if (empty($restaurant_id)) {
        $errors[] = "Restaurant ID is missing.";
    }
    if (empty($restaurant_name)) {
        $errors[] = "Restaurant name is required.";
    }
    if (empty($customer_name)) {
        $errors[] = "Customer name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($rating)) {
        $errors[] = "Rating is required.";
    } elseif (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        $errors[] = "Rating must be between 1 and 5.";
    }
    if (empty($review_message)) {
        $errors[] = "Review message cannot be empty.";
    } elseif ($review_word_count > $word_limit) {
        $errors[] = "Review message must be $word_limit words or fewer.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO reviews (restaurant_id, restaurant_name, user_id, customer_name, email, rating, review) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$restaurant_id, $restaurant_name, $currentUser['id'], $customer_name, $email, $rating, $review_message]);
            $success_message = "Your review has been submitted successfully!";
            // Clear form fields after successful submission
            $customer_name = '';
            $email = '';
            $rating = '';
            $review_message = '';
        } catch (PDOException $e) {
            $errors[] = "Error submitting review: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<section class="form-page-shell">
    <div class="section-heading">
        <h2>Submit a Review for <?= htmlspecialchars($restaurant_name) ?></h2>
        <p>Share feedback without changing the review submission flow.</p>
    </div>

    <form id="reviewForm" action="submit-review.php" method="POST">
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <p class="success-message"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>

        <input type="hidden" name="restaurant_id" value="<?= htmlspecialchars($restaurant_id) ?>">
        <input type="hidden" name="restaurant_name" value="<?= htmlspecialchars($restaurant_name) ?>">

        <label for="customer_name">Your Name:</label>
        <input type="text" id="customer_name" value="<?= htmlspecialchars(current_user()['name'] ?? '') ?>" disabled>

        <label for="email">Your Email:</label>
        <input type="email" id="email" value="<?= htmlspecialchars(current_user()['email'] ?? '') ?>" disabled>

        <fieldset class="rating-fieldset">
            <legend>Rating</legend>
            <div class="star-rating" aria-label="Restaurant rating from 1 to 5 stars">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <input
                        type="radio"
                        id="rating-<?= $i ?>"
                        name="rating"
                        value="<?= $i ?>"
                        <?= (isset($rating) && $rating == $i) ? 'checked' : '' ?>
                        required
                    >
                    <label for="rating-<?= $i ?>" title="<?= $i ?> stars"><?= $i ?> star<?= $i > 1 ? 's' : '' ?></label>
                <?php endfor; ?>
            </div>
        </fieldset>

        <label for="review_message">Your Review:</label>
        <textarea id="review_message" name="review_message" rows="5" maxlength="3500" data-word-limit="<?= $word_limit ?>" required><?= htmlspecialchars($review_message ?? '') ?></textarea>
        <p class="field-hint"><span id="reviewWordCount">0</span>/<?= $word_limit ?> words</p>

        <div class="form-actions">
            <button type="submit" class="button-primary">Submit Review</button>
            <a href="restaurant-details.php?id=<?= htmlspecialchars($restaurant_id) ?>" class="button-secondary">Cancel</a>
        </div>
    </form>
</section>

<script src="assets/js/validation.js"></script>

<?php require_once 'includes/footer.php'; ?>

<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

$restaurant_id = $_GET['restaurant_id'] ?? null;
$restaurant_name = $_GET['restaurant_name'] ?? '';

$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_id = $_POST['restaurant_id'] ?? null;
    $restaurant_name = trim($_POST['restaurant_name'] ?? '');
    $customer_name = trim($_POST['customer_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rating = $_POST['rating'] ?? '';
    $review_message = trim($_POST['review_message'] ?? '');

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
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO reviews (restaurant_id, restaurant_name, customer_name, email, rating, review) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$restaurant_id, $restaurant_name, $customer_name, $email, $rating, $review_message]);
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
        <input type="text" id="customer_name" name="customer_name" value="<?= htmlspecialchars($customer_name ?? '') ?>" required>
        <span class="error-message"></span>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        <span class="error-message"></span>

        <label for="rating">Rating (1-5):</label>
        <select id="rating" name="rating" required>
            <option value="">Select a rating</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>" <?= (isset($rating) && $rating == $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <span class="error-message"></span>

        <label for="review_message">Your Review:</label>
        <textarea id="review_message" name="review_message" rows="5" required><?= htmlspecialchars($review_message ?? '') ?></textarea>
        <span class="error-message"></span>

        <div class="form-actions">
            <button type="submit" class="button-primary">Submit Review</button>
            <a href="restaurant-details.php?id=<?= htmlspecialchars($restaurant_id) ?>" class="button-secondary">Cancel</a>
        </div>
    </form>
</section>

<script src="assets/js/validation.js"></script>

<?php require_once 'includes/footer.php'; ?>

<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_admin();
require_once 'includes/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $cuisine_type = trim($_POST['cuisine_type'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $opening_hours = trim($_POST['opening_hours'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if ($name === '' || $cuisine_type === '' || $location === '' || $description === '' || $opening_hours === '') {
        $errors[] = 'All fields except image are required.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO restaurants (name, cuisine_type, location, description, opening_hours, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $cuisine_type, $location, $description, $opening_hours, $image ?: null]);
        header('Location: index.php?status=restaurant_added');
        exit;
    }
}
?>

<section class="form-page-shell">
    <div class="section-heading">
        <h2>Add Restaurant</h2>
        <p>Admin only.</p>
    </div>

    <?php foreach ($errors as $error): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form method="POST">
        <label>Name</label>
        <input name="name" required>
        <label>Cuisine Type</label>
        <input name="cuisine_type" required>
        <label>Location</label>
        <input name="location" required>
        <label>Opening Hours</label>
        <input name="opening_hours" required>
        <label>Description</label>
        <textarea name="description" rows="5" required></textarea>
        <label>Image Filename</label>
        <input name="image">
        <div class="form-actions">
            <button class="button-primary" type="submit">Save</button>
            <a class="button-secondary" href="index.php">Cancel</a>
        </div>
    </form>
</section>

<?php require_once 'includes/footer.php'; ?>

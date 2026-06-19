<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_admin();
require_once 'includes/header.php';

$restaurant = null;
$errors = [];
$success_message = '';
$cuisine_options = [
    'Malay',
    'Chinese',
    'Indian',
    'Mamak',
    'Western',
    'Japanese',
    'Korean',
    'Thai',
    'Italian',
    'Fast Food',
    'Dessert',
    'Cafe',
    'Seafood',
    'Other',
];
$day_options = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
$time_options = [
    '06:00', '06:30', '07:00', '07:30', '08:00', '08:30',
    '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
    '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
    '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
    '18:00', '18:30', '19:00', '19:30', '20:00', '20:30',
    '21:00', '21:30', '22:00', '22:30', '23:00', '23:30',
];

$restaurant_id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_id = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $cuisine_type = trim($_POST['cuisine_type'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $opening_hours = trim($_POST['opening_hours'] ?? '');
    $image = trim($_POST['image'] ?? ''); // Assuming image path can be updated or kept

    // PHP Validation
    if (empty($restaurant_id)) {
        $errors[] = "Restaurant ID is missing.";
    }
    if (empty($name)) {
        $errors[] = "Restaurant name is required.";
    }
    if (empty($cuisine_type)) {
        $errors[] = "Cuisine type is required.";
    }
    if (empty($description)) {
        $errors[] = "Description is required.";
    }
    if (empty($opening_hours)) {
        $errors[] = "Opening hours are required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE restaurants SET name = ?, cuisine_type = ?, description = ?, opening_hours = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $cuisine_type, $description, $opening_hours, $image, $restaurant_id]);
            $success_message = "Restaurant information updated successfully!";
            header("Location: restaurant-details.php?id=" . urlencode($restaurant_id));
            exit;
        } catch (PDOException $e) {
            $errors[] = "Error updating restaurant: " . htmlspecialchars($e->getMessage());
        }
    }

    // If there are errors, re-fetch restaurant data to re-populate the form correctly
    if (!empty($errors) && $restaurant_id) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = ?");
            $stmt->execute([$restaurant_id]);
            $restaurant = $stmt->fetch();
        } catch (PDOException $e) {
            $errors[] = "Error fetching restaurant data for re-display: " . htmlspecialchars($e->getMessage());
        }
    }

} else {
    // Initial load for GET request
    if ($restaurant_id) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = ?");
            $stmt->execute([$restaurant_id]);
            $restaurant = $stmt->fetch();
            if (!$restaurant) {
                $errors[] = "Restaurant not found.";
            }
        } catch (PDOException $e) {
            $errors[] = "Error fetching restaurant: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $errors[] = "No restaurant ID provided.";
    }
}
?>

<section class="form-page-shell">
    <div class="section-heading">
        <h2>Edit Restaurant Information</h2>
        <p>Update the restaurant profile details shown on the listing and detail pages.</p>
    </div>

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

    <?php if ($restaurant): ?>
        <?php
        $opening_day_from = '';
        $opening_day_to = '';
        $opening_time_from = '';
        $opening_time_to = '';
        if (!empty($restaurant['opening_hours']) && preg_match('/^([A-Za-z]{3})-([A-Za-z]{3}),\s*([0-9]{2}:[0-9]{2})-([0-9]{2}:[0-9]{2})$/', $restaurant['opening_hours'], $matches)) {
            $opening_day_from = $matches[1];
            $opening_day_to = $matches[2];
            $opening_time_from = $matches[3];
            $opening_time_to = $matches[4];
        }
        ?>
        <form action="edit-restaurant.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($restaurant['id']) ?>">

            <label for="name">Restaurant Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($restaurant['name']) ?>" required>

            <label for="cuisine_type">Cuisine Type:</label>
            <select id="cuisine_type" name="cuisine_type" required>
                <option value="">Select cuisine</option>
                <?php foreach ($cuisine_options as $option): ?>
                    <option value="<?= htmlspecialchars($option) ?>" <?= $restaurant['cuisine_type'] === $option ? 'selected' : '' ?>><?= htmlspecialchars($option) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($restaurant['location']) ?>" required>

            <label for="opening_hours">Opening Hours:</label>
            <div class="opening-hours-grid">
                <select name="opening_day_from" required>
                    <option value="">From day</option>
                    <?php foreach ($day_options as $day): ?>
                        <option value="<?= htmlspecialchars($day) ?>" <?= $opening_day_from === $day ? 'selected' : '' ?>><?= htmlspecialchars($day) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="opening_day_to" required>
                    <option value="">To day</option>
                    <?php foreach ($day_options as $day): ?>
                        <option value="<?= htmlspecialchars($day) ?>" <?= $opening_day_to === $day ? 'selected' : '' ?>><?= htmlspecialchars($day) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="opening_time_from" required>
                    <option value="">From time</option>
                    <?php foreach ($time_options as $time): ?>
                        <option value="<?= htmlspecialchars($time) ?>" <?= $opening_time_from === $time ? 'selected' : '' ?>><?= htmlspecialchars($time) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="opening_time_to" required>
                    <option value="">To time</option>
                    <?php foreach ($time_options as $time): ?>
                        <option value="<?= htmlspecialchars($time) ?>" <?= $opening_time_to === $time ? 'selected' : '' ?>><?= htmlspecialchars($time) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="opening_hours" id="opening_hours" value="<?= htmlspecialchars($restaurant['opening_hours']) ?>">
            </div>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($restaurant['description']) ?></textarea>

            <label for="image">Image Filename:</label>
            <input type="text" id="image" name="image" value="<?= htmlspecialchars($restaurant['image'] ?? '') ?>">

            <div class="form-actions">
                <button type="submit" class="button-primary">Update Restaurant</button>
                <a href="restaurant-details.php?id=<?= htmlspecialchars($restaurant['id']) ?>" class="button-secondary">Cancel</a>
            </div>
        </form>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const hidden = document.getElementById('opening_hours');
            if (!form || !hidden) return;

            form.addEventListener('submit', function () {
                const dayFrom = form.elements.opening_day_from.value;
                const dayTo = form.elements.opening_day_to.value;
                const timeFrom = form.elements.opening_time_from.value;
                const timeTo = form.elements.opening_time_to.value;
                hidden.value = `${dayFrom}-${dayTo}, ${timeFrom}-${timeTo}`;
            });
        });
        </script>
    <?php else: ?>
        <p class="error-message">Error: <?= htmlspecialchars($errors[0] ?? 'Restaurant data could not be loaded.') ?></p>
        <p><a href="index.php">Go back to restaurant list</a></p>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>

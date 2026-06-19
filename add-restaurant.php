<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_admin();
require_once 'includes/header.php';

$errors = [];

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
        <select name="cuisine_type" required>
            <option value="">Select cuisine</option>
            <?php foreach ($cuisine_options as $option): ?>
                <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Location</label>
        <input name="location" required>
        <label>Opening Hours</label>
        <div class="opening-hours-grid">
            <select name="opening_day_from" required>
                <option value="">From day</option>
                <?php foreach ($day_options as $day): ?>
                    <option value="<?= htmlspecialchars($day) ?>"><?= htmlspecialchars($day) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="opening_day_to" required>
                <option value="">To day</option>
                <?php foreach ($day_options as $day): ?>
                    <option value="<?= htmlspecialchars($day) ?>"><?= htmlspecialchars($day) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="opening_time_from" required>
                <option value="">From time</option>
                <?php foreach ($time_options as $time): ?>
                    <option value="<?= htmlspecialchars($time) ?>"><?= htmlspecialchars($time) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="opening_time_to" required>
                <option value="">To time</option>
                <?php foreach ($time_options as $time): ?>
                    <option value="<?= htmlspecialchars($time) ?>"><?= htmlspecialchars($time) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="opening_hours" id="opening_hours">
        </div>
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

<?php require_once 'includes/footer.php'; ?>

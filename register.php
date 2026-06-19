<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $errors[] = 'All fields are required.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email already registered.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            header('Location: login.php');
            exit;
        }
    }
}

require_once 'includes/header.php';
?>
<section class="form-page-shell">
    <div class="section-heading"><h2>Register</h2></div>
    <?php foreach ($errors as $error): ?><p class="error-message"><?= htmlspecialchars($error) ?></p><?php endforeach; ?>
    <form method="POST">
        <label>Name</label><input name="name" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Password</label><input type="password" name="password" required>
        <div class="form-actions"><button class="button-primary">Register</button></div>
    </form>
</section>
<?php require_once 'includes/footer.php'; ?>

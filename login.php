<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if (!$user || !password_verify($password, $user['password'])) {
        $errors[] = 'Invalid credentials.';
    } else {
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'role' => $user['role']];
        header('Location: index.php');
        exit;
    }
}

require_once 'includes/header.php';
?>
<section class="form-page-shell">
    <div class="section-heading"><h2>Login</h2></div>
    <?php foreach ($errors as $error): ?><p class="error-message"><?= htmlspecialchars($error) ?></p><?php endforeach; ?>
    <form method="POST">
        <label>Email</label><input type="email" name="email" required>
        <label>Password</label><input type="password" name="password" required>
        <div class="form-actions"><button class="button-primary">Login</button></div>
    </form>
</section>
<?php require_once 'includes/footer.php'; ?>

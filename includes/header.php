<?php require_once __DIR__ . '/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f172a">
    <title>RestView: Restaurant Listing and Review System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="brand-lockup">
                <a class="brand-mark" href="index.php" aria-label="RestView home">RV</a>
                <div>
                    <h1><a href="index.php">RestView</a></h1>
                    <p class="brand-tagline">Discover, compare, and review restaurants.</p>
                </div>
            </div>
            <nav aria-label="Primary">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if (is_logged_in()): ?>
                        <?php if (is_admin()): ?><li><a href="add-restaurant.php">Add Restaurant</a></li><?php endif; ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">

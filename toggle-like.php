<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = (int)($_POST['review_id'] ?? 0);
    $restaurant_id = (int)($_POST['restaurant_id'] ?? 0);
    $user = current_user();

    $stmt = $pdo->prepare("SELECT user_id FROM reviews WHERE id = ?");
    $stmt->execute([$review_id]);
    $review = $stmt->fetch();

    if (!$review || (int)$review['user_id'] === (int)$user['id']) {
        header("Location: restaurant-details.php?id=" . urlencode($restaurant_id));
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM review_likes WHERE review_id = ? AND user_id = ?");
    $stmt->execute([$review_id, $user['id']]);
    $like = $stmt->fetch();

    if ($like) {
        $stmt = $pdo->prepare("DELETE FROM review_likes WHERE id = ?");
        $stmt->execute([$like['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO review_likes (review_id, user_id) VALUES (?, ?)");
        $stmt->execute([$review_id, $user['id']]);
    }

    header("Location: restaurant-details.php?id=" . urlencode($restaurant_id));
    exit;
}

header("Location: index.php");
exit;

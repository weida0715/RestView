<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'] ?? null;
    $restaurant_id = $_POST['restaurant_id'] ?? null; // To redirect back to the restaurant details page

    if ($review_id && $restaurant_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
            $stmt->execute([$review_id]);

            // Redirect back to the restaurant details page with a success message
            header("Location: restaurant-details.php?id=" . urlencode($restaurant_id) . "&status=review_deleted");
            exit;
        } catch (PDOException $e) {
            // Redirect back with an error message
            header("Location: restaurant-details.php?id=" . urlencode($restaurant_id) . "&status=delete_error&message=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        // Redirect if parameters are missing
        header("Location: index.php?status=error&message=" . urlencode("Invalid request for review deletion."));
        exit;
    }
} else {
    // If not a POST request, redirect to homepage or show an error
    header("Location: index.php?status=error&message=" . urlencode("Invalid request method."));
    exit;
}
?>
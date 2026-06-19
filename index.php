<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

$search_term = $_GET['search'] ?? '';
$cuisine_filter = $_GET['cuisine'] ?? '';
$sort_by = $_GET['sort'] ?? '';

// Fetch distinct cuisine types for the filter dropdown
$cuisine_types = [];
try {
    $stmt = $pdo->query("SELECT DISTINCT cuisine_type FROM restaurants ORDER BY cuisine_type");
    $cuisine_types = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Log error or display a user-friendly message
    echo "<p class=\"error-message\">Error fetching cuisine types.</p>";
}

$sql = "SELECT r.*, AVG(rev.rating) AS average_rating
        FROM restaurants r
        LEFT JOIN reviews rev ON r.id = rev.restaurant_id
        WHERE 1=1";
$params = [];

if (!empty($search_term)) {
    $sql .= " AND r.name LIKE ?";
    $params[] = '%' . $search_term . '%';
}

if (!empty($cuisine_filter)) {
    $sql .= " AND r.cuisine_type = ?";
    $params[] = $cuisine_filter;
}

$sql .= " GROUP BY r.id";

if ($sort_by === 'name_asc') {
    $sql .= " ORDER BY r.name ASC";
} elseif ($sort_by === 'name_desc') {
    $sql .= " ORDER BY r.name DESC";
} elseif ($sort_by === 'rating_desc') {
    $sql .= " ORDER BY average_rating DESC";
} elseif ($sort_by === 'rating_asc') {
    $sql .= " ORDER BY average_rating ASC";
} else {
    $sql .= " ORDER BY r.name ASC"; // Default sort
}

$restaurants = [];
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $restaurants = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<p class=\"error-message\">Error fetching restaurants: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<section class="hero-panel">
    <div class="hero-copy">
        <p class="eyebrow">Discover your next culinary adventure</p>
        <h2>Explore Top-Rated Restaurants Near You</h2>
        <p>Find the perfect spot for any craving with our curated selection of eateries.</p>
    </div>
    <div class="hero-search-form">
        <form action="index.php" method="GET" class="search-form">
            <div class="field-group field-search">
                <label for="search" class="sr-only">Search</label>
                <input type="text" id="search" name="search" placeholder="Search by restaurant name..." value="<?= htmlspecialchars($search_term) ?>">
            </div>

            <div class="field-group">
                <label for="cuisine" class="sr-only">Cuisine</label>
                <select name="cuisine" id="cuisine">
                    <option value="">All Cuisines</option>
                    <?php foreach ($cuisine_types as $cuisine): ?>
                        <option value="<?= htmlspecialchars($cuisine) ?>" <?= ($cuisine_filter === $cuisine) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cuisine) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-group">
                <label for="sort" class="sr-only">Sort</label>
                <select name="sort" id="sort">
                    <option value="">Sort By</option>
                    <option value="name_asc" <?= ($sort_by === 'name_asc') ? 'selected' : '' ?>>Name (A-Z)</option>
                    <option value="name_desc" <?= ($sort_by === 'name_desc') ? 'selected' : '' ?>>Name (Z-A)</option>
                    <option value="rating_desc" <?= ($sort_by === 'rating_desc') ? 'selected' : '' ?>>Rating (High to Low)</option>
                    <option value="rating_asc" <?= ($sort_by === 'rating_asc') ? 'selected' : '' ?>>Rating (Low to High)</option>
                </select>
            </div>

            <button type="submit" class="button-primary">Search</button>
        </form>
    </div>
</section>

<section class="listings-section">
    <div class="section-heading">
        <h2>Restaurant Listings</h2>
        <p>Browse the current collection and open a restaurant for full details and reviews.</p>
    </div>

    <div class="restaurant-list">
    <?php if (count($restaurants) > 0): ?>
        <?php foreach ($restaurants as $restaurant): ?>
            <a href="restaurant-details.php?id=<?= htmlspecialchars($restaurant['id']) ?>" class="restaurant-card">
                <div class="restaurant-card-media">
                    <img src="assets/images/<?= htmlspecialchars($restaurant['image'] ?? 'modern-dark-placeholder.jpg') ?>" alt="<?= htmlspecialchars($restaurant['name']) ?>">
                </div>
                <div class="restaurant-card-content">
                    <div class="card-topline">
                        <h3><?= htmlspecialchars($restaurant['name']) ?></h3>
                        <?php if ($restaurant['average_rating']): ?>
                            <span class="rating-pill"><?= htmlspecialchars(number_format($restaurant['average_rating'], 1)) ?> &#9733;</span>
                        <?php else: ?>
                            <span class="rating-pill muted">No reviews</span>
                        <?php endif; ?>
                    </div>
                    <p class="meta-line"><strong>Cuisine:</strong> <?= htmlspecialchars($restaurant['cuisine_type']) ?></p>
                    <p class="meta-line"><strong>Location:</strong> <?= htmlspecialchars($restaurant['location']) ?></p>
                    <p><?= htmlspecialchars(substr($restaurant['description'], 0, 100)) ?>...</p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No restaurants found.</p>
    <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

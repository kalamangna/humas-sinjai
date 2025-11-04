<?php
// --- Parameters ---
// Get the 'limit' parameter from the URL, defaulting to 5 if not set.
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
// Get the 'theme' parameter, defaulting to light theme.
$theme = isset($_GET['theme']) && $_GET['theme'] === 'dark' ? 'theme-dark' : 'theme-light';

// --- Data Fetching ---
// Determine the full URL to the feed.php script.
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
$feedUrl = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/feed.php';

// Fetch the JSON data from our feed script.
$json_data = @file_get_contents($feedUrl);
$items = $json_data ? json_decode($json_data, true) : [];

// --- Data Processing ---
// If the feed data is valid, slice the array to the specified limit.
if (!empty($items) && is_array($items) && !isset($items['error'])) {
    $items = array_slice($items, 0, $limit);
} else {
    // If the feed fails or is empty, ensure $items is an empty array.
    $items = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terbaru - Humas Sinjai</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?= htmlspecialchars($theme, ENT_QUOTES, 'UTF-8') ?>">

    <div class="rss-widget">
        <header class="widget-header">
            <h1 class="widget-title">Berita Terbaru - Humas Sinjai</h1>
        </header>

        <main class="widget-body">
            <?php if (!empty($items)): ?>
                <ul class="widget-list">
                    <?php foreach ($items as $item): ?>
                        <li class="widget-list-item">
                            <a href="<?= htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8') ?>" class="widget-link" target="_blank" rel="noopener noreferrer">
                                <?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                            <div class="widget-date"><?= htmlspecialchars($item['date'], ENT_QUOTES, 'UTF-8') ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p style="text-align: center; padding: 2rem 1rem;">Gagal memuat berita atau tidak ada berita yang tersedia saat ini.</p>
            <?php endif; ?>
        </main>

        <footer class="widget-footer">
            <a href="https://humas.sinjaikab.go.id" class="footer-link" target="_blank" rel="noopener noreferrer">
                Humas Sinjai
            </a>
        </footer>
    </div>

</body>
</html>

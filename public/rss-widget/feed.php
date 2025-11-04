<?php
// Set headers for JSON output and cross-origin access
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// --- Configuration ---
// Define the RSS feed URL. We build it dynamically based on the server host.
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$rssUrl = $protocol . $host . '/rss';

// --- Fetch and Parse ---
// Suppress warnings from invalid XML, we will handle errors manually.
libxml_use_internal_errors(true);
$xml = @simplexml_load_file($rssUrl);

if ($xml === false) {
    // If the feed fails to load, return a JSON error.
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load or parse the RSS feed from ' . $rssUrl]);
    exit;
}

// --- Process Feed Items ---
$items = [];
if (isset($xml->channel->item)) {
    foreach ($xml->channel->item as $item) {
        try {
            // Create a DateTime object for formatting.
            $pubDate = new DateTime((string)$item->pubDate);
            $formattedDate = $pubDate->format('D, d M Y');
        } catch (Exception $e) {
            // Fallback for invalid date formats.
            $formattedDate = date('D, d M Y');
        }

        $items[] = [
            'title' => (string)$item->title,
            'link' => (string)$item->link,
            'date' => $formattedDate,
            'description' => (string)$item->description,
        ];
    }
}

// --- Output JSON ---
echo json_encode($items);

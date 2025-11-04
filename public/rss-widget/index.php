<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *'); // penting untuk cross-domain

$rss_url = 'https://humas.sinjaikab.go.id/v1/rss'; // URL RSS kamu

function load_rss($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $data = curl_exec($ch);
    curl_close($ch);
    return simplexml_load_string($data);
}

$rss = load_rss($rss_url);

if (!$rss) {
    echo json_encode(['error' => 'Failed to load RSS feed']);
    exit;
}

$items = [];
foreach ($rss->channel->item as $item) {
    $items[] = [
        'title' => (string) $item->title,
        'link' => (string) $item->link,
        'pubDate' => date('d M Y', strtotime((string) $item->pubDate))
    ];
}

echo json_encode($items);

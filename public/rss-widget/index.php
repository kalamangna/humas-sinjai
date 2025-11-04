<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

$rss_url = 'https://humas.sinjaikab.go.id/v1/rss';

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
    echo json_encode(['error' => 'Gagal memuat RSS']);
    exit;
}

$items = [];
foreach ($rss->channel->item as $item) {
    // Ambil thumbnail jika ada
    $thumbnail = '';
    if (isset($item->enclosure['url'])) {
        $thumbnail = (string)$item->enclosure['url'];
    } elseif (isset($item->children('media', true)->thumbnail)) {
        $thumbnail = (string)$item->children('media', true)->thumbnail->attributes()->url;
    }

    $items[] = [
        'title' => (string)$item->title,
        'link' => (string)$item->link,
        'pubDate' => date('d M Y', strtotime((string)$item->pubDate)),
        'thumbnail' => $thumbnail
    ];
}

echo json_encode($items);

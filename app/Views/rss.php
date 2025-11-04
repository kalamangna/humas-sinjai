<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<rss version="2.0">
    <channel>
        <title>Humas Sinjai</title>
        <link><?= base_url() ?></link>
        <description>Berita Terbaru - Humas Sinjai</description>
        <language>id-id</language>
        <pubDate><?= date('r', strtotime($posts[0]['published_at'] ?? 'now')) ?></pubDate>
        <lastBuildDate><?= date('r', strtotime($posts[0]['published_at'] ?? 'now')) ?></lastBuildDate>
        <ttl>60</ttl>

        <?php foreach ($posts as $post) : ?>
            <item>
                <title><?= esc($post['title']) ?></title>
                <link><?= base_url('post/' . $post['slug']) ?></link>
                <description><?= esc(substr(strip_tags($post['content']), 0, 200)) ?>...</description>
                <pubDate><?= date('r', strtotime($post['published_at'])) ?></pubDate>
                <?php if (!empty($post['thumbnail'])): ?>
                    <enclosure url="<?= htmlspecialchars($post['thumbnail']) ?>" type="image/webp" />
                <?php endif; ?>
                <guid><?= base_url('post/' . $post['slug']) ?></guid>
            </item>
        <?php endforeach; ?>
    </channel>
</rss>
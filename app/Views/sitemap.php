<?= '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url() ?></loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <?php foreach ($posts as $post) : ?>
        <url>
            <loc><?= base_url('post/' . $post['slug']) ?></loc>
            <lastmod><?= date('Y-m-d', strtotime($post['updated_at'])) ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>
    <?php foreach ($categories as $category) : ?>
        <url>
            <loc><?= base_url('category/' . $category['slug']) ?></loc>
            <lastmod><?= date('Y-m-d') ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    <?php endforeach; ?>
    <?php foreach ($tags as $tag) : ?>
        <url>
            <loc><?= base_url('tag/' . $tag['slug']) ?></loc>
            <lastmod><?= date('Y-m-d') ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.4</priority>
        </url>
    <?php endforeach; ?>
</urlset>
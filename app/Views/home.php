<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-primary-gradient text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center g-3">
            <!-- Text Content -->
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-4 fw-bold mb-2">Humas Sinjai</h1>
                <div class="mb-4">
                    <p class="lead fs-4 mb-2">Portal Berita Resmi <span class="d-block d-md-inline">Pemerintah Kabupaten Sinjai</span></p>
                    <span class="badge bg-light text-primary fs-6 px-3 py-2 border-0">
                        <i class="fas fa-hashtag me-1"></i>samasamaki
                    </span>
                </div>
            </div>

            <!-- Banner Image -->
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('banner.png') ?>" alt="Humas Sinjai - Portal Berita Resmi Kabupaten Sinjai"
                    class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Featured Posts -->
<section class="mb-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold border-bottom pb-2">Berita Terbaru</h2>
            </div>
        </div>

        <?php if (!empty($posts)): ?>
            <div class="row g-3">
                <?php foreach ($posts as $index => $post): ?>
                    <?php if ($index < 6): // Tampilkan 6 post pertama 
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm border-0">
                                <?php if (!empty($post['thumbnail'])): ?>
                                    <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-newspaper text-white fa-3x"></i>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">
                                        <a href="<?= base_url('post/' . esc($post['slug'])) ?>" class="text-decoration-none text-dark">
                                            <?= esc($post['title']) ?>
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        <?= word_limiter(strip_tags($post['content']), 20) ?>
                                    </p>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center text-muted small">
                                            <span>
                                                <i class="fas fa-calendar me-1"></i>
                                                <?php
                                                // Use published_at as primary date, fallback to created_at
                                                $dateField = '';
                                                if (isset($post['published_at']) && !empty($post['published_at'])) {
                                                    $dateField = $post['published_at'];
                                                } elseif (isset($post['created_at']) && !empty($post['created_at'])) {
                                                    $dateField = $post['created_at'];
                                                } else {
                                                    $dateField = date('Y-m-d'); // fallback to current date
                                                }
                                                echo format_date($dateField, 'date_only');
                                                ?>
                                            </span>
                                            <span>
                                                <i class="fas fa-user me-1"></i>
                                                <?= esc($post['author_name'] ?? 'Admin') ?>
                                            </span>
                                        </div>

                                        <?php if (!empty($post['categories'])) : ?>
                                            <div class="mt-2">
                                                <?php foreach ($post['categories'] as $category) : ?>
                                                    <a href="<?= base_url('category/' . esc($category['slug'])) ?>" class="badge bg-primary text-decoration-none me-1">
                                                        <?= esc($category['name']) ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- View All Button -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="<?= base_url('posts') ?>" class="btn btn-outline-primary btn-lg px-5">
                        <i class="fas fa-list me-2"></i>Lihat Semua Berita
                    </a>
                </div>
            </div>

        <?php else: ?>
            <div class="row">
                <div class="col-12 text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada berita</h4>
                    <p class="text-muted">Silakan kembali lagi nanti untuk melihat berita terbaru.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
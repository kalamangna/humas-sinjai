<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="mb-5">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <?php if (!empty($slides)): ?>
            <div class="carousel-indicators">
                <?php foreach ($slides as $index => $slide): ?>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-inner">
                <?php foreach ($slides as $index => $slide): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= base_url(esc($slide['image_path'])) ?>" class="d-block w-100" alt="Carousel Slide" style="max-height: 400px; object-fit: cover;">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        <?php endif; ?>
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
                                <a href="<?= base_url('post/' . esc($post['slug'])) ?>">
                                    <?php if (!empty($post['thumbnail'])) : ?>
                                        <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 200px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fas fa-newspaper text-white fa-3x"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>

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
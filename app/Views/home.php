<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Carousel Section -->
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
                        <img src="<?= esc($slide['image_path']) ?>" class="d-block w-100" alt="Carousel Slide" style="max-height: 500px; object-fit: cover;">
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
<section class="py-4 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold display-5 mb-3">
                    <i class="fas fa-newspaper text-primary me-3"></i>Berita Terbaru
                </h2>
                <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
            </div>
        </div>

        <!-- Posts Grid -->
        <?php if (!empty($posts)): ?>
            <div class="row g-4">
                <?php foreach ($posts as $index => $post): ?>
                    <?php if ($index < 6): // Tampilkan 6 post pertama 
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
                                <div class="position-relative">
                                    <a href="<?= base_url('post/' . esc($post['slug'])) ?>">
                                        <?php if (!empty($post['thumbnail'])) : ?>
                                            <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 220px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 220px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                                                <i class="fas fa-newspaper text-white fa-4x"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>

                                    <!-- Category Badge -->
                                    <?php if (!empty($post['categories'])) : ?>
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <?php foreach ($post['categories'] as $category) : ?>
                                                <a href="<?= base_url('category/' . esc($category['slug'])) ?>" class="badge bg-primary text-decoration-none me-1 shadow-sm">
                                                    <?= esc($category['name']) ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold mb-3">
                                        <a href="<?= base_url('post/' . esc($post['slug'])) ?>" class="text-decoration-none text-dark stretched-link">
                                            <?= esc($post['title']) ?>
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1 mb-4">
                                        <?= word_limiter(strip_tags($post['content']), 20) ?>
                                    </p>

                                    <div class="mt-auto pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center text-muted small">
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt me-2"></i>
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
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-user-edit me-2"></i>
                                                <?= esc($post['author_name'] ?? 'Admin') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- View All Button -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="<?= base_url('posts') ?>" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm">
                        <i class="fas fa-list me-2"></i>Lihat Semua Berita
                    </a>
                </div>
            </div>

        <?php else: ?>
            <!-- Empty State -->
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    </div>
                    <h3 class="text-muted mb-3">Belum ada berita</h3>
                    <p class="text-muted mb-4">Silakan kembali lagi nanti untuk melihat berita terbaru.</p>
                    <a href="<?= base_url() ?>" class="btn btn-outline-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Kategori Populer -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">
            <i class="fas fa-tags text-primary me-2"></i>Kategori Populer
        </h2>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <?php if (!empty($popular_categories)): ?>
                <?php foreach ($popular_categories as $category): ?>
                    <a href="<?= base_url('category/' . esc($category['slug'])) ?>"
                        class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                        <?= esc($category['name']) ?> <span class="badge bg-primary ms-2"><?= esc($category['post_count']) ?></span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada kategori populer untuk saat ini.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Program Prioritas -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h2 class="fw-bold display-6 mb-3">
                    <i class="fas fa-bullseye text-primary me-3"></i>Program Prioritas
                </h2>
                <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
            </div>
        </div>

        <?php if (!empty($priority_posts)): ?>
            <div class="row g-4">
                <?php foreach ($priority_posts as $post): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
                            <div class="position-relative">
                                <a href="<?= base_url('post/' . esc($post['slug'])) ?>">
                                    <?php if (!empty($post['thumbnail'])) : ?>
                                        <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 220px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 220px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                                            <i class="fas fa-newspaper text-white fa-4x"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>

                                <!-- Category Badge -->
                                <?php if (!empty($post['categories'])) : ?>
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <?php foreach ($post['categories'] as $category) : ?>
                                            <a href="<?= base_url('category/' . esc($category['slug'])) ?>" class="badge bg-primary text-decoration-none me-1 shadow-sm">
                                                <?= esc($category['name']) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold mb-3">
                                    <a href="<?= base_url('post/' . esc($post['slug'])) ?>" class="text-decoration-none text-dark stretched-link">
                                        <?= esc($post['title']) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted flex-grow-1 mb-4">
                                    <?= word_limiter(strip_tags($post['content']), 20) ?>
                                </p>

                                <div class="mt-auto pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center text-muted small">
                                        <span class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            <?php
                                            $dateField = '';
                                            if (isset($post['published_at']) && !empty($post['published_at'])) {
                                                $dateField = $post['published_at'];
                                            } elseif (isset($post['created_at']) && !empty($post['created_at'])) {
                                                $dateField = $post['created_at'];
                                            } else {
                                                $dateField = date('Y-m-d');
                                            }
                                            echo format_date($dateField, 'date_only');
                                            ?>
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <i class="fas fa-user-edit me-2"></i>
                                            <?= esc($post['author_name'] ?? 'Admin') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- View All Button -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="<?= base_url('program-prioritas') ?>" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm">
                        <i class="fas fa-list me-2"></i>Lihat Semua Program
                    </a>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <p>Belum ada program prioritas yang tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<?= $this->endSection() ?>
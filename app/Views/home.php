<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-primary-gradient text-white py-5 mb-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-5 fw-bold mb-3">Humas Sinjai</h1>
                <p class="lead mb-4">Portal Berita Resmi Pemerintah Kabupaten Sinjai <span class="fw-bold">#samasamaki</span></p>
                <a href="<?= base_url('about') ?>" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-info-circle me-2"></i>Selengkapnya
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('logo.png') ?>" alt="Logo Kabupaten Sinjai" class="img-fluid" style="max-width: 300px;">
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
                        <div class="col-lg-4 col-md-6 mb-4">
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
                                        <?php
                                        // Handle content truncation safely
                                        $content = strip_tags($post['content'] ?? '');
                                        if (strlen($content) > 120) {
                                            echo esc(substr($content, 0, 120)) . '...';
                                        } else {
                                            echo esc($content);
                                        }
                                        ?>
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
                                                echo date('d M Y', strtotime($dateField));
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

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold">Informasi Humas Sinjai</h2>
                <p class="lead text-muted">Layanan informasi publik Kabupaten Sinjai</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-newspaper text-white fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">Berita Terkini</h4>
                    <p class="text-muted">Informasi terbaru seputar kegiatan dan perkembangan di Kabupaten Sinjai</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-bullhorn text-white fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">Pengumuman</h4>
                    <p class="text-muted">Pengumuman resmi dari Pemerintah Kabupaten Sinjai untuk masyarakat</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-images text-white fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">Galeri Kegiatan</h4>
                    <p class="text-muted">Dokumentasi visual berbagai kegiatan dan program pemerintah</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="py-4 bg-white">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-md-3 col-6 mb-3">
                <div class="border-end border-2">
                    <h3 class="fw-bold text-primary mb-1"><?= !empty($posts) ? count($posts) : 0 ?></h3>
                    <p class="text-muted small">Total Berita</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="border-end border-2">
                    <h3 class="fw-bold text-primary mb-1"><?= date('Y') - 2020 ?></h3>
                    <p class="text-muted small">Tahun Aktif</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="border-end border-2">
                    <h3 class="fw-bold text-primary mb-1">24/7</h3>
                    <p class="text-muted small">Layanan Informasi</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <h3 class="fw-bold text-primary mb-1">100%</h3>
                <p class="text-muted small">Informasi Terpercaya</p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
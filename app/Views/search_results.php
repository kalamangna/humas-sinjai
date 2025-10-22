<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <nav aria-label="breadcrumb" class="my-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/') ?>" class="text-decoration-none">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
                </ol>
            </nav>

            <h1 class="fw-bold display-5 mb-3">
                <i class="fas fa-search text-primary me-3"></i>Hasil Pencarian
            </h1>
            <p class="lead text-muted">
                <?php if (!empty($query)) : ?>
                    Menampilkan hasil untuk: "<strong><?= esc($query) ?></strong>"
                <?php else : ?>
                    Masukkan kata kunci untuk mencari berita
                <?php endif; ?>
            </p>
            <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
        </div>
    </div>

    <?php if (!empty($posts)) : ?>
        <!-- Search Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-primary border-0 rounded-4 shadow-sm">
                    <i class="fas fa-info-circle me-2"></i>
                    Ditemukan <strong><?= count($posts) ?></strong> berita yang sesuai dengan pencarian "<strong><?= esc($query) ?></strong>"
                </div>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="row g-4">
            <?php foreach ($posts as $post) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <a href="<?= base_url('post/' . esc($post['slug'])) ?>">
                                <?php if (!empty($post['thumbnail'])) : ?>
                                    <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else : ?>
                                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                                        <i class="fas fa-newspaper text-white fa-3x"></i>
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
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager->getPageCount() > 1) : ?>
            <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center justify-content-lg-between mt-5 pt-4">
                <div class="text-muted small mb-2 mb-lg-0">
                    <?php
                    $from = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1;
                    $to = $from + count($posts) - 1;
                    ?>
                    Menampilkan <?= $from ?>-<?= $to ?> dari <?= $pager->getTotal() ?> berita
                </div>
                <div class="d-flex align-items-center">
                    <?= $pager->links('default', 'custom_bootstrap') ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <!-- No Results -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
            </div>
            <h3 class="text-muted mb-3">Tidak ada hasil ditemukan</h3>
            <p class="text-muted mb-4">
                <?php if (!empty($query)) : ?>
                    Tidak ada berita yang sesuai dengan pencarian "<strong><?= esc($query) ?></strong>".
                <?php else : ?>
                    Silakan masukkan kata kunci pencarian.
                <?php endif; ?>
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap mb-5">
                <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                    <i class="fas fa-home me-2"></i>Kembali ke Beranda
                </a>
                <a href="<?= base_url('categories') ?>" class="btn btn-outline-primary btn-lg px-4 rounded-pill shadow-sm">
                    <i class="fas fa-folder me-2"></i>Lihat Semua Kategori
                </a>
                <a href="<?= base_url('tags') ?>" class="btn btn-outline-primary btn-lg px-4 rounded-pill shadow-sm">
                    <i class="fas fa-tags me-2"></i>Lihat Semua Tag
                </a>
            </div>

            <!-- Search Tips -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow rounded-4 bg-light">
                        <div class="card-body p-5">
                            <h6 class="fw-bold mb-4 text-dark text-center">
                                <i class="fas fa-lightbulb text-primary me-2"></i>Tips Pencarian:
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-check text-primary me-3 fa-lg"></i>
                                        <span>Gunakan kata kunci yang lebih umum</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-check text-primary me-3 fa-lg"></i>
                                        <span>Coba kata kunci yang berbeda</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-check text-primary me-3 fa-lg"></i>
                                        <span>Periksa ejaan kata kunci</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-check text-primary me-3 fa-lg"></i>
                                        <span>Jelajahi kategori atau tag terkait</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
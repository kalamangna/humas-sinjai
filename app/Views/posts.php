<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold display-5 mb-3">
                <i class="fas fa-newspaper text-primary me-3"></i><?= esc($title) ?>
            </h1>
            <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
        </div>
    </div>

    <?php if (!empty($posts)) : ?>
        <div class="row g-4">
            <?php foreach ($posts as $post) : ?>
                <div class="col-md-6">
                    <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <a href="<?= base_url('post/' . esc($post['slug'])) ?>">
                                <?php if (!empty($post['thumbnail'])) : ?>
                                    <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 250px; object-fit: cover;">
                                <?php else : ?>
                                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 250px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
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
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            </div>
            <h3 class="text-muted mb-3">Belum ada berita</h3>
            <p class="text-muted mb-4">Tidak ada berita yang ditemukan.</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>
    <?php endif; ?>
</div>


<?= $this->endSection() ?>
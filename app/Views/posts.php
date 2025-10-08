<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1 class="my-4 fw-bold border-bottom pb-2"><?= esc($title) ?></h1>

    <?php if (!empty($posts)) : ?>
        <div class="row g-3">
            <?php foreach ($posts as $post) : ?>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if (!empty($post['thumbnail'])) : ?>
                            <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 250px; object-fit: cover;">
                        <?php else : ?>
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
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager->getPageCount() > 1) : ?>
            <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center justify-content-lg-between mt-5">
                <div class="text-muted small mb-2 mb-lg-0">
                    <?php
                    $from = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1;
                    $to = $from + count($posts) - 1;
                    ?>
                    Menampilkan <?= $from ?>-<?= $to ?> dari <?= $pager->getTotal() ?> berita
                </div>
                <div class="d-flex align-items-text-center">
                    <?= $pager->links('default', 'custom_bootstrap') ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada berita</h4>
            <p class="text-muted">Tidak ada berita yang ditemukan.</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
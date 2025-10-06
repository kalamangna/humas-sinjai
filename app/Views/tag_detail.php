<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="my-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('tags') ?>" class="text-decoration-none">Tag</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= esc($tag['name'] ?? 'Tag') ?></li>
                </ol>
            </nav>
            <h1 class="fw-bold border-bottom pb-2">Tag: <?= esc($tag['name'] ?? '') ?></h1>
            <?php if (!empty($tag['description'])) : ?>
                <p class="lead text-muted"><?= esc($tag['description']) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Posts Grid -->
    <?php if (!empty($posts)) : ?>
        <div class="row g-3">
            <?php foreach ($posts as $post) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if (!empty($post['thumbnail'])) : ?>
                            <img src="<?= esc($post['thumbnail']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 200px; object-fit: cover;">
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
                                <?php
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
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="fas fa-tag fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada berita</h4>
            <p class="text-muted">Tidak ada berita dengan tag <?= esc($tag['name'] ?? 'ini') ?>.</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="my-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
                </ol>
            </nav>
            <h1 class="fw-bold border-bottom pb-2">Hasil Pencarian</h1>
            <p class="lead text-muted">
                <?php if (!empty($query)) : ?>
                    Menampilkan hasil untuk: "<strong><?= esc($query) ?></strong>"
                <?php else : ?>
                    Masukkan kata kunci untuk mencari berita
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if (!empty($posts)) : ?>
        <!-- Search Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-primary border-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Ditemukan <strong><?= count($posts) ?></strong> berita yang sesuai dengan pencarian "<strong><?= esc($query) ?></strong>"
                </div>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="row g-3">
            <?php foreach ($posts as $post) : ?>
                <div class="col-lg-4 col-md-6">
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
        <!-- No Results -->
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Tidak ada hasil ditemukan</h4>
            <p class="text-muted mb-4">
                <?php if (!empty($query)) : ?>
                    Tidak ada berita yang sesuai dengan pencarian "<strong><?= esc($query) ?></strong>".
                <?php else : ?>
                    Silakan masukkan kata kunci pencarian.
                <?php endif; ?>
            </p>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <a href="<?= base_url('/') ?>" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Kembali ke Beranda
                </a>
                <a href="<?= base_url('categories') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-folder me-2"></i>Lihat Semua Kategori
                </a>
                <a href="<?= base_url('tags') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-tags me-2"></i>Lihat Semua Tag
                </a>
            </div>

            <!-- Search Tips -->
            <div class="mt-5">
                <div class="card border-0 bg-light">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-dark">
                            <i class="fas fa-lightbulb me-2"></i>Tips Pencarian:
                        </h6>
                        <ul class="list-unstyled text-muted mb-0">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Gunakan kata kunci yang lebih umum</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Coba kata kunci yang berbeda</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Periksa ejaan kata kunci</li>
                            <li class="mb-0"><i class="fas fa-check text-primary me-2"></i>Jelajahi kategori atau tag untuk menemukan berita terkait</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold display-5 mb-3">
                <i class="fas fa-tags text-primary me-3"></i><?= esc($title) ?>
            </h1>
            <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
        </div>
    </div>

    <?php if (!empty($tags)) : ?>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?= base_url('tag/' . esc($tag['slug'])) ?>"
                                    class="btn btn-lg btn-outline-primary d-flex align-items-center rounded-pill shadow-sm px-4 py-2">
                                    <i class="fas fa-tag me-2"></i>
                                    <?= esc($tag['name']) ?>
                                    <span class="badge bg-primary ms-2 rounded-pill"><?= $tag['post_count'] ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            </div>
            <h3 class="text-muted mb-3">Belum ada tag</h3>
            <p class="text-muted mb-4">Tidak ada tag yang ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
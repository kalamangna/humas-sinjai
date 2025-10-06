<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1 class="my-4 fw-bold border-bottom pb-2"><?= esc($title) ?></h1>

    <?php if (!empty($tags)) : ?>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($tags as $tag) : ?>
                <a href="<?= base_url('tag/' . esc($tag['slug'])) ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                    <i class="fas fa-tag me-1"></i>
                    <?= esc($tag['name']) ?>
                    <span class="badge bg-secondary ms-2"><?= $tag['post_count'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada tag</h4>
            <p class="text-muted">Tidak ada tag yang ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
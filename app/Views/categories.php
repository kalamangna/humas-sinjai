<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1 class="my-4 fw-bold border-bottom pb-2"><?= esc($title) ?></h1>

    <?php if (!empty($categories)) : ?>
        <div class="list-group shadow-sm">
            <?php foreach ($categories as $category) : ?>
                <a href="<?= base_url('category/' . esc($category['slug'])) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-folder-open me-2 text-primary"></i>
                        <?= esc($category['name']) ?>
                    </span>
                    <span class="badge bg-primary rounded-pill"><?= $category['post_count'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada kategori</h4>
            <p class="text-muted">Tidak ada kategori yang ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
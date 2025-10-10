<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1 class="my-4 fw-bold border-bottom pb-2"><?= esc($title) ?></h1>

    <?php if (!empty($categories)) : ?>
        <ul class="list-group shadow-sm">
            <?php foreach ($categories as $category) : ?>
                <li class="list-group-item">
                    <i class="fas fa-folder-open me-2 text-primary"></i>
                    <span class="fw-bold"><?= esc($category['name']) ?></span>

                    <?php if (isset($subCategories[$category['id']])) : ?>
                        <ul class="list-group mt-2">
                            <?php foreach ($subCategories[$category['id']] as $subCategory) : ?>
                                <a href="<?= base_url('category/' . esc($subCategory['slug'])) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 ps-4">
                                    <span>
                                        <i class="fas fa-folder me-2 text-secondary"></i>
                                        <?= esc($subCategory['name']) ?>
                                    </span>
                                    <span class="badge bg-secondary rounded-pill"><?= $subCategory['post_count'] ?></span>
                                </a>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada kategori</h4>
            <p class="text-muted">Tidak ada kategori yang ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
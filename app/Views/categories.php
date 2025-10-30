<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <i class="fas fa-home me-2"></i>Beranda
                </a></li>
            <li class="breadcrumb-item active" aria-current="page">Semua Kategori</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold display-5 mb-3">
                <i class="fas fa-folder-tree text-primary me-3"></i><?= esc($title) ?>
            </h1>
            <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
        </div>
    </div>

    <?php if (!empty($categories)) : ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($categories as $category) : ?>
                                <div class="list-group-item border-0 p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-folder-open text-primary fa-lg me-3"></i>
                                        <span class="fw-bold fs-5 text-dark"><?= esc($category['name']) ?></span>
                                    </div>

                                    <?php if (isset($subCategories[$category['id']])) : ?>
                                        <div class="row g-2 ps-4">
                                            <?php foreach ($subCategories[$category['id']] as $subCategory) : ?>
                                                <div class="col-12 col-md-6">
                                                    <a href="<?= base_url('category/' . esc($subCategory['slug'])) ?>"
                                                        class="card border-0 shadow-sm rounded-3 text-decoration-none text-dark h-100">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-folder text-secondary me-2"></i>
                                                                    <span class="fw-medium"><?= esc($subCategory['name']) ?></span>
                                                                </div>
                                                                <span class="badge bg-primary rounded-pill shadow-sm"><?= $subCategory['post_count'] ?></span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($category !== end($categories)) : ?>
                                    <hr class="my-0">
                                <?php endif; ?>
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
            <h3 class="text-muted mb-3">Belum ada kategori</h3>
            <p class="text-muted mb-4">Tidak ada kategori yang ditemukan.</p>
        </div>
    <?php endif; ?>
</div>


<?= $this->endSection() ?>
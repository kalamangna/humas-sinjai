<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none"><i class="fas fa-home me-2"></i>Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($title) ?></li>
        </ol>
    </nav>

    <?php if (!empty($profile)) : ?>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm overflow-hidden rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <div class="text-center mb-5">
                            <?php if (!empty($profile['image'])) : ?>
                                <img src="<?= esc($profile['image']) ?>" alt="<?= esc($profile['name']) ?>" class="img-fluid rounded-circle shadow mb-4" style="width: 200px; height: 200px; object-fit: cover; border: 5px solid #fff;">
                            <?php else : ?>
                                <div class="bg-light rounded-circle shadow mb-4 d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px;">
                                    <i class="fas fa-user fa-5x text-secondary"></i>
                                </div>
                            <?php endif; ?>
                            
                            <h2 class="fw-bold mb-1"><?= $profile['name'] ? esc($profile['name']) : esc($profile['position']) ?></h2>
                            <?php if ($profile['name']): ?>
                                <p class="text-muted fs-5 mb-0"><?= esc($profile['position']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($profile['institution'])) : ?>
                                <p class="text-primary fw-semibold mb-0"><?= esc($profile['institution']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="profile-content mt-4">
                            <h4 class="fw-bold mb-3 border-bottom pb-2"><i class="fas fa-info-circle me-2 text-primary"></i>Biografi</h4>
                            <div class="profile-bio lh-lg">
                                <?= $profile['bio'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="text-center py-5">
            <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">Profil Belum Tersedia</h3>
            <p class="text-muted">Informasi untuk profil ini belum ditambahkan.</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Kembali ke Beranda</a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

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
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm overflow-hidden rounded-4">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-4 bg-light text-center p-4 d-flex flex-column align-items-center justify-content-center">
                                <?php if (!empty($profile['image'])) : ?>
                                    <img src="<?= esc($profile['image']) ?>" alt="<?= esc($profile['name']) ?>" class="img-fluid rounded-circle shadow mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                                <?php else : ?>
                                    <div class="bg-white rounded-circle shadow mb-3 d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                                        <i class="fas fa-user fa-5x text-secondary"></i>
                                    </div>
                                <?php endif; ?>
                                <h4 class="fw-bold mb-1"><?= esc($profile['name']) ?></h4>
                                <p class="text-muted mb-0"><?= esc($profile['position']) ?></p>
                            </div>
                            <div class="col-md-8 p-4 p-lg-5">
                                <h3 class="fw-bold mb-4 border-bottom pb-2">Biografi</h3>
                                <div class="profile-bio">
                                    <?= nl2br(esc($profile['bio'])) ?>
                                </div>
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

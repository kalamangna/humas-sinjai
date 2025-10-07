<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Profil Pengguna<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-4">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fas fa-user-circle me-2 text-primary"></i>Profil Pengguna
                </h4>
                <p class="text-muted mb-0 mt-2">Informasi dasar profil Anda.</p>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap</label>
                            <p class="form-control-plaintext"><?= esc($user['name']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label fw-semibold text-dark">Email</label>
                            <p class="form-control-plaintext"><?= esc($user['email']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role" class="form-label fw-semibold text-dark">Role</label>
                            <p class="form-control-plaintext"><?= esc(ucfirst($user['role'])) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="created_at" class="form-label fw-semibold text-dark">Bergabung Sejak</label>
                            <p class="form-control-plaintext"><?= date('d M Y, H:i', strtotime($user['created_at'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
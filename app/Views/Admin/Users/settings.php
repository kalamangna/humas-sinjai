<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Pengaturan Pengguna<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-4">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fas fa-cog me-2 text-primary"></i>Pengaturan Pengguna
                </h4>
                <p class="text-muted mb-0 mt-2">Kelola pengaturan akun Anda.</p>
            </div>

            <div class="card-body">
                <form action="<?= base_url('admin/users/update_settings') ?>" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" value="<?= esc($user['id']) ?>">

                    <div class="row g-2 g-md-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['name'])) ? 'is-invalid' : '' ?>"
                                    value="<?= old('name', $user['name']) ?>" placeholder="Masukkan nama..." required>
                                <?php if (isset(session('errors')['name'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email" class="form-label fw-semibold text-dark">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['email'])) ? 'is-invalid' : '' ?>"
                                    value="<?= old('email', $user['email']) ?>" placeholder="Masukkan email..." required>
                                <?php if (isset(session('errors')['email'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password" class="form-label fw-semibold text-dark">Password Baru</label>
                                <input type="password" name="password" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['password'])) ? 'is-invalid' : '' ?>" placeholder="Biarkan kosong jika tidak ingin mengubah password.">
                                <?php if (isset(session('errors')['password'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['password'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password_confirm" class="form-label fw-semibold text-dark">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirm" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['password_confirm'])) ? 'is-invalid' : '' ?>" placeholder="Konfirmasi password baru.">
                                <?php if (isset(session('errors')['password_confirm'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['password_confirm'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end border-top pt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/admin_validation_script') ?>

<?= $this->endSection() ?>

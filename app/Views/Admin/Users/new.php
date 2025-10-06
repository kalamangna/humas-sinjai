<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Tambah Pengguna Baru<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-4">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fas fa-user-plus me-2 text-primary"></i>Tambah Pengguna Baru
                </h4>
                <p class="text-muted mb-0 mt-2">Isi form berikut untuk membuat pengguna baru.</p>
            </div>

            <div class="card-body">
                <?= $this->include('layout/admin_errors') ?>

                <form action="<?= base_url('admin/users') ?>" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg border-0 bg-light rounded-3 py-3"
                                    value="<?= old('name') ?>" placeholder="Masukkan nama..." required>
                                <div class="invalid-feedback">Harap masukkan nama.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label fw-semibold text-dark">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg border-0 bg-light rounded-3 py-3"
                                    value="<?= old('email') ?>" placeholder="Masukkan email..." required>
                                <div class="invalid-feedback">Harap masukkan alamat email yang valid.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label fw-semibold text-dark">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control form-control-lg border-0 bg-light rounded-3 py-3" required>
                                <div class="invalid-feedback">Harap masukkan password.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="form-label fw-semibold text-dark">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select form-select-lg border-0 bg-light rounded-3 py-3" required>
                                    <option value="author" <?= old('role') == 'author' ? 'selected' : '' ?>>Author</option>
                                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end border-top pt-4">
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Pengguna
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
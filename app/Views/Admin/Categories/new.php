<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Tambah Kategori Baru<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-4">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Kategori Baru
                </h4>
                <p class="text-muted mb-0 mt-2">Isi form berikut untuk membuat kategori baru.</p>
            </div>

            <div class="card-body">
                <?= $this->include('layout/admin_errors') ?>

                <form action="<?= base_url('admin/categories') ?>" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name" class="form-label fw-semibold text-dark">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg border-0 bg-light rounded-3 py-3"
                                    value="<?= old('name') ?>" placeholder="Masukkan nama kategori..." required>
                                <div class="invalid-feedback">Harap masukkan nama kategori.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end border-top pt-4">
                                <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Kategori
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
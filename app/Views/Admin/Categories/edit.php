<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Edit Kategori<?= $this->endSection() ?>

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
                    <i class="fas fa-edit me-2 text-primary"></i>Edit Kategori
                </h4>
                <p class="text-muted mb-0 mt-2">Perbarui nama kategori.</p>
            </div>

            <div class="card-body">
                <?= $this->include('layout/admin_errors') ?>

                <form action="<?= base_url('admin/categories/' . $category['id']) ?>" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="_method" value="PUT">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label fw-semibold text-dark">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg border-0 bg-light rounded-3 py-3"
                                    value="<?= old('name', $category['name']) ?>" placeholder="Masukkan nama kategori..." required>
                                <div class="invalid-feedback">Harap masukkan nama kategori.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_id" class="form-label fw-semibold text-dark">Parent</label>
                                <select name="parent_id" id="parent_id" class="form-select form-select-lg border-0 bg-light rounded-3 py-3">
                                    <option value="">Tidak ada</option>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= $cat['id'] ?>" <?= old('parent_id', $category['parent_id']) == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                                    <i class="fas fa-save me-2"></i>Perbarui Kategori
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
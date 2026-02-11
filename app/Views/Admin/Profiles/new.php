<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Tambah Profil Baru<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/profiles') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-4">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Profil Baru
                </h4>
                <p class="text-muted mb-0 mt-2">Isi form berikut untuk membuat profil baru</p>
            </div>

            <div class="card-body">
                <form action="<?= base_url('admin/profiles') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <!-- Foto -->
                        <div class="col-12" id="image-container">
                            <div class="form-group">
                                <label for="image" class="form-label fw-semibold text-dark">Foto Profil</label>
                                <div class="input-group">
                                    <input type="file" name="image" id="image" class="form-control <?= (isset(session('errors')['image'])) ? 'is-invalid' : '' ?>" onchange="previewImage('image', 'image-preview')">
                                    <input type="hidden" name="pasted_image" id="pasted_image">
                                    <button type="button" id="paste-image-btn" class="btn btn-outline-secondary">
                                        <i class="fas fa-paste"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Tipe file yang diizinkan: jpg, jpeg, png, webp. Ukuran maksimal: 2MB.</small>
                                <?php if (isset(session('errors')['image'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['image'] ?>
                                    </div>
                                <?php endif; ?>
                                <img id="image-preview" class="img-fluid rounded mt-2 shadow-sm" style="max-height: 200px; display: none;">
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['name'])) ? 'is-invalid' : '' ?>"
                                    value="<?= old('name') ?>" placeholder="Nama Lengkap...">
                                <?php if (isset(session('errors')['name'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Posisi -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position" class="form-label fw-semibold text-dark">Jabatan</label>
                                <input type="text" name="position" id="position" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['position'])) ? 'is-invalid' : '' ?>"
                                    value="<?= old('position') ?>" placeholder="Contoh: Bupati Sinjai, Anggota DPRD...">
                                <?php if (isset(session('errors')['position'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['position'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Institusi -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="institution" class="form-label fw-semibold text-dark">Instansi</label>
                                <input type="text" name="institution" id="institution" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['institution'])) ? 'is-invalid' : '' ?>"
                                    value="<?= old('institution') ?>" placeholder="Contoh: Polres Sinjai, Kejari Sinjai...">
                                <?php if (isset(session('errors')['institution'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['institution'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Tipe -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-label fw-semibold text-dark">Tipe Profil <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select form-select-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['type'])) ? 'is-invalid' : '' ?>">
                                    <option value="" disabled selected>Pilih Tipe...</option>
                                    <option value="bupati" <?= old('type') == 'bupati' ? 'selected' : '' ?>>Bupati</option>
                                    <option value="wakil-bupati" <?= old('type') == 'wakil-bupati' ? 'selected' : '' ?>>Wakil Bupati</option>
                                    <option value="sekda" <?= old('type') == 'sekda' ? 'selected' : '' ?>>Sekda</option>
                                    <option value="forkopimda" <?= old('type') == 'forkopimda' ? 'selected' : '' ?>>Forkopimda</option>
                                    <option value="eselon-ii" <?= old('type') == 'eselon-ii' ? 'selected' : '' ?>>Eselon II</option>
                                    <option value="eselon-iii" <?= old('type') == 'eselon-iii' ? 'selected' : '' ?>>Eselon III</option>
                                    <option value="eselon-iv" <?= old('type') == 'eselon-iv' ? 'selected' : '' ?>>Eselon IV</option>
                                    <option value="kepala-desa" <?= old('type') == 'kepala-desa' ? 'selected' : '' ?>>Kepala Desa</option>
                                </select>
                                <?php if (isset(session('errors')['type'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['type'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Urutan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order" class="form-label fw-semibold text-dark">Urutan Tampil</label>
                                <input type="number" name="order" id="order" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['order'])) ? 'is-invalid' : '' ?>"
                                    value="<?= old('order', 0) ?>" placeholder="0">
                                <small class="text-muted">Semakin kecil angka, semakin awal ditampilkan.</small>
                                <?php if (isset(session('errors')['order'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['order'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="col-12" id="bio-container">
                            <div class="form-group">
                                <label for="bio" class="form-label fw-semibold text-dark">Biografi Singkat</label>
                                <textarea name="bio" id="bio" class="form-control border-0 bg-light rounded-3 <?= (isset(session('errors')['bio'])) ? 'is-invalid' : '' ?>" rows="6"
                                    placeholder="Tulis biografi singkat..."><?= old('bio') ?></textarea>
                                <?php if (isset(session('errors')['bio'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['bio'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end border-top pt-4">
                                <a href="<?= base_url('admin/profiles') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const bioContainer = document.getElementById('bio-container');
        const imageContainer = document.getElementById('image-container');

        function toggleFields() {
            const selectedType = typeSelect.value;
            const hideList = ['forkopimda', 'eselon-ii', 'eselon-iii', 'eselon-iv', 'kepala-desa'];

            if (hideList.includes(selectedType)) {
                bioContainer.style.display = 'none';
                imageContainer.style.display = 'none';
            } else {
                bioContainer.style.display = 'block';
                imageContainer.style.display = 'block';
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields(); // Run on load

        const pasteBtn = document.getElementById('paste-image-btn');

        pasteBtn.addEventListener('click', async function() {
            try {
                const clipboardItems = await navigator.clipboard.read();
                for (const item of clipboardItems) {
                    const isJpg = item.types.includes('image/jpeg');
                    const isPng = item.types.includes('image/png');
                    const isWebp = item.types.includes('image/webp');

                    if (isJpg || isPng || isWebp) {
                        const blob = await item.getType(item.types.find(type => type.startsWith('image/')));
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            document.getElementById('pasted_image').value = event.target.result;
                            const preview = document.getElementById('image-preview');
                            preview.src = event.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(blob);
                    }
                }
            } catch (err) {
                console.error('Failed to read clipboard contents: ', err);
                alert('Gagal menempel gambar dari clipboard. Pastikan Anda telah menyalin gambar.');
            }
        });
    });

    function previewImage(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?= $this->endSection() ?>
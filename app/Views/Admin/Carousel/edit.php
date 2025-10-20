<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>
Edit Slide
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/carousel') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-4">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fas fa-edit me-2 text-primary"></i>Edit Slide
                </h4>
                <p class="text-muted mb-0 mt-2">Perbarui informasi slide</p>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/carousel/' . $slide['id']) ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="image" class="form-label fw-semibold text-dark">Gambar</label>
                                <input type="file" class="form-control <?= (isset(session('errors')['image'])) ? 'is-invalid' : '' ?>" id="image" name="image" onchange="previewImage()">
                                <?php if (isset(session('errors')['image'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['image'] ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted">Biarkan kosong untuk mempertahankan gambar saat ini. Tipe file yang diizinkan: jpg, jpeg, png, webp. Ukuran maksimal: 2MB.</small>
                                <img id="image-preview" src="<?= esc($slide['image_path']) ?>" alt="" class="img-fluid rounded mt-2" style="max-height: 200px;">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="slide_order" class="form-label fw-semibold text-dark">Urutan</label>
                                <input type="number" class="form-control <?= (isset(session('errors')['slide_order'])) ? 'is-invalid' : '' ?>" id="slide_order" name="slide_order" value="<?= old('slide_order', $slide['slide_order']) ?>">
                                <?php if (isset(session('errors')['slide_order'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['slide_order'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end border-top pt-4">
                                <a href="<?= base_url('admin/carousel') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Perbarui
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('#image-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
<?= $this->endSection() ?>

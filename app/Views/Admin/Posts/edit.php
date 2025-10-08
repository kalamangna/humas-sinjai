<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Edit Berita<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-4">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fas fa-edit me-2 text-primary"></i>Edit Berita
                </h4>
                <p class="text-muted mb-0 mt-2">Perbarui informasi berita</p>
            </div>

            <div class="card-body">
                <form action="<?= base_url('admin/posts/' . $post['id']) ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <input type="hidden" name="_method" value="PUT">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <!-- Judul -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="form-label fw-semibold text-dark">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control form-control-lg border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['title'])) ? 'is-invalid' : '' ?>"
                                    value="<?= old('title', $post['title']) ?>" placeholder="Masukkan judul berita..." required>
                                <?php if (isset(session('errors')['title'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['title'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Konten -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="content" class="form-label fw-semibold text-dark">Konten <span class="text-danger">*</span></label>
                                <textarea name="content" id="content" class="form-control border-0 bg-light rounded-3 <?= (isset(session('errors')['content'])) ? 'is-invalid' : '' ?>" rows="12"
                                    placeholder="Tulis konten berita di sini..." required><?= old('content', $post['content']) ?></textarea>
                                <?php if (isset(session('errors')['content'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['content'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="thumbnail" class="form-label fw-semibold text-dark">Thumbnail</label>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control <?= (isset(session('errors')['thumbnail'])) ? 'is-invalid' : '' ?>" onchange="previewImage()">
                                <small class="text-muted">Tipe file yang diizinkan: jpg, jpeg, png, webp. Ukuran maksimal: 2MB.</small>
                                <?php if (isset(session('errors')['thumbnail'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['thumbnail'] ?>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <img id="thumbnail-preview" src="<?= !empty($post['thumbnail']) ? $post['thumbnail'] : '' ?>" alt="<?= esc($post['title']) ?>" class="img-fluid rounded mt-2" style="max-height: 200px; <?= !empty($post['thumbnail']) ? '' : 'display: none;' ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Kategori & Tags -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold text-dark">Kategori <span class="text-danger">*</span></label>
                                <div id="category-list" class="checkbox-group-container border-0 bg-light rounded-3 p-3 <?= (isset(session('errors')['categories'])) ? 'is-invalid' : '' ?>" style="max-height: 200px; overflow-y: auto;">
                                    <?php foreach ($categories as $category) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]" value="<?= $category['id'] ?>" id="cat_<?= $category['id'] ?>"
                                                <?= in_array($category['id'], old('categories', $post_categories)) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="cat_<?= $category['id'] ?>">
                                                <?= esc($category['name']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <small class="text-muted">Pilih satu atau lebih kategori.</small>
                                <?php if (isset(session('errors')['categories'])) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session('errors')['categories'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold text-dark">Tags <span class="text-danger">*</span></label>
                                <div id="tag-list" class="checkbox-group-container border-0 bg-light rounded-3 p-3 <?= (isset(session('errors')['tags'])) ? 'is-invalid' : '' ?>" style="max-height: 200px; overflow-y: auto;">
                                    <?php foreach ($tags as $tag) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" id="tag_<?= $tag['id'] ?>"
                                                <?= in_array($tag['id'], old('tags', $post_tags)) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="tag_<?= $tag['id'] ?>">
                                                <?= esc($tag['name']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <small class="text-muted">Pilih satu atau lebih tag.</small>
                                <?php if (isset(session('errors')['tags'])) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session('errors')['tags'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="status" class="form-label fw-semibold text-dark">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select border-0 bg-light rounded-3 py-3 <?= (isset(session('errors')['status'])) ? 'is-invalid' : '' ?>" required>
                                    <option value="published" <?= (old('status', $post['status']) == 'published') ? 'selected' : '' ?>>Published</option>
                                    <option value="draft" <?= (old('status', $post['status']) == 'draft') ? 'selected' : '' ?>>Draft</option>
                                </select>
                                <?php if (isset(session('errors')['status'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors')['status'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end border-top pt-4">
                                <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Perbarui Berita
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
<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Edit Berita<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-12">
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
                                <label for="thumbnail" class="form-label fw-semibold text-dark">Gambar <span class="text-danger">*</span></label>
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

                        <div class="col-12">
                            <div class="form-group">
                                <label for="thumbnail_caption" class="form-label fw-semibold text-dark">Keterangan Gambar</label>
                                <input type="text" name="thumbnail_caption" id="thumbnail_caption" class="form-control" value="<?= old('thumbnail_caption', $post['thumbnail_caption'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Kategori & Tags -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold text-dark">Kategori <span class="text-danger">*</span></label>
                                <div id="category-list" class="checkbox-group-container form-control p-3 <?= (isset(session('errors')['categories'])) ? 'is-invalid' : '' ?>" style="height: 200px; overflow-y: auto;">
                                    <?php foreach ($categories as $category) : ?>
                                        <h6 class="fw-bold"><?= esc($category['name']) ?></h6>
                                        <?php if (!empty($category['children'])) : ?>
                                            <div class="ms-3">
                                                <?php foreach ($category['children'] as $child) : ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="categories[]" value="<?= $child['id'] ?>" id="cat_<?= $child['id'] ?>" <?= in_array($child['id'], old('categories', $post_categories)) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="cat_<?= $child['id'] ?>">
                                                            <?= esc($child['name']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
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
                                <label class="form-label fw-semibold text-dark">Tag <span class="text-danger">*</span></label>
                                <div id="tag-list" class="checkbox-group-container form-control p-3 <?= (isset(session('errors')['tags'])) ? 'is-invalid' : '' ?>" style="height: 200px; overflow-y: auto;">
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
                            <div class="form-group mt-3">
                                <button type="button" id="suggest-tags-btn" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-wand-magic-sparkles me-2"></i>Sarankan Tag
                                </button>
                                <div id="suggested-tags" class="mt-2"></div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const suggestBtn = document.getElementById('suggest-tags-btn');
        const suggestedTagsContainer = document.getElementById('suggested-tags');
        const titleInput = document.getElementById('title');

        suggestBtn.addEventListener('click', function() {
            try {
                const contentInput = tinymce.get('content');
                if (!contentInput) {
                    alert('Editor is not ready yet.');
                    return;
                }

                const title = titleInput.value;
                const content = contentInput.getContent();

                if (!title || !content) {
                    alert('Judul dan konten harus diisi untuk menyarankan tag.');
                    return;
                }

                suggestBtn.disabled = true;
                suggestBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyarankan...';

                fetch('<?= base_url('api/tags/suggest') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({
                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                            'title': title,
                            'content': content
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        suggestedTagsContainer.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(tag => {
                                const badge = document.createElement('span');
                                badge.className = 'badge bg-primary me-1 mb-1';
                                badge.style.cursor = 'pointer';
                                badge.textContent = tag;
                                badge.addEventListener('click', function() {
                                    // Check if a checkbox with this tag already exists
                                    let existingCheckbox = null;
                                    document.querySelectorAll('#tag-list .form-check-label').forEach(label => {
                                        if (label.textContent.trim().toLowerCase() === tag.toLowerCase()) {
                                            existingCheckbox = label.previousElementSibling;
                                        }
                                    });

                                    if (existingCheckbox) {
                                        existingCheckbox.checked = true;
                                    } else {
                                        // Create a new checkbox
                                        const newTagId = 'new_tag_' + tag.replace(/\s+/g, '_');
                                        const newCheckbox = document.createElement('div');
                                        newCheckbox.className = 'form-check';
                                        newCheckbox.innerHTML = `
                                        <input class="form-check-input" type="checkbox" name="new_tags[]" value="${tag}" id="${newTagId}" checked>
                                        <label class="form-check-label" for="${newTagId}">${tag}</label>
                                    `;
                                        document.getElementById('tag-list').appendChild(newCheckbox);
                                    }
                                });
                                suggestedTagsContainer.appendChild(badge);
                            });
                        } else {
                            suggestedTagsContainer.innerHTML = '<p class="text-muted small">Tidak ada tag yang disarankan.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        suggestedTagsContainer.innerHTML = '<p class="text-danger small">Gagal menyarankan tag.</p>';
                    })
                    .finally(() => {
                        suggestBtn.disabled = false;
                        suggestBtn.innerHTML = '<i class="fas fa-wand-magic-sparkles me-2"></i>Sarankan Tag';
                    });
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while getting the editor content.');
            }
        });
    });
</script>

<?= $this->endSection() ?>
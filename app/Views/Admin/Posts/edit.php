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
                <form action="<?= base_url('admin/posts/' . $post['id']) ?>" method="post" enctype="multipart/form-data">
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
                                <div class="input-group">
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control <?= (isset(session('errors')['thumbnail'])) ? 'is-invalid' : '' ?>" onchange="previewImage()">
                                    <input type="hidden" name="pasted_thumbnail" id="pasted_thumbnail">
                                    <button type="button" id="paste-thumbnail-btn" class="btn btn-outline-secondary">
                                        <i class="fas fa-paste"></i>
                                    </button>
                                </div>
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

                        <div class="col-12" id="published_at_container" style="display: <?= old('status', $post['status']) === 'published' ? 'block' : 'none' ?>;">
                            <div class="form-group">
                                <label for="published_at" class="form-label fw-semibold text-dark">Tanggal Publikasi</label>
                                <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="<?= old('published_at', $post['published_at'] ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : '') ?>">
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
                                <div id="tag-container" class="form-control" style="min-height: 100px;">
                                    <?php foreach ($post_tag_names as $tagName) : ?>
                                        <span class="tag-badge badge bg-primary me-1 mb-1"><?= esc($tagName) ?> <i class="fas fa-times-circle ms-1" style="cursor: pointer;"></i></span>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="tags" id="tags-input" value="<?= implode(',', is_string(old('tags')) ? explode(',', old('tags')) : old('tags', $post_tag_names)) ?>">
                                <small class="text-muted">Klik pada tag untuk menghapusnya.</small>
                                <?php if (isset(session('errors')['tags'])) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session('errors')['tags'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group mt-3 d-flex gap-2">
                                <button type="button" id="suggest-tags-btn" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-wand-magic-sparkles me-2"></i>Sarankan Tag
                                </button>
                                <div class="input-group input-group-sm" style="max-width: 300px;">
                                    <input type="text" id="manual-tag-input" class="form-control" placeholder="Tambah tag manual...">
                                    <button class="btn btn-outline-secondary" type="button" id="add-manual-tag-btn">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <input type="hidden" name="status" id="status" value="<?= old('status', $post['status']) ?>">
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end border-top pt-4">
                                <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <?php if ($post['status'] === 'published') : ?>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Perbarui
                                    </button>
                                <?php else : ?>
                                    <button type="submit" name="status" value="draft" class="btn btn-outline-primary px-4">
                                        <i class="fas fa-save me-2"></i>Draft
                                    </button>
                                    <button type="submit" name="status" value="published" class="btn btn-primary px-4">
                                        <i class="fas fa-paper-plane me-2"></i>Publish
                                    </button>
                                <?php endif; ?>
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
        const thumbnailInput = document.getElementById('thumbnail');
        const pasteBtn = document.getElementById('paste-thumbnail-btn');

        thumbnailInput.addEventListener('paste', function(e) {
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (const item of items) {
                if (item.type.indexOf('image') === 0) {
                    const blob = item.getAsFile();
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        document.getElementById('pasted_thumbnail').value = event.target.result;
                        document.getElementById('thumbnail-preview').src = event.target.result;
                        document.getElementById('thumbnail-preview').style.display = 'block';
                    };
                    reader.readAsDataURL(blob);
                }
            }
        });

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
                            document.getElementById('pasted_thumbnail').value = event.target.result;
                            document.getElementById('thumbnail-preview').src = event.target.result;
                            document.getElementById('thumbnail-preview').style.display = 'block';
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusInput = document.getElementById('status');
        const publishedAtContainer = document.getElementById('published_at_container');

        function togglePublishedAt(status) {
            if (status === 'published') {
                publishedAtContainer.style.display = 'block';
            } else {
                publishedAtContainer.style.display = 'none';
            }
        }

        togglePublishedAt(statusInput.value);

        // This is a hack to listen to the change of the hidden status input
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === "attributes") {
                    togglePublishedAt(statusInput.value);
                }
            });
        });

        observer.observe(statusInput, {
            attributes: true //configure it to listen to attribute changes
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const suggestBtn = document.getElementById('suggest-tags-btn');
        const suggestedTagsContainer = document.getElementById('suggested-tags');
        const tagContainer = document.getElementById('tag-container');
        const tagsInput = document.getElementById('tags-input');
        const titleInput = document.getElementById('title');
        const manualTagInput = document.getElementById('manual-tag-input');
        const addManualTagBtn = document.getElementById('add-manual-tag-btn');

        function updateTagsInput() {
            const tags = [];
            tagContainer.querySelectorAll('.tag-badge').forEach(badge => {
                tags.push(badge.textContent.slice(0, -1).trim());
            });
            tagsInput.value = tags.join(',');
        }

        function createTag(tag) {
            // Check if tag already exists
            let exists = false;
            tagContainer.querySelectorAll('.tag-badge').forEach(badge => {
                if (badge.textContent.slice(0, -1).trim().toLowerCase() === tag.toLowerCase()) {
                    exists = true;
                }
            });

            if (exists) {
                return;
            }

            const badge = document.createElement('span');
            badge.className = 'tag-badge badge bg-primary me-1 mb-1';
            badge.innerHTML = `${tag} <i class="fas fa-times-circle ms-1" style="cursor: pointer;"></i>`;

            badge.querySelector('i').addEventListener('click', function() {
                badge.remove();
                updateTagsInput();
            });

            tagContainer.appendChild(badge);
            updateTagsInput();
        }

        function addManualTag() {
            const tag = manualTagInput.value.trim();
            if (tag) {
                createTag(tag);
                manualTagInput.value = '';
            }
        }

        addManualTagBtn.addEventListener('click', addManualTag);

        manualTagInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
                addManualTag();
            }
        });

        // Add event listeners to existing tags
        tagContainer.querySelectorAll('.tag-badge i').forEach(icon => {
            icon.addEventListener('click', function() {
                icon.parentElement.remove();
                updateTagsInput();
            });
        });

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
                        if (data.length > 0) {
                            data.forEach(tag => {
                                createTag(tag);
                            });
                        } else {
                            alert('Tidak ada tag yang disarankan.');
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
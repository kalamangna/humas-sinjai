<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Kelola Berita<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/posts/new') ?>" class="btn btn-primary">
    <i class="fas fa-plus-circle me-2"></i>Tambah Berita
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Search and Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= base_url('admin/posts') ?>" method="get">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul berita..." value="<?= esc($filters['search'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['id'] ?>" <?= ($filters['category'] ?? '') == $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="author" class="form-select">
                        <option value="">Semua Penulis</option>
                        <?php foreach ($users as $user) : ?>
                            <option value="<?= $user['id'] ?>" <?= ($filters['author'] ?? '') == $user['id'] ? 'selected' : '' ?>><?= esc($user['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-grid d-md-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Stats Overview -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-primary text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $total_posts ?? '0' ?></h4>
                        <small>Total Berita</small>
                    </div>
                    <i class="fas fa-newspaper fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-success text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $published_posts ?? '0' ?></h4>
                        <small>Published</small>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-warning text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $draft_posts ?? '0' ?></h4>
                        <small>Draft</small>
                    </div>
                    <i class="fas fa-edit fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-info text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $today_posts ?? '0' ?></h4>
                        <small>Hari Ini</small>
                    </div>
                    <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Posts Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 ps-4">Judul Berita</th>
                        <th class="border-0">Kategori</th>
                        <th class="border-0 text-center">Tags</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">Penulis</th>
                        <th class="border-0">Tanggal</th>
                        <th class="border-0 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($posts)) : ?>
                        <?php foreach ($posts as $post) : ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-start">
                                        <?php if (!empty($post['thumbnail'])) : ?>
                                            <img src="<?= esc($post['thumbnail']) ?>" alt="<?= esc($post['title']) ?>" class="rounded me-3" style="width: 60px; height: 40px; object-fit: cover;">
                                        <?php else : ?>
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 40px;">
                                                <i class="fas fa-newspaper text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-dark"><?= esc($post['title']) ?></h6>
                                            <small class="text-muted">/<?= esc($post['slug']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($post['category_name'])) : ?>
                                        <?php
                                        $cat_names = explode(',', $post['category_name']);
                                        foreach ($cat_names as $name) : ?>
                                            <span class="badge bg-primary me-1"><?= esc($name) ?></span>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Uncategorized</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?= $post['tag_count'] ?></span>
                                </td>
                                <td>
                                    <?php if ($post['status'] === 'published') : ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Published
                                        </span>
                                    <?php elseif ($post['status'] === 'draft') : ?>
                                        <span class="badge bg-warning">
                                            <i class="fas fa-edit me-1"></i>Draft
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary"><?= esc($post['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted"><?= esc($post['author_name'] ?? 'Admin') ?></small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d M Y, H:i', strtotime($post['published_at'] ?? $post['created_at'])) ?>
                                    </small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('post/' . esc($post['slug'])) ?>" target="_blank" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/posts/' . $post['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('admin/posts/' . $post['id']) ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada berita</h5>
                                <p class="text-muted">Mulai dengan membuat berita pertama Anda.</p>
                                <a href="<?= base_url('admin/posts/new') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Berita Pertama
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<?php if (isset($pager) && $pager->getPageCount('posts') > 1) : ?>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted small">
            <?php
                $from = ($pager->getCurrentPage('posts') - 1) * $pager->getPerPage('posts') + 1;
                $to = $from + count($posts) - 1;
            ?>
            Menampilkan <?= $from ?>-<?= $to ?> dari <?= $pager->getTotal('posts') ?> berita
        </div>
        <div>
            <?= $pager->only(['search', 'category', 'author'])->links('posts', 'custom_bootstrap') ?>
        </div>
    </div>
<?php endif; ?>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<?= $this->endSection() ?>
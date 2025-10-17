<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<button class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
    <i class="fas fa-sync-alt me-2"></i>Refresh
</button>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="row g-3 mb-5">
    <?php $isAdmin = session()->get('role') === 'admin'; ?>
    <!-- Posts Card -->
    <div class="<?= $isAdmin ? 'col-xl-3' : 'col-xl-4' ?> col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="p-3 rounded-3 bg-primary">
                        <i class="fas fa-newspaper text-white fs-4"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1"><?= $postCount ?? '0' ?></h3>
                <p class="text-muted mb-0">Total Berita</p>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>Update: <?= $lastPostUpdate ?? 'N/A' ?>
                    </small>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-primary btn-sm w-100">
                    <i class="fas fa-eye me-2"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="<?= $isAdmin ? 'col-xl-3' : 'col-xl-4' ?> col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="p-3 rounded-3 bg-success">
                        <i class="fas fa-folder text-white fs-4"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1"><?= $categoryCount ?? '0' ?></h3>
                <p class="text-muted mb-0">Total Kategori</p>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-success btn-sm w-100">
                    <i class="fas fa-eye me-2"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <!-- Tags Card -->
    <div class="<?= $isAdmin ? 'col-xl-3' : 'col-xl-4' ?> col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="p-3 rounded-3 bg-info">
                        <i class="fas fa-tags text-white fs-4"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1"><?= $tagCount ?? '0' ?></h3>
                <p class="text-muted mb-0">Total Tag</p>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <a href="<?= base_url('admin/tags') ?>" class="btn btn-outline-info btn-sm w-100">
                    <i class="fas fa-eye me-2"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <?php if ($isAdmin) : ?>
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 rounded-3 bg-warning">
                            <i class="fas fa-users text-white fs-4"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1"><?= $userCount ?? '0' ?></h3>
                    <p class="text-muted mb-0">Total Pengguna</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-warning btn-sm w-100">
                        <i class="fas fa-eye me-2"></i>Lihat Semua
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="row g-3 mb-5">
    <!-- Popular Posts -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom-0 py-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-fire me-2"></i>Berita Terpopuler
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th class="text-end">Dilihat</th>
                            </tr>
                        </thead>
                        <tbody id="popular-posts-data">
                            <tr>
                                <td colspan="2" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom-0 py-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-history me-2"></i>Berita Terbaru
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recentPosts)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentPosts as $post) : ?>
                                    <tr>
                                        <td><?= esc($post['title']) ?></td>
                                        <td><?= format_date($post['published_at']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Belum ada berita.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 py-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php $isAdmin = session()->get('role') === 'admin'; ?>
                    <div class="<?= $isAdmin ? 'col-lg-3' : 'col-lg-4' ?> col-6">
                        <a href="<?= base_url('admin/posts/new') ?>" class="btn btn-primary w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                            <i class="fas fa-plus-circle fs-2 mb-2"></i>
                            <span>Tambah Berita</span>
                            <small class="text-light opacity-75 mt-1">Berita baru</small>
                        </a>
                    </div>
                    <div class="<?= $isAdmin ? 'col-lg-3' : 'col-lg-4' ?> col-6">
                        <a href="<?= base_url('admin/categories/new') ?>" class="btn btn-success w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                            <i class="fas fa-folder-plus fs-2 mb-2"></i>
                            <span>Tambah Kategori</span>
                            <small class="text-light opacity-75 mt-1">Kategori baru</small>
                        </a>
                    </div>
                    <div class="<?= $isAdmin ? 'col-lg-3' : 'col-lg-4' ?> col-6">
                        <a href="<?= base_url('admin/tags/new') ?>" class="btn btn-info w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                            <i class="fas fa-tag fs-2 mb-2"></i>
                            <span>Tambah Tag</span>
                            <small class="text-light opacity-75 mt-1">Tag baru</small>
                        </a>
                    </div>
                    <?php if ($isAdmin) : ?>
                        <div class="col-lg-3 col-6">
                            <a href="<?= base_url('admin/users/new') ?>" class="btn btn-warning w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                                <i class="fas fa-user-plus fs-2 mb-2"></i>
                                <span>Tambah Pengguna</span>
                                <small class="text-light opacity-75 mt-1">Pengguna baru</small>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popularPostsData = document.getElementById('popular-posts-data');

        fetch('<?= base_url('api/analytics/popular-posts') ?>')
            .then(response => response.json())
            .then(data => {
                popularPostsData.innerHTML = '';
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.title}</td>
                        <td class="text-end">${item.views}</td>
                    `;
                    popularPostsData.appendChild(row);
                });
            });
    });
</script>

<?= $this->endSection() ?>
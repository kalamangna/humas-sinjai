[file name]: index.php
[file content begin]
<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Kelola Pengguna<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="/admin/users/new" class="btn btn-primary">
    <i class="fas fa-plus-circle me-2"></i>Tambah Pengguna
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Stats Overview -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-primary text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $total_users ?? '0' ?></h4>
                        <small>Total Pengguna</small>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-success text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $active_users ?? '0' ?></h4>
                        <small>Pengguna Aktif</small>
                    </div>
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-info text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $admin_users ?? '0' ?></h4>
                        <small>Administrator</small>
                    </div>
                    <i class="fas fa-user-shield fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 bg-warning text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $author_users ?? '0' ?></h4>
                        <small>Authors</small>
                    </div>
                    <i class="fas fa-user-edit fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table View -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 ps-4">Pengguna</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Role</th>
                        <th class="border-0">Jumlah Berita</th>
                        <th class="border-0">Tanggal Bergabung</th>
                        <th class="border-0 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><?= esc($user['name']) ?></h6>
                                            <small class="text-muted">ID: <?= $user['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark"><?= esc($user['email']) ?></span>
                                    <?php if ($user['email_verified_at'] ?? false) : ?>
                                        <i class="fas fa-check-circle text-success ms-1" data-bs-toggle="tooltip" title="Email Terverifikasi"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $roleBadge = match ($user['role'] ?? 'user') {
                                        'admin' => 'bg-danger',
                                        'editor' => 'bg-warning',
                                        'author' => 'bg-info',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $roleBadge ?>"><?= ucfirst($user['role'] ?? 'user') ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?= $user['post_count'] ?? '0' ?></span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d M Y, H:i', strtotime($user['created_at'] ?? 'now')) ?>
                                    </small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="/admin/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Pengguna">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if (($user['id'] ?? 0) !== ($current_user_id ?? 0)): ?>
                                            <form action="/admin/users/<?= $user['id'] ?>" method="post" class="d-inline">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus Pengguna" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna <?= esc($user['name']) ?>?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Tidak dapat menghapus akun sendiri" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pengguna</h5>
                                <p class="text-muted">Mulai dengan menambahkan pengguna pertama.</p>
                                <a href="/admin/users/new" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Pengguna Pertama
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
<?php if (isset($pager) && $pager->getPageCount() > 1) : ?>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted small">
            <?php
                $from = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1;
                $to = $from + count($users) - 1;
            ?>
            Menampilkan <?= $from ?>-<?= $to ?> dari <?= $pager->getTotal() ?> pengguna
        </div>
        <div>
            <?= $pager->links('default', 'custom_bootstrap') ?>
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
[file content end]
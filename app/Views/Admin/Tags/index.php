<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Kelola Tag<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/tags/new') ?>" class="btn btn-primary">
    <i class="fas fa-plus-circle me-2"></i>Tambah Tag
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Stats Overview -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 bg-primary text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $total_tags ?? '0' ?></h4>
                        <small>Total Tag</small>
                    </div>
                    <i class="fas fa-tags fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 bg-success text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0"><?= $active_tags ?? '0' ?></h4>
                        <small>Tag Aktif</small>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 bg-info text-white">
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
</div>

<!-- Tags Table View -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 ps-4">Nama Tag</th>
                        <th class="border-0">Slug</th>
                        <th class="border-0">Jumlah Berita</th>
                        <th class="border-0">Tanggal Dibuat</th>
                        <th class="border-0 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tags)): ?>
                        <?php foreach ($tags as $tag): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-tag text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><?= esc($tag['name']) ?></h6>
                                            <?php if (!empty($tag['description'])): ?>
                                                <small class="text-muted"><?= esc($tag['description']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="text-muted">/<?= esc($tag['slug']) ?></code>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?= $tag['post_count'] ?? '0' ?></span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d M Y, H:i', strtotime($tag['created_at'] ?? 'now')) ?>
                                    </small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <?php if (($tag['post_count'] ?? 0) > 0): ?>
                                            <a href="<?= base_url('tag/' . esc($tag['slug'])) ?>" target="_blank" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Lihat Berita">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('admin/tags/' . $tag['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('admin/tags/' . $tag['id']) ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus tag <?= esc($tag['name']) ?>?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada tag</h5>
                                <p class="text-muted">Mulai dengan membuat tag pertama Anda.</p>
                                <a href="<?= base_url('admin/tags/new') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Tag Pertama
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
                $to = $from + count($tags) - 1;
            ?>
            Menampilkan <?= $from ?>-<?= $to ?> dari <?= $pager->getTotal() ?> tag
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
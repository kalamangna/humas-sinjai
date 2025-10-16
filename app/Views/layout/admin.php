<?php include('admin_header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-lg-2 d-lg-block bg-white sidebar collapse border-end">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 <?= url_is('admin') ? 'active text-primary fw-bold' : 'text-dark' ?>" href="<?= base_url('admin') ?>">
                            <i class="fas fa-fw fa-tachometer-alt me-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 <?= url_is('admin/posts*') ? 'active text-primary fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/posts') ?>">
                            <i class="fas fa-fw fa-newspaper me-3"></i>
                            Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 <?= url_is('admin/categories*') ? 'active text-primary fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/categories') ?>">
                            <i class="fas fa-fw fa-folder me-3"></i>
                            Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 <?= url_is('admin/tags*') ? 'active text-primary fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/tags') ?>">
                            <i class="fas fa-fw fa-tags me-3"></i>
                            Tag
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 <?= url_is('admin/analytics*') ? 'active text-primary fw-bold' : 'text-dark' ?>" href="#analytics-submenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="analytics-submenu">
                            <i class="fas fa-fw fa-chart-line me-3"></i>
                            Analitik
                        </a>
                        <div class="collapse" id="analytics-submenu">
                            <ul class="nav flex-column ms-4">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center py-2 <?= url_is('admin/analytics/overview') ? 'active text-primary' : 'text-dark' ?>" href="<?= base_url('admin/analytics/overview') ?>">
                                        <i class="fas fa-fw fa-tachometer-alt me-2"></i>
                                        Gambaran
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center py-2 <?= url_is('admin/analytics/top-pages') ? 'active text-primary' : 'text-dark' ?>" href="<?= base_url('admin/analytics/top-pages') ?>">
                                        <i class="fas fa-fw fa-file-alt me-2"></i>
                                        Halaman Teratas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center py-2 <?= url_is('admin/analytics/traffic-sources') ? 'active text-primary' : 'text-dark' ?>" href="<?= base_url('admin/analytics/traffic-sources') ?>">
                                        <i class="fas fa-fw fa-globe me-2"></i>
                                        Sumber Lalu Lintas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center py-2 <?= url_is('admin/analytics/geo') ? 'active text-primary' : 'text-dark' ?>" href="<?= base_url('admin/analytics/geo') ?>">
                                        <i class="fas fa-fw fa-map-marker-alt me-2"></i>
                                        Geografis
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center py-2 <?= url_is('admin/analytics/device-category') ? 'active text-primary' : 'text-dark' ?>" href="<?= base_url('admin/analytics/device-category') ?>">
                                        <i class="fas fa-fw fa-desktop me-2"></i>
                                        Kategori Perangkat
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <?php if (session()->get('role') === 'admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center py-3 <?= url_is('admin/users*') ? 'active text-primary fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/users') ?>">
                                <i class="fas fa-users me-3"></i>
                                Pengguna
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Quick Stats -->
                <div class="mt-5 px-3 d-none d-lg-block">
                    <h6 class="text-uppercase small fw-bold text-muted mb-3">Statistik</h6>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Total Berita</span>
                            <span class="badge bg-primary"><?= $total_posts ?? '0' ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Total Kategori</span>
                            <span class="badge bg-success"><?= $total_categories ?? '0' ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Total Tag</span>
                            <span class="badge bg-info"><?= $total_tags ?? '0' ?></span>
                        </div>
                        <?php if (session()->get('role') === 'admin') : ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Total Pengguna</span>
                                <span class="badge bg-warning"><?= $total_users ?? '0' ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-lg-10 ms-lg-auto px-md-4 py-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1"><?= $this->renderSection('page_title') ?? 'Dashboard' ?></h2>
                </div>
                <div>
                    <?= $this->renderSection('page_actions') ?? '' ?>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Main Content -->
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<?php include('admin_footer.php'); ?>
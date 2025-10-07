<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Humas Sinjai</title>
    <link rel="icon" href="<?= base_url('logo.png') ?>" type="image/png">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg-light">
    <!-- Top Navigation -->
    <header class="navbar navbar-dark sticky-top shadow bg-primary-gradient">
        <div class="container-fluid">
            <!-- Mobile Toggle -->
            <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('admin') ?>">
                <img src="<?= base_url('logo.png') ?>" alt="Logo Sinjai" width="32" height="32" class="rounded-circle me-2">
                <span>Humas Sinjai</span>
                <small class="badge bg-light text-primary ms-2">Admin</small>
            </a>

            <!-- User Menu -->
            <div class="dropdown ms-auto">
                <a href="#" class="nav-link dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-2 fs-5"></i>
                    <span class="d-none d-sm-inline"><?= session()->get('name') ?? 'Admin' ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li>
                        <a class="dropdown-item" href="<?= base_url('admin/profile') ?>">
                            <i class="fas fa-fw fa-user me-2"></i>Profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                            <i class="fas fa-fw fa-cog me-2"></i>Pengaturan
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i class="fas fa-fw fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
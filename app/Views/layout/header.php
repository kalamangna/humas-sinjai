<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' - ' : '' ?>Humas Sinjai</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= isset($description) ? esc($description) : 'Portal Berita Resmi Pemerintah Kabupaten Sinjai #samasamaki' ?>">
    <meta name="keywords" content="<?= isset($keywords) ? esc($keywords) : 'Humas Sinjai, Berita Sinjai, Sinjai, Pemerintah Kabupaten Sinjai' ?>">
    <meta name="author" content="<?= isset($author) ? esc($author) : 'Humas Sinjai' ?>">
    <meta name="image" content="<?= isset($image) ? esc($image) : base_url('meta.png') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= isset($title) ? esc($title) : 'Humas Sinjai' ?>">
    <meta property="og:description" content="<?= isset($description) ? esc($description) : 'Portal Berita Resmi Pemerintah Kabupaten Sinjai #samasamaki' ?>">
    <meta property="og:image" content="<?= isset($image) ? esc($image) : base_url('meta.png') ?>">
    <meta property="og:url" content="<?= current_url() ?>">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= isset($title) ? esc($title) : 'Humas Sinjai' ?>">
    <meta name="twitter:description" content="<?= isset($description) ? esc($description) : 'Portal Berita Resmi Pemerintah Kabupaten Sinjai #samasamaki' ?>">
    <meta name="twitter:image" content="<?= isset($image) ? esc($image) : base_url('meta.png') ?>">

    <link rel="icon" href="<?= base_url('logo.png') ?>" type="image/png">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-gradient shadow-sm">
        <div class="container">
            <!-- Brand with icon -->
            <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="<?= base_url('/') ?>">
                <img src="<?= base_url('logo.png') ?>" alt="Logo Sinjai" width="40" height="40" class="d-inline-block align-text-top me-2">
                <span>Humas Sinjai</span>
            </a>

            <!-- Mobile toggle button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars text-white"></i>
            </button>

            <!-- Navbar items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php
                    helper('url'); // Ensure the URL helper is loaded
                    $nav_items = [
                        ['path' => '/', 'icon' => 'fas fa-fw fa-home', 'text' => 'Beranda'],
                        ['path' => 'posts', 'icon' => 'fas fa-fw fa-newspaper', 'text' => 'Berita'],
                        ['path' => 'about', 'icon' => 'fas fa-fw fa-info-circle', 'text' => 'Tentang'],
                        ['path' => 'contact', 'icon' => 'fas fa-fw fa-envelope', 'text' => 'Kontak'],
                    ];
                    ?>
                    <?php foreach ($nav_items as $item) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is($item['path']) ? 'active' : '' ?>" href="<?= site_url($item['path']) ?>">
                                <i class="<?= $item['icon'] ?> me-2"></i><?= $item['text'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Search form -->
                <form class="d-flex" action="<?= base_url('search') ?>" method="get">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Cari berita..." aria-label="Search" name="q" required>
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main content container -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
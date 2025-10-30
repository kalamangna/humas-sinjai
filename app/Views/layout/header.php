<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' - ' : '' ?>Humas Sinjai</title>

    <!-- Favicon and Stylesheets -->
    <link rel="icon" href="<?= base_url('logo.png') ?>" type="image/png">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= isset($description) ? esc($description) : 'Portal Berita Resmi Pemerintah Kabupaten Sinjai #samasamaki' ?>">
    <meta name="keywords" content="<?= isset($keywords) ? esc($keywords) : 'Humas Sinjai, Berita Sinjai, Sinjai, Pemerintah Kabupaten Sinjai' ?>">
    <meta name="author" content="<?= isset($author) ? esc($author) : 'Humas Sinjai' ?>">
    <meta name="image" content="<?= isset($image) ? $image : base_url('meta.png') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= isset($title) ? esc($title) : 'Humas Sinjai' ?>">
    <meta property="og:description" content="<?= isset($description) ? esc($description) : 'Portal Berita Resmi Pemerintah Kabupaten Sinjai #samasamaki' ?>">
    <meta property="og:image" content="<?= isset($image) ? $image : base_url('meta.png') ?>">
    <meta property="og:url" content="<?= current_url() ?>">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= isset($title) ? esc($title) : 'Humas Sinjai' ?>">
    <meta name="twitter:description" content="<?= isset($description) ? esc($description) : 'Portal Berita Resmi Pemerintah Kabupaten Sinjai #samasamaki' ?>">
    <meta name="twitter:image" content="<?= isset($image) ? $image : base_url('meta.png') ?>">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QEW3BM9KJ7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-QEW3BM9KJ7');
    </script>
</head>

<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-gradient shadow-sm">
        <div class="container">
            <!-- Brand with icon -->
            <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="<?= base_url('/') ?>">
                <img src="<?= base_url('humas.png') ?>" alt="Logo Sinjai" height="40" class="d-inline-block align-text-top me-2">
            </a>

            <!-- Mobile toggle button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-fw fa-bars text-white"></i>
            </button>

            <!-- Navbar items -->
            <div class="collapse navbar-collapse py-2" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('/') ? 'active' : '' ?>" href="<?= base_url('/') ?>"><i class="fas fa-fw fa-home me-2"></i>Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('posts') ? 'active' : '' ?>" href="<?= base_url('posts') ?>"><i class="fas fa-fw fa-newspaper me-2"></i>Semua Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('program-prioritas') ? 'active' : '' ?>" href="<?= base_url('program-prioritas') ?>"><i class="fas fa-fw fa-bullseye me-2"></i>Program Prioritas</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-fw fa-folder me-2"></i>Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($categories as $category) : ?>
                                <?php if (! empty($subCategories[$category['id']])) : ?>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-fw fa-folder-open me-2 text-primary"></i><?= esc($category['name']) ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($subCategories[$category['id']] as $subCategory) : ?>
                                                <li>
                                                    <a class="dropdown-item" href="<?= base_url('category/' . $subCategory['slug']) ?>">
                                                        <i class="fas fa-fw fa-folder me-2 text-secondary"></i><?= esc($subCategory['name']) ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('category/' . $category['slug']) ?>">
                                            <i class="fas fa-fw fa-folder me-2"></i><?= esc($category['name']) ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-primary" href="<?= base_url('categories') ?>">
                                    <i class="fas fa-fw fa-list me-2"></i>Semua Kategori
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Search form -->
                <form class="d-flex" action="<?= base_url('search') ?>" method="get">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Cari berita..." aria-label="Search" name="q" required>
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-fw fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main content container -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-fw fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-fw fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
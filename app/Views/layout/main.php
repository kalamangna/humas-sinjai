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
    <link rel="canonical" href="<?= current_url() ?>">

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
    <nav class="navbar navbar-expand-xl navbar-dark bg-primary-gradient shadow-sm">
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProfil" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-fw fa-user-tie me-2"></i>Profil
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProfil">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('profil/bupati') ?>">
                                    <i class="fas fa-fw fa-user me-2 text-primary"></i>Bupati
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('profil/wakil-bupati') ?>">
                                    <i class="fas fa-fw fa-user-friends me-2 text-secondary"></i>Wakil Bupati
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('profil/sekda') ?>">
                                    <i class="fas fa-fw fa-user-shield me-2 text-success"></i>Sekda
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('profil/forkopimda') ?>">
                                    <i class="fas fa-fw fa-users me-2 text-info"></i>Forkopimda
                                </a>
                            </li>
                        </ul>
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
                <form class="d-flex my-2 my-xl-0" action="<?= base_url('search') ?>" method="get">
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

    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="bg-primary-gradient text-white mt-5">
        <div class="container py-5">
            <div class="row g-3">
                <!-- Brand info -->
                <div class="col-md-12 col-lg-4 mb-4">
                    <div class="d-block mb-3">
                        <img src="<?= base_url('humas.png') ?>" alt="Logo Sinjai" height="50">
                        <!-- <h5 class="fw-bold mb-0 text-white">Humas Sinjai</h5> -->
                    </div>
                    <p class="text-light mb-2">
                        Portal Berita Resmi Pemerintah Kabupaten Sinjai
                    </p>
                    <span class="badge bg-light text-primary mb-3">
                        <i class="fas fa-hashtag me-1"></i>samasamaki
                    </span>
                    <div class="d-flex gap-3">
                        <a href="https://www.facebook.com/FP.KabupatenSinjai" target="_blank" class="text-white fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/sinjaikab" target="_blank" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@pemkabsinjai" target="_blank" class="text-white fs-5"><i class="fab fa-tiktok"></i></a>
                        <a href="https://x.com/sinjaikab" target="_blank" class="text-white fs-5"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://www.youtube.com/@SINJAITV" target="_blank" class="text-white fs-5"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Quick links -->
                <div class="col-md-4 col-lg-2 mb-4">
                    <h6 class="fw-bold mb-3 text-white">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= base_url('/') ?>" class="text-light text-decoration-none">
                                <i class="fas fa-fw fa-arrow-right me-2 small text-white"></i>Beranda
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('about') ?>" class="text-light text-decoration-none">
                                <i class="fas fa-fw fa-arrow-right me-2 small text-white"></i>Tentang
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('contact') ?>" class="text-light text-decoration-none">
                                <i class="fas fa-fw fa-arrow-right me-2 small text-white"></i>Kontak
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('rss') ?>" class="text-light text-decoration-none">
                                <i class="fas fa-fw fa-rss me-2 small text-white"></i>RSS
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('widget') ?>" class="text-light text-decoration-none">
                                <i class="fas fa-fw fa-code me-2 small text-white"></i>Widget
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact info -->
                <div class="col-md-8 col-lg-3 mb-4">
                    <h6 class="fw-bold mb-3 text-white">Kontak</h6>
                    <ul class="list-unstyled text-light">
                        <li class="mb-3">
                            <i class="fas fa-fw fa-envelope me-2 text-white"></i>
                            <span>humas@sinjaikab.go.id</span>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-fw fa-map-marker-alt me-2 text-white"></i>
                            <a href="https://maps.app.goo.gl/8WX2QetWMMaGdYiw5" target="_blank" class="text-light text-decoration-none">Jl. Persatuan Raya No. 101, Kel. Balangnipa, Kec. Sinjai Utara, Kab. Sinjai</a>
                        </li>
                    </ul>
                </div>

                <!-- Layanan Pengaduan -->
                <div class="col-md-12 col-lg-3 mb-4">
                    <h6 class="fw-bold mb-3 text-white">Layanan Pengaduan</h6>
                    <a href="https://lapor.go.id/" target="_blank" class="bg-white d-inline-block p-2 rounded mb-2">
                        <img src="<?= base_url('lapor.png') ?>" alt="Layanan Pengaduan" class="img-fluid">
                    </a>
                </div>

            </div>

            <hr class="my-4 border-light">

            <!-- Copyright -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-light mb-0">
                        &copy; <?= date('Y') ?> Humas Sinjai. All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="text-light mb-0">
                        Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk Sinjai.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <a href="#" class="scroll-to-top d-flex align-items-center justify-content-center text-decoration-none"><i class="fas fa-chevron-up"></i></a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script>
        /**
         * JavaScript untuk hover behavior pada dropdown dan dropend
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const mainDropdown = document.querySelector('.navbar-nav .dropdown');
            const dropends = document.querySelectorAll('.dropend');

            // Hover behavior untuk dropdown utama (desktop only)
            if (mainDropdown && window.innerWidth >= 992) {
                const mainToggle = mainDropdown.querySelector('.dropdown-toggle');
                const mainMenu = mainDropdown.querySelector('.dropdown-menu');

                mainDropdown.addEventListener('mouseenter', function() {
                    mainMenu.classList.add('show');
                    mainToggle.setAttribute('aria-expanded', 'true');
                });

                mainDropdown.addEventListener('mouseleave', function() {
                    mainMenu.classList.remove('show');
                    mainToggle.setAttribute('aria-expanded', 'false');

                    // Tutup semua dropend ketika meninggalkan dropdown utama
                    dropends.forEach(function(dropend) {
                        const toggle = dropend.querySelector('.dropdown-toggle');
                        const menu = dropend.querySelector('.dropdown-menu');
                        if (toggle && menu) {
                            menu.classList.remove('show');
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    });
                });
            }

            // Mobile behavior untuk dropend
            dropends.forEach(function(dropend) {
                const toggle = dropend.querySelector('.dropdown-toggle');
                const menu = dropend.querySelector('.dropdown-menu');

                if (toggle && menu) {
                    // Desktop hover behavior
                    if (window.innerWidth >= 992) {
                        dropend.addEventListener('mouseenter', function() {
                            // Tutup dropend lainnya
                            document.querySelectorAll('.dropend .dropdown-menu').forEach(function(otherMenu) {
                                if (otherMenu !== menu) {
                                    otherMenu.classList.remove('show');
                                }
                            });

                            menu.classList.add('show');
                            toggle.setAttribute('aria-expanded', 'true');
                        });

                        dropend.addEventListener('mouseleave', function() {
                            menu.classList.remove('show');
                            toggle.setAttribute('aria-expanded', 'false');
                        });
                    }

                    // Mobile click behavior - diperbaiki
                    toggle.addEventListener('click', function(e) {
                        if (window.innerWidth < 992) {
                            e.preventDefault();
                            e.stopPropagation();

                            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

                            // Jika dropend ini sudah terbuka, tutup saja
                            if (isExpanded) {
                                menu.classList.remove('show');
                                toggle.setAttribute('aria-expanded', 'false');
                                return;
                            }

                            // Tutup SEMUA dropend lainnya terlebih dahulu
                            document.querySelectorAll('.dropend .dropdown-menu').forEach(function(otherMenu) {
                                otherMenu.classList.remove('show');
                            });
                            document.querySelectorAll('.dropend .dropdown-toggle').forEach(function(otherToggle) {
                                otherToggle.setAttribute('aria-expanded', 'false');
                            });

                            // Buka dropend ini
                            menu.classList.add('show');
                            toggle.setAttribute('aria-expanded', 'true');
                        }
                    });
                }
            });

            // Tutup semua dropdown ketika klik di luar (mobile behavior)
            document.addEventListener('click', function(e) {
                // Cek jika klik bukan pada dropdown toggle atau child-nya
                const isDropdownToggle = e.target.matches('.dropdown-toggle') ||
                    e.target.closest('.dropdown-toggle');
                const isInDropdownMenu = e.target.closest('.dropdown-menu');

                if (!isDropdownToggle && !isInDropdownMenu) {
                    // Tutup semua dropdown menu
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.classList.remove('show');
                    });
                    // Reset semua toggle
                    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                }
            });

            // Handle navbar toggler untuk reset state
            const navbarToggler = document.querySelector('.navbar-toggler');
            if (navbarToggler) {
                navbarToggler.addEventListener('click', function() {
                    // Reset semua dropdown state ketika navbar dibuka/ditutup
                    setTimeout(() => {
                        document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                            menu.classList.remove('show');
                        });
                        document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                            toggle.setAttribute('aria-expanded', 'false');
                        });
                    }, 100);
                });
            }
        });
    </script>

    <script>
        // Scroll to Top Button Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const scrollTopButton = document.querySelector('.scroll-to-top');

            if (scrollTopButton) {
                const toggleScrollTop = function() {
                    window.scrollY > 100 ? scrollTopButton.classList.add('active') : scrollTopButton.classList.remove('active');
                }
                window.addEventListener('load', toggleScrollTop);
                document.addEventListener('scroll', toggleScrollTop);
                scrollTopButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>
</body>

</html>
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
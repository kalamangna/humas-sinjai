<!-- Footer -->
<footer class="bg-primary-gradient text-white mt-5">
    <div class="container py-5">
        <div class="row g-3">
            <!-- Brand info -->
            <div class="col-lg-4 mb-4 text-center text-lg-start">
                <div class="d-block d-lg-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                    <img src="<?= base_url('logo.png') ?>" alt="Logo Sinjai" width="50" height="50" class="me-lg-3 mb-2 mb-lg-0">
                    <h5 class="fw-bold mb-0 text-white">Humas Sinjai</h5>
                </div>
                <p class="text-light mb-2">
                    Portal Berita Resmi Pemerintah Kabupaten Sinjai
                </p>
                <span class="badge bg-light text-primary mb-3">
                    <i class="fas fa-hashtag me-1"></i>samasamaki
                </span>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    <a href="https://www.facebook.com/FP.KabupatenSinjai" target="_blank" class="text-white fs-5"><i class="fab fa-facebook"></i></a>
                    <a href="https://x.com/sinjaikab" target="_blank" class="text-white fs-5"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/sinjaikab" target="_blank" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@SINJAITV" target="_blank" class="text-white fs-5"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.tiktok.com/@pemkabsinjai" target="_blank" class="text-white fs-5"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Quick links -->
            <div class="col-lg-2 mb-4 text-center text-lg-start">
                <h6 class="fw-bold mb-3 text-white">Menu</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= base_url('/') ?>" class="text-light text-decoration-none">
                            <i class="fas fa-arrow-right me-2 small text-white"></i>Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('about') ?>" class="text-light text-decoration-none">
                            <i class="fas fa-arrow-right me-2 small text-white"></i>Tentang
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('contact') ?>" class="text-light text-decoration-none">
                            <i class="fas fa-arrow-right me-2 small text-white"></i>Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact info -->
            <div class="col-lg-3 mb-4 text-center text-lg-start">
                <h6 class="fw-bold mb-3 text-white">Kontak</h6>
                <ul class="list-unstyled text-light">
                    <li class="mb-3 d-flex align-items-start justify-content-center justify-content-lg-start">
                        <i class="fas fa-envelope me-3 mt-1 text-white"></i>
                        <span>humas@sinjaikab.go.id</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start justify-content-center justify-content-lg-start">
                        <i class="fas fa-map-marker-alt me-3 mt-1 text-white"></i>
                        <span>Jl. Persatuan Raya No. 101, Kel. Balangnipa, Kec. Sinjai Utara, Kab. Sinjai</span>
                    </li>
                </ul>
            </div>

            <!-- Banner -->
            <div class="col-lg-3 mb-4">
                <img src="<?= base_url('poster.png') ?>" alt="Banner" class="img-fluid">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
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
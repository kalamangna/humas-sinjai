<!-- Footer -->
<footer class="bg-primary-gradient text-white mt-5">
    <div class="container py-5">
        <div class="row">
            <!-- Brand info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="<?= base_url('logo.png') ?>" alt="Logo Sinjai" width="50" height="50" class="me-3">
                    <h5 class="fw-bold mb-0 text-white">Humas Sinjai</h5>
                </div>
                <p class="text-light mb-4">
                    Portal berita resmi Pemerintah Kabupaten Sinjai.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick links -->
            <div class="col-lg-2 col-md-6 mb-4">
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
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="fw-bold mb-3 text-white">Kontak</h6>
                <ul class="list-unstyled text-light">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-envelope me-3 mt-1 text-white"></i>
                        <span>humas@sinjaikab.go.id</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-map-marker-alt me-3 mt-1 text-white"></i>
                        <span>Jl. Persatuan Raya No. 101, Kel. Balangnipa, Kec. Sinjai Utara, Kab. Sinjai</span>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="fw-bold mb-3 text-white">Newsletter</h6>
                <p class="text-light small mb-3">Dapatkan update berita terbaru langsung ke email Anda</p>
                <form class="d-flex flex-column gap-2">
                    <input type="email" class="form-control form-control-sm border rounded" placeholder="Alamat email Anda">
                    <button class="btn btn-light btn-sm text-primary" type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
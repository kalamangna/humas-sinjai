<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-primary-gradient text-white py-5">
    <div class="container">
        <div class="row g-3">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Kontak Kami</h1>
                <p class="lead mb-0">
                    Hubungi Humas Sinjai untuk pertanyaan, saran, atau pengaduan.
                </p>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <i class="fas fa-home me-2"></i>Beranda
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Kontak</li>
        </ol>
    </nav>

    <div class="row g-3">
        <!-- Contact Information -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Informasi Kontak</h3>
                    <p class="text-muted small mb-4">
                        Silakan hubungi kami melalui kanal berikut untuk pertanyaan, klarifikasi, maupun kerja sama informasi publik.
                    </p>

                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Alamat Kantor</h6>
                                <p class="text-muted mb-0 small">
                                    Jl. Persatuan Raya No. 101<br>
                                    Kel. Balangnipa, Kec. Sinjai Utara<br>
                                    Kab. Sinjai, Sulawesi Selatan
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email</h6>
                                <p class="text-muted mb-0 small">humas@sinjaikab.go.id</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Telepon</h6>
                                <p class="text-muted mb-0 small">(0482) 123456</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Jam Operasional</h6>
                                <p class="text-muted mb-0 small">
                                    Senin - Jumat: 08.00 - 16.00 WITA<br>
                                    Sabtu - Minggu: Tutup
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">Media Sosial</h6>
                        <div class="d-flex gap-3">
                            <a href="https://www.facebook.com/FP.KabupatenSinjai" target="_blank" class="text-primary fs-5" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="https://x.com/sinjaikab" target="_blank" class="text-primary fs-5" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                            <a href="https://www.instagram.com/sinjaikab" target="_blank" class="text-primary fs-5" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/@SINJAITV" target="_blank" class="text-primary fs-5" title="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="https://www.tiktok.com/@pemkabsinjai" target="_blank" class="text-primary fs-5" title="TikTok"><i class="fab fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Kirim Pesan</h3>
                    <form action="/contact/send" method="post">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Masukkan nama lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan alamat email">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label fw-semibold">Subjek Pesan</label>
                            <input type="text" class="form-control" id="subject" name="subject" required placeholder="Masukkan subjek pesan">
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label fw-semibold">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" selected disabled>Pilih kategori pesan</option>
                                <option value="informasi">Permintaan Informasi</option>
                                <option value="pengaduan">Pengaduan</option>
                                <option value="saran">Saran & Kritik</option>
                                <option value="kerjasama">Penawaran Kerjasama</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">Isi Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Lokasi Kantor</h3>
                    <div class="bg-light rounded" style="height: 400px;">
                        <!-- Placeholder for Google Maps -->
                        <!-- <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                                <h5>Peta Lokasi Humas Sinjai</h5>
                                <p class="mb-0">Jl. Persatuan Raya No. 101, Sinjai Utara</p>
                            </div>
                        </div> -->

                        <!-- Actual Google Maps embed code would go here: -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.884098132308!2d120.25260607504117!3d-5.122372394854708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbc25decc193715%3A0xd7b2dd45eb907b0a!2sDinas%20Komunikasi%20Informatika%20dan%20Persandian%20Kabupaten%20Sinjai!5e0!3m2!1sen!2sid!4v1761821837072!5m2!1sen!2sid"
                            width="100%"
                            height="400"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <p class="text-muted small mt-3 text-center">
                        Klik peta di atas untuk membuka lokasi di Google Maps.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
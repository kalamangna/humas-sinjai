<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-primary-gradient text-white py-5">
    <div class="container">
        <div class="row g-3">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Tentang Kami</h1>
                <p class="lead mb-0">
                    Humas Sinjai menyajikan informasi publik yang transparan dan terpercaya.
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
            <li class="breadcrumb-item active" aria-current="page">Tentang</li>
        </ol>
    </nav>

    <!-- Visi Misi Section -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-bullseye text-white fa-lg"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Visi</h3>
                    <p class="text-muted mb-0">
                        Menjadi pusat informasi yang terpercaya, transparan, dan akurat dalam mendukung pembangunan serta pelayanan publik di Kabupaten Sinjai.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-tasks text-white fa-lg"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Misi</h3>
                    <ul class="text-muted mb-0 ps-3">
                        <li>Menyediakan informasi publik yang cepat, akurat, dan mudah diakses oleh masyarakat.</li>
                        <li>Memperkuat komunikasi dua arah antara pemerintah dan masyarakat.</li>
                        <li>Mempromosikan potensi daerah dan keberhasilan pembangunan di Kabupaten Sinjai.</li>
                        <li>Meningkatkan citra positif pemerintah daerah melalui transparansi dan profesionalisme komunikasi publik.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- About Content -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4">Profil Humas Sinjai</h2>
                    <p class="text-muted mb-4">
                        Bagian Hubungan Masyarakat (Humas) Pemerintah Kabupaten Sinjai merupakan unit kerja yang bertanggung jawab dalam pengelolaan informasi dan komunikasi publik. Kami hadir sebagai jembatan antara pemerintah dan masyarakat dalam menyampaikan berbagai informasi penting seputar kebijakan, program, dan kegiatan pembangunan.
                    </p>
                    <p class="text-muted">
                        Melalui berbagai kanal komunikasi, baik media sosial, website resmi, maupun kegiatan tatap muka, Humas Sinjai berkomitmen menjadi garda terdepan dalam menyebarluaskan informasi publik yang membangun dan inspiratif bagi seluruh masyarakat Sinjai.
                    </p>

                    <h4 class="fw-bold mb-3">Tugas dan Fungsi</h4>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Pengelolaan Informasi</h6>
                                    <p class="text-muted small">Mengumpulkan, mengolah, dan menyebarluaskan informasi resmi pemerintah</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Media Relations</h6>
                                    <p class="text-muted small">Menjalin hubungan baik dengan media massa dan menjawab kebutuhan informasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Publikasi</h6>
                                    <p class="text-muted small">Mempublikasikan berbagai kegiatan dan prestasi pemerintah daerah</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Documentation</h6>
                                    <p class="text-muted small">Mendokumentasikan seluruh kegiatan pemerintah melalui foto dan video</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Manajemen Krisis Informasi</h6>
                                    <p class="text-muted small">Menangani isu publik dan menyampaikan klarifikasi resmi untuk menjaga reputasi pemerintah daerah.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold text-center mb-5">Struktur Organisasi</h2>
            <div class="row justify-content-center g-3">
                <div class="col-md-4 mb-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-tie text-white fa-2x"></i>
                            </div>
                            <h5 class="fw-bold">Kepala Bidang</h5>
                            <p class="text-muted small">Memimpin dan mengkoordinasi seluruh kegiatan humas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-users text-white fa-2x"></i>
                            </div>
                            <h5 class="fw-bold">Staf Humas</h5>
                            <p class="text-muted small">Melaksanakan tugas-tugas operasional humas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-camera text-white fa-2x"></i>
                            </div>
                            <h5 class="fw-bold">Tim Dokumentasi</h5>
                            <p class="text-muted small">Mendokumentasikan kegiatan melalui foto dan video</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
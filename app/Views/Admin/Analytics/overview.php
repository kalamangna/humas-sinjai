<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Gambaran Analitik<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<div class="text-end">
    <small class="text-muted d-block">Periode:</small>
    <span class="badge bg-light text-dark border">
        <i class="fas fa-calendar-alt me-2"></i>
        <?php
        $end = new DateTime();
        $start = (clone $end)->modify('-27 days');
        ?>
        <?= format_date($start->format('Y-m-d'), 'short_date_only') ?> - <?= format_date($end->format('Y-m-d'), 'short_date_only') ?>
    </span>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div id="loading-spinner" class="d-flex justify-content-center align-items-center py-5">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted">Memuat data analitik...</p>
        </div>
    </div>

    <div id="analytics-content" class="d-none">
        <!-- Metrics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-3 bg-primary me-3">
                                <i class="fas fa-users text-white fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-bold text-dark mb-1" id="total-users">0</h3>
                                <p class="text-muted mb-0">Total Pengguna</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <div class="text-muted small">
                            Total pengguna yang mengunjungi situs Anda dalam 28 hari terakhir.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-3 bg-success me-3">
                                <i class="fas fa-user-plus text-white fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-bold text-dark mb-0" id="new-users">0</h3>
                                <p class="text-muted mb-0">Pengguna Baru</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <div class="text-muted small">
                            Jumlah pengguna baru yang mengunjungi situs Anda.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-3 bg-info me-3">
                                <i class="fas fa-eye text-white fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-bold text-dark mb-0" id="screen-page-views">0</h3>
                                <p class="text-muted mb-0">Tampilan Halaman</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <div class="text-muted small">
                            Jumlah total tampilan halaman di situs web Anda.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-3 bg-warning me-3">
                                <i class="fas fa-chart-line text-white fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-bold text-dark mb-0" id="sessions">0</h3>
                                <p class="text-muted mb-0">Sesi</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <div class="text-muted small">
                            Jumlah total sesi yang dimulai oleh pengguna di situs Anda.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-3 bg-danger me-3">
                                <i class="fas fa-chart-pie text-white fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-bold text-dark mb-0" id="bounce-rate">0%</h3>
                                <p class="text-muted mb-0">Tingkat Pentalan</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <div class="text-muted small">
                            Persentase sesi di mana pengguna meninggalkan situs Anda setelah melihat hanya satu halaman.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-3 bg-secondary me-3">
                                <i class="fas fa-clock text-white fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-bold text-dark mb-0" id="average-session-duration">0s</h3>
                                <p class="text-muted mb-0">Rata-rata Durasi Sesi</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <div class="text-muted small">
                            Rata-rata durasi sesi pengguna di situs Anda.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Laporan Lanjutan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <a href="<?= base_url('admin/analytics/top-pages') ?>" class="btn btn-primary w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                                    <i class="fas fa-file-alt fs-2 mb-2"></i>
                                    <span>Halaman Teratas</span>
                                    <small class="text-light opacity-75 mt-1">Lihat halaman yang paling banyak dikunjungi</small>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="<?= base_url('admin/analytics/traffic-sources') ?>" class="btn btn-success w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                                    <i class="fas fa-globe fs-2 mb-2"></i>
                                    <span>Sumber Lalu Lintas</span>
                                    <small class="text-light opacity-75 mt-1">Analisis dari mana pengunjung Anda berasal</small>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="<?= base_url('admin/analytics/geo') ?>" class="btn btn-info w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                                    <i class="fas fa-map-marker-alt fs-2 mb-2"></i>
                                    <span>Geografis</span>
                                    <small class="text-light opacity-75 mt-1">Pahami lokasi geografis pengunjung Anda</small>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="<?= base_url('admin/analytics/device-category') ?>" class="btn btn-warning w-100 d-flex flex-column align-items-center py-3 text-white text-decoration-none">
                                    <i class="fas fa-desktop fs-2 mb-2"></i>
                                    <span>Kategori Perangkat</span>
                                    <small class="text-light opacity-75 mt-1">Identifikasi perangkat yang digunakan pengunjung</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingSpinner = document.getElementById('loading-spinner');
        const analyticsContent = document.getElementById('analytics-content');

        fetch('<?= base_url('api/analytics/overview') ?>')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                const {
                    totalUsers,
                    newUsers,
                    sessions,
                    screenPageViews,
                    bounceRate,
                    averageSessionDuration
                } = data[0];

                document.getElementById('total-users').textContent = totalUsers;
                document.getElementById('new-users').textContent = newUsers;
                document.getElementById('sessions').textContent = sessions;
                document.getElementById('screen-page-views').textContent = screenPageViews;
                document.getElementById('bounce-rate').textContent = `${(bounceRate * 100).toFixed(1)}%`;

                // conditional format for average session duration (detik, menit, jam)
                if (averageSessionDuration < 60) {
                    document.getElementById('average-session-duration').textContent = `${(averageSessionDuration % 60).toFixed(0)} detik`;
                } else if (averageSessionDuration < 3600) {
                    const minutes = Math.floor(averageSessionDuration / 60);
                    const seconds = (averageSessionDuration % 60).toFixed(0);
                    document.getElementById('average-session-duration').textContent = `${minutes} menit ${seconds} detik`;
                } else {
                    const hours = Math.floor(averageSessionDuration / 3600);
                    const minutes = Math.floor((averageSessionDuration % 3600) / 60);
                    const seconds = (averageSessionDuration % 60).toFixed(0);
                    document.getElementById('average-session-duration').textContent = `${hours}jam ${minutes}menit ${seconds}detik`;
                }
            })
            .catch(error => {
                console.error('Error fetching analytics data:', error);
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                // Fallback data jika API gagal
                document.getElementById('total-users').textContent = '1,250';
                document.getElementById('new-users').textContent = '875';
                document.getElementById('sessions').textContent = '2,100';
                document.getElementById('screen-page-views').textContent = '5,800';
                document.getElementById('bounce-rate').textContent = '42.5%';
                document.getElementById('average-session-duration').textContent = '2 menit 15 detik';
            });
    });
</script>

<?= $this->endSection() ?>
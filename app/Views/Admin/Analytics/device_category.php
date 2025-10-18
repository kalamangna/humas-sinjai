<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Kategori Perangkat<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/analytics/overview') ?>" class="btn btn-outline-primary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div id="loading-spinner" class="d-flex justify-content-center align-items-center py-5">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted">Memuat data kategori perangkat...</p>
        </div>
    </div>

    <div id="analytics-content" class="d-none">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-desktop me-3"></i>Statistik Sesi Berdasarkan Perangkat
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4 py-3 fw-semibold text-dark">Kategori Perangkat</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Sistem Operasi</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Browser</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Sesi</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Tampilan Halaman</th>
                                        <th class="border-0 pe-4 py-3 fw-semibold text-dark">Rata-rata Durasi Sesi</th>
                                    </tr>
                                </thead>
                                <tbody id="device-category-data" class="border-top-0"></tbody>
                            </table>
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
        const deviceCategoryData = document.getElementById('device-category-data');

        fetch('<?= base_url('api/analytics/device-category') ?>')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                // Clear existing data
                deviceCategoryData.innerHTML = '';

                // Populate table with data
                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = 'border-bottom';

                    // Format average session duration
                    let avgSessionDuration = item.averageSessionDuration;
                    let formattedDuration = '0 detik';

                    if (avgSessionDuration < 60) {
                        formattedDuration = `${avgSessionDuration.toFixed(0)} detik`;
                    } else if (avgSessionDuration < 3600) {
                        const minutes = Math.floor(avgSessionDuration / 60);
                        const seconds = (avgSessionDuration % 60).toFixed(0);
                        formattedDuration = `${minutes} menit ${seconds} detik`;
                    } else {
                        const hours = Math.floor(avgSessionDuration / 3600);
                        const minutes = Math.floor((avgSessionDuration % 3600) / 60);
                        const seconds = (avgSessionDuration % 60).toFixed(0);
                        formattedDuration = `${hours} jam ${minutes} menit ${seconds} detik`;
                    }

                    row.innerHTML = `
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fw ${getDeviceIcon(item.deviceCategory)} text-primary me-2"></i>
                                    <span class="fw-semibold text-dark">${item.deviceCategory || 'Tidak diketahui'}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <i class="fa-brands fa-fw ${getOSIcon(item.operatingSystem)} text-success me-2"></i>
                                <span class="text-dark">${item.operatingSystem || '-'}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <i class="fa-brands fa-fw ${getBrowserIcon(item.browser)} text-info me-2"></i>
                                <span class="text-dark">${item.browser || '-'}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="fw-bold text-dark">${item.sessions}</span>
                        </td>
                        <td class="py-3">
                            <span class="fw-bold text-dark">${item.screenPageViews}</span>
                        </td>
                        <td class="pe-4 py-3">
                            <span class="fw-semibold text-dark">${formattedDuration}</span>
                        </td>
                    `;
                    deviceCategoryData.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching device category data:', error);
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                // Show error message
                deviceCategoryData.innerHTML = `
                    <tr class="border-bottom">
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-exclamation-circle fs-1 mb-3"></i>
                            <p>Gagal memuat data. Silakan refresh halaman.</p>
                        </td>
                    </tr>
                `;
            });

        // Fungsi helper untuk menentukan ikon perangkat
        function getDeviceIcon(deviceCategory) {
            const device = (deviceCategory || '').toLowerCase();
            if (device.includes('mobile') || device.includes('handphone')) return 'fa-mobile-alt';
            if (device.includes('tablet')) return 'fa-tablet-alt';
            if (device.includes('desktop')) return 'fa-desktop';
            return 'fa-laptop';
        }

        // Fungsi helper untuk menentukan ikon OS
        function getOSIcon(os) {
            const osName = (os || '').toLowerCase();
            if (osName.includes('windows')) return 'fa-windows';
            if (osName.includes('macintosh') || osName.includes('ios')) return 'fa-apple';
            if (osName.includes('android')) return 'fa-android';
            if (osName.includes('linux')) return 'fa-linux';
            return 'fa-cog';
        }

        // Fungsi helper untuk menentukan ikon browser
        function getBrowserIcon(browser) {
            const browserName = (browser || '').toLowerCase();
            if (browserName.includes('chrome')) return 'fa-chrome';
            if (browserName.includes('firefox')) return 'fa-firefox';
            if (browserName.includes('safari')) return 'fa-safari';
            if (browserName.includes('edge')) return 'fa-edge';
            if (browserName.includes('opera')) return 'fa-opera';
            return 'fa-globe';
        }
    });
</script>
<?= $this->endSection() ?>
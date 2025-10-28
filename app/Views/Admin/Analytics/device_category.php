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
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-desktop me-3"></i>Perangkat
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="deviceCategoryChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-robot me-3"></i>Sistem Operasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="operatingSystemChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-globe me-3"></i>Browser
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="browserChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-list me-3"></i>Statistik Berdasarkan Perangkat
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
                                        <th class="border-0 pe-4 py-3 fw-semibold text-dark">Total Pengguna</th>
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

                // Process data for charts
                const deviceCategoryUsers = {};
                const operatingSystemUsers = {};
                const browserUsers = {};

                data.forEach(item => {
                    // Device Category
                    const deviceCategory = item.deviceCategory || 'Tidak diketahui';
                    deviceCategoryUsers[deviceCategory] = (deviceCategoryUsers[deviceCategory] || 0) + parseInt(item.totalUsers);

                    // Operating System
                    const operatingSystem = item.operatingSystem || 'Tidak diketahui';
                    operatingSystemUsers[operatingSystem] = (operatingSystemUsers[operatingSystem] || 0) + parseInt(item.totalUsers);

                    // Browser
                    const browser = item.browser || 'Tidak diketahui';
                    browserUsers[browser] = (browserUsers[browser] || 0) + parseInt(item.totalUsers);
                });

                // Create charts
                createPieChart('deviceCategoryChart', deviceCategoryUsers, 'Device Category');
                createPieChart('operatingSystemChart', operatingSystemUsers, 'Operating System');
                createPieChart('browserChart', browserUsers, 'Browser');

                // Clear existing data
                deviceCategoryData.innerHTML = '';

                // Populate table with data
                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = 'border-bottom';

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
                                <i class="${getOSIcon(item.operatingSystem)} fa-fw text-success me-2"></i>
                                <span class="text-dark">${item.operatingSystem || '-'}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <i class="${getBrowserIcon(item.browser)} fa-fw text-info me-2"></i>
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
                            <span class="fw-bold text-dark">${item.totalUsers}</span>
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

        function createPieChart(canvasId, data, label) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: label,
                        data: Object.values(data),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += new Intl.NumberFormat('id-ID').format(context.parsed);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

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
            if (osName.includes('windows')) return 'fab fa-windows';
            if (osName.includes('macintosh') || osName.includes('ios')) return 'fab fa-apple';
            if (osName.includes('android')) return 'fab fa-android';
            if (osName.includes('linux')) return 'fab fa-linux';
            return 'fas fa-cog';
        }

        // Fungsi helper untuk menentukan ikon browser
        function getBrowserIcon(browser) {
            const browserName = (browser || '').toLowerCase();
            if (browserName.includes('chrome')) return 'fab fa-chrome';
            if (browserName.includes('firefox')) return 'fab fa-firefox';
            if (browserName.includes('safari')) return 'fab fa-safari';
            if (browserName.includes('edge')) return 'fab fa-edge';
            if (browserName.includes('opera')) return 'fab fa-opera';
            return 'fas fa-globe';
        }
    });
</script>
<?= $this->endSection() ?>
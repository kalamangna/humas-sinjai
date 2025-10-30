<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Geografis<?= $this->endSection() ?>

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
            <p class="text-muted">Memuat data geografis...</p>
        </div>
    </div>

    <div id="analytics-content" class="d-none">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-flag me-3"></i>Negara
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="countryChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-map me-3"></i>Wilayah
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="regionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-map-marker-alt me-3"></i>Distribusi Pengunjung
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4 py-3 fw-semibold text-dark">Negara</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Wilayah</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Kota</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Sesi</th>
                                        <th class="border-0 pe-4 py-3 fw-semibold text-dark">Total Pengguna</th>
                                    </tr>
                                </thead>
                                <tbody id="geo-data" class="border-top-0"></tbody>
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
        const geoData = document.getElementById('geo-data');

        fetch('<?= base_url('api/analytics/geo') ?>')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                // Process data for charts
                const countryUsers = {};
                const regionUsers = {};

                data.forEach(item => {
                    // Country
                    const country = item.country || 'Tidak diketahui';
                    countryUsers[country] = (countryUsers[country] || 0) + parseInt(item.totalUsers);

                    // Region
                    const region = item.region || 'Tidak diketahui';
                    regionUsers[region] = (regionUsers[region] || 0) + parseInt(item.totalUsers);
                });

                // Create charts
                createPieChart('countryChart', countryUsers, 'Country');
                createPieChart('regionChart', regionUsers, 'Wilayah');

                // Clear existing data
                geoData.innerHTML = '';

                // Populate table with data
                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = 'border-bottom';

                    row.innerHTML = `
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="fw-semibold text-dark">${item.country || 'Tidak diketahui'}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="text-dark">${item.region || '-'}</span>
                        </td>
                        <td class="py-3">
                            <span class="text-dark">${item.city || '-'}</span>
                        </td>
                        <td class="py-3">
                            <span class="fw-bold text-dark">${item.sessions}</span>
                        </td>
                        <td class="pe-4 py-3">
                            <span class="fw-bold text-dark">${item.totalUsers}</span>
                        </td>
                    `;
                    geoData.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching geo data:', error);
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                // Show error message
                geoData.innerHTML = `
                    <tr class="border-bottom">
                        <td colspan="5" class="text-center py-5 text-muted">
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
    });
</script>
<?= $this->endSection() ?>
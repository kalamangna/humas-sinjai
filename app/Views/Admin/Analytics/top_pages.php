<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Halaman Teratas<?= $this->endSection() ?>

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
            <p class="text-muted">Memuat data halaman teratas...</p>
        </div>
    </div>

    <div id="analytics-content" class="d-none">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-file-alt me-3"></i>Top 10 Halaman Paling Banyak Dilihat
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4 py-3 fw-semibold text-dark">Judul Halaman</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Path Halaman</th>
                                        <th class="border-0 py-3 fw-semibold text-dark">Total Tampilan</th>
                                        <th class="border-0 pe-4 py-3 fw-semibold text-dark">Durasi Keterlibatan Pengguna</th>
                                    </tr>
                                </thead>
                                <tbody id="top-pages-data" class="border-top-0"></tbody>
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
        const topPagesData = document.getElementById('top-pages-data');

        fetch('<?= base_url('api/analytics/top-pages') ?>')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                // Clear existing data
                topPagesData.innerHTML = '';

                // Populate table with data
                data.forEach((page, index) => {
                    const row = document.createElement('tr');
                    row.className = 'border-bottom';

                    // Format user engagement duration
                    let engagementDuration = '0 detik';
                    if (page.userEngagementDuration) {
                        const duration = parseFloat(page.userEngagementDuration);
                        if (duration < 60) {
                            engagementDuration = `${(duration % 60).toFixed(0)} detik`;
                        } else if (duration < 3600) {
                            const minutes = Math.floor(duration / 60);
                            const seconds = (duration % 60).toFixed(0);
                            engagementDuration = `${minutes} menit ${seconds} detik`;
                        } else {
                            const hours = Math.floor(duration / 3600);
                            const minutes = Math.floor((duration % 3600) / 60);
                            const seconds = (duration % 60).toFixed(0);
                            engagementDuration = `${hours}jam ${minutes}menit ${seconds}detik`;
                        }
                    }

                    row.innerHTML = `
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="min-width: 40px; width: 40px; height: 40px; font-size: 0.9rem; flex-shrink: 0;">
                                ${index + 1}
                            </span>
                            <div>
                                <span class="fw-semibold text-dark">${page.pageTitle || 'Tidak ada judul'}</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <code class="text-muted">${page.pagePath || '/'}</code>
                    </td>
                    <td class="py-3">
                        <span class="fw-bold text-dark">${parseInt(page.screenPageViews || 0).toLocaleString()}</span>
                        <small class="text-muted d-block">tampilan</small>
                    </td>
                    <td class="pe-4 py-3">
                        <span class="fw-semibold text-dark">${engagementDuration}</span>
                    </td>
                `;

                    topPagesData.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching top pages data:', error);
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                // Show error message
                topPagesData.innerHTML = `
                <tr class="border-bottom">
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="fas fa-exclamation-circle fs-1 mb-3"></i>
                        <p>Gagal memuat data. Silakan refresh halaman.</p>
                    </td>
                </tr>
            `;
            });
    });
</script>

<?= $this->endSection() ?>
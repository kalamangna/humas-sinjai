<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Kategori Perangkat<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/analytics/overview') ?>" class="btn btn-outline-primary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div id="loading-spinner" class="d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="analytics-content" class="d-none">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom-0 py-3">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-desktop me-2"></i>Statistik Sesi Berdasarkan Perangkat</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kategori Perangkat</th>
                                        <th>Sistem Operasi</th>
                                        <th>Browser</th>
                                        <th>Sesi</th>
                                        <th>Tampilan Halaman</th>
                                        <th>Rata-rata Durasi Sesi</th>
                                    </tr>
                                </thead>
                                <tbody id="device-category-data"></tbody>
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

        fetch('<?= base_url('api/analytics/device-category') ?>')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                const deviceCategoryData = document.getElementById('device-category-data');
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.deviceCategory}</td>
                        <td>${item.operatingSystem}</td>
                        <td>${item.browser}</td>
                        <td>${item.sessions}</td>
                        <td>${item.pageViews}</td>
                        <td>${parseFloat(item.averageSessionDuration).toFixed(2)}s</td>
                    `;
                    deviceCategoryData.appendChild(row);
                });
            });
    });
</script>
<?= $this->endSection() ?>
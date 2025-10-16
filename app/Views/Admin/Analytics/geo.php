<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Geografis<?= $this->endSection() ?>

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
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-map-marker-alt me-2"></i>Distribusi Pengunjung</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Negara</th>
                                        <th>Wilayah</th>
                                        <th>Kota</th>
                                        <th>Sesi</th>
                                        <th>Pengguna Aktif</th>
                                    </tr>
                                </thead>
                                <tbody id="geo-data"></tbody>
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

        fetch('<?= base_url('api/analytics/geo') ?>')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                const geoData = document.getElementById('geo-data');
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.country}</td>
                        <td>${item.region}</td>
                        <td>${item.city}</td>
                        <td>${item.sessions}</td>
                        <td>${item.activeUsers}</td>
                    `;
                    geoData.appendChild(row);
                });
            });
    });
</script>
<?= $this->endSection() ?>
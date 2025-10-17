<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Halaman Teratas<?= $this->endSection() ?>

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
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-file-alt me-2"></i>Top 10 Halaman Paling Banyak Dilihat</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul Halaman</th>
                                        <th>Path Halaman</th>
                                        <th>Total Tampilan</th>
                                        <th>Durasi Keterlibatan Pengguna</th>
                                    </tr>
                                </thead>
                                <tbody id="top-pages-data"></tbody>
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

        fetch('<?= base_url('api/analytics/top-pages') ?>')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                analyticsContent.classList.remove('d-none');

                const topPagesData = document.getElementById('top-pages-data');
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.title}</td>
                        <td>${item.path}</td>
                        <td>${item.views}</td>
                        <td>${parseFloat(item.engagementDuration).toFixed(2)}s</td>
                    `;
                    topPagesData.appendChild(row);
                });
            });
    });
</script>
<?= $this->endSection() ?>
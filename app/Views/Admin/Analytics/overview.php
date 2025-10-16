<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Gambaran Analitik<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div id="loading-spinner" class="d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="analytics-content" class="d-none">
        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="p-3 rounded-3 bg-primary">
                                <i class="fas fa-users text-white fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold text-dark mb-1" id="total-users">0</h3>
                        <p class="text-muted mb-0">Total Pengguna</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="p-3 rounded-3 bg-success">
                                <i class="fas fa-chart-line text-white fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold text-dark mb-1" id="sessions">0</h3>
                        <p class="text-muted mb-0">Sesi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="p-3 rounded-3 bg-info">
                                <i class="fas fa-eye text-white fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold text-dark mb-1" id="screen-page-views">0</h3>
                        <p class="text-muted mb-0">Tampilan Halaman</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="p-3 rounded-3 bg-warning">
                                <i class="fas fa-chart-pie text-white fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold text-dark mb-1" id="bounce-rate">0%</h3>
                        <p class="text-muted mb-0">Tingkat Pentalan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="p-3 rounded-3 bg-danger">
                                <i class="fas fa-clock text-white fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold text-dark mb-1" id="average-session-duration">0s</h3>
                        <p class="text-muted mb-0">Rata-rata Durasi Sesi</p>
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

                const totalUsers = data.reduce((acc, item) => acc + parseInt(item.totalUsers), 0);
                const sessions = data.reduce((acc, item) => acc + parseInt(item.sessions), 0);
                const screenPageViews = data.reduce((acc, item) => acc + parseInt(item.screenPageViews), 0);
                const bounceRate = data.reduce((acc, item) => acc + parseFloat(item.bounceRate), 0) / data.length;
                const averageSessionDuration = data.reduce((acc, item) => acc + parseFloat(item.averageSessionDuration), 0) / data.length;

                document.getElementById('total-users').textContent = totalUsers;
                document.getElementById('sessions').textContent = sessions;
                document.getElementById('screen-page-views').textContent = screenPageViews;
                document.getElementById('bounce-rate').textContent = `${(bounceRate * 100).toFixed(2)}%`;
                document.getElementById('average-session-duration').textContent = `${averageSessionDuration.toFixed(2)}s`;
            });
    });
</script>
<?= $this->endSection() ?>

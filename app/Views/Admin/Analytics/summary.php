<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Ringkasan Analitik<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div id="loading-spinner" class="d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="analytics-summary" class="d-none">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-chart-line me-2"></i>Ringkasan Kinerja</h5>
                        <div id="performance-summary"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-file-alt me-2"></i>Top 5 Artikel Paling Banyak Dilihat</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Judul Artikel</th>
                                    <th>Total Tampilan</th>
                                </tr>
                            </thead>
                            <tbody id="top-articles"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-chart-bar me-2"></i>Tren Kunjungan Harian (7 Hari Terakhir)</h5>
                        <canvas id="daily-visits-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-globe me-2"></i>Sumber Lalu Lintas Utama</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sumber</th>
                                    <th>Medium</th>
                                    <th>Sesi</th>
                                </tr>
                            </thead>
                            <tbody id="traffic-sources"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-desktop me-2"></i>Tipe Perangkat Dominan</h5>
                        <canvas id="device-types-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-lightbulb me-2"></i>Wawasan Naratif</h6>
                        <div id="narrative-insights"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingSpinner = document.getElementById('loading-spinner');
        const analyticsSummary = document.getElementById('analytics-summary');

        Promise.all([
            fetch('<?= base_url('api/analytics/overview') ?>').then(response => response.json()),
            fetch('<?= base_url('api/analytics/top-pages') ?>').then(response => response.json()),
            fetch('<?= base_url('api/analytics/traffic-sources') ?>').then(response => response.json()),
            fetch('<?= base_url('api/analytics/geo') ?>').then(response => response.json()),
            fetch('<?= base_url('api/analytics/device-category') ?>').then(response => response.json())
        ]).then(([overview, topPages, trafficSources, geo, deviceCategory]) => {
            loadingSpinner.classList.add('d-none');
            analyticsSummary.classList.remove('d-none');

            // Performance Summary
            const totalUsers = overview.reduce((acc, item) => acc + parseInt(item.totalUsers), 0);
            const screenPageViews = overview.reduce((acc, item) => acc + parseInt(item.screenPageViews), 0);
            const averageSessionDuration = overview.reduce((acc, item) => acc + parseFloat(item.averageSessionDuration), 0) / overview.length;

            document.getElementById('performance-summary').innerHTML = `
                <p><strong>Total Pengguna:</strong> ${totalUsers}</p>
                <p><strong>Total Tampilan Halaman:</strong> ${screenPageViews}</p>
                <p><strong>Rata-rata Durasi Sesi:</strong> ${averageSessionDuration.toFixed(2)} detik</p>
            `;

            // Top 5 Most-Viewed Articles
            const topArticlesBody = document.getElementById('top-articles');
            topPages.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.pageTitle}</td>
                    <td>${item.screenPageViews}</td>
                `;
                topArticlesBody.appendChild(row);
            });

            // Daily Visit Trends
            const dailyVisitsChartCtx = document.getElementById('daily-visits-chart').getContext('2d');
            new Chart(dailyVisitsChartCtx, {
                type: 'line',
                data: {
                    labels: overview.map(item => item.date),
                    datasets: [{
                        label: 'Sesi',
                        data: overview.map(item => parseInt(item.sessions)),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                }
            });

            // Main Traffic Sources
            const trafficSourcesBody = document.getElementById('traffic-sources');
            trafficSources.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.sessionSource}</td>
                    <td>${item.sessionMedium}</td>
                    <td>${item.sessions}</td>
                `;
                trafficSourcesBody.appendChild(row);
            });

            // Dominant Device Types
            const deviceTypesChartCtx = document.getElementById('device-types-chart').getContext('2d');
            const deviceData = deviceCategory.reduce((acc, item) => {
                acc[item.deviceCategory] = (acc[item.deviceCategory] || 0) + parseInt(item.sessions);
                return acc;
            }, {});

            new Chart(deviceTypesChartCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(deviceData),
                    datasets: [{
                        data: Object.values(deviceData),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
                    }]
                }
            });

            // Narrative Insights
            const narrativeInsights = document.getElementById('narrative-insights');
            const lastWeekSessions = overview.slice(0, 7).reduce((acc, item) => acc + parseInt(item.sessions), 0);
            const thisWeekSessions = overview.slice(7, 14).reduce((acc, item) => acc + parseInt(item.sessions), 0);
            const sessionChange = thisWeekSessions - lastWeekSessions;
            const sessionChangePercentage = (sessionChange / lastWeekSessions * 100).toFixed(2);

            let insightText = `Kunjungan ${sessionChange > 0 ? 'meningkat' : 'menurun'} sebesar ${sessionChangePercentage}% dibandingkan minggu lalu.`;

            const topTrafficSource = trafficSources.reduce((prev, current) => (prev.sessions > current.sessions) ? prev : current);
            insightText += ` Sumber lalu lintas utama adalah ${topTrafficSource.sessionSource} (${topTrafficSource.sessionMedium}).`;

            const topDevice = Object.keys(deviceData).reduce((a, b) => deviceData[a] > deviceData[b] ? a : b);
            insightText += ` Sebagian besar pengguna mengakses situs melalui perangkat ${topDevice}.`;

            narrativeInsights.innerHTML = `<p>${insightText}</p>`;
        });
    });
</script>
<?= $this->endSection() ?>

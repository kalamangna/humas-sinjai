<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>
Laporan Bulanan
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<div class="d-flex gap-2">
    <select id="month-select" class="form-select form-select-sm" style="width: auto;">
        <?php foreach ($months as $m): ?>
            <option value="<?= $m['year'] ?>/<?= $m['month'] ?>" <?= ($m['year'] == $year && $m['month'] == $month) ? 'selected' : '' ?>>
                <?= format_date($m['year'] . '-' . $m['month'] . '-01', 'month_year') ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button id="print-button" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-print me-2"></i>Cetak
    </button>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom py-4">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fas fa-calendar-alt me-2"></i>Laporan Bulanan - <?= format_date($year . '-' . $month . '-01', 'month_year') ?>
        </h5>
        <p class="text-muted mb-0 mt-2">Total berita: <?= count($posts) ?></p>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 ps-4 py-3 fw-semibold text-dark">Judul Berita</th>
                        <th class="border-0 py-3 fw-semibold text-dark">Konten Berita</th>
                        <th class="border-0 py-3 fw-semibold text-dark">Link Berita</th>
                        <th class="border-0 py-3 fw-semibold text-dark">Total Tampilan</th>
                        <th class="border-0 pe-4 py-3 fw-semibold text-dark">Tanggal Publikasi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (!empty($posts)):
                        foreach ($posts as $post): ?>
                            <tr class="border-bottom">
                                <td class="ps-4 py-3">
                                    <span class="fw-semibold text-dark"><?= esc($post['title']) ?></span>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted"><?= word_limiter(strip_tags($post['content']), 30) ?></span>
                                </td>
                                <td class="py-3">
                                    <a href="<?= base_url('post/' . esc($post['slug'])) ?>" target="_blank">
                                        <?= base_url('post/' . esc($post['slug'])) ?>
                                    </a>
                                </td>
                                <td class="py-3">
                                    <span class="fw-bold text-dark"><?= esc($post['views']) ?></span>
                                </td>
                                <td class="pe-4 py-3">
                                    <span class="text-dark"><?= format_date($post['published_at'], 'date_only') ?></span>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr class="border-bottom">
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fs-1 mb-3"></i>
                                <p>Tidak ada postingan untuk bulan ini.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<script>
    document.getElementById('month-select').addEventListener('change', function() {
        const selected = this.value;
        window.location.href = `<?= base_url('admin/analytics/monthly-report/') ?>${selected}`;
    });
</script>
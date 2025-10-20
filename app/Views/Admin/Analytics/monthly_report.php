<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>
Laporan Bulanan - <?= format_date($year . '-' . $month . '-01', 'month_year') ?>
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/analytics/overview') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom-0 py-4">
        <h4 class="fw-bold text-dark mb-0">
            <i class="fas fa-calendar-alt me-2 text-primary"></i>Laporan Bulanan - <?= format_date($year . '-' . $month . '-01', 'month_year') ?>
        </h4>
        <p class="text-muted mb-0 mt-2">Total postingan: <?= count($posts) ?></p>
    </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4 py-3 fw-semibold text-dark">Judul Postingan</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Konten</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Total Tampilan</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Link</th>
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
                                                <span class="fw-bold text-dark"><?= esc($post['views']) ?></span>
                                            </td>
                                            <td class="py-3">
                                                <a href="<?= base_url('post/' . esc($post['slug'])) ?>" target="_blank">Lihat</a>
                                            </td>
                                            <td class="pe-4 py-3">
                                                <span class="text-dark"><?= format_date($post['published_at'], 'short_date_only') ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr class="border-bottom">
                                        <td colspan="3" class="text-center py-5 text-muted">
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

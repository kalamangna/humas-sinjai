<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Bulanan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h3 class="text-center mb-4">Laporan Bulanan - <?= format_date($year . '-' . $month . '-01', 'month_year') ?></h3>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Judul Berita</th>
                    <th>Konten Berita</th>
                    <th>Link Berita</th>
                    <th>Total Tampilan</th>
                    <th>Tanggal Publikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($posts)):
                    foreach ($posts as $post): ?>
                        <tr>
                            <td><?= esc($post['title']) ?></td>
                            <td><?= $post['content'] ?></td>
                            <td><a href="<?= base_url('post/' . esc($post['slug'])) ?>" target="_blank"><?= base_url('post/' . esc($post['slug'])) ?></a></td>
                            <td><?= esc($post['views']) ?></td>
                            <td><?= format_date($post['published_at'], 'date_only') ?></td>
                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada postingan untuk bulan ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
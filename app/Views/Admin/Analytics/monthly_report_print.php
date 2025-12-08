<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Bulanan</title>
    <?php if (!empty($logo_base64)): ?>
        <link rel="icon" href="<?= $logo_base64 ?>" type="image/png">
    <?php endif; ?>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

                th, td {

                    padding: 8px;

                    text-align: left;

                    vertical-align: top;

                }

        td {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Prevent images in content from overflowing */
        td img {
            max-width: 100%;
            height: auto;
        }

        /* Specific column widths to help layout */
        th:nth-child(1) {
            width: 20%;
        }

        /* Judul */
        th:nth-child(2) {
            width: 40%;
        }

        /* Konten */
        th:nth-child(3) {
            width: 15%;
        }

        /* Link */
        th:nth-child(4) {
            width: 10%;
        }

        /* Views */
        th:nth-child(5) {
            width: 15%;
        }

        /* Tanggal */
    </style>
</head>

<body>
    <div class="container py-5">
        <h3 class="text-center fw-bold mb-4">Laporan Bulanan - <?= format_date($year . '-' . $month . '-01', 'month_year') ?></h3>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="align-middle">Judul Berita</th>
                    <th class="align-middle">Konten Berita</th>
                    <th class="align-middle">Link Berita</th>
                    <th class="align-middle">Total Tampilan</th>
                    <th class="align-middle">Tanggal Publikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($posts)):
                    foreach ($posts as $post): ?>
                        <tr>
                            <td><strong><?= esc($post['title']) ?></strong></td>
                            <td>
                                <?php if (!empty($post['thumbnail_path']) && file_exists($post['thumbnail_path'])): ?>
                                    <div style="margin-bottom: 15px;">
                                        <img src="<?= $post['thumbnail_path'] ?>" style="max-width: 100%; height: auto;">
                                    </div>
                                <?php endif; ?>
                                <?= $post['content'] ?>
                            </td>
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
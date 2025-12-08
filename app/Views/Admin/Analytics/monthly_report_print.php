<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Bulanan</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            font-size: 10px;
            /* Decreased font size */
        }

        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            /* Revert to collapse */
            page-break-inside: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
            /* Apply border to table elements directly */
        }

        tr {
            page-break-inside: auto;
            page-break-after: auto;
        }

        tbody {
            page-break-inside: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
            page-break-inside: auto;
        }

        td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-all;
            /* More aggressive for long strings like URLs */
        }

        td a {
            word-break: break-all;
            /* Ensure links also break */
        }

        td p:first-child {
            margin-top: 0;
        }

        /* Prevent images in content from overflowing */
        td img {
            max-width: 100%;
            height: auto;
        }

        /* Specific column widths to help layout */
        /* No */
        th:nth-child(1) {
            width: 5%;
        }

        /* Judul */
        th:nth-child(2) {
            width: 20%;
        }

        /* Konten */
        th:nth-child(3) {
            width: 45%;
        }

        /* Link */
        th:nth-child(4) {
            width: 20%;
        }

        /* Views */
        th:nth-child(5) {
            width: 10%;
        }

        /* Tanggal */
        th:nth-child(6) {
            width: 10%;
        }
    </style>

</head>



<body>

    <div class="container py-5">

        <h3 class="text-center fw-bold mb-4">Laporan Bulanan - <?= format_date($year . '-' . $month . '-01', 'month_year') ?></h3>

        <table class="table table-bordered">

            <thead class="table-light">

                <tr>

                    <th class="align-middle text-center">No</th>

                    <th class="align-middle">Judul Berita</th>

                    <th class="align-middle">Konten Berita</th>

                    <th class="align-middle">Link Berita</th>

                    <th class="align-middle">Total Tampilan</th>

                    <th class="align-middle">Tanggal Publikasi</th>

                </tr>

            </thead>

            <tbody>

                <?php if (!empty($posts)):

                    $i = 1;

                    foreach ($posts as $post): ?>

                        <tr>

                            <td class="text-center"><?= $i++ ?></td>

                            <td><strong><?= esc($post['title']) ?></strong></td>

                            <td>
                                <?= word_limiter(trim(strip_tags($post['content'], '<p><a>')), 100) ?>
                            </td>

                            <td><a href="<?= base_url('post/' . esc($post['slug'])) ?>" target="_blank"><?= base_url('post/' . esc($post['slug'])) ?></a></td>

                            <td><?= esc($post['views']) ?></td>

                            <td><?= format_date($post['published_at'], 'date_only') ?></td>

                        </tr>

                    <?php endforeach;

                else: ?>

                    <tr>

                        <td colspan="6" class="text-center">Tidak ada postingan untuk bulan ini.</td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</body>



</html>
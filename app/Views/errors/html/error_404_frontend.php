<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-1 fw-bold text-primary">404</h1>
            <p class="fs-3"> <span class="text-danger">Oops!</span> Halaman tidak ditemukan.</p>
            <p class="lead">
                Maaf, halaman yang Anda cari tidak dapat kami temukan.
            </p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Kembali ke Beranda</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

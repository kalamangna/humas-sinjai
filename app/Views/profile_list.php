<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none"><i class="fas fa-home me-2"></i>Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($title) ?></li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="fw-bold display-5 mb-3">
                <i class="fas fa-users text-primary me-3"></i><?= esc($title) ?>
            </h2>
            <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
        </div>
    </div>

    <?php 
    $hasData = false;
    foreach ($groupedProfiles as $profiles) {
        if (!empty($profiles)) {
            $hasData = true;
            break;
        }
    }
    ?>

    <?php if ($hasData) : ?>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php 
                $displayOrder = ['Forkopimda', 'Eselon II', 'Eselon III', 'Eselon IV', 'Kepala Desa'];
                foreach ($displayOrder as $groupName) : 
                    $profiles = $groupedProfiles[$groupName] ?? [];
                    if (!empty($profiles)) : ?>
                        <div class="mb-5">
                            <h3 class="fw-bold text-primary mb-3 ps-3 border-start border-5 border-primary"><?= esc($groupName) ?></h3>
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="py-3 ps-4" style="width: 35%;">Nama</th>
                                                <th class="py-3" style="width: 30%;">Jabatan</th>
                                                <th class="py-3 pe-4" style="width: 35%;">Instansi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($profiles as $profile) : ?>
                                                <tr>
                                                    <td class="ps-4 fw-semibold text-dark"><?= esc($profile['name']) ?></td>
                                                    <td class="text-muted"><?= esc($profile['position'] ?? '-') ?></td>
                                                    <td class="pe-4 text-muted"><?= esc($profile['institution'] ?? '-') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="text-center py-5">
            <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">Data Belum Tersedia</h3>
            <p class="text-muted">Daftar <?= esc($title) ?> belum ditambahkan.</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Kembali ke Beranda</a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
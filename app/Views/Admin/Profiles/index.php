<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>Kelola Profil<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/profiles/new') ?>" class="btn btn-primary">
    <i class="fas fa-plus-circle me-2"></i>Tambah Profil
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 ps-4">Foto</th>
                        <th class="border-0">Nama</th>
                        <th class="border-0">Posisi / Jabatan</th>
                        <th class="border-0">Institusi</th>
                        <th class="border-0">Tipe</th>
                        <th class="border-0 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($profiles)) : ?>
                        <?php foreach ($profiles as $profile) : ?>
                            <tr>
                                <td class="ps-4">
                                    <?php if (!empty($profile['image'])) : ?>
                                        <img src="<?= esc($profile['image']) ?>" alt="<?= esc($profile['name']) ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else : ?>
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <h6 class="fw-bold mb-1 text-dark"><?= esc($profile['name']) ?></h6>
                                </td>
                                <td>
                                    <?= esc($profile['position'] ?? '-') ?>
                                </td>
                                <td>
                                    <?= esc($profile['institution'] ?? '-') ?>
                                </td>
                                <td>
                                    <?php 
                                        $typeLabels = [
                                            'bupati' => 'Bupati',
                                            'wakil-bupati' => 'Wakil Bupati',
                                            'sekda' => 'Sekda',
                                            'forkopimda' => 'Forkopimda',
                                            'eselon-ii' => 'Eselon II',
                                            'eselon-iii' => 'Eselon III',
                                            'eselon-iv' => 'Eselon IV',
                                            'kepala-desa' => 'Kepala Desa',
                                        ];
                                        echo '<span class="badge bg-info">' . ($typeLabels[$profile['type']] ?? $profile['type']) . '</span>';
                                    ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/profiles/' . $profile['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('admin/profiles/' . $profile['id']) ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus profil ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada profil</h5>
                                <a href="<?= base_url('admin/profiles/new') ?>" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Profil
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<?= $this->endSection() ?>

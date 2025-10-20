<?= $this->extend('layout/admin') ?>

<?= $this->section('page_title') ?>
Kelola Slide
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="<?= base_url('admin/carousel/new') ?>" class="btn btn-primary">
    <i class="fas fa-plus-circle me-2"></i>Tambah Slide
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 ps-4">Urutan</th>
                        <th class="border-0">Gambar</th>
                        <th class="border-0 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($slides)): ?>
                        <?php foreach ($slides as $slide): ?>
                            <tr>
                                <td class="ps-4"><?= esc($slide['slide_order']) ?></td>
                                <td>
                                    <img src="<?= esc($slide['image_path']) ?>" alt="" class="rounded" style="width: 150px; height: 75px; object-fit: cover;">
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/carousel/' . $slide['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('admin/carousel/' . $slide['id']) ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus slide ini?')">
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
                                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada slide</h5>
                                <p class="text-muted">Mulai dengan menambahkan slide pertama Anda.</p>
                                <a href="<?= base_url('admin/carousel/new') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Slide Pertama
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
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<?= $this->endSection() ?>
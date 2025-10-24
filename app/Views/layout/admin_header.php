<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Humas Sinjai</title>
    <link rel="icon" href="<?= base_url('logo.png') ?>" type="image/png">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.js"></script>

    <script src="<?= base_url('assets/tinymce/tinymce/tinymce.min.js') ?>" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'code table lists image',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image',
            images_upload_url: '<?= site_url('admin/posts/upload_image') ?>',
            relative_urls: false,
            remove_script_host: false,
            license_key: 'gpl'
        });
    </script>

    <script>
        function previewImage() {
            const thumbnail = document.querySelector('#thumbnail');
            const thumbnailPreview = document.querySelector('#thumbnail-preview');

            thumbnailPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(thumbnail.files[0]);

            oFReader.onload = function(oFREvent) {
                thumbnailPreview.src = oFREvent.target.result;
            }
        }
    </script>
</head>

<body class="bg-light">
    <!-- Top Navigation -->
    <header class="navbar navbar-dark sticky-top shadow bg-primary-gradient">
        <div class="container-fluid">
            <!-- Mobile Toggle -->
            <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('admin') ?>">
                <img src="<?= base_url('humas.png') ?>" alt="Logo Sinjai" height="40" class="d-inline-block align-text-top me-2">
                <!-- <small class="badge bg-light text-primary ms-2">Admin</small> -->
            </a>

            <div class="d-flex align-items-center ms-auto">
                <!-- View Site Button -->
                <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-outline-light btn-sm me-3">
                    <i class="fas fa-eye"></i> <span class="d-none d-md-inline ms-md-2">Lihat Situs</span>
                </a>

                <!-- User Menu -->
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2 fs-5"></i>
                        <span class="d-none d-sm-inline"><?= session()->get('name') ?? 'Admin' ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/profile') ?>">
                                <i class="fas fa-fw fa-user me-2"></i>Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                                <i class="fas fa-fw fa-cog me-2"></i>Pengaturan
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <i class="fas fa-fw fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
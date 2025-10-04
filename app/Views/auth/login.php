<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Header Section -->
            <div class="text-white text-center py-4 mb-4 rounded-3 bg-primary-gradient">
                <i class="fas fa-user-lock display-4 mb-3 opacity-75"></i>
                <h2 class="fw-bold mb-2">Login Admin</h2>
                <p class="mb-0 opacity-85">Portal Berita Humas Sinjai</p>
            </div>

            <!-- Login Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Flash Message -->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger d-flex align-items-center border-0" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success d-flex align-items-center border-0" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form action="<?= site_url('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-dark">
                                <i class="fas fa-envelope me-2"></i>Alamat Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-at text-muted"></i>
                                </span>
                                <input type="email" name="email" class="form-control border-start-0" placeholder="masukkan email anda" value="<?= old('email') ?>" required>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control border-start-0" placeholder="masukkan password" required>
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" <?= old('remember') ? 'checked' : '' ?>>
                                <label class="form-check-label text-muted small" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small text-primary">
                                <i class="fas fa-question-circle me-1"></i>Lupa password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>




                </div>
            </div>


        </div>
    </div>
</div>

<script>
    // Toggle Password Visibility
    document.getElementById('togglePassword')?.addEventListener('click', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
</script>

<?= $this->endSection() ?>
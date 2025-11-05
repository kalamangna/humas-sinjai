<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <i class="fas fa-home me-2"></i>Beranda
                </a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($post['title'] ?? '') ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                <!-- Post Header -->
                <div class="card-body p-4">
                    <h1 class="fw-bold mb-4 display-6 text-dark"><?= esc($post['title']) ?></h1>

                    <!-- Post Meta -->
                    <div class="d-flex flex-wrap gap-4 text-muted mb-4 pb-4 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <span>
                                <?php
                                $dateField = '';
                                if (isset($post['published_at']) && !empty($post['published_at'])) {
                                    $dateField = $post['published_at'];
                                } elseif (isset($post['created_at']) && !empty($post['created_at'])) {
                                    $dateField = $post['created_at'];
                                } else {
                                    $dateField = date('Y-m-d');
                                }
                                echo format_date($dateField, 'date_only');
                                ?>
                            </span>
                        </div>

                        <?php if (!empty($post['author_name'])) : ?>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-edit me-2"></i>
                                <span><?= esc($post['author_name']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($post['categories'])) : ?>
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <i class="fas fa-folder text-primary"></i>
                                <?php foreach ($post['categories'] as $category) : ?>
                                    <a href="<?= base_url('category/' . esc($category['slug'])) ?>" class="badge bg-primary text-decoration-none shadow-sm">
                                        <?= esc($category['name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($post['thumbnail'])) : ?>
                        <figure class="w-100 mb-4">
                            <img src="<?= esc($post['thumbnail']) ?>" class="figure-img img-fluid rounded-3 mb-3 w-100" alt="<?= esc($post['title']) ?>">
                            <?php if (!empty($post['thumbnail_caption'])) : ?>
                                <figcaption class="figure-caption text-center text-muted"><?= esc($post['thumbnail_caption']) ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                    <!-- Post Content -->
                    <div class="text-muted lh-lg mb-5 fs-6">
                        <?= $post['content'] ?>
                    </div>

                    <!-- Share Buttons -->
                    <div class="border-top pt-5 mt-4">
                        <h6 class="fw-bold mb-4 text-dark">
                            <i class="fas fa-share-alt text-primary me-2"></i>Bagikan Berita
                        </h6>
                        <div class="d-flex flex-wrap gap-3">
                            <?php
                            $share_url = urlencode(current_url());
                            $share_title = urlencode($post['title']);
                            ?>
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text=<?= $share_title ?>%20<?= $share_url ?>" target="_blank" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>" target="_blank" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" style="background-color: #1877f2; border-color: #1877f2;">
                                <i class="fab fa-facebook me-2"></i>Facebook
                            </a>

                            <!-- X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?url=<?= $share_url ?>&text=<?= $share_title ?>" target="_blank" class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm">
                                <i class="fab fa-x-twitter me-2"></i>X
                            </a>

                            <!-- Copy Link -->
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-4 shadow-sm" onclick="copyToClipboard()">
                                <i class="fas fa-link me-2"></i>Copy Link
                            </button>
                        </div>
                    </div>

                    <!-- Tags -->
                    <?php if (!empty($tags)) : ?>
                        <div class="mt-5 pt-4 border-top">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="fas fa-tags text-primary me-2"></i>Tag:
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?= base_url('tag/' . esc($tag['slug'])) ?>" class="badge bg-primary text-decoration-none shadow-sm">
                                        <?= esc($tag['name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Related Posts -->
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3 text-dark">
                        <i class="fas fa-link me-2"></i>Berita Terkait
                    </h5>
                    <?php if (!empty($related_posts)) : ?>
                        <div class="row g-4">
                            <?php foreach ($related_posts as $related) : ?>
                                <div class="col-12 col-md-6">
                                    <a href="<?= base_url('post/' . esc($related['slug'])) ?>" class="card text-white h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                        <img src="<?= esc($related['thumbnail']) ?>" class="card-img" alt="<?= esc($related['title']) ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-img-overlay bg-dark bg-opacity-50 d-flex flex-column justify-content-end p-4">
                                            <h6 class="card-title fw-bold mb-2"><?= esc($related['title']) ?></h6>
                                            <small class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                <?= format_date($related['published_at'] ?? $related['created_at'] ?? 'now', 'date_only') ?>
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-muted small mb-0 text-center py-3">Tidak ada berita terkait.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Recent Posts -->
            <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3 text-dark">
                        <i class="fas fa-history me-2"></i>Berita Terbaru
                    </h5>
                    <?php if (!empty($recent_posts)) : ?>
                        <div class="row g-3">
                            <?php foreach ($recent_posts as $recent) : ?>
                                <div class="col-12">
                                    <a href="<?= base_url('post/' . esc($recent['slug'])) ?>" class="card text-white h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                        <img src="<?= esc($recent['thumbnail']) ?>" class="card-img" alt="<?= esc($recent['title']) ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-img-overlay bg-dark bg-opacity-50 d-flex flex-column justify-content-end p-3">
                                            <h6 class="card-title fw-bold mb-1 small"><?= esc($recent['title']) ?></h6>
                                            <small class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                <?= format_date($recent['published_at'] ?? $recent['created_at'] ?? 'now', 'date_only') ?>
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-muted small mb-0 text-center py-3">Tidak ada berita terbaru.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Popular Posts -->
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3 text-dark">
                        <i class="fas fa-fire me-2"></i>Berita Terpopuler
                    </h5>
                    <?php if (!empty($popular_posts)) : ?>
                        <div class="row g-3">
                            <?php foreach ($popular_posts as $popular) : ?>
                                <div class="col-12">
                                    <a href="<?= base_url('post/' . esc($popular['slug'])) ?>" class="card text-white h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                        <img src="<?= esc($popular['thumbnail']) ?>" class="card-img" alt="<?= esc($popular['title']) ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-img-overlay bg-dark bg-opacity-50 d-flex flex-column justify-content-end p-3">
                                            <h6 class="card-title fw-bold mb-1 small"><?= esc($popular['title']) ?></h6>
                                            <small class="d-flex align-items-center">
                                                <i class="fas fa-eye me-2"></i><?= $popular['views'] ?>
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-muted small mb-0 text-center py-3">Tidak ada berita populer.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const url = window.location.href;
        const textarea = document.createElement('textarea');
        textarea.value = url;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        // Show success message
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-2"></i>Link Disalin!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');

        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    }
</script>

<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('posts') ?>" class="text-decoration-none">Berita</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($post['title'] ?? '') ?></li>
        </ol>
    </nav>

    <div class="row g-3">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm mb-4">
                <!-- Post Header -->
                <div class="card-body p-4">
                    <?php if (!empty($post['thumbnail'])) : ?>
                        <img src="<?= esc($post['thumbnail']) ?>" class="img-fluid rounded mb-4 w-100" alt="<?= esc($post['title']) ?>" style="max-height: 400px; object-fit: cover;">
                    <?php endif; ?>

                    <h1 class="fw-bold mb-3 text-dark"><?= esc($post['title']) ?></h1>

                    <!-- Post Meta -->
                    <div class="d-flex flex-wrap gap-4 text-muted mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar me-2"></i>
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
                                echo date('d M Y', strtotime($dateField));
                                ?>
                            </span>
                        </div>

                        <?php if (!empty($post['author_name'])) : ?>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user me-2"></i>
                                <span><?= esc($post['author_name']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($post['categories'])) : ?>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-folder me-2"></i>
                                <?php foreach ($post['categories'] as $category) : ?>
                                    <a href="<?= base_url('category/' . esc($category['slug'])) ?>" class="badge bg-primary text-decoration-none me-1">
                                        <?= esc($category['name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex align-items-center">
                            <i class="fas fa-eye me-2"></i>
                            <span><?= $post['views'] ?? 0 ?> dilihat</span>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="text-muted lh-lg mb-4">
                        <?= nl2br(esc($post['content'])) ?>
                    </div>

                    <!-- Share Buttons -->
                    <div class="border-top pt-4 mt-4">
                        <h6 class="fw-bold mb-3 text-dark">
                            <i class="fas fa-share-alt me-2"></i>Bagikan Berita
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php
                            $share_url = urlencode(current_url());
                            $share_title = urlencode($post['title']);
                            ?>
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text=<?= $share_title ?>%20<?= $share_url ?>" target="_blank" class="btn btn-success btn-sm">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>" target="_blank" class="btn btn-primary btn-sm" style="background-color: #1877f2; border-color: #1877f2;">
                                <i class="fab fa-facebook me-2"></i>Facebook
                            </a>

                            <!-- X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?url=<?= $share_url ?>&text=<?= $share_title ?>" target="_blank" class="btn btn-dark btn-sm">
                                <i class="fab fa-x-twitter me-2"></i>X
                            </a>

                            <!-- Copy Link -->
                            <button class="btn btn-outline-primary btn-sm" onclick="copyToClipboard()">
                                <i class="fas fa-link me-2"></i>Copy Link
                            </button>
                        </div>
                    </div>

                    <!-- Tags -->
                    <?php if (!empty($tags)) : ?>
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="fas fa-tags me-2"></i>Tag:
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?= base_url('tag/' . esc($tag['slug'])) ?>" class="badge bg-primary text-decoration-none">
                                        <?= esc($tag['name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Navigation Between Posts -->
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <?php if (!empty($previous_post)) : ?>
                        <a href="<?= base_url('post/' . esc($previous_post['slug'])) ?>" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Post Sebelumnya
                        </a>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if (!empty($next_post)) : ?>
                        <a href="<?= base_url('post/' . esc($next_post['slug'])) ?>" class="btn btn-outline-primary">
                            Post Selanjutnya<i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Posts -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark">
                        <i class="fas fa-link me-2"></i>Berita Terkait
                    </h5>
                    <?php if (!empty($related_posts)) : ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($related_posts as $related) : ?>
                                <a href="<?= base_url('post/' . esc($related['slug'])) ?>" class="list-group-item list-group-item-action border-0 px-0 py-3">
                                    <div class="d-block">
                                        <?php if (!empty($related['thumbnail'])) : ?>
                                            <img src="<?= esc($related['thumbnail']) ?>" class="img-fluid rounded mb-2" alt="<?= esc($related['title']) ?>">
                                        <?php else : ?>
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2" style="height: 150px;">
                                                <i class="fas fa-newspaper text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1 text-dark"><?= esc($related['title']) ?></h6>
                                            <small class="text-muted">
                                                <?= date('d M Y', strtotime($related['published_at'] ?? $related['created_at'] ?? 'now')) ?>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-muted small mb-0">Tidak ada berita terkait.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark">
                        <i class="fas fa-history me-2"></i>Berita Terbaru
                    </h5>
                    <?php if (!empty($recent_posts)) : ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_posts as $recent) : ?>
                                <a href="<?= base_url('post/' . esc($recent['slug'])) ?>" class="list-group-item list-group-item-action border-0 px-0 py-3">
                                    <div class="d-block">
                                        <?php if (!empty($recent['thumbnail'])) : ?>
                                            <img src="<?= esc($recent['thumbnail']) ?>" class="img-fluid rounded mb-2" alt="<?= esc($recent['title']) ?>">
                                        <?php else : ?>
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2" style="height: 150px;">
                                                <i class="fas fa-newspaper text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1 text-dark"><?= esc($recent['title']) ?></h6>
                                            <small class="text-muted">
                                                <?= date('d M Y', strtotime($recent['published_at'] ?? $recent['created_at'] ?? 'now')) ?>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-muted small mb-0">Tidak ada berita terbaru.</p>
                    <?php endif; ?>
                </div>
            </div>



        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
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
        }).catch(function(err) {
            console.error('Gagal menyalin link: ', err);
            alert('Gagal menyalin link');
        });
    }
</script>

<?= $this->endSection() ?>
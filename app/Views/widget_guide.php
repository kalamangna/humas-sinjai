<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <i class="fas fa-home me-2"></i>Beranda
                </a></li>
            <li class="breadcrumb-item active" aria-current="page">Panduan Widget</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold display-5 mb-3">
                <i class="fas fa-puzzle-piece text-primary me-3"></i>Panduan Widget Berita
            </h1>
            <div class="border-bottom border-primary mx-auto" style="width: 100px;"></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <section class="mb-5">
                        <h2 class="h4 fw-bold border-bottom pb-2 mb-3">Deskripsi Singkat</h2>
                        <p>Widget ini memungkinkan Anda untuk menampilkan berita terbaru dari portal Humas Sinjai langsung di situs web Anda. Widget ini mengambil data dari RSS feed kami dan dapat dengan mudah dipasang di website mitra pemerintah atau media lokal untuk menyajikan informasi yang up-to-date kepada pengunjung.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold border-bottom pb-2 mb-3">Cara Pemasangan</h2>
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item">Salin kode embed di bawah ini sesuai dengan tema yang Anda inginkan (Light atau Dark).</li>
                            <li class="list-group-item">Tempelkan kode tersebut ke dalam bagian <code>&lt;body&gt;</code> pada halaman web Anda di mana Anda ingin widget ditampilkan.</li>
                            <li class="list-group-item">Simpan perubahan pada file HTML Anda dan muat ulang halaman untuk melihat widget beraksi.</li>
                        </ol>

                        <div class="accordion mt-4" id="platform-guides">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-blogspot">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-blogspot" aria-expanded="false" aria-controls="collapse-blogspot">
                                        <i class="fab fa-blogger-b me-2"></i><strong>Panduan untuk Pengguna Blogspot</strong>
                                    </button>
                                </h2>
                                <div id="collapse-blogspot" class="accordion-collapse collapse" aria-labelledby="heading-blogspot" data-bs-parent="#platform-guides">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Masuk ke <strong>Dashboard Blogger</strong> → menu <strong>Tata Letak</strong>.</li>
                                            <li>Klik <strong>Tambahkan Gadget</strong> → pilih <strong>HTML/JavaScript</strong>.</li>
                                            <li>Tempelkan kode widget di kolom <strong>Konten</strong>.</li>
                                            <li>Klik <strong>Simpan</strong> dan lihat hasilnya di blog Anda.</li>
                                            <li>Jika widget tidak tampil, pastikan blog Anda mengizinkan script eksternal (https).</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-wordpress">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-wordpress" aria-expanded="false" aria-controls="collapse-wordpress">
                                        <i class="fab fa-wordpress me-2"></i><strong>Panduan untuk Pengguna WordPress</strong>
                                    </button>
                                </h2>
                                <div id="collapse-wordpress" class="accordion-collapse collapse" aria-labelledby="heading-wordpress" data-bs-parent="#platform-guides">
                                    <div class="accordion-body">
                                        <p><strong>Untuk Widget Area (Sidebar/Footer):</strong></p>
                                        <ol>
                                            <li>Masuk ke <strong>Dashboard WordPress</strong> → <strong>Appearance</strong> → <strong>Widgets</strong> (Tampilan → Widget).</li>
                                            <li>Tambahkan block <strong>Custom HTML</strong> di area yang Anda inginkan (misalnya, sidebar atau footer).</li>
                                            <li>Tempelkan kode script widget di dalamnya.</li>
                                            <li>Simpan perubahan dan muat ulang situs Anda.</li>
                                        </ol>
                                        <hr class="my-3">
                                        <p><strong>Untuk Konten Halaman/Postingan (Block Editor):</strong></p>
                                        <ol>
                                            <li>Tambahkan blok <strong>Custom HTML</strong> di mana Anda ingin widget muncul.</li>
                                            <li>Tempelkan kode di atas ke dalam blok tersebut.</li>
                                            <li>Klik <strong>Preview</strong> untuk melihat hasilnya atau <strong>Update</strong> untuk menyimpan.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold border-bottom pb-2 mb-3">Kode Embed</h2>

                        <h3 class="h5 fw-semibold mt-4">Light Theme</h3>
                        <div class="position-relative mb-3">
                            <button type="button" class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 m-2 copy-btn" data-target="code-light" title="Salin kode">
                                <i class="fas fa-copy me-2"></i>Salin
                            </button>
                            <pre id="code-light" class="bg-light border rounded p-3"><code>
&lt;link rel="stylesheet" href="https://humas.sinjaikab.go.id/v1/rss-widget/style.css"&gt;
&lt;div id="rss-widget-light"&gt;&lt;/div&gt;
&lt;script src="https://humas.sinjaikab.go.id/v1/rss-widget/widget.js"
    data-container="rss-widget-light"
    data-limit="5"
    data-theme="light"
    data-title="Berita Terbaru - Humas Sinjai"&gt;
&lt;/script&gt;</code></pre>
                        </div>

                        <h3 class="h5 fw-semibold mt-4">Dark Theme</h3>
                        <div class="position-relative mb-3">
                            <button type="button" class="btn btn-sm btn-outline-light position-absolute top-0 end-0 m-2 copy-btn" data-target="code-dark" title="Salin kode">
                                <i class="fas fa-copy me-2"></i>Salin
                            </button>
                            <pre id="code-dark" class="bg-dark text-light border rounded p-3"><code>
&lt;link rel="stylesheet" href="https://humas.sinjaikab.go.id/v1/rss-widget/style.css"&gt;
&lt;div id="rss-widget-dark"&gt;&lt;/div&gt;
&lt;script src="https://humas.sinjaikab.go.id/v1/rss-widget/widget.js"
    data-container="rss-widget-dark"
    data-limit="5"
    data-theme="dark"
    data-title="Berita Terbaru - Humas Sinjai"&gt;
&lt;/script&gt;</code></pre>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold border-bottom pb-2 mb-3">Kustomisasi Parameter</h2>
                        <p>Anda dapat menyesuaikan tampilan dan konten widget dengan mengubah <code>data</code> atribut pada tag <code>&lt;script&gt;</code>:</p>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p class="fw-semibold mb-1"><code>data-container</code> <span class="badge bg-danger">Wajib</span></p>
                                <p class="mb-0 text-muted">ID dari elemen <code>&lt;div&gt;</code> di mana widget akan ditampilkan. Pastikan ID ini unik di halaman Anda. Contoh: <code>data-container="rss-widget-light"</code>.</p>
                            </li>
                            <li class="list-group-item">
                                <p class="fw-semibold mb-1"><code>data-limit</code> <span class="badge bg-secondary">Opsional</span></p>
                                <p class="mb-0 text-muted">Jumlah berita yang ingin ditampilkan. Jika tidak diatur, akan menampilkan 5 berita secara default. Contoh: <code>data-limit="3"</code>.</p>
                            </li>
                            <li class="list-group-item">
                                <p class="fw-semibold mb-1"><code>data-theme</code> <span class="badge bg-secondary">Opsional</span></p>
                                <p class="mb-0 text-muted">Tema tampilan widget. Gunakan <code>light</code> untuk tema terang atau <code>dark</code> untuk tema gelap. Defaultnya adalah <code>light</code>. Contoh: <code>data-theme="dark"</code>.</p>
                            </li>
                            <li class="list-group-item">
                                <p class="fw-semibold mb-1"><code>data-title</code> <span class="badge bg-secondary">Opsional</span></p>
                                <p class="mb-0 text-muted">
                                    Judul yang akan ditampilkan di bagian atas widget. Jika tidak diatur, judul default adalah
                                    <code>Berita Terbaru - Humas Sinjai</code>. Anda dapat menyesuaikannya sesuai kebutuhan, misalnya:
                                    <code>data-title="Info Resmi Pemkab Sinjai"</code>.
                                </p>
                            </li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold border-bottom pb-2 mb-3">Pratinjau Langsung</h2>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <h3 class="h5 fw-semibold">Contoh Light Theme</h3>
                                <div id="rss-widget-preview-light"></div>
                            </div>

                            <div class="col-md-6">
                                <h3 class="h5 fw-semibold">Contoh Dark Theme</h3>
                                <div id="rss-widget-preview-dark"></div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script for live preview -->
<script src="https://humas.sinjaikab.go.id/v1/rss-widget/widget.js"
    data-container="rss-widget-preview-light"
    data-limit="5"
    data-theme="light">
</script>

<script src="https://humas.sinjaikab.go.id/v1/rss-widget/widget.js"
    data-container="rss-widget-preview-dark"
    data-limit="5"
    data-theme="dark">
</script>

<link rel="stylesheet" href="https://humas.sinjaikab.go.id/v1/rss-widget/style.css">

<script>
    (function() {
        function fallbackCopyTextToClipboard(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                var successful = document.execCommand('copy');
                document.body.removeChild(textArea);
                return successful;
            } catch (err) {
                document.body.removeChild(textArea);
                return false;
            }
        }

        function copyTextToClipboard(text) {
            if (!navigator.clipboard) {
                return Promise.resolve(fallbackCopyTextToClipboard(text));
            }
            return navigator.clipboard.writeText(text);
        }

        function getCodeText(codeEl) {
            // Use textContent to get unescaped text (contains &lt; etc.)
            return codeEl.textContent || codeEl.innerText || '';
        }

        document.addEventListener('click', function(e) {
            var btn = e.target.closest && e.target.closest('.copy-btn');
            if (!btn) return;
            var targetId = btn.getAttribute('data-target');
            var pre = document.getElementById(targetId);
            if (!pre) return;
            var code = pre.querySelector('code') || pre;
            var text = getCodeText(code);

            copyTextToClipboard(text).then(function() {
                var original = btn.innerHTML;
                btn.innerHTML = 'Tersalin';
                btn.disabled = true;
                setTimeout(function() {
                    btn.innerHTML = original;
                    btn.disabled = false;
                }, 2000);
            }).catch(function() {
                // fallback UI
                alert('Gagal menyalin ke clipboard. Silakan salin secara manual.');
            });
        });
    })();
</script>

<?= $this->endSection() ?>
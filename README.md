# Humas Sinjai - Portal Berita Resmi Pemerintah Kabupaten Sinjai

Aplikasi web portal berita dan informasi untuk Humas Sinjai, dibangun menggunakan framework CodeIgniter 4. Aplikasi ini menyediakan platform untuk mempublikasikan berita, kegiatan, dan program prioritas pemerintah, dilengkapi dengan dashboard admin yang komprehensif.

## Fitur Utama

### 🌐 Portal Publik

- **Beranda Informatif:** Menampilkan berita terbaru, berita populer, carousel banner, dan widget penting.
- **Manajemen Berita:** Halaman detail berita dengan gambar, kategori, dan tag.
- **Profil Pejabat:** Halaman detail profil pejabat dengan biografi lengkap (Rich Text) dan foto.
- **Daftar Pejabat Terstruktur:** Halaman daftar pejabat yang dikelompokkan secara sistematis (Forkopimda, Eselon II, III, IV, dan Kepala Desa).
- **Kategorisasi:** Penelusuran berita berdasarkan kategori dan tag.
- **Pencarian:** Fitur pencarian berita yang cepat.
- **Halaman Statis:** Profil (About), Kontak, dan Panduan Widget.
- **Program Prioritas:** Halaman khusus untuk mensosialisasikan program prioritas pemerintah.
- **Widget RSS:** Widget yang dapat dipasang di situs eksternal untuk menampilkan berita terbaru secara otomatis.
- **SEO & Distribusi:** Dukungan otomatis untuk Sitemap.xml, RSS Feed, Canonical Tags, dan Dynamic Meta Tags.
- **Error Handling:** Halaman error 404 kustom yang selaras dengan desain situs.

### 🛠 Dashboard Admin

- **Statistik & Analitik:** Integrasi mendalam dengan Google Analytics untuk menampilkan:
  - Ikhtisar Kunjungan (Overview).
  - Halaman Terpopuler (Top Pages).
  - Sumber Trafik (Traffic Sources).
  - Demografi Pengunjung (Geografi & Perangkat).
  - **Laporan Bulanan PDF:** Ekspor laporan statistik bulanan ke format PDF siap cetak.
- **Manajemen Konten (CMS):**
  - **Post Editor:** Editor teks kaya fitur (TinyMCE) dengan dukungan upload gambar dan _paste_ gambar langsung dari clipboard.
  - **AI Tag Suggestion:** Integrasi **Gemini AI** untuk menyarankan tag SEO secara otomatis berdasarkan judul dan konten berita.
  - **Input Tag Manual:** Fleksibilitas untuk menambah tag secara manual.
  - **Status Publikasi:** Dukungan draft dan publikasi terjadwal.
- **Manajemen Profil Pejabat:** CRUD lengkap untuk mengelola data pejabat, jabatan, instansi, dan biografi dengan editor teks kaya.
- **Manajemen Media:** Pengelolaan Banner/Carousel halaman depan.
- **Manajemen Taksonomi:** Pengelolaan Kategori dan Tag secara dinamis.
- **Manajemen Pengguna:** Pengelolaan akun admin dan pengaturan profil.

### 🚀 Teknologi & Integrasi

- **Framework:** CodeIgniter 4 (PHP 8.1+).
- **Database:** MySQL.
- **Frontend:** Bootstrap 5, SCSS.
- **AI Service:** Google Gemini API (Model: `gemini-2.5-flash` dengan fallback ke `gemini-2.5-flash-lite`).
- **Analytics:** Google Analytics 4 (via Service Account).
- **Libraries:** TinyMCE, FontAwesome.

## Persyaratan Sistem

- PHP version 8.1 atau lebih baru.
- Ekstensi PHP: `intl`, `mbstring`, `json`, `mysqlnd`, `libcurl`.
- Database MySQL/MariaDB.
- Composer.

## Konfigurasi

1.  **Environment:**
    Salin file `env` menjadi `.env` dan sesuaikan konfigurasi berikut:

    ```env
    CI_ENVIRONMENT = development # atau production

    app.baseURL = 'http://localhost:8080/'

    database.default.hostname = localhost
    database.default.database = nama_database
    database.default.username = user_database
    database.default.password = password_database
    database.default.DBDriver = MySQLi

    # Google Analytics Service Account Credentials (JSON)
    GOOGLE_APPLICATION_CREDENTIALS = /path/to/service-account.json
    GA_PROPERTY_ID = 'YOUR_GA4_PROPERTY_ID'

    # Gemini AI API Key
    GEMINI_API_KEY = 'YOUR_GEMINI_API_KEY'
    ```

2.  **Instalasi Dependensi:**

    ```bash
    composer install
    ```

3.  **Migrasi Database:**

    ```bash
    php spark migrate
    ```

4.  **Menjalankan Server:**
    ```bash
    php spark serve
    ```

## Struktur Folder Penting

- `app/Controllers`: Logika aplikasi (Frontend & Admin).
- `app/Views`: Template HTML.
- `app/Models`: Interaksi database.
- `app/Libraries`: Layanan eksternal (GeminiService, GoogleAnalyticsService).
- `public`: Aset publik (CSS, JS, Images, Uploads).

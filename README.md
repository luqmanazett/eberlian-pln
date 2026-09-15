# E-Berlian PLN

E-Berlian PLN adalah aplikasi web untuk mengelola pengajuan **Elektronik Berita Acara Lingkungan dan Pertanahan** secara terstruktur. Aplikasi ini membantu pengguna mengirim permohonan beserta dokumen pendukung, sementara petugas dapat melakukan verifikasi, meminta perbaikan, memberi persetujuan, dan menyiapkan dokumen hasil proses.

## Fitur Utama

### Portal Pengguna

- Registrasi, login, verifikasi email, dan pengelolaan profil.
- Pengajuan permohonan secara online dengan form dinamis berbasis Livewire.
- Pemilihan jenis permohonan, termasuk pasang baru, tambah daya, dan peningkatan keandalan.
- Upload data pemohon, dokumen pendukung, serta tanda tangan elektronik.
- Melihat detail, status, dan riwayat seluruh permohonan.
- Pembatalan permohonan yang masih dapat dibatalkan.
- Upload ulang dokumen yang perlu diperbaiki berdasarkan catatan verifikator.
- Notifikasi status permohonan dengan penanda sudah dibaca dan jumlah notifikasi belum dibaca.

### Dashboard Admin

- Ringkasan total permohonan, pending, disetujui, ditolak, dan yang membutuhkan perbaikan.
- Grafik permohonan tujuh hari terakhir dan statistik berdasarkan jenis permohonan.
- Daftar permohonan terbaru.
- Pencarian berdasarkan nama pelanggan, nomor KTP, atau IDPEL.
- Filter berdasarkan status, jenis permohonan, dan rentang tanggal.
- Pengurutan permohonan terbaru atau terlama.
- Penguncian permohonan saat sedang ditangani admin lain untuk mencegah konflik pemeriksaan.

### Verifikasi dan Alur Perbaikan

- Melihat data pemohon dan seluruh dokumen dalam satu halaman pemeriksaan.
- Menyetujui permohonan dengan catatan admin.
- Menolak permohonan secara permanen dengan alasan penolakan.
- Menandai dokumen tertentu agar pemohon dapat melakukan perbaikan dan upload ulang.
- Menyimpan detail alasan penolakan per dokumen.
- Menyimpan riwayat versi perbaikan dan status pemeriksaannya.
- Mengirim notifikasi otomatis kepada pemohon setelah persetujuan, penolakan, atau permintaan perbaikan.

### Dokumen dan Pelaporan

- Ekspor data permohonan ke Excel.
- Ekspor rekap permohonan ke PDF berdasarkan tanggal, status, dan jenis permohonan.
- Ekspor dokumen permohonan individual ke Excel dan PDF.
- Pembuatan dokumen berita acara lahan dan lingkungan dalam format PDF.
- Penggabungan tanda tangan elektronik ke dokumen PDF.

### Manajemen Akses

Aplikasi menggunakan role-based access control:

- **User**: membuat dan memantau permohonan miliknya.
- **Admin verifikator**: memeriksa dan memproses permohonan.
- **Admin utama**: mengelola pengguna dan ekspor data administratif.
- **Management**: melihat dashboard management dan akses ekspor yang disediakan.

Aktivitas penting admin dicatat melalui activity log, termasuk tindakan menyetujui dan menolak permohonan.

## Teknologi

- Laravel 12
- PHP 8.2+
- MySQL
- Livewire 4
- Blade
- Tailwind CSS
- Vite
- Laravel Breeze untuk autentikasi
- Laravel Excel untuk ekspor spreadsheet
- Dompdf dan FPDI/TCPDF untuk pembuatan serta pengolahan PDF
- Intervention Image untuk pemrosesan gambar

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- MySQL 8 atau MariaDB
- Ekstensi PHP yang dibutuhkan Laravel dan koneksi database MySQL

## Instalasi Lokal

```bash
git clone https://github.com/luqmanazett/eberlian-pln.git
cd eberlian-pln
composer install
copy .env.example .env
php artisan key:generate
```

Atur koneksi database pada `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eberlian_pln
DB_USERNAME=root
DB_PASSWORD=
```

Lanjutkan dengan migrasi, storage link, dan asset frontend:

```bash
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

Buka aplikasi melalui `http://127.0.0.1:8000`.

## Pengembangan

Untuk menjalankan server Laravel dan Vite secara terpisah:

```bash
php artisan serve
npm run dev
```

Untuk menjalankan test:

```bash
php artisan test
```

## Struktur Modul

```text
app/
├── Exports/              # Export Excel permohonan
├── Http/Controllers/     # Controller user, admin, management, dan auth
├── Livewire/             # Form permohonan interaktif
├── Models/               # Permohonan, notifikasi, log, dan riwayat perbaikan
└── Services/             # Service tanda tangan elektronik
resources/views/          # Tampilan user, admin, management, dan export PDF
database/migrations/      # Struktur database dan perubahan skema
routes/web.php            # Route dan pembatasan akses berbasis role
```

## Status Project

Project ini dibuat sebagai aplikasi pengelolaan permohonan berbasis web dan portfolio full-stack development. Fitur inti pengajuan, verifikasi, notifikasi, perbaikan dokumen, ekspor, dan tanda tangan elektronik telah tersedia.

## Lisensi

Project ini menggunakan lisensi MIT.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

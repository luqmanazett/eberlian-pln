# E-Berlian PLN

E-Berlian PLN adalah aplikasi web untuk mengelola pengajuan **Elektronik Berita Acara Lingkungan dan Pertanahan** secara terstruktur. Aplikasi ini membantu pengguna mengirim permohonan beserta dokumen pendukung, sementara petugas dapat melakukan verifikasi, meminta perbaikan, memberi persetujuan, dan menyiapkan dokumen hasil proses.

## Fitur Utama

### Portal Pengguna

- Registrasi, login, verifikasi email, dan pengelolaan profil.
- Pengajuan permohonan online dengan form dinamis berbasis Livewire.
- Pemilihan jenis permohonan, termasuk pasang baru, tambah daya, dan peningkatan keandalan.
- Upload data pemohon, dokumen pendukung, serta tanda tangan elektronik.
- Melihat detail, status, dan riwayat seluruh permohonan.
- Pembatalan permohonan yang masih dapat dibatalkan.
- Upload ulang dokumen yang perlu diperbaiki berdasarkan catatan verifikator.
- Notifikasi status permohonan dengan penanda sudah dibaca dan jumlah belum dibaca.

### Dashboard Admin

- Ringkasan total permohonan, pending, disetujui, ditolak, dan yang membutuhkan perbaikan.
- Grafik permohonan tujuh hari terakhir dan statistik berdasarkan jenis permohonan.
- Daftar permohonan terbaru.
- Pencarian berdasarkan nama pelanggan, nomor KTP, atau IDPEL.
- Filter berdasarkan status, jenis permohonan, dan rentang tanggal.
- Pengurutan permohonan terbaru atau terlama.
- Penguncian permohonan saat sedang ditangani admin lain untuk mencegah konflik pemeriksaan.

### Verifikasi dan Alur Perbaikan

- Melihat data pemohon dan dokumen dalam satu halaman pemeriksaan.
- Menyetujui permohonan dengan catatan admin.
- Menolak permohonan secara permanen dengan alasan penolakan.
- Menandai dokumen tertentu agar pemohon dapat memperbaiki dan upload ulang.
- Menyimpan detail alasan penolakan per dokumen.
- Menyimpan riwayat versi perbaikan dan status pemeriksaannya.
- Mengirim notifikasi otomatis setelah persetujuan, penolakan, atau permintaan perbaikan.

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

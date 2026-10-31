# Panduan Menjalankan Website Indah Salon

Panduan ini untuk menjalankan proyek yang sudah tersedia di Windows menggunakan PowerShell, MySQL, dan Midtrans Sandbox. Perintah dijalankan dari folder proyek, kecuali disebutkan berbeda.

## 1. Perangkat yang perlu diinstal

| Perangkat | Kegunaan | Ketentuan |
| --- | --- | --- |
| PHP | Menjalankan Laravel | Minimal PHP 8.2, sesuai `composer.json` |
| MySQL | Menyimpan data aplikasi | Siapkan server database dan akun database |
| Composer | Memasang dependensi PHP | Gunakan Composer 2 |
| Node.js dan npm | Membuat CSS dan JavaScript | Gunakan Node.js LTS yang kompatibel dengan dependensi proyek |
| Visual Studio Code | Membuka dan mengedit proyek | Opsional, editor lain juga bisa |
| Git | Mengunduh proyek dari repository | Diperlukan jika menggunakan Git |
| ngrok | Menerima webhook Midtrans di komputer lokal | Diperlukan untuk pengujian pembayaran melalui webhook |
| Browser | Membuka website | Gunakan browser modern |

PHP dan MySQL bisa disediakan melalui WampServer, Laragon, atau instalasi terpisah. Cukup gunakan satu lingkungan agar port dan PHP tidak bertabrakan. Jika PHP dan MySQL sudah berjalan di WampServer, tidak perlu memasang server lain.

Unduhan dan referensi:

- [PHP untuk Windows](https://windows.php.net/download/)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://dev.mysql.com/downloads/installer/)
- [Node.js](https://nodejs.org/en/download)
- [Visual Studio Code](https://code.visualstudio.com/)
- [Git](https://git-scm.com/downloads)
- [ngrok untuk Windows](https://ngrok.com/download/windows)

Aktifkan ekstensi PHP yang dibutuhkan Laravel: Ctype, cURL, DOM, Fileinfo, Filter, Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer, dan XML. Tambahkan `pdo_mysql` untuk koneksi MySQL. `gd` diperlukan untuk pengujian yang membuat gambar contoh; `pdo_sqlite` dan `sqlite3` diperlukan jika menjalankan pengujian dengan SQLite sementara. [Persyaratan Laravel 12](https://laravel.com/framework/docs/12.x/deployment)

Periksa instalasi dari terminal baru:

```powershell
php -v
php --ini
php -m
composer --version
node -v
npm -v
git --version
```

Jika perintah tidak dikenali, periksa PATH Windows. Pada instalasi WampServer, arahkan PATH ke folder PHP yang digunakan. `php --ini` menunjukkan konfigurasi PHP terminal; konfigurasinya bisa berbeda dari PHP Apache.

## 2. Buka folder proyek

Untuk lokasi proyek saat ini:

```powershell
Set-Location 'D:\PROJEK CUAN\veloura'
```

Nama folder `veloura` tetap boleh digunakan meskipun nama aplikasi sudah Indah Salon.

Jika menerima proyek dalam ZIP, ekstrak terlebih dahulu. Jika menerima repository Git, clone repository yang diberikan pemilik proyek, lalu masuk ke foldernya. Jangan membuat proyek Laravel baru di dalam folder ini.

## 3. Siapkan file lingkungan

Untuk instalasi pertama, salin contoh konfigurasi hanya jika `.env` belum ada:

```powershell
if (!(Test-Path .env)) { Copy-Item .env.example .env }
```

Buka `.env` dan sesuaikan bagian berikut:

```dotenv
APP_NAME="Indah Salon"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_LOCALE=id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veloura
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
```

`root` dan kata sandi kosong hanya contoh lingkungan lokal. Gunakan akun, kata sandi, serta port MySQL yang benar di komputer Anda. Biarkan `APP_KEY` yang sudah ada tetap digunakan jika menjalankan instalasi lama.

`.env.example` proyek masih memiliki konfigurasi SQLite bawaan. Ganti menjadi MySQL seperti contoh di atas jika mengikuti panduan ini.

## 4. Pasang dependensi

```powershell
composer install
npm install
```

Gunakan `composer install` agar versi mengikuti `composer.lock`. Jangan memakai `composer update` hanya untuk menjalankan proyek.

Jika PowerShell menolak `npm.ps1`, gunakan perintah berikut sebagai pengganti:

```powershell
npm.cmd install
```

Untuk instalasi baru yang `APP_KEY`-nya masih kosong:

```powershell
php artisan key:generate
```

Setelah mengubah `.env`:

```powershell
php artisan config:clear
```

## 5. Buat database MySQL

Nyalakan layanan MySQL melalui lingkungan yang digunakan. Buka phpMyAdmin atau aplikasi pengelola MySQL, lalu jalankan:

```sql
CREATE DATABASE IF NOT EXISTS veloura
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Nama database harus sama dengan `DB_DATABASE`. Jangan menghapus database yang sudah berisi data.

## 6. Periksa migrasi sebelum instalasi baru

Pada versi kode saat panduan dibuat, file berikut masih memiliki referensi tabel yang tidak cocok:

```text
database/migrations/2026_10_05_121530_create_bookings_table.php
```

Di bagian foreign key `staff_id`, ubah:

```php
->constrained('staff')
```

menjadi:

```php
->constrained('staffs')
```

Tabel staff yang dibuat migrasi proyek bernama `staffs`. Koreksi ini perlu dilakukan sebelum migrasi pada database baru. Panduan ini tidak mengubah file migrasi tersebut secara otomatis.

Jika database lama sudah memiliki tabel booking, mengedit migrasi lama tidak memperbaiki foreign key yang sudah terpasang. Periksa struktur aktual terlebih dahulu; perubahan struktur database lama memerlukan migrasi perbaikan tersendiri.

## 7. Jalankan migrasi dan buat akun admin

Pada database baru:

```powershell
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan migrate:status
```

Seeder tersebut membuat atau memperbarui akun berikut berdasarkan `AdminSeeder.php`:

| Keterangan | Nilai |
| --- | --- |
| Email | `admin@veloura.com` |
| Kata sandi awal | `Admin@12345` |

Email admin masih memakai nama lama; ini memang identitas login yang tersimpan dalam seeder. Nama tampilannya adalah Admin Indah Salon.

Ganti kata sandi melalui profil setelah masuk. Menjalankan seeder ini lagi akan mengatur ulang kata sandi akun tersebut ke nilai dalam seeder.

Untuk database yang sudah digunakan, jangan menjalankan `migrate:fresh`, karena perintah tersebut menghapus semua tabel. Migrasi biasa juga tidak otomatis memulihkan migrasi yang sebelumnya gagal di tengah pembuatan tabel; periksa pesan error dan struktur database sebelum mengulang.

## 8. Hubungkan gambar layanan

```powershell
php artisan storage:link
```

Upload layanan disimpan di `storage/app/public/services` dan diakses melalui `public/storage`. Gambar default berada di `public/images/service-default.svg`; logo berada di `public/images/logo.png`.

Jika muncul pesan bahwa link sudah ada dan gambar dapat dibuka, tidak perlu membuat ulang link. Pastikan folder `storage` dan `bootstrap/cache` dapat ditulis oleh proses PHP. Pada Windows, jika pembuatan link ditolak, aktifkan Developer Mode atau jalankan terminal dengan hak yang sesuai.

## 9. Bangun tampilan dan jalankan website

Cara paling sederhana, termasuk untuk dibuka melalui ngrok, adalah membuat aset statis:

```powershell
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Biarkan terminal server tetap terbuka. Buka:

```text
http://127.0.0.1:8000
```

Jika mengedit tampilan secara aktif, gunakan terminal kedua:

```powershell
npm run dev
```

Untuk penggunaan melalui ngrok, hentikan Vite dengan `Ctrl+C` lalu jalankan `npm run build` agar halaman publik tidak bergantung pada alamat Vite lokal. Jika Vite sebelumnya berhenti tidak normal dan halaman masih mencoba memuat port 5173, periksa file penanda `public/hot`; hapus hanya file penanda itu ketika server Vite memang sudah berhenti.

Aplikasi memakai beberapa pustaka dan gambar dari internet, sehingga koneksi internet tetap diperlukan untuk tampilan lengkap serta pembayaran. Panduan ini menggunakan server Laravel; Apache tidak perlu melayani proyek yang sama. MySQL tetap harus aktif.

## 10. Isi data awal melalui admin

1. Masuk sebagai admin dan buka `/dashboard`.
2. Buat kategori layanan dan aktifkan kategorinya.
3. Tambahkan layanan: kategori, harga, durasi, deskripsi, status aktif, dan gambar opsional.
4. Tambahkan staf aktif dan pilih layanan yang dikuasai.
5. Isi jam operasional dan jadwal staf.
6. Daftarkan akun pelanggan melalui halaman Daftar.
7. Coba buat pemesanan sebagai pelanggan atau melalui Tambah Pemesanan di admin.

Seeder proyek hanya memanggil seeder admin. Jangan mengharapkan kategori, layanan, pelanggan, atau staf contoh otomatis tersedia pada database kosong.

Gambar layanan mendukung JPG, PNG, dan WebP dengan ukuran maksimal 2 MB. Layanan tanpa gambar memakai gambar default. Saat menyunting data lama, pilih kategori lalu simpan agar `service_category_id` terisi jika sebelumnya kosong.

## 11. Konfigurasi Midtrans Sandbox

Buka akun [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/) dan ambil Server Key serta Client Key Sandbox melalui pengaturan akses akun. Masukkan ke `.env`:

```dotenv
MIDTRANS_SERVER_KEY=SERVER_KEY_SANDBOX_ANDA
MIDTRANS_CLIENT_KEY=CLIENT_KEY_SANDBOX_ANDA
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

Gunakan pasangan key dari akun dan lingkungan yang sama. Jangan menyalin nilai contoh di atas sebagai key sungguhan atau memasukkan `.env` ke repository publik.

```powershell
php artisan config:clear
```

## 12. Hubungkan webhook dengan ngrok

Midtrans membutuhkan URL yang bisa diakses dari internet. `localhost` tidak bisa digunakan sebagai tujuan webhook dari server Midtrans. [Panduan webhook Midtrans](https://docs.midtrans.com/docs/https-notification-webhooks)

Daftarkan akun ngrok, instal aplikasinya, lalu jalankan sekali dengan token ngrok milik Anda:

```powershell
ngrok config add-authtoken TOKEN_NGROK_ANDA
```

Dengan Laravel tetap berjalan di port 8000, buka terminal lain:

```powershell
ngrok http 8000
```

Salin URL HTTPS yang ditampilkan ngrok. Contoh:

```text
https://alamat-anda.ngrok-free.dev
```

Di dashboard **Sandbox** Midtrans, isi **Payment Notification URL** dengan:

```text
https://alamat-anda.ngrok-free.dev/payment/midtrans/webhook
```

Jangan memakai URL halaman detail atau checkout sebagai webhook. Jika URL ngrok berubah, perbarui pengaturan Midtrans. Untuk inspeksi permintaan, buka `http://127.0.0.1:4040` jika inspector lokal tersedia. [Instalasi dan penggunaan ngrok](https://ngrok.com/download/windows)

Jika mengakses website melalui ngrok, gunakan URL ngrok tersebut secara konsisten selama pengujian login dan pembayaran. Untuk tautan yang dibuat di luar request web, `APP_URL` bisa disesuaikan ke URL publik lalu jalankan `php artisan config:clear`.

## 13. Uji pembayaran sampai status berubah

1. Masuk sebagai pelanggan.
2. Buat pemesanan dengan layanan dan staf aktif.
3. Buka Riwayat Pemesanan, lalu Lihat Detail.
4. Klik Bayar Sekarang untuk membuka popup Midtrans.
5. Pilih metode pembayaran Sandbox.
6. Selesaikan simulasi sesuai metode melalui [panduan dan simulator resmi Midtrans](https://docs.midtrans.com/docs/testing-payment-on-sandbox). Gunakan simulator Sandbox, bukan pembayaran uang sungguhan.
7. Pastikan ngrok dan Laravel masih berjalan ketika notifikasi dikirim.
8. Periksa Notification History di Midtrans. Endpoint harus menerima POST dan mengembalikan HTTP 200 jika berhasil diproses.
9. Muat ulang detail pelanggan dan daftar pemesanan admin.

| Status Midtrans | Status pembayaran aplikasi | Status pemesanan |
| --- | --- | --- |
| `pending` | Menunggu Pembayaran | Menunggu Pembayaran |
| `settlement` | Lunas | Terkonfirmasi |
| `capture` yang diterima | Lunas | Terkonfirmasi |
| `expire` | Kedaluwarsa | Kedaluwarsa |
| `cancel` | Dibatalkan | Dibatalkan |

Lunas tidak berarti perawatan sudah selesai. Admin mengubah status pengerjaan sampai Selesai sesuai pelayanan. Notifikasi berstatus `pending` dan kode `201` belum menyatakan lunas. [Notifikasi QRIS](https://docs.midtrans.com/reference/qris)

## 14. Batas pembayaran dan email

Pemesanan baru memiliki batas pembayaran bawaan 24 jam sejak dibuat. Admin dapat menentukan batas berbeda. Pengingat dan batas waktunya tampil di riwayat/detail pelanggan; setelah lewat, tombol pembayaran tidak tersedia.

Saat ini pengingat tersebut adalah notifikasi dalam halaman, bukan pengiriman email atau WhatsApp terjadwal. Proyek belum menjadwalkan perubahan seluruh pemesanan kedaluwarsa secara otomatis; status kedaluwarsa pembayaran juga dapat diterima dari webhook Midtrans.

Dengan `MAIL_MAILER=log`, email seperti pengaturan ulang kata sandi ditulis ke `storage/logs/laravel.log`, bukan ke kotak masuk. Untuk pengiriman nyata, siapkan layanan SMTP dan isi pengaturan mail sesuai penyedianya.

## 15. Menjalankan kembali pada hari berikutnya

Tidak perlu memasang ulang dependensi, membuat APP_KEY, atau menjalankan seeder setiap hari.

1. Nyalakan MySQL.
2. Masuk ke folder proyek.
3. Jika aset berubah, jalankan `npm run build`.
4. Jalankan `php artisan serve --port=8000`.
5. Jika menguji pembayaran, jalankan `ngrok http 8000` dan pastikan URL webhook sesuai.
6. Buka website dan masuk dengan akun yang sudah ada.

Queue worker hanya diperlukan jika menggunakan pekerjaan antrean. Alur pembayaran saat ini menerima webhook lewat request HTTP, bukan melalui worker queue. Jangan bergantung pada `composer run dev` di Windows: script proyek juga menjalankan Laravel Pail yang dapat memerlukan ekstensi `pcntl`.

## 16. Pemecahan masalah

| Masalah | Pemeriksaan atau tindakan |
| --- | --- |
| `php`/`composer` tidak dikenali | Periksa PATH, lalu buka terminal baru. |
| `could not find driver` | Aktifkan `pdo_mysql` pada PHP terminal. |
| `Unknown database` | Buat database dengan nama yang sesuai `.env`. |
| `Access denied` MySQL | Periksa username, password, host, dan port. |
| Migrasi foreign key staff gagal | Periksa referensi `staff` versus `staffs` pada langkah 6. |
| `No application encryption key` | Untuk instalasi baru, jalankan `php artisan key:generate`. |
| Tabel `sessions`/`cache` tidak tersedia | Pastikan migrasi sudah selesai pada database yang dipakai aplikasi. |
| `Vite manifest not found` | Jalankan `npm install`, kemudian `npm run build`. |
| CSS tidak muncul melalui ngrok | Gunakan build statis dan pastikan penanda Vite lokal tidak tertinggal. |
| Gambar upload 404 | Periksa `storage:link`, file gambar, dan izin folder. |
| Upload gambar ditolak | Periksa format, batas 2 MB, `fileinfo`, `upload_max_filesize`, dan `post_max_size`. |
| HTTP 403 | Periksa peran pengguna; pada webhook, cek kecocokan key/signature. |
| HTTP 419 pada form | Muat ulang halaman, pastikan sesi aktif dan domain konsisten. |
| HTTP 404 saat menambah pemesanan | Buka lewat tombol Tambah Pemesanan dan jalankan `php artisan route:clear` jika memakai cache route lama. |
| Webhook gagal/tidak ada respons | Periksa proses Laravel, tunnel aktif, port target, URL webhook, dan inspector ngrok. |
| Webhook HTTP 404 `Payment not found` | Pastikan order ID ada pada `payments.payment_reference` di database aplikasi yang benar. |
| Webhook HTTP 422 `Invalid payment amount` | Cocokkan nominal di database dengan transaksi Midtrans; jangan menandai lunas secara paksa. |
| Midtrans lunas tetapi aplikasi pending | Cari notifikasi `settlement`, pastikan berhasil diproses, lalu muat ulang halaman. |
| HTTP 500 | Baca error terakhir di `storage/logs/laravel.log`. |
| Warning CRLF/LF Git | Ini peringatan akhir baris, bukan error aplikasi. Simpan file sebagai LF. |

Perintah pemeriksaan:

```powershell
php artisan route:list
php artisan migrate:status
php artisan config:clear
php artisan route:clear
php artisan view:clear
Get-Content storage/logs/laravel.log -Tail 80
```

Jika `php artisan storage:link` sudah berhasil, tidak perlu menjalankannya berulang. Hindari memposting log yang berisi key, cookie, atau data pelanggan ke tempat publik.

## 17. Pengujian di database sementara

Untuk menjalankan pengujian khusus yang sudah dibuat tanpa memakai database MySQL utama, buka terminal PowerShell terpisah dan jalankan:

```powershell
$env:DB_CONNECTION = 'sqlite'
$env:DB_DATABASE = ':memory:'
php artisan test --filter='AdminBookingPageTest|ServiceImageTest|ProfileTest|PasswordUpdateTest|BookingDeadlineTest'
Remove-Item Env:DB_CONNECTION
Remove-Item Env:DB_DATABASE
```

Perintah ini memerlukan ekstensi SQLite PHP. Pengujian tersebut tidak melakukan pembayaran sungguhan. Pengujian integrasi lengkap tetap dilakukan melalui Sandbox pada langkah 13.

## 18. Tanda website siap dipakai untuk pengujian lokal

- Beranda terbuka dengan nama, logo, serta tampilan Indah Salon.
- Admin bisa masuk dan mengelola kategori, layanan, staf, serta jadwal.
- Gambar layanan tampil dan gambar default tersedia.
- Pelanggan bisa mendaftar, masuk, dan membuat pemesanan.
- Admin bisa menambah pemesanan manual.
- Popup pembayaran Sandbox terbuka.
- Notifikasi `settlement` menghasilkan pembayaran Lunas dan pemesanan Terkonfirmasi.
- Laporan menampilkan transaksi sesuai implementasi filter yang tersedia.

Panduan ini khusus pengembangan lokal. Untuk server publik permanen, gunakan konfigurasi produksi, HTTPS, pengelolaan kredensial, dan server web yang melayani folder `public`. Rujukan umum pemasangan: [Laravel 12](https://laravel.com/framework/docs/12.x/installation).

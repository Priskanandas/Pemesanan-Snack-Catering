## Surya Catering:
Halo semuanya , terima kasih telah mengunjungi Repository git ku, proyek ini merupakan sistem pemesanan snack dan catering berbasis laravel yang saya gunakan sebagai tugas akhir saya di UTDI Yogyakarta, berhubungan karena ini hanya web Eccomerce biasa saja yang hanya ditujukan untuk ujian. mohon maaf sebesarnya karena ada beberapa fitur dari web ini yang sengaja dimatian oleh Web Hostnya seperti upload gambar dan menampilkan gambar yang diupload karena saat development saya menggunakan storage:link atau symbolic link yang dimana Sistem ini diblok oleh kebanyakan hosting gratis. 

## Alert
mungkin ada beberapa fitur yang mungkin secara tidak disengaja lupa dikerjakan  atau ada kesalahan lainnya mohon dimaklumi karena mungkin ada kelupaan saat 
developemnt. mengenai web satu ini disarankan untuk menonton video demonstrasinya (maaf kalau tidak ada penjelasan ya) karena ada beberapa bagian yang ditutupi oleh middleware seperti admin dan lain-lainnya.

## Warning
dihimbau untuk tidak menggunakan data informasi yang asli saat mencoba registerasi atau login. karena jika terjadi kebocoran data tidak akan ditanggung oleh developer. 
# Pemesanan Snack & Catering – Surya Catering

Aplikasi web sederhana untuk membantu proses pemesanan snack dan katering, dikembangkan untuk mendukung operasional bisnis keluarga *Surya Catering*. Sistem ini memudahkan pelanggan melihat menu, melakukan pemesanan, dan mempercepat pengelolaan data pesanan.

## ✨ Fitur Utama

- Melihat katalog menu digital (makanan & snack)
- Form pemesanan berbasis web
- Manajemen menu oleh admin (CRUD)
- Update katalog secara real-time
- Konfirmasi dan pencatatan pesanan

## 🛠️ Teknologi yang Digunakan

- **Laravel** (PHP Framework)
- **MySQL** (Database)
- **Bootstrap 4/5** (Tampilan antarmuka)
- **JavaScript & jQuery**

## 🧑‍💻 Akun

Jika tersedia sistem login:
- **Admin**
  - Email: `admin@gmail.com`
  - Password: `admin123`
- **User**: 

## ⚙️ Instalasi Lokal

Langkah-langkah untuk menjalankan proyek di komputer Anda:

```bash
git clone https://github.com/Priskanandas/Pemesanan-Snack-Catering.git
cd Pemesanan-Snack-Catering
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve


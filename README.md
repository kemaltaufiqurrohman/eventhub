EventHub – Sistem Manajemen Event

EventHub adalah aplikasi berbasis web yang dibuat dengan Laravel untuk membantu proses pengelolaan event kampus. Mulai dari pembuatan event, pendaftaran peserta, presensi pakai QR Code, sampai penerbitan sertifikat otomatis.

Project ini dibuat sebagai bagian dari tugas mata kuliah / proyek pengembangan aplikasi.

🎯 Fitur-Fitur Utama
👥 Role Pengguna

Admin
Mengelola user dan memantau semua aktivitas sistem.

Panitia
Membuat event, mengelola peserta, melakukan presensi, dan mengatur sertifikat.

Mahasiswa
Melihat dan mendaftar event, presensi, serta mengunduh sertifikat.

📝 Manajemen Event

Membuat, edit, dan hapus event.

Menentukan kategori event.

Upload template sertifikat.

🧍‍♂️🧍‍♀️ Pendaftaran Peserta

Mahasiswa daftar event secara online.

Panitia bisa melihat semua pendaftar.

📱 Presensi QR Code

Sistem otomatis bikin QR Code untuk presensi.

Panitia scan QR langsung via web.

🏅 Generate Sertifikat Otomatis

Sertifikat PDF otomatis keluar setelah peserta memenuhi syarat presensi.

Sertifikat berisi nama peserta, nama event, dan QR Code validasi.

🛠 Teknologi yang Dipakai

Laravel 10

MySQL

Blade Template

TailwindCSS

DOMPDF (PDF Generator)

Simple QrCode

📌 Cara Menjalankan Project (Singkat & Jelas)
1. Clone project
git clone https://github.com/kemaltaufiqurrohman/eventhub.git
cd eventhub

2. Install dependency
composer install
npm install
npm run build

3. Setup environment
cp .env.example .env
php artisan key:generate

4. Migrasi database
php artisan migrate --seed

5. Jalankan server
php artisan serve

📚 Tujuan Pembuatan

Project ini dibuat untuk memenuhi tugas pembuatan aplikasi web sekaligus mempraktikkan:

Autentikasi dan role user

CRUD data

QR Code scanning

Generate PDF

Workflow event management

👨‍💻 Dikembangkan oleh

Kemal Taufiqurrohman
Mahasiswa Universitas Jember

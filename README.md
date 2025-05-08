<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Simple Absensi dan Nilai Mahasiswa

## Tech Stack
Project ini menggunakan teknologi berikut:

- **Laravel 12** - Framework PHP
- **MySQL** - Database management system
- **Nginx** - Web server

## Feature
1. authentication
2. crud mata pelajaran
3. crud mahasiswa
4. crud pertemuan
5. create and update absen mahasiswa berdasarkan mata pelajaran dan pertemuan
6. create and update nilai mahasiswa berdasarkan mata pelajaran

## Instalasi
Untuk menjalankan proyek ini secara lokal, pastikan Anda telah menginstal **Laragon** atau **Xampp** dan **composer**.

1. **Clone repositor**
    - Clone project dari repository dengan menggunakan perintah berikut:
   ```bash
   git clone https://github.com/rnaufal52/absensidannilaimahasiswa.git
   cd absensidannilaimahasiswa
   ```
2. **Install Composer Dependencies dan node js**

    - Jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:
        ```bash
        composer install
        ```
    - Jalankan perintah berikut untuk menginstall semua dependensi node js yang diperlukan:
       ```bash
        npm install
        ```
3. **Copy dan Paste File .env**

    - Salin semua data dari file `.env.example` dan tempelkan di file `.env`:
        ```bash
        cp .env.example .env
        ```
4. **Buat database**

    - Jalankan perintah berikut untuk menghasilkan kunci proyek:
        ```bash
        ganti .env bagian database dengan nama database yang dibuat serta menjadi mysql
        ```
5. **Migrasi database:**
   ```bash
   php artisan migrate --seed
   ```
6. **Jalankan aplikasi**
   - Jalankan server node js
     ```bash
     npm run dev
     ```
   - Jalankan server laravel (jika bukan menggunakan laragon)
     ```bash
     php artisan start
     ```
8. Akses aplikasi melalui browser di `http://localhost::8000` atau `http://absensidannilaimahasiswa.test` jika menggunakan laragon.

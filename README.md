<div align="center">

# 🎮 MobiPlay | Digital Entertainment & Top-Up Platform

**Platform Web Modern untuk Top Up Game, Layanan Digital, & Voucher Streaming**

</div>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
</p>


## 📋 Tentang Aplikasi

**MobiPlay** adalah aplikasi web yang menyediakan layanan **top-up game online**, **voucher digital**, dan **layanan hiburan** dengan sistem transaksi cepat, aman, dan transparan.  
Didesain khusus untuk memberikan pengalaman belanja digital yang nyaman bagi pengguna, serta panel admin modern untuk pengelolaan produk, pesanan, dan laporan.

Dengan **UI responsif** dan **dashboard analitik interaktif**, MobiPlay menjadi solusi ideal untuk bisnis digital di era hiburan online.

---

## ✨ Fitur Unggulan

<table width="100%">
  <tbody>
    <tr>
      <td width="50%" valign="top">
        <h3>🏠 Dashboard & Analitik</h3>
        <ul>
          <li>📊 Ringkasan transaksi & statistik penjualan real-time.</li>
          <li>📈 Chart pendapatan bulanan & tren order.</li>
          <li>🃏 Card informasi total produk, pesanan, user, dll.</li>
        </ul>
      </td>
      <td width="50%" valign="top">
        <h3>🛒 Manajemen Produk</h3>
        <ul>
          <li>🎮 CRUD lengkap untuk produk (FF, PUBG, MLBB, dll).</li>
          <li>📂 Manajemen kategori game & layanan digital.</li>
          <li>📝 Custom Input Field (User ID, Zone, Server, Region, Username, dll).</li>
        </ul>
      </td>
    </tr>
    <tr>
      <td width="50%" valign="top">
        <h3>📑 Order & Pembayaran</h3>
        <ul>
          <li>💳 Sistem order terintegrasi (riwayat transaksi, order items).</li>
          <li>⚡ Multi payment support (Dana, OVO, GoPay, ShopeePay, LinkAja, Bank Transfer).</li>
          <li>🔔 Notifikasi status order (pending, success, failed).</li>
        </ul>
      </td>
      <td width="50%" valign="top">
        <h3>📢 Konten & Iklan</h3>
        <ul>
          <li>📰 Manajemen artikel/berita seputar game & hiburan.</li>
          <li>📢 Manajemen advertisement/banner promosi.</li>
          <li>🎯 Target URL untuk iklan eksternal.</li>
        </ul>
      </td>
    </tr>
    <tr>
      <td width="50%" valign="top">
        <h3>👤 Manajemen Pengguna</h3>
        <ul>
          <li>🙋 Registrasi & login user.</li>
          <li>🔐 Manajemen profil & logout.</li>
          <li>🛡️ Role-based access untuk Admin & User.</li>
        </ul>
      </td>
      <td width="50%" valign="top">
        <h3>⚙️ Lainnya</h3>
        <ul>
          <li>🌙 Dark Mode & UI responsif (mobile & tablet).</li>
          <li>🖼️ Banner dinamis dengan rasio 2:1.</li>
          <li>📤 Export data order untuk laporan.</li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

---

## 🛠️ Teknologi Yang Digunakan

- **Backend Framework**: [Laravel 10+](https://laravel.com/docs)  
- **Bahasa**: [PHP 8.2+](https://www.php.net/)  
- **Frontend Styling**: [Tailwind CSS](https://tailwindcss.com/docs)  
- **JavaScript Framework**: [Alpine.js](https://alpinejs.dev/start-here)  
- **Database**: [MySQL 8.0+](https://dev.mysql.com/doc/)  

---

## 🚀 Panduan Instalasi

<details>
<summary><strong>Klik untuk melihat langkah-langkah instalasi</strong></summary>
<br>

### 📦 Prasyarat
Pastikan environment Anda telah terinstal:
- [PHP 8.2+](https://www.php.net/downloads.php)
- [Composer 2.0+](https://getcomposer.org/download/)
- [Node.js 18+](https://nodejs.org/en/download)
- [MySQL 8.0+](https://dev.mysql.com/downloads/mysql/)

### 1. Clone Repository
```bash
git clone https://github.com/username/mobiplay.git
cd mobiplay
```

### 2. Instalasi Dependensi
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mobiplay
DB_USERNAME=root   # user database
DB_PASSWORD=       # password database
```

### 5. Migrasi dan Seeder
```bash
php artisan migrate --seed
```

### 6. Build Asset Frontend
```bash
npm run build    # untuk production
```

### 7. Jalankan Website
```bash
npm run dev        # untuk development
composer run dev   # alternatif via composer
```

🎉 Website berjalan di http://localhost:8000
 atau sesuai konfigurasi vite.

</details> 

## 🔑 Akun Demo

| Role   | Email                | Password  |
|--------|----------------------|-----------|
| 👑 **Admin** | `admin@gmail.com` | `admin123` |
| 🙍 **User**  | `user@gmail.com`  | `password123` |

> ⚡ Gunakan akun di atas untuk mencoba fitur MobiPlay tanpa perlu registrasi.  

---

<div align="center">

<h3>💡 MobiPlay – Solusi Top Up Game & Hiburan Digital yang Cepat, Aman, dan Terpercaya</h3>

<p>Jika proyek ini bermanfaat, jangan lupa beri bintang ⭐ di repository untuk mendukung pengembangan lebih lanjut!</p>

<hr style="height:1px; width:50%; border-width:0; color:gray; background-color:gray; margin: 20px auto;">

<p>
  <a href="mailto:nyomangedeewisaya@gmail.com">📧 Email</a> &nbsp;&nbsp;|&nbsp;&nbsp;
  <a href="https://wa.me/6285788773480">💬 WhatsApp</a> &nbsp;&nbsp;|&nbsp;&nbsp;
  <a href="https://mobiplay.com">🌐 Website</a>
</p>

</div>

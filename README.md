# Sistem Informasi Kantin Digital - SIT As-Salaam Jayapura

Aplikasi manajemen kantin sekolah terpadu berbasis **CodeIgniter 4** dan **Framework7** yang dirancang untuk mengelola transaksi kantin non-tunai (cashless), saldo siswa/santri, rekapitulasi belanja orang tua, stand kantin, serta manajemen database sekolah.

---

## 🌟 Fitur Utama

### 1. Panel Admin & Petugas (Dashboard Web)
* **Manajemen Pengguna (Multi-Level RBAC):**
  * Super Admin (Level 1)
  * Petugas Keuangan / Deposit
  * Pengelola Stand Kantin
  * Guru & Karyawan
  * Siswa / Santri
  * Orang Tua Siswa
* **Point of Sales (Kasir Kantin):**
  * Transaksi belanja cepat menggunakan Scan Barcode / QR Code kartu siswa.
  * Dukungan struk transaksi dan potongan saldo otomatis.
* **Top-Up & Deposit:**
  * Deposit saldo kartu siswa secara langsung di petugas kantin/keuangan.
* **Laporan & Rekapitulasi:**
  * Laporan penjualan harian, mingguan, dan bulanan.
  * Rekapitulasi per stand kantin dan export ke Microsoft Excel (`.xlsx`).
* **Database Manager Terintegrasi (Full CRUD):**
  * Akses langsung ke seluruh tabel database melalui antarmuka admin tanpa perlu tools eksternal (seperti `adminer.php`).
  * Dukungan pencarian cepat lintas kolom, pagination, dan filter.
  * Form tambah dan edit dinamis dengan deteksi otomatis tipe data kolom, status *auto-increment*, opsi *NULL*, serta enkripsi otomatis *BCRYPT* (`password_hash`) untuk kolom password.
  * SQL Query Editor interaktif untuk eksekusi query custom (`SELECT`, `INSERT`, `UPDATE`, dsb.).

### 2. Portal Siswa & Orang Tua (Mobile Web Application)
* **Tampilan Mobile Native:** Antarmuka responsif ramah smartphone berbasis Framework7.
* **Monitoring Saldo Realtime:** Informasi sisa saldo kartu digital.
* **Rekap Belanja Bulanan:** Card ringkasan total pengeluaran belanja per bulan yang dapat difilter berdasarkan bulan dan tahun.
* **Rincian Transaksi:** Detail item makanan/minuman yang dibeli, harga, waktu belanja, dan stand kantin terkait.
* **Kartu Virtual & QR Code:** QR code digital siswa untuk verifikasi transaksi belanja di kantin.

---

## 🛠️ Teknologi & Stack

* **Backend Framework:** [CodeIgniter 4](https://codeigniter.com/)
* **Bahasa:** PHP (7.4 / 8.0+)
* **Database:** MySQL / MariaDB
* **Frontend Web Admin:** Bootstrap 5, Nazox Admin Dashboard Template, DataTables
* **Frontend Mobile Client:** Framework7, FontAwesome, Material Design Icons
* **Library Pendukung:**
  * `chillerlan/php-qrcode` (QR Code Generator)
  * `phpoffice/phpspreadsheet` (Import & Export Excel)
  * `hermawan/codeigniter4-datatables` (Server-side DataTables CI4)

---

## 📁 Struktur Direktori

```text
kantin/
├── assets/                  # File statis (CSS, JS, gambar, template admin & mobile)
│   ├── client/              # File aset & theme Framework7 untuk portal siswa & ortu
│   ├── css/ & js/           # Aset UI dashboard admin
│   └── libs/                # Library pihak ketiga (Bootstrap, DataTables, SimpleBar, dll.)
├── database/                # File skema database (SQL)
│   └── db_kantin.sql        # Database dump awal SIT As-Salaam Jayapura
├── format_import_*.xlsx     # Template Excel untuk import massal siswa, guru, & barang
├── index.php                # Front controller utama aplikasi
├── README.md                # Dokumentasi proyek
└── ~core/                   # Direktori inti CodeIgniter 4
    ├── app/
    │   ├── Config/          # Konfigurasi aplikasi, rute (Routes.php), & database
    │   ├── Controllers/     # Controller Admin, Kasir, Kantin, Ortu, & Siswa
    │   ├── Models/          # Model database CodeIgniter 4
    │   └── Views/           # Template & view (Admin, Ortu, Siswa, Petugas)
    ├── system/              # Sistem inti framework CodeIgniter 4
    ├── vendor/              # Dependensi Composer (PhpSpreadsheet, QR Code, dll.)
    └── writable/            # Direktori cache, log, dan sesi
```

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat Sistem
* Web Server (Apache / Nginx / XAMPP / Laragon)
* PHP versi **7.4** atau **8.0+**
* Ekstensi PHP yang aktif: `intl`, `mbstring`, `mysqli`, `gd`, `curl`, `json`
* MySQL / MariaDB Server

### 2. Kloning Repositori
```bash
git clone https://github.com/septaryanhidayat/kantin-assalaam.git
cd kantin-assalaam
```

### 3. Konfigurasi Database
1. Buat database baru di MySQL (misal: `kantin` atau `pesonaas_db_kantin`).
2. Import file SQL yang berada di direktori `database/db_kantin.sql`:
   ```bash
   mysql -u root -p kantin < database/db_kantin.sql
   ```
3. Buka file konfigurasi database di `~core/app/Config/Database.php` dan sesuaikan kredensial:
   ```php
   public $default = [
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'kantin',
       'DBDriver' => 'MySQLi',
       ...
   ];
   ```

### 4. Konfigurasi Base URL
Buka `~core/app/Config/App.php` dan ubah `baseURL` sesuai domain atau path lokal Anda:
```php
public $baseURL = 'http://localhost/kantin/';
```

### 5. Menjalankan Aplikasi
* Buka browser dan akses URL: `http://localhost/kantin/`
* Halaman login admin: `http://localhost/kantin/admin/login` atau `http://localhost/kantin/login`

---

## 🌐 Panduan Deployment ke cPanel

1. **Upload File:**
   * Ekstrak seluruh file ke folder `public_html` (atau subdomain).
   * Pastikan file `.htaccess` dan `index.php` berada di root direktori public.
2. **Database:**
   * Buat database MySQL dan user database melalui menu **MySQL Databases** di cPanel.
   * Import file `database/db_kantin.sql` melalui **phpMyAdmin** cPanel.
3. **Konfigurasi Environment cPanel:**
   * Sesuaikan konfigurasi user & password database pada file `~core/app/Config/Database.php`.
   * Sesuaikan `baseURL` pada `~core/app/Config/App.php` menggunakan alamat domain (misal: `https://kantin.assalaam.sch.id/`).
4. **Izin Akses Folder:**
   * Pastikan folder `~core/writable` memiliki hak akses tulis (*permission* `755` atau `777`).

---

## 🔒 Catatan Keamanan
* File sensitif sesi dan log telah dimasukkan ke dalam `.gitignore` agar tidak terunggah ke repositori publik.
* Fitur manajemen database di menu admin hanya dapat diakses oleh akun admin tingkat 1 (Super Admin).
* File utility standalone seperti `adminer.php` tidak disarankan diletakkan di server produksi.

---

## 📄 Lisensi & Kontributor
Dikembangkan untuk ekosistem digital **SIT As-Salaam Jayapura**.
* Repository: [septaryanhidayat/kantin-assalaam](https://github.com/septaryanhidayat/kantin-assalaam)

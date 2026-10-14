# SmaCan versi Laravel (Blade + Eloquent + Migration + Seeder)

Folder ini adalah **paket tempel (overlay)**: hanya berisi file milik SmaCan.
Kerangka Laravel-nya (vendor, bootstrap, config, dll.) dibuat dulu oleh Laragon/Composer,
lalu isi folder ini ditimpa ke atasnya.

## Langkah di Laragon

1. **Buat project Laravel baru**
   - Laragon: klik kanan -> Quick app -> Laravel -> nama `smacan`.
     Hasilnya `C:\laragon\www\smacan` dan alamat `http://smacan.test`.
   - Atau lewat terminal Laragon: `composer create-project laravel/laravel smacan`

2. **Tempel file SmaCan**
   Salin folder `app`, `database`, `public`, `resources`, `routes` dari paket ini ke
   `C:\laragon\www\smacan\`, lalu pilih **Replace / Timpa** jika ditanya.

3. **Atur `.env`** (di folder project), samakan bagian ini:
   ```
   APP_NAME=SmaCan
   APP_URL=http://smacan.test

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=smacan_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Pada Laravel baru, baris DB_* bisa ditandai `#`. Hapus tanda `#` dan ubah
   `DB_CONNECTION=sqlite` menjadi `mysql`.

4. **Nyalakan Laragon** (Start All), lalu buat database kosong `smacan_db`
   (tombol Database di Laragon / phpMyAdmin).

5. **Jalankan migration + seeder** (Terminal Laragon, di folder project):
   ```
   php artisan config:clear
   php artisan migrate:fresh --seed
   ```

6. **Buka** `http://smacan.test`
   (jika memakai `php artisan serve`, ubah `APP_URL=http://127.0.0.1:8000` dan buka alamat itu).

Akun demo (password `password123`):
`andi.saputra@smacan.sch.id`, `budi.rahayu@smacan.sch.id`, `siti.fatimah@smacan.sch.id`.
Selain itu ada 12 siswa dummy hasil Faker (email `siswa####@smacan.sch.id`, password sama).

## Peta konversi

| SmaCan lama (PHP native)                | SmaCan baru (Laravel)                                  |
|-----------------------------------------|--------------------------------------------------------|
| `smacan_db.sql`                         | `database/migrations/*` (5 tabel)                      |
| `app/Models/*.php` (PDO manual)         | `app/Models/*.php` (Eloquent, `$table` + `$fillable`)  |
| `app/Core/Router.php`, `routes/web.php` | `routes/web.php` (middleware `auth`)                   |
| `app/Controllers/*`                     | `app/Http/Controllers/*` (API digabung `Api/ApiController`) |
| `app/Views/*.php`                       | `resources/views/**/*.blade.php`                       |
| `database/seeder.php`                   | `database/seeders/*` + `DatabaseSeeder` (`$this->call`) |
| session manual + `password_verify`      | `Auth::attempt()` + cast `hashed`                      |
| `$_SESSION['flash']`                    | `->with('flash', [...])`                               |

Data dari database lama (akun lama dan laporan) tidak ikut terbawa. Seeder membuat data baru.

## Jika ada masalah

| Gejala | Solusi |
|---|---|
| `Access denied` / `Connection refused` | MySQL belum Start, atau `.env` belum sesuai langkah 3 |
| `Unknown database 'smacan_db'` | Buat database dulu (langkah 4) |
| `419 Page Expired` | Muat ulang halaman, lalu `php artisan config:clear` |
| Halaman tanpa CSS | `APP_URL` di `.env` belum sama dengan alamat yang dibuka |
| Upload foto gagal | Pastikan folder `public/uploads/laporan` dan `public/uploads/avatar` ada |
| Waktu laporan beda 7 jam | Ubah `'timezone'` di `config/app.php` menjadi `'Asia/Jakarta'` |

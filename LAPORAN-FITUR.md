# Laporan Implementasi Authentication dan CRUD

## Pemilihan Authentication

Authentication dibuat secara manual dengan fasilitas bawaan Laravel. Project sudah memiliki halaman login/register bertema SmaCan, model `User`, dan kolom pengguna yang spesifik (`nama`, `nis`, `kelas`, `role`); cara manual menjaga halaman dan skema tersebut tanpa menambahkan alur UI Breeze yang perlu disesuaikan. Password di-hash oleh cast `hashed` pada model. Login meregenerasi session, logout menginvalidasi session dan token CSRF.

Route landing, login, dan register dapat diakses publik. Dashboard, lokasi, poin, edukasi, profil, API internal, seluruh route laporan, dan logout dilindungi middleware `auth`. Route login/register memakai middleware `guest`.

Validasi login memeriksa email dan password serta menampilkan pesan ketika kredensial salah. Register memvalidasi nama, format dan keunikan email, panjang password minimal 8 karakter, serta kesamaan konfirmasi password.

## CRUD Upload

CRUD laporan sampah menggunakan `LaporanController` dan `Route::resource` (tanpa halaman detail `show`). Semua route pengelolaan dilindungi `auth`, dan pengguna hanya dapat mengubah atau menghapus laporannya sendiri. Setelah laporan diperbarui, kolom `edited_at` menyimpan waktu edit dan halaman daftar menampilkan label `Edited`; laporan baru belum memiliki label tersebut. Foto menerima JPG, PNG, atau WEBP dengan ukuran maksimal 2 MB. File disimpan di `storage/app/public/laporan`, path relatifnya dicatat pada kolom `laporan_sampah.foto`, dan dapat ditampilkan melalui halaman laporan. Foto lama dihapus ketika diganti atau laporan dihapus.

## Akun Dummy dan Bukti

`UserSeeder` terdaftar pada `DatabaseSeeder` dan membuat 3 akun contoh serta 10 akun Faker. Password semua akun seed adalah `password123`; akun demo pertama adalah `andi.saputra@smacan.sch.id`. Cast password pada model menyimpan hash, bukan teks password.

Untuk database lama, jalankan `php artisan migrate` agar kolom pengguna SmaCan ditambahkan dan kolom `name` lama dibuat opsional tanpa menghapus data, lalu `php artisan db:seed --class=UserSeeder`. `migrate:fresh` tidak diperlukan untuk tugas ini karena menghapus seluruh tabel.

Di phpMyAdmin, pilih database aplikasi lalu jalankan:

```sql
SELECT id, nama, email, password, role FROM users ORDER BY id;
```

Kolom `password` seharusnya menampilkan hash bcrypt/Argon, bukan `password123`. Untuk bukti CRUD, jalankan `php artisan storage:link`, login, buat laporan dengan foto, lalu buka tabel `laporan_sampah` di phpMyAdmin dan periksa path `foto` (contoh: `laporan/....jpg`). Folder fisiknya ada di `storage/app/public/laporan`; ambil tangkapan layar tabel dan folder tersebut setelah mengunggah foto.
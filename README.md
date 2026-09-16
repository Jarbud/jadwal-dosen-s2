# Jadwal Dosen S2 — Magister Manajemen Eksekutif

Aplikasi web untuk menampilkan, memfilter, dan mengelola **jadwal perkuliahan dosen S2 Magister Manajemen Eksekutif** dengan sumber data otomatis dari **Google Spreadsheet**.

Data jadwal diambil live via CSV (`gviz/tq?tqx=out:csv`) dari Google Sheet, diparsing di backend, lalu ditampilkan dalam tabel interaktif dengan filter, statistik, dan export Excel / PDF.

> Repo: https://github.com/Jarbud/jadwal-dosen-s2.git

## Fitur

- **Integrasi Google Spreadsheet** — ambil data otomatis dari sheet `Data` tanpa input manual ke database
- **Tabel jadwal interaktif** — kolom Tanggal, Jam (18.30–20.30), Batch, Mata Kuliah, Dosen, Materi, Sub Materi, Periode, Tahun Ajaran
- **Filter & pencarian** — filter per batch, dosen, matakuliah, periode, dan pencarian teks (Alpine.js)
- **Statistik ringkas** — kartu statistik total sesi, dosen, matakuliah, dsb
- **Export Excel & PDF** — via SheetJS (`xlsx`) dan jsPDF + autotable di sisi client
- **Modal detail / tambah / hapus** — komponen Blade: `detail-modal`, `form-modal`, `delete-modal`
- **UI responsif** — Tailwind CSS 4 + Alpine.js + layout sidebar + header
- **Parsing tanggal Indonesia** — misal `Selasa, 31 Maret 2026` → `2026-03-31`

## Teknologi

| Layer | Teknologi |
|---|---|
| Backend | Laravel 12, PHP ^8.2 |
| Frontend | Blade, Tailwind CSS 4, Vite, Alpine.js 3 |
| Export | SheetJS (xlsx), jsPDF + jspdf-autotable |
| Data | Google Spreadsheet (CSV via gviz) |
| HTTP Client | `illuminate/http` (Laravel HTTP Client, Guzzle) |

## Struktur Proyek (ringkas)

```
app/Http/Controllers/JadwalController.php  # ambil + parsing CSV Google Sheet
routes/web.php                             # GET / -> JadwalController@index
resources/views/jadwal.blade.php           # halaman utama
resources/views/layouts/app.blade.php      # layout + Alpine state
resources/views/components/                # stats-cards, filter-panel, schedule-table,
                                           # sidebar, header, toast, modals/
```

### Alur data

1. `JadwalController@index` request CSV:
   `https://docs.google.com/spreadsheets/d/{SPREADSHEET_ID}/gviz/tq?tqx=out:csv&sheet=Data`
2. Parsing `fgetcsv`, normalisasi newline, mapping header:
   `Nama Dosen, Mata Kuliah, Batch, Materi, Sub Materi, Periode, Tahun Ajaran, Tanggal`
3. Konversi tanggal Indonesia ke `Y-m-d`, default hari ini jika gagal parse
4. Kirim `$jadwalList` ke view `jadwal`

> ID spreadsheet saat ini hardcode di `JadwalController.php:12`. Untuk sheet lain, ubah `$spreadsheetId` dan `$sheetName` di sana.

## Syarat

- PHP ^8.2 + ekstensi umum Laravel (openssl, mbstring, tokenizer, xml, ctype, json, sqlite/mysql)
- Composer 2.x
- Node.js 18+ & npm
- Akses internet (untuk fetch Google Sheet + CDN Alpine/jsPDF)

## Instalasi

```bash
# 1. Clone
git clone https://github.com/Jarbud/jadwal-dosen-s2.git
cd jadwal-dosen-s2

# 2. Install dependency
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Database (default sqlite)
# untuk sqlite:
touch database/database.sqlite
php artisan migrate --force

# 5. Jalankan (dev)
composer dev
# atau manual:
# php artisan serve
# npm run dev

# 6. Build production
npm run build
```

Atau sekali jalan (script sudah ada di `composer.json`):

```bash
composer setup
```

Lalu buka: **http://localhost:8000**

## Konfigurasi Google Sheet

1. Sheet harus **share: Anyone with the link → Viewer**.
2. Nama sheet default: `Data` (lihat `$sheetName` di `JadwalController`).
3. Header baris pertama wajib memuat kolom:
   `Tanggal | Batch | Mata Kuliah | Nama Dosen | Materi | Sub Materi | Periode | Tahun Ajaran`
4. Format tanggal yang didukung: `Hari, DD Bulan YYYY`, contoh `Selasa, 31 Maret 2026`.
5. Jam saat ini default `18.30-20.30` (lihat `'jam'` di controller).

Untuk ganti sumber data, edit `app/Http/Controllers/JadwalController.php`:

```php
$spreadsheetId = 'ISI_ID_SPREADSHEET_ANDA';
$sheetName = 'Data';
```

## Environment (.env)

Default memakai SQLite, jadi minim setup:

```
APP_NAME="Jadwal Dosen S2"
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

Untuk MySQL, sesuaikan `DB_*` di `.env` lalu `php artisan migrate`.

> File `.env` tidak di-commit (sudah ada di `.gitignore`). Contoh config ada di `.env.example`.

## Script Berguna

| Perintah | Fungsi |
|---|---|
| `composer dev` | serve + queue + pail + vite concurrently |
| `composer setup` | install + key + migrate + build |
| `composer test` | `php artisan test` |
| `npm run dev` | Vite dev server |
| `npm run build` | Build asset production |
| `php artisan test` | Unit/feature test |

## Deploy Singkat

```bash
composer install --no-dev --optimize-autoloader
npm install && npm run build
cp .env.example .env
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Pastikan folder `storage/` dan `bootstrap/cache/` writable, dan `APP_URL` benar.

## Troubleshooting

- **Tabel kosong** → cek share permission Google Sheet (Viewer publik) + ID/sheet name benar.
- **`APP_KEY` missing** → `php artisan key:generate`.
- **Vite manifest not found** → jalankan `npm run dev` (dev) atau `npm run build` (prod).
- **HTTP fetch gagal** → cek koneksi server ke `docs.google.com`, error akan menghasilkan list kosong (fallback di controller).

## Lisensi

MIT — sama seperti skeleton Laravel. Lihat `composer.json` (`laravel/laravel`, MIT).

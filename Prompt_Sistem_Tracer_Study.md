# Prompt Pembuatan Sistem Tracer Study

Laravel + Tailwind CSS + MySQL (Laragon)

## A. Keputusan Rancangan

**Landing page:** perlu. Landing page menjadi pintu masuk yang menjelaskan tujuan tracer study, menampilkan statistik ringkas dan pengumuman, serta berisi tombol Login dan Daftar Alumni. Tanpa landing page, alumni yang baru mengunjungi alamat web tidak tahu harus mulai dari mana.

**Login:** perlu. Satu halaman login dipakai bersama, lalu pengguna diarahkan otomatis sesuai role (admin ke /admin/dashboard, alumni ke /alumni/dashboard).

**Halaman registrasi alumni:** terpisah dari login, yaitu cari NISN, isi data diri dan akun, verifikasi email, lalu menunggu persetujuan admin.

**Jenjang:** SMK. Karena itu jurusan (kompetensi keahlian) menjadi data wajib pada setiap alumni, dan seluruh statistik serta laporan bisa dipecah per jurusan, termasuk kesesuaian bidang kerja dengan jurusan.

### Tambahan yang disarankan

- Lupa password lewat email.
- Pembatasan percobaan login (rate limiting) untuk keamanan.
- Seeder akun admin awal agar langsung bisa login setelah instalasi.
- Soft delete pada data alumni supaya data tidak hilang permanen.
- Pencarian, filter, dan pagination pada semua tabel data.
- Template Excel untuk impor data alumni (NISN, nama, tahun lulus, jurusan), lengkap dengan validasi dan laporan baris yang gagal.
- Khusus SMK: analisis keterserapan lulusan di dunia kerja per jurusan, kesesuaian bidang kerja dengan kompetensi keahlian, dan pertanyaan seputar PKL serta kompetensi yang dibutuhkan industri.
- Satu alumni hanya dapat mengisi satu kuesioner satu kali.
- Tampilan responsif (HP dan desktop) dengan Tailwind.

## B. Prompt Utama (siap disalin)

Salin mulai dari baris di bawah ini sampai akhir bagian B.

**PERAN:** Kamu adalah senior full-stack developer Laravel. Bantu saya membangun sistem Tracer Study Alumni sekolah berbasis web, lengkap dengan kode, dan jelaskan langkahnya secara bertahap supaya mudah saya ikuti.

**KONTEKS:** Sistem ini untuk sekolah SMK. Setiap alumni memiliki jurusan (kompetensi keahlian) dan tahun lulus.

**TEKNOLOGI:** Laravel versi terbaru yang stabil, PHP 8.2 ke atas, MySQL, Tailwind CSS (lewat Vite), Blade, Chart.js (npm), barryvdh/laravel-dompdf untuk PDF, maatwebsite/excel untuk Excel dan impor. Autentikasi memakai Laravel Breeze (Blade) yang disesuaikan. Lingkungan pengembangan: Laragon di Windows.

**ROLE:** dua role, yaitu admin dan alumni. Role disimpan di kolom users.role. Buat RoleMiddleware untuk membatasi akses dan AlumniDisetujui middleware agar alumni yang belum disetujui tidak bisa mengakses menu alumni.

### 1. Halaman Publik

- Landing page: navbar (Beranda, Tentang, Statistik, Pengumuman, Login, Daftar Alumni), hero, penjelasan tracer study, statistik ringkas (total alumni, jumlah sudah mengisi, persentase), alur 4 langkah pendaftaran, pengumuman terbaru, footer.
- Login: satu halaman untuk admin dan alumni, redirect otomatis sesuai role, ada link Lupa Password dan Daftar Alumni.

### 2. Alur Registrasi Alumni

1. Admin menambahkan data alumni berisi NISN dan nama (manual atau impor Excel), lengkap dengan tahun lulus dan jurusan (kompetensi keahlian) yang wajib diisi.
1. Alumni membuka halaman Daftar Alumni dan memasukkan NISN.
1. Jika NISN ditemukan dan belum pernah didaftarkan, tampilkan nama, NISN, tahun lulus, dan jurusan (semuanya read-only). Jika tidak ditemukan atau sudah dipakai, tampilkan pesan yang jelas.
1. Alumni mengisi data pribadi: jenis kelamin, tempat lahir, tanggal lahir, agama (opsional), no HP/WhatsApp, alamat lengkap, kabupaten/kota, provinsi, Instagram/LinkedIn (opsional), foto (opsional), lalu email dan password beserta konfirmasi password.
1. Sistem membuat akun dan mengirim link verifikasi email (Laravel MustVerifyEmail, link berlaku 60 menit). Sediakan halaman pemberitahuan dan tombol kirim ulang link.
1. Setelah email terverifikasi, status_registrasi menjadi menunggu_verifikasi.
1. Admin menyetujui atau menolak (dengan catatan penolakan) di menu Verifikasi Alumni. Admin hanya melihat alumni yang emailnya sudah terverifikasi.
1. Setelah disetujui, alumni dapat mengakses seluruh menu alumni. Jika ditolak, alumni melihat alasannya dan dapat memperbaiki data.

Aturan: satu NISN hanya untuk satu akun, email harus unik, NISN divalidasi 10 digit angka.

### 3. Menu Admin

Dashboard, Kelola User, Data Alumni, Kuesioner, Verifikasi Alumni, Hasil Kuesioner, Grafik Statistik, Laporan, Pengumuman, Master Data (jurusan dan tahun lulus), Log Aktivitas, Profil, Logout.

- Dashboard: kartu ringkasan (total alumni, sudah dan belum mengisi kuesioner, menunggu verifikasi), grafik status alumni, dan ringkasan keterserapan per jurusan.
- Kelola User: lihat, tambah admin, aktif/nonaktif, reset password.
- Data Alumni: CRUD NISN dan nama, impor Excel dengan template, ekspor, filter tahun lulus dan jurusan, pencarian.
- Kuesioner: CRUD kuesioner dan pertanyaan (pilihan tunggal, pilihan ganda, isian singkat, isian panjang, skala), atur periode dan status (draft/aktif/selesai).
- Verifikasi Alumni: daftar menunggu, lihat detail, setujui atau tolak dengan catatan.
- Hasil Kuesioner: jawaban per alumni dan ringkasan per pertanyaan.
- Grafik Statistik (Chart.js): status alumni (kuliah, bekerja, wirausaha, belum bekerja), masa tunggu kerja, kesesuaian bidang kerja dengan jurusan, keterserapan lulusan per jurusan, dan jumlah alumni per tahun lulus, dengan filter tahun lulus dan jurusan.
- Laporan: ekspor PDF dan Excel dengan filter tahun lulus dan jurusan, termasuk rekap per jurusan.
- Profil: ubah data dan password admin.

### 4. Menu Alumni

Dashboard, Data Diri, Status Saat Ini, Kuesioner, Riwayat Pengisian, Pengumuman, Akun (ubah password), Logout.

- Dashboard: status kelengkapan data dan kuesioner, pengumuman terbaru.
- Data Diri: lihat dan ubah biodata (NISN, nama, tahun lulus, dan jurusan tidak dapat diubah oleh alumni).
- Status Saat Ini: input dan perbarui kegiatan (kuliah, bekerja, wirausaha, belum bekerja) beserta nama instansi, bidang/jabatan, kota, tahun mulai, masa tunggu, dan kesesuaian bidang dengan jurusan (sesuai, kurang sesuai, tidak sesuai).
- Kuesioner: tampilkan kuesioner aktif, isi dan kirim satu kali, validasi pertanyaan wajib.
- Riwayat Pengisian: lihat jawaban yang sudah dikirim.

### 5. Struktur Folder (ikuti persis)

```
tracer-study/
├── app/
│   ├── Exports/
│   │   ├── AlumniExport.php
│   │   └── HasilKuesionerExport.php
│   ├── Imports/
│   │   └── AlumniImport.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── LandingController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegistrasiAlumniController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── AlumniController.php
│   │   │   │   ├── KuesionerController.php
│   │   │   │   ├── PertanyaanController.php
│   │   │   │   ├── VerifikasiAlumniController.php
│   │   │   │   ├── HasilKuesionerController.php
│   │   │   │   ├── StatistikController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   ├── PengumumanController.php
│   │   │   │   ├── MasterDataController.php
│   │   │   │   ├── LogAktivitasController.php
│   │   │   │   └── ProfilController.php
│   │   │   └── Alumni/
│   │   │       ├── DashboardController.php
│   │   │       ├── DataDiriController.php
│   │   │       ├── StatusKegiatanController.php
│   │   │       ├── KuesionerController.php
│   │   │       ├── RiwayatController.php
│   │   │       ├── PengumumanController.php
│   │   │       └── AkunController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   │   │   └── AlumniDisetujui.php
│   │   └── Requests/
│   │       ├── Admin/
│   │       └── Alumni/
│   ├── Models/
│   │   ├── User.php, Alumni.php, Jurusan.php, TahunLulus.php
│   │   ├── StatusKegiatan.php, Kuesioner.php, Pertanyaan.php
│   │   ├── OpsiPertanyaan.php, PengisianKuesioner.php, Jawaban.php
│   │   └── Pengumuman.php, LogAktivitas.php
│   └── Services/
│       ├── StatistikService.php
│       └── LogService.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminSeeder.php
│       ├── JurusanSeeder.php
│       └── TahunLulusSeeder.php
├── resources/
│   ├── css/app.css
│   ├── js/
│   │   ├── app.js
│   │   └── charts.js
│   └── views/
│       ├── layouts/
│       │   ├── guest.blade.php
│       │   ├── admin.blade.php
│       │   └── alumni.blade.php
│       ├── components/
│       │   ├── sidebar-admin.blade.php
│       │   ├── sidebar-alumni.blade.php
│       │   ├── navbar.blade.php
│       │   ├── alert.blade.php
│       │   └── kartu-statistik.blade.php
│       ├── landing/
│       │   └── index.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── cari-nisn.blade.php
│       │   ├── form-registrasi.blade.php
│       │   ├── verifikasi-email.blade.php
│       │   ├── menunggu-verifikasi.blade.php
│       │   └── lupa-password.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── user/ (index, create, edit)
│       │   ├── alumni/ (index, create, edit, import)
│       │   ├── kuesioner/ (index, create, edit, pertanyaan)
│       │   ├── verifikasi/ (index, detail)
│       │   ├── hasil/ (index, detail)
│       │   ├── statistik/index.blade.php
│       │   ├── laporan/ (index, pdf)
│       │   ├── pengumuman/ (index, create, edit)
│       │   ├── master/ (jurusan, tahun-lulus)
│       │   ├── log/index.blade.php
│       │   └── profil/index.blade.php
│       └── alumni/
│           ├── dashboard.blade.php
│           ├── data-diri/ (index, edit)
│           ├── status-kegiatan/ (index, form)
│           ├── kuesioner/ (index, isi)
│           ├── riwayat/ (index, detail)
│           ├── pengumuman/ (index, detail)
│           └── akun/index.blade.php
├── routes/
│   ├── web.php        (landing + include file lain)
│   ├── auth.php       (login, registrasi alumni, verifikasi email, lupa password)
│   ├── admin.php      (prefix /admin, middleware auth, verified, role:admin)
│   └── alumni.php     (prefix /alumni, middleware auth, verified, role:alumni, alumni.disetujui)
├── tailwind.config.js
├── vite.config.js
└── .env
```

### 6. Struktur Database (buat migration dan relasi Eloquent)

**`users:`** id, name, email (unik), email_verified_at, password, role (admin/alumni), is_active (boolean, default true), remember_token, timestamps

**`jurusan:`** id, kode (misalnya TKJ), nama (kompetensi keahlian), timestamps

**`tahun_lulus:`** id, tahun (unik), timestamps

**`alumni:`** id, user_id (FK ke users, nullable, unik), nisn (unik, 10 digit), nama, tahun_lulus_id (FK), jurusan_id (FK, wajib), jenis_kelamin, tempat_lahir, tanggal_lahir, agama, no_hp, alamat, kabupaten_kota, provinsi, instagram, linkedin, foto, status_registrasi (belum_daftar/menunggu_verifikasi/disetujui/ditolak, default belum_daftar), catatan_penolakan, diverifikasi_oleh (FK users, nullable), diverifikasi_pada, timestamps, softDeletes

**`status_kegiatan:`** id, alumni_id (FK), jenis (kuliah/bekerja/wirausaha/belum_bekerja), nama_instansi, bidang_atau_jabatan, kota, tahun_mulai, masa_tunggu_bulan, kesesuaian_bidang (sesuai/kurang_sesuai/tidak_sesuai, nullable; relevansi pekerjaan atau studi dengan jurusan alumni), is_terbaru (boolean), timestamps

**`kuesioner:`** id, judul, deskripsi, tanggal_mulai, tanggal_selesai, status (draft/aktif/selesai), dibuat_oleh (FK users), timestamps

**`pertanyaan:`** id, kuesioner_id (FK), teks, tipe (pilihan_tunggal/pilihan_ganda/isian_singkat/isian_panjang/skala), wajib (boolean), urutan, timestamps

**`opsi_pertanyaan:`** id, pertanyaan_id (FK), teks, urutan

**`pengisian_kuesioner:`** id, kuesioner_id (FK), alumni_id (FK), dikirim_pada, timestamps. Unique gabungan (kuesioner_id, alumni_id) agar satu alumni hanya sekali mengisi per kuesioner

**`jawaban:`** id, pengisian_id (FK), pertanyaan_id (FK), opsi_id (FK, nullable), isi_jawaban (text, nullable). Pilihan ganda disimpan sebagai beberapa baris

**`pengumuman:`** id, judul, isi, is_published (boolean), published_at, dibuat_oleh (FK users), timestamps

**`log_aktivitas:`** id, user_id (FK, nullable), aksi, deskripsi, ip_address, created_at

Tambahan: tabel bawaan Laravel (password_reset_tokens, sessions, cache, jobs). Buat index pada nisn, email, tahun_lulus_id, jurusan_id, dan status_registrasi.

### 7. Aturan Kode

- Gunakan Form Request untuk validasi, Policy atau middleware untuk otorisasi, dan Service class untuk logika statistik.
- Controller dipisah per folder Admin dan Alumni, route dipisah per file (web, auth, admin, alumni) dengan prefix dan nama route yang konsisten.
- Layout Blade dipisah (guest, admin, alumni), sidebar sebagai komponen, tampilan bersih dan responsif dengan Tailwind, warna utama tenang dan konsisten.
- Gunakan Eloquent dengan eager loading untuk mencegah query berulang, dan pagination pada semua daftar.
- Catat aktivitas penting ke log_aktivitas (login, verifikasi, hapus data, ubah kuesioner).
- Sertakan seeder: akun admin (email dan password awal bisa saya ganti), jurusan contoh SMK (misalnya TKJ, RPL, AKL, OTKP, BDP, TKR; nanti saya sesuaikan dengan jurusan di sekolah saya), tahun lulus contoh, beberapa data alumni dummy, dan satu kuesioner contoh tracer study SMK (status setelah lulus, masa tunggu kerja, kesesuaian bidang, relevansi kompetensi dengan kebutuhan industri, manfaat PKL, saran untuk sekolah).
- Konfigurasi email lewat .env (MAIL_*), gunakan Mailtrap atau Mailpit saat pengembangan.
- Komentar kode secukupnya dan pesan validasi dalam Bahasa Indonesia.

### 8. Cara Kerja yang Saya Minta

Kerjakan bertahap sesuai urutan di bawah. Setelah tiap tahap selesai, berikan kode lengkap per file (tulis path file di atas setiap kode), perintah artisan atau composer yang dijalankan, dan cara mengujinya. Berhenti dan tunggu konfirmasi saya sebelum lanjut ke tahap berikutnya.

1. Setup proyek, Tailwind, Breeze, struktur folder, migration, model, relasi, dan seeder.
1. Role middleware, login, dan redirect berdasarkan role.
1. Data Alumni (CRUD, impor Excel, master data jurusan dan tahun lulus).
1. Registrasi alumni lewat NISN, verifikasi email, dan menu Verifikasi Alumni.
1. Landing page dan layout admin serta alumni.
1. Kuesioner dan pertanyaan (admin), lalu pengisian dan riwayat (alumni), termasuk Status Saat Ini.
1. Dashboard, Grafik Statistik, dan Hasil Kuesioner.
1. Laporan PDF dan Excel, Pengumuman, Log Aktivitas, Profil dan Akun, lupa password.
1. Pengujian akhir dan perapian.

Mulai dari tahap 1 sekarang.

---

## C. Prompt Singkat Per Tahap (untuk lanjut di chat baru)

Jika percakapan dengan AI sudah panjang atau dimulai ulang, gunakan pola berikut agar konteksnya tidak hilang.

"Lanjutkan proyek Tracer Study Laravel + Tailwind saya. Struktur folder dan database sama seperti prompt utama. Saat ini saya di tahap [nomor dan nama tahap]. Berikut kondisi proyek saya: [tempel struktur folder atau error]. Buatkan kode lengkap per file beserta path-nya dan cara mengujinya."

Untuk perbaikan error: "Saya mendapat error berikut di tahap [..]: [tempel pesan error dan file terkait]. Jelaskan penyebabnya dan berikan perbaikan per file."

## D. Catatan Penggunaan

- Kerjakan satu tahap lalu uji di Laragon sebelum lanjut, supaya error mudah dilacak.
- Simpan setiap tahap ke Git (git commit) agar bisa kembali jika ada yang rusak.
- Ganti password admin dari seeder sebelum sistem dipakai sungguhan.
- Sesuaikan daftar jurusan di seeder dengan kompetensi keahlian yang ada di sekolah Bapak/Ibu.

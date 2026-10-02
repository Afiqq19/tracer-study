<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Jurusan;
use App\Models\Kuesioner;
use App\Models\OpsiPertanyaan;
use App\Models\Pengumuman;
use App\Models\Pertanyaan;
use App\Models\StatusKegiatan;
use App\Models\TahunLulus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Seed data dummy untuk pengujian.
     */
    public function run(): void
    {
        $jurusan = Jurusan::all();
        $tahunLulus = TahunLulus::all();
        $admin = User::where('role', 'admin')->first();

        // Data alumni dummy (sudah terdaftar & disetujui)
        $alumniData = [
            ['nisn' => '0012345001', 'nama' => 'Ahmad Fauzi', 'jk' => 'Laki-laki'],
            ['nisn' => '0012345002', 'nama' => 'Siti Nurhaliza', 'jk' => 'Perempuan'],
            ['nisn' => '0012345003', 'nama' => 'Budi Santoso', 'jk' => 'Laki-laki'],
            ['nisn' => '0012345004', 'nama' => 'Dewi Sartika', 'jk' => 'Perempuan'],
            ['nisn' => '0012345005', 'nama' => 'Rudi Hermawan', 'jk' => 'Laki-laki'],
            ['nisn' => '0012345006', 'nama' => 'Lina Marlina', 'jk' => 'Perempuan'],
            ['nisn' => '0012345007', 'nama' => 'Agus Prabowo', 'jk' => 'Laki-laki'],
            ['nisn' => '0012345008', 'nama' => 'Rina Wulandari', 'jk' => 'Perempuan'],
            ['nisn' => '0012345009', 'nama' => 'Dedi Kurniawan', 'jk' => 'Laki-laki'],
            ['nisn' => '0012345010', 'nama' => 'Maya Sari', 'jk' => 'Perempuan'],
        ];

        // Alumni yang belum mendaftar (hanya data NISN & nama dari admin)
        $alumniRaw = [
            ['nisn' => '0012345011', 'nama' => 'Joko Widodo'],
            ['nisn' => '0012345012', 'nama' => 'Fitri Handayani'],
            ['nisn' => '0012345013', 'nama' => 'Bambang Suharto'],
            ['nisn' => '0012345014', 'nama' => 'Nurul Aini'],
            ['nisn' => '0012345015', 'nama' => 'Hendra Gunawan'],
        ];

        $statusJenis = ['kuliah', 'bekerja', 'wirausaha', 'belum_bekerja'];
        $kesesuaian = ['sesuai', 'kurang_sesuai', 'tidak_sesuai'];

        foreach ($alumniData as $i => $data) {
            // Buat user untuk alumni yang sudah terdaftar
            $user = User::create([
                'name' => $data['nama'],
                'email' => 'alumni' . ($i + 1) . '@tracerstudy.test',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'alumni',
                'is_active' => true,
            ]);

            $alumni = Alumni::create([
                'user_id' => $user->id,
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'tahun_lulus_id' => $tahunLulus->random()->id,
                'jurusan_id' => $jurusan->random()->id,
                'jenis_kelamin' => $data['jk'],
                'tempat_lahir' => 'Kota Contoh',
                'tanggal_lahir' => now()->subYears(rand(20, 25))->subDays(rand(1, 365)),
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'alamat' => 'Jl. Contoh No. ' . ($i + 1),
                'kabupaten_kota' => 'Kota Contoh',
                'provinsi' => 'Jawa Barat',
                'status_registrasi' => 'disetujui',
                'diverifikasi_oleh' => $admin->id,
                'diverifikasi_pada' => now()->subDays(rand(1, 30)),
            ]);

            // Buat status kegiatan
            $jenis = $statusJenis[array_rand($statusJenis)];
            StatusKegiatan::create([
                'alumni_id' => $alumni->id,
                'jenis' => $jenis,
                'nama_instansi' => $jenis !== 'belum_bekerja' ? 'PT Contoh ' . ($i + 1) : null,
                'bidang_atau_jabatan' => $jenis !== 'belum_bekerja' ? 'Staff ' . ($i + 1) : null,
                'kota' => 'Kota Contoh',
                'tahun_mulai' => $jenis !== 'belum_bekerja' ? rand(2021, 2024) : null,
                'masa_tunggu_bulan' => in_array($jenis, ['bekerja', 'wirausaha']) ? rand(1, 18) : null,
                'kesesuaian_bidang' => in_array($jenis, ['bekerja', 'wirausaha']) ? $kesesuaian[array_rand($kesesuaian)] : null,
                'is_terbaru' => true,
            ]);
        }

        // Alumni yang belum daftar (hanya NISN dan nama)
        foreach ($alumniRaw as $data) {
            Alumni::create([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'tahun_lulus_id' => $tahunLulus->random()->id,
                'jurusan_id' => $jurusan->random()->id,
                'status_registrasi' => 'belum_daftar',
            ]);
        }

        // ===== KUESIONER CONTOH TRACER STUDY SMK =====
        $kuesioner = Kuesioner::create([
            'judul' => 'Tracer Study Alumni SMK Tahun 2024',
            'deskripsi' => 'Kuesioner tracer study untuk mengetahui kondisi alumni setelah lulus dari SMK. Data yang dikumpulkan akan digunakan untuk meningkatkan kualitas pendidikan.',
            'tanggal_mulai' => now()->subMonth(),
            'tanggal_selesai' => now()->addMonths(3),
            'status' => 'aktif',
            'dibuat_oleh' => $admin->id,
        ]);

        // Pertanyaan 1: Status setelah lulus
        $p1 = Pertanyaan::create([
            'kuesioner_id' => $kuesioner->id,
            'teks' => 'Apa status Anda saat ini setelah lulus dari SMK?',
            'tipe' => 'pilihan_tunggal',
            'wajib' => true,
            'urutan' => 1,
        ]);
        foreach (['Bekerja', 'Kuliah/Melanjutkan Pendidikan', 'Wirausaha', 'Belum Bekerja'] as $j => $opsi) {
            OpsiPertanyaan::create(['pertanyaan_id' => $p1->id, 'teks' => $opsi, 'urutan' => $j + 1]);
        }

        // Pertanyaan 2: Masa tunggu kerja
        $p2 = Pertanyaan::create([
            'kuesioner_id' => $kuesioner->id,
            'teks' => 'Berapa lama masa tunggu Anda untuk mendapatkan pekerjaan pertama setelah lulus?',
            'tipe' => 'pilihan_tunggal',
            'wajib' => false,
            'urutan' => 2,
        ]);
        foreach (['Kurang dari 3 bulan', '3-6 bulan', '6-12 bulan', 'Lebih dari 12 bulan', 'Belum mendapatkan pekerjaan'] as $j => $opsi) {
            OpsiPertanyaan::create(['pertanyaan_id' => $p2->id, 'teks' => $opsi, 'urutan' => $j + 1]);
        }

        // Pertanyaan 3: Kesesuaian bidang
        $p3 = Pertanyaan::create([
            'kuesioner_id' => $kuesioner->id,
            'teks' => 'Seberapa sesuai pekerjaan/studi lanjut Anda dengan kompetensi keahlian (jurusan) di SMK?',
            'tipe' => 'pilihan_tunggal',
            'wajib' => true,
            'urutan' => 3,
        ]);
        foreach (['Sangat Sesuai', 'Sesuai', 'Kurang Sesuai', 'Tidak Sesuai'] as $j => $opsi) {
            OpsiPertanyaan::create(['pertanyaan_id' => $p3->id, 'teks' => $opsi, 'urutan' => $j + 1]);
        }

        // Pertanyaan 4: Relevansi kompetensi
        $p4 = Pertanyaan::create([
            'kuesioner_id' => $kuesioner->id,
            'teks' => 'Kompetensi apa saja yang Anda peroleh di SMK dan berguna di dunia kerja/kuliah?',
            'tipe' => 'pilihan_ganda',
            'wajib' => true,
            'urutan' => 4,
        ]);
        foreach (['Keterampilan teknis/hard skill', 'Komunikasi', 'Kerja tim', 'Disiplin', 'Pemecahan masalah', 'Keterampilan digital'] as $j => $opsi) {
            OpsiPertanyaan::create(['pertanyaan_id' => $p4->id, 'teks' => $opsi, 'urutan' => $j + 1]);
        }

        // Pertanyaan 5: Manfaat PKL
        $p5 = Pertanyaan::create([
            'kuesioner_id' => $kuesioner->id,
            'teks' => 'Seberapa bermanfaat pengalaman PKL (Praktik Kerja Lapangan) untuk persiapan Anda di dunia kerja?',
            'tipe' => 'skala',
            'wajib' => true,
            'urutan' => 5,
        ]);
        foreach (['1 - Tidak Bermanfaat', '2 - Kurang Bermanfaat', '3 - Cukup Bermanfaat', '4 - Bermanfaat', '5 - Sangat Bermanfaat'] as $j => $opsi) {
            OpsiPertanyaan::create(['pertanyaan_id' => $p5->id, 'teks' => $opsi, 'urutan' => $j + 1]);
        }

        // Pertanyaan 6: Saran untuk sekolah
        Pertanyaan::create([
            'kuesioner_id' => $kuesioner->id,
            'teks' => 'Apa saran Anda untuk meningkatkan kualitas pendidikan di SMK agar lebih relevan dengan kebutuhan industri?',
            'tipe' => 'isian_panjang',
            'wajib' => false,
            'urutan' => 6,
        ]);

        // Pertanyaan 7: Kompetensi yang dibutuhkan industri
        Pertanyaan::create([
            'kuesioner_id' => $kuesioner->id,
            'teks' => 'Menurut Anda, kompetensi tambahan apa yang perlu diajarkan di SMK untuk memenuhi kebutuhan industri saat ini?',
            'tipe' => 'isian_panjang',
            'wajib' => false,
            'urutan' => 7,
        ]);

        // ===== PENGUMUMAN CONTOH =====
        Pengumuman::create([
            'judul' => 'Selamat Datang di Sistem Tracer Study',
            'isi' => '<p>Selamat datang di Sistem Tracer Study Alumni SMK. Sistem ini bertujuan untuk melacak dan mengumpulkan data tentang kondisi alumni setelah lulus.</p><p>Silakan lengkapi data diri dan isi kuesioner yang tersedia. Terima kasih atas partisipasi Anda!</p>',
            'is_published' => true,
            'published_at' => now(),
            'dibuat_oleh' => $admin->id,
        ]);

        Pengumuman::create([
            'judul' => 'Kuesioner Tracer Study 2024 Telah Dibuka',
            'isi' => '<p>Kami informasikan bahwa kuesioner Tracer Study tahun 2024 telah dibuka. Seluruh alumni diharapkan untuk mengisi kuesioner ini.</p><p>Batas waktu pengisian: 3 bulan ke depan. Ayo isi sekarang!</p>',
            'is_published' => true,
            'published_at' => now(),
            'dibuat_oleh' => $admin->id,
        ]);
    }
}

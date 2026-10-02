<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Deployment & Server Utility Routes
|--------------------------------------------------------------------------
| Khusus untuk otomasi pembaruan kode di server (Git pull, Composer, Migration,
| Optimize Cache) serta route helper storage file.
| Dipisahkan dari web.php agar struktur routing tetap rapi dan terisolasi.
*/

// Route Rahasia untuk Auto Deploy / Update Sistem Tracer Study di Server
Route::get('/update-rahasia-tracerstudy', function () {
    $repoDir = base_path(); // Alamat folder root Laravel di server

    // AUTO-PATCH .env untuk Timezone
    $envFile = base_path('.env');
    if (file_exists($envFile)) {
        $env = file_get_contents($envFile);
        $env = preg_replace('/^APP_TIMEZONE=.*/m', 'APP_TIMEZONE=Asia/Jakarta', $env);
        if (!str_contains($env, 'APP_TIMEZONE=')) {
            $env .= "\nAPP_TIMEZONE=Asia/Jakarta\n";
        }
        file_put_contents($envFile, $env);
    }

    // 1. Mantra Sakti mengatasi "Dubious Ownership" di server Git
    shell_exec("git config --global --add safe.directory \"$repoDir\"");
    
    // 2. Eksekusi Perintah Pembaruan Git
    $output1 = shell_exec("cd \"$repoDir\" && git fetch --all 2>&1");
    // Gunakan 'git reset' yang aman (mereset ke branch default)
    $output2 = shell_exec("cd \"$repoDir\" && git reset --hard origin/main 2>&1");
    
    // 3. Pakai Composer dengan environment temporary
    putenv('COMPOSER_HOME=/tmp');
    $output3 = shell_exec("cd \"$repoDir\" && composer install --no-interaction --prefer-dist --optimize-autoloader 2>&1");
    
    // 4. Migrate Database & Seeder
    $output4 = shell_exec("cd \"$repoDir\" && php artisan migrate --force 2>&1");
    
    // Kita cek apakah Seeder class ada sebelum dipanggil untuk menghindari error
    $output_admin = file_exists(database_path('seeders/AdminSeeder.php')) 
        ? shell_exec("cd \"$repoDir\" && php artisan db:seed --class=AdminSeeder --force 2>&1") 
        : "AdminSeeder tidak ditemukan.";
        
    $output_jurusan = file_exists(database_path('seeders/JurusanSeeder.php'))
        ? shell_exec("cd \"$repoDir\" && php artisan db:seed --class=JurusanSeeder --force 2>&1")
        : "JurusanSeeder tidak ditemukan.";

    $output_tahun = file_exists(database_path('seeders/TahunLulusSeeder.php'))
        ? shell_exec("cd \"$repoDir\" && php artisan db:seed --class=TahunLulusSeeder --force 2>&1")
        : "TahunLulusSeeder tidak ditemukan.";
    
    $output_dbseed = "DatabaseSeeder dilewati agar tidak duplicate data.";
      
    // 5. Jalankan clear cache & optimize (Penting untuk production!)
    $output_optimize = shell_exec("cd \"$repoDir\" && php artisan optimize:clear 2>&1 && php artisan optimize 2>&1");
    $output_link = shell_exec("cd \"$repoDir\" && php artisan storage:link --force 2>&1");
    
    return "<h1 style='color:green;'>✅ Berhasil Menarik Kodingan Baru & Update Sistem Tracer Study oleh MSS!</h1>
            <h3>Laporan Log:</h3>
            <pre style='background:#1e1e1e;color:#00ff00;padding:20px;border-radius:10px;overflow-x:auto;'>
[GIT FETCH & PULL]
" . htmlspecialchars((string) $output1) . "
" . htmlspecialchars((string) $output2) . "

[COMPOSER INSTALL]
" . htmlspecialchars((string) $output3) . "

[DATABASE MIGRATE & SEED]
" . htmlspecialchars((string) $output4) . "
" . htmlspecialchars((string) $output_admin) . "
" . htmlspecialchars((string) $output_jurusan) . "
" . htmlspecialchars((string) $output_tahun) . "
" . htmlspecialchars((string) $output_dbseed) . "

[OPTIMIZE & CACHE]
" . htmlspecialchars((string) $output_optimize) . "
" . htmlspecialchars((string) $output_link) . "
            </pre>";
});

// Route pembantu penyedia file storage (menjamin file lampiran/logo selalu bisa dibuka tanpa 404)
Route::get('storage/{path}', function ($path) {
    $candidates = [
        storage_path('app/public/' . $path),
        storage_path('app/private/public/' . $path),
        storage_path('app/private/' . $path),
        storage_path('app/' . $path),
        public_path('storage/' . $path),
    ];
    
    foreach ($candidates as $filePath) {
        if (file_exists($filePath) && !is_dir($filePath)) {
            $mime = mime_content_type($filePath) ?: 'application/octet-stream';
            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if ($ext === 'heic' || $ext === 'heif') {
                $mime = 'image/heic';
            }
            return response()->file($filePath, [
                'Content-Type' => $mime,
                'Access-Control-Allow-Origin' => '*',
            ]);
        }
    }
    abort(404, 'File lampiran tidak ditemukan di server.');
})->where('path', '.*');

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumni')->cascadeOnDelete();
            $table->enum('jenis', ['kuliah', 'bekerja', 'wirausaha', 'belum_bekerja']);
            $table->string('nama_instansi')->nullable();
            $table->string('bidang_atau_jabatan')->nullable();
            $table->string('kota')->nullable();
            $table->year('tahun_mulai')->nullable();
            $table->integer('masa_tunggu_bulan')->nullable();
            $table->enum('kesesuaian_bidang', ['sesuai', 'kurang_sesuai', 'tidak_sesuai'])->nullable();
            $table->boolean('is_terbaru')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_kegiatan');
    }
};

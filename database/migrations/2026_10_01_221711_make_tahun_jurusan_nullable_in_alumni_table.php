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
        Schema::table('alumni', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_lulus_id')->nullable()->change();
            $table->unsignedBigInteger('jurusan_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_lulus_id')->nullable(false)->change();
            $table->unsignedBigInteger('jurusan_id')->nullable(false)->change();
        });
    }
};

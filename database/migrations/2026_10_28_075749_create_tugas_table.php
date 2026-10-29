<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('id_pengguna')->default(1);
            $table->unsignedBigInteger('id_kategori');
            $table->string('penanggung_jawab', 100)->nullable();
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->date('deadline');
            $table->integer('tingkat_kesulitan');
            $table->integer('dampak');
            $table->integer('skor_prioritas')->nullable();
            $table->string('status')->default('Belum Mulai');
            $table->timestamp('dibuat_pada')->nullable(); // Menyesuaikan controller yang memanggil 'dibuat_pada'
            $table->timestamps(); // Menghasilkan created_at dan updated_at standar Laravel
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
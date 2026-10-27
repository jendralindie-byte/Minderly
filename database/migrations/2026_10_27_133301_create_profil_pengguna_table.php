<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_pengguna', function (Blueprint $table) {
            $table->id('id_profil');

            $table->integer('id_pengguna')->unique();

            // A. Kemampuan dan keterampilan
            $table->unsignedTinyInteger('riset');
            $table->unsignedTinyInteger('menulis');
            $table->unsignedTinyInteger('desain');
            $table->unsignedTinyInteger('presentasi');
            $table->unsignedTinyInteger('analisis');
            $table->unsignedTinyInteger('perencanaan');
            $table->unsignedTinyInteger('ketelitian');

            // B. Gaya kerja dan tanggung jawab
            $table->unsignedTinyInteger('kolaborasi');
            $table->unsignedTinyInteger('disiplin_deadline');
            $table->unsignedTinyInteger('mandiri');

            // C. Ketersediaan dan beban kerja
            $table->unsignedTinyInteger('waktu_tersedia');
            $table->unsignedTinyInteger('beban_kerja');

            $table->timestamps();

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_pengguna');
    }
};

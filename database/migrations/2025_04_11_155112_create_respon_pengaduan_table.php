<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('respon_pengaduan', function (Blueprint $table) {
            $table->id();
            
            // Gunakan tipe data yang sama dengan tabel referensi
            $table->unsignedBigInteger('pengaduan_id');
            $table->unsignedBigInteger('user_id');
            
            $table->text('isi_respon');
            $table->timestamps();
    
            // Pastikan nama tabel referensi benar (sesuai yang ada di database)
            $table->foreign('pengaduan_id')
                  ->references('id')
                  ->on('pengaduan') // Ganti 'pengaduans' menjadi 'pengaduan'
                  ->onDelete('cascade');
                  
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respon_pengaduan');
    }
};

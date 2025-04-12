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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_pengaduan')->onDelete('cascade');
            $table->string('judul', 255);
            $table->text('isi');
            $table->enum('status', ['dikirim', 'diproses', 'selesai'])->default('dikirim');
            $table->timestamps();
            $table->boolean('is_deleted')->default(false); // Adds a boolean column for soft delete

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};

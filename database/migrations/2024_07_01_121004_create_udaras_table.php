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
        Schema::create('udaras', function (Blueprint $table) {
            $table->id();
            $table->float('kecepatan_udara'); // Tipe data float untuk menyimpan suhu udara
            $table->string('keterangan'); // Tipe data string untuk menyimpan keterangan
            $table->timestamp('waktu'); // Tipe data timestamp untuk menyimpan waktu
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('udaras');
    }
};

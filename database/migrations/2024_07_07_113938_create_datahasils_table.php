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
        Schema::create('datahasils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_suhu');
            $table->unsignedBigInteger('id_kelembaban');
            $table->unsignedBigInteger('id_amonia');
            $table->unsignedBigInteger('id_udara');
            $table->string('status', 250);
            $table->timestamps();

            // Menambahkan foreign key constraints
            $table->foreign('id_suhu')->references('id')->on('suhus')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('id_kelembaban')->references('id')->on('kelembabans')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('id_amonia')->references('id')->on('amonias')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('id_udara')->references('id')->on('udaras')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datahasils');
    }
};

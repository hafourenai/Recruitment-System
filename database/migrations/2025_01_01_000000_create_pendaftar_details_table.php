<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftar_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('npm')->unique();
            $table->string('nama'); // redundancy but good for quick access without join
            $table->string('email'); // redundancy
            $table->string('nomor_hp');
            $table->string('program_studi');
            $table->decimal('ipk', 3, 2);
            $table->enum('posisi', ['asisten', 'programmer']);
            $table->enum('status', ['seleksi_berkas', 'seleksi_ujian', 'seleksi_wawancara', 'seleksi_staf', 'lulus', 'tidak_lulus'])->default('seleksi_berkas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftar_details');
    }
};

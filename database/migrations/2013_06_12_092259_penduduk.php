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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();

            $table->string('nik', 20)->unique();
            $table->string('no_kk', 20);

            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');

            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->string('agama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_perkawinan')->nullable();

            $table->text('alamat');

            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();

            $table->string('dusun')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};

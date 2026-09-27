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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surat')
                ->restrictOnDelete();

            $table->text('keperluan');

            $table->enum('status', [
                'diajukan',
                'selesai',
                'ditolak'
            ])->default('diajukan');

            $table->text('catatan_admin')
                ->nullable();

            $table->string('file_surat')
                ->nullable();

            $table->timestamp('tanggal_pengajuan')
                ->nullable();

            $table->timestamp('tanggal_verifikasi')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};

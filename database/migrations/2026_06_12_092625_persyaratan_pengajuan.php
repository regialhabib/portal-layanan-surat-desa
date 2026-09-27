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
        Schema::create('persyaratan_pengajuan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_surat_id')
                ->constrained('pengajuan_surat')
                ->cascadeOnDelete();

            $table->string('jenis_dokumen');

            $table->string('file_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persyaratan_pengajuan');
    }
};

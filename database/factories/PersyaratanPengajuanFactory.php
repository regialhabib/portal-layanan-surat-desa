<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersyaratanPengajuan>
 */
class PersyaratanPengajuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $table = 'persyaratan_pengajuan';

    protected $fillable = [
        'pengajuan_surat_id',
        'jenis_dokumen',
        'file_path',
    ];

    public function pengajuanSurat()
    {
        return $this->belongsTo(PengajuanSurat::class);
    }
}

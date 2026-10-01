<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;
    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama_surat',
        'deskripsi',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function syarat()
    {
        return $this->hasMany(SyaratJenisSurat::class);
    }
}

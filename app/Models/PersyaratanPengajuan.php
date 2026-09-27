<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersyaratanPengajuan extends Model
{
    use HasFactory;
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

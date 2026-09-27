<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratJenisSurat extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_surat_id', 'nama_syarat', 'format_file'];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}

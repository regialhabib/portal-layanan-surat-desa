<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $suratList = [
            [
                'nama_surat' => 'Surat Keterangan Usaha (SKU)',
                'deskripsi' => 'Surat yang menerangkan bahwa warga memiliki sebuah usaha.',
                'syarat' => [
                    ['nama_syarat' => 'Foto KTP', 'format_file' => 'image'],
                    ['nama_syarat' => 'Foto KK', 'format_file' => 'image'],
                    ['nama_syarat' => 'Foto Tempat Usaha', 'format_file' => 'image'],
                ]
            ],
            [
                'nama_surat' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat keterangan bahwa warga telah meninggal dunia.',
                'syarat' => [
                    ['nama_syarat' => 'Foto KTP Pelapor', 'format_file' => 'image'],
                    ['nama_syarat' => 'Foto KTP Jenazah', 'format_file' => 'image'],
                    ['nama_syarat' => 'Surat Keterangan Dokter/RS', 'format_file' => 'pdf']
                ]
            ],
            [
                'nama_surat' => 'Surat Pengantar Nikah',
                'deskripsi' => 'Surat pengantar administrasi untuk keperluan pernikahan tingkat desa.',
                'syarat' => [
                    ['nama_syarat' => 'Foto KTP Calon Suami', 'format_file' => 'image'],
                    ['nama_syarat' => 'Foto KTP Calon Istri', 'format_file' => 'image'],
                    ['nama_syarat' => 'Foto KK', 'format_file' => 'image']
                ]
            ],
            [
                'nama_surat' => 'SKTM (Surat Keterangan Tidak Mampu)',
                'deskripsi' => 'Surat Keterangan Tidak Mampu untuk berbagai keperluan bantuan/pendidikan.',
                'syarat' => [
                    ['nama_syarat' => 'Foto KTP', 'format_file' => 'image'],
                    ['nama_syarat' => 'Foto KK', 'format_file' => 'image'],
                    ['nama_syarat' => 'Surat Pengantar RT', 'format_file' => 'image']
                ]
            ],
            [
                'nama_surat' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat resmi yang menerangkan tempat tinggal warga saat ini.',
                'syarat' => [
                    ['nama_syarat' => 'Foto KTP', 'format_file' => 'image'],
                    ['nama_syarat' => 'Foto KK', 'format_file' => 'image']
                ]
            ],
            [
                'nama_surat' => 'Surat Keterangan Penghasilan',
                'deskripsi' => 'Surat keterangan terkait rincian jumlah penghasilan warga.',
                'syarat' => [
                    ['nama_syarat' => 'Foto KTP', 'format_file' => 'image'],
                    ['nama_syarat' => 'Slip Gaji / Bukti Penghasilan', 'format_file' => 'pdf']
                ]
            ],
        ];

        // Kosongkan tabel dulu agar sinkron, tapi abaikan constraint sementara
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        JenisSurat::truncate();
        \App\Models\SyaratJenisSurat::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        foreach ($suratList as $item) {
            $jenisSurat = JenisSurat::create([
                'nama_surat' => $item['nama_surat'],
                'deskripsi' => $item['deskripsi'],
                'aktif' => true
            ]);

            $jenisSurat->syarat()->createMany($item['syarat']);
        }
    }
}

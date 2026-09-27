<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Jenis Surat & Syarat
        |--------------------------------------------------------------------------
        */

        $suratDomisili = JenisSurat::create([
            'nama_surat' => 'Surat Keterangan Domisili',
            'deskripsi' => 'Surat resmi yang menerangkan domisili atau tempat tinggal warga.',
            'aktif' => true,
        ]);
        $suratDomisili->syarat()->createMany([
            ['nama_syarat' => 'Foto KTP', 'format_file' => 'image'],
            ['nama_syarat' => 'Foto KK', 'format_file' => 'image']
        ]);

        $suratPenghasilan = JenisSurat::create([
            'nama_surat' => 'Surat Keterangan Penghasilan',
            'deskripsi' => 'Surat keterangan terkait rincian penghasilan warga.',
            'aktif' => true,
        ]);
        $suratPenghasilan->syarat()->createMany([
            ['nama_syarat' => 'Foto KTP', 'format_file' => 'image'],
            ['nama_syarat' => 'Slip Gaji / Keterangan Usaha', 'format_file' => 'pdf']
        ]);

        $suratNikah = JenisSurat::create([
            'nama_surat' => 'Surat Pengantar Nikah',
            'deskripsi' => 'Surat pengantar administrasi untuk keperluan pernikahan.',
            'aktif' => true,
        ]);
        $suratNikah->syarat()->createMany([
            ['nama_syarat' => 'Foto KTP Calon Suami', 'format_file' => 'image'],
            ['nama_syarat' => 'Foto KTP Calon Istri', 'format_file' => 'image'],
            ['nama_syarat' => 'Surat Pengantar RT', 'format_file' => 'pdf']
        ]);

        $suratKematian = JenisSurat::create([
            'nama_surat' => 'Surat Kematian',
            'deskripsi' => 'Surat keterangan meninggal dunia.',
            'aktif' => true,
        ]);
        $suratKematian->syarat()->createMany([
            ['nama_syarat' => 'Foto KTP Pelapor', 'format_file' => 'image'],
            ['nama_syarat' => 'Foto KTP Jenazah', 'format_file' => 'image'],
            ['nama_syarat' => 'Surat Keterangan Dokter/RS', 'format_file' => 'pdf']
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        User::create([
            'role' => 'admin',
            'email' => 'admin@desa.test',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Penduduk Dummy
        |--------------------------------------------------------------------------
        */

        $penduduk = [];

        for ($i = 1; $i <= 10; $i++) {
            $penduduk[] = Penduduk::create([
                'nik' => '18010000000000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'no_kk' => '18020000000000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nama' => 'Penduduk ' . $i,
                'tempat_lahir' => 'Lubuk Bernai',
                'tanggal_lahir' => now()->subYears(20 + $i),
                'jenis_kelamin' => $i % 2 == 0 ? 'L' : 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Wiraswasta',
                'status_perkawinan' => 'Belum Kawin',
                'alamat' => 'Alamat Penduduk ' . $i,
                'rt' => '001',
                'rw' => '001',
                'dusun' => 'Dusun 1',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Akun Masyarakat
        |--------------------------------------------------------------------------
        */

        User::create([
            'penduduk_id' => $penduduk[0]->id,
            'role' => 'masyarakat',
            'email' => 'masyarakat@desa.test',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Seed Berita
        |--------------------------------------------------------------------------
        */
        $this->call([
            BeritaSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Seed Pengajuan Surat Dummy
        |--------------------------------------------------------------------------
        */
        $masyarakat = User::where('role', 'masyarakat')->first();
        $suratDomisili = JenisSurat::where('nama_surat', 'Surat Keterangan Domisili')->first();
        $suratNikah = JenisSurat::where('nama_surat', 'Surat Pengantar Nikah')->first();

        // 1. Pengajuan Domisili (ID 1)
        $pengajuan1 = \App\Models\PengajuanSurat::create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $suratDomisili->id,
            'keperluan' => 'Pendaftaran beasiswa pendidikan',
            'status' => 'diajukan',
            'tanggal_pengajuan' => now(),
        ]);

        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('persyaratan/' . $pengajuan1->id);
        foreach ($suratDomisili->syarat as $syarat) {
            $ext = $syarat->format_file === 'image' ? 'jpg' : 'pdf';
            $fileName = 'dummy_' . \Illuminate\Support\Str::slug($syarat->nama_syarat) . '_' . time() . '.' . $ext;
            $path = 'persyaratan/' . $pengajuan1->id . '/' . $fileName;
            
            if ($ext === 'jpg') {
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents(public_path('images/kantor_desa_hero.jpg')));
            } else {
                $dummyPdf = base64_decode("JVBERi0xLjcKCjEgMCBvYmogICUgZW50cnkgcG9pbnQKPDwKICAvVHlwZSAvQ2F0YWxvZwogIC9QYWdlcyAyIDAgUgo+PgplbmRvYmoKCjIgMCBvYmoKPDwKICAvVHlwZSAvUGFnZXMKICAvTWVkaWFCb3ggWyAwIDAgMjAwIDIwMCBdCiAgL0NvdW50IDEKICAvS2lkcyBbIDMgMCBSIF0KPj4KZW5kb2JqCgozIDAgb2JqCjw8CiAgL1R5cGUgL1BhZ2UKICAvUGFyZW50IDIgMCBSCiAgL1Jlc291cmNlcyA8PAogICAgL0ZvbnQgPDwKICAgICAgL0YxIDQgMCBSCgkJPj4KICA+PgogIC9Db250ZW50cyA1IDAgUgo+PgplbmRvYmoKCjQgMCBvYmoKPDwKICAvVHlwZSAvRm9udAogIC9TdWJ0eXBlIC9UeXBlMQogIC9CYXNlRm9udCAvVGltZXMtUm9tYW4KPj4KZW5kb2JqCgo1IDAgb2JqICAlIHBhZ2UgY29udGVudAo8PAogIC9MZW5ndGggNDQKPj4Kc3RyZWFtCkJUCjcwIDUwIFRECi9GMSAxMiBUZgooSGVsbG8sIHdvcmxkISkgVGoKRVQKZW5kc3RyZWFtCmVuZG9iagoKeHJlZgowIDYKMDAwMDAwMDAwMCA2NTUzNSBmIAowMDAwMDAwMDEwIDAwMDAwIG4gCjAwMDAwMDAwNjggMDAwMDAgbiAKMDAwMDAwMDE2NyAwMDAwMCBuIAowMDAwMDAwMjg3IDAwMDAwIG4gCjAwMDAwMDAzNzMgMDAwMDAgbiAKdHJhaWxlcgo8PAogIC9TaXplIDYKICAvUm9vdCAxIDAgUgo+PgpzdGFydHhyZWYKNDY2CiUlRU9GCg==");
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $dummyPdf);
            }

            \App\Models\PersyaratanPengajuan::create([
                'pengajuan_surat_id' => $pengajuan1->id,
                'jenis_dokumen' => strtoupper($syarat->nama_syarat),
                'file_path' => $path,
            ]);
        }

        // 2. Pengajuan Nikah (ID 2)
        $pengajuan2 = \App\Models\PengajuanSurat::create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $suratNikah->id,
            'keperluan' => 'Persyaratan administrasi KUA',
            'status' => 'diajukan',
            'tanggal_pengajuan' => now()->subDays(1),
        ]);

        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('persyaratan/' . $pengajuan2->id);
        foreach ($suratNikah->syarat as $syarat) {
            $ext = $syarat->format_file === 'image' ? 'jpg' : 'pdf';
            $fileName = 'dummy_' . \Illuminate\Support\Str::slug($syarat->nama_syarat) . '_' . time() . '.' . $ext;
            $path = 'persyaratan/' . $pengajuan2->id . '/' . $fileName;
            
            if ($ext === 'jpg') {
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents(public_path('images/kantor_desa_hero.jpg')));
            } else {
                $dummyPdf = base64_decode("JVBERi0xLjcKCjEgMCBvYmogICUgZW50cnkgcG9pbnQKPDwKICAvVHlwZSAvQ2F0YWxvZwogIC9QYWdlcyAyIDAgUgo+PgplbmRvYmoKCjIgMCBvYmoKPDwKICAvVHlwZSAvUGFnZXMKICAvTWVkaWFCb3ggWyAwIDAgMjAwIDIwMCBdCiAgL0NvdW50IDEKICAvS2lkcyBbIDMgMCBSIF0KPj4KZW5kb2JqCgozIDAgb2JqCjw8CiAgL1R5cGUgL1BhZ2UKICAvUGFyZW50IDIgMCBSCiAgL1Jlc291cmNlcyA8PAogICAgL0ZvbnQgPDwKICAgICAgL0YxIDQgMCBSCgkJPj4KICA+PgogIC9Db250ZW50cyA1IDAgUgo+PgplbmRvYmoKCjQgMCBvYmoKPDwKICAvVHlwZSAvRm9udAogIC9TdWJ0eXBlIC9UeXBlMQogIC9CYXNlRm9udCAvVGltZXMtUm9tYW4KPj4KZW5kb2JqCgo1IDAgb2JqICAlIHBhZ2UgY29udGVudAo8PAogIC9MZW5ndGggNDQKPj4Kc3RyZWFtCkJUCjcwIDUwIFRECi9GMSAxMiBUZgooSGVsbG8sIHdvcmxkISkgVGoKRVQKZW5kc3RyZWFtCmVuZG9iagoKeHJlZgowIDYKMDAwMDAwMDAwMCA2NTUzNSBmIAowMDAwMDAwMDEwIDAwMDAwIG4gCjAwMDAwMDAwNjggMDAwMDAgbiAKMDAwMDAwMDE2NyAwMDAwMCBuIAowMDAwMDAwMjg3IDAwMDAwIG4gCjAwMDAwMDAzNzMgMDAwMDAgbiAKdHJhaWxlcgo8PAogIC9TaXplIDYKICAvUm9vdCAxIDAgUgo+PgpzdGFydHhyZWYKNDY2CiUlRU9GCg==");
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $dummyPdf);
            }

            \App\Models\PersyaratanPengajuan::create([
                'pengajuan_surat_id' => $pengajuan2->id,
                'jenis_dokumen' => strtoupper($syarat->nama_syarat),
                'file_path' => $path,
            ]);
        }
    }
}

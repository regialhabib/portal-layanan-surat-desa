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

        $names = ['Budi Santoso', 'Siti Aminah', 'Rudi Heryanto', 'Rina Marlina', 'Ahmad Firmansyah', 'Dewi Sartika', 'Bambang Pamungkas', 'Sri Mulyani', 'Rizky Pratama', 'Ayu Lestari'];
        $penduduk = [];

        for ($i = 1; $i <= 10; $i++) {
            $penduduk[] = Penduduk::create([
                'nik' => '18010000000000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'no_kk' => '18020000000000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nama' => $names[$i - 1],
                'tempat_lahir' => 'Lubuk Bernai',
                'tanggal_lahir' => now()->subYears(20 + $i),
                'jenis_kelamin' => $i % 2 == 0 ? 'P' : 'L',
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

    }
}

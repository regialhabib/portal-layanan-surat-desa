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
        $this->call([
            JenisSuratSeeder::class,
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

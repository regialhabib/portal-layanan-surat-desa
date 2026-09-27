<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $admin = User::first();
        }

        $beritaList = [
            [
                'judul' => 'Pesona Alam Desa Lubuk Bernai di Pagi Hari',
                'slug' => Str::slug('Pesona Alam Desa Lubuk Bernai di Pagi Hari'),
                'thumbnail' => 'berita/berita_desa_1.jpg',
                'konten' => '<p>Desa Lubuk Bernai menyimpan keindahan alam yang luar biasa, terutama di pagi hari. Hamparan sawah terasering yang menghijau dipadukan dengan kabut tipis dan sinar matahari pagi menciptakan suasana yang sangat asri dan menenangkan.</p><p>Keindahan ini diharapkan dapat menjadi daya tarik bagi para pengunjung serta terus dijaga oleh masyarakat setempat sebagai aset berharga desa. Mari bersama-sama kita lestarikan alam kita tercinta.</p>',
                'is_published' => true,
                'user_id' => $admin->id,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Gotong Royong Petani Meningkatkan Kualitas Panen',
                'slug' => Str::slug('Gotong Royong Petani Meningkatkan Kualitas Panen'),
                'thumbnail' => 'berita/berita_desa_2.jpg',
                'konten' => '<p>Pembangunan sektor pertanian terus menjadi fokus utama di Desa Lubuk Bernai. Terlihat antusiasme warga yang bahu-membahu bekerja di lahan persawahan. Semangat gotong royong ini tidak hanya mempererat tali persaudaraan, tetapi juga sangat efektif dalam mempercepat proses tanam dan panen.</p><p>Pemerintah Desa terus mendukung para petani dengan berbagai program penyuluhan dan bantuan bibit unggul untuk memastikan ketahanan pangan desa kita tetap kuat.</p>',
                'is_published' => true,
                'user_id' => $admin->id,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'judul' => 'Peresmian Balai Pertemuan Desa yang Baru',
                'slug' => Str::slug('Peresmian Balai Pertemuan Desa yang Baru'),
                'thumbnail' => 'berita/berita_desa_3.jpg',
                'konten' => '<p>Fasilitas umum di desa kita semakin lengkap dengan diresmikannya balai pertemuan yang baru. Bangunan dengan arsitektur yang modern namun tetap mempertahankan nilai tradisional ini diharapkan menjadi pusat kegiatan positif warga.</p><p>Balai ini akan digunakan untuk berbagai pertemuan penting, acara keagamaan, serta musyawarah desa. Semoga fasilitas ini dapat dimanfaatkan dan dirawat sebaik mungkin oleh seluruh lapisan masyarakat.</p>',
                'is_published' => true,
                'user_id' => $admin->id,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ]
        ];

        foreach ($beritaList as $berita) {
            Berita::create($berita);
        }
    }
}

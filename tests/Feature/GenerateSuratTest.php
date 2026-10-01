<?php

namespace Tests\Feature;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class GenerateSuratTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Jalankan seeder agar jenis surat tersedia
        $this->seed(\Database\Seeders\JenisSuratSeeder::class);
    }

    public function test_admin_dapat_menyelesaikan_surat_dan_generate_pdf()
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);

        // Buat jenis surat fiktif khusus untuk test agar tidak menimpa template asli
        $jenisSurat = JenisSurat::create([
            'nama_surat' => 'Surat Fiktif Untuk Test Generate PDF',
            'deskripsi' => 'Dummy',
            'aktif' => true
        ]);

        // Buat mock view template agar tidak error saat PDF loadView
        $viewName = 'format_surat.' . Str::slug($jenisSurat->nama_surat);
        \Illuminate\Support\Facades\View::addNamespace('format_surat', resource_path('views/format_surat'));
        
        // Buat file temporary view jika belum ada (hanya untuk testing)
        $viewDir = resource_path('views/format_surat');
        if (!is_dir($viewDir)) {
            mkdir($viewDir, 0777, true);
        }
        $viewFile = $viewDir . '/' . Str::slug($jenisSurat->nama_surat) . '.blade.php';
        file_put_contents($viewFile, '<html><body><h1>Test Surat</h1></body></html>');

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
            'keperluan' => 'Keperluan Test',
        ]);

        $response = $this->actingAs($admin)
            ->put(route('pengajuan-surat.selesaikan', $pengajuan->id));

        $response->assertSessionHas('success');
        $response->assertRedirect();

        $pengajuan->refresh();

        $this->assertEquals('selesai', $pengajuan->status);
        $this->assertNotNull($pengajuan->file_surat);
        
        // Assert file exists in storage
        Storage::disk('public')->assertExists($pengajuan->file_surat);

        // Cleanup mock view
        @unlink($viewFile);
    }

    public function test_masyarakat_tidak_bisa_akses_generate_surat()
    {
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $jenisSurat = JenisSurat::first();

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
            'keperluan' => 'Keperluan Test',
        ]);

        $response = $this->actingAs($masyarakat)
            ->put(route('pengajuan-surat.selesaikan', $pengajuan->id));

        $response->assertStatus(403);
    }

    public function test_gagal_generate_jika_template_blade_tidak_ditemukan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);

        // Create a fake jenis surat that doesn't have a view
        $jenisSurat = JenisSurat::create([
            'nama_surat' => 'Surat Belum Ada Template',
            'deskripsi' => 'Test',
            'aktif' => true
        ]);

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
            'keperluan' => 'Keperluan Test',
        ]);

        $response = $this->actingAs($admin)
            ->put(route('pengajuan-surat.selesaikan', $pengajuan->id));

        $response->assertSessionHas('error', 'Template untuk surat ini belum tersedia.');
        $response->assertRedirect();

        $pengajuan->refresh();
        $this->assertEquals('diajukan', $pengajuan->status); // Status should not change
    }

    public function test_tidak_bisa_generate_surat_yang_bukan_status_diajukan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $jenisSurat = JenisSurat::first();

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'ditolak',
            'keperluan' => 'Keperluan Test',
        ]);

        $response = $this->actingAs($admin)
            ->put(route('pengajuan-surat.selesaikan', $pengajuan->id));

        $response->assertSessionHas('error', 'Hanya pengajuan dengan status diajukan atau diproses yang dapat diselesaikan.');
        
        $pengajuan->refresh();
        $this->assertEquals('ditolak', $pengajuan->status); 
    }
}

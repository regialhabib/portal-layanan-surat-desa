<?php

namespace Tests\Feature;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\SyaratJenisSurat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengajuanSuratEdgeCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed db minimum requirement
        $this->seed(\Database\Seeders\JenisSuratSeeder::class);
    }

    public function test_store_gagal_jika_file_persyaratan_tidak_dilampirkan()
    {
        $user = User::factory()->create(['role' => 'masyarakat']);

        // Create a JenisSurat with a required file
        $jenisSurat = JenisSurat::create([
            'nama_surat' => 'Surat Butuh File',
            'deskripsi' => 'Test',
            'aktif' => true
        ]);
        
        SyaratJenisSurat::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_syarat' => 'KTP',
            'format_file' => 'image',
            'is_required' => true,
        ]);

        // Attempt to store WITHOUT file
        $response = $this->actingAs($user)->post(route('pengajuan-surat.store'), [
            'jenis_surat_id' => $jenisSurat->id,
            'keperluan' => 'Test Keperluan',
        ]);

        // Should have validation error for the 'ktp' field (slugified 'KTP')
        $response->assertSessionHasErrors(['ktp']);
        
        // Assert no record is created
        $this->assertDatabaseCount('pengajuan_surat', 0);
    }

    public function test_masyarakat_tidak_bisa_hapus_pengajuan_orang_lain()
    {
        $masyarakatA = User::factory()->create(['role' => 'masyarakat']);
        $masyarakatB = User::factory()->create(['role' => 'masyarakat']);
        $jenisSurat = JenisSurat::first();

        // Pengajuan belongs to masyarakat A
        $pengajuanA = PengajuanSurat::factory()->create([
            'user_id' => $masyarakatA->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
            'keperluan' => 'Test',
        ]);

        // Masyarakat B attempts to delete it
        $response = $this->actingAs($masyarakatB)->delete(route('pengajuan-surat.destroy', $pengajuanA->id));

        // Should receive 403 Forbidden
        $response->assertStatus(403);
        
        // Ensure record still exists
        $this->assertDatabaseHas('pengajuan_surat', [
            'id' => $pengajuanA->id
        ]);
    }

    public function test_admin_bisa_hapus_pengajuan_siapa_saja_beserta_filenya()
    {
        Storage::fake('public');
        
        $admin = User::factory()->create(['role' => 'admin']);
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $jenisSurat = JenisSurat::first();

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'selesai',
            'keperluan' => 'Test',
        ]);

        // Mock some files for this pengajuan
        $pdfPath = 'surat-selesai/surat_123.pdf';
        $reqPath = 'persyaratan/' . $pengajuan->id . '/ktp.jpg';
        
        Storage::disk('public')->put($pdfPath, 'dummy content');
        Storage::disk('public')->put($reqPath, 'dummy content');
        
        $pengajuan->update(['file_surat' => $pdfPath]);

        // Admin deletes it
        $response = $this->actingAs($admin)->delete(route('pengajuan-surat.destroy', $pengajuan->id));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Ensure record deleted
        $this->assertDatabaseMissing('pengajuan_surat', [
            'id' => $pengajuan->id
        ]);

        // Ensure files deleted
        Storage::disk('public')->assertMissing($pdfPath);
        // assertDirectoryEmpty or checking specific file in directory
        Storage::disk('public')->assertMissing($reqPath);
    }

    public function test_tolak_gagal_jika_catatan_kosong()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $jenisSurat = JenisSurat::first();

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $masyarakat->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
            'keperluan' => 'Test',
        ]);

        // Admin attempts to reject without catatan_admin
        $response = $this->actingAs($admin)->put(route('pengajuan-surat.tolak', $pengajuan->id), [
            // 'catatan_admin' => 'Alasan penolakan', // Missing!
        ]);

        // Should return validation error
        $response->assertSessionHasErrors(['catatan_admin']);
        
        // Assert status did not change to ditolak
        $this->assertDatabaseHas('pengajuan_surat', [
            'id' => $pengajuan->id,
            'status' => 'diajukan'
        ]);
    }
}

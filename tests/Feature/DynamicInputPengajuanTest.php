<?php

namespace Tests\Feature;

use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DynamicInputPengajuanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat data jenis surat untuk test (mirip dengan DB asli)
        JenisSurat::create([
            'nama_surat' => 'Surat Keterangan Kematian',
            'deskripsi' => 'Surat kematian',
            'aktif' => true
        ]);
        JenisSurat::create([
            'nama_surat' => 'Surat Keterangan Usaha (SKU)',
            'deskripsi' => 'SKU',
            'aktif' => true
        ]);
    }

    public function test_get_detail_returns_static_isian_fields()
    {
        $user = User::factory()->create();

        $jenisSurat = JenisSurat::where('nama_surat', 'Surat Keterangan Kematian')->first();

        $response = $this->actingAs($user)->get("/jenis-surat/{$jenisSurat->id}/detail");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'syarat',
            'isian'
        ]);

        $isian = $response->json('isian');
        $this->assertCount(3, $isian);
        $this->assertEquals('hari_tanggal_meninggal', $isian[0]['name']);
        $this->assertEquals('tempat_meninggal', $isian[1]['name']);
        $this->assertEquals('penyebab_meninggal', $isian[2]['name']);
    }

    public function test_store_pengajuan_saves_data_tambahan()
    {
        $penduduk = Penduduk::create([
            'nik' => '1234567890123456',
            'no_kk' => '1234567890123456',
            'nama' => 'John Doe',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
            'pekerjaan' => 'Swasta',
            'status_perkawinan' => 'Belum Kawin',
            'alamat' => 'Jl. Test',
            'rt' => '01',
            'rw' => '02',
            'dusun' => 'Dusun 1',
        ]);

        $user = User::factory()->create([
            'role' => 'masyarakat',
            'penduduk_id' => $penduduk->id
        ]);

        $jenisSurat = JenisSurat::where('nama_surat', 'Surat Keterangan Usaha (SKU)')->first();

        $dataTambahan = [
            'nama_usaha' => 'Toko Kelontong Berkah'
        ];

        $response = $this->actingAs($user)->post(route('pengajuan-surat.store'), [
            'jenis_surat_id' => $jenisSurat->id,
            'keperluan' => 'Syarat pinjaman KUR',
            'data_tambahan' => $dataTambahan
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('masyarakat.riwayat-pengajuan'));

        $pengajuan = PengajuanSurat::first();
        $this->assertNotNull($pengajuan);
        $this->assertEquals('Syarat pinjaman KUR', $pengajuan->keperluan);
        
        $this->assertIsArray($pengajuan->data_tambahan);
        $this->assertEquals('Toko Kelontong Berkah', $pengajuan->data_tambahan['nama_usaha']);
    }
}

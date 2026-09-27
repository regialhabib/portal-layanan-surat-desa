<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JenisSuratTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $user = \App\Models\User::first();
        if (!$user) {
            $user = \App\Models\User::forceCreate([
                'email' => 'test@test.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }
        $this->actingAs($user);
    }

    public function test_can_view_index()
    {
        $response = $this->get('/jenis-surat');
        $response->assertStatus(200);
    }

    public function test_can_create_jenis_surat()
    {
        $data = [
            'nama_surat' => 'Surat Pengantar',
            'deskripsi' => 'Pengantar RT/RW',
            'aktif' => 1,
            'syarat' => [
                ['nama_syarat' => 'KTP', 'format_file' => 'image'],
                ['nama_syarat' => 'KK', 'format_file' => 'pdf'],
            ]
        ];

        $response = $this->post('/jenis-surat', $data);
        $response->assertRedirect('/jenis-surat');
        
        $this->assertDatabaseHas('jenis_surat', ['nama_surat' => 'Surat Pengantar']);
        $this->assertDatabaseHas('syarat_jenis_surats', ['nama_syarat' => 'KTP']);
    }

    public function test_can_update_jenis_surat()
    {
        $jenisSurat = \App\Models\JenisSurat::create([
            'nama_surat' => 'Surat Keterangan',
            'deskripsi' => 'Deskripsi',
            'aktif' => true,
        ]);

        $data = [
            'nama_surat' => 'Surat Keterangan Updated',
            'deskripsi' => 'Deskripsi Updated',
            'aktif' => 0,
            'syarat' => [
                ['nama_syarat' => 'Foto', 'format_file' => 'all']
            ]
        ];

        $response = $this->put("/jenis-surat/{$jenisSurat->id}", $data);
        $response->assertRedirect('/jenis-surat');

        $this->assertDatabaseHas('jenis_surat', ['nama_surat' => 'Surat Keterangan Updated']);
        $this->assertDatabaseHas('syarat_jenis_surats', ['nama_syarat' => 'Foto']);
    }

    public function test_can_delete_jenis_surat()
    {
        $jenisSurat = \App\Models\JenisSurat::create([
            'nama_surat' => 'Surat Keterangan',
            'deskripsi' => 'Deskripsi',
            'aktif' => true,
        ]);

        $response = $this->delete("/jenis-surat/{$jenisSurat->id}");
        $response->assertRedirect('/jenis-surat');

        $this->assertDatabaseMissing('jenis_surat', ['id' => $jenisSurat->id]);
    }
}

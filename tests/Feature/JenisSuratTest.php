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

    public function test_can_update_syarat_jenis_surat()
    {
        $jenisSurat = \App\Models\JenisSurat::create([
            'nama_surat' => 'Surat Keterangan',
            'deskripsi' => 'Deskripsi',
            'aktif' => true,
        ]);

        $data = [
            'deskripsi' => 'Deskripsi Updated',
            'aktif' => 0,
            'syarat' => [
                ['nama_syarat' => 'Foto', 'format_file' => 'all']
            ]
        ];

        $response = $this->put("/jenis-surat/{$jenisSurat->id}", $data);
        $response->assertRedirect('/jenis-surat');

        $this->assertDatabaseHas('jenis_surat', ['deskripsi' => 'Deskripsi Updated']);
        $this->assertDatabaseHas('syarat_jenis_surats', ['nama_syarat' => 'Foto']);
    }
}

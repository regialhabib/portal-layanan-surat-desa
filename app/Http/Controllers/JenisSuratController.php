<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenisSurat = JenisSurat::with('syarat')->latest()->get();
        return view('jenis_surat.index', compact('jenisSurat'));
    }

    public function edit($id)
    {
        $jenisSurat = JenisSurat::with('syarat')->findOrFail($id);
        return view('jenis_surat.edit', compact('jenisSurat'));
    }

    public function update(Request $request, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        
        $validated = $request->validate([
            'deskripsi' => 'nullable|string',
            'aktif' => 'boolean',
            'syarat' => 'nullable|array',
            'syarat.*.nama_syarat' => 'required|string|max:255',
            'syarat.*.format_file' => 'required|in:image,pdf,all',
        ]);

        DB::beginTransaction();
        try {
            $jenisSurat->update([
                'deskripsi' => $validated['deskripsi'] ?? null,
                'aktif' => $request->has('aktif') ? true : false,
            ]);

            $jenisSurat->syarat()->delete();
            if (isset($validated['syarat'])) {
                foreach ($validated['syarat'] as $syarat) {
                    $jenisSurat->syarat()->create([
                        'nama_syarat' => $syarat['nama_syarat'],
                        'format_file' => $syarat['format_file'],
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('jenis-surat.index')->with('success', 'Syarat Jenis Surat berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function getDetail($id)
    {
        $jenisSurat = JenisSurat::with('syarat')->findOrFail($id);
        
        $isian = [];
        $namaSurat = strtolower($jenisSurat->nama_surat);
        
        if (str_contains($namaSurat, 'usaha') || str_contains($namaSurat, 'sku')) {
            $isian = [
                ['name' => 'nama_usaha', 'label' => 'Nama Usaha / Jenis Usaha', 'type' => 'text']
            ];
        } elseif (str_contains($namaSurat, 'kematian')) {
            $isian = [
                ['name' => 'hari_tanggal_meninggal', 'label' => 'Hari / Tanggal Meninggal (mis: Senin, 12 Agustus 2024)', 'type' => 'text'],
                ['name' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'type' => 'text'],
                ['name' => 'penyebab_meninggal', 'label' => 'Penyebab Meninggal', 'type' => 'text']
            ];
        } elseif (str_contains($namaSurat, 'nikah')) {
            $isian = [
                ['name' => 'nama_calon_pasangan', 'label' => 'Nama Calon Pasangan', 'type' => 'text']
            ];
        } elseif (str_contains($namaSurat, 'penghasilan')) {
            $isian = [
                ['name' => 'rata_rata_penghasilan_per_bulan', 'label' => 'Rata-rata Penghasilan per Bulan (mis: Rp. 2.000.000,-)', 'type' => 'text']
            ];
        }

        return response()->json([
            'syarat' => $jenisSurat->syarat,
            'isian' => $isian
        ]);
    }
}

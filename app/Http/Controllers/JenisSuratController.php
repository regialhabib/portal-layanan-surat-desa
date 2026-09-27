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

    public function create()
    {
        return view('jenis_surat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'aktif' => 'boolean',
            'syarat' => 'nullable|array',
            'syarat.*.nama_syarat' => 'required|string|max:255',
            'syarat.*.format_file' => 'required|in:image,pdf,all',
        ]);

        DB::beginTransaction();
        try {
            $jenisSurat = JenisSurat::create([
                'nama_surat' => $validated['nama_surat'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'aktif' => $request->has('aktif') ? true : false,
            ]);

            if (isset($validated['syarat'])) {
                foreach ($validated['syarat'] as $syarat) {
                    $jenisSurat->syarat()->create([
                        'nama_syarat' => $syarat['nama_syarat'],
                        'format_file' => $syarat['format_file'],
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('jenis-surat.index')->with('success', 'Jenis Surat berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
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
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'aktif' => 'boolean',
            'syarat' => 'nullable|array',
            'syarat.*.nama_syarat' => 'required|string|max:255',
            'syarat.*.format_file' => 'required|in:image,pdf,all',
        ]);

        DB::beginTransaction();
        try {
            $jenisSurat->update([
                'nama_surat' => $validated['nama_surat'],
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
            return redirect()->route('jenis-surat.index')->with('success', 'Jenis Surat berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();
        return redirect()->route('jenis-surat.index')->with('success', 'Jenis Surat berhasil dihapus.');
    }

    public function getSyarat($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        return response()->json($jenisSurat->syarat);
    }
}

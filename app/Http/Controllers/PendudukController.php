<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penduduks = Penduduk::latest()->get();
        return view('penduduk.index', compact('penduduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penduduk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'               => 'required|string|max:20|unique:penduduk,nik',
            'no_kk'             => 'required|string|max:20',
            'nama'              => 'required|string|max:255',
            'tempat_lahir'      => 'required|string|max:255',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|in:L,P',
            'agama'             => 'nullable|string|max:50',
            'pekerjaan'         => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:100',
            'alamat'            => 'required|string',
            'rt'                => 'nullable|string|max:5',
            'rw'                => 'nullable|string|max:5',
            'dusun'             => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            Penduduk::create($validated);

            DB::commit();

            return redirect()
                ->route('penduduk.index')
                ->with('success', 'Data penduduk berhasil ditambahkan.');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal menambah penduduk', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penduduk $penduduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);

        return view('penduduk.edit', compact('penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik'               => 'required|string|max:20|unique:penduduk,nik,' . $penduduk->id,
            'no_kk'             => 'required|string|max:20',
            'nama'              => 'required|string|max:255',
            'tempat_lahir'      => 'required|string|max:255',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|in:L,P',
            'agama'             => 'nullable|string|max:50',
            'pekerjaan'         => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:100',
            'alamat'            => 'required|string',
            'rt'                => 'nullable|string|max:5',
            'rw'                => 'nullable|string|max:5',
            'dusun'             => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            $penduduk->update($validated);

            DB::commit();

            return redirect()
                ->route('penduduk.index')
                ->with('success', 'Data penduduk berhasil diperbarui.');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal memperbarui data penduduk', [
                'penduduk_id' => $penduduk->id,
                'message'     => $e->getMessage(),
                'line'        => $e->getLine(),
                'file'        => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
   

    public function destroy(Penduduk $penduduk)
    {
        DB::beginTransaction();

        try {

            $penduduk->delete();

            DB::commit();

            return redirect()
                ->route('penduduk.index')
                ->with('success', 'Data penduduk berhasil dihapus.');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal menghapus data penduduk', [
                'penduduk_id' => $penduduk->id,
                'message'     => $e->getMessage(),
                'line'        => $e->getLine(),
                'file'        => $e->getFile(),
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}

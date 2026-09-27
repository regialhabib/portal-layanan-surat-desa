<?php

namespace App\Http\Controllers;


use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{

    public function index(Request $request)
    {
        $query = SuratKeluar::query();

        // Jika kedua tanggal diisi
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_terima', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Jika hanya start_date
        if ($request->start_date && !$request->end_date) {
            $query->whereDate('tanggal_terima', '>=', $request->start_date);
        }

        // Jika hanya end_date
        if (!$request->start_date && $request->end_date) {
            $query->whereDate('tanggal_terima', '<=', $request->end_date);
        }

        $surats = $query->get();

        return view('surat_keluar.index', compact('surats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('surat_keluar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_berkas' => 'required',
            'no_surat' => 'required',
            'tanggal_terima' => 'required|date',
            'alamat_penerima' => 'required',
            'isi_surat' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf,docx,png|max:2048'
        ]);

        try {
            // upload file jika ada
            $path = storeFileSurat($request->file('file_surat'), 'surat_keluar');

            SuratKeluar::create([
                'no_berkas' => $request->no_berkas,
                'no_surat' => $request->no_surat,
                'tanggal_terima' => $request->tanggal_terima,
                'alamat_penerima' => $request->alamat_penerima,
                'isi_surat' => $request->isi_surat,
                'keterangan' => $request->keterangan,
                'path_surat' => $path
            ]);

            if ($path) {

                try {

                    backupToGoogleDrive(
                        $path,
                        'keluar'
                    );
                } catch (\Exception $e) {

                    Log::error(
                        'Backup Google Drive gagal: '
                            . $e->getMessage()
                    );
                }
            }

            return redirect()
                ->route('surat_keluar.index')
                ->with('success', 'Surat keluar berhasil ditambahkan');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if (!$surat->path_surat) {
            return back()->with('error', 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($surat->path_surat);
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {

            $surat = SuratKeluar::findOrFail($id);

            return view('surat_keluar.edit', compact('surat'));
        } catch (\Exception $e) {

            return redirect()
                ->route('surat_keluar.index')
                ->with('error', 'Data surat tidak ditemukan atau terjadi kesalahan.');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'no_berkas' => 'required',
            'no_surat' => 'required',
            'tanggal_terima' => 'required|date',
            'alamat_penerima' => 'required',
            'isi_surat' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:2048'
        ]);

        try {

            $surat = SuratKeluar::findOrFail($request->id);

            $path = $surat->path_surat;

            if ($request->hasFile('file_surat')) {

                deleteFileSurat($surat->path_surat);

                $path = storeFileSurat($request->file('file_surat'), 'surat_keluar');
            }

            $surat->update([
                'no_berkas' => $request->no_berkas,
                'no_surat' => $request->no_surat,
                'tanggal_terima' => $request->tanggal_terima,
                'alamat_penerima' => $request->alamat_penerima,
                'isi_surat' => $request->isi_surat,
                'keterangan' => $request->keterangan,
                'path_surat' => $path
            ]);

            return redirect()
                ->route('surat_keluar.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $surat = SuratKeluar::findOrFail($id);

            // hapus file jika ada
            if ($surat->path_surat) {
                deleteFileSurat($surat->path_surat);
            }

            // hapus data
            $surat->delete();

            return redirect()
                ->route('surat_keluar.index')
                ->with('success', 'Data surat berhasil dihapus');
        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
}

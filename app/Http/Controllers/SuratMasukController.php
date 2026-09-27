<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;



class SuratMasukController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::query();

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

        return view('surat_masuk.index', compact('surats'));
    }
    public function home()
    {
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        return view('home', compact('totalSuratMasuk', 'totalSuratKeluar'));
    }

    public function laporan()
    {
        return view('laporan');
    }

    public function print(Request $request)
    {
        try {

            $awal  = $request->tanggal_awal;
            $akhir = $request->tanggal_akhir;
            $jenis = $request->jenis_surat;

            if ($jenis == 'surat_masuk') {

                $data = SuratMasuk::whereBetween('tanggal_terima', [$awal, $akhir])->get();
                $judul = "Data Surat Masuk";
            } else {

                $data = SuratKeluar::whereBetween('tanggal_terima', [$awal, $akhir])->get();
                $judul = "Data Surat Keluar";
            }

            $pdf = Pdf::loadView('print', compact(
                'data',
                'judul',
                'awal',
                'akhir'
            ))->setPaper('A4', 'portrait');

            return $pdf->stream('laporan-surat.pdf');
        } catch (\Exception $e) {

            return back()->with('error', 'Terjadi kesalahan saat membuat PDF');
        }
    }

    public function data(Request $request)
    {
        $awal = $request->tanggal_awal;
        $akhir = $request->tanggal_akhir;
        $jenis = $request->jenis_surat;

        if ($jenis == 'surat_masuk') {
            $query = \App\Models\SuratMasuk::query();
        } else {
            $query = \App\Models\SuratKeluar::query();
        }

        if ($awal && $akhir) {
            $query->whereBetween('tanggal_terima', [$awal, $akhir]);
        }

        $data = $query->get();

        $result = [];

        foreach ($data as $item) {

            $result[] = [
                'no_berkas' => $item->no_berkas,
                'no_surat' => $item->no_surat,
                'surat' => $item->path_surat
                    ? '<a href="/storage/' . $item->path_surat . '" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                   </a>'
                    : '-',
                'tanggal_terima' => \Carbon\Carbon::parse($item->tanggal_terima)->format('d-m-Y'),
                'alamat_penerima' => $item->alamat_penerima,
                'isi_surat' => $item->isi_surat,
                'keterangan' => $item->keterangan,
            ];
        }

        return response()->json([
            "draw" => intval($request->draw),
            "recordsTotal" => count($result),
            "recordsFiltered" => count($result),
            "data" => $result
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('surat_masuk.create');
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
            $path = storeFileSurat($request->file('file_surat'), 'surat_masuk');

            SuratMasuk::create([
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
                        'masuk'
                    );
                } catch (\Exception $e) {

                    Log::error(
                        'Backup Google Drive gagal: '
                            . $e->getMessage()
                    );
                }
            }

            return redirect()
                ->route('surat_masuk.index')
                ->with('success', 'Surat masuk berhasil ditambahkan');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if (!$surat->path_surat) {
            return back()->with('error', 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($surat->path_surat);
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {

            $surat = SuratMasuk::findOrFail($id);

            return view('surat_masuk.edit', compact('surat'));
        } catch (\Exception $e) {

            return redirect()
                ->route('surat_masuk.index')
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

            $surat = SuratMasuk::findOrFail($request->id);

            $path = $surat->path_surat;

            if ($request->hasFile('file_surat')) {

                deleteFileSurat($surat->path_surat);

                $path = storeFileSurat($request->file('file_surat'), 'surat_masuk');
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
                ->route('surat_masuk.index')
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

            $surat = SuratMasuk::findOrFail($id);

            // hapus file jika ada
            if ($surat->path_surat) {
                deleteFileSurat($surat->path_surat);
            }

            // hapus data
            $surat->delete();

            return redirect()
                ->route('surat_masuk.index')
                ->with('success', 'Data surat berhasil dihapus');
        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
}

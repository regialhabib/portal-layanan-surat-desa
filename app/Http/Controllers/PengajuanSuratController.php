<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengajuanSuratRequest;
use App\Http\Requests\UpdatePengajuanSuratRequest;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\PersyaratanPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'baru'); 
        $filter = $request->get('filter', 'semua');
        
        $countBaru = PengajuanSurat::where('status', 'diajukan')->count();
        $countSelesai = PengajuanSurat::where('status', 'selesai')->count();
        $countDitolak = PengajuanSurat::where('status', 'ditolak')->count();
        $countTotal = PengajuanSurat::count();

        $query = PengajuanSurat::with([
            'user.penduduk',
            'jenisSurat',
            'persyaratan'
        ])->latest();

        if($tab == 'baru') {
            $query->where('status', 'diajukan');
        } else {
            if ($filter == 'selesai') {
                $query->where('status', 'selesai');
            } elseif ($filter == 'ditolak') {
                $query->where('status', 'ditolak');
            } else {
                $query->whereIn('status', ['selesai', 'ditolak']);
            }
        }
        
        $pengajuanSurat = $query->get();

        return view('pengajuan_surat.index', compact('pengajuanSurat', 'tab', 'filter', 'countBaru', 'countSelesai', 'countDitolak', 'countTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisSurat = JenisSurat::all();
        return view('pengajuan_surat.create', compact('jenisSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'keperluan'      => 'required|string',
            'data_tambahan'  => 'nullable|array',
        ]);

        $jenisSurat = JenisSurat::with('syarat')->findOrFail($request->jenis_surat_id);

        $rules = [];
        $fileNames = [];
        foreach ($jenisSurat->syarat as $syarat) {
            $slugName = preg_replace('/[^\w\_]+/', '', preg_replace('/\s+/', '_', strtolower($syarat->nama_syarat)));
            $fileNames[] = [
                'input_name' => $slugName,
                'nama_syarat' => $syarat->nama_syarat
            ];
            
            if ($syarat->format_file === 'image') {
                $rules[$slugName] = 'required|file|image|mimes:jpeg,png,jpg|max:2048';
            } elseif ($syarat->format_file === 'pdf') {
                $rules[$slugName] = 'required|file|mimes:pdf|max:2048';
            } else {
                $rules[$slugName] = 'required|file|mimes:jpeg,png,jpg,pdf|max:2048';
            }
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {

            $pengajuan = PengajuanSurat::create([
                'user_id'             => Auth::id(),
                'jenis_surat_id'      => $request->jenis_surat_id,
                'keperluan'           => $request->keperluan,
                'data_tambahan'       => $request->data_tambahan,
                'status'              => 'diajukan',
                'tanggal_pengajuan'   => now(),
            ]);

            foreach ($fileNames as $data) {
                $inputName = $data['input_name'];
                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);
                    $path = $file->store('persyaratan/' . $pengajuan->id, 'public');

                    PersyaratanPengajuan::create([
                        'pengajuan_surat_id' => $pengajuan->id,
                        'jenis_dokumen'      => strtoupper($data['nama_syarat']),
                        'file_path'          => $path,
                    ]);
                }
            }

            DB::commit();

            if (auth()->user()->role === 'admin') {
                return redirect()
                    ->route('pengajuan-surat.index')
                    ->with('success', 'Pengajuan surat berhasil dikirim.');
            } else {
                return redirect()
                    ->route('masyarakat.riwayat-pengajuan')
                    ->with('success', 'Pengajuan surat berhasil dikirim.');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal menyimpan pengajuan surat', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengirim pengajuan.');
        }
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanSurat $pengajuanSurat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePengajuanSuratRequest $request, PengajuanSurat $pengajuanSurat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanSurat $pengajuanSurat)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $pengajuanSurat->user_id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        try {
            DB::beginTransaction();

            $persyaratanPath = 'persyaratan/' . $pengajuanSurat->id;
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($persyaratanPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory($persyaratanPath);
            }

            if ($pengajuanSurat->file_surat && \Illuminate\Support\Facades\Storage::disk('public')->exists($pengajuanSurat->file_surat)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pengajuanSurat->file_surat);
            }

            $pengajuanSurat->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Pengajuan surat berhasil dihapus beserta file terkait.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus pengajuan surat', [
                'message' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengajuan surat.');
        }
    }

    public function proses(PengajuanSurat $pengajuanSurat)
    {
        try {

            $pengajuanSurat->update([
                'status' => 'diproses',
                'tanggal_verifikasi' => now(),
            ]);

            return back()->with(
                'success',
                'Pengajuan berhasil diproses.'
            );
        } catch (\Exception $e) {

            Log::error('Gagal memproses pengajuan', [
                'message' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'Terjadi kesalahan.'
            );
        }
    }

    public function tolak(
        Request $request,
        PengajuanSurat $pengajuanSurat
    ) {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        try {

            $pengajuanSurat->update([
                'status' => 'ditolak',
                'catatan_admin' => $request->catatan_admin,
                'tanggal_verifikasi' => now(),
            ]);

            return back()->with(
                'success',
                'Pengajuan berhasil ditolak.'
            );
        } catch (\Exception $e) {

            Log::error('Gagal menolak pengajuan', [
                'message' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'Terjadi kesalahan.'
            );
        }
    }

    public function diproses()
    {
        $pengajuanSurat = PengajuanSurat::with([
            'user.penduduk',
            'jenisSurat'
        ])
            ->where('status', 'diproses')
            ->latest()
            ->get();

        return view(
            'pengajuan_surat.diproses',
            compact('pengajuanSurat')
        );
    }

    public function show(PengajuanSurat $pengajuanSurat)
    {
        $pengajuanSurat->load([
            'user.penduduk',
            'jenisSurat',
            'persyaratan'
        ]);

        return response()->json($pengajuanSurat);
    }

    public function selesaikan(Request $request, PengajuanSurat $pengajuanSurat)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Edge Case: Check status
        if (!in_array($pengajuanSurat->status, ['diajukan', 'diproses'])) {
            return redirect()
                ->back()
                ->with('error', 'Hanya pengajuan dengan status diajukan atau diproses yang dapat diselesaikan.');
        }

        try {
            $pengajuanSurat->load(['user.penduduk', 'jenisSurat']);
            
            $viewName = 'format_surat.' . \Illuminate\Support\Str::slug($pengajuanSurat->jenisSurat->nama_surat);
            
            // Edge Case: Check if view exists
            if (!view()->exists($viewName)) {
                return redirect()
                    ->back()
                    ->with('error', 'Template untuk surat ini belum tersedia.');
            }

            // Generate PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewName, compact('pengajuanSurat'));

            // Set file name and path
            $fileName = 'surat_' . $pengajuanSurat->id . '_' . time() . '.pdf';
            $path = 'surat-selesai/' . $fileName;

            // Save PDF to public storage
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

            $pengajuanSurat->update([
                'status' => 'selesai',
                'file_surat' => $path,
                'tanggal_verifikasi' => now(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Surat berhasil digenerate dan diterbitkan.');
        } catch (\Exception $e) {

            \Illuminate\Support\Facades\Log::error('Gagal menyelesaikan surat', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memproses surat: ' . $e->getMessage());
        }
    }

    public function selesai()
    {
        $pengajuanSurat = PengajuanSurat::with([
            'user.penduduk',
            'jenisSurat'
        ])
            ->where('status', 'selesai')
            ->latest()
            ->get();

        return view(
            'pengajuan-surat.selesai',
            compact('pengajuanSurat')
        );
    }

    public function riwayat()
    {
        $pengajuanSurat = PengajuanSurat::with([
            'user.penduduk',
            'jenisSurat'
        ])
            ->whereIn('status', [
                'selesai',
                'ditolak'
            ])
            ->latest()
            ->get();

        return view(
            'pengajuan_surat.riwayat',
            compact('pengajuanSurat')
        );
    }

    public function riwayatMasyarakat(\Illuminate\Http\Request $request)
    {
        $filter = $request->query('filter');

        $query = PengajuanSurat::with(['jenisSurat'])
            ->where('user_id', auth()->id());

        if ($filter) {
            if ($filter === 'diproses') {
                $query->whereIn('status', ['diajukan', 'diproses']);
            } else {
                $query->where('status', $filter);
            }
        }

        $pengajuanSurat = $query->latest()->get();

        return view(
            'pengajuan_surat.riwayat_masyarakat',
            compact('pengajuanSurat')
        );
    }

    public function showMasyarakat(PengajuanSurat $pengajuanSurat)
    {
        if ($pengajuanSurat->user_id != auth()->id()) {
            abort(403);
        }

        $pengajuanSurat->load([
            'jenisSurat',
            'persyaratan'
        ]);

        return response()->json($pengajuanSurat);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    //
    public function index()
    {
        $berita = Berita::latest()
            ->take(8)
            ->get();
        return view('index', compact('berita'));
    }

    protected function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255|unique:users,email,' . Auth::user()->id,

            'foto' => 'nullable|image|mimes:jpg,jpeg,png',

            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);


        $user = User::findOrFail(Auth::user()->id);

        $user->email = $request->email;
       

        /*
    |--------------------------------------------------------------------------
    | Upload Foto Profile
    |--------------------------------------------------------------------------
    */
        if ($request->hasFile('foto')) {

            // hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/profile/' . $user->foto)) {
                Storage::delete('public/profile/' . $user->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/profile', $filename);

            $user->foto = $filename;
        }

        /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */
        if (!is_null($request->current_password)) {

            if (Hash::check($request->current_password, $user->password)) {

                $user->password = Hash::make($request->new_password);
            } else {

                return redirect()->back()
                    ->withErrors(['current_password' => 'Password saat ini salah'])
                    ->withInput();
            }
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function home()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $jumlahPenduduk = Penduduk::count();

        $jumlahUser = User::count();

        $jumlahJenisSurat = JenisSurat::count();

        $jumlahBerita = Berita::count();

        $jumlahPengajuan = PengajuanSurat::count();

        $jumlahMenunggu = PengajuanSurat::where('status', 'menunggu')
            ->count();

        $jumlahDiproses = PengajuanSurat::where('status', 'diproses')
            ->count();

        $jumlahSelesai = PengajuanSurat::where('status', 'selesai')
            ->count();

        $jumlahDitolak = PengajuanSurat::where('status', 'ditolak')
            ->count();

        $jumlahRiwayat = PengajuanSurat::whereIn('status', [
            'selesai',
            'ditolak'
        ])->count();

        /*
        |--------------------------------------------------------------------------
        | Grafik Pengajuan per Bulan
        |--------------------------------------------------------------------------
        */

        $grafikPengajuan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $grafikPengajuan[] = PengajuanSurat::whereYear(
                'tanggal_pengajuan',
                now()->year
            )
                ->whereMonth(
                    'tanggal_pengajuan',
                    $bulan
                )
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Pengajuan Terbaru
        |--------------------------------------------------------------------------
        */

        $pengajuanTerbaru = PengajuanSurat::with([
            'user.penduduk',
            'jenisSurat'
        ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Berita Terbaru
        |--------------------------------------------------------------------------
        */

        $beritaTerbaru = Berita::latest()
            ->take(5)
            ->get();

        return view('home', compact(
            'jumlahPenduduk',
            'jumlahUser',
            'jumlahJenisSurat',
            'jumlahBerita',
            'jumlahPengajuan',
            'jumlahMenunggu',
            'jumlahDiproses',
            'jumlahSelesai',
            'jumlahDitolak',
            'jumlahRiwayat',
            'grafikPengajuan',
            'pengajuanTerbaru',
            'beritaTerbaru'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdateBeritaRequest;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::with('user')
            ->latest()
            ->get();

        return view(
            'berita.index',
            compact('berita')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'konten'    => 'required',
        ]);

        try {

            $thumbnail = null;

            if ($request->hasFile('thumbnail')) {

                $thumbnail = $request
                    ->file('thumbnail')
                    ->store('berita', 'public');
            }

            $slug = Str::slug($validated['judul']);

            /*
        |--------------------------------------------------------------------------
        | Antisipasi slug duplikat
        |--------------------------------------------------------------------------
        */

            $originalSlug = $slug;
            $counter = 1;

            while (
                Berita::where('slug', $slug)->exists()
            ) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            Berita::create([
                'user_id'   => auth()->id(),
                'judul'     => $validated['judul'],
                'slug'      => $slug,
                'thumbnail' => $thumbnail,
                'konten'    => $validated['konten'],
            ]);

            return redirect()
                ->route('berita.index')
                ->with(
                    'success',
                    'Berita berhasil ditambahkan.'
                );
        } catch (\Exception $e) {

            Log::error('Gagal menyimpan berita', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat menyimpan berita.'
                );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->firstOrFail();

        $beritaTerbaru = Berita::where('id', '!=', $berita->id)
            ->latest()
            ->take(5)
            ->get();

        return view('berita.show', compact(
            'berita',
            'beritaTerbaru'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        return view('berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'konten'    => 'required',
        ]);

        try {
            $berita = Berita::findOrFail($id);
            $thumbnail = $berita->thumbnail;

            /*
        |--------------------------------------------------------------------------
        | Upload thumbnail baru
        |--------------------------------------------------------------------------
        */

            if ($request->hasFile('thumbnail')) {

                if (
                    $berita->thumbnail &&
                    Storage::disk('public')->exists($berita->thumbnail)
                ) {
                    Storage::disk('public')->delete($berita->thumbnail);
                }

                $thumbnail = $request
                    ->file('thumbnail')
                    ->store('berita', 'public');
            }

            /*
        |--------------------------------------------------------------------------
        | Generate slug baru jika judul berubah
        |--------------------------------------------------------------------------
        */

            $slug = $berita->slug;

            if ($berita->judul !== $validated['judul']) {

                $slug = Str::slug($validated['judul']);

                $originalSlug = $slug;
                $counter = 1;

                while (
                    Berita::where('slug', $slug)
                    ->where('id', '!=', $berita->id)
                    ->exists()
                ) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }

            $berita->update([
                'judul'     => $validated['judul'],
                'slug'      => $slug,
                'thumbnail' => $thumbnail,
                'konten'    => $validated['konten'],
            ]);

            return redirect()
                ->route('berita.index')
                ->with(
                    'success',
                    'Berita berhasil diperbarui.'
                );
        } catch (\Exception $e) {

            Log::error('Gagal memperbarui berita', [
                'berita_id' => $berita->id,
                'message'   => $e->getMessage(),
                'line'      => $e->getLine(),
                'file'      => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat memperbarui berita.'
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $berita = Berita::findOrFail($id);

            /*
        |--------------------------------------------------------------------------
        | Hapus Thumbnail
        |--------------------------------------------------------------------------
        */

            if (
                $berita->thumbnail &&
                Storage::disk('public')->exists($berita->thumbnail)
            ) {
                Storage::disk('public')->delete($berita->thumbnail);
            }

            $berita->delete();

            return redirect()
                ->route('berita.index')
                ->with(
                    'success',
                    'Berita berhasil dihapus.'
                );
        } catch (\Exception $e) {

            Log::error('Gagal menghapus berita', [
                'berita_id' => $id,
                'message'   => $e->getMessage(),
                'line'      => $e->getLine(),
                'file'      => $e->getFile(),
            ]);

            return back()
                ->with(
                    'error',
                    'Terjadi kesalahan saat menghapus berita.'
                );
        }
    }
}

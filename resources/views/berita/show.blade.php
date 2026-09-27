@extends('layouts.landing')

@section('content')


    

    <main class="pt-10 pb-24">
        <section class="max-w-5xl mx-auto px-6">
            <!-- Back Link -->
            <div class="mb-10">
                <a href="/#berita" class="text-xs font-semibold text-primary tracking-widest uppercase hover:underline flex items-center gap-2">
                    &larr; Kembali ke Berita
                </a>
            </div>

            <!-- Meta -->
            <div class="flex items-center gap-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-4">
                <span class="text-secondary">Berita Desa</span>
                <span>{{ $berita->created_at->translatedFormat('d F Y') }}</span>
            </div>
            
            <!-- Title (Dikurangi ukurannya) -->
            <h1 class="text-3xl md:text-5xl font-bold text-primary leading-tight mb-10 max-w-4xl tracking-tight">
                {{ $berita->judul }}
            </h1>

            <!-- Featured Image (Dikurangi tinggi dan dibatasi lebarnya) -->
            <figure class="mb-10">
                <img src="{{ $berita->thumbnail_url }}" alt="{{ $berita->judul }}"
                    class="w-full h-auto max-h-[300px] object-cover rounded-xl shadow-md">
            </figure>

            <!-- Grid Content & Sidebar -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">
                <!-- Main Content -->
                <div class="md:col-span-8 lg:col-span-8 prose prose-slate prose-lg max-w-none text-on-surface leading-relaxed font-sans">
                    {!! $berita->konten !!}
                </div>

                <!-- Sidebar -->
                <div class="md:col-span-4 lg:col-span-4">
                    <div class="sticky top-32">
                        <div class="border-t-2 border-primary/20 pt-4 mb-8">
                            <h4 class="text-xs font-bold text-secondary uppercase tracking-widest mb-2">Kategori</h4>
                            <p class="text-base font-semibold text-on-surface">Berita Desa</p>
                        </div>
                        
                        <div class="border-t-2 border-primary/20 pt-4">
                            <a href="/#berita" class="text-xs font-bold text-primary uppercase tracking-widest hover:underline flex items-center">
                                Lihat Berita Lainnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

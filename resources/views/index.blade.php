@extends('layouts.landing')

@section('content')
<!-- BEGIN: HeroSection -->
<section class="relative pt-12 overflow-hidden hero-gradient pb-16" id="beranda">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
<!-- Left Content -->
<div class="lg:col-span-6 space-y-6">
<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/60 text-brand-600 text-xs font-semibold tracking-wide">
<span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            PORTAL RESMI PEMERINTAH DESA&nbsp;</div>
<h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
            Layanan <span class="text-brand-600">Desa Lubuk Bernai</span> Lebih Cepat &amp; Transparan
          </h1>
<p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
            Mewujudkan tata kelola desa yang modern dan inklusif. Urus administrasi kependudukan dan pantau kabar desa dengan mudah langsung dari layar gawai Anda.
          </p>
<!-- Primary Actions -->
<div class="flex flex-wrap items-center gap-4 pt-2">
<a class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm transition-all shadow-lg shadow-brand-600/30 hover:shadow-brand-600/40 transform hover:-translate-y-0.5" href="{{ route('pengajuan-surat.create') }}">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span class="">Ajukan Surat Online</span>
</a>
<a class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-sm border border-slate-200 transition-all hover:border-slate-300" href="#berita">
<span class="">Lihat Berita Desa</span>
<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</a>
</div>
<!-- Quick Service Search Box -->
<div class="pt-4 max-w-md">
<div class="relative flex items-center">
<span class="absolute left-4 text-slate-400">

</span>


</div>

</div>
</div>
<!-- Right Hero Media Presentation -->
<div class="lg:col-span-6 relative">
<div class="relative mx-auto rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-slate-100 max-h-[500px] group">
<img alt="Kantor dan Suasana Desa Lubuk Bernai" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700" src="{{ asset('images/hero-desa.jpg') }}">

</div>
</div>
</div>
</section>
<!-- END: HeroSection -->
<!-- BEGIN: VillageStatistics -->
<section class="relative -mt-12 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 bg-white p-6 sm:p-8 rounded-3xl shadow-xl shadow-slate-200/70 border border-slate-100">
<!-- Stat 1 -->
<div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
<div class="w-14 h-14 rounded-2xl bg-blue-50 text-brand-600 flex items-center justify-center shrink-0 border border-blue-100">
<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<div>
<span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block">Jumlah Penduduk</span>
<span class="text-2xl sm:text-3xl font-extrabold text-slate-800">~4.500</span>
<span class="text-[11px] text-slate-500 block">Jiwa terdaftar</span>
</div>
</div>
<!-- Stat 2 -->
<div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
<div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<div>
<span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block">Kepala Keluarga</span>
<span class="text-2xl sm:text-3xl font-extrabold text-slate-800">~1.200</span>
<span class="text-[11px] text-slate-500 block">KK Aktif</span>
</div>
</div>
<!-- Stat 3 -->
<div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
<div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<div>
<span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block">Rukun Tetangga</span>
<span class="text-2xl sm:text-3xl font-extrabold text-slate-800">24</span>
<span class="text-[11px] text-slate-500 block">Wilayah RT</span>
</div>
</div>
<!-- Stat 4 -->
<div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
<div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<div>
<span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block">Jumlah Dusun</span>
<span class="text-2xl sm:text-3xl font-extrabold text-slate-800">6</span>
<span class="text-[11px] text-slate-500 block">Dusun Pemukiman</span>
</div>
</div>
</div>
</section>
<!-- END: VillageStatistics -->
<!-- BEGIN: OnlineLetterServices -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" id="layanan">
<div class="text-center max-w-2xl mx-auto mb-10">
<span class="px-3.5 py-1.5 rounded-full bg-blue-50 text-brand-600 text-xs font-bold tracking-wide uppercase">Layanan Mandiri</span>
<h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">Layanan Surat Online</h2>
<p class="text-slate-600 mt-3 text-base">Proses permohonan surat kini lebih mudah, cepat, dan transparan langsung dari genggaman Anda tanpa perlu bolak-balik ke kantor desa.</p>
</div>
<!-- Letter Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<!-- Card 1: SK Domisili -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-xl hover:border-brand-500/40 transition-all duration-300 group">
<div>
<div class="flex items-center justify-between mb-5">
<div class="w-12 h-12 rounded-xl bg-blue-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-colors">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>

</div>
<h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">SK Domisili</h3>
<p class="text-sm text-slate-500 mt-2 leading-relaxed">
            Surat keterangan tempat tinggal resmi dari pemerintah desa untuk keperluan administrasi dan pencatatan.
          </p>
</div>
<div class="mt-8 pt-4 border-t border-slate-100">
<a class="w-full py-2.5 px-4 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm" href="{{ route('pengajuan-surat.create') }}">
<span class="">Ajukan Sekarang</span>
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</a>
</div>
</div>
<!-- Card 2: SK Usaha -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-xl hover:border-brand-500/40 transition-all duration-300 group">
<div>
<div class="flex items-center justify-between mb-5">
<div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-colors">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>

</div>
<h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">SK Usaha</h3>
<p class="text-sm text-slate-500 mt-2 leading-relaxed">
            Legalitas usaha mikro dan UMKM untuk syarat pengajuan kredit KUR, perizinan, dan perbankan.
          </p>
</div>
<div class="mt-8 pt-4 border-t border-slate-100">
<a class="w-full py-2.5 px-4 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm" href="{{ route('pengajuan-surat.create') }}">
<span class="">Ajukan Sekarang</span>
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</a>
</div>
</div>
<!-- Card 3: SKTM -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-xl hover:border-brand-500/40 transition-all duration-300 group">
<div>
<div class="flex items-center justify-between mb-5">
<div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-colors">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>

</div>
<h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">SKTM</h3>
<p class="text-sm text-slate-500 mt-2 leading-relaxed">
            Surat keterangan tidak mampu untuk keperluan keringanan biaya pendidikan, beasiswa, dan bantuan sosial.
          </p>
</div>
<div class="mt-8 pt-4 border-t border-slate-100">
<a class="w-full py-2.5 px-4 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm" href="{{ route('pengajuan-surat.create') }}">
<span class="">Ajukan Sekarang</span>
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</a>
</div>
</div>
<!-- Card 4: SK Kelahiran -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-xl hover:border-brand-500/40 transition-all duration-300 group">
<div>
<div class="flex items-center justify-between mb-5">
<div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-colors">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
<path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>

</div>
<h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">SK Kelahiran</h3>
<p class="text-sm text-slate-500 mt-2 leading-relaxed">
            Layanan administrasi dasar bagi putra-putri warga baru sebagai pengantar penerbitan Akta Catatan Sipil.
          </p>
</div>
<div class="mt-8 pt-4 border-t border-slate-100">
<a class="w-full py-2.5 px-4 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm" href="{{ route('pengajuan-surat.create') }}">
<span class="">Ajukan Sekarang</span>
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</a>
</div>
</div>
</div>
<!-- Info Banner for Requirements -->
<div class="mt-10 p-5 rounded-2xl bg-gradient-to-r from-blue-900 to-brand-800 text-white flex flex-col md:flex-row items-center justify-between gap-4">
<div class="flex items-center gap-3">
<div class="p-2.5 rounded-lg bg-white/10 shrink-0">
<svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<p class="text-sm leading-relaxed text-blue-50">
          Semua dokumen yang diterbitkan telah terverifikasi secara elektronik dan sah digunakan di tingkat instansi terkait.
        </p>
</div>

</div>
</section>
<!-- END: OnlineLetterServices -->
<!-- BEGIN: VillageNewsSection -->
<section class="bg-slate-100/70 border-t border-slate-200/60 py-12" id="berita">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- Section Header with Arrows -->
<div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
<div>
<span class="text-brand-600 font-bold text-xs uppercase tracking-wider block mb-1">Pembaruan &amp; Publikasi</span>
<h2 class="text-3xl font-extrabold text-slate-900">Kabar Terkini Lubuk Bernai</h2>
</div>
<div class="flex items-center gap-2">
<button aria-label="Previous" class="w-10 h-10 rounded-full border border-slate-300 bg-white flex items-center justify-center text-slate-600 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition shadow-sm">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"></path></svg>
</button>
<button aria-label="Next" class="w-10 h-10 rounded-full border border-slate-300 bg-white flex items-center justify-center text-slate-600 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition shadow-sm">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"></path></svg>
</button>
</div>
</div>
<!-- News Cards Grid -->
<div id="news-carousel" class="flex overflow-x-hidden snap-x snap-mandatory gap-8 scroll-smooth w-full">
@forelse ($berita as $item)
<!-- News Card -->
<article class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-lg transition flex flex-col group w-full md:w-[calc(33.333%-1.33rem)] shrink-0 snap-start">
<div class="relative h-40 overflow-hidden bg-slate-200">
@if($item->thumbnail)
<img alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $item->thumbnail) }}">
@else
<div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 group-hover:scale-105 transition-transform duration-500">
<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
</div>
@endif
<div class="absolute top-4 left-4">
<span class="px-3 py-1 rounded-md bg-brand-700 text-white font-bold text-[10px] tracking-wide uppercase">{{ $item->kategori->nama ?? 'BERITA DESA' }}</span>
</div>
</div>
<div class="p-6 flex-1 flex flex-col justify-between">
<div>
<time class="text-xs font-semibold text-slate-400 block mb-2">{{ strtoupper($item->created_at->translatedFormat('d F Y')) }}</time>
<h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors leading-snug">
{{ $item->judul }}
</h3>
<p class="text-slate-600 text-xs sm:text-sm mt-3 leading-relaxed line-clamp-3">
{{ Str::limit(strip_tags($item->konten), 100) }}
</p>
</div>
<div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
<a class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-800" href="{{ route('berita.show', $item->slug) }}">
<span class="">Baca Selengkapnya</span>
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
</a>
</div>
</div>
</article>
@empty
<div class="col-span-1 md:col-span-3 text-center py-10">
<p class="text-slate-500">Belum ada berita terbaru.</p>
</div>
@endforelse
</div>
</div>
</section>
<!-- END: VillageNewsSection -->
<!-- BEGIN: VillageAgendaSchedule -->

<!-- END: VillageAgendaSchedule -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('news-carousel');
    const prevBtn = document.querySelector('button[aria-label="Previous"]');
    const nextBtn = document.querySelector('button[aria-label="Next"]');

    if (carousel && prevBtn && nextBtn) {
        const scrollAmount = () => {
            const card = carousel.firstElementChild;
            return card ? card.clientWidth + 32 : 300;
        };

        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });
        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });
    }
});
</script>

@endsection

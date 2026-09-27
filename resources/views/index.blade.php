<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Desa Lubuk Bernai | Portal Layanan Digital</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#1E3A8A", // Blue 900
                        "on-primary": "#ffffff",
                        "primary-container": "#DBEAFE", // Blue 100
                        "on-primary-container": "#1E3A8A",
                        "secondary": "#3B82F6", // Blue 500
                        "on-secondary": "#ffffff",
                        "secondary-container": "#EFF6FF", // Blue 50
                        "on-secondary-container": "#1E3A8A",
                        "tertiary": "#F59E0B", // Amber 500
                        "on-tertiary": "#ffffff",
                        "background": "#F8FAFC", // Slate 50
                        "on-background": "#1E293B", // Slate 800
                        "surface": "#FFFFFF",
                        "on-surface": "#1E293B",
                        "surface-variant": "#F1F5F9",
                        "on-surface-variant": "#475569",
                        "outline": "#94A3B8",
                        "outline-variant": "#CBD5E1",
                        "surface-container-low": "#F8FAFC",
                        "surface-container": "#F1F5F9",
                        "surface-container-high": "#E2E8F0",
                        "surface-container-highest": "#CBD5E1",
                        "surface-container-lowest": "#FFFFFF",
                        "inverse-surface": "#1E293B",
                        "inverse-on-surface": "#F8FAFC",
                        "primary-fixed": "#1E3A8A",
                        "tertiary-fixed": "#F59E0B",
                        "on-tertiary-fixed": "#1E293B"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "16px",
                        "xl": "24px",
                        "full": "9999px"
                    },
                    
                    
                    
                },
            },
        }
    </script>
    <style>
        .glass-card {
            background: rgba(248, 250, 252, 0.7); /* slate-50 */
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-gradient {
            background: linear-gradient(to right, rgba(30, 58, 138, 0.9), rgba(30, 58, 138, 0.6));
        }

        .soft-elevation {
            box-shadow: 0 10px 32px -4px rgba(30, 58, 138, 0.1);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { 
            animation: fadeInUp 0.8s ease-out forwards; 
            opacity: 0; 
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
    </style>
</head>

<body class="bg-background text-on-surface text-base">
    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 bg-surface/90 backdrop-blur-md shadow-sm transition-all duration-300">
        <nav id="navbar" class="flex justify-between items-center px-6 py-6 max-w-7xl mx-auto transition-all duration-300">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/sekolah.png') }}" alt="Logo Desa" class="w-10 h-10 object-contain">
                <span class="text-2xl font-bold leading-tight text-primary">Desa
                    Lubuk Bernai</span>
            </div>
            <div class="hidden md:flex items-center gap-12 nav-menu">
                <a class="nav-link text-primary transition-colors text-base font-bold leading-relaxed relative after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-primary after:rounded-full"
                    href="/#home" data-target="home">Beranda</a>
                <a class="nav-link text-on-surface-variant hover:text-primary transition-colors text-base font-normal leading-relaxed"
                    href="/#layanan" data-target="layanan">Layanan Surat</a>
                <a class="nav-link text-on-surface-variant hover:text-primary transition-colors text-base font-normal leading-relaxed"
                    href="/#berita" data-target="berita">Berita</a>
            </div>
            <div class="flex items-center gap-6">
                <a class="px-8 py-2.5 bg-primary text-white rounded-full text-sm font-medium tracking-wide transition-colors duration-200 hover:bg-blue-800 hover:shadow-md"
                    href="{{ route('login') }}">Login</a>
            </div>
        </nav>
    </header>
    <main class="pt-20">
        <!-- Hero Section -->
        <section id="home" class="relative min-h-[70vh] lg:min-h-[75vh] flex items-center bg-surface overflow-hidden">
            <!-- Background element -->
            <div class="absolute inset-0 bg-primary/5 z-0">
                <div class="absolute right-0 top-0 w-1/2 h-full bg-primary/10 rounded-l-[100px] transform translate-x-1/4 skew-x-12"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center -mt-24">
                    <div class="max-w-xl animate-fade-in-up">

                        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight text-on-surface mb-6 leading-tight">
                            Layanan <span class="text-secondary">Desa Lubuk Bernai</span> Lebih Cepat & Transparan
                        </h1>
                        <p class="text-lg font-normal leading-relaxed text-on-surface-variant mb-12">
                            Mewujudkan tata kelola desa yang modern dan inklusif. Urus administrasi dan pantau kabar desa dengan mudah langsung dari layar Anda.
                        </p>
                        <div class="flex flex-row flex-wrap gap-4 mt-4">
                            <a class="px-8 py-3 bg-secondary text-white rounded-full text-lg font-semibold shadow-md hover:-translate-y-1 hover:shadow-lg hover:bg-blue-600 transition-all duration-300 flex justify-center items-center gap-2 group w-full sm:w-auto"
                                href="/#layanan">
                                Ajukan Surat
                                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform text-xl" aria-hidden="true">description</span>
                            </a>
                            <a class="px-8 py-3 border-2 border-primary text-primary rounded-full text-lg font-semibold hover:bg-primary hover:text-white transition-all duration-300 flex justify-center items-center w-full sm:w-auto"
                                href="/#berita">
                                Lihat Berita
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative hidden lg:block animate-fade-in-up" style="animation-delay: 0.2s;">
                        <img alt="Kantor Desa Modern Lubuk Bernai" class="w-full aspect-[4/3] object-cover rounded-2xl shadow-2xl animate-float border-4 border-white"
                            src="{{ asset('images/kantor_desa_hero.jpg') }}" />
                        
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Grid -->
        <section class="relative z-20 -mt-12 lg:-mt-24 pb-12">
            <div class="max-w-7xl mx-auto px-6 md:px-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-surface p-6 rounded-xl shadow-lg border border-outline-variant/30 flex items-center gap-6 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div
                            class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-4xl"
                                style="font-variation-settings: 'FILL' 1;" aria-hidden="true">groups</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-on-surface-variant">Jumlah Penduduk</p>
                            <h3 class="text-4xl font-bold text-primary">~4,500</h3>
                        </div>
                    </div>
                    <div
                        class="bg-surface p-6 rounded-xl shadow-lg border border-outline-variant/30 flex items-center gap-6 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.4s;">
                        <div
                            class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-4xl"
                                style="font-variation-settings: 'FILL' 1;" aria-hidden="true">family_restroom</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-on-surface-variant">Kepala Keluarga</p>
                            <h3 class="text-4xl font-bold text-primary">~1,200</h3>
                        </div>
                    </div>
                    <div
                        class="bg-surface p-6 rounded-xl shadow-lg border border-outline-variant/30 flex items-center gap-6 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.5s;">
                        <div
                            class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-4xl"
                                style="font-variation-settings: 'FILL' 1;" aria-hidden="true">home</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-on-surface-variant">Jumlah RT</p>
                            <h3 class="text-4xl font-bold text-primary">24</h3>
                        </div>
                    </div>
                    <div
                        class="bg-surface p-6 rounded-xl shadow-lg border border-outline-variant/30 flex items-center gap-6 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.6s;">
                        <div
                            class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-4xl"
                                style="font-variation-settings: 'FILL' 1;" aria-hidden="true">location_city</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-on-surface-variant">Jumlah Dusun</p>
                            <h3 class="text-4xl font-bold text-primary">6</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Online Letter Services -->
        <section class="py-12 bg-surface" id="layanan">
            <div class="max-w-7xl mx-auto px-6 md:px-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                    <div class="max-w-2xl">
                        <span
                            class="px-4 py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-semibold uppercase uppercase tracking-wider mb-4 inline-block">Layanan
                            Mandiri</span>
                        <h2 class="text-4xl font-bold text-on-surface mb-2">Layanan Surat Online</h2>
                        <p class="text-lg text-on-surface-variant">Proses permohonan surat kini lebih mudah, cepat,
                            dan transparan langsung dari genggaman Anda.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Service Card 1 -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-secondary hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-symbols-outlined text-6xl" aria-hidden="true">distance</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-lg bg-secondary-container flex items-center justify-center text-secondary mb-6">
                            <span class="material-symbols-outlined" aria-hidden="true">distance</span>
                        </div>
                        <h4 class="text-xl font-bold text-on-surface mb-4">SK Domisili</h4>
                        <p class="text-base text-on-surface-variant mb-12">Surat keterangan tempat tinggal resmi dari
                            pemerintah desa.</p>
                        <button
                            class="w-full py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors mt-auto">Ajukan
                            Sekarang</button>
                    </div>
                    <!-- Service Card 2 -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-secondary hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-symbols-outlined text-6xl" aria-hidden="true">storefront</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-lg bg-secondary-container flex items-center justify-center text-secondary mb-6">
                            <span class="material-symbols-outlined" aria-hidden="true">storefront</span>
                        </div>
                        <h4 class="text-xl font-bold text-on-surface mb-4">SK Usaha</h4>
                        <p class="text-base text-on-surface-variant mb-12">Legalitas usaha mikro untuk keperluan
                            administrasi perbankan.</p>
                        <button
                            class="w-full py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors mt-auto">Ajukan
                            Sekarang</button>
                    </div>
                    <!-- Service Card 3 -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-secondary hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-symbols-outlined text-6xl" aria-hidden="true">assignment_ind</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-lg bg-secondary-container flex items-center justify-center text-secondary mb-6">
                            <span class="material-symbols-outlined" aria-hidden="true">assignment_ind</span>
                        </div>
                        <h4 class="text-xl font-bold text-on-surface mb-4">SKTM</h4>
                        <p class="text-base text-on-surface-variant mb-12">Surat keterangan tidak mampu untuk
                            layanan bantuan sosial.</p>
                        <button
                            class="w-full py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors mt-auto">Ajukan
                            Sekarang</button>
                    </div>
                    <!-- Service Card 4 -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-secondary hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-symbols-outlined text-6xl" aria-hidden="true">child_care</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-lg bg-secondary-container flex items-center justify-center text-secondary mb-6">
                            <span class="material-symbols-outlined" aria-hidden="true">child_care</span>
                        </div>
                        <h4 class="text-xl font-bold text-on-surface mb-4">SK Kelahiran</h4>
                        <p class="text-base text-on-surface-variant mb-12">Layanan administrasi dasar bagi
                            putra-putri warga desa.</p>
                        <button
                            class="w-full py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors mt-auto">Ajukan
                            Sekarang</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Village News -->
        <!-- Style untuk menghilangkan scrollbar bawaan browser namun tetap bisa di-scroll -->
        <style>
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
        <section class="py-12 bg-surface-container-low relative" id="berita">
            <div class="max-w-7xl mx-auto px-6 md:px-12">

                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h2 class="text-4xl font-bold text-on-surface mb-4">
                            Kabar Terkini Lubuk Bernai
                        </h2>
                        <div class="h-1 w-24 bg-primary rounded-full"></div>
                    </div>
                    <div class="hidden md:flex items-center gap-2">
                        <button id="berita-prev" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </button>
                        <button id="berita-next" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Container Scrollable -->
                <div id="berita-slider" class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory hide-scrollbar scroll-smooth">

                    @forelse($berita as $item)
                        <article
                            class="bg-white rounded-2xl overflow-hidden border border-slate-100 hover:border-slate-300 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group flex-none w-[85vw] md:w-[calc(33.333%-1rem)] snap-start flex flex-col h-full">

                            <div class="h-48 relative overflow-hidden">

                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                                <div class="absolute top-4 left-4">

                                    <span class="bg-primary text-on-primary px-4 py-1 rounded text-xs font-semibold uppercase">
                                        Berita Desa
                                    </span>

                                </div>

                            </div>

                            <div class="p-6 flex flex-col flex-grow">

                                <time class="text-xs font-semibold uppercase text-on-surface-variant">
                                    {{ $item->created_at->format('d F Y') }}
                                </time>

                                <h3 class="text-xl font-bold text-on-surface mt-2 mb-4 group-hover:text-primary transition-colors">
                                    {{ Str::limit($item->judul, 60) }}
                                </h3>

                                <p class="text-base text-on-surface-variant line-clamp-3 mb-6">
                                    {{ Str::limit(strip_tags($item->konten), 120) }}
                                </p>

                                <div class="mt-auto">
                                    <a href="{{ route('berita.show', $item->slug) }}"
                                        class="text-primary text-sm font-medium flex items-center gap-2 group-hover:underline">
    
                                        Baca Selengkapnya
    
                                        <span
                                            class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">
                                            arrow_right_alt
                                        </span>
    
                                    </a>
                                </div>

                            </div>

                        </article>
                        @php
                            $placeholderCount = 3 - $berita->count();
                        @endphp
                    @empty
                    @endforelse
                    
                    @if(isset($placeholderCount) && $placeholderCount > 0)
                        @for ($i = 0; $i < $placeholderCount; $i++)
                            <article
                                class="bg-white rounded-2xl overflow-hidden border border-slate-100 opacity-80 group flex-none w-[85vw] md:w-[calc(33.333%-1rem)] snap-start flex flex-col h-full">
    
                                <div class="h-48 relative overflow-hidden">
    
                                    <img src="https://placehold.co/600x400/e2e8f0/64748b?text=Berita+Desa"
                                        alt="Placeholder Berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
    
                                    <div class="absolute top-4 left-4">
    
                                        <span class="bg-gray-500 text-white px-4 py-1 rounded text-xs font-semibold uppercase">
                                            Segera Hadir
                                        </span>
    
                                    </div>
    
                                </div>
    
                                <div class="p-6 flex flex-col flex-grow">
    
                                    <time class="text-xs font-semibold uppercase text-on-surface-variant">
                                        -
                                    </time>
    
                                    <h3 class="text-xl font-bold text-on-surface mt-2 mb-4">
                                        Informasi Desa Akan Segera Diperbarui
                                    </h3>
    
                                    <p class="text-base text-on-surface-variant line-clamp-3 mb-6">
                                        Pemerintah Desa Lubuk Bernai akan terus menghadirkan
                                        informasi dan kegiatan terbaru untuk masyarakat.
                                    </p>
    
                                    <div class="mt-auto">
                                        <span class="text-gray-400 text-sm font-medium flex items-center gap-2 cursor-not-allowed">
        
                                            Belum Tersedia
        
                                        </span>
                                    </div>
    
                                </div>
    
                            </article>
                        @endfor
                    @endif
                    
                    
                </div>

            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const slider = document.getElementById('berita-slider');
                    const btnPrev = document.getElementById('berita-prev');
                    const btnNext = document.getElementById('berita-next');

                    if(btnNext && btnPrev && slider) {
                        btnNext.addEventListener('click', () => {
                            // Scroll by the width of one card plus gap
                            const scrollAmount = window.innerWidth < 768 ? window.innerWidth * 0.85 : slider.clientWidth / 3;
                            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                        });
                        btnPrev.addEventListener('click', () => {
                            const scrollAmount = window.innerWidth < 768 ? window.innerWidth * 0.85 : slider.clientWidth / 3;
                            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                        });
                    }
                });
            </script>
        </section>
        
    </main>
    <!-- Footer -->
    <footer class="bg-slate-900 w-full pt-20 pb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 px-6 max-w-7xl mx-auto">
            <div class="md:col-span-4">
                <span class="text-xl font-bold leading-tight font-bold text-white mb-6 block">Desa Lubuk Bernai</span>
                <p class="text-slate-300 text-base font-normal leading-relaxed mb-6">Mewujudkan desa digital yang mandiri, sejahtera, dan berbudaya melalui inovasi layanan publik yang transparan.</p>
                <div class="flex gap-6">
                    <a class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-secondary hover:text-white transition-all"
                        href="#" aria-label="Website"><span class="material-symbols-outlined" aria-hidden="true" aria-hidden="true">public</span></a>
                    <a class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-secondary hover:text-white transition-all"
                        href="#" aria-label="Email"><span class="material-symbols-outlined" aria-hidden="true" aria-hidden="true">mail</span></a>
                    <a class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-secondary hover:text-white transition-all"
                        href="#" aria-label="Phone"><span class="material-symbols-outlined" aria-hidden="true" aria-hidden="true">call</span></a>
                </div>
            </div>
            <div class="md:col-span-2">
                <h4 class="text-sm font-medium tracking-wide text-white mb-6">Layanan</h4>
                <ul class="flex flex-col gap-4">
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">Administrasi</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">Kesehatan</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">Pendidikan</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">UMKM Desa</a></li>
                </ul>
            </div>
            <div class="md:col-span-2">
                <h4 class="text-sm font-medium tracking-wide text-white mb-6">Informasi</h4>
                <ul class="flex flex-col gap-4">
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">Kebijakan Privasi</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">Peta Situs</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base text-base" href="#">Bantuan</a></li>
                </ul>
            </div>
            <div class="md:col-span-4">
                <h4 class="text-sm font-medium tracking-wide text-white mb-6">Alamat Kantor</h4>
                <p class="text-slate-300 text-base font-normal leading-relaxed flex gap-2">
                    <span class="material-symbols-outlined text-secondary" aria-hidden="true">location_on</span>
                    Jl. Raya Lubuk Bernai No. 01, Kec. Batang Asam, Kab. Tanjung Jabung Barat, Jambi 36552
                </p>
                <div class="mt-6 h-32 w-full rounded-lg bg-slate-800 overflow-hidden border border-slate-700">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-xs font-semibold uppercase text-xs font-semibold uppercase text-slate-500">Interactive Map Loading...</span>
                    </div>
                </div>
            </div>
            <div class="md:col-span-12 pt-12 mt-6 border-t border-slate-800 text-center">
                <p class="text-slate-500 text-sm font-medium tracking-wide">© 2024 Desa Lubuk Bernai, Kabupaten Tanjung Jabung Barat. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            const nav = document.getElementById('navbar');
            
            // Scrollspy logic
            const sections = document.querySelectorAll('section[id]');
            const scrollY = window.scrollY;
            
            sections.forEach(current => {
                const sectionHeight = current.offsetHeight;
                const sectionTop = current.offsetTop - 100;
                const sectionId = current.getAttribute('id');
                const navLink = document.querySelector('.nav-menu a[data-target="' + sectionId + '"]');
                
                if (navLink && scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    // Remove active classes from all
                    document.querySelectorAll('.nav-menu a').forEach(a => {
                        a.className = "nav-link text-on-surface-variant hover:text-primary transition-colors text-base font-normal leading-relaxed";
                    });
                    // Add active class to current
                    navLink.className = "nav-link text-primary transition-colors text-base font-bold leading-relaxed relative after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-primary after:rounded-full";
                }
            });

            if (window.scrollY > 50) {
                header.classList.add('shadow-md', 'bg-surface/95');
                header.classList.remove('shadow-sm', 'bg-surface/90');
                
                nav.classList.add('py-4');
                nav.classList.remove('py-6');
            } else {
                header.classList.add('shadow-sm', 'bg-surface/90');
                header.classList.remove('shadow-md', 'bg-surface/95');
                
                nav.classList.add('py-6');
                nav.classList.remove('py-4');
            }
        });
    </script>
</body>

</html>

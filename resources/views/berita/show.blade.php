<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $berita->judul }} | Desa Lubuk Bernai</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries,typography"></script>
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
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
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
</head>

<body class="bg-background text-on-surface font-sans">
    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 bg-surface/90 backdrop-blur-md shadow-sm transition-all duration-300">
        <nav id="navbar" class="flex justify-between items-center px-6 py-6 max-w-7xl mx-auto transition-all duration-300">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold leading-tight text-primary">Desa
                    Lubuk Bernai</span>
            </div>
            <div class="hidden md:flex items-center gap-12 nav-menu">
                <a class="nav-link text-on-surface-variant hover:text-primary transition-colors text-base font-normal leading-relaxed"
                    href="/#home">Beranda</a>
                <a class="nav-link text-on-surface-variant hover:text-primary transition-colors text-base font-normal leading-relaxed"
                    href="/#layanan">Layanan Surat</a>
                <a class="nav-link text-primary transition-colors text-base font-bold leading-relaxed relative after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-primary after:rounded-full"
                    href="/#berita">Berita</a>
            </div>
            <div class="flex items-center gap-6">
                <a class="px-8 py-2.5 bg-primary text-white rounded-full text-sm font-medium tracking-wide transition-all hover:bg-secondary hover:-translate-y-0.5 hover:shadow-md active:scale-95 duration-150"
                    href="{{ route('login') }}">Login</a>
            </div>
        </nav>
    </header>

    <main class="pt-32 pb-24">
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
            <figure class="mb-14">
                <img src="{{ $berita->thumbnail_url }}" alt="{{ $berita->judul }}"
                    class="w-full h-auto max-h-[450px] object-cover rounded-xl shadow-md">
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
    
    <footer class="bg-slate-900 w-full pt-20 pb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 px-6 max-w-7xl mx-auto">
            <div class="md:col-span-4">
                <span class="text-xl font-bold leading-tight text-white mb-6 block">Desa Lubuk Bernai</span>
                <p class="text-slate-300 text-base font-normal leading-relaxed mb-6">Mewujudkan desa digital yang mandiri, sejahtera, dan berbudaya melalui inovasi layanan publik yang transparan.</p>
                <div class="flex gap-6">
                    <a class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-secondary hover:text-white transition-all"
                        href="#" aria-label="Website"><span class="material-symbols-outlined" aria-hidden="true">public</span></a>
                    <a class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-secondary hover:text-white transition-all"
                        href="#" aria-label="Email"><span class="material-symbols-outlined" aria-hidden="true">mail</span></a>
                    <a class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-secondary hover:text-white transition-all"
                        href="#" aria-label="Phone"><span class="material-symbols-outlined" aria-hidden="true">call</span></a>
                </div>
            </div>
            <div class="md:col-span-2">
                <h4 class="text-sm font-medium tracking-wide text-white mb-6">Layanan</h4>
                <ul class="flex flex-col gap-4">
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">Administrasi</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">Kesehatan</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">Pendidikan</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">UMKM Desa</a></li>
                </ul>
            </div>
            <div class="md:col-span-2">
                <h4 class="text-sm font-medium tracking-wide text-white mb-6">Informasi</h4>
                <ul class="flex flex-col gap-4">
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">Kebijakan Privasi</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">Peta Situs</a></li>
                    <li><a class="text-slate-400 hover:text-secondary transition-colors hover:underline text-base" href="#">Bantuan</a></li>
                </ul>
            </div>
            <div class="md:col-span-4">
                <h4 class="text-sm font-medium tracking-wide text-white mb-6">Alamat Kantor</h4>
                <p class="text-slate-300 text-base font-normal leading-relaxed flex gap-2">
                    <span class="material-symbols-outlined text-secondary" aria-hidden="true">location_on</span>
                    Jl. Raya Lubuk Bernai No. 01, Kec. Batang Asam, Kab. Tanjung Jabung Barat, Jambi 36552
                </p>
            </div>
            <div class="md:col-span-12 pt-12 mt-6 border-t border-slate-800 text-center">
                <p class="text-slate-500 text-sm font-medium tracking-wide">© 2024 Desa Lubuk Bernai, Kabupaten Tanjung Jabung Barat. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('shadow-md', 'bg-surface/95');
                header.classList.remove('shadow-sm', 'bg-surface/90');
            } else {
                header.classList.add('shadow-sm', 'bg-surface/90');
                header.classList.remove('shadow-md', 'bg-surface/95');
            }
        });
    </script>
</body>

</html>

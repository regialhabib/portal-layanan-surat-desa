<!DOCTYPE html><html class="scroll-smooth" lang="id" style=""><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>Desa Lubuk Bernai - Portal Layanan &amp; Informasi Terpadu</title>
<!-- Google Fonts: Plus Jakarta Sans -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries,typography"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eef6ff',
              100: '#d9eaff',
              200: '#bbd9fe',
              500: '#1d4ed8',
              600: '#1e40af',
              700: '#1e3a8a',
              800: '#172554',
              900: '#0f172a',
            },
            accent: {
              500: '#10b981',
              600: '#059669',
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
          }
        }
      }
    }
  </script>
<!-- BEGIN: Custom Style Block -->
<style data-purpose="base-styling">
    html {
      font-size: 90%;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      color: #1e293b;
    }
    .hero-gradient {
      background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 50%),
                  radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.05), transparent 40%);
    }
  </style>
<!-- END: Custom Style Block -->
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-brand-500 selection:text-white">
<!-- BEGIN: MainHeader -->
<header id="main-header" class="sticky top-0 z-50 bg-white border-b border-transparent shadow-sm transition-all duration-300">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex items-center justify-between h-20">
<!-- Identity Branding & Logo -->
<a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
<div class="w-12 h-12 flex items-center justify-center">
<img src="{{ asset('images/sekolah.png') }}" class="w-full h-full object-contain" alt="Logo">
</div>
<div>
<span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-tight group-hover:text-brand-600 transition-colors">Desa Lubuk Bernai</span>
<span class="text-xs font-semibold text-slate-500 tracking-wide">Kec. Batang Asam, Kab. Tanjung Jabung Barat</span>
</div>
</a>
<!-- Desktop Navigation Bar -->
<nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
<a class="px-4 py-2 text-sm font-bold text-brand-600 border-b-2 border-brand-600 transition-colors" href="{{ url('/#beranda') }}">Beranda</a>
<a class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-brand-600 transition-colors" href="{{ url('/#layanan') }}">Layanan Mandiri</a>
<a class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-brand-600 transition-colors" href="{{ url('/#berita') }}">Berita</a>
</nav>
<!-- CTA Auth Button -->
<div class="flex items-center gap-3">
<a class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold bg-brand-700 text-white hover:bg-brand-800 transition-all shadow-md shadow-brand-700/20 active:scale-95" href="{{ route('login') }}">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span class="">Masuk</span>
</a>
</div>
</div>
</div>
</header>
<!-- END: MainHeader -->

<!-- MAIN CONTENT -->
<main>
    @yield('content')
</main>

<!-- BEGIN: MainFooter -->
<footer class="bg-[#0b132b] text-slate-300 pb-6 pt-8" id="kontak">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800">
<!-- Brand Info -->
<div class="lg:col-span-6 space-y-4">
<div class="flex items-center gap-3">

<h4 class="text-xl font-bold text-white">Desa Lubuk Bernai</h4>
</div>
<p class="text-sm text-slate-400 leading-relaxed pr-4">
            Mewujudkan desa digital yang mandiri, sejahtera, dan berbudaya melalui inovasi layanan publik yang transparan dan akuntabel.
          </p>
<div class="flex items-center space-x-3 pt-2">
<!-- Website Globe -->
<a class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 flex items-center justify-center text-slate-300 hover:text-white transition" href="#">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" stroke-linecap="round" stroke-linejoin="round"></path></svg>
</a>
<!-- Mail -->
<a class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 flex items-center justify-center text-slate-300 hover:text-white transition" href="#">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
</a>
<!-- Call / WA -->
<a class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 flex items-center justify-center text-slate-300 hover:text-white transition" href="#">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
</a>
</div>
</div>


<!-- Links 3: Alamat Kantor & Map Preview -->
<div class="lg:col-span-6 space-y-4">
<h5 class="text-sm font-semibold uppercase tracking-wider text-white">Alamat Kantor</h5>
<div class="flex items-start gap-3 text-sm text-slate-400">
<svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span class="">Jl. Raya Lubuk Bernai No. 01, Kec. Batang Asam, Kab. Tanjung Jabung Barat, Jambi 36552</span>
</div>
<!-- Mockup Map Visual Box -->
<div class="h-28 w-full rounded-xl bg-slate-800/80 border border-slate-700/80 flex items-center justify-center relative overflow-hidden group">
<div class="absolute inset-0 opacity-20 bg-[radial-gradient(#60a5fa_1px,transparent_1px)] [background-size:12px_12px]"></div>
<div class="text-center z-10 px-4">
<span class="text-xs font-semibold text-brand-400 tracking-wider flex items-center justify-center gap-1.5">
<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" fill-rule="evenodd"></path></svg>
                PETA INTERAKTIF DESA
              </span>
<span class="text-[11px] text-slate-400 block mt-1">Buka di Google Maps Navigasi</span>
</div>
</div>
</div>
</div>
<!-- Copyright Notice -->
<div class="mt-8 text-center text-xs text-slate-500">
<p class="">© 2026 Desa Lubuk Bernai, Kabupaten Tanjung Jabung Barat. All Rights Reserved.</p>
</div>
</div>
</footer>
<!-- END: MainFooter -->





<!-- Custom Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('nav a');
    const header = document.querySelector('header');

    window.addEventListener('scroll', () => {
        let current = '';
        const scrollY = window.scrollY;
        
        // Header Glassmorphism on Scroll
        if (scrollY > 10) {
            header.classList.remove('bg-white', 'border-transparent');
            header.classList.add('bg-white/75', 'backdrop-blur-md', 'border-slate-100');
        } else {
            header.classList.remove('bg-white/75', 'backdrop-blur-md', 'border-slate-100');
            header.classList.add('bg-white', 'border-transparent');
        }
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop - header.offsetHeight - 20;
            const sectionHeight = section.clientHeight;
            if (scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('font-bold', 'text-brand-600', 'border-b-2', 'border-brand-600');
            link.classList.add('font-medium', 'text-slate-600');
            
            const href = link.getAttribute('href') || '';
            const hash = href.substring(href.indexOf('#'));
            
            if (current && hash === '#' + current) {
                link.classList.remove('font-medium', 'text-slate-600');
                link.classList.add('font-bold', 'text-brand-600', 'border-b-2', 'border-brand-600');
            }
        });
    });
});
</script>
</body></html>
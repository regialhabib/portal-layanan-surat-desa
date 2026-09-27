 <div id="sidebar-menu">
     <!-- Left Menu Start -->
     <ul class="metismenu list-unstyled" id="side-menu">
         <li class="menu-title" key="t-menu">Menu Utama</li>

         @can('admin')
             <li>
                 <a href="{{ route('dashboard') }}" class="waves-effect">
                     <i class="bx bx-home-circle"></i>
                     <span>Dashboard</span>
                 </a>
             </li>
             
             <li class="menu-title" key="t-admin">Administrasi</li>

             <li>
                 <a href="{{ route('penduduk.index') }}" class="waves-effect">
                     <i class="bx bx-group"></i>
                     <span>Data Penduduk</span>
                 </a>
             </li>

             <li>
                 <a href="{{ route('jenis-surat.index') }}" class="waves-effect">
                     <i class="bx bx-list-ul"></i>
                     <span>Jenis Surat</span>
                 </a>
             </li>

             <li>
                 <a href="{{ route('pengajuan-surat.index') }}" class="waves-effect">
                     <i class="bx bx-file-find"></i>
                     <span>Manajemen Pengajuan</span>
                 </a>
             </li>
             
             <li class="menu-title" key="t-info">Informasi Publik</li>

             <li>
                 <a href="{{ route('berita.index') }}" class="waves-effect">
                     <i class="bx bx-news"></i>
                     <span>Berita Desa</span>
                 </a>
             </li>
         @endcan

         @can('masyarakat')
             <li>
                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                     <i class="bx bx-file-find"></i>
                     <span>Pelayanan Surat</span>
                 </a>
                 <ul class="sub-menu" aria-expanded="false">
                     <li>
                         <a href="{{ route('pengajuan-surat.create') }}">Ajukan Surat</a>
                     </li>
                     <li>
                         <a href="{{ route('masyarakat.riwayat-pengajuan') }}">Riwayat Pengajuan</a>
                     </li>
                 </ul>
             </li>
         @endcan

         <li class="menu-title" key="t-settings">Pengaturan</li>
         
         <li>
             <a href="{{ route('profile') }}" class="waves-effect">
                 <i class="bx bx-user-circle"></i>
                 <span>Profil Akun</span>
             </a>
         </li>

     </ul>
 </div>

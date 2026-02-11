<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LabManajemen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Phosphor Icons for the exact look if needed, using emojis for now as standard unicode -->
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div style="width: 30px; height: 30px; background: var(--primary-color); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center;">M</div> 
                Laboratorium<br>Manajemen Lanjut
            </div>

            <!-- Profile Widget -->
            <div class="sidebar-profile">
                <div class="sidebar-avatar" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=E1BEE7&color=9b28b5');"></div>
                <div class="sidebar-name">{{ strtoupper(Auth::user()->name) }}</div>
                <div class="sidebar-role">{{ Auth::user()->role }}</div>
            </div>

            <nav class="sidebar-menu">
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span style="font-size: 1.2rem;">📊</span> Data Pendaftar
                    </a>
                @elseif(Auth::user()->role == 'dosen')
                    <a href="{{ route('dosen.dashboard') }}" class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                        <span style="font-size: 1.2rem;">📁</span> Review Berkas
                    </a>
                @else
                    <a href="{{ route('pendaftar.dashboard') }}" class="{{ request()->routeIs('pendaftar.dashboard') ? 'active' : '' }}">
                        <span style="font-size: 1.2rem;">🏠</span> Beranda
                    </a>
                    <a href="{{ route('pendaftar.berkas_page') }}" class="{{ request()->routeIs('pendaftar.berkas_page') ? 'active' : '' }}">
                        <span style="font-size: 1.2rem;">📄</span> Pengumpulan Berkas
                    </a>
                @endif
                
                <div style="flex: 1;"></div> <!-- Spacer -->
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; padding: 0;">
                        <span class="sidebar-menu">
                            <a href="#" onclick="this.closest('form').submit(); return false;" style="color: #333;">
                                <span style="font-size: 1.2rem;">🚪</span> Keluar
                            </a>
                        </span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header collapsed into content for Pendaftar if matching mockup exactly, 
                 but keeping header for Admin/Dosen as it's useful. 
                 Mockup shows minimal header "Dashboard". -->
            
            <header class="header" style="background: transparent; box-shadow: none; padding: 0; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 15px; color: var(--text-muted);">
                    <span style="font-size: 1.2rem;">◫</span> Dashboard
                </div>
            </header>

            @if(session('success'))
                <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #badbcc;">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>

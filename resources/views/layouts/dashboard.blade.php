<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Laboratorium Manajemen Lanjut - Universitas Gunadarma">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - LabManajemen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="logo-icon">M</div>
                <span>Laboratorium<br>Manajemen Lanjut</span>
            </div>

            <div class="sidebar-profile">
                <div class="sidebar-avatar">
                    {{ strtoupper(Auth::user()->name)[0] ?? 'U' }}
                </div>
                <div class="sidebar-name">{{ strtoupper(Auth::user()->name) }}</div>
                <div class="sidebar-role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>

            <nav class="sidebar-menu">
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span>📊</span> Data Pendaftar
                    </a>
                @elseif(Auth::user()->role == 'dosen')
                    <a href="{{ route('dosen.dashboard') }}" class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                        <span>📁</span> Review Berkas
                    </a>
                @else
                    <a href="{{ route('pendaftar.dashboard') }}" class="{{ request()->routeIs('pendaftar.dashboard') ? 'active' : '' }}">
                        <span>🏠</span> Beranda
                    </a>
                    <a href="{{ route('pendaftar.berkas_page') }}" class="{{ request()->routeIs('pendaftar.berkas_page') ? 'active' : '' }}">
                        <span>📄</span> Pengumpulan Berkas
                    </a>
                @endif
                
                <div style="flex: 1;"></div>
                
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a href="#" onclick="document.getElementById('logout-form').submit(); return false;" style="color: var(--text-muted); display: flex; align-items: center; gap: 12px; padding: 14px 20px; margin-bottom: 8px; border-radius: 12px; transition: all 0.3s ease; font-weight: 500; text-decoration: none;">
                        <span>🚪</span> Keluar
                    </a>
                </form>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div style="display: flex; align-items: center; gap: 15px; color: var(--text-muted);">
                    <span style="font-size: 1.2rem;">◫</span>
                    <h2 style="font-size: 1.1rem; font-weight: 600; color: var(--text-main); margin: 0;">@yield('header-title', 'Dashboard')</h2>
                </div>
                <div class="user-info">
                    <span style="font-size: 0.9rem; color: var(--text-muted);">{{ Auth::user()->email }}</span>
                </div>
            </header>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>

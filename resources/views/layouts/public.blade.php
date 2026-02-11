<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laboratorium Manajemen Lanjut') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="logo">
                <div class="logo-icon">M</div>
                <span>Laboratorium Manajemen Lanjut</span>
            </div>
            
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <div class="nav-menu" id="navMenu">
                <div class="nav-links">
                    <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                    <a href="{{ url('#galeri') }}" class="nav-link">Galeri</a>
                    <a href="{{ url('#informasi') }}" class="nav-link">Informasi</a>
                    <a href="{{ url('/syarat') }}" class="nav-link">Persyaratan</a>
                    <a href="{{ url('#kontak') }}" class="nav-link">Kontak</a>
                </div>

                <div class="nav-auth">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-outline btn-sm">Daftar</a>
                    @else
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                        @elseif(Auth::user()->role == 'dosen')
                            <a href="{{ route('dosen.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                        @else
                            <a href="{{ route('pendaftar.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                        @endif
                    @endguest
                </div>
            </div>
        </nav>

        @yield('content')

        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="logo-icon">M</div>
                        <div>
                            <h3>Laboratorium<br>Manajemen Lanjut</h3>
                            <p>Universitas Gunadarma</p>
                        </div>
                    </div>
                    <p>Membangun generasi profesional yang siap menghadapi tantangan dunia kerja modern.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Links Cepat</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><a href="{{ url('/syarat') }}">Persyaratan</a></li>
                        <li><a href="{{ url('#galeri') }}">Galeri</a></li>
                        <li><a href="{{ url('#informasi') }}">Informasi</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <ul>
                        <li>📍 Kampus Universitas Gunadarma</li>
                        <li>📧 lab.mgmt@gunadarma.ac.id</li>
                        <li>📱 +62 21-xxxx-xxxx</li>
                        <li>🕐 Senin - Jumat, 08:00 - 16:00</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                                <path d="M12 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998z"/>
                                <path d="M18.406 4.594a1.44 1.44 0 1 1 2.819-.001 1.44 1.44 0 0 1-2.819.001z"/>
                            </svg>
                        </a>
                        <a href="#" aria-label="LinkedIn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" aria-label="YouTube">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Laboratorium Manajemen Lanjut. Universitas Gunadarma. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

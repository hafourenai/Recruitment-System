@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <div class="tag-pill">
            <span style="color: purple;">✦</span> Dibuka Pendaftaran Asisten dan Programmer
        </div>
        <h1>Ayo <i>Bergabung</i><br>Bersama Kami!</h1>
        <p>Laboratorium Manajemen Lanjut Universitas Gunadarma sedang membuka pendaftaran untuk Asisten dan Programmer. Gabung bersama kami di Laboratorium Manajemen Lanjut Universitas Gunadarma dan kembangkan skill serta pengalamanmu!</p>
        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang &rarr;</a>
    </div>
    <div class="hero-image-container">
        <img src="{{ asset('assets/images/1.jpeg') }}" alt="Kegiatan Lab" style="width: 100%; height: 100%; object-fit: cover;">
        <div class="hero-nav">
            <strong style="font-size: 1.2rem;">Training</strong>
            <span>Tip 1/1 &gt;</span>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="section" id="galeri">
    <h2 class="section-title">Galeri Kegiatan</h2>
    <p class="section-subtitle">Dokumentasi kegiatan dan suasana di Laboratorium Manajemen Lanjut</p>
    
    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="{{ asset('assets/images/1.jpeg') }}" alt="Training Session 1">
            <div class="gallery-overlay">
                <h4>Sesi Training</h4>
                <p>Pembekalan materi dasar</p>
            </div>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('assets/images/2.jpeg') }}" alt="Practical Session">
            <div class="gallery-overlay">
                <h4>Sesi Praktikum</h4>
                <p>Aplikasi langsung materi</p>
            </div>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('assets/images/3.jpeg') }}" alt="Collaboration">
            <div class="gallery-overlay">
                <h4>Kolaborasi Tim</h4>
                <p>Kerjasama antar asisten</p>
            </div>
        </div>
    </div>
</section>

<!-- Persyaratan Umum Section -->
<section class="section" id="informasi">
    <h2 class="section-title">Persyaratan Umum</h2>
    <p class="section-subtitle">Syarat dan ketentuan umum untuk bergabung dengan Laboratorium Manajemen Lanjut</p>
    
    <div class="req-grid">
        <!-- Card 1 -->
        <div class="req-card">
            <div class="req-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
            <h3>Mahasiswa Aktif</h3>
            <small>Universitas Gunadarma</small>
        </div>
        
        <!-- Card 2 -->
        <div class="req-card">
            <div class="req-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <h3>Minimal Semester 3</h3>
            <small>Persyaratan minimum untuk bergabung dengan program lab</small>
        </div>

        <!-- Card 3 -->
        <div class="req-card">
            <div class="req-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <h3>IPK Minimal 2.90</h3>
            <small>Standar akademik yang harus dipenuhi mahasiswa</small>
        </div>

        <!-- Card 4 -->
        <div class="req-card">
            <div class="req-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3>Tidak Terdaftar di Lab Lain</h3>
            <small>Khusus untuk mahasiswa yang belum bergabung dengan lab lain</small>
        </div>
    </div>
</section>

<!-- Persyaratan Khusus Section -->
<section class="section">
    <h2 class="section-title">Persyaratan Khusus</h2>
    <p class="section-subtitle">Lihat persyaratan dan kualifikasi untuk menjadi Asisten dan Programmer di Laboratorium Manajemen Lanjut Universitas Gunadarma.</p>

    <div class="spec-grid">
        <!-- Asisten Column -->
        <div class="spec-card">
            <div class="spec-header asisten">
                Asisten
            </div>
            <div class="spec-body">
                <h3>Asisten</h3>
                <small style="display:block; margin-bottom: 20px; font-weight: 600;">Persyaratan Akademik</small>
                
                <div class="spec-item">
                    <h4>S1-Manajemen</h4>
                    <p>Telah atau sedang mengikuti perkuliahan bank dan lembaga keuangan atau telah mengikuti kursus mini bank.</p>
                </div>

                <div class="spec-item">
                    <h4>S1-Akuntansi</h4>
                    <p>Nilai mata kuliah bank dan lembaga keuangan minimal B atau sedang mengikuti BLK atau sedang mengikuti perkuliahan akuntansi perbankan.</p>
                </div>

                <div class="spec-item">
                    <h4>D3-Manajemen / D3-Akuntansi</h4>
                    <p>Sudah mengambil komputerisasi penganggaran.</p>
                </div>
            </div>
        </div>

        <!-- Programmer Column -->
        <div class="spec-card">
            <div class="spec-header programmer">
                Programmer
            </div>
            <div class="spec-body">
                <h3>Programmer</h3>
                <small style="display:block; margin-bottom: 20px; font-weight: 600;">Persyaratan Akademik</small>

                <div class="spec-item">
                    <h4>S1-Informatika</h4>
                </div>
                <div class="spec-item">
                    <h4>S1-Sistem Informasi</h4>
                </div>
                <div class="spec-item">
                    <h4>S1-Sistem Komputer</h4>
                </div>

                <small style="display:block; margin-top:20px; margin-bottom: 10px; font-weight: 600;">Kemampuan</small>
                <div class="spec-item" style="border-left-color: #333;">
                    <h4>Pengetahuan Teknis</h4>
                    <p>Mempunyai pengetahuan mengenai Web dan Desktop Programming</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alur Pendaftaran Section -->
<section class="section">
    <h2 class="section-title">Alur Pendaftaran</h2>
    <p class="section-subtitle">Ikuti tahapan seleksi untuk bergabung sebagai Asisten atau Programmer di Laboratorium Manajemen Lanjut.</p>

    <div class="timeline">
        <!-- Item 1 -->
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-date">13 Okt - 27 Okt</div>
            <div class="timeline-content">
                <h4>Registrasi Akun & Pengisian Data</h4>
                <p>Peserta membuat akun pada website, melengkapi data pribadi, serta mengunggah dokumen yang dipersyaratkan.</p>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-date">5 Nov - 7 Nov</div>
            <div class="timeline-content">
                <h4>Validasi Data</h4>
                <p>Asisten melakukan pengecekan terhadap kebenaran dan kelengkapan data serta dokumen. Peserta yang valid akan dikonfirmasi lebih lanjut.</p>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-date">8 Nov 2025</div>
            <div class="timeline-content">
                <h4>Tes Tahap 1 - Ujian Tertulis (Daring)</h4>
                <p>Peserta mengikuti ujian yang mencakup pengetahuan dasar perbankan dan pengetahuan umum.</p>
            </div>
        </div>

        <!-- Item 4 -->
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-date">14 Nov - 21 Nov</div>
            <div class="timeline-content">
                <h4>Wawancara & Seleksi Akhir</h4>
                <p>Tahap wawancara kompetensi dan kepribadian untuk menentukan kelulusan akhir.</p>
            </div>
        </div>
    </div>
</section>
@endsection

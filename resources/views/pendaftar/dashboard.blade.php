@extends('layouts.dashboard')

@section('title', 'Dashboard Peserta')

@section('content')
<!-- Top Banner -->
<div class="dash-banner">
    <h1>Laboratorium<br>Manajemen Lanjut</h1>
</div>

<div class="grid-2-col">
    <!-- Left: Biodata -->
    <div class="white-card">
        <h3>Biodata Peserta</h3>
        <p class="sub">Informasi data diri & berkas yang dikumpulkan</p>

        <div class="bio-group">
            <div class="bio-label">NPM</div>
            <div class="bio-value">{{ $pendaftar->npm }}</div>
        </div>
        <div class="bio-group">
            <div class="bio-label">No. Telepon</div>
            <div class="bio-value">{{ $pendaftar->nomor_hp }}</div>
        </div>
        <div class="bio-group">
            <div class="bio-label">Email</div>
            <div class="bio-value">{{ $pendaftar->email }}</div>
        </div>
        
        <!-- Assuming we might want to show class but sticking to available data -->
        <div class="bio-group">
            <div class="bio-label">Jurusan</div>
            <div class="bio-value">{{ $pendaftar->program_studi }}</div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <div style="width: 80px; height: 80px; background-color: #eee; border-radius: 50%; margin: 0 auto 10px; background-image: url('https://ui-avatars.com/api/?name={{ urlencode($pendaftar->nama) }}&background=9b28b5&color=fff'); background-size: cover;"></div>
            <h4 style="margin-bottom: 5px;">{{ strtoupper($pendaftar->nama) }}</h4>
            <span class="badge badge-primary">{{ $pendaftar->posisi }}</span>
        </div>
    </div>

    <!-- Right: Status Berkas -->
    <div class="white-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <div>
                <h3>Status Berkas</h3>
                @php
                    $requiredFiles = ['cv', 'krs', 'transkrip', 'sertifikat']; // Sertifikat is technically optional in code but let's count it for UI padding
                    $uploadedCount = $pendaftar->berkas->count();
                    $totalFiles = 4; 
                    $percent = ($uploadedCount / $totalFiles) * 100;
                @endphp
                <p class="sub">{{ $uploadedCount }} dari {{ $totalFiles }} berkas status</p>
            </div>
            <div style="text-align: right;">
                <span class="badge badge-success" style="font-size: 0.9rem;">{{ round($percent) }}%</span>
                <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 2px;">Kelengkapan</div>
            </div>
        </div>

        <div>
             @php
                $uploadedTypes = $pendaftar->berkas->pluck('jenis_berkas')->toArray();
                $filesMap = [
                    'cv' => 'CV', 
                    'krs' => 'KRS', 
                    'transkrip' => 'Rangkuman Nilai', 
                    'sertifikat' => 'Sertifikat'
                ];
            @endphp

            @foreach($filesMap as $type => $label)
                @if(in_array($type, $uploadedTypes))
                    <div class="file-status-item success">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span>📄</span> <strong>{{ $label }}</strong>
                        </div>
                        <span>✔ Sudah</span>
                    </div>
                @else
                     <div class="file-status-item pending">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span>📄</span> <strong>{{ $label }}</strong>
                        </div>
                        <span>✕ Belum</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Selection Flow -->
<h3 style="margin-bottom: 20px;">Tahap Seleksi</h3>
<div class="flow-grid">
    @php
        $steps = [
            'seleksi_berkas' => 'Seleksi Berkas',
            'seleksi_ujian' => 'Seleksi Ujian',
            'seleksi_wawancara' => 'Seleksi Wawancara',
            'seleksi_staf' => 'Seleksi Staf',
            'lulus' => 'Congratulations!'
        ];
        
        $currentStatusIndex = array_search($pendaftar->status, array_keys($steps));
        if ($pendaftar->status == 'lulus') $currentStatusIndex = 4;
        if ($pendaftar->status == 'tidak_lulus') $currentStatusIndex = -1; // Handle fail case separately ideally
    @endphp

    @foreach($steps as $key => $label)
        @php
            $isPassed = false;
            $stepIndex = array_search($key, array_keys($steps));
            
            // Logic: If status is 'lulus', all steps passed.
            // If status is 'seleksi_ujian', then 'seleksi_berkas' is passed.
            // This logic assumes sequential progression in ENUM or logic.
            // Simplified: If current status index >= step index, mark as active/green
            
            $isActive = $currentStatusIndex >= $stepIndex;
            if ($pendaftar->status == 'lulus') $isActive = true;
        @endphp

        <div class="flow-card">
            <div class="flow-icon {{ $isActive ? 'active' : 'inactive' }}">
                {{ $isActive ? '✔' : '○' }}
            </div>
            <div class="flow-title">{{ $label }}</div>
            <div class="flow-desc">
                @if($key == 'lulus')
                    Anda telah lolos semua tahap!
                @else
                    Tetap semangat dan jangan menyerah.
                @endif
            </div>
        </div>
    @endforeach
</div>

@if($pendaftar->status == 'lulus')
    <div class="success-banner">
        <div class="success-icon-lg">✨</div>
        <h2 style="color: #198754; margin-bottom: 10px;">Selamat Anda Lulus Semua Tahap</h2>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Silakan gabung ke grup WhatsApp berikut untuk tahap selanjutnya.</p>
        <a href="#" class="btn btn-primary" style="background: #198754; box-shadow: none;">Silahkan Join WhatsApp</a>
    </div>
@endif

@endsection

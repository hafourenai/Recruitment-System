@extends('layouts.dashboard')

@section('title', 'Dashboard Peserta')
@section('header-title', 'Dashboard')

@section('content')
<div class="dash-banner">
    <h1>Laboratorium<br>Manajemen Lanjut</h1>
</div>

<div class="grid-2-col">
    <x-card title="Biodata Peserta" subtitle="Informasi data diri & berkas yang dikumpulkan">
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
        <div class="bio-group">
            <div class="bio-label">Jurusan</div>
            <div class="bio-value">{{ $pendaftar->program_studi }}</div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <div class="sidebar-avatar" style="width: 80px; height: 80px; margin: 0 auto 10px; font-size: 1.5rem;">
                {{ strtoupper($pendaftar->nama)[0] ?? 'U' }}
            </div>
            <h4 style="margin-bottom: 5px; color: var(--text-main);">{{ strtoupper($pendaftar->nama) }}</h4>
            <x-badge variant="primary">{{ ucfirst($pendaftar->posisi) }}</x-badge>
        </div>
    </x-card>

    <x-card title="Status Berkas" subtitle="{{ $pendaftar->berkas->count() }} dari 4 berkas terkirim">
        @php
            $requiredFiles = ['cv', 'krs', 'transkrip', 'sertifikat'];
            $uploadedCount = $pendaftar->berkas->count();
            $totalFiles = 4; 
            $percent = ($uploadedCount / $totalFiles) * 100;
        @endphp

        <div style="text-align: right; margin-bottom: 20px;">
            <x-badge variant="{{ $percent == 100 ? 'success' : 'warning' }}">{{ round($percent) }}%</x-badge>
            <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 2px;">Kelengkapan</div>
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
                        <span>✓ Terkirim</span>
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
    </x-card>
</div>

<h3 style="margin-bottom: 20px; color: var(--text-main);">Tahap Seleksi</h3>
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
    @endphp

    @foreach($steps as $key => $label)
        @php
            $isActive = $currentStatusIndex >= array_search($key, array_keys($steps));
            if ($pendaftar->status == 'lulus') $isActive = true;
        @endphp

        <div class="flow-card">
            <div class="flow-icon {{ $isActive ? 'active' : 'inactive' }}">
                {{ $isActive ? '✓' : '○' }}
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
        <x-button variant="success" size="lg">
            Silahkan Join WhatsApp
        </x-button>
    </div>
@endif

@endsection

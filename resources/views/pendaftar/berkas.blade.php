@extends('layouts.dashboard')

@section('title', 'Daftar Berkas')

@section('content')

@php
    $filesMap = [
        'cv' => [
            'label' => 'CV',
            'desc' => 'Curriculum Vitae',
            'required' => true,
            'icon' => '📄',
            'color' => '#E1BEE7', 
            'text' => '#9b28b5'
        ],
        'transkrip' => [
            'label' => 'Rangkuman Nilai',
            'desc' => 'Rangkuman Nilai Akademik',
            'required' => true,
            'icon' => '📊',
            'color' => '#E1BEE7',
            'text' => '#9b28b5'
        ],
        'krs' => [
            'label' => 'KRS',
            'desc' => 'Kartu Rencana Studi',
            'required' => true,
            'icon' => '📑',
            'color' => '#E1BEE7',
            'text' => '#9b28b5'
        ],
        'sertifikat' => [
            'label' => 'Sertifikat',
            'desc' => 'Sertifikat Kompetensi',
            'required' => false,
            'icon' => '🎖',
            'color' => '#E1BEE7',
            'text' => '#9b28b5'
        ]
    ];

    $uploadedCount = $pendaftar->berkas->whereIn('jenis_berkas', ['cv', 'transkrip', 'krs'])->count();
    $totalRequired = 3;
    $percent = min(100, ($uploadedCount / $totalRequired) * 100);
@endphp

<!-- Status Bar -->
<div class="white-card" style="margin-bottom: 20px; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h3 style="font-size: 1rem; margin: 0; font-weight: 700; color: #333;">Status Pengumpulan</h3>
        <span class="badge {{ $uploadedCount >= 3 ? 'badge-success' : 'badge-pending' }}" style="font-size: 0.7rem;">{{ $uploadedCount }}/3 Wajib</span>
    </div>
    <p class="sub" style="margin-bottom: 12px; color: var(--text-muted); font-size: 0.85rem;">{{ $uploadedCount }} dari {{ $totalRequired }} berkas wajib telah diunggah</p>
    
    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 5px; color: var(--text-muted);">
        <span>Progress Berkas Wajib:</span>
        <strong style="color: #333;">{{ round($percent) }}%</strong>
    </div>
    <div style="height: 8px; background: #f3e5f5; border-radius: 4px; overflow: hidden;">
        <div style="height: 100%; width: {{ $percent }}%; background: var(--primary-color); border-radius: 4px; transition: width 0.5s ease;"></div>
    </div>
</div>

<!-- Files List -->
@foreach($filesMap as $type => $info)
    @php
        $file = $pendaftar->berkas->where('jenis_berkas', $type)->first();
    @endphp

    <div class="white-card" style="margin-bottom: 12px; padding: 0; border: 1px solid #f0f0f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
        
        <!-- Card Header -->
        <div style="padding: 12px 20px; border-bottom: 1px solid #f8f9fa; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 12px; align-items: center;">
                <div style="width: 32px; height: 32px; background: {{ $info['color'] }}; color: {{ $info['text'] }}; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    {{ $info['icon'] }}
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 0.9rem; font-weight: 700;">{{ $info['label'] }}</h4>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">
                        {{ $info['desc'] }} 
                        @if($info['required']) <span style="color: #e53e3e;">*</span> @endif
                    </span>
                </div>
            </div>
            
            @if($file)
                <span style="color: #0f5132; font-size: 0.65rem; background: #d1e7dd; padding: 3px 8px; border-radius: 4px; font-weight: 600;">Berhasil</span>
            @endif
        </div>

        <!-- Card Body -->
        <div style="padding: 12px 20px; background: #fff;">
            
            @if($file)
                <!-- VIEW MODE -->
                <div id="view-mode-{{ $type }}" style="background: #f0fff4; border: 1px solid #c6f6d5; padding: 10px 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 0.65rem; color: #2f855a; font-weight: 700; margin-bottom: 2px;">FILE TERUNGGAH</div>
                        <div style="font-size: 0.8rem; color: #276749; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file->original_name }}</div>
                    </div>
                    
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('pendaftar.file', $file->id) }}" target="_blank" class="btn-action">
                            👁
                        </a>
                        <button onclick="toggleEdit('{{ $type }}')" class="btn-action">
                            ✏
                        </button>
                        <form action="{{ route('pendaftar.deleteFile', $type) }}" method="POST" onsubmit="return confirm('Hapus file ini?');" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-action" style="border-color: #fed7d7; color: #c53030; background: #fff5f5;">
                                🗑
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- UPLOAD/EDIT FORM -->
            <div id="upload-form-{{ $type }}" style="display: {{ $file ? 'none' : 'block' }};">
                <div style="background: #fafafa; border: 1px dashed #cbd5e0; padding: 12px; border-radius: 8px;">
                    <form action="{{ route('pendaftar.updateBerkas') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <input type="file" name="{{ $type }}" class="form-control" accept="application/pdf" required style="padding: 6px; background: white; border-color: #e2e8f0; font-size: 0.8rem;">
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 0.65rem; color: var(--text-muted);">PDF Max 2MB</span>
                                <div style="display: flex; gap: 8px;">
                                    @if($file)
                                        <button type="button" onclick="toggleEdit('{{ $type }}')" class="btn" style="padding: 5px 10px; font-size: 0.75rem; background: #eee;">Batal</button>
                                    @endif
                                    <button type="submit" class="btn btn-primary" style="padding: 5px 15px; font-size: 0.75rem;">
                                        {{ $file ? 'Simpan' : 'Unggah' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endforeach

<style>
    .btn-action {
        display: flex; 
        align-items: center; 
        justify-content: center;
        width: 32px;
        height: 32px;
        font-size: 0.9rem; 
        background: white; 
        border: 1px solid #e2e8f0; 
        color: #4a5568;
        border-radius: 6px; 
        cursor: pointer; 
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-color: #cbd5e0;
    }
</style>

<script>
    function toggleEdit(type) {
        const viewMode = document.getElementById('view-mode-' + type);
        const uploadForm = document.getElementById('upload-form-' + type);
        
        if (viewMode.style.display === 'none') {
            viewMode.style.display = 'flex';
            uploadForm.style.display = 'none';
        } else {
            viewMode.style.display = 'none';
            uploadForm.style.display = 'block';
        }
    }
</script>

@endsection

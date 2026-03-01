@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftaran')
@section('header-title', 'Data Pendaftaran')

@section('content')

<div style="margin-bottom: 25px; display: flex; gap: 10px; flex-wrap: wrap;">
    <x-button 
        href="{{ route('admin.dashboard', ['posisi' => 'asisten']) }}" 
        variant="{{ request('posisi') == 'asisten' ? 'primary' : 'secondary' }}"
        size="sm"
    >
        Laboratorium
    </x-button>
    <x-button 
        href="{{ route('admin.dashboard', ['posisi' => 'programmer']) }}" 
        variant="{{ request('posisi') == 'programmer' ? 'primary' : 'secondary' }}"
        size="sm"
    >
        Programmer
    </x-button>
    <x-button 
        href="{{ route('admin.dashboard') }}" 
        variant="secondary"
        size="sm"
    >
        Reset Filter
    </x-button>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nama & NPM</th>
                <th>Posisi</th>
                <th>IPK</th>
                <th>Berkas</th>
                <th>Status Seleksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarList as $pendaftar)
                <tr>
                    <td>
                        <strong style="display:block; margin-bottom: 2px; color: var(--text-main);">{{ $pendaftar->nama }}</strong>
                        <small style="color: var(--text-muted);">{{ $pendaftar->npm }}</small>
                    </td>
                    <td>
                        <x-badge variant="primary">{{ ucfirst($pendaftar->posisi) }}</x-badge>
                    </td>
                    <td><strong>{{ number_format($pendaftar->ipk, 2) }}</strong></td>
                    <td>
                        <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                            @foreach($pendaftar->berkas as $file)
                                <a href="{{ route('admin.file', $file->id) }}" target="_blank" class="badge" style="background: #e9ecef; color: #495057; text-decoration: none; cursor: pointer; border: 1px solid #dee2e6;">
                                    {{ strtoupper($file->jenis_berkas) }}
                                </a>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.updateStatus', $pendaftar->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" style="padding: 6px 10px; border-radius: 8px; border: 1px solid #ced4da; font-size: 0.85rem; background-color: white; color: #1f2937;">
                                @foreach(['seleksi_berkas', 'seleksi_ujian', 'seleksi_wawancara', 'seleksi_staf', 'lulus', 'tidak_lulus'] as $st)
                                    <option value="{{ $st }}" {{ $pendaftar->status == $st ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $st)) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <x-button variant="secondary" size="sm">
                            Detail
                        </x-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada pendaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

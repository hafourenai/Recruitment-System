@extends('layouts.dashboard')

@section('title', 'Data Pendaftar (Read Only)')

@section('content')
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NPM</th>
                <th>IPK</th>
                <th>Posisi</th>
                <th>Status</th>
                <th>Berkas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarList as $pendaftar)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $pendaftar->nama }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $pendaftar->program_studi }}</div>
                    </td>
                    <td>{{ $pendaftar->npm }}</td>
                    <td><span style="font-weight: 700;">{{ $pendaftar->ipk }}</span></td>
                    <td>
                        <span class="badge badge-primary">{{ ucfirst($pendaftar->posisi) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucwords(str_replace('_', ' ', $pendaftar->status)) }}</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            @foreach($pendaftar->berkas as $file)
                                <a href="{{ route('dosen.file', $file->id) }}" target="_blank" class="badge" style="background: #e9ecef; color: #495057; text-decoration: none; font-weight: 500; font-size: 0.7rem;">
                                    {{ strtoupper($file->jenis_berkas) }}
                                </a>
                            @endforeach
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">Belum ada pendaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

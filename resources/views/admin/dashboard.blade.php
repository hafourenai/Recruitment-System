@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftar')

@section('content')

<div style="margin-bottom: 25px; display: flex; gap: 10px;">
    <a href="{{ route('admin.dashboard', ['posisi' => 'asisten']) }}" class="btn {{ request('posisi') == 'asisten' ? 'btn-primary' : '' }}" style="{{ request('posisi') == 'asisten' ? '' : 'background: white; border: 1px solid var(--border-color); color: var(--text-muted);' }}">Laboratorium</a>
    <a href="{{ route('admin.dashboard', ['posisi' => 'programmer']) }}" class="btn {{ request('posisi') == 'programmer' ? 'btn-primary' : '' }}" style="{{ request('posisi') == 'programmer' ? '' : 'background: white; border: 1px solid var(--border-color); color: var(--text-muted);' }}">Programmer</a>
    <a href="{{ route('admin.dashboard') }}" class="btn" style="background: white; border: 1px solid var(--border-color); color: var(--text-muted);">Reset Filter</a>
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarList as $pendaftar)
                <tr>
                    <td>
                        <strong style="display:block; margin-bottom: 2px;">{{ $pendaftar->nama }}</strong>
                        <small style="color: var(--text-muted);">{{ $pendaftar->npm }}</small>
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ ucfirst($pendaftar->posisi) }}</span>
                    </td>
                    <td><strong>{{ $pendaftar->ipk }}</strong></td>
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
                        <button class="btn" style="padding: 6px 12px; font-size: 0.8rem; background: #e9ecef; color: #333;">Detail</button>
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

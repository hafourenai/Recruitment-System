@extends('layouts.public')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 40px 0;">
    <h1 class="section-title">Informasi Pendaftaran</h1>

    <div class="card" style="margin-bottom: 40px;">
        <h2>Persyaratan Umum</h2>
        <ul style="margin-left: 20px; margin-top: 15px;">
            <li>Mahasiswa Aktif Universitas Gunadarma.</li>
            <li>Tidak sedang menjadi asisten di laboratorium lain.</li>
            <li>Memiliki integritas, disiplin, dan kemauan belajar tinggi.</li>
            <li>Berpenampilan rapi dan sopan.</li>
        </ul>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
        <div class="card">
            <h3>Persyaratan Asisten</h3>
            <ul style="margin-left: 20px; margin-top: 15px;">
                <li>Minimal Semester 3.</li>
                <li>IPK Minimal 3.00.</li>
                <li>Nilai mata kuliah Manajemen Umum minimal B.</li>
                <li>Mampu berkomunikasi dengan baik.</li>
            </ul>
        </div>
        <div class="card">
            <h3>Persyaratan Programmer</h3>
            <ul style="margin-left: 20px; margin-top: 15px;">
                <li>Minimal Semester 3.</li>
                <li>IPK Minimal 2.75.</li>
                <li>Menguasai logika pemrograman dasar.</li>
                <li>Familiar dengan Web Development (PHP, JS, CSS).</li>
            </ul>
        </div>
    </div>

    <h2 class="section-title">Alur Seleksi</h2>
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; text-align: center; gap: 20px;">
            <div style="flex: 1; min-width: 120px;">
                <div style="font-size: 2rem; color: var(--primary-color);">1</div>
                <strong>Seleksi Berkas</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Verifikasi dokumen</p>
            </div>
            <div style="font-size: 1.5rem;">&rarr;</div>
            <div style="flex: 1; min-width: 120px;">
                <div style="font-size: 2rem; color: var(--primary-color);">2</div>
                <strong>Ujian Tulis</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Tes pengetahuan</p>
            </div>
            <div style="font-size: 1.5rem;">&rarr;</div>
            <div style="flex: 1; min-width: 120px;">
                <div style="font-size: 2rem; color: var(--primary-color);">3</div>
                <strong>Wawancara</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Kepribadian & Teknis</p>
            </div>
            <div style="font-size: 1.5rem;">&rarr;</div>
            <div style="flex: 1; min-width: 120px;">
                <div style="font-size: 2rem; color: var(--primary-color);">4</div>
                <strong>Seleksi Staf</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Finalisasi</p>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.2rem;">Daftar Sekarang</a>
    </div>
</div>
@endsection

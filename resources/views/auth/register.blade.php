@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 40px 20px;">
    <div class="auth-card auth-card-wide">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 2rem; margin-bottom: 10px; color: var(--text-main);">Formulir Pendaftaran</h2>
            <p style="color: var(--text-muted);">Isi data dengan benar untuk mengikuti seleksi</p>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Perhatikan hal berikut:</strong>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid-2-col">
                <div>
                    <div class="card" style="margin-bottom: 25px;">
                        <div class="card-header">
                            <h3 class="card-title">1. Data Diri & Akun</h3>
                            <p class="card-subtitle">Informasi akun dan data pribadi</p>
                        </div>
                        <div class="card-body">
                            <x-form-input
                                name="nama"
                                label="Nama Lengkap"
                                type="text"
                                placeholder="Sesuai KTM"
                                required="true"
                                :value="old('nama')"
                                help="Sesuai Kartu Tanda Mahasiswa"
                            />

                            <div class="grid-2-col" style="gap: 20px;">
                                <x-form-input
                                    name="npm"
                                    label="NPM"
                                    type="text"
                                    placeholder="Contoh: 10421001"
                                    required="true"
                                    :value="old('npm')"
                                    help="Nomor Pokok Mahasiswa"
                                />
                                <x-form-input
                                    name="nomor_hp"
                                    label="Nomor HP / WhatsApp"
                                    type="tel"
                                    placeholder="Contoh: 081234567890"
                                    required="true"
                                    :value="old('nomor_hp')"
                                    help="Untuk komunikasi penting"
                                />
                            </div>

                            <x-form-input
                                name="email"
                                label="Email"
                                type="email"
                                placeholder="email@gunadarma.ac.id"
                                required="true"
                                :value="old('email')"
                                help="Wajib menggunakan email @gunadarma.ac.id"
                            />

                            <div class="grid-2-col" style="gap: 20px;">
                                <div>
                                    <x-form-input
                                        name="password"
                                        label="Password"
                                        type="password"
                                        placeholder="Minimal 12 karakter"
                                        required="true"
                                        help="Huruf besar, kecil, angka, dan karakter khusus"
                                    />
                                </div>
                                <div>
                                    <x-form-input
                                        name="password_confirmation"
                                        label="Konfirmasi Password"
                                        type="password"
                                        placeholder="Ulangi password"
                                        required="true"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="card" style="margin-bottom: 25px;">
                        <div class="card-header">
                            <h3 class="card-title">2. Data Akademik</h3>
                            <p class="card-subtitle">Informasi akademik dan posisi yang dipilih</p>
                        </div>
                        <div class="card-body">
                            <x-form-input
                                name="program_studi"
                                label="Program Studi"
                                type="select"
                                required="true"
                                :options="[
                                    'Sistem Informasi' => 'Sistem Informasi',
                                    'Sistem Komputer' => 'Sistem Komputer',
                                    'Informatika' => 'Informatika',
                                    'Manajemen' => 'Manajemen',
                                    'Akuntansi' => 'Akuntansi',
                                ]"
                                :value="old('program_studi')"
                            />

                            <x-form-input
                                name="ipk"
                                label="IPK Terakhir"
                                type="number"
                                placeholder="Contoh: 3.50"
                                required="true"
                                :value="old('ipk')"
                                help="Skala 0.00 - 4.00"
                            />

                            <x-form-input
                                name="posisi"
                                label="Pilihan Posisi"
                                type="select"
                                required="true"
                                :options="[
                                    'asisten' => 'Asisten Laboratorium',
                                    'programmer' => 'Programmer',
                                ]"
                                :value="old('posisi')"
                            />
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">3. Upload Berkas</h3>
                            <p class="card-subtitle">Format: PDF, maksimal 2MB per file</p>
                        </div>
                        <div class="card-body">
                            <x-form-input
                                name="cv"
                                label="CV"
                                type="file"
                                accept="application/pdf"
                                required="true"
                                help="Curriculum Vitae"
                            />
                            <x-form-input
                                name="krs"
                                label="KRS Terakhir"
                                type="file"
                                accept="application/pdf"
                                required="true"
                                help="Kartu Rencana Studi"
                            />
                            <x-form-input
                                name="transkrip"
                                label="Transkrip Nilai"
                                type="file"
                                accept="application/pdf"
                                required="true"
                                help="Transkrip nilai akademik"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px; text-align: right;">
                <x-button type="submit" variant="primary" size="lg">
                    Kirim Pendaftaran
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection

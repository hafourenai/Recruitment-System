@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 40px 20px;">
    <div class="auth-card" style="max-width: 900px; padding: 50px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 2rem; margin-bottom: 10px;">Formulir Pendaftaran</h2>
            <p style="color: var(--text-muted);">Isi data dengan benar untuk mengikuti seleksi.</p>
        </div>
        
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
                <strong>Perhatikan hal berikut:</strong>
                <ul style="margin-left: 20px; margin-top: 5px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <!-- Left Column: Personal Data -->
                <div>
                    <h3 style="font-size: 1.2rem; color: var(--primary-color); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">1. Data Diri & Akun</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Sesuai KTM" autocomplete="name" pattern="[A-Za-z\s\.\-,]+" title="Nama hanya boleh mengandung huruf, spasi, titik, koma, dan tanda hubung">
                        <small class="form-help">Sesuai Kartu Tanda Mahasiswa</small>
                    </div>

                     <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">NPM</label>
                            <input type="text" name="npm" class="form-control" value="{{ old('npm') }}" required pattern="[0-9]{8,15}" title="NPM minimal 8 digit angka" autocomplete="off">
                            <small class="form-help">Nomor Pokok Mahasiswa (angka saja)</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor HP / WHATSAPP</label>
                            <input type="tel" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}" required pattern="[0-9\+\-]{10,15}" title="Nomor HP minimal 10 digit" autocomplete="tel">
                            <small class="form-help">Untuk komunikasi penting</small>
                        </div>
                     </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@example.com" autocomplete="email">
                        <small class="form-help">Email aktif dan masih digunakan</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Minimal 12 karakter" autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&]).{12,}" title="Password harus mengandung minimal 12 karakter dengan huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&)">
                            <div class="password-strength"></div>
                            <small class="form-help">Minimal 12 karakter dengan huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&)</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password" autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <!-- Right Column: Academic & Files -->
                <div>
                     <h3 style="font-size: 1.2rem; color: var(--primary-color); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">2. Data Akademik</h3>

                    <div class="form-group">
                        <label class="form-label">Program Studi</label>
                        <select name="program_studi" class="form-control" required>
                            <option value="" disabled selected>Pilih Jurusan</option>
                            <option value="Sistem Informasi" {{ old('program_studi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Sistem Komputer" {{ old('program_studi') == 'Sistem Komputer' ? 'selected' : '' }}>Sistem Komputer</option>
                            <option value="Informatika" {{ old('program_studi') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                            <option value="Manajemen" {{ old('program_studi') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">IPK Terakhir</label>
                        <input type="number" step="0.01" min="0" max="4" name="ipk" class="form-control" value="{{ old('ipk') }}" required placeholder="3.00" pattern="[0-3]\.[0-9]{2}|4\.00" title="IPK harus antara 0.00 - 4.00">
                        <small class="form-help">Skala 0.00 - 4.00</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pilihan Posisi</label>
                        <select name="posisi" class="form-control">
                            <option value="asisten" {{ old('posisi') == 'asisten' ? 'selected' : '' }}>Asisten Laboratorium</option>
                            <option value="programmer" {{ old('posisi') == 'programmer' ? 'selected' : '' }}>Programmer</option>
                        </select>
                    </div>

                     <h3 style="font-size: 1.2rem; color: var(--primary-color); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0; margin-top: 30px;">3. Upload Berkas (PDF)</h3>

                     <div class="form-group">
                        <label class="form-label">CV, KRS, Transkrip</label>
                        <div style="background: #fafafa; border: 2px dashed #e0e0e0; padding: 20px; border-radius: 10px;">
                            <div style="margin-bottom: 15px;">
                                <label style="font-size: 0.85rem; display:block; margin-bottom:5px;">CV *</label>
                                <input type="file" name="cv" class="form-control" accept="application/pdf" required style="padding: 8px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="font-size: 0.85rem; display:block; margin-bottom:5px;">KRS Terakhir *</label>
                                <input type="file" name="krs" class="form-control" accept="application/pdf" required style="padding: 8px;">
                            </div>
                            <div>
                                <label style="font-size: 0.85rem; display:block; margin-bottom:5px;">Transkrip Nilai *</label>
                                <input type="file" name="transkrip" class="form-control" accept="application/pdf" required style="padding: 8px;">
                            </div>
                        </div>
                     </div>
                </div>
            </div>

            <div style="margin-top: 40px; text-align: right;">
                <button type="submit" class="btn btn-primary" style="padding: 15px 50px; font-size: 1.1rem;">Kirim Pendaftaran</button>
            </div>
        </form>
    </div>
</div>
@endsection

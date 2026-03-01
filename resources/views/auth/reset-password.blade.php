@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 60px 20px;">
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 30px;">
            <div class="logo-icon" style="width: 60px; height: 60px; margin: 0 auto 15px; font-size: 1.5rem; background: var(--primary-color);">🔐</div>
            <h2 style="font-size: 1.8rem; margin-bottom: 8px; color: var(--text-main);">Reset Password</h2>
            <p style="color: var(--text-muted);">Buat password baru untuk akun Anda</p>
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

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <x-form-input
                name="email"
                label="Email"
                type="email"
                placeholder="email@gunadarma.ac.id"
                required="true"
                :value="old('email')"
            />
            
            <x-form-input
                name="password"
                label="Password Baru"
                type="password"
                placeholder="Minimal 12 karakter"
                required="true"
                help="Minimal 12 karakter dengan huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&)"
            />
            
            <x-form-input
                name="password_confirmation"
                label="Konfirmasi Password"
                type="password"
                placeholder="Ulangi password baru"
                required="true"
            />
            
            <x-button type="submit" variant="primary" size="lg" style="width: 100%;">
                Reset Password
            </x-button>
        </form>
        
        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">
                ← Kembali ke Login
            </a>
        </div>
    </div>
</div>
@endsection

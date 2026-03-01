@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 60px 20px;">
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 30px;">
            <div class="logo-icon" style="width: 60px; height: 60px; margin: 0 auto 15px; font-size: 1.5rem;">M</div>
            <h2 style="font-size: 1.8rem; margin-bottom: 8px; color: var(--text-main);">Selamat Datang!</h2>
            <p style="color: var(--text-muted);">Silakan masuk untuk melanjutkan</p>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <x-form-input
                name="email"
                label="Email"
                type="email"
                placeholder="email@gunadarma.ac.id"
                required="true"
                :value="old('email')"
                help="Gunakan email yang terdaftar saat pendaftaran"
            />
            <x-form-input
                name="password"
                label="Password"
                type="password"
                placeholder="Masukkan password"
                required="true"
                help="Minimal 8 karakter"
            />
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; color: var(--text-muted); cursor: pointer;">
                    <input type="checkbox" name="remember" style="width: 16px; height: 16px; accent-color: var(--primary-color);">
                    Ingat saya
                </label>
                <a href="{{ route('password.request') }}" style="color: var(--primary-color); font-size: 0.9rem; text-decoration: none; font-weight: 500;">
                    Lupa Password?
                </a>
            </div>
            
            <x-button type="submit" variant="primary" size="lg" style="width: 100%;">
                Masuk ke Akun
            </x-button>
        </form>
        
        <p style="text-align: center; margin-top: 25px; color: var(--text-muted); font-size: 0.9rem;">
            Belum punya akun? 
            <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Daftar Sekarang</a>
        </p>
    </div>
</div>
@endsection

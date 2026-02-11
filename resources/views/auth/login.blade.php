@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 60px 20px;">
    <div class="auth-card" style="max-width: 450px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 50px; height: 50px; background: var(--primary-color); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.2rem;">M</div>
            <h2 style="font-size: 1.8rem; margin-bottom: 5px;">Selamat Datang!</h2>
            <p style="color: var(--text-muted);">Silakan masuk untuk melanjutkan.</p>
        </div>
        
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #842029; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="user@gunadarma.ac.id" autocomplete="email">
                <small class="form-help">Gunakan email yang terdaftar saat pendaftaran</small>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••" autocomplete="current-password">
                <small class="form-help">Minimal 8 karakter</small>
            </div>
            
            <div style="text-align: right; margin-bottom: 20px;">
                <a href="{{ route('password.request') }}" style="color: var(--primary-color); font-size: 0.9rem; text-decoration: none;">
                    Lupa Password?
                </a>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">Masuk ke Akun</button>
        </form>
        <p style="text-align: center; margin-top: 25px; color: var(--text-muted); font-size: 0.9rem;">
            Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600;">Daftar Sekarang</a>
        </p>
    </div>
</div>
@endsection

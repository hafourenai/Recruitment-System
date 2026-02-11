@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 60px 20px;">
    <div class="auth-card" style="max-width: 450px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 50px; height: 50px; background: var(--primary-color); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.2rem;">🔐</div>
            <h2 style="font-size: 1.8rem; margin-bottom: 5px;">Reset Password</h2>
            <p style="color: var(--text-muted);">Buat password baru untuk akun Anda</p>
        </div>
        
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #842029; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                <strong>Perhatikan hal berikut:</strong>
                <ul style="margin-left: 20px; margin-top: 5px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="email@example.com">
            </div>
            
            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••••••">
                <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 5px; display: block;">
                    Minimal 12 karakter dengan huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&)
                </small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••••••">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">Reset Password</button>
        </form>
        
        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">
                ← Kembali ke Login
            </a>
        </div>
    </div>
</div>
@endsection
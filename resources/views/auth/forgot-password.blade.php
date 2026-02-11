@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 60px 20px;">
    <div class="auth-card" style="max-width: 450px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 50px; height: 50px; background: var(--primary-color); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.2rem;">🔒</div>
            <h2 style="font-size: 1.8rem; margin-bottom: 5px;">Lupa Password?</h2>
            <p style="color: var(--text-muted);">Masukkan email untuk reset password</p>
        </div>
        
        @if (session('success'))
            <div style="background-color: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #842029; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="email@example.com">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">Kirim Link Reset</button>
        </form>
        
        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">
                ← Kembali ke Login
            </a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.public')

@section('content')
<div class="container" style="display: flex; justify-content: center; padding: 60px 20px;">
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 30px;">
            <div class="logo-icon" style="width: 60px; height: 60px; margin: 0 auto 15px; font-size: 1.5rem; background: var(--primary-color);">🔒</div>
            <h2 style="font-size: 1.8rem; margin-bottom: 8px; color: var(--text-main);">Lupa Password?</h2>
            <p style="color: var(--text-muted);">Masukkan email untuk reset password</p>
        </div>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <x-form-input
                name="email"
                label="Email"
                type="email"
                placeholder="email@gunadarma.ac.id"
                required="true"
                :value="old('email')"
                help="Masukkan email terdaftar Anda"
            />
            
            <x-button type="submit" variant="primary" size="lg" style="width: 100%;">
                Kirim Link Reset
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

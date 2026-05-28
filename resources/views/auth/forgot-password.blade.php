@extends('layouts.guest')
@section('title', 'Lupa Password')

@section('content')
    <h2 style="font-size: 24px; font-weight: 700; color: var(--ink-900); margin-bottom: 8px;">
        Lupa Password?
    </h2>
    <p style="font-size: 14px; color: var(--ink-500); margin-bottom: 32px; line-height: 1.6;">
        Tidak masalah. Masukkan alamat email yang terdaftar dan kami akan
        mengirimkan link untuk membuat password baru.
    </p>

    {{-- Status sukses (setelah link dikirim) --}}
    @if (session('status'))
        <div class="alert-success mb-4 flex items-start gap-2">
            <i data-lucide="check-circle" class="w-4 h-4" style="margin-top: 2px; flex-shrink: 0;"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" novalidate>
        @csrf

        {{-- Email --}}
        <div>
            <label class="form-label" for="email">Alamat Email</label>
            <input id="email" type="email" name="email"
                   class="form-input @error('email') border-red-400 @enderror"
                   value="{{ old('email') }}"
                   placeholder=""
                   required autofocus autocomplete="username">
            @error('email')
                <p class="field-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full justify-center" style="width: 100%; justify-content: center; margin-top: 8px;">
            Kirim Link Reset Password
        </button>

        {{-- Kembali ke Login --}}
        <p style="text-align: center; font-size: 13px; color: var(--ink-500); margin-top: 16px;">
            Ingat password?
            <a href="{{ route('login') }}" style="color: var(--telkom-red); font-weight: 600; text-decoration: none;">
                Masuk di sini
            </a>
        </p>
    </form>
@endsection

@extends('layouts.guest')
@section('title', 'Daftar')

@section('content')
    <h2 style="font-size: 24px; font-weight: 700; color: var(--ink-900); margin-bottom: 8px;">
        Buat Akun Baru
    </h2>
    <p style="font-size: 14px; color: var(--ink-500); margin-bottom: 32px;">
        Isi data di bawah untuk mendaftar
    </p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Nama Lengkap --}}
        <div>
            <label class="form-label" for="name">Nama Lengkap <span style="color: var(--telkom-red);">*</span></label>
            <input id="name" type="text" name="name"
                   class="form-input @error('name') border-red-400 @enderror"
                   value="{{ old('name') }}"
                   placeholder="Masukkan nama lengkap Anda"
                   required autofocus autocomplete="name">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Organisasi / UKM --}}
        <div>
            <label class="form-label" for="organization">
                Organisasi / UKM
                <span style="font-weight: 400; color: var(--ink-500);">(opsional)</span>
            </label>
            <input id="organization" type="text" name="organization"
                   class="form-input @error('organization') border-red-400 @enderror"
                   value="{{ old('organization') }}"
                   placeholder="Contoh: SRE Telkom University">
            @error('organization')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jabatan --}}
        <div>
            <label class="form-label" for="position">
                Jabatan
                <span style="font-weight: 400; color: var(--ink-500);">(opsional)</span>
            </label>
            <input id="position" type="text" name="position"
                   class="form-input @error('position') border-red-400 @enderror"
                   value="{{ old('position') }}"
                   placeholder="Contoh: Ketua Pelaksana">
            @error('position')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="form-label" for="email">Alamat Email <span style="color: var(--telkom-red);">*</span></label>
            <input id="email" type="email" name="email"
                   class="form-input @error('email') border-red-400 @enderror"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   required autocomplete="username">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password dengan toggle --}}
        <div x-data="{ showPass: false }">
            <label class="form-label" for="password">Kata Sandi <span style="color: var(--telkom-red);">*</span></label>
            <div class="relative">
                <input id="password"
                       :type="showPass ? 'text' : 'password'"
                       name="password"
                       class="form-input @error('password') border-red-400 @enderror"
                       placeholder="Minimal 8 karakter"
                       required autocomplete="new-password"
                       style="padding-right: 44px;">
                <button type="button"
                        @click="showPass = !showPass"
                        class="absolute right-3 top-1/2 -translate-y-1/2"
                        style="background:none; border:none; cursor:pointer; color: var(--ink-500); padding: 4px;">
                    <i :data-lucide="showPass ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                </button>
            </div>
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div x-data="{ showPass2: false }">
            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi <span style="color: var(--telkom-red);">*</span></label>
            <div class="relative">
                <input id="password_confirmation"
                       :type="showPass2 ? 'text' : 'password'"
                       name="password_confirmation"
                       class="form-input"
                       placeholder="Ulangi kata sandi"
                       required autocomplete="new-password"
                       style="padding-right: 44px;">
                <button type="button"
                        @click="showPass2 = !showPass2"
                        class="absolute right-3 top-1/2 -translate-y-1/2"
                        style="background:none; border:none; cursor:pointer; color: var(--ink-500); padding: 4px;">
                    <i :data-lucide="showPass2 ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                </button>
            </div>
            @error('password_confirmation')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 8px;">
            Daftar Sekarang
        </button>

        {{-- Link login --}}
        <p style="text-align: center; font-size: 13px; color: var(--ink-500); margin-top: 16px;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color: var(--telkom-red); font-weight: 600; text-decoration: none;">
                Masuk di sini
            </a>
        </p>
    </form>
@endsection

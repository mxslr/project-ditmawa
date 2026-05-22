@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
    <div class="mb-6">
        <h1 style="font-size: 24px; font-weight: 700; color: var(--ink-900); margin-bottom: 4px;">
            Profil Saya
        </h1>
        <p style="font-size: 14px; color: var(--ink-500);">
            Kelola informasi akun dan keamanan Anda
        </p>
    </div>

    {{-- Tab Navigation --}}
    <div x-data="{ activeTab: '{{ session('activeTab', 'info') }}' }" class="max-w-2xl">

        {{-- Tab Buttons --}}
        <div class="flex gap-1 mb-6 p-1 rounded-xl" style="background: var(--surface-muted); display: inline-flex;">
            <button @click="activeTab = 'info'"
                    :class="activeTab === 'info' ? 'bg-white shadow-sm' : ''"
                    class="px-5 py-2 text-sm font-semibold rounded-lg transition-all"
                    style="border: none; cursor: pointer;"
                    :style="activeTab === 'info' ? 'color: var(--ink-900);' : 'color: var(--ink-500); background: transparent;'">
                <span class="flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    Informasi Akun
                </span>
            </button>
            <button @click="activeTab = 'password'"
                    :class="activeTab === 'password' ? 'bg-white shadow-sm' : ''"
                    class="px-5 py-2 text-sm font-semibold rounded-lg transition-all"
                    style="border: none; cursor: pointer;"
                    :style="activeTab === 'password' ? 'color: var(--ink-900);' : 'color: var(--ink-500); background: transparent;'">
                <span class="flex items-center gap-2">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                    Ubah Kata Sandi
                </span>
            </button>
        </div>

        {{-- Tab: Informasi Akun --}}
        <div x-show="activeTab === 'info'">
            <div class="card">
                @if (session('success') && !request()->is('*password*'))
                    <div class="alert-success mb-5 flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="form-label" for="name">
                            Nama Lengkap <span style="color: var(--telkom-red);">*</span>
                        </label>
                        <input id="name" type="text" name="name"
                               class="form-input @error('name') border-red-400 @enderror"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="email">
                            Alamat Email <span style="color: var(--telkom-red);">*</span>
                        </label>
                        <input id="email" type="email" name="email"
                               class="form-input @error('email') border-red-400 @enderror"
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="organization">
                            UKM
                            <span style="font-weight: 400; color: var(--ink-500);"></span>
                        </label>
                        <input id="organization" type="text" name="organization"
                               class="form-input @error('organization') border-red-400 @enderror"
                               value="{{ old('organization', $user->organization) }}"
                               placeholder=""
                               required>
                        @error('organization')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="position">
                            Jabatan
                            <span style="font-weight: 400; color: var(--ink-500);"></span>
                        </label>
                        <input id="position" type="text" name="position"
                               class="form-input @error('position') border-red-400 @enderror"
                               value="{{ old('position', $user->position) }}"
                               placeholder="Contoh: Ketua Pelaksana"
                               required>
                        @error('position')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="phone">
                            No. Telepon
                            <span style="font-weight: 400; color: var(--ink-500);"></span>
                        </label>
                        <input id="phone" type="text" name="phone"
                               class="form-input @error('phone') border-red-400 @enderror"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder=""
                               required>
                        @error('phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-primary">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tab: Ubah Kata Sandi --}}
        <div x-show="activeTab === 'password'">
            <div class="card">
                @if (session('success'))
                    <div class="alert-success mb-5 flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div x-data="{ show: false }">
                        <label class="form-label" for="current_password">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input id="current_password"
                                   :type="show ? 'text' : 'password'"
                                   name="current_password"
                                   class="form-input @error('current_password') border-red-400 @enderror"
                                   placeholder=""
                                   style="padding-right: 44px;">
                            <button type="button" @click="show = !show"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--ink-500); padding:4px;">
                                <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="form-label" for="password">Kata Sandi Baru</label>
                        <div class="relative">
                            <input id="password"
                                   :type="show ? 'text' : 'password'"
                                   name="password"
                                   class="form-input @error('password') border-red-400 @enderror"
                                   placeholder="Minimal 8 karakter"
                                   style="padding-right: 44px;">
                            <button type="button" @click="show = !show"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--ink-500); padding:4px;">
                                <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <input id="password_confirmation"
                                   :type="show ? 'text' : 'password'"
                                   name="password_confirmation"
                                   class="form-input"
                                   placeholder=""
                                   style="padding-right: 44px;">
                            <button type="button" @click="show = !show"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--ink-500); padding:4px;">
                                <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-primary">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            Ubah Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

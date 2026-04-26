@extends('layouts.admin-layout')

@section('admin-title', 'Perbarui Pengguna')

@section('admin-content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight mb-2">Perbarui Pengguna</h2>
            <p class="text-slate-500 font-medium">Ubah informasi akun untuk <span class="text-blue-600 font-bold">{{ $user->name }}</span>.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 transition-all shadow-sm">
            <i class="fas fa-times text-lg"></i>
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 bg-red-50 border border-red-100 rounded-[2rem] flex items-start space-x-4">
            <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                <i class="fas fa-exclamation-circle text-lg"></i>
            </div>
            <div>
                <h4 class="text-red-800 font-black text-sm uppercase tracking-widest mb-2">Terjadi Kesalahan</h4>
                <ul class="list-disc list-inside text-red-600 text-sm font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Main Form Card -->
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-slate-200/60 border border-slate-50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50/50 rounded-full blur-3xl -mr-32 -mt-32"></div>
            
            <div class="relative grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" 
                           class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-700 placeholder:text-slate-300" required>
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <label for="username" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" placeholder="Contoh: bidansari" 
                           class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-700 placeholder:text-slate-300" required>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="email@posyandu.com" 
                           class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-700 placeholder:text-slate-300" required>
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label for="role" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Peran / Role</label>
                    <div class="relative">
                        <select name="role" id="role" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-700 appearance-none cursor-pointer" required>
                            @foreach(['admin', 'superadmin', 'coordinator', 'staff', 'medical', 'patient', 'partner'] as $role)
                                <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>{{ ucfirst($role == 'medical' ? 'Tenaga Medis' : $role) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Separator -->
                <div class="md:col-span-2 py-4">
                    <div class="h-px bg-slate-100 w-full"></div>
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mt-4 text-center">Biarkan password kosong jika tidak ingin diubah</p>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Password Baru</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" 
                           class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-700 placeholder:text-slate-300">
                </div>

                <!-- Password Confirmation -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" 
                           class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-700 placeholder:text-slate-300">
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2 flex items-center justify-between p-6 bg-slate-50 rounded-3xl mt-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                            <i class="fas fa-user-shield text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Status Akun</h4>
                            <p class="text-xs text-slate-500">Ubah status akses pengguna ke sistem.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $user->is_active ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-4">
            <a href="{{ route('admin.users.index') }}" class="px-10 py-4 bg-white border border-slate-200 text-slate-500 text-xs font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-slate-50 transition-all">Batalkan</a>
            <button type="submit" class="px-10 py-4 bg-indigo-600 text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95 flex items-center">
                <i class="fas fa-save mr-3"></i> SIMPAN PERUBAHAN
            </button>
        </div>
    </form>
</div>
@endsection
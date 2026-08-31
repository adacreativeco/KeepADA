@extends('layouts.panel')

@section('title', 'Ekip & Teknisyen Yönetimi')

@section('content')
<div class="space-y-6" x-data="{ inviteModalOpen: false }">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Ekip &amp; Teknisyen Kadrosu</h1>
            <p class="text-xs text-slate-400 mt-1">Bakım amirleri, saha teknisyenleri ve yetkilendirme yönetimi.</p>
        </div>
        <button type="button" @click="inviteModalOpen = true" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Yeni Üye / Teknisyen Ekle</span>
        </button>
    </div>

    <!-- Team Members Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($members as $user)
            @php
                $isSelf = $user->id === auth()->id();
                $isManager = $user->hasRole('manager') || $user->hasRole('super_admin');
            @endphp
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col justify-between hover:border-slate-700 transition relative">
                
                <div>
                    <!-- Header Strip -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-600 to-amber-400 flex items-center justify-center font-black text-slate-950 text-base shadow-md shadow-amber-500/20">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        
                        <div>
                            @if($isManager)
                                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 font-mono text-[10px] font-bold border border-amber-500/20">
                                    Yönetici (Manager)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 font-mono text-[10px] font-bold border border-blue-500/20">
                                    Teknisyen (Technician)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- User Info -->
                    <h3 class="text-lg font-bold text-white mb-1 flex items-center gap-2">
                        <span>{{ $user->name }}</span>
                        @if($isSelf)
                            <span class="text-[10px] font-mono text-slate-400 bg-slate-800 px-2 py-0.5 rounded">(Siz)</span>
                        @endif
                    </h3>
                    <div class="text-xs text-slate-400 font-mono mb-4">{{ $user->email }}</div>

                    <!-- Task assignment counter -->
                    <div class="p-3.5 rounded-2xl bg-slate-950/60 border border-slate-800/80 flex items-center justify-between text-xs font-mono">
                        <span class="text-slate-400 font-sans">Aktif Açık Görevler:</span>
                        <a href="{{ route('panel.tasks.index', ['company' => $currentCompany->slug, 'assigned_to' => $user->id]) }}" class="font-bold text-amber-400 hover:underline">
                            {{ $user->maintenanceTasks->count() }} Görev →
                        </a>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="pt-4 mt-4 border-t border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-[11px] text-slate-500 font-mono">Eklenme: {{ $user->created_at->format('d.m.Y') }}</span>
                    
                    @if(!$isSelf)
                        <form action="{{ route('panel.team.destroy', ['company' => $currentCompany->slug, 'user' => $user->id]) }}" method="POST" onsubmit="return confirm('{{ $user->name }} adlı personeli bu ekipten çıkarmak istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-400 hover:text-rose-300 font-semibold text-xs transition">
                                Ekipten Çıkar
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-3 py-16 text-center bg-slate-900 border border-slate-800 rounded-3xl text-slate-400">
                <i data-lucide="users" class="w-12 h-12 text-slate-600 mx-auto mb-3"></i>
                <div class="text-base font-bold text-white">Ekip Üyesi Bulunamadı</div>
            </div>
        @endforelse
    </div>

    <!-- Modal: Invite New Team Member -->
    <div x-show="inviteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="inviteModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl space-y-4">
                
                <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                    <div>
                        <h3 class="text-base font-bold text-white">Yeni Ekip Üyesi / Teknisyen Ekle</h3>
                        <p class="text-xs text-slate-400">Tesisinize yeni bir bakım personeli kaydedin.</p>
                    </div>
                    <button type="button" @click="inviteModalOpen = false" class="text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('panel.team.store', ['company' => $currentCompany->slug]) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Ad Soyad *</label>
                        <input type="text" name="name" required placeholder="Örn: Mehmet Usta" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">E-posta Adresi *</label>
                        <input type="email" name="email" required placeholder="mehmet@fabrika.com" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Giriş Şifresi *</label>
                        <input type="password" name="password" required placeholder="En az 6 karakter" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Yetki / Rol *</label>
                        <select name="role" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="technician" selected>Teknisyen (İş emirlerini uygular, sayaç ve parça girer)</option>
                            <option value="manager">Yönetici / Bakım Müdürü (Tüm modülleri yönetir)</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-800">
                        <button type="button" @click="inviteModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-800 text-slate-300 text-xs font-semibold">
                            İptal
                        </button>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-5 py-2 rounded-xl text-xs">
                            Kullanıcıyı Kaydet
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection

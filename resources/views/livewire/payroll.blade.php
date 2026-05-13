<div class="container mx-auto max-w-4xl py-8 px-4 space-y-6">
    
    <div class="bg-white dark:bg-gray-900 border-t-4 border-t-amber-500 border-x border-b border-gray-200 dark:border-white/10 rounded-xl shadow-md">
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-amber-100 dark:bg-amber-500/20 rounded-lg">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-950 dark:text-white">Filter Perhitungan Gaji</h2>
            </div>
            
            <form method="POST" wire:submit.prevent="calculate" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Pegawai</label>
                    <select wire:model="user_id" class="w-full rounded-lg border-gray-300 dark:border-white/20 dark:bg-gray-800 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 transition-colors">
                        <option value="">-- Pilih User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal Mulai</label>
                    <input type="date" wire:model="start_date" class="w-full rounded-lg border-gray-300 dark:border-white/20 dark:bg-gray-800 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal Selesai</label>
                    <input type="date" wire:model="end_date" class="w-full rounded-lg border-gray-300 dark:border-white/20 dark:bg-gray-800 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>

                <div class="md:col-span-3 flex justify-end pt-2">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-amber-500/30 transition-all active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Hitung Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-white/10 rounded-xl shadow-xl overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-500/10 dark:to-orange-500/10 border-b border-amber-100 dark:border-amber-500/20">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-black text-amber-700 dark:text-amber-500">Laporan Slip Gaji</h2>
                    <p class="text-sm text-amber-600/80 dark:text-amber-400 font-medium">Periode: {{ $start_date }} - {{ $end_date }}</p>
                </div>
                <span class="bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 px-4 py-1 rounded-full text-xs font-bold uppercase border border-amber-200 dark:border-amber-500/30">
                    Draft Terhitung
                </span>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Informasi Pegawai</h3>
                        <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-5 space-y-4">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500">Nama Lengkap</span>
                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $pegawai->name ?? "-"}}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500">Jabatan</span>
                                <span class="text-md font-semibold text-amber-600 dark:text-amber-400">Karyawan</span>
                            </div>
                            <div class="pt-2 flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                {{ $this->formattedDuration ?? "0 jam"}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Rincian Finansial</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center group">
                            <span class="text-gray-600 dark:text-gray-400">Gaji Pokok Tahunan/Bulan</span>
                            <span class="font-bold text-gray-900 dark:text-white">Rp 8.500.000</span>
                        </div>
                        <div class="flex justify-between items-center text-emerald-600 dark:text-emerald-400">
                            <span>Tunjangan Transportasi</span>
                            <span class="font-bold">+ Rp 750.000</span>
                        </div>
                        <div class="flex justify-between items-center text-rose-600 dark:text-rose-400">
                            <span>Potongan BPJS & Pajak</span>
                            <span class="font-bold">- Rp 150.000</span>
                        </div>
                        
                        <div class="mt-8 p-6 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-xl shadow-orange-500/20 text-white relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
                            
                            <div class="relative z-10 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium opacity-90">Take Home Pay</p>
                                    <p class="text-3xl font-black tracking-tight">Rp 9.100.000</p>
                                </div>
                                <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap gap-4 pt-6 border-t border-gray-100 dark:border-white/5">
                <button class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-2.5 bg-white dark:bg-white/5 border-2 border-amber-500 text-amber-600 dark:text-amber-500 font-bold text-sm rounded-xl hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-all">
                    Cetak Slip Gaji
                </button>
                <button class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold text-sm rounded-xl hover:opacity-90 transition-all">
                    Simpan Permanen
                </button>
            </div>
        </div>
    </div>
</div>
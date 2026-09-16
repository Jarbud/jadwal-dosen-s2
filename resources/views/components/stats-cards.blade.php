<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    {{-- Total Jadwal --}}
    <div class="bg-white rounded-xl border border-border p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-11 h-11 bg-navy-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-text font-display" x-text="stats.total"></p>
            <p class="text-xs text-text-muted font-medium">Total Jadwal</p>
        </div>
    </div>

    {{-- Batch Aktif --}}
    <div class="bg-white rounded-xl border border-border p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-11 h-11 bg-gold-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-text font-display" x-text="stats.batchCount"></p>
            <p class="text-xs text-text-muted font-medium">Batch Aktif</p>
        </div>
    </div>

    {{-- Jadwal Bulan Ini --}}
    <div class="bg-white rounded-xl border border-border p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-text font-display" x-text="stats.thisMonth"></p>
            <p class="text-xs text-text-muted font-medium">Jadwal Bulan Ini</p>
        </div>
    </div>
</div>

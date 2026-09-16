<header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-border">
    <div class="flex items-center justify-between px-4 md:px-6 lg:px-8 h-16">
        {{-- Left: Mobile menu + Breadcrumb --}}
        <div class="flex items-center gap-3">
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-navy-50 text-text-muted"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <div>
                <nav class="flex items-center gap-1.5 text-xs text-text-muted">
                    <span class="hover:text-navy cursor-pointer">Dashboard</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    <span class="text-navy font-semibold">Jadwal</span>
                </nav>
                <h2 class="font-display text-lg font-bold text-text mt-0.5 leading-tight">Jadwal Mengajar</h2>
            </div>
        </div>

        {{-- Right: Search + Badge --}}
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2 bg-navy-50 rounded-lg px-3 py-2 w-64">
                <svg class="w-4 h-4 text-text-muted flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input
                    type="text"
                    placeholder="Cari dosen, materi..."
                    class="bg-transparent text-sm w-full outline-none placeholder:text-text-muted/60"
                    x-model="filters.search"
                    @input.debounce.300ms="applyFilters()"
                >
            </div>

            <div class="flex items-center gap-2 bg-gold-50 text-gold px-3 py-1.5 rounded-full text-xs font-bold">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span x-text="stats.total + ' jadwal'"></span>
            </div>
        </div>
    </div>
</header>

<div class="bg-white rounded-xl border border-border mb-6" x-data="{ open: true }">
    {{-- Filter Header (clickable toggle) --}}
    <button
        @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-navy-50/50 rounded-xl transition-colors"
    >
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-navy-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-text">Filter & Pencarian</h3>
                <p class="text-xs text-text-muted">Saring data jadwal</p>
            </div>
        </div>
        <svg
            class="w-5 h-5 text-text-muted transition-transform duration-200"
            :class="open ? 'rotate-180' : ''"
            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    {{-- Filter Body --}}
    <div x-show="open" x-collapse class="px-5 pb-5">
        <div class="border-t border-border pt-4">
            {{-- Mobile search (visible only on mobile) --}}
            <div class="md:hidden mb-4">
                <label class="block text-xs font-semibold text-text-muted mb-1.5 uppercase tracking-wide">Cari</label>
                <div class="flex items-center gap-2 bg-navy-50 rounded-lg px-3 py-2.5">
                    <svg class="w-4 h-4 text-text-muted flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input
                        type="text"
                        placeholder="Nama dosen, materi..."
                        class="bg-transparent text-sm w-full outline-none placeholder:text-text-muted/60"
                        x-model="filters.search"
                        @input.debounce.300ms="applyFilters()"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                {{-- Batch --}}
                <div>
                    <label class="block text-xs font-semibold text-text-muted mb-1.5 uppercase tracking-wide">Batch</label>
                    <select
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text appearance-none cursor-pointer hover:border-navy-200 transition-colors"
                        x-model="filters.batch"
                        @change="applyFilters()"
                    >
                        <option value="">Semua Batch</option>
                        <template x-for="b in batches" :key="b">
                            <option :value="b" x-text="b"></option>
                        </template>
                    </select>
                </div>

                {{-- Hari --}}
                <div>
                    <label class="block text-xs font-semibold text-text-muted mb-1.5 uppercase tracking-wide">Hari</label>
                    <select
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text appearance-none cursor-pointer hover:border-navy-200 transition-colors"
                        x-model="filters.hari"
                        @change="applyFilters()"
                    >
                        <option value="">Semua Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>

                {{-- Bulan --}}
                <div>
                    <label class="block text-xs font-semibold text-text-muted mb-1.5 uppercase tracking-wide">Bulan</label>
                    <select
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text appearance-none cursor-pointer hover:border-navy-200 transition-colors"
                        x-model="filters.bulan"
                        @change="applyFilters()"
                    >
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>

                {{-- Tahun --}}
                <div>
                    <label class="block text-xs font-semibold text-text-muted mb-1.5 uppercase tracking-wide">Tahun</label>
                    <select
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text appearance-none cursor-pointer hover:border-navy-200 transition-colors"
                        x-model="filters.tahun"
                        @change="applyFilters()"
                    >
                        <option value="">Semua Tahun</option>
                        <template x-for="y in years" :key="y">
                            <option :value="y" x-text="y"></option>
                        </template>
                    </select>
                </div>

                {{-- Tanggal Spesifik --}}
                <div>
                    <label class="block text-xs font-semibold text-text-muted mb-1.5 uppercase tracking-wide">Tanggal</label>
                    <input
                        type="date"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text hover:border-navy-200 transition-colors"
                        x-model="filters.tanggal"
                        @change="applyFilters()"
                    >
                </div>

                {{-- Reset --}}
                <div class="flex items-end">
                    <button
                        @click="resetFilters()"
                        class="w-full flex items-center justify-center gap-2 bg-white border border-border text-text-muted hover:text-navy hover:border-navy rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                        </svg>
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

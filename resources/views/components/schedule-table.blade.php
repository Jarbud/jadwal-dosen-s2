<div class="bg-white rounded-xl border border-border overflow-hidden">
    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 px-5 py-4 border-b border-border">
        <p class="text-sm text-text-muted">
            Menampilkan <strong class="text-navy font-bold" x-text="totalFiltered"></strong> dari <strong class="text-navy font-bold" x-text="totalData"></strong> jadwal
        </p>
        <div class="flex items-center gap-2 flex-wrap">
            <button @click="exportExcel()" class="inline-flex items-center gap-1.5 bg-success text-white px-3.5 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                Excel
            </button>
            <button @click="exportPDF()" class="inline-flex items-center gap-1.5 bg-danger text-white px-3.5 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                PDF
            </button>
            <button @click="openAdd()" class="inline-flex items-center gap-1.5 bg-gold text-white px-3.5 py-2 rounded-lg text-sm font-semibold hover:bg-amber-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Tambah
            </button>
        </div>
    </div>

    {{-- Desktop Table --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm min-w-[900px]">
            <thead>
                <tr class="bg-navy text-white">
                    <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider">Tanggal</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider">Jam</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider">Batch</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider">Mata Kuliah</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider">Dosen</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider">Materi</th>
                    <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider w-[120px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(r, idx) in pagedData" :key="r.id">
                    <tr class="border-b border-border hover:bg-gold-50/40 transition-colors group">
                        {{-- Tanggal --}}
                        <td class="px-5 py-3">
                            <div class="font-semibold text-text text-[13px]" x-text="formatDate(r.date)"></div>
                        </td>
                        {{-- Jam --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gold flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="font-semibold text-navy text-[13px]" x-text="r.jam || '-'"></span>
                            </div>
                        </td>
                        {{-- Batch --}}
                        <td class="px-4 py-3">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold" :class="getBadgeClass(r.batch)" x-text="r.batch || '-'"></span>
                        </td>
                        {{-- Mata Kuliah --}}
                        <td class="px-4 py-3 max-w-[200px]">
                            <div class="font-semibold text-text text-[13px] leading-snug" x-text="r.matkul && r.matkul.length > 45 ? r.matkul.slice(0,45)+'…' : (r.matkul || '-')"></div>
                        </td>
                        {{-- Dosen --}}
                        <td class="px-4 py-3 max-w-[160px]">
                            <div class="italic text-text-muted text-[13px]" x-text="r.dosen || '-'"></div>
                        </td>
                        {{-- Materi --}}
                        <td class="px-4 py-3 max-w-[200px]">
                            <div class="text-text text-[13px] leading-snug" x-text="r.materi && r.materi.length > 50 ? r.materi.slice(0,50)+'…' : (r.materi || '-')"></div>
                            <button
                                x-show="r.sub_materi && r.sub_materi.trim()"
                                @click="openDetail(r.id)"
                                class="text-xs text-navy underline hover:text-gold mt-0.5 transition-colors"
                            >Lihat detail &rsaquo;</button>
                        </td>
                        {{-- Aksi --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                <button
                                    @click="openDetail(r.id)"
                                    class="p-1.5 rounded-lg hover:bg-navy-50 text-text-muted hover:text-navy transition-colors"
                                    title="Lihat Detail"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                <button
                                    @click="openEdit(r.id)"
                                    class="p-1.5 rounded-lg hover:bg-navy-50 text-text-muted hover:text-navy transition-colors"
                                    title="Edit"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                </button>
                                <button
                                    @click="openDelete(r.id)"
                                    class="p-1.5 rounded-lg hover:bg-red-50 text-text-muted hover:text-danger transition-colors"
                                    title="Hapus"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>

                {{-- Empty state --}}
                <tr x-show="pagedData.length === 0">
                    <td colspan="7" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-16 h-16 text-border mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12H9.75m3 0H9.75m0 0H7.5m6.75 0v-3.375c0-.621-.504-1.125-1.125-1.125H9.75m6.75 0v.001M12 16.5v.001M12 16.5c0 .621-.504 1.125-1.125 1.125H9.75m0 0H7.5m2.25 0c.621 0 1.125.504 1.125 1.125v.375" />
                            </svg>
                            <p class="text-text-muted font-medium mb-1">Tidak ada jadwal ditemukan</p>
                            <p class="text-text-muted text-sm">Coba ubah filter atau reset pencarian</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Mobile Cards --}}
    <div class="md:hidden">
        <template x-for="(r, idx) in pagedData" :key="r.id">
            <div class="border-b border-border p-4 hover:bg-gold-50/30 transition-colors">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div>
                        <div class="font-semibold text-text text-sm" x-text="formatDate(r.date)"></div>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <svg class="w-3 h-3 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="text-xs font-semibold text-navy" x-text="r.jam || '-'"></span>
                        </div>
                    </div>
                    <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-bold whitespace-nowrap" :class="getBadgeClass(r.batch)" x-text="r.batch || '-'"></span>
                </div>
                <div class="font-semibold text-sm text-text mb-0.5" x-text="r.matkul || '-'"></div>
                <div class="text-xs text-text-muted italic" x-text="r.dosen || '-'"></div>
                <div x-show="r.materi" class="text-xs text-text-muted mt-1" x-text="r.materi && r.materi.length > 60 ? r.materi.slice(0,60)+'…' : r.materi"></div>

                <div class="flex items-center gap-2 mt-3 pt-2 border-t border-border/50">
                    <button @click="openDetail(r.id)" class="text-xs text-navy font-medium hover:underline">Detail</button>
                    <span class="text-border">|</span>
                    <button @click="openEdit(r.id)" class="text-xs text-navy font-medium hover:underline">Edit</button>
                    <span class="text-border">|</span>
                    <button @click="openDelete(r.id)" class="text-xs text-danger font-medium hover:underline">Hapus</button>
                </div>
            </div>
        </template>

        {{-- Mobile empty --}}
        <div x-show="pagedData.length === 0" class="px-4 py-12 text-center">
            <svg class="w-12 h-12 text-border mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12H9.75m3 0H9.75m0 0H7.5m6.75 0v-3.375c0-.621-.504-1.125-1.125-1.125H9.75m0 0H7.5m2.25 0c.621 0 1.125.504 1.125 1.125v.375" />
            </svg>
            <p class="text-text-muted font-medium">Tidak ada jadwal ditemukan</p>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-3 border-t border-border bg-navy-50/30">
        <p class="text-sm text-text-muted" x-text="pageInfo"></p>
        <div class="flex items-center gap-1">
            <button
                @click="goToPage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="px-3 py-1.5 rounded-lg text-sm font-medium border border-border bg-white hover:bg-navy-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
            >&lsaquo;</button>

            <template x-for="p in pageNumbers" :key="'p-'+p">
                <button
                    x-show="p !== '...'"
                    @click="goToPage(p)"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border transition-colors"
                    :class="p === currentPage ? 'bg-navy text-white border-navy' : 'bg-white border-border hover:bg-navy-50'"
                    x-text="p"
                ></button>
                <span x-show="p === '...'" class="px-1.5 text-text-muted text-sm">&hellip;</span>
            </template>

            <button
                @click="goToPage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="px-3 py-1.5 rounded-lg text-sm font-medium border border-border bg-white hover:bg-navy-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
            >&rsaquo;</button>
        </div>
    </div>
</div>

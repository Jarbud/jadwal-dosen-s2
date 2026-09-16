<div
    x-show="showModal === 'detail'"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
    @click.self="showModal = null"
>
    <div
        class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-border sticky top-0 bg-white rounded-t-2xl z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gold-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <h3 class="font-display text-lg font-bold text-text">Detail Jadwal</h3>
            </div>
            <button @click="showModal = null" class="p-2 -mr-2 rounded-lg hover:bg-navy-50 text-text-muted hover:text-text transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <template x-if="detailRecord">
            <div class="px-6 py-5 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Tanggal</p>
                        <p class="text-sm font-semibold text-text" x-text="formatDate(detailRecord.date)"></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Jam</p>
                        <p class="text-sm font-semibold text-navy" x-text="detailRecord.jam || '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Batch</p>
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold" :class="getBadgeClass(detailRecord.batch)" x-text="detailRecord.batch || '-'"></span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Periode</p>
                        <p class="text-sm text-text" x-text="detailRecord.periode || '-'"></p>
                    </div>
                </div>

                <div class="border-t border-border pt-4">
                    <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Mata Kuliah</p>
                    <p class="text-sm font-bold text-text" x-text="detailRecord.matkul || '-'"></p>
                </div>

                <div>
                    <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Nama Dosen</p>
                    <p class="text-sm text-text italic" x-text="detailRecord.dosen || '-'"></p>
                </div>

                <div>
                    <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Materi</p>
                    <p class="text-sm text-text" x-text="detailRecord.materi || '-'"></p>
                </div>

                <div x-show="detailRecord.sub_materi && detailRecord.sub_materi.trim()">
                    <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Sub Materi</p>
                    <p class="text-sm text-text-muted whitespace-pre-wrap leading-relaxed" x-text="detailRecord.sub_materi"></p>
                </div>

                <div x-show="detailRecord.tahun_ajaran" class="border-t border-border pt-4">
                    <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Tahun Ajaran</p>
                    <p class="text-sm text-text" x-text="detailRecord.tahun_ajaran || '-'"></p>
                </div>
            </div>
        </template>

        {{-- Footer --}}
        <div class="flex items-center justify-end px-6 py-4 border-t border-border bg-navy-50/30 rounded-b-2xl">
            <button @click="showModal = null" class="px-5 py-2.5 rounded-lg text-sm font-semibold border border-border text-text-muted hover:bg-white hover:text-text transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<div
    x-show="showModal === 'delete'"
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
        class="bg-white rounded-2xl shadow-2xl w-full max-w-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        {{-- Header --}}
        <div class="px-6 pt-6 pb-4 text-center">
            <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-danger" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <h3 class="font-display text-lg font-bold text-text mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-text-muted leading-relaxed">Yakin ingin menghapus jadwal ini? Tindakan tidak dapat dibatalkan.</p>
        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 pb-6">
            <button @click="showModal = null" class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold border border-border text-text-muted hover:bg-navy-50 transition-colors">
                Batal
            </button>
            <button @click="confirmDelete()" class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold bg-danger text-white hover:bg-red-700 transition-colors">
                Hapus
            </button>
        </div>
    </div>
</div>

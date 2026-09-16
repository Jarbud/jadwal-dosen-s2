<div
    x-show="showModal === 'form'"
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
        class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-border sticky top-0 bg-white rounded-t-2xl z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-navy-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <h3 class="font-display text-lg font-bold text-text" x-text="editingId ? 'Edit Jadwal' : 'Tambah Jadwal'"></h3>
            </div>
            <button @click="showModal = null" class="p-2 -mr-2 rounded-lg hover:bg-navy-50 text-text-muted hover:text-text transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-text mb-1.5">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" x-model="editForm.date"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text focus:border-navy transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-text mb-1.5">Jam <span class="text-danger">*</span></label>
                    <input type="text" x-model="editForm.jam" placeholder="18.30-20.30"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text focus:border-navy transition-colors">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-text mb-1.5">Batch / Konsentrasi <span class="text-danger">*</span></label>
                    <input type="text" x-model="editForm.batch" placeholder="Contoh: B19EB"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text focus:border-navy transition-colors">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-text mb-1.5">Mata Kuliah <span class="text-danger">*</span></label>
                    <input type="text" x-model="editForm.matkul" placeholder="Nama mata kuliah"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text focus:border-navy transition-colors">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-text mb-1.5">Nama Dosen <span class="text-danger">*</span></label>
                    <input type="text" x-model="editForm.dosen" placeholder="Nama dosen"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text focus:border-navy transition-colors">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-text mb-1.5">Materi</label>
                    <input type="text" x-model="editForm.materi" placeholder="Judul materi"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text focus:border-navy transition-colors">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-text mb-1.5">Sub Materi</label>
                    <textarea x-model="editForm.sub_materi" placeholder="Detail sub materi (opsional)" rows="3"
                        class="w-full bg-navy-50 border border-border rounded-lg px-3 py-2.5 text-sm text-text focus:border-navy transition-colors resize-none"></textarea>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-border bg-navy-50/30 rounded-b-2xl">
            <button @click="showModal = null" class="px-5 py-2.5 rounded-lg text-sm font-semibold border border-border text-text-muted hover:bg-white hover:text-text transition-colors">
                Batal
            </button>
            <button @click="saveRecord()" class="px-5 py-2.5 rounded-lg text-sm font-semibold bg-navy text-white hover:bg-navy-light transition-colors">
                Simpan
            </button>
        </div>
    </div>
</div>

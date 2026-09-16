<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jadwal S2 Magister Manajemen Eksekutif')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: var(--color-cream);
            color: var(--color-text);
            min-height: 100vh;
        }

        .font-display {
            font-family: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        ::selection {
            background: var(--color-gold);
            color: white;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--color-navy-200); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-navy-light); }

        input:focus, select:focus, textarea:focus, button:focus-visible {
            outline: 2px solid var(--color-gold);
            outline-offset: 2px;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased" x-data="appState()" x-cloak>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen lg:ml-[260px]">
            {{-- Header --}}
            @include('components.header')

            {{-- Page Content --}}
            <main class="flex-1 p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Toast --}}
    @include('components.toast')

    {{-- Modals --}}
    @include('components.modals.form-modal')
    @include('components.modals.detail-modal')
    @include('components.modals.delete-modal')

    <script>
    function appState() {
        return {
            raw: @json($jadwalList),
            filtered: [],
            currentPage: 1,
            perPage: 20,
            filters: { search: '', batch: '', hari: '', bulan: '', tahun: '', tanggal: '' },
            showModal: null,
            editingId: null,
            deletingId: null,
            editForm: { date: '', jam: '', batch: '', matkul: '', dosen: '', materi: '', sub_materi: '' },
            detailRecord: null,
            toastMsg: '',
            toastType: 'success',
            toastVisible: false,
            sidebarOpen: false,

            dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
            monthNames: ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            monthShort: ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],

            get batches() {
                return [...new Set(this.raw.map(r => r.batch).filter(Boolean))].sort();
            },
            get years() {
                return [...new Set(this.raw.map(r => (r.date||'').split('-')[0]).filter(Boolean))].sort();
            },
            get totalFiltered() { return this.filtered.length; },
            get totalData() { return this.raw.length; },
            get totalPages() { return Math.ceil(this.filtered.length / this.perPage) || 1; },
            get pagedData() {
                const s = (this.currentPage - 1) * this.perPage;
                return this.filtered.slice(s, s + this.perPage);
            },
            get pageInfo() {
                if (this.filtered.length === 0) return '';
                const s = (this.currentPage - 1) * this.perPage + 1;
                const e = Math.min(this.currentPage * this.perPage, this.filtered.length);
                return `${s}\u2013${e} dari ${this.filtered.length}`;
            },
            get stats() {
                const batches = new Set(this.raw.map(r => r.batch).filter(Boolean));
                const now = new Date();
                const thisMonth = this.raw.filter(r => {
                    if (!r.date) return false;
                    const d = new Date(r.date + 'T00:00:00');
                    return d.getMonth() === now.getMonth() && d.getFullYear() === now.getFullYear();
                });
                return { total: this.raw.length, batchCount: batches.size, thisMonth: thisMonth.length };
            },
            get pageNumbers() {
                const pages = [];
                const total = this.totalPages;
                const cur = this.currentPage;
                for (let p = 1; p <= total; p++) {
                    if (p === 1 || p === total || Math.abs(p - cur) <= 1) pages.push(p);
                    else if (pages[pages.length - 1] !== '...') pages.push('...');
                }
                return pages;
            },

            init() {
                this.raw.sort((a, b) => new Date(a.date) - new Date(b.date));
                this.applyFilters();
            },

            getDayName(dateStr) {
                if (!dateStr) return '';
                return this.dayNames[new Date(dateStr + 'T00:00:00').getDay()];
            },

            formatDate(dateStr) {
                if (!dateStr) return '-';
                const d = dateStr.split('-');
                if (d.length !== 3) return dateStr;
                const day = this.getDayName(dateStr);
                return `${day}, ${parseInt(d[2])} ${this.monthShort[parseInt(d[1])]} ${d[0]}`;
            },

            getBadgeClass(batch) {
                if (!batch) return 'bg-yellow-50 text-yellow-800 border border-yellow-200';
                const u = batch.toUpperCase();
                if (u.includes('EB')) return 'bg-blue-50 text-blue-700 border border-blue-200';
                if (u.includes('EP')) return 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                return 'bg-yellow-50 text-yellow-800 border border-yellow-200';
            },

            esc(s) {
                return String(s == null ? '' : s)
                    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            },

            applyFilters() {
                const f = this.filters;
                this.filtered = this.raw.filter(r => {
                    if (f.batch && r.batch !== f.batch) return false;
                    if (f.tanggal && r.date !== f.tanggal) return false;
                    if (f.bulan && r.date) {
                        if (parseInt(r.date.split('-')[1], 10) !== parseInt(f.bulan, 10)) return false;
                    }
                    if (f.tahun && r.date && r.date.split('-')[0] !== f.tahun) return false;
                    if (f.hari && this.getDayName(r.date) !== f.hari) return false;
                    if (f.search) {
                        const hay = [r.matkul, r.dosen, r.materi, r.sub_materi, r.batch].join(' ').toLowerCase();
                        if (!hay.includes(f.search.toLowerCase())) return false;
                    }
                    return true;
                });
                this.currentPage = 1;
            },

            resetFilters() {
                this.filters = { search: '', batch: '', hari: '', bulan: '', tahun: '', tanggal: '' };
                this.applyFilters();
            },

            openAdd() {
                this.editingId = null;
                this.editForm = { date: '', jam: '', batch: '', matkul: '', dosen: '', materi: '', sub_materi: '' };
                this.showModal = 'form';
            },

            openEdit(id) {
                const r = this.raw.find(x => x.id === id);
                if (!r) return;
                this.editingId = id;
                this.editForm = { date: r.date||'', jam: r.jam||'', batch: r.batch||'', matkul: r.matkul||'', dosen: r.dosen||'', materi: r.materi||'', sub_materi: r.sub_materi||'' };
                this.showModal = 'form';
            },

            openDetail(id) {
                this.detailRecord = this.raw.find(x => x.id === id);
                if (this.detailRecord) this.showModal = 'detail';
            },

            openDelete(id) {
                this.deletingId = id;
                this.showModal = 'delete';
            },

            saveRecord() {
                const f = this.editForm;
                if (!f.date || !f.jam || !f.dosen) {
                    this.showToast('Tanggal, Jam, dan Dosen wajib diisi', 'error');
                    return;
                }
                if (this.editingId) {
                    const idx = this.raw.findIndex(x => x.id === this.editingId);
                    if (idx >= 0) Object.assign(this.raw[idx], { ...f });
                    this.showToast('Jadwal berhasil diperbarui', 'success');
                } else {
                    this.raw.push({ id: Date.now(), ...f, periode: '', tahun_ajaran: '' });
                    this.showToast('Jadwal berhasil ditambahkan', 'success');
                }
                this.showModal = null;
                this.applyFilters();
            },

            confirmDelete() {
                this.raw = this.raw.filter(x => x.id !== this.deletingId);
                this.showModal = null;
                this.applyFilters();
                this.showToast('Jadwal berhasil dihapus', 'success');
            },

            showToast(msg, type = 'success') {
                this.toastMsg = msg;
                this.toastType = type;
                this.toastVisible = true;
                setTimeout(() => this.toastVisible = false, 3000);
            },

            exportExcel() {
                if (this.filtered.length === 0) { this.showToast('Tidak ada data untuk diexport', 'error'); return; }
                const exportData = this.filtered.map((r, i) => ({
                    "No": i + 1,
                    "Tanggal": this.formatDate(r.date),
                    "Hari": this.getDayName(r.date),
                    "Jam": r.jam || '-',
                    "Batch": r.batch || '-',
                    "Mata Kuliah": r.matkul || '-',
                    "Nama Dosen": r.dosen || '-',
                    "Materi": r.materi || '-',
                    "Sub Materi": r.sub_materi || '-',
                    "Periode": r.periode || '-',
                    "Tahun Ajaran": r.tahun_ajaran || '-'
                }));
                const ws = XLSX.utils.json_to_sheet(exportData);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Jadwal");
                XLSX.writeFile(wb, "Jadwal_Magister_Manajemen.xlsx");
            },

            exportPDF() {
                if (this.filtered.length === 0) { this.showToast('Tidak ada data untuk diexport', 'error'); return; }
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('l', 'pt', 'a4');
                doc.setFontSize(16);
                doc.setTextColor(26, 39, 68);
                doc.text("Jadwal S2 Magister Manajemen Eksekutif", 40, 40);
                doc.setFontSize(10);
                doc.setTextColor(100, 100, 100);
                doc.text("Konsentrasi EB (Bisnis) & EP (Pendidikan)", 40, 55);

                const headers = [["No", "Tanggal", "Hari", "Jam", "Batch", "Mata Kuliah", "Dosen", "Materi", "Sub Materi"]];
                const rows = this.filtered.map((r, i) => [
                    i + 1, this.formatDate(r.date), this.getDayName(r.date),
                    r.jam || '-', r.batch || '-', r.matkul || '-',
                    r.dosen || '-', r.materi || '-', r.sub_materi || '-'
                ]);
                doc.autoTable({
                    head: headers, body: rows, startY: 70, theme: 'grid',
                    styles: { fontSize: 7, cellPadding: 3, font: 'helvetica', valign: 'middle' },
                    headStyles: { fillColor: [26, 39, 68], textColor: [255, 255, 255], halign: 'center' },
                    columnStyles: {
                        0: { cellWidth: 25, halign: 'center' }, 1: { cellWidth: 65 },
                        2: { cellWidth: 40 }, 3: { cellWidth: 50 }, 4: { cellWidth: 40, halign: 'center' },
                        5: { cellWidth: 120 }, 6: { cellWidth: 90 }, 7: { cellWidth: 130 }, 8: { cellWidth: 'auto' }
                    }
                });
                doc.save("Jadwal_Magister_Manajemen.pdf");
            },

            goToPage(p) {
                if (p >= 1 && p <= this.totalPages) this.currentPage = p;
            }
        };
    }
    </script>

    @stack('scripts')
</body>
</html>

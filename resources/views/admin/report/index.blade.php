@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<x-layout-admin>
    <x-slot name="sidebar">
        <x-admin.sidebar />
    </x-slot>

    <x-slot name="header">
        <x-admin.header>Generate Laporan</x-admin.header>
        <x-admin.profile-dropdown></x-admin.profile-dropdown>
    </x-slot>

    <div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 max-w-7xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-blue-900">Generate Laporan Tracer Study</h1>
        </div>

        <!-- FORM FILTER -->
        <form id="report-form" class="mb-6 bg-white shadow rounded-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Pilih Tahun -->
                <div>
                    <label class="block font-semibold mb-1">Tahun Periode</label>
                    <select name="tahun" class="w-full border rounded p-2" required>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Program Studi -->
                <div>
                    <label class="block font-semibold">Program Studi</label>
                    <select name="prodi_ids[]" class="w-full rounded p-2" multiple required id="prodiSelect">
                        @foreach ($prodiList as $id => $prodi)
                            <option value="{{ $id }}">{{ $prodi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 hover:bg-blue-700">
                Generate Report
            </button>
            <a href="#" onclick="openReport()" class="text-blue-600 underline mt-2 block">Lihat Laporan Lengkap</a>
        </form>

        <!-- Narasi -->
        <div id="narasi" class="bg-blue-50 p-4 rounded shadow mb-6 hidden text-gray-800 leading-relaxed"></div>

        <!-- Tabel Statistik -->
        <div id="tabel-hasil" class="overflow-x-auto hidden">
            <table class="table-auto w-full border-collapse border border-gray-300 text-sm sm:text-base">
                <thead class="bg-blue-100 text-blue-900">
                    <tr>
                        <th class="border p-2 text-left">Program Studi</th>
                        <th class="border p-2 text-center">Mengisi</th>
                        <th class="border p-2 text-center">Tidak Mengisi</th>
                        <th class="border p-2 text-center">Jumlah</th>
                        <th class="border p-2 text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody id="tabel-body"></tbody>
            </table>
        </div>
    </div>

    <!-- Script pengambilan data -->

    <script>
    function openReport() {
        const form = document.getElementById('report-form');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        const url = "{{ route('admin.generate-report.pdf') }}" + "?" + params;
        window.open(url, '_blank');
    }
</script>
    <script>
        document.getElementById('report-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch("{{ route('admin.generate-report') }}?" + new URLSearchParams(formData), {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.json())
            .then(data => {
                // Tampilkan narasi
                const narasi = document.getElementById('narasi');
                narasi.innerHTML = data.narasi;
                narasi.classList.remove('hidden');

                // Tampilkan tabel
                const tbody = document.getElementById('tabel-body');
                tbody.innerHTML = "";

                data.data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="border p-2">${row.prodi}</td>
                        <td class="border p-2 text-center">${row.mengisi}</td>
                        <td class="border p-2 text-center">${row.tidak_mengisi}</td>
                        <td class="border p-2 text-center">${row.jumlah}</td>
                        <td class="border p-2 text-center">${row.persen}%</td>
                    `;
                    tbody.appendChild(tr);
                });

                document.getElementById('tabel-hasil').classList.remove('hidden');
            })
            .catch(err => {
                alert("Terjadi kesalahan dalam mengambil data laporan.");
                console.error(err);
            });
        });
    </script>
</x-layout-admin>

<!-- Include TomSelect -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<!-- Inisialisasi TomSelect -->
<script>
    const prodiSelect = new TomSelect('select[name="prodi_ids[]"]', {
        plugins: ['remove_button'],
        placeholder: "Pilih Program Studi...",
        persist: false,
        create: false,
        maxItems: null,
        render: {
            item: function(data, escape) {
                return '<div class="px-2 py-1 bg-blue-100 rounded text-blue-800 mr-1 mb-1 text-sm inline-block">' + escape(data.text) + '</div>';
            },
            option: function(data, escape) {
                return '<div>' + escape(data.text) + '</div>';
            }
        }
    });

    // Setelah inisialisasi, sembunyikan elemen select asli
    const selectElement = document.querySelector('select[name="prodi_ids[]"]');
    selectElement.style.opacity = '0';
    selectElement.style.position = 'absolute';
    selectElement.style.pointerEvents = 'none';
    selectElement.style.height = '0';
</script>
@endsection

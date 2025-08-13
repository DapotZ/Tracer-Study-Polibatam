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
            <form id="report-form" class="mb-6 bg-white shadow rounded-xl p-6" method="GET"
                action="{{ route('admin.statistik.partisipasi') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Pilih Periode -->
                    <div>
                        <label class="block font-semibold mb-2">Periode</label>
                        <select name="periode_id" class="w-full border border-gray-300 rounded p-1.5 pt-1.5" required>
                            @foreach ($periodes as $periode)
                                <option value="{{ $periode->id_periode }}"
                                    {{ (string) $selectedPeriode === (string) $periode->id_periode ? 'selected' : '' }}>
                                    {{ $periode->start_date->format('d M Y') }} - {{ $periode->end_date->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Program Studi -->
                    <div>
                        <label class="block font-semibold">Program Studi</label>
                        <select name="prodi_ids[]" class="w-full rounded pt-2" multiple id="prodiSelect">
                            <option value="all" {{ in_array('all', $selectedProdi) ? 'selected' : '' }}>Semua Program
                                Studi</option>

                            @foreach ($jurusans as $jurusan)
                                <optgroup label="{{ strtoupper($jurusan->department_name) }}">
                                    @foreach ($prodis->where('id_department', $jurusan->id_department) as $prodi)
                                        <option value="{{ $prodi->id_study }}"
                                            {{ in_array($prodi->id_study, $selectedProdi) ? 'selected' : '' }}>
                                            {{ $prodi->study_program }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('prodi_ids')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Jurusan -->
                    <div>
                        <label class="block font-semibold">Jurusan</label>
                        <select name="jurusan_ids[]" class="w-full rounded pt-2" multiple id="jurusanSelect">
                            <option value="all" {{ in_array('all', $selectedJurusan) ? 'selected' : '' }}>Semua Jurusan
                            </option>

                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id_department }}"
                                    {{ in_array($jurusan->id_department, $selectedJurusan) ? 'selected' : '' }}>
                                    {{ $jurusan->department_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_ids')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol generate, dipisah dari grid -->
                <div class="mt-6 flex gap-4">
                    <button type="submit" name="mode" value="prodi"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded whitespace-nowrap">
                        Generate Report (Prodi)
                    </button>

                    <button type="submit" name="mode" value="jurusan"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded whitespace-nowrap">
                        Generate Report (Jurusan)
                    </button>

                    <button type="reset"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded whitespace-nowrap">
                        Reset
                    </button>
                </div>

            </form>


            <!-- Narasi -->
            <div id="narasi" class="bg-blue-50 p-4 rounded shadow mb-6 hidden text-gray-800 leading-relaxed"></div>

            @if (!empty($statistik))
                @if ($narasiProfilUmum)
                    <div id="narasi" class="bg-blue-50 p-4 rounded shadow mb-6 text-gray-800 leading-relaxed">
                        {!! $narasiProfilUmum !!}
                    </div>
                @endif
                <div id="tabel-hasil" class="overflow-x-auto mt-6">
                    <h2 class="text-lg font-semibold text-blue-900 mb-2">Hasil Statistik</h2>
                    <table class="table-auto w-full border-collapse border border-gray-300 text-sm sm:text-base">
                        <thead class="bg-blue-100 text-blue-900">
                            <tr>
                                {{-- Kolom pertama berubah sesuai mode --}}
                                <th class="border p-2 text-left">
                                    {{ request()->input('mode') === 'jurusan' ? 'Jurusan' : 'Program Studi' }}
                                </th>
                                <th class="border p-2 text-center">Mengisi</th>
                                <th class="border p-2 text-center">Tidak Mengisi</th>
                                <th class="border p-2 text-center">Jumlah</th>
                                <th class="border p-2 text-center">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistik as $stat)
                                <tr>
                                    {{-- Kolom pertama juga menyesuaikan field --}}
                                    <td class="border p-2">
                                        @if (request()->input('mode') === 'jurusan')
                                            {{ $stat['jurusan'] === null || $stat['jurusan'] === '' ? 'Perusahaan' : $stat['jurusan'] }}
                                        @else
                                            {{ $stat['prodi'] ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="border p-2 text-center">{{ $stat['mengisi'] }}</td>
                                    <td class="border p-2 text-center">{{ $stat['belum'] }}</td>
                                    <td class="border p-2 text-center">{{ $stat['total'] }}</td>
                                    <td class="border p-2 text-center">{{ $stat['persentase'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-blue-200 font-semibold text-blue-900">
                            @php
                                $totalMengisi = array_sum(array_column($statistik, 'mengisi'));
                                $totalBelum = array_sum(array_column($statistik, 'belum'));
                                $totalResponden = array_sum(array_column($statistik, 'total'));
                                $totalPersentase =
                                    $totalResponden > 0 ? round(($totalMengisi / $totalResponden) * 100, 2) : 0;
                            @endphp
                            <tr>
                                <td class="border p-2">Total</td>
                                <td class="border p-2 text-center">{{ $totalMengisi }}</td>
                                <td class="border p-2 text-center">{{ $totalBelum }}</td>
                                <td class="border p-2 text-center">{{ $totalResponden }}</td>
                                <td class="border p-2 text-center">{{ $totalPersentase }}%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>

        <!-- SCRIPT -->
        <script></script>

        <!-- Tom Select -->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

        <script>
            // Tom Select untuk Prodi
            // Inisialisasi Tom Select dan simpan instance ke variabel
            const tomProdi = new TomSelect('select[name="prodi_ids[]"]', {
                plugins: ['remove_button'],
                placeholder: "Pilih Program Studi...",
                persist: false,
                create: false,
                maxItems: null,
                render: {
                    item: function(data, escape) {
                        return '<div class="px-2 py-1 bg-blue-100 rounded text-blue-800 mr-1 mb-1 text-sm inline-block">' +
                            escape(data.text) + '</div>';
                    },
                    option: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    }
                }
            });

            const tomJurusan = new TomSelect('select[name="jurusan_ids[]"]', {
                plugins: ['remove_button'],
                placeholder: "Pilih Jurusan...",
                persist: false,
                create: false,
                maxItems: null,
                render: {
                    item: function(data, escape) {
                        return '<div class="px-2 py-1 bg-green-100 rounded text-green-800 mr-1 mb-1 text-sm inline-block">' +
                            escape(data.text) + '</div>';
                    },
                    option: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    }
                }
            });

            const form = document.getElementById('report-form');

            form.addEventListener('reset', () => {
                setTimeout(() => {
                    tomProdi.clear(true);
                    tomJurusan.clear(true);
                    tomProdi.setValue(['']);
                    tomJurusan.setValue(['']);
                }, 10);
            });
        </script>

        <script src="{{ asset('js/script.js') }}"></script>
    </x-layout-admin>
@endsection

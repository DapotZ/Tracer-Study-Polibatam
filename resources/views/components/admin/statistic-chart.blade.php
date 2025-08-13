<div class="bg-blue-100 p-4 sm:p-6 lg:p-8 rounded-2xl shadow">
    <div class="font-bold mb-6 text-xl sm:text-2xl text-blue-900">Statistik Alumni</div>

    <form method="GET" id="global-filter-form" class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Program Studi -->
        <div class="flex flex-col">
            <label for="study_program" class="text-sm font-medium text-gray-700 mb-1">Program Studi</label>
            <select name="study_program" id="study_program"
                class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 w-full">
                <option value="">Semua Program Studi</option>
                @foreach ($studyPrograms as $sp)
                    <option value="{{ $sp->id_study }}"
                        {{ request('study_program') == $sp->id_study ? 'selected' : '' }}>
                        {{ $sp->study_program }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tahun Lulus -->
        <div class="flex flex-col">
            <label for="graduation_year_filter" class="text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
            <select name="graduation_year_filter" id="graduation_year_filter"
                class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 w-full">
                <option value="">Semua Tahun</option>
                @foreach ($allGraduationYears ?? [] as $year)
                    <option value="{{ $year }}"
                        {{ request('graduation_year_filter') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 items-stretch">
        <!-- Chart Status Alumni -->
        <div class="bg-white rounded-2xl shadow-md p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="text-blue-800 font-semibold text-base sm:text-lg flex-1">Status Alumni</div>
                <!-- Download buttons -->
                <div class="flex gap-1 ml-2">
                    <button onclick="downloadChart('statistikChart', 'png')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download PNG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <button onclick="downloadChart('statistikChart', 'jpeg')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download JPEG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                        </svg>
                    </button>
                    <button onclick="downloadChart('statistikChart', 'svg')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download SVG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                        </svg>
                    </button>
                    <button
                        onclick="downloadChartData('statistikChart', 'csv', ['Bekerja', 'Tidak Bekerja', 'Melanjutkan Studi', 'Berwiraswasta', 'Sedang Mencari Kerja'], [{{ $statisticData['bekerja'] ?? 0 }}, {{ $statisticData['tidak bekerja'] ?? 0 }}, {{ $statisticData['melanjutkan studi'] ?? 0 }}, {{ $statisticData['berwiraswasta'] ?? 0 }}, {{ $statisticData['sedang mencari kerja'] ?? 0 }}])"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download CSV">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button
                        onclick="downloadChartData('statistikChart', 'xlsx', ['Bekerja', 'Tidak Bekerja', 'Melanjutkan Studi', 'Berwiraswasta', 'Sedang Mencari Kerja'], [{{ $statisticData['bekerja'] ?? 0 }}, {{ $statisticData['tidak bekerja'] ?? 0 }}, {{ $statisticData['melanjutkan studi'] ?? 0 }}, {{ $statisticData['berwiraswasta'] ?? 0 }}, {{ $statisticData['sedang mencari kerja'] ?? 0 }}])"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download Excel">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button onclick="printChart('statistikChart', 'Status Alumni')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Print Chart">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zM5 14H4v-3h1v3zm1 0v2h6v-2H6zm0-1h6V9H6v4z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-full h-64 sm:h-72 lg:h-72">
                <canvas id="statistikChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Chart Distribusi Tahun Lulus -->
        <div class="bg-white rounded-2xl shadow-md p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="text-blue-800 font-semibold text-base sm:text-lg flex-1">
                    Top Perusahaan Perekrut Alumni
                </div>
                <!-- Download buttons -->
                <div class="flex gap-1 ml-2">
                    <button onclick="downloadChart('graduationYearPieChart', 'png')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download PNG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <button onclick="downloadChart('graduationYearPieChart', 'jpeg')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download JPEG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                        </svg>
                    </button>
                    <button onclick="downloadChart('graduationYearPieChart', 'svg')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download SVG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                        </svg>
                    </button>
                    <button onclick="downloadGraduationYearData('csv')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download CSV">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button onclick="downloadGraduationYearData('xlsx')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download Excel">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button onclick="printChart('graduationYearPieChart', 'Distribusi Tahun Lulus Alumni')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Print Chart">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zM5 14H4v-3h1v3zm1 0v2h6v-2H6zm0-1h6V9H6v4z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-full h-64 sm:h-72 lg:h-72">
                <canvas id="graduationYearPieChart" class="max-w-full max-h-full"></canvas>
            </div>
        </div>

        <!-- Diagram Bar Rata-rata Pendapatan Alumni per Range -->
        <div class="bg-white rounded-2xl shadow-md p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="text-blue-800 font-semibold text-base sm:text-lg flex-1">Program Studi Teratas dengan
                    Alumni Bekerja
                </div>
                <!-- Download buttons -->
                <div class="flex gap-1 ml-2">
                    <button onclick="downloadChart('topStudyProgramsChart', 'png')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download PNG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <button onclick="downloadChart('topStudyProgramsChart', 'jpeg')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download JPEG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                        </svg>
                    </button>
                    <button onclick="downloadChart('topStudyProgramsChart', 'svg')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download SVG">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                        </svg>
                    </button>
                    <button onclick="downloadSalaryRangeData('csv')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download CSV">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button onclick="downloadSalaryRangeData('xlsx')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Download Excel">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button onclick="printChart('topStudyProgramsChart', 'Distribusi Rentang Gaji Alumni')"
                        class="bg-white/80 hover:bg-white p-1 rounded shadow text-xs text-gray-600 hover:text-gray-800"
                        title="Print Chart">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zM5 14H4v-3h1v3zm1 0v2h6v-2H6zm0-1h6V9H6v4z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-full h-64 sm:h-72 lg:h-72">
                <canvas id="topStudyProgramsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Total Alumni Mengisi Kuesioner -->
    <div class="mt-6 bg-white rounded-2xl shadow-md p-4 flex flex-col items-center justify-center">
        <div class="text-blue-800 font-semibold text-base sm:text-lg mb-2">Total Alumni Mengisi Kuesioner</div>
        <div class="text-3xl font-bold text-blue-700">
            {{ $answerCountAlumni ?? 0 }}
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        const colorPalettes = {
            chart1: ['#77BEF0', '#FFCB61', '#FF894F', '#EA5B6F', "#93DA97", ],
            chart2: ['#FEFFC4', '#FFBC4C', '#799EFF', '#FFBC4C', ],
            chart3: ['#BB3E00', '#F7AD45', '#657C6A', '#A2B9A7', '#A86523', '#E9A319', '#FAD59A', ]
        };

        function getRandomColorsFromPalette(palette, count) {
            const shuffled = [...palette].sort(() => 0.5 - Math.random());
            return shuffled.slice(0, count);
        }

        document.addEventListener('DOMContentLoaded', function() {

            const studyProgramSelect = document.getElementById('study_program');
            const graduationYearSelect = document.getElementById('graduation_year_filter');
            const barChartElement = document.getElementById('statistikChart');
            let statistikChart;

            function initChart(data) {
                statistikChart = new Chart(barChartElement, {
                    type: 'bar',
                    data: {
                        labels: ['Bekerja', 'Tidak Bekerja', 'Melanjutkan Studi', 'Berwiraswasta',
                            'Sedang Mencari Kerja'
                        ],
                        datasets: [{
                            label: 'Jumlah Alumni',
                            data: data,
                            backgroundColor: getRandomColorsFromPalette(colorPalettes.chart1, data
                                .length),
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            function fetchChartData() {
                const studyProgram = studyProgramSelect.value;
                const graduationYear = graduationYearSelect.value;

                fetch(
                        `/alumni/statistics-data?study_program=${studyProgram}&graduation_year_filter=${graduationYear}`
                    )
                    .then(response => response.json())
                    .then(data => {
                        const chartData = [
                            data.bekerja ?? 0,
                            data.tidak_bekerja ?? 0,
                            data.melanjutkan_studi ?? 0,
                            data.berwiraswasta ?? 0,
                            data.sedang_mencari_kerja ?? 0
                        ];

                        if (statistikChart) {
                            statistikChart.data.datasets[0].data = chartData;
                            statistikChart.update();
                        } else {
                            initChart(chartData);
                        }
                    });
            }

            // Load pertama kali
            fetchChartData();

            // Perubahan filter
            [studyProgramSelect, graduationYearSelect].forEach(select => {
                select.addEventListener('change', fetchChartData);
            });
        });

        // Pie Chart: Tahun Lulus
        const ctx = document.getElementById('graduationYearPieChart').getContext('2d');
        let topCompaniesChart;

        function fetchAndRenderTopCompanies() {
            const studyProgram = document.getElementById('study_program')?.value;
            const graduationYear = document.getElementById('graduation_year_filter')?.value;

            const url = new URL('/alumni/top-companies', window.location.origin);
            if (studyProgram) url.searchParams.append('study_program', studyProgram);
            if (graduationYear) url.searchParams.append('graduation_year_filter', graduationYear);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.company_name);
                    const values = data.map(item => item.total);

                    // Simpan untuk download/export jika perlu
                    window.topCompanyLabels = labels;
                    window.topCompanyValues = values;

                    if (topCompaniesChart) {
                        topCompaniesChart.destroy();
                    }

                    topCompaniesChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels, // contoh: ['Google', 'Tokopedia', 'Shopee']
                            datasets: [{
                                label: 'Jumlah Alumni',
                                data: values, // contoh: [5, 3, 8]
                                backgroundColor: getRandomColorsFromPalette(colorPalettes.chart1, values
                                    .length),
                                borderRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                    labels: {
                                        boxWidth: 20,
                                        padding: 15
                                    }
                                },
                            }
                        }
                    });
                });
        }

        // Event listener filter
        document.getElementById('study_program')?.addEventListener('change', fetchAndRenderTopCompanies);
        document.getElementById('graduation_year_filter')?.addEventListener('change', fetchAndRenderTopCompanies);

        // Load pertama kali
        fetchAndRenderTopCompanies();

        const topStudyProgramsCtx = document.getElementById('topStudyProgramsChart').getContext('2d');
        let topStudyProgramsChart;

        function fetchAndRenderTopStudyPrograms() {
            const studyProgram = document.getElementById('study_program')?.value;
            const graduationYear = document.getElementById('graduation_year_filter')?.value;

            const url = new URL('/alumni/top-study-programs', window.location.origin);
            if (studyProgram && studyProgram !== 'all') url.searchParams.append('study_program', studyProgram);
            if (graduationYear) url.searchParams.append('graduation_year_filter', graduationYear);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.study_program);
                    const values = data.map(item => item.total);

                    // Simpan untuk keperluan download/export
                    window.topStudyProgramLabels = labels;
                    window.topStudyProgramValues = values;

                    if (topStudyProgramsChart) {
                        topStudyProgramsChart.destroy();
                    }

                    topStudyProgramsChart = new Chart(topStudyProgramsCtx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Alumni Bekerja',
                                data: values,
                                backgroundColor: getRandomColorsFromPalette(colorPalettes.chart1, data
                                    .length),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                    labels: {
                                        boxWidth: 20,
                                        padding: 15
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            let value = context.raw || 0;
                                            return `${label}: ${value} orang`;
                                        }
                                    }
                                },
                            }
                        }
                    });
                });
        }

        // Event listener untuk filter
        document.getElementById('study_program')?.addEventListener('change', fetchAndRenderTopStudyPrograms);
        document.getElementById('graduation_year_filter')?.addEventListener('change', fetchAndRenderTopStudyPrograms);

        // Load pertama kali
        fetchAndRenderTopStudyPrograms();
    </script>
@endpush

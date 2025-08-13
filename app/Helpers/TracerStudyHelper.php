<?php

namespace App\Helpers;

class TracerStudyHelper
{
    public static function generateNarasiProdi($tahun, $dataProdi, $semuaProdiTerpilih = false, $periode = null)
    {
        if (empty($dataProdi)) {
            return '';
        }

        // Total target dan responden
        $totalTarget = array_sum(array_column($dataProdi, 'total'));
        $totalResponden = array_sum(array_column($dataProdi, 'mengisi'));
        $totalBelumMengisi = $totalTarget - $totalResponden;
        $persentaseTotal = $totalTarget > 0 ? round(($totalResponden / $totalTarget) * 100, 2) : 0;

        // Cek apakah hanya alumni, company, atau both
        $adaAlumni = collect($dataProdi)->contains('type', 'alumni');
        $adaCompany = collect($dataProdi)->contains('type', 'company');
        $tipe = $adaAlumni && $adaCompany ? 'both' : ($adaCompany ? 'company' : 'alumni');

        $narasi = "<h2 class='text-lg font-bold mb-2'>3.1 Profil Umum " . ucfirst($tipe) . '</h2>';
        $narasi .= "Kegiatan tracer study Politeknik Negeri Batam tahun <b>{$tahun}</b> dilakukan untuk memetakan kondisi dan aktivitas ";

        if ($tipe === 'company') {
            $narasi .= 'perusahaan mitra yang menjadi tempat alumni bekerja. ';
        } elseif ($tipe === 'alumni') {
            $narasi .= 'alumni setelah menyelesaikan pendidikan di berbagai program studi. ';
        } else {
            $narasi .= 'baik alumni setelah menyelesaikan pendidikan maupun perusahaan mitra tempat alumni bekerja. ';
        }

        $narasi .= 'Target responden dalam tracer study ini ditentukan melalui konfigurasi sistem berdasarkan status, tahun lulus, dan peran pengguna. ';

        // 🔹 Tambahan logika berdasarkan periode
        if ($periode) {
            if ($periode->all_alumni == 0 && $periode->target_type === 'years_ago' && !empty($periode->years_ago_list)) {
                $listTahun = is_array($periode->years_ago_list) ? $periode->years_ago_list : json_decode($periode->years_ago_list, true);

                if (!empty($listTahun)) {
                    $narasi .= 'Pada periode ini, target responden <b>bukan semua alumni</b>, melainkan alumni yang lulus ';
                    $narasi .= '<b>' . implode(', ', $listTahun) . ' tahun yang lalu</b>. ';
                }
            }
        }

        $narasi .= '<br><br>';

        if ($tipe === 'company') {
            $narasi .= 'Hasil kuesioner ditujukan kepada <b>perusahaan-perusahaan</b> yang menjadi mitra lulusan Polibatam. ';
        } elseif ($tipe === 'alumni') {
            if ($semuaProdiTerpilih) {
                $narasi .= 'Laporan ini memuat hasil tracer study untuk alumni dari <b>semua program studi</b> pada periode ini. ';
            } else {
                $dataAlumniOnly = array_filter($dataProdi, fn($d) => $d['type'] === 'alumni');
                $daftarProdi = implode(', ', array_column($dataAlumniOnly, 'prodi'));
                $narasi .= "Laporan ini memuat hasil tracer study untuk alumni dari program studi yang dipilih pada periode ini, meliputi <b>{$daftarProdi}</b>. ";
            }
        } else {
            $narasi .= 'Laporan ini memuat hasil tracer study untuk alumni dari berbagai program studi serta kepada perusahaan yang menjadi tempat kerja alumni. ';
        }

        $narasi .= $tipe === 'company' ? 'Setiap perusahaan menerima kuesioner untuk memberikan umpan balik mengenai kualitas alumni yang bekerja di tempat mereka.<br><br>' : 'Setiap alumni menerima kuesioner yang telah disesuaikan dengan tahun kelulusan dan status mereka saat ini, baik alumni yang bekerja, belum bekerja, melanjutkan studi, berwirausaha, maupun sedang mencari pekerjaan.<br><br>';

        $narasi .= "Dari total <b>{$totalTarget}</b> responden yang menjadi target tracer, tercatat sebanyak <b>{$totalResponden}</b> telah memberikan tanggapan terhadap kuesioner, dengan rincian sebagai berikut:<br><br>";

        foreach ($dataProdi as $prodi) {
            $label = $prodi['type'] === 'company' && $prodi['prodi'] === 'Perusahaan' ? '<b>Perusahaan</b>' : "Program Studi <b>{$prodi['prodi']}</b>";

            $narasi .= "- {$label}: dari total <b>{$prodi['total']}</b>, sebanyak <b>{$prodi['mengisi']}</b> telah mengisi kuesioner dan <b>{$prodi['belum']}</b> belum mengisi, dengan tingkat partisipasi sebesar <b>{$prodi['persentase']}%</b>.<br>";
        }

        if (count($dataProdi) > 3) {
            $narasi .= '<br><b>Analisis Tambahan:</b><br>';

            $dataAlumni = array_filter($dataProdi, fn($d) => $d['type'] === 'alumni');

            if (!empty($dataAlumni)) {
                $terbanyak = collect($dataAlumni)->sortByDesc('mengisi')->first();
                $tersedikit = collect($dataAlumni)->sortBy('mengisi')->first();

                $narasi .= "Program studi dengan jumlah responden terbanyak adalah <b>{$terbanyak['prodi']}</b> dengan <b>{$terbanyak['mengisi']}</b> responden. ";
                $narasi .= "Sedangkan jumlah responden paling sedikit berasal dari <b>{$tersedikit['prodi']}</b> dengan hanya <b>{$tersedikit['mengisi']}</b> yang mengisi.<br>";
            }

            $narasi .= "Masih terdapat <b>{$totalBelumMengisi}</b> responden yang belum mengisi kuesioner. ";
            $narasi .= "Tingkat partisipasi keseluruhan tracer study tahun {$tahun} mencapai <b>{$persentaseTotal}%</b> dari total target yang ditentukan.<br><br>";
            $narasi .= 'Temuan ini dapat menjadi bahan evaluasi dalam upaya peningkatan partisipasi pada pelaksanaan tracer study berikutnya.';
        }

        return $narasi;
    }

    public static function generateNarasiJurusan($tahun, $dataJurusan, $isAllJurusan = false, $periode = null, $jurusanDipilih = null)
    {
        if (empty($dataJurusan)) {
            return '';
        }

        // ✅ Filter jika jurusan dipilih dan bukan "semua jurusan"
        if ($jurusanDipilih && !$isAllJurusan) {
            $dataJurusan = array_filter($dataJurusan, function ($d) use ($jurusanDipilih) {
                // Cocokkan berdasarkan nama jurusan
                return stripos($d['jurusan'], $jurusanDipilih) !== false;
            });
        }

        // Hitung total
        $totalTarget = array_sum(array_column($dataJurusan, 'total'));
        $totalResponden = array_sum(array_column($dataJurusan, 'mengisi'));
        $totalBelumMengisi = $totalTarget - $totalResponden;
        $persentaseTotal = $totalTarget > 0 ? round(($totalResponden / $totalTarget) * 100, 2) : 0;

        // Tentukan tipe responden
        $adaAlumni = collect($dataJurusan)->contains('type', 'alumni');
        $adaCompany = collect($dataJurusan)->contains('type', 'company');
        $tipe = $adaAlumni && $adaCompany ? 'both' : ($adaCompany ? 'company' : 'alumni');

        // Awal narasi
        $narasi = "<h2 class='text-lg font-bold mb-2'>3.1 Profil Umum " . ucfirst($tipe) . '</h2>';
        $narasi .= "Kegiatan tracer study Politeknik Negeri Batam tahun <b>{$tahun}</b> dilakukan untuk memetakan kondisi dan aktivitas ";

        if ($tipe === 'company') {
            $narasi .= 'perusahaan mitra yang menjadi tempat alumni bekerja. ';
        } elseif ($tipe === 'alumni') {
            $narasi .= 'alumni setelah menyelesaikan pendidikan di berbagai jurusan. ';
        } else {
            $narasi .= 'baik alumni setelah menyelesaikan pendidikan maupun perusahaan mitra tempat alumni bekerja. ';
        }

        $narasi .= 'Target responden dalam tracer study ini ditentukan melalui konfigurasi sistem berdasarkan status, tahun lulus, dan peran pengguna. ';

        // Periode khusus
        if ($periode) {
            if ($periode->all_alumni == 0 && $periode->target_type === 'years_ago' && !empty($periode->years_ago_list)) {
                $listTahun = is_array($periode->years_ago_list) ? $periode->years_ago_list : json_decode($periode->years_ago_list, true);
                if (!empty($listTahun)) {
                    $narasi .= 'Pada periode ini, target responden <b>bukan semua alumni</b>, melainkan alumni yang lulus ';
                    $narasi .= '<b>' . implode(', ', $listTahun) . ' tahun yang lalu</b>. ';
                }
            }
        }

        $narasi .= '<br><br>';

        // Kalimat sesuai pilihan jurusan
        if ($tipe === 'company') {
            $narasi .= 'Hasil kuesioner ditujukan kepada <b>perusahaan-perusahaan</b> yang menjadi mitra lulusan Polibatam. ';
        } elseif ($tipe === 'alumni') {
            if ($isAllJurusan) {
                $narasi .= 'Laporan ini memuat hasil tracer study untuk alumni dari <b></b> pada periode ini. ';
            } else {
                $dataAlumniOnly = array_filter($dataJurusan, fn($d) => $d['type'] === 'alumni');
                $daftarJurusan = implode(', ', array_unique(array_column($dataAlumniOnly, 'jurusan')));
                $narasi .= "Laporan ini memuat hasil tracer study untuk alumni dari jurusan yang dipilih pada periode ini, meliputi <b>{$daftarJurusan}</b>. ";
            }
        } else {
            // both
            if ($isAllJurusan) {
                $narasi .= 'Laporan ini memuat hasil tracer study untuk alumni dari berbagai jurusan serta kepada perusahaan yang menjadi tempat kerja alumni. ';
            } else {
                $dataAlumniOnly = array_filter($dataJurusan, fn($d) => $d['type'] === 'alumni');
                $daftarJurusan = implode(', ', array_unique(array_column($dataAlumniOnly, 'jurusan')));
                $narasi .= "Laporan ini memuat hasil tracer study untuk alumni dari jurusan yang dipilih pada periode ini, meliputi <b>{$daftarJurusan}</b>, serta kepada perusahaan yang menjadi tempat kerja alumni. ";
            }
        }

        $narasi .= $tipe === 'company' ? 'Setiap perusahaan menerima kuesioner untuk memberikan umpan balik mengenai kualitas alumni yang bekerja di tempat mereka.<br><br>' : 'Setiap alumni menerima kuesioner yang telah disesuaikan dengan tahun kelulusan dan status mereka saat ini, baik alumni yang bekerja, belum bekerja, melanjutkan studi, berwirausaha, maupun sedang mencari pekerjaan.<br><br>';

        // Rincian jumlah
        $narasi .= "Dari total <b>{$totalTarget}</b> responden yang menjadi target tracer, tercatat sebanyak <b>{$totalResponden}</b> telah memberikan tanggapan terhadap kuesioner, dengan rincian sebagai berikut:<br><br>";

        foreach ($dataJurusan as $jurusan) {
            $label = $jurusan['type'] === 'company' ? ' <b>Perusahaan</b>' : "Jurusan <b>{$jurusan['jurusan']}</b>";

            $narasi .= "- {$label}: dari total <b>{$jurusan['total']}</b>, sebanyak <b>{$jurusan['mengisi']}</b> telah mengisi kuesioner dan <b>{$jurusan['belum']}</b> belum mengisi, dengan tingkat partisipasi sebesar <b>{$jurusan['persentase']}%</b>.<br>";
        }
        // Analisis tambahan kalau datanya banyak
        if (count($dataJurusan) > 1) {
            $narasi .= '<br><b>Analisis Tambahan:</b><br>';

            $dataAlumni = array_filter($dataJurusan, fn($d) => $d['type'] === 'alumni');
            if (!empty($dataAlumni)) {
                $terbanyak = collect($dataAlumni)->sortByDesc('mengisi')->first();
                $tersedikit = collect($dataAlumni)->sortBy('mengisi')->first();

                $narasi .= "Program studi dengan jumlah responden terbanyak adalah <b>{$terbanyak['jurusan']}</b> dengan <b>{$terbanyak['mengisi']}</b> responden. ";
                $narasi .= "Sedangkan jumlah responden paling sedikit berasal dari <b>{$tersedikit['jurusan']}</b> dengan hanya <b>{$tersedikit['mengisi']}</b> yang mengisi.<br>";
            }

            $narasi .= "Masih terdapat <b>{$totalBelumMengisi}</b> responden yang belum mengisi kuesioner. ";
            $narasi .= "Tingkat partisipasi keseluruhan tracer study tahun {$tahun} mencapai <b>{$persentaseTotal}%</b> dari total target yang ditentukan.<br><br>";
            $narasi .= 'Temuan ini dapat menjadi bahan evaluasi dalam upaya peningkatan partisipasi pada pelaksanaan tracer study berikutnya.';
        }

        return $narasi;
    }
}

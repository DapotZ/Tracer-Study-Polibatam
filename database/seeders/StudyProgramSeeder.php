<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tb_study_program;

class StudyProgramSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Teknik Informatika
            ['id_study' => 1, 'study_program' => 'Diploma 3 Teknik Informatika', 'id_department' => 1],
            ['id_study' => 2, 'study_program' => 'Diploma 3 Teknologi Geomatika', 'id_department' => 1],
            ['id_study' => 3, 'study_program' => 'Sarjana Terapan Animasi', 'id_department' => 1],
            ['id_study' => 4, 'study_program' => 'Sarjana Terapan Teknologi Rekayasa Multimedia', 'id_department' => 1],
            ['id_study' => 5, 'study_program' => 'Sarjana Terapan Rekayasa Keamanan Siber', 'id_department' => 1],
            ['id_study' => 6, 'study_program' => 'Sarjana Terapan Rekayasa Perangkat Lunak', 'id_department' => 1],
            ['id_study' => 7, 'study_program' => 'Sarjana Terapan Teknologi Permainan', 'id_department' => 1],
            ['id_study' => 8, 'study_program' => 'Magister Terapan (S2) Rekayasa / Teknik Komputer', 'id_department' => 1],

            // Teknik Mesin
            ['id_study' => 9, 'study_program' => 'Diploma 3 Teknik Mesin', 'id_department' => 2],
            ['id_study' => 10, 'study_program' => 'Diploma 3 Teknik Perawatan Pesawat Udara', 'id_department' => 2],
            ['id_study' => 11, 'study_program' => 'Sarjana Terapan Teknologi Rekayasa Konstruksi Perkapalan', 'id_department' => 2],
            ['id_study' => 12, 'study_program' => 'Sarjana Terapan Teknologi Rekayasa Pengelasan dan Fabrikasi', 'id_department' => 2],
            ['id_study' => 13, 'study_program' => 'Program Profesi Insinyur (PSPPI)', 'id_department' => 2],
            ['id_study' => 14, 'study_program' => 'Sarjana Terapan Teknologi Rekayasa Metalurgi', 'id_department' => 2],

            // Teknik Elektro
            ['id_study' => 15, 'study_program' => 'Diploma 3 Teknik Elektronika Manufaktur', 'id_department' => 3],
            ['id_study' => 16, 'study_program' => 'Sarjana Terapan Teknologi Rekayasa Elektronika', 'id_department' => 3],
            ['id_study' => 17, 'study_program' => 'Diploma 3 Teknik Instrumentasi', 'id_department' => 3],
            ['id_study' => 18, 'study_program' => 'Sarjana Terapan Teknik Mekatronika', 'id_department' => 3],
            ['id_study' => 19, 'study_program' => 'Sarjana Terapan Teknologi Rekayasa Pembangkit Energi', 'id_department' => 3],
            ['id_study' => 20, 'study_program' => 'Sarjana Terapan Teknologi Rekayasa Robotika', 'id_department' => 3],

            // Manajemen Bisnis
            ['id_study' => 21, 'study_program' => 'Diploma 3 Akuntansi', 'id_department' => 4],
            ['id_study' => 22, 'study_program' => 'Sarjana Terapan Akuntansi Manajerial', 'id_department' => 4],
            ['id_study' => 23, 'study_program' => 'Sarjana Terapan Administrasi Bisnis Terapan', 'id_department' => 4],
            ['id_study' => 24, 'study_program' => 'Sarjana Terapan Logistik Perdagangan Internasional', 'id_department' => 4],
            ['id_study' => 25, 'study_program' => 'Program Studi D2 Jalur Cepat Distribusi Barang', 'id_department' => 4],
        ];

        foreach ($data as $item) {
            Tb_study_program::create($item);
        }
    }
}

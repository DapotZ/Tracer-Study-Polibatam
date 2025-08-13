<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        DB::table('tb_departments')->insert([
            [
                'id_department' => 1,
                'department_name' => 'Teknik Informatika',
            ],
            [
                'id_department' => 2,
                'department_name' => 'Teknik Mesin',
            ],
            [
                'id_department' => 3,
                'department_name' => 'Teknik Elektro',
            ],
            [
                'id_department' => 4,
                'department_name' => 'Manajemen Bisnis',
            ],
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_Department extends Model
{
    protected $table = 'tb_departments'; // <--- ini penting!

    protected $primaryKey = 'id_department';

    protected $fillable = ['department_name'];

    public function studyPrograms()
    {
        return $this->hasMany(Tb_study_program::class, 'id_department');
    }
}

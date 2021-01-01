<?php

namespace App\Models;

use CodeIgniter\Model;

class nilaiAModel extends Model
{
    protected $table = 'nilai_alternatif';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields =
    [
        'id_kriteria',
        'alternatif1',
        'alternatif2',
        'nilai',
    ];
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class nilaiKModel extends Model
{
    protected $table = 'nilai_kriteria';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields =
    [
        'id_kriteria1',
        'id_kriteria2',
        'nilai',
    ];
}
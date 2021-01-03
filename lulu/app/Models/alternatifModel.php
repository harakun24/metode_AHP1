<?php

namespace App\Models;

use CodeIgniter\Model;

class alternatifModel extends Model
{
    protected $table = 'alternatif';
    protected $primaryKey = 'id_alternatif';
    protected $allowedFields =
    [
        'nama_alternatif',
    ];
}
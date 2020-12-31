<?php

namespace App\Models;

use CodeIgniter\Model;

class adminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'admin_username';
    protected $allowedFields =
    [
        'admin_nama',
        'admin_username',
        'admin_pass',
    ];
}
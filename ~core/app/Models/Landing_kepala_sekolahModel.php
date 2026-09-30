<?php

namespace App\Models;

use CodeIgniter\Model;

class Landing_kepala_sekolahModel extends Model
{
    protected $table            = 'landing_kepala_sekolah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'nama', 'foto', 'moto1', 'moto2', 'moto3', 'moto4'];
}

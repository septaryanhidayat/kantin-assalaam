<?php

namespace App\Models;

use CodeIgniter\Model;

class KantinModel extends Model
{
    protected $table            = 'kantin';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
    protected $allowedFields    = ['id', 'kode', 'nama', 'pemilik', 'petugas', 'created_at', 'updated_at', 'deleted_at'];
}

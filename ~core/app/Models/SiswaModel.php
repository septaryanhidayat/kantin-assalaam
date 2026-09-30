<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
    protected $allowedFields    = ['id', 'kode', 'pin', 'nis', 'password', 'nama', 'kelas', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'whatsapp', 'foto', 'qrcode', 'created_at', 'updated_at', 'deleted_at'];
}

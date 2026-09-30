<?php

namespace App\Models;

use CodeIgniter\Model;

class Landing_galleryModel extends Model
{
    protected $table            = 'landing_gallery';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6'];
}

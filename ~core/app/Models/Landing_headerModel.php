<?php

namespace App\Models;

use CodeIgniter\Model;

class Landing_headerModel extends Model
{
    protected $table            = 'landing_header';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'logo', 'hero_text', 'helo_image'];
}

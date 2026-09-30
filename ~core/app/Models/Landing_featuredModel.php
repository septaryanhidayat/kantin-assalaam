<?php

namespace App\Models;

use CodeIgniter\Model;

class Landing_featuredModel extends Model
{
    protected $table            = 'landing_featured';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'text1', 'text2', 'text3', 'text4'];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class Landing_footerModel extends Model
{
    protected $table            = 'landing_footer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'logo_footer', 'nama_sekolah', 'copyright', 'link_facebook', 'link_linkedin', 'link_twitter', 'link_instagram'];
}

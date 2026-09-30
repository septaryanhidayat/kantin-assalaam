<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaksi_detailModel extends Model
{
    protected $table            = 'transaksi_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'id_transaksi', 'id_barang', 'modal', 'harga', 'jumlah'];
}

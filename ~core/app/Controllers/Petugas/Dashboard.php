<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_in') == null && session()->get('level_kantin') == false) {
            return redirect()->to(base_url('login'));
        }

        $kantin = $this->kantin->where('petugas', session()->get('id'))->first();
        $id_kantin = $kantin->id;
        $nama_kantin = $kantin->nama;

        $trx = $this->transaksi->select('count(id) as trx')->like('updated_at', date("Y-m-d") . '%')->where(['id_kantin' => $id_kantin, 'status' => 1])->first();
        $modal = $this->transaksi->select('sum(modal) as modal')->like('updated_at', date("Y-m-d") . '%')->where('id_kantin', $id_kantin)->first();
        $total = $this->transaksi->select('sum(total) as total')->like('updated_at', date("Y-m-d") . '%')->where('id_kantin', $id_kantin)->first();
        $laba = $total->total - $modal->modal;

        $data = [
            'title'   => 'Dashboard Petugas',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'trx'     => $trx->trx,
            'modal'   => $modal->modal,
            'total'   => $total->total,
            'laba'    => $laba,
            'id_kantin' => $id_kantin,
            'nama_kantin' => $nama_kantin,
        ];

        return view('petugas/dashboard/index', $data);
    }
}

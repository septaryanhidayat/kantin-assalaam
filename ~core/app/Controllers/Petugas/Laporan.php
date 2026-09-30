<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;

class Laporan extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_in') == null && session()->get('level_kantin') == false) {
            return redirect()->to(base_url('login'));
        }

        $kantin = $this->kantin->where('petugas', session()->get('id'))->first();
        $id_kantin = $kantin ? $kantin->id : 0;

        $start = $this->request->getGet('start');
        $end   = $this->request->getGet('end');

        if (!empty($start) && !empty($end)) {
            $s = $start;
            $e = $end . ' 23:59:59';
            $db = db_connect();
            $t = $db->table('transaksi')
                ->where('updated_at >=', $s)
                ->where('updated_at <=', $e)
                ->where('lunas', '1')
                ->where('id_kantin', $id_kantin)
                ->get()->getResult();
        } else {
            $t = '';
        }

        $data = [
            'title'     => 'Laporan Transaksi',
            'session'   => session()->get(),
            'segment'   => $this->request->uri->getSegments(),
            'admin'     => $this->admin->find(session()->get('id')),
            'transaksi' => $t,
        ];

        return view('petugas/laporan/index', $data);
    }

    public function riwayat()
    {
        if (session()->get('logged_in') == null && session()->get('level_kantin') == false) {
            return redirect()->to(base_url('login'));
        }

        $kantin = $this->kantin->where('petugas', session()->get('id'))->first();
        $id_kantin = $kantin ? $kantin->id : 0;
        $db = db_connect();
        $t = $db->table('transaksi')
            ->where('lunas', '1')
            ->where('id_kantin', $id_kantin)
            ->get()->getResult();
        $data = [
            'title'     => 'Riwayat Transaksi',
            'session'   => session()->get(),
            'segment'   => $this->request->uri->getSegments(),
            'admin'     => $this->admin->find(session()->get('id')),
            'transaksi' => $t,
        ];

        return view('petugas/laporan/riwayat', $data);
    }
}

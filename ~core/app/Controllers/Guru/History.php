<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class History extends BaseController
{


    public function index()
    {
        if (session()->get('logged_guru') == null) {
            return redirect()->to(base_url('login'));
        }

        $where = "id_guru=" . session()->get('id') . " AND status=0 OR status=1";

        $data = [
            'title'   => 'Riwayat Deposit',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'setting' => $this->setting->find(1),
            'user'    => $this->guru->find(session()->get('id')),
            'deposit' => $this->deposit->where(['id_guru' => session()->get('id'), 'status' => 2])->orderBy('id', 'desc')->findAll(),
        ];

        return view('guru/history/index', $data);
    }

    public function transaksi()
    {
        if (session()->get('logged_guru') == null) {
            return redirect()->to(base_url('login'));
        }

        $guru = $this->guru->find(session()->get('id'));


        $data = [
            'title'     => 'Riwayat Transaksi',
            'session'   => session()->get(),
            'segment'   => $this->request->uri->getSegments(),
            'setting'   => $this->setting->find(1),
            'user'      => $this->guru->find(session()->get('id')),
            'transaksi' => $this->transaksi->where(['id_guru' => session()->get('id'), 'status' => 1])->orderBy('id', 'desc')->findAll(20),
        ];

        return view('guru/history/transaksi', $data);
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

class Setting extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Setting',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'setting' => $this->setting->find(1),
        ];

        return view('admin/setting/index', $data);
    }

    public function save()
    {

        $post = [
            'id'            => 1,
            'teks_transfer' => $this->request->getVar('teks_transfer'),
            'kop_kartu'     => $this->request->getVar('kop_kartu'),
        ];

        if ($this->setting->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

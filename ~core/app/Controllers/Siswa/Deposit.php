<?php

namespace App\Controllers\Ortu;

use App\Controllers\BaseController;

class Deposit extends BaseController
{

    public function index()
    {
        $where = "id_ortu=" . session()->get('id') . " AND status=0 OR status=1";
        $data = [
            'title'   => 'Dashboard Ortu',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'setting' => $this->setting->find(1),
            'deposit' => $this->deposit->where($where)->first(),
            'user'    => $this->ortu->find(session()->get('id')),
        ];
        return view('ortu/dashboard/deposit', $data);
    }

    public function deposit_proses()
    {
        if (session()->get('logged_ortu') == null) {
            return redirect()->to(base_url('login'));
        }

        $post = [
            'id_ortu' => session()->get('id'),
            'jumlah'  => $this->request->getVar('jumlah'),
            'status'  => 0
        ];

        if ($this->deposit->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            return redirect()->to(base_url('ortu/dashboard#!/deposit'));
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(base_url('ortu/dashboard#!/deposit'));
        }
    }

    public function batal($id)
    {
        if ($this->deposit->delete($id, true)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            return redirect()->to(base_url('ortu/dashboard#!/deposit'));
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(base_url('ortu/dashboard#!/deposit'));
        }
    }

    public function konfirmasi($id)
    {
        $validateImg = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png,image/gif]',
                'max_size[file,8096]',
            ]
        ]);

        if (!$validateImg) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal upload foto data.', 'type' => 'warning']);
            return redirect()->to(base_url('ortu/dashboard#!/deposit'));
        } else {
            $x_file = $this->request->getFile('file');
            $fname = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(512, 512, true, 'height')
                ->save('assets/client/uploads/' . $fname);
            $post = [
                'id'             => $id,
                'bukti_transfer' => $fname,
                'status'         => 1,
            ];
            if ($this->deposit->save($post) === false) {
                session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
                return redirect()->to(base_url('ortu/dashboard#!/deposit'));
            } else {
                session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal upload foto data.', 'type' => 'warning']);
                return redirect()->to(base_url('ortu/dashboard#!/deposit'));
            }
        }
    }
}

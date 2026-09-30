<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_guru') == null) {
            return redirect()->to(base_url('login'));
        }

        $where = "id_guru=" . session()->get('id') . " AND status=0 OR status=1";

        $data = [
            'title'      => 'Dashboard Guru',
            'session'    => session()->get(),
            'segment'    => $this->request->uri->getSegments(),
            'setting'    => $this->setting->find(1),
            'deposit'    => $this->deposit->where($where)->first(),
            'user'       => $this->guru->find(session()->get('id')),
            'notifikasi' => $this->notifikasi->where('id_guru', session()->get('id'))->orderBy('id', 'desc')->findAll(20),
        ];

        return view('guru/dashboard/index', $data);
    }

    public function deposit()
    {
        if (session()->get('logged_guru') == null) {
            return redirect()->to(base_url('login'));
        }

        $post = [
            'id_ortu' => session()->get('id'),
            'jumlah'  => (int) filter_var($this->request->getVar('jumlah'), FILTER_SANITIZE_NUMBER_INT),
            'status'  => 0
        ];

        if ($this->deposit->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            session()->setFlashData('aktif', 'deposit');
            return redirect()->to(base_url('ortu/dashboard#tab-3'));
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function batal($id)
    {
        if ($this->deposit->delete($id, true)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Deposit di batalkan.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
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
            return redirect()->to(session()->get()['_ci_previous_url']);
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
                'bank'           => $this->request->getVar('bank'),
                'status'         => 1,
            ];
            if ($this->deposit->save($post) === false) {
                session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
                return redirect()->to(session()->get()['_ci_previous_url']);
            } else {
                session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal upload foto data.', 'type' => 'warning']);
                return redirect()->to(session()->get()['_ci_previous_url']);
            }
        }
    }
}

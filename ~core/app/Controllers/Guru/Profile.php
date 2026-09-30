<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Profile extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_guru') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Profile',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'user'    => $this->guru->find(session()->get('id')),
        ];

        return view('guru/profile/index', $data);
    }

    public function save()
    {
        $rules = [
            'whatsapp' => [
                'rules' => 'is_unique[guru.whatsapp,id,{id}]',
                'errors' => [
                    'is_unique' => 'Nomor WhatsApp sudah terdaftar',
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $post = [
                'id'       => $this->request->getVar('id'),
                'nama'     => $this->request->getVar('nama'),
                'pin'     => $this->request->getVar('pin'),
                'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
            ];


            if ($this->guru->save($post)) {
                session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
                return redirect()->to(session()->get()['_ci_previous_url']);
            } else {
                session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
                return redirect()->to(session()->get()['_ci_previous_url']);
            }
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'GAGAL', 'message' => $this->validator->getErrors(), 'type' => 'error']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function password()
    {
        if (session()->get('logged_guru') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Ubah Password',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'user'    => $this->guru->find(session()->get('id')),
        ];

        return view('guru/profile/password', $data);
    }

    public function save_password()
    {
        $post = [
            'id'       => session()->get('id'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
        ];

        if ($this->guru->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Password berhasil di ubah.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
    public function kartu()
    {
        if (session()->get('logged_guru') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Kartu Kantin Guru/Karyawan',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'guru'    => $this->guru->find(session()->get('id')),
        ];

        return view('guru/profile/kartu', $data);
    }
}

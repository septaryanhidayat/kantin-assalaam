<?php

namespace App\Controllers\Ortu;

use App\Controllers\BaseController;

class Profile extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_ortu') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Profile',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'user'    => $this->ortu->find(session()->get('id')),
        ];

        return view('ortu/profile/index', $data);
    }

    public function save()
    {
        $rules = [
            'nik' => [
                'rules' => 'is_unique[ortu.nik,id,{id}]',
                'errors' => [
                    'is_unique' => 'Nomor WhatsApp sudah terdaftar',
                ]
            ],
            'whatsapp' => [
                'rules' => 'is_unique[ortu.whatsapp,id,{id}]',
                'errors' => [
                    'is_unique' => 'Nomor WhatsApp sudah terdaftar',
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $post = [
                'id'       => $this->request->getVar('id'),
                'nik'      => $this->request->getVar('nik'),
                'nama'     => $this->request->getVar('nama'),
                'alamat'   => $this->request->getVar('alamat'),
                'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
            ];


            if ($this->ortu->save($post)) {
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
        if (session()->get('logged_ortu') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Ubah Password',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'user'    => $this->ortu->find(session()->get('id')),
        ];

        return view('ortu/profile/password', $data);
    }

    public function save_password()
    {
        $post = [
            'id'       => session()->get('id'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
        ];

        if ($this->ortu->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Password berhasil di ubah.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

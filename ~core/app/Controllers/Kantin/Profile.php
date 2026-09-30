<?php

namespace App\Controllers\Kantin;

use App\Controllers\BaseController;

class Profile extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Profile',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'user'    => $this->admin->find(session()->get('id')),
        ];

        return view('admin/profile/index', $data);
    }

    public function save()
    {
        $rules = [
            'username' => [
                'rules' => 'is_unique[admin.username,id,{id}]',
                'errors' => [
                    'is_unique' => 'Username sudah terdaftar',
                ]
            ],
            'whatsapp' => [
                'rules' => 'is_unique[admin.whatsapp,id,{id}]',
                'errors' => [
                    'is_unique' => 'Nomor WhatsApp sudah terdaftar',
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $post = [
                'id'       => $this->request->getVar('id'),
                'username' => $this->request->getVar('username'),
                'nama'     => $this->request->getVar('nama'),
                'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
            ];

            if ($this->admin->save($post)) {
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
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Ubah Password',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/profile/password', $data);
    }

    public function save_password()
    {
        $post = [
            'id'       => session()->get('id'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
        ];

        if ($this->admin->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Password berhasil di ubah.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

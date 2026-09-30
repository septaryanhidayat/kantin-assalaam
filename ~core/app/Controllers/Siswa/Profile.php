<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;

class Profile extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_siswa') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Profile',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'user'    => $this->siswa->find(session()->get('id')),
        ];

        return view('siswa/profile/index', $data);
    }

    public function save()
    {
        $rules = [
            'whatsapp' => [
                'rules' => 'is_unique[siswa.whatsapp,id,{id}]',
                'errors' => [
                    'is_unique' => 'Nomor WhatsApp sudah terdaftar',
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $post = [
                'id'       => $this->request->getVar('id'),
                'nama'     => $this->request->getVar('nama'),
                'alamat'   => $this->request->getVar('alamat'),
                'pin'      => $this->request->getVar('pin'),
                'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
            ];


            if ($this->siswa->save($post)) {
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
        if (session()->get('logged_siswa') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Ubah Password',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'user'    => $this->siswa->find(session()->get('id')),
        ];

        return view('siswa/profile/password', $data);
    }

    public function save_password()
    {
        $post = [
            'id'       => session()->get('id'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
        ];

        if ($this->siswa->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Password berhasil di ubah.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
    public function kartu()
    {
        if (session()->get('logged_siswa') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Kartu Kantin Siswa',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'siswa'    => $this->siswa->find(session()->get('id')),
        ];

        return view('siswa/profile/kartu', $data);
    }
}

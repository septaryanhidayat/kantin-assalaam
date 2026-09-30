<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

class User extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Daftar User',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/user/index', $data);
    }

    public function data()
    {
        $q = $this->admin->where('deleted_at', null);

        return DataTable::of($q)
            ->add('level', function ($row) {
                if ($row->level == 1) {
                    $l = '<span class="badge bg-success">Administrator</span>';
                }
                if ($row->level == 2) {
                    $l = '<span class="badge bg-primary">Super Admin</span>';
                }
                if ($row->level == 3) {
                    $l = '<span class="badge bg-warning">Petugas Kantin</span>';
                }
                if ($row->level == 4) {
                    $l = '<span class="badge bg-info">Admin Kantin</span>';
                }
                return $l;
            })
            ->add('aksi', function ($row) {
                if ($row->id == 0) {
                    return '<a href="' . base_url('admin/user/edit/' . $row->id) . '" class="btn btn-outline-primary btn-sm">Edit</a>';
                } else {
                    return '<a href="' . base_url('admin/user/edit/' . $row->id) . '" class="btn btn-outline-primary btn-sm">Edit</a> 
                    <a href="' . base_url('admin/user/reset/' . $row->id) . '" class="btn btn-outline-warning btn-sm" onclick="return confirm(\'Password default: 12345. Lanjutkan?\')">Reset Pwd.</a>
                    <a href="' . base_url('admin/user/delete/' . $row->id) . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin?\')">Delete</a>';
                }
            })
            ->addNumbering('no')->toJson(true);
    }

    public function new()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Tambah User',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/user/new', $data);
    }

    public function edit($id)
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Edit User',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'user'    => $this->admin->find($id),
        ];

        return view('admin/user/edit', $data);
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
            if ($this->request->getVar('id') == null) {
                $post = [
                    'username' => $this->request->getVar('username'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'nama'     => $this->request->getVar('nama'),
                    'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                    'level'    => $this->request->getVar('level'),
                ];
            } else {
                $post = [
                    'id'       => $this->request->getVar('id'),
                    'username' => $this->request->getVar('username'),
                    'nama'     => $this->request->getVar('nama'),
                    'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                    'level'    => $this->request->getVar('level'),
                ];
            }

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

    public function reset($id)
    {
        $post = [
            'id'       => $id,
            'password' => password_hash('12345', PASSWORD_BCRYPT),
        ];

        if ($this->admin->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Password di Reset: 12345', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function delete($id)
    {
        if ($this->admin->delete($id)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil di hapus.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menghapus data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

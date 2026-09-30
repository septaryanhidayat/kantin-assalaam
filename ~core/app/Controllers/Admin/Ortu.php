<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

class Ortu extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Daftar Orang Tua',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/ortu/index', $data);
    }

    public function data()
    {
        $q = $this->ortu->select('ortu.id, ortu.kode, ortu.nik, ortu.nama, ortu.alamat, ortu.whatsapp, ortu.deleted_at, siswa.nama as siswa')->where('ortu.deleted_at', null)->join('siswa', 'siswa.id=ortu.id_siswa');

        return DataTable::of($q)
            ->add('aksi', function ($row) {
                return '<a href="' . base_url('admin/ortu/edit/' . $row->id) . '" class="btn btn-outline-primary btn-sm">Edit</a> 
                <a href="' . base_url('admin/ortu/reset/' . $row->id) . '" class="btn btn-outline-warning btn-sm" onclick="return confirm(\'Password default: 12345. Lanjutkan?\')">Reset Pwd.</a>
                <a href="' . base_url('admin/ortu/delete/' . $row->id) . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin?\')">Delete</a>';
            })
            ->addNumbering('no')->toJson(true);
    }

    public function new()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $cek = $this->ortu->orderBy('id', 'desc')->withDeleted()->first();

        if ($cek == null) {
            $kode = 1;
        } else {
            $k = (int) filter_var($cek->kode, FILTER_SANITIZE_NUMBER_INT);
            $kode = $k + 1;
        }

        $data = [
            'title'   => 'Tambah Orang Tua',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'siswa'   => $this->siswa->findAll(),
            'kode'    => $kode
        ];

        return view('admin/ortu/new', $data);
    }

    public function edit($id)
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Edit Orang Tua',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'ortu'    => $this->ortu->find($id),
            'siswa'   => $this->siswa->findAll(),
        ];

        return view('admin/ortu/edit', $data);
    }

    public function save()
    {
        $rules = [
            'kode' => [
                'rules' => 'is_unique[ortu.kode,id,{id}]',
                'errors' => [
                    'is_unique' => 'ID/Kode sudah terdaftar',
                ]
            ],
            'nik' => [
                'rules' => 'is_unique[ortu.nik,id,{id}]',
                'errors' => [
                    'is_unique' => 'NIK sudah terdaftar',
                ]
            ],
            'whatsapp' => [
                'rules' => 'is_unique[ortu.whatsapp,id,{id}]',
                'errors' => [
                    'is_unique' => 'Nomor Whatsapp sudah terdaftar',
                ]
            ],
        ];
        if ($this->validate($rules)) {
            if ($this->request->getVar('id') == null) {
                $post = [
                    'id_siswa' => $this->request->getVar('id_siswa'),
                    'kode'     => $this->request->getVar('kode'),
                    'nik'      => $this->request->getVar('nik'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'nama'     => $this->request->getVar('nama'),
                    'alamat'   => $this->request->getVar('alamat'),
                    'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                ];
            } else {
                $post = [
                    'id'       => $this->request->getVar('id'),
                    'id_siswa' => $this->request->getVar('id_siswa'),
                    'kode'     => $this->request->getVar('kode'),
                    'nik'      => $this->request->getVar('nik'),
                    'nama'     => $this->request->getVar('nama'),
                    'alamat'   => $this->request->getVar('alamat'),
                    'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                ];
            }

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

    public function reset($id)
    {
        $post = [
            'id'       => $id,
            'password' => password_hash('12345', PASSWORD_BCRYPT),
        ];

        if ($this->ortu->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Password di Reset: 12345', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function delete($id)
    {
        if ($this->ortu->delete($id)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil di hapus.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menghapus data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

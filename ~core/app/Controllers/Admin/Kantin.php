<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

class Kantin extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Daftar Kantin',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/kantin/index', $data);
    }

    public function data()
    {
        $q = $this->kantin->select('kantin.id, kantin.kode, kantin.nama, a.nama as pemilik, b.nama as petugas')->where('kantin.deleted_at', null)
            ->join('admin a', 'a.id=kantin.pemilik')
            ->join('admin b', 'b.id=kantin.petugas');

        return DataTable::of($q)
            ->add('kode', function ($row) {
                return kode_kantin($row->kode);
            })
            ->add('aksi', function ($row) {
                return '<a href="' . base_url('admin/kantin/edit/' . $row->id) . '" class="btn btn-outline-primary btn-sm">Edit</a> 
                <a href="' . base_url('admin/kantin/delete/' . $row->id) . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin?\')">Delete</a>';
            })
            ->addNumbering('no')->toJson(true);
    }

    public function new()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $cek = $this->kantin->orderBy('id', 'desc')->withDeleted()->first();

        if ($cek == null) {
            $kode = 1;
        } else {
            $kode = $cek->kode + 1;
        }

        $data = [
            'title'   => 'Tambah Kantin',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'petugas' => $this->admin->where('level', 3)->findAll(),
            'pemilik' => $this->admin->where('level', 4)->findAll(),
            'kode'    => $kode,
        ];

        return view('admin/kantin/new', $data);
    }

    public function edit($id)
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Edit Kantin',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'kantin'  => $this->kantin->find($id),
            'petugas' => $this->admin->where('level', 3)->findAll(),
            'pemilik' => $this->admin->where('level', 4)->findAll(),
        ];

        return view('admin/kantin/edit', $data);
    }

    public function save()
    {
        $rules = [
            'kode' => [
                'rules' => 'is_unique[kantin.kode,id,{id}]',
                'errors' => [
                    'is_unique' => 'Kode Kantin sudah terdaftar',
                ]
            ],
        ];
        if ($this->validate($rules)) {
            if ($this->request->getVar('id') == null) {
                $post = [
                    'kode'    => $this->request->getVar('kode'),
                    'nama'    => $this->request->getVar('nama'),
                    'pemilik' => $this->request->getVar('pemilik'),
                    'petugas' => $this->request->getVar('petugas'),
                ];
            } else {
                $post = [
                    'id'       => $this->request->getVar('id'),
                    'kode'    => $this->request->getVar('kode'),
                    'nama'    => $this->request->getVar('nama'),
                    'pemilik' => $this->request->getVar('pemilik'),
                    'petugas' => $this->request->getVar('petugas'),
                ];
            }

            if ($this->kantin->save($post)) {
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

    public function delete($id)
    {
        if ($this->kantin->delete($id)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil di hapus.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menghapus data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function kartu()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Kartu Kantin Siswa',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'setting' => $this->setting->find(1),
            'admin'   => $this->admin->find(session()->get('id')),
            'siswa'   => $this->siswa->findAll(),
        ];

        return view('admin/kantin/kartu', $data);
    }

    public function kartu_guru()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Kartu Kantin Guru & Karyawan',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'setting' => $this->setting->find(1),
            'admin'   => $this->admin->find(session()->get('id')),
            'guru'    => $this->guru->findAll(),
        ];

        return view('admin/kantin/kartu_guru', $data);
    }
}

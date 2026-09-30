<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Landing extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Header Section',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'header'   => $this->landing_header->find(1),
        ];

        return view('admin/landing/index', $data);
    }

    public function save_header()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $post = [
            'id'         => 1,
            'logo'       => $this->request->getVar('logo'),
            'hero_text'  => $this->request->getVar('hero_text'),
            'hero_image' => $this->request->getVar('hero_image'),
        ];

        if ($this->landing_header->save($post) == true) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function featured()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'    => 'Featured Section',
            'session'  => session()->get(),
            'segment'  => $this->request->uri->getSegments(),
            'admin'    => $this->admin->find(session()->get('id')),
            'featured' => $this->landing_featured->find(1),
        ];

        return view('admin/landing/featured', $data);
    }

    public function save_featured()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $post = [
            'id'    => 1,
            'text1' => $this->request->getVar('text1'),
            'text2' => $this->request->getVar('text2'),
            'text3' => $this->request->getVar('text3')
        ];

        if ($this->landing_featured->save($post) == true) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function kepala()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Kepala Sekolah Section',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'kepala'  => $this->landing_kepala_sekolah->find(1),
        ];

        return view('admin/landing/kepala', $data);
    }

    public function save_kepala()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $post = [
            'id'    => 1,
            'nama' => $this->request->getVar('nama'),
            'foto' => $this->request->getVar('foto'),
            'moto1' => $this->request->getVar('moto1'),
            'moto2' => $this->request->getVar('moto2'),
            'moto3' => $this->request->getVar('moto3'),
            'moto4' => $this->request->getVar('moto4'),
        ];

        if ($this->landing_kepala_sekolah->save($post) == true) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function gallery()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Gallery Section',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'gallery' => $this->landing_gallery->find(1),
        ];

        return view('admin/landing/gallery', $data);
    }

    public function save_gallery()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') == false) {
            return redirect()->to(base_url('login'));
        }

        $post = [
            'id'    => 1,
            'foto1' => $this->request->getVar('foto1'),
            'foto2' => $this->request->getVar('foto2'),
            'foto3' => $this->request->getVar('foto3'),
            'foto4' => $this->request->getVar('foto4'),
            'foto5' => $this->request->getVar('foto5'),
            'foto6' => $this->request->getVar('foto6'),
        ];

        if ($this->landing_gallery->save($post) == true) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

<?php

namespace App\Controllers;

class Login extends BaseController
{
    protected $admin;

    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('login', $data);
    }

    public function proses()
    {
        $cek = $this->admin->where('username', $this->request->getVar('username'))->first();

        if ($cek != null) {
            if (password_verify($this->request->getVar('password'), $cek->password)) {
                if ($cek->level == 1) { //admin
                    $sesi = [
                        'logged_in'     => true,
                        'id'            => $cek->id,
                        'level_admin'   => true,
                        'level_super'   => true,
                        'level_petugas' => true,
                        'level_kantin'  => true,
                    ];

                    session()->set($sesi);
                    return redirect()->to('admin/dashboard');
                } else if ($cek->level == 2) { //admin landingpage
                    $sesi = [
                        'logged_in'     => true,
                        'id'            => $cek->id,
                        'level_admin'   => false,
                        'level_super'   => true,
                        'level_petugas' => false,
                        'level_kantin'  => false,
                    ];

                    session()->set($sesi);
                    return redirect()->to('super/dashboard');
                } else if ($cek->level == 3) { //petugas kantin
                    $sesi = [
                        'logged_in'     => true,
                        'id'            => $cek->id,
                        'level_admin'   => false,
                        'level_super'   => false,
                        'level_petugas' => true,
                        'level_kantin'  => false,
                    ];

                    session()->set($sesi);
                    return redirect()->to('petugas/dashboard');
                } else if ($cek->level == 4) { //kantin
                    $sesi = [
                        'logged_in'     => true,
                        'id'            => $cek->id,
                        'level_admin'   => false,
                        'level_super'   => false,
                        'level_petugas' => false,
                        'level_kantin'  => true,
                    ];

                    session()->set($sesi);
                    return redirect()->to('kantin/dashboard');
                } else {
                    session()->setFlashData(['alert' => true, 'title' => 'GAGAL', 'message' => 'Level Login tidak di ketahui.', 'type' => 'warning']);
                    return redirect()->to(session()->get()['_ci_previous_url']);
                }
            } else {
                session()->setFlashData(['alert' => true, 'title' => 'GAGAL', 'message' => 'Username dan Password tidak cocok.', 'type' => 'warning']);
                return redirect()->to(session()->get()['_ci_previous_url']);
            }
        } else {
            $u = $this->request->getVar('username');
            $guru = $this->guru->where('kode', $u)->first();
            if ($guru != null) {

                if (password_verify($this->request->getVar('password'), $guru->password)) {
                    $sesi = [
                        'logged_guru' => true,
                        'id'          => $guru->id,
                    ];

                    session()->set($sesi);
                    return redirect()->to('guru/dashboard');
                } else {
                    session()->setFlashData(['alert' => true, 'title' => 'GAGAL', 'message' => 'Username tidak ditemuakan.', 'type' => 'warning']);
                    return redirect()->to(session()->get()['_ci_previous_url']);
                }
            } else {
                $u = $this->request->getVar('username');
                $ortu = $this->ortu->where('kode', $u)->first();

                if ($ortu != null) {
                    if (password_verify($this->request->getVar('password'), $ortu->password)) {
                        $sesi = [
                            'logged_ortu' => true,
                            'id'          => $ortu->id,
                        ];

                        session()->set($sesi);
                        return redirect()->to('ortu/dashboard');
                    } else {
                        session()->setFlashData(['alert' => true, 'title' => 'GAGAL', 'message' => 'Username tidak ditemuakan.', 'type' => 'warning']);
                        return redirect()->to(session()->get()['_ci_previous_url']);
                    }
                } else {
                    $u = $this->request->getVar('username');
                    $siswa = $this->siswa->where('kode', $u)->first();
                    // dd(password_hash(1, PASSWORD_BCRYPT));
                    if ($siswa != null) {
                        if (password_verify($this->request->getVar('password'), $siswa->password)) {
                            $sesi = [
                                'logged_siswa' => true,
                                'id'           => $siswa->id,
                            ];

                            session()->set($sesi);
                            return redirect()->to('siswa/dashboard');
                        } else {
                            session()->setFlashData(['alert' => true, 'title' => 'GAGAL', 'message' => 'Username dan Password tidak cocok.', 'type' => 'warning']);
                            return redirect()->to(session()->get()['_ci_previous_url']);
                        }
                    } else {
                        session()->setFlashData(['alert' => true, 'title' => 'GAGAL', 'message' => 'Username tidak ditemuakan.', 'type' => 'warning']);
                        return redirect()->to(session()->get()['_ci_previous_url']);
                    }
                }
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}

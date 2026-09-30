<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

class Deposit extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null && session()->get('level_petugas') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Deposit Aktif',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('petugas/deposit/index', $data);
    }

    public function data()
    {
        $q = $this->deposit
            ->select('deposit.id, deposit.jumlah, deposit.status, deposit.bank, deposit.bukti_transfer, deposit.created_at, ortu.nama as ortu')
            ->join('ortu', 'ortu.id=deposit.id_ortu')
            ->where('deposit.status !=', 2);

        return DataTable::of($q)
            ->add('jumlah', function ($row) {
                return number_format($row->jumlah, 0, ',', '.');
            })
            ->add('status', function ($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge bg-info">Baru, Belum Konfirmasi</span>';
                } else if ($row->status == 1) {
                    $status = '<span class="badge bg-primary">Sudah Konfirmasi</span><br><a href="' . base_url() . '/assets/client/uploads/' . $row->bukti_transfer . '" class="badge bg-info" target="_blank">Lihat bukti transfer</a>';
                }
                return $status;
            })
            ->add('aksi', function ($row) {
                $s = number_format($row->jumlah, 0, ',', '.');
                return '<a href="' . base_url('petugas/deposit/konfirmasi/' . $row->id) . '" class="btn btn-outline-success btn-sm" onclick="return confirm(\'Saldo sebesar ' . $s . ' akan masuk ke akun orang tua. Lanjutkan?\')">Konfirmasi</a>';
            })
            ->addNumbering('no')->toJson(true);
    }

    public function konfirmasi($id)
    {
        $dep = $this->deposit->find($id);
        $ortu = $this->ortu->find($dep->id_ortu);

        $up = [
            'id'    => $ortu->id,
            'saldo' => $ortu->saldo + $dep->jumlah,
        ];

        $up2 = [
            'id'     => $id,
            'status' => 2
        ];

        if ($this->ortu->save($up) && $this->deposit->save($up2)) {
            $post = [
                'id_siswa' => $ortu->id_siswa,
                'id_ortu'  => $ortu->id,
                'pesan'    => 'Saldo kamu berhasil di tambahkan sebesar Rp. ' . number_format($dep->jumlah, 0, ',', '.') . ' pada ' . $ortu->updated_at . '.',
                'jenis'    => 'in'
            ];
            $this->notifikasi->save($post);

            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Deposit sudah di tambahkan ke Akun Orang Tua.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function new()
    {
        if (session()->get('logged_in') == null && session()->get('level_petugas') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Tmbah Deposit',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'ortu'    => $this->ortu->findAll(),
        ];

        return view('petugas/deposit/new', $data);
    }

    public function save()
    {
        $post = [
            'id_ortu' => $this->request->getVar('id_ortu'),
            'jumlah'  => $this->request->getVar('jumlah'),
            'bank'    => $this->request->getVar('bank'),
            'status'  => 2,
        ];

        $ortu = $this->ortu->find($this->request->getVar('id_ortu'));

        $post2 = [
            'id' => $this->request->getVar('id_ortu'),
            'saldo' => $ortu->saldo + $this->request->getVar('jumlah'),
        ];

        if ($this->deposit->save($post) && $this->ortu->save($post2)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Deposit sudah di tambahkan ke Akun Orang Tua.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal, silahkan coba lagi.', 'type' => 'error']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function history()
    {
        if (session()->get('logged_in') == null && session()->get('level_petugas') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Riwayat Deposit',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('petugas/deposit/history', $data);
    }

    public function data_history()
    {
        $q = $this->deposit
            ->select('deposit.id, deposit.jumlah, deposit.status, deposit.bank, deposit.bukti_transfer, deposit.created_at, ortu.nama as ortu')
            ->join('ortu', 'ortu.id=deposit.id_ortu')
            ->where('deposit.status', 2);

        return DataTable::of($q)
            ->add('jumlah', function ($row) {
                return number_format($row->jumlah, 0, ',', '.');
            })
            ->add('status', function ($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge bg-info">Baru, Belum Konfirmasi</span>';
                } else if ($row->status == 1) {
                    if ($row->bank == 'Manual') {
                        $status = '<span class="badge bg-primary">Selesai</span><br><a href="#" class="badge bg-success">Manual, tidak perlu bukti</a>';
                    } else {
                        $status = '<span class="badge bg-primary">Selesai</span><br><a href="' . base_url() . '/assets/client/uploads/' . $row->bukti_transfer . '" class="badge bg-info" target="_blank">Lihat bukti transfer</a>';
                    }
                } else if ($row->status == 2) {
                    if ($row->bank == 'Manual') {
                        $status = '<span class="badge bg-primary">Selesai</span><br><a href="#" class="badge bg-success">Manual, tidak perlu bukti</a>';
                    } else {
                        $status = '<span class="badge bg-primary">Selesai</span><br><a href="' . base_url() . '/assets/client/uploads/' . $row->bukti_transfer . '" class="badge bg-info" target="_blank">Lihat bukti transfer</a>';
                    }
                }
                return $status;
            })
            // ->add('aksi', function ($row) {
            //     $s = number_format($row->jumlah, 0, ',', '.');
            //     return '<a href="' . base_url('petugas/deposit/konfirmasi/' . $row->id) . '" class="btn btn-outline-success btn-sm" onclick="return confirm(\'Saldo sebesar ' . $s . ' akan masuk ke akun orang tua. Lanjutkan?\')">Konfirmasi</a>';
            // })
            ->addNumbering('no')->toJson(true);
    }
}

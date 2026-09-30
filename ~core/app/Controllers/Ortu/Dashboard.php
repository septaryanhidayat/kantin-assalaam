<?php

namespace App\Controllers\Ortu;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_ortu') == null) {
            return redirect()->to(base_url('login'));
        }

        $id_ortu = session()->get('id');
        $ortu = $this->ortu->find($id_ortu);

        // Perbaikan operator logika (status 0 atau status 1 milik ortu ini)
        $where = "id_ortu=" . (int)$id_ortu . " AND (status=0 OR status=1)";

        // Hitung total belanja bulan berjalan (anak dari ortu ini)
        $db = \Config\Database::connect();
        $total_bulan_ini = $db->table('transaksi')
            ->select("COUNT(id) as jml_transaksi, COALESCE(SUM(total), 0) as total_belanja")
            ->where('id_siswa', $ortu->id_siswa)
            ->where('status', 1)
            ->where('lunas', 1)
            ->where('MONTH(updated_at)', date('m'))
            ->where('YEAR(updated_at)', date('Y'))
            ->get()->getRow();

        // Rekap belanja bulanan (keseluruhan per bulan)
        $rekap_bulanan = $db->table('transaksi')
            ->select("DATE_FORMAT(updated_at, '%Y-%m') as periode, YEAR(updated_at) as tahun, MONTH(updated_at) as bulan, COUNT(id) as jml_transaksi, SUM(total) as total_belanja")
            ->where('id_siswa', $ortu->id_siswa)
            ->where('status', 1)
            ->where('lunas', 1)
            ->groupBy("DATE_FORMAT(updated_at, '%Y-%m')")
            ->orderBy('periode', 'DESC')
            ->get()->getResult();

        $siswa = !empty($ortu->id_siswa) ? $this->siswa->find($ortu->id_siswa) : null;

        $data = [
            'title'           => 'Dashboard Ortu',
            'session'         => session()->get(),
            'segment'         => $this->request->uri->getSegments(),
            'setting'         => $this->setting->find(1),
            'deposit'         => $this->deposit->where($where)->first(),
            'user'            => $ortu,
            'siswa'           => $siswa,
            'notifikasi'      => $this->notifikasi->where('id_ortu', $id_ortu)->orderBy('id', 'desc')->findAll(20),
            'total_bulan_ini' => $total_bulan_ini,
            'rekap_bulanan'   => $rekap_bulanan,
        ];

        return view('ortu/dashboard/index', $data);
    }

    public function deposit()
    {
        if (session()->get('logged_ortu') == null) {
            return redirect()->to(base_url('login'));
        }

        $post = [
            'id_ortu' => session()->get('id'),
            'jumlah'  => (int) filter_var($this->request->getVar('jumlah'), FILTER_SANITIZE_NUMBER_INT),
            'status'  => 0
        ];

        if ($this->deposit->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
            session()->setFlashData('aktif', 'deposit');
            return redirect()->to(base_url('ortu/dashboard#tab-3'));
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menambahkan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function batal($id)
    {
        if ($this->deposit->delete($id, true)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Deposit di batalkan.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function konfirmasi($id)
    {
        $validateImg = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png,image/gif]',
                'max_size[file,8096]',
            ]
        ]);

        if (!$validateImg) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal upload foto data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            $x_file = $this->request->getFile('file');
            $fname = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(512, 512, true, 'height')
                ->save('assets/client/uploads/' . $fname);
            $post = [
                'id'             => $id,
                'bukti_transfer' => $fname,
                'bank'           => $this->request->getVar('bank'),
                'status'         => 1,
            ];
            if ($this->deposit->save($post) === false) {
                session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil disimpan.', 'type' => 'success']);
                return redirect()->to(session()->get()['_ci_previous_url']);
            } else {
                session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal upload foto data.', 'type' => 'warning']);
                return redirect()->to(session()->get()['_ci_previous_url']);
            }
        }
    }
}

<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{

    protected $admin;

    public function index()
    {
        if (session()->get('logged_siswa') == null) {
            return redirect()->to(base_url('login'));
        }

        $id_siswa = session()->get('id');
        $siswa = $this->siswa->select('siswa.*, ortu.saldo')->where('siswa.id', $id_siswa)->join('ortu', 'siswa.id=ortu.id_siswa', 'left')->first();
        $ortu = $this->ortu->where('id_siswa', $id_siswa)->first();

        // Cari deposit aktif milik ortu dari siswa ini
        $where = $ortu ? "id_ortu=" . (int)$ortu->id . " AND (status=0 OR status=1)" : "1=0";

        $db = \Config\Database::connect();
        // Total belanja bulan berjalan untuk siswa ini
        $total_bulan_ini = $db->table('transaksi')
            ->select("COUNT(id) as jml_transaksi, COALESCE(SUM(total), 0) as total_belanja")
            ->where('id_siswa', $id_siswa)
            ->where('status', 1)
            ->where('lunas', 1)
            ->where('MONTH(updated_at)', date('m'))
            ->where('YEAR(updated_at)', date('Y'))
            ->get()->getRow();

        // Rekap belanja bulanan (keseluruhan per bulan)
        $rekap_bulanan = $db->table('transaksi')
            ->select("DATE_FORMAT(updated_at, '%Y-%m') as periode, YEAR(updated_at) as tahun, MONTH(updated_at) as bulan, COUNT(id) as jml_transaksi, SUM(total) as total_belanja")
            ->where('id_siswa', $id_siswa)
            ->where('status', 1)
            ->where('lunas', 1)
            ->groupBy("DATE_FORMAT(updated_at, '%Y-%m')")
            ->orderBy('periode', 'DESC')
            ->get()->getResult();

        $data = [
            'title'           => 'Dashboard Siswa',
            'session'         => session()->get(),
            'segment'         => $this->request->uri->getSegments(),
            'setting'         => $this->setting->find(1),
            'deposit'         => $this->deposit->where($where)->first(),
            'user'            => $siswa,
            'notifikasi'      => $this->notifikasi->where('id_siswa', $id_siswa)->orderBy('id', 'desc')->findAll(20),
            'total_bulan_ini' => $total_bulan_ini,
            'rekap_bulanan'   => $rekap_bulanan,
        ];

        return view('siswa/dashboard/index', $data);
    }
}

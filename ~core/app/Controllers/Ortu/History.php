<?php

namespace App\Controllers\Ortu;

use App\Controllers\BaseController;

class History extends BaseController
{


    public function index()
    {
        if (session()->get('logged_ortu') == null) {
            return redirect()->to(base_url('login'));
        }

        $id_ortu = session()->get('id');
        $where = "id_ortu=" . (int)$id_ortu . " AND (status=0 OR status=1)";

        $data = [
            'title'   => 'Riwayat Deposit',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'setting' => $this->setting->find(1),
            'user'    => $this->ortu->find($id_ortu),
            'deposit' => $this->deposit->where(['id_ortu' => $id_ortu, 'status' => 2])->orderBy('id', 'desc')->findAll(),
        ];

        return view('ortu/history/index', $data);
    }

    public function transaksi()
    {
        if (session()->get('logged_ortu') == null) {
            return redirect()->to(base_url('login'));
        }

        $ortu = $this->ortu->find(session()->get('id'));
        $db = \Config\Database::connect();

        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->transaksi
            ->select('transaksi.*, kantin.nama as nama_kantin')
            ->join('kantin', 'kantin.id=transaksi.id_kantin', 'left')
            ->where(['transaksi.id_siswa' => $ortu->id_siswa, 'transaksi.status' => 1, 'transaksi.lunas' => 1]);

        if (!empty($bulan)) {
            $query->where('MONTH(transaksi.updated_at)', (int)$bulan);
        }
        if (!empty($tahun)) {
            $query->where('YEAR(transaksi.updated_at)', (int)$tahun);
        }

        $transaksi = $query->orderBy('transaksi.id', 'desc')->findAll();

        // Rekapitulasi belanja keseluruhan per bulan
        $rekap_bulanan = $db->table('transaksi')
            ->select("DATE_FORMAT(updated_at, '%Y-%m') as periode, YEAR(updated_at) as tahun, MONTH(updated_at) as bulan, COUNT(id) as jml_transaksi, SUM(total) as total_belanja")
            ->where('id_siswa', $ortu->id_siswa)
            ->where('status', 1)
            ->where('lunas', 1)
            ->groupBy("DATE_FORMAT(updated_at, '%Y-%m')")
            ->orderBy('periode', 'DESC')
            ->get()->getResult();

        // Total belanja bulan berjalan
        $total_bulan_ini = $db->table('transaksi')
            ->select("COUNT(id) as jml_transaksi, COALESCE(SUM(total), 0) as total_belanja")
            ->where('id_siswa', $ortu->id_siswa)
            ->where('status', 1)
            ->where('lunas', 1)
            ->where('MONTH(updated_at)', date('m'))
            ->where('YEAR(updated_at)', date('Y'))
            ->get()->getRow();

        // Total belanja untuk hasil filter
        $total_terfilter = 0;
        foreach ($transaksi as $t) {
            $total_terfilter += $t->total;
        }

        // List tahun untuk opsi dropdown filter
        $list_tahun = $db->table('transaksi')
            ->select("DISTINCT YEAR(updated_at) as tahun")
            ->where('id_siswa', $ortu->id_siswa)
            ->where('status', 1)
            ->orderBy('tahun', 'DESC')
            ->get()->getResult();

        $data = [
            'title'           => 'Riwayat Transaksi',
            'session'         => session()->get(),
            'segment'         => $this->request->uri->getSegments(),
            'setting'         => $this->setting->find(1),
            'user'            => $ortu,
            'transaksi'       => $transaksi,
            'rekap_bulanan'   => $rekap_bulanan,
            'total_bulan_ini' => $total_bulan_ini,
            'total_terfilter' => $total_terfilter,
            'filter_bulan'    => $bulan,
            'filter_tahun'    => $tahun,
            'list_tahun'      => $list_tahun,
        ];

        return view('ortu/history/transaksi', $data);
    }
}

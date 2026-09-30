<?php

namespace App\Controllers\Kantin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Barang extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null && session()->get('level_kantin') == false) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Daftar Makanan & Minuman',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('kantin/barang/index', $data);
    }

    public function data()
    {
        if (session()->get('level_admin') == true) {
            $q = $this->barang
                ->select('barang.id, barang.kode, barang.nama, barang.modal, barang.harga, barang.stok, barang.terjual, barang.foto, kantin.nama as kantin')
                ->join('kantin', 'kantin.id=barang.id_kantin')
                ->where('barang.deleted_at', null);
        } else {
            $q = $this->barang
                ->select('barang.id, barang.kode, barang.nama, barang.modal, barang.harga, barang.stok, barang.terjual, barang.foto, kantin.nama as kantin')
                ->join('kantin', 'kantin.id=barang.id_kantin')
                ->where(['kantin.pemilik' => session()->get('id'), 'barang.deleted_at' => null]);
        }

        return DataTable::of($q)
            ->add('foto', function ($row) {
                return '<img src="' . base_url('assets/food/' . $row->foto) . '" width="70">';
            })
            ->add('modal', function ($row) {
                return number_format($row->modal, '0', ',', '.');
            })
            ->add('harga', function ($row) {
                return number_format($row->harga, '0', ',', '.');
            })
            ->add('aksi', function ($row) {
                return '<a href="' . base_url('kantin/barang/edit/' . $row->id) . '" class="btn btn-outline-primary btn-sm">Edit</a> 
                <a href="' . base_url('kantin/barang/delete/' . $row->id) . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin?\')">Delete</a>';
            })
            ->addNumbering('no')->toJson(true);
    }

    public function new()
    {
        if (session()->get('logged_in') == null && session()->get('level_kantin') == false) {
            return redirect()->to(base_url('login'));
        }

        if (session()->get('level_admin') == true) {
            $kantin = $this->kantin->findAll();
        } else {
            $kantin = $this->kantin->where('pemilik', session()->get('id'))->findAll();
        }

        $data = [
            'title'   => 'Tambah Makanan & Minuman',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'kantin'  => $kantin,
        ];

        return view('kantin/barang/new', $data);
    }

    public function edit($id)
    {
        if (session()->get('logged_in') == null && session()->get('level_kantin') == false) {
            return redirect()->to(base_url('login'));
        }

        if (session()->get('level_admin') == true) {
            $kantin = $this->kantin->findAll();
        } else {
            $kantin = $this->kantin->where('pemilik', session()->get('id'))->findAll();
        }

        $data = [
            'title'   => 'Edit Makanan & Minuman',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'kantin'  => $kantin,
            'barang'  => $this->barang->find($id),
        ];

        return view('kantin/barang/edit', $data);
    }

    public function save()
    {
        if ($this->request->getFile('foto')->getSize() > 0) {
            $rules = [
                'kode' => [
                    'rules' => 'is_unique[barang.kode,id,{id}]',
                    'errors' => [
                        'is_unique' => 'Kode Barang sudah terdaftar',
                    ]
                ],
                'foto' => [
                    'mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
                    'max_size[foto,10000]',
                ]
            ];
        } else {
            $rules = [
                'kode' => [
                    'rules' => 'is_unique[barang.kode,id,{id}]',
                    'errors' => [
                        'is_unique' => 'Kode Barang sudah terdaftar',
                    ]
                ],
            ];
        }

        if ($this->validate($rules)) {
            if ($this->request->getFile('foto')->getSize() > 0) {
                $imgPath = $this->request->getFile('foto');
                $foto = $imgPath->getRandomName();
                // Image manipulation
                $image = \Config\Services::image()
                    ->withFile($imgPath)
                    ->resize(512, 512, true, 'height')
                    ->save(FCPATH . '/assets/food/' . $foto);
            }

            if ($this->request->getVar('id') == null) {
                $post = [
                    'id_kantin' => $this->request->getVar('id_kantin'),
                    'kode'      => $this->request->getVar('kode'),
                    'nama'      => $this->request->getVar('nama'),
                    'modal'     => $this->request->getVar('modal'),
                    'harga'     => $this->request->getVar('harga'),
                    'stok'      => $this->request->getVar('stok'),
                    'terjual'   => 0,
                    'foto'      => (empty($foto)) ? 'food.png' : $foto,
                ];
            } else {
                if ($this->request->getFile('foto')->getSize() > 0) {
                    $post = [
                        'id'        => $this->request->getVar('id'),
                        'id_kantin' => $this->request->getVar('id_kantin'),
                        'kode'      => $this->request->getVar('kode'),
                        'nama'      => $this->request->getVar('nama'),
                        'modal'     => $this->request->getVar('modal'),
                        'harga'     => $this->request->getVar('harga'),
                        'stok'      => $this->request->getVar('stok'),
                        'foto'      => $foto,
                    ];
                } else {
                    $post = [
                        'id'        => $this->request->getVar('id'),
                        'id_kantin' => $this->request->getVar('id_kantin'),
                        'kode'      => $this->request->getVar('kode'),
                        'nama'      => $this->request->getVar('nama'),
                        'modal'     => $this->request->getVar('modal'),
                        'harga'     => $this->request->getVar('harga'),
                        'stok'      => $this->request->getVar('stok'),
                    ];
                }
            }

            if ($this->barang->save($post)) {
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
        if ($this->barang->delete($id)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil di hapus.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menghapus data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function import()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Import Data Barang',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('kantin/barang/import', $data);
    }

    public function import_proses()
    {
        $file_excel = $this->request->getFile('file');
        $ext = $file_excel->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }

            $post1 = [
                'id_kantin'     => $row[1],
                'kode'          => $row[2],
                'nama'          => $row[3],
                'modal'         => $row[4],
                'harga'         => $row[5],
                'stok'          => $row[6],
                'terjual'       => $row[7],
            ];
            $this->barang->save($post1);
        }

        return redirect()->to('/kantin/barang');
    }

    public function export()
    {
        $barang = $this->barang->findAll();

        $fileName = 'barang.xlsx';
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'ID KANTIN');
        $sheet->setCellValue('C1', 'KODE');
        $sheet->setCellValue('D1', 'NAMA');
        $sheet->setCellValue('E1', 'HARGA MODAL');
        $sheet->setCellValue('F1', 'HARGA JUAL');
        $sheet->setCellValue('G1', 'STOK');
        $sheet->setCellValue('H1', 'TERJUAL');
        $rows = 2;
        $no = 0;

        foreach ($barang as $val) {

            $no ++;
            $sheet->setCellValue('A' . $rows, $no);
            $sheet->setCellValue('B' . $rows, $val->id_kantin);
            $sheet->setCellValue('C' . $rows, $val->kode);
            $sheet->setCellValue('D' . $rows, $val->nama);
            $sheet->setCellValue('E' . $rows, $val->modal);
            $sheet->setCellValue('F' . $rows, $val->harga);
            $sheet->setCellValue('G' . $rows, $val->stok);
            $sheet->setCellValue('H' . $rows, $val->terjual);
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save("assets/export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect()->to(base_url('/assets/export/' . $fileName));
    }
}

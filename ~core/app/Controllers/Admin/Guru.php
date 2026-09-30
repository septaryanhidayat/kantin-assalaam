<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;

class Guru extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Daftar Guru dan Karyawan',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/guru/index', $data);
    }

    public function data()
    {
        $q = $this->guru->where('deleted_at', null);

        return DataTable::of($q)
            ->add('aksi', function ($row) {
                return '<a href="' . base_url('admin/guru/edit/' . $row->id) . '" class="btn btn-outline-primary btn-sm">Edit</a> 
                <a href="' . base_url('admin/guru/cetak/' . $row->id) . '" class="btn btn-outline-info btn-sm" target="_blank">Cetak Qr</a>
                <a href="' . base_url('admin/guru/reset/' . $row->id) . '" class="btn btn-outline-warning btn-sm" onclick="return confirm(\'Password default: 12345. Lanjutkan?\')">Reset Pwd.</a>
                <a href="' . base_url('admin/guru/delete/' . $row->id) . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin?\')">Delete</a>';
            })
            ->addNumbering('no')->toJson(true);
    }

    public function new()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $cek = $this->guru->orderBy('id', 'desc')->withDeleted()->first();

        if ($cek == null) {
            $kode = 1;
        } else {
            $k = (int) filter_var($cek->kode, FILTER_SANITIZE_NUMBER_INT);
            $kode = $k + 1;
        }

        $data = [
            'title'   => 'Tambah Guru & Karyawan',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'kode'    => $kode
        ];

        return view('admin/guru/new', $data);
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
            'guru'    => $this->guru->find($id),
        ];

        return view('admin/guru/edit', $data);
    }

    public function save()
    {
        if ($this->request->getFile('foto')->getSize() > 0) {
            $rules = [
                'kode' => [
                    'rules' => 'is_unique[guru.kode,id,{id}]',
                    'errors' => [
                        'is_unique' => 'ID/Kode sudah terdaftar',
                    ]
                ],
                'whatsapp' => [
                    'rules' => 'is_unique[guru.whatsapp,id,{id}]',
                    'errors' => [
                        'is_unique' => 'Nomor Whatsapp sudah terdaftar',
                    ]
                ],
                'foto' => [
                    'mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
                    'max_size[foto,10000]',
                ],
            ];
        } else {
            $rules = [
                'kode' => [
                    'rules' => 'is_unique[guru.kode,id,{id}]',
                    'errors' => [
                        'is_unique' => 'ID/Kode sudah terdaftar',
                    ]
                ],
                'whatsapp' => [
                    'rules' => 'is_unique[guru.whatsapp,id,{id}]',
                    'errors' => [
                        'is_unique' => 'Nomor Whatsapp sudah terdaftar',
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
                    ->save(FCPATH . '/assets/client/guru/' . $foto);
            }

            if ($this->request->getVar('id') == null) {
                $qr = $this->request->getVar('kode');

                $post = [
                    'kode'     => $this->request->getVar('kode'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'nama'     => $this->request->getVar('nama'),
                    'jabatan'  => $this->request->getVar('jabatan'),
                    'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                    'foto'     => (empty($foto)) ? 'guru.png' : $foto,
                    'qrcode'   => $qr . '.png',
                ];

                $options = new QROptions([
                    'version'    => 5,
                    'eccLevel'   => QRCode::ECC_L,
                ]);

                $qrcode = new QRCode($options);
                $qrcode->render($qr);
                $qrcode->render($qr, FCPATH . '/assets/qrcode/' . $qr . '.png');
            } else {
                if ($this->request->getFile('foto')->getSize() > 0) {
                    $post = [
                        'id'       => $this->request->getVar('id'),
                        'kode'     => $this->request->getVar('kode'),
                        'nama'     => $this->request->getVar('nama'),
                        'jabatan'  => $this->request->getVar('jabatan'),
                        'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                        'foto'     => $foto
                    ];
                } else {
                    $post = [
                        'id'       => $this->request->getVar('id'),
                        'kode'     => $this->request->getVar('kode'),
                        'nama'     => $this->request->getVar('nama'),
                        'jabatan'  => $this->request->getVar('jabatan'),
                        'whatsapp' => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                    ];
                }
            }

            if ($this->guru->save($post)) {
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

        if ($this->guru->save($post)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Password di Reset: 12345', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menyimpan data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }

    public function import()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Import Data Guru',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/guru/import', $data);
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

            $qr = $row[1];

            $options = new QROptions([
                'version'    => 5,
                'eccLevel'   => QRCode::ECC_L,
            ]);

            $qrcode = new QRCode($options);
            $qrcode->render($qr);
            $qrcode->render($qr, FCPATH . '/assets/qrcode/' . $qr . '.png');

            $post1 = [
                'kode'          => $row[1],
                'password'      => password_hash('12345', PASSWORD_BCRYPT),
                'nama'          => $row[2],
                'jabatan'       => $row[3],
                'whatsapp'      => $row[4],
                'saldo'         => $row[5],
                'qrcode'        => $qr . '.png',
                'foto'          => 'guru.png',
            ];
            $this->guru->save($post1);
        }

        return redirect()->to('/admin/guru');
    }

    public function export()
    {
        $users = $this->guru->findAll();

        $fileName = 'guru-karyawan.xlsx';
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'KODE');
        $sheet->setCellValue('C1', 'NAMA');
        $sheet->setCellValue('D1', 'JABATAN');
        $sheet->setCellValue('E1', 'SISA SALDO');
        $rows = 2;
        $no = 0;

        foreach ($users as $val) {
            if ($val->saldo != '') {
                $s = $val->saldo;
            } else {
                $s = 0;
            }
            $no ++;
            $sheet->setCellValue('A' . $rows, $no);
            $sheet->setCellValue('B' . $rows, $val->kode);
            $sheet->setCellValue('C' . $rows, $val->nama);
            $sheet->setCellValue('D' . $rows, $val->jabatan);
            $sheet->setCellValue('E' . $rows, $s);
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save("assets/export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect()->to(base_url('/assets/export/' . $fileName));
    }

    public function cetak($id)
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Cetak QrCode',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'guru'    => $this->guru->find($id),
        ];

        return view('admin/guru/cetak', $data);
    }

    public function delete($id)
    {
        if ($this->guru->delete($id)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil di hapus.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menghapus data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

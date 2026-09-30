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

class Siswa extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Daftar User',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/siswa/index', $data);
    }

    public function data()
    {
        $q = $this->siswa->select('siswa.id, siswa.kode, siswa.nis, siswa.nama, siswa.kelas, siswa.tempat_lahir, siswa.tanggal_lahir, siswa.alamat, siswa.whatsapp, ortu.saldo')->where('siswa.deleted_at', null)->join('ortu', 'ortu.id_siswa=siswa.id', 'left');

        return DataTable::of($q)
            ->add('aksi', function ($row) {
                return '<a href="' . base_url('admin/siswa/edit/' . $row->id) . '" class="btn btn-outline-primary btn-sm">Edit</a> 
                    <a href="' . base_url('admin/siswa/cetak/' . $row->id) . '" class="btn btn-outline-info btn-sm" target="_blank">Cetak Qr</a>
                    <a href="' . base_url('admin/siswa/reset/' . $row->id) . '" class="btn btn-outline-warning btn-sm" onclick="return confirm(\'Password default: 12345. Lanjutkan?\')">Reset Pwd.</a>
                    <a href="' . base_url('admin/siswa/delete/' . $row->id) . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin?\')">Delete</a>';
            })
            ->addNumbering('no')->toJson(true);
    }

    public function new()
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $cek = $this->siswa->orderBy('id', 'desc')->withDeleted()->first();

        if ($cek == null) {
            $kode = 1;
        } else {
            $k = (int) filter_var($cek->kode, FILTER_SANITIZE_NUMBER_INT);
            $kode = $k + 1;
        }

        $data = [
            'title'   => 'Tambah Siswa',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'kode'    => $kode
        ];

        return view('admin/siswa/new', $data);
    }

    public function edit($id)
    {
        if (session()->get('logged_in') == null) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'   => 'Edit Siswa',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
            'siswa'   => $this->siswa->find($id),
        ];

        return view('admin/siswa/edit', $data);
    }

    public function save()
    {

        // dd($this->request->getFile('foto'));
        if ($this->request->getFile('foto')->getSize() > 0) {
            $rules = [
                'kode' => [
                    'rules' => 'is_unique[siswa.kode,id,{id}]',
                    'errors' => [
                        'is_unique' => 'ID/Kode sudah terdaftar',
                    ]
                ],
                'nis' => [
                    'rules' => 'is_unique[siswa.nis,id,{id}]',
                    'errors' => [
                        'is_unique' => 'NIS sudah terdaftar',
                    ]
                ],
                'whatsapp' => [
                    'rules' => 'is_unique[siswa.whatsapp,id,{id}]',
                    'errors' => [
                        'is_unique' => 'Nomor Whatsapp sudah terdaftar',
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
                    'rules' => 'is_unique[siswa.kode,id,{id}]',
                    'errors' => [
                        'is_unique' => 'ID/Kode sudah terdaftar',
                    ]
                ],
                'nis' => [
                    'rules' => 'is_unique[siswa.nis,id,{id}]',
                    'errors' => [
                        'is_unique' => 'NIS sudah terdaftar',
                    ]
                ],
                'whatsapp' => [
                    'rules' => 'is_unique[siswa.whatsapp,id,{id}]',
                    'errors' => [
                        'is_unique' => 'Nomor Whatsapp sudah terdaftar',
                    ]
                ]
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
                    ->save(FCPATH . '/assets/client/foto/' . $foto);
            }

            if ($this->request->getVar('id') == null) {
                $qr = $this->request->getVar('kode');

                $post = [
                    'kode'          => $this->request->getVar('kode'),
                    'nis'           => $this->request->getVar('nis'),
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'nama'          => $this->request->getVar('nama'),
                    'kelas'         => $this->request->getVar('kelas'),
                    'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                    'alamat'        => $this->request->getVar('alamat'),
                    'whatsapp'      => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                    'foto'          => (empty($foto)) ? 'siswa.png' : $foto,
                    'qrcode'        => $qr . '.png',
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
                        'id'            => $this->request->getVar('id'),
                        'kode'          => $this->request->getVar('kode'),
                        'nis'           => $this->request->getVar('nis'),
                        'nama'          => $this->request->getVar('nama'),
                        'kelas'         => $this->request->getVar('kelas'),
                        'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                        'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                        'alamat'        => $this->request->getVar('alamat'),
                        'whatsapp'      => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                        'foto'          => $foto,
                    ];
                } else {
                    $post = [
                        'id'            => $this->request->getVar('id'),
                        'kode'          => $this->request->getVar('kode'),
                        'nis'           => $this->request->getVar('nis'),
                        'nama'          => $this->request->getVar('nama'),
                        'kelas'         => $this->request->getVar('kelas'),
                        'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                        'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                        'alamat'        => $this->request->getVar('alamat'),
                        'whatsapp'      => ($this->request->getVar('whatsapp') == '') ? null : $this->request->getVar('whatsapp'),
                    ];
                }
            }

            if ($this->siswa->save($post)) {
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

        if ($this->siswa->save($post)) {
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
            'title'   => 'Daftar User',
            'session' => session()->get(),
            'segment' => $this->request->uri->getSegments(),
            'admin'   => $this->admin->find(session()->get('id')),
        ];

        return view('admin/siswa/import', $data);
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
                'nis'           => $row[2],
                'password'      => password_hash($row[3], PASSWORD_BCRYPT),
                'nama'          => $row[4],
                'kelas'         => $row[5],
                'tempat_lahir'  => $row[6],
                'tanggal_lahir' => $row[7],
                'alamat'        => $row[8],
                'whatsapp'      => $row[9],
                'qrcode'        => $qr . '.png',
                'foto'          => 'siswa.png',
            ];

            if ($this->siswa->save($post1) ==  true) {
                $id = $this->siswa->insertID();

                $post2 = [
                    'id_siswa' => $id,
                    'kode'     => $row[10],
                    'nik'      => $row[11],
                    'password' =>  password_hash($row[12], PASSWORD_BCRYPT),
                    'nama'     => $row[13],
                    'alamat'   => $row[14],
                    'whatsapp' => $row[15],
                    'saldo'    => 0,
                ];

                $this->ortu->save($post2);
            }
        }

        return redirect()->to('/admin/siswa');
    }

    public function export()
    {
        $users = $this->siswa->select('siswa.*, ortu.saldo')->join('ortu', 'ortu.id_siswa=siswa.id', 'left')->findAll();

        $fileName = 'siswa.xlsx';
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'NISN');
        $sheet->setCellValue('C1', 'NAMA');
        $sheet->setCellValue('D1', 'SISWA SALDO');
        $rows = 2;

        foreach ($users as $val) {
            if ($val->saldo != '') {
                $s = $val->saldo;
            } else {
                $s = 0;
            }
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->nis);
            $sheet->setCellValue('C' . $rows, $val->nama);
            $sheet->setCellValue('D' . $rows, $s);
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
            'siswa'   => $this->siswa->find($id),
        ];

        return view('admin/siswa/cetak', $data);
    }

    public function delete($id)
    {
        if ($this->siswa->delete($id)) {
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Data berhasil di hapus.', 'type' => 'success']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        } else {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Gagal menghapus data.', 'type' => 'warning']);
            return redirect()->to(session()->get()['_ci_previous_url']);
        }
    }
}

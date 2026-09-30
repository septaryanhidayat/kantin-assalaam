<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<?php $this->endSection() ?>

<?php $this->section('content') ?>

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18"><?= $title ?></h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Aplikasi Kantin</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <input type="date" name="start" class="form-control" require>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end" class="form-control" require>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success" value="Proses">
                    </div>
                </div>

            </form>
            
            <?php if (!empty($_GET['start'])) : ?>
                <hr>
                <button id="btnExport" class="btn btn-primary mb-3" onclick="exportReportToExcel(this)">EXPORT REPORT</button>
                <div id="export-excel">
                <div class="alert alert-primary" role="alert" style="text-align: center;"><b>LAPORAN TRANSAKSI SISWA</b></div>
                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead class="table-light">
                            <th>#</th>
                            <th>Tgl. Transaksi</th>
                            <th>No. Transaksi</th>
                            <th>Nama Siswa</th>
                            <th class="text-end">Total Belanja</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($transaksi)) : ?>
                                <?php $no = 1; ?>
                                <?php $total_siswa = 0; ?>
                                <?php foreach ($transaksi as $t) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $t->updated_at ?></td>
                                        <td><?= nomor_transaksi($t->no_transaksi) ?></td>
                                        <td><?= $t->siswa ?></td>
                                        <td align="right"><?= uang($t->total) ?></td>
                                    </tr>
                                    <?php $total_siswa += $t->total; ?>
                                <?php endforeach ?>
                                <tr class="table-warning">
                                    <td colspan="4">TOTAL TRANSAKSI SISWA</td>
                                    <td align="right"><?= uang($total_siswa) ?></td>
                                </tr>
                            <?php else : ?>

                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-primary" role="alert" style="text-align: center;"><b>LAPORAN TRANSAKSI GURU</b></div>
                <div class="table-responsive">
                    <table id="table2" class="table table-hover" width="100%">
                        <thead class="table-light">
                            <th>#</th>
                            <th>Tgl. Transaksi</th>
                            <th>No. Transaksi</th>
                            <th>Nama Guru / Karyawan</th>
                            <th class="text-end">Total Belanja</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($transaksi2)) : ?>
                                <?php $no = 1; ?>
                                <?php $total_guru = 0; ?>
                                <?php foreach ($transaksi2 as $u) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $u->updated_at ?></td>
                                        <td><?= nomor_transaksi($u->no_transaksi) ?></td>
                                        <td><?= $u->guru ?></td>
                                        <td align="right"><?= uang($u->total) ?></td>
                                    </tr>
                                    <?php $total_guru += $u->total; ?>
                                <?php endforeach ?>
                                <tr class="table-warning">
                                    <td colspan="4">TOTAL TRANSAKSI GURU</td>
                                    <td align="right"><?= uang($total_guru) ?></td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="4">TOTAL SEMUA TRANSAKSI</td>
                                    <td align="right"><?= uang($total_siswa + $total_guru) ?></td>
                                </tr>
                            <?php else : ?>

                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script src="<?= base_url() ?>/assets/js/tableToExcel.js"></script>
<script>
    function exportReportToExcel() {
        var location = 'data:application/vnd.ms-excel;base64,';
        var excelTemplate = '<html> ' +
                            '<head> ' +
                            '<meta http-equiv="content-type" content="text/plain; charset=UTF-8"/> ' +
                            '</head> ' +
                            '<body> ' +
                            document.getElementById("export-excel").innerHTML +
                            '</body> ' +
                            '</html>';
        window.location.href = location + window.btoa(excelTemplate);
    }
</script>
<?php $this->endSection() ?>
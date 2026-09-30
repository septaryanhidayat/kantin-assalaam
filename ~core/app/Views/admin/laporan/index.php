<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<style>
    @media print {
        body {
            background-color: #fff;
        }
    }
</style>
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
                        <select name="ortu" class="form-select">
                            <?php foreach ($ortu as $o) : ?>
                                <option value="<?= $o->id ?>"><?= $o->siswa ?> - <?= $o->nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="tanggal" class="form-control" id="">
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-primary" value="Proses">
                    </div>
                </div>
            </form>
            <hr>
            <a href="#" class="btn btn-primary" onclick="printDiv('cetak')">Cetak</a>
            <hr>
            <div id="cetak">
                <?php if (isset($_GET['tanggal'])) : ?>
                    <h3>Laporan Deposit</h3>
                    <h5><?= $_GET['tanggal'] ?></h5>
                    <div class="table-responsive">
                        <table id="table" class="table table-hover" width="100%">
                            <thead class="table-light">
                                <th>#</th>
                                <th>Tgl. Deposit</th>
                                <th>Nama Orang Tua</th>
                                <th>Jumlah Deposit</th>
                                <th>Status</th>
                                <!-- <th>Aksi</th> -->
                            </thead>
                            <tbody>
                                <?php if ($deposit != 0) : ?>
                                    <?php $no = 1 ?>
                                    <?php foreach ($deposit as $dep) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= format_indo($dep->updated_at) ?></td>
                                            <td><?= $dep->nama ?></td>
                                            <td><?= uang($dep->jumlah) ?></td>
                                            <td>
                                                <?php if ($dep->status == 0) : ?>
                                                    Baru
                                                <?php elseif ($dep->status == 1) : ?>
                                                    Konfirmasi
                                                <?php elseif ($dep->status == 2) : ?>
                                                    Selesai
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5">Tidak ada data.</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
<?php $this->endSection() ?>
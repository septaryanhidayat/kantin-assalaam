<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<style>
    @media print {
        body {
            background-color: #fff;
        }
    }

    .padding {
        border: 1px solid #005206;
        margin: 5px;
        float: left;
        border-radius: 15px;
    }

    .header {
        width: 100%;
        color: #e6ebe0;
        position: absolute;
        z-index: 999;
        text-align: center;
        padding: 10px;
        font-size: 14px;
        font-weight: bold;
    }

    .font {
        height: 300px;
        width: 220px;
        position: relative;
        border-radius: 10px;
    }

    .top {
        height: 30%;
        width: 100%;
        background-color: #005206;
        position: relative;
        z-index: 5;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .bottom {
        height: 70%;
        width: 100%;
        background-color: white;
        position: absolute;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }

    .top img {
        height: 70px;
        width: 70px;
        background-color: #e6ebe0;
        border-radius: 10px;
        position: absolute;
        top: 60px;
        left: 34%;
    }

    .bottom p {
        position: relative;
        top: 50px;
        text-align: center;
        text-transform: capitalize;
        font-weight: bold;
        font-size: 20px;
        text-emphasis: spacing;
        margin: 0;
    }

    .bottom .desi {
        font-size: 12px;
        color: grey;
        font-weight: normal;
        margin: 0;
    }

    .bottom .no {
        font-size: 15px;
        font-weight: normal;
        margin: 0;
    }

    .barcode img {
        height: 100px;
        width: 100px;
        text-align: center;
    }

    .barcode {
        text-align: center;
        position: relative;
        top: 50px;
    }

    .cetak {
        width: 13cm;
        /* height: 9.2cm; */
        margin-bottom: 7px;
        border: 1px solid #fff;
    }

    .kartu {
        width: 6cm;
        height: 9.4cm;
        /* border: 1px solid #000; */
        position: relative;
        margin-right: 3px;
        float: left;
    }

    .kartu .container-foto {
        width: 91px;
        height: 103px;
        position: absolute;
        top: 76px;
        left: 63px;
        /* border: 1px solid #000; */
    }

    .kartu img.foto {
        width: 100px;
        height: 113px;
        object-fit: cover;
        object-position: 100% 10%;
    }

    .info {
        position: absolute;
        top: 215px;
        width: 100%;
    }

    .info .text {
        font-weight: bold;
        text-transform: uppercase;
        color: #000;
        line-height: 13px;
    }

    .info img {
        width: 80px;
    }

    .kartu_belakang {
        width: 6cm;
        height: 9.4cm;
        /* border: 1px solid #000; */
        /* position: absolute; */
        margin-right: 10px;
        left: 210px;
    }

    @media print {
        .break {
            page-break-after: always;
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="#" class="btn btn-primary" onclick="printDiv('qrcode')">Cetak</a>
                    <hr>

                    <div id="qrcode">
                        <?php $no = 1 ?>
                        <?php foreach ($siswa as $s) : ?>
                            <div class="cetak">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="kartu" style="background-image: url(<?= base_url('assets/siswa_depan.png') ?>); background-size: cover; background-repeat: no-repeat">
                                                <div class="container-foto">
                                                    <img class="foto" src="<?= base_url('assets/client/foto/' . $s->foto) ?>" alt="" class="img-fluid">
                                                </div>
                                                <div class="info">
                                                    <center>
                                                        <div class="text"><?= $s->nama ?><br><?= $s->nis ?></div>
                                                        <img src="<?= base_url('assets/qrcode/' . $s->qrcode) ?>">
                                                    </center>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="kartu_belakang" style="background-image: url(<?= base_url('assets/siswa_belakang.png') ?>); background-size: cover;background-repeat: no-repeat"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="clear: both;"></div>
                            <?php
                            for ($x = 1; $x < 100; $x++) {
                                if (is_int($x / 3)) {
                                    if ($no == $x) {
                                        echo '<div class="break"></div>';
                                    }
                                }
                            }
                            $no++;
                            ?>
                        <?php endforeach ?>

                    </div>
                </div>
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
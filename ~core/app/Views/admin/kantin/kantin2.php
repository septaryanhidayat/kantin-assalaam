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

                    <div id="qrcode">
                        <?php foreach ($siswa as $s) : ?>
                            <div class="padding">
                                <div class="font">
                                    <div class="header">
                                        <?= $setting->kop_kartu ?>
                                    </div>
                                    <div class="top">
                                        <img src="<?= base_url('assets/client/foto/' . $s->foto) ?>">
                                    </div>
                                    <div class="bottom">
                                        <p><?= $s->nama ?></p>
                                        <p class="desi"><?= $s->nis ?></p>
                                        <div class="barcode">
                                            <img src="<?= base_url('assets/qrcode/' . $s->qrcode) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <div style="clear:both"></div>
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
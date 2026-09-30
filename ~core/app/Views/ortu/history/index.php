<?php $this->extend('ortu/template'); ?>

<?php $this->section('css') ?>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="page">
    <div class="navbar navbar-page">
        <div class="navbar-inner sliding">
            <div class="left">
                <a onclick="history.back()" class="link back">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </div>
            <div class="title">
                Deposit
            </div>
        </div>
    </div>
    <div class="page-content">
        <!-- deposit -->
        <div class="deposit margin-pages">
            <div class="container">
                <?php foreach ($deposit as $d) : ?>
                    <div class="background-white box-shadow border-radius padding-box-middle">
                        <div class="float-left margin-right-middle">
                            <span class="icon-big icon-color-green">
                                <i class="fa fa-wallet"></i>
                            </span>
                        </div>
                        <div class="overflow-hidden">
                            <span><?= format_indo($d->updated_at) ?></span>
                            <h6 class="margin-bottom-5px">Selamat, Anda berhasil melakukan Deposit Saldo sebesar Rp. <?= number_format($d->jumlah, 0, ',', '.') ?></h6>
                        </div>
                    </div>
                    <div class="separator-small"></div>
                <?php endforeach ?>

                <div class="separator-bottom"></div>
            </div>
        </div>
        <!-- end deposit -->
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<?php $this->endSection() ?>
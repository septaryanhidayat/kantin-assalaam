<?php $this->extend('guru/template'); ?>

<?php $this->section('css') ?>
<style>
.alert {
  padding: 10px;
  background-color: green;
  color: white;
  margin-bottom: 10px;
}
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="page">
    <div class="navbar navbar-page">
        <div class="navbar-inner sliding">
            <div class="left">
                <a href="#" class="link back" onclick="location.href='<?= base_url('guru/dashboard') ?>'">
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
                <?php if (empty($deposit)) : ?>
                    <form method="post" action="<?= base_url() ?>/guru/deposit/proses">
                        <h5 class="text-center margin-bottom-small">Jumlah Rp.</h5>
                        <div class="background-white border-radius box-shadow content">
                            <input type="text" id="tanpa-rupiah" name="jumlah" required style="font-size: 20px; text-align:center">
                        </div>
                        <div class="separator-small"></div>
                        <h5 class="text-center margin-bottom-small">Bayar dengan:</h5>
                        <div class="row margin-bottom">
                            <div class="col">
                                <div class="background-white border-radius box-shadow text-center padding-box border-active">
                                    <span class="icon-big icon-color-red">
                                        <i class="fa fa-university"></i>
                                    </span>
                                    <h6 class="font-weight-600">Petunjuk Transfer</h6>

                                    <?= $setting->teks_transfer ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="buttons buttons-full margin-top-small box-shadow">Proses...</button>
                    </form>
                <?php else : ?>
                    <div class="background-white border-radius box-shadow">
                        <!-- <img class="border-radius-top-left-right float-left margin-bottom-middle" src="images/about-us.jpg" alt=""> -->
                        <div class="padding-box">
                            <?php if ($deposit->status == 1){ ?>
                                    <div class="alert">
                                        <b>Pembayaran kamu sedang diverifikasi dan menunggu persetujuan dari Admin</b>
                                    </div> <?php } ?>
                            <h5 class="margin-bottom-small">Petunjuk Transfer</h5>
                            <?= $setting->teks_transfer ?>
                            <center>
                                <h5 class="margin-bottom-small">Nominal Transfer</h5>
                                <h2><?= uang($deposit->jumlah) ?></h2>
                            </center>
                        </div>
                    </div>
                    <br>
                    <div class="background-white border-radius box-shadow">
                        <div class="padding-box">
                            <h5 class="margin-bottom-small">Konfirmasi Transfer</h5>

                            <form action="<?= base_url('guru/deposit/konfirmasi/' . $deposit->id) ?>" method="post" enctype="multipart/form-data">
                                <p>Pilih Bank Tujuan:</p>
                                <?php
                                if ($deposit->bank != '') {
                                    $bank = $deposit->bank;
                                } else {
                                    $bank = '';
                                }
                                ?>
                                <select name="bank" id="bank">
                                    <option value="BRI" <?= ($bank == 'BRI') ? 'selected' : '' ?>>BRI</option>
                                    <option value="BCA" <?= ($bank == 'BCA') ? 'selected' : '' ?>>BCA</option>
                                    <option value="BNI" <?= ($bank == 'BNI') ? 'selected' : '' ?>>BNI</option>
                                    <option value="Mandiri" <?= ($bank == 'Mandiri') ? 'selected' : '' ?>>Mandiri</option>
                                    <option value="QRIS" <?= ($bank == 'QRIS') ? 'selected' : '' ?>>QRIS</option>
                                </select>
                                <div id="bayarqris" style="display: none;">
                                    <p align="center">Pebayaran Via QRIS scan kode QR dibawah ini:</p>
                                    <img src="<?= base_url('assets/qris.png') ?>" class="img-fluid" alt="">
                                </div>
                                <p>Silahkan lampirkan foto bukti transfer:</p>
                                <input type="file" name="file" id="">
                                <?php if ($deposit->status == 1) : ?>
                                    <img src="<?= base_url('assets/client/uploads/' . $deposit->bukti_transfer) ?>" width="50" alt="">
                                <?php endif ?>
                                <button type="submit" class="buttons buttons-full margin-top-small box-shadow">Konfirmasi Transfer</button>
                            </form>
                        </div>
                    </div>
                    <button onclick="location.href='<?= base_url() ?>/guru/deposit/batal/<?= $deposit->id ?>'" class="buttons buttons-full margin-top-small box-shadow" style="background:red">Batalkan Deposit</button>
                <?php endif ?>
            </div>
        </div>
        <!-- end deposit -->
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script>
    var elem = document.getElementById("tanpa-rupiah");

    elem.addEventListener("keydown", function(event) {
        var key = event.which;
        if ((key < 48 || key > 57) && key != 8) event.preventDefault();
    });

    elem.addEventListener("keyup", function(event) {
        var value = this.value.replace(/,/g, "");
        this.dataset.currentValue = parseInt(value);
        var caret = value.length - 1;
        while ((caret - 3) > -1) {
            caret -= 3;
            value = value.split('');
            value.splice(caret + 1, 0, ",");
            value = value.join('');
        }
        this.value = value;
    });
</script>
<script>
    var pilih = document.getElementById('bank');
    pilih.addEventListener('change', event => {
        if (pilih.value === 'QRIS') {
            document.getElementById('bayarqris').style.display = 'block';
             }
        else {
            document.getElementById('bayarqris').style.display = 'none';
        }
    });
    
</script>
<?php $this->endSection() ?>
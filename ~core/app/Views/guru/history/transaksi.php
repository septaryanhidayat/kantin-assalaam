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
                Riwayat Transaksi
            </div>
        </div>
    </div>
    <div class="page-content">
        <!-- deposit -->
        <div class="deposit margin-pages">
            <div class="container">
                <?php foreach ($transaksi as $t) : ?>
                    <div class="background-white box-shadow border-radius padding-box-middle">

                        <div class="overflow-hidden">
                            <span><?= format_indo($t->updated_at) ?></span>
                            <h6 class="margin-bottom-5px">Transaksi sebesar: Rp. <?= number_format($t->total, 0, ',', '.') ?></h6>
                            <table width="100%" border="0">
                                <tr>
                                    <th></th>
                                    <th>Nama barang</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                                <?php
                                $idt = $t->id;
                                $db = db_connect();
                                $det = $db->query("SELECT transaksi_detail.*, barang.nama, barang.foto FROM transaksi_detail JOIN barang ON barang.id=transaksi_detail.id_barang WHERE id_transaksi='$idt'")->getResult();

                                $total = 0;
                                foreach ($det as $d) {
                                    echo '
                                    <tr>
                                        <td width="50"><img src="' . base_url('assets/food/' . $d->foto) . '" height="20"></td>
                                        <td>' . $d->nama . '</td>
                                        <td  align="center">' . $d->jumlah . '</td>
                                        <td align="center">' . $d->harga . '</td>
                                        <td align="right">' . number_format($d->harga * $d->jumlah, 0, '.', '.') . '</td>
                                    </tr>
                                    ';

                                    $total +=  ($d->harga * $d->jumlah);
                                }
                                ?>
                                <tr>
                                    <td align="center" colspan="4">TOTAL</td>
                                    <td align="right"><?= number_format($total, 0, '.', '.')  ?></td>
                                </tr>
                            </table>
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
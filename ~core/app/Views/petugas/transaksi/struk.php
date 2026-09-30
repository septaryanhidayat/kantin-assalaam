<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<style>
    @media print {
        body {
            font-size: 10px;
            background-color: #fff;
            width: 200px;
            margin: 5px;
            color: #000;
        }
    }

    .keterangan {
        padding: 5px;
        text-align: center;
        border: 1px dashed #ddd;
        margin-top: 20px;
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
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <div id="cetak">
                        <center><b><?= $setting->kop_kartu ?></b></center>
                        <hr>

                        <table width="100%">
                            <tr>
                                <td>No. Transaksi</td>
                                <td align="right"><?= nomor_transaksi($transaksi_aktif->no_transaksi) ?></td>
                            </tr>
                            <tr>
                                <td>Tgl. Transaksi</td>
                                <td align="right"><?= format_indo($transaksi_aktif->updated_at) ?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td align="right"><?= $transaksi_aktif->siswa ?></td>
                            </tr>
                        </table>
                        <hr>
                        <table width="100%">
                            <tr>
                                <th style="border-bottom: 1px dashed #ddd;">Produk</th>
                                <th style="border-bottom: 1px dashed #ddd;">Jml.</th>
                                <th style="border-bottom: 1px dashed #ddd;" class="text-end">Sub Total</th>
                            </tr>
                            <?php $total = 0 ?>
                            <?php foreach ($transaksi_detail as $detail) : ?>
                                <tr>
                                    <td><?= $detail->barang ?></td>
                                    <td width="50">x<?= $detail->jumlah ?></td>
                                    <td align="right" width="70"><?= number_format($detail->jumlah * $detail->harga, 0, ',', '.') ?></td>
                                </tr>
                                <?php $total += ($detail->jumlah * $detail->harga) ?>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="2" style="border-top: 1px dashed #ddd;">TOTAL</td>
                                <td align="right" style="border-top: 1px dashed #ddd;"><?= number_format($total, 0, ',', '.') ?></td>
                            </tr>
                            <?php if (!empty($siswa)) : ?>
                                <tr>
                                    <td colspan="2">SALDO</td>
                                    <td align="right" style="border-bottom: 1px dashed #ddd;"><?= number_format($siswa->saldo, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">SISA SALDO</td>
                                    <td align="right"><?= number_format($siswa->saldo - $total, 0, ',', '.') ?></td>
                                </tr>
                            <?php endif ?>
                        </table>
                        <div class="keterangan">
                            Silahkan cek barang yang anda beli, barang yang sudah di beli tidak dapat di tukarkan lagi.
                            Terima kasih.
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-success mt-3" onclick="printDiv('cetak')">CETAK STRUK</a>
                        <a href="<?= base_url('petugas/dashboard') ?>" class="btn btn-primary">DASHBOARD</a>
                        <a href="<?= base_url('petugas/transaksi/aktif') ?>" class="btn btn-info">TRANSAKSI BARU</a>
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
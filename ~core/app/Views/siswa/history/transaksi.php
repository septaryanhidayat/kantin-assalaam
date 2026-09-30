<?php $this->extend('siswa/template'); ?>

<?php $this->section('css') ?>
<style>
    .rekap-card {
        background: #fff;
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        border-left: 4px solid #3498db;
    }
    .rekap-badge {
        background: #eef2f7;
        color: #333;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    .filter-box {
        background: #fff;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }
    .filter-box select {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 12px;
        background: #fff;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="page">
    <div class="navbar navbar-page">
        <div class="navbar-inner sliding">
            <div class="left">
                <a onclick="location.href='<?= base_url('siswa/dashboard') ?>'" class="link back">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </div>
            <div class="title">
                Riwayat & Total Belanja
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="deposit margin-pages">
            <div class="container">

                <!-- Ringkasan Total Belanja Bulan Ini -->
                <div class="background-white box-shadow border-radius padding-box-middle margin-bottom-small" style="border-top: 4px solid #2ecc71;">
                    <div class="row row-no-margin-bottom">
                        <div class="col-70">
                            <span style="font-size: 11px; color: #777;">Total Belanja Bulan Ini (<?= nama_bulan(date('m')) . ' ' . date('Y') ?>):</span>
                            <h4 style="margin: 4px 0 0 0; color: #27ae60; font-weight: 700;">Rp. <?= number_format($total_bulan_ini->total_belanja ?? 0, 0, ',', '.') ?></h4>
                            <span style="font-size: 11px; color: #888;"><i class="fa fa-shopping-bag"></i> <?= $total_bulan_ini->jml_transaksi ?? 0 ?> Transaksi</span>
                        </div>
                        <div class="col-30 text-right" style="display:flex; align-items:center; justify-content:flex-end;">
                            <span class="icon-big" style="color: #2ecc71; font-size: 32px;"><i class="fa fa-calendar-check"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Rekap Belanja Keseluruhan Tiap Bulan -->
                <div class="margin-bottom-small">
                    <h5 style="margin-bottom: 8px; font-weight: 600; color: #333;"><i class="fa fa-chart-bar" style="color: #3498db;"></i> Rekap Belanja Per Bulan</h5>
                    
                    <?php if (!empty($rekap_bulanan)) : ?>
                        <?php foreach ($rekap_bulanan as $rb) : ?>
                            <?php $is_active = ($filter_bulan == $rb->bulan && $filter_tahun == $rb->tahun); ?>
                            <div class="rekap-card" style="<?= $is_active ? 'border-left-color: #e67e22; background-color: #fffaf4;' : '' ?>">
                                <div class="row row-no-margin-bottom">
                                    <div class="col-65">
                                        <h6 style="margin: 0 0 4px 0; font-weight: 600; color: #2c3e50;">
                                            <i class="fa fa-calendar-alt" style="color: #888;"></i> <?= nama_bulan($rb->bulan) . ' ' . $rb->tahun ?>
                                        </h6>
                                        <span style="font-size: 15px; font-weight: 700; color: #e74c3c;">
                                            Rp. <?= number_format($rb->total_belanja, 0, ',', '.') ?>
                                        </span>
                                    </div>
                                    <div class="col-35 text-right">
                                        <span class="rekap-badge margin-bottom-small"><?= $rb->jml_transaksi ?>x Belanja</span><br>
                                        <a href="javascript:void(0)" class="external buttons" onclick="window.location.href='<?= base_url('siswa/history/transaksi?bulan=' . $rb->bulan . '&tahun=' . $rb->tahun) ?>'; return false;" style="font-size: 10px; padding: 3px 8px; <?= $is_active ? 'background:#e67e22; color:#fff;' : 'background:#3498db; color:#fff;' ?> border-radius: 4px; display: inline-block;">
                                            <?= $is_active ? 'Aktif' : 'Rincian' ?> &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="background-white box-shadow border-radius padding-box-middle text-center">
                            <span style="color: #999; font-size: 12px;">Belum ada data belanja.</span>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Filter Transaksi -->
                <div class="filter-box">
                    <form action="<?= base_url('siswa/history/transaksi') ?>" method="get" class="external">
                        <div class="row">
                            <div class="col-50">
                                <label style="font-size: 11px; color: #666; font-weight: 500;">Filter Bulan:</label>
                                <select name="bulan">
                                    <option value="">-- Semua Bulan --</option>
                                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                                        <option value="<?= $m ?>" <?= ($filter_bulan == $m) ? 'selected' : '' ?>><?= nama_bulan($m) ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                            <div class="col-50">
                                <label style="font-size: 11px; color: #666; font-weight: 500;">Filter Tahun:</label>
                                <select name="tahun">
                                    <option value="">-- Semua Tahun --</option>
                                    <?php foreach ($list_tahun as $lt) : ?>
                                        <option value="<?= $lt->tahun ?>" <?= ($filter_tahun == $lt->tahun) ? 'selected' : '' ?>><?= $lt->tahun ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-small">
                            <div class="col-50">
                                <button type="submit" class="buttons" style="width: 100%; font-size: 11px; padding: 6px 0; background: #3498db; color: #fff; border-radius: 5px;">Terapkan Filter</button>
                            </div>
                            <div class="col-50">
                                <a href="javascript:void(0)" class="external buttons buttons-outline text-center" onclick="window.location.href='<?= base_url('siswa/history/transaksi') ?>'; return false;" style="display: block; width: 100%; font-size: 11px; padding: 5px 0; border-radius: 5px;">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Daftar Rincian Transaksi -->
                <div class="margin-bottom-small">
                    <h5 style="margin-bottom: 6px; font-weight: 600; color: #333;"><i class="fa fa-list" style="color: #e74c3c;"></i> Daftar Rincian Transaksi</h5>
                    <?php if (!empty($filter_bulan) || !empty($filter_tahun)) : ?>
                        <div style="font-size: 11px; color: #555; margin-bottom: 8px; background: #fff3cd; padding: 6px 10px; border-radius: 5px;">
                            Filter: <strong><?= !empty($filter_bulan) ? nama_bulan($filter_bulan) : '' ?> <?= !empty($filter_tahun) ? $filter_tahun : '' ?></strong> | Total: <strong>Rp. <?= number_format($total_terfilter, 0, ',', '.') ?></strong> (<?= count($transaksi) ?> transaksi)
                        </div>
                    <?php endif ?>
                </div>

                <?php if (!empty($transaksi)) : ?>
                    <?php foreach ($transaksi as $t) : ?>
                        <div class="background-white box-shadow border-radius padding-box-middle" style="margin-bottom: 12px;">
                            <div class="overflow-hidden">
                                <div class="row row-no-margin-bottom" style="margin-bottom: 5px;">
                                    <div class="col-60">
                                        <span style="font-size: 11px; color: #888;"><?= format_indo($t->updated_at) ?></span><br>
                                        <span style="font-size: 11px; color: #555;">
                                            <?= !empty($t->nama_kantin) ? '<i class="fa fa-store"></i> <strong>' . $t->nama_kantin . '</strong> &bull; ' : '' ?>
                                            No. Trx: <?= nomor_transaksi($t->no_transaksi) ?>
                                        </span>
                                    </div>
                                    <div class="col-40 text-right">
                                        <h6 style="margin: 0; font-weight: 700; color: #e74c3c;">
                                            Rp. <?= number_format($t->total, 0, ',', '.') ?>
                                        </h6>
                                    </div>
                                </div>
                                <hr style="border: 0; border-top: 1px dashed #eee; margin: 6px 0;">
                                <table width="100%" border="0" style="font-size: 12px;">
                                    <?php
                                    $idt = $t->id;
                                    $db = db_connect();
                                    $det = $db->table('transaksi_detail')
                                        ->select('transaksi_detail.*, barang.nama, barang.foto')
                                        ->join('barang', 'barang.id=transaksi_detail.id_barang')
                                        ->where('id_transaksi', $idt)
                                        ->get()->getResult();

                                    foreach ($det as $d) :
                                    ?>
                                        <tr>
                                            <td width="30">
                                                <img src="<?= base_url('assets/food/' . $d->foto) ?>" height="22" style="border-radius: 4px; object-fit: cover;">
                                            </td>
                                            <td><?= $d->nama ?></td>
                                            <td align="center" width="40"><?= $d->jumlah ?>x</td>
                                            <td align="right" width="70">Rp. <?= number_format($d->harga * $d->jumlah, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </table>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php else : ?>
                    <div class="background-white box-shadow border-radius padding-box-middle text-center">
                        <span style="color: #999; font-size: 12px;">Tidak ada transaksi ditemukan pada periode ini.</span>
                    </div>
                <?php endif ?>

                <div class="separator-bottom"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>

<?php $this->section('js') ?>
<?php $this->endSection() ?>
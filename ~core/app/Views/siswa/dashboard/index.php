<?php $this->extend('siswa/template'); ?>

<?php $this->section('css') ?>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div id="app">
    <div class="view view-main view-init" data-url="/">
        <div class="page page-home page-with-subnavbar">
            <div class="toolbar tabbar tabbar-labels toolbar-bottom">
                <div class="toolbar-inner">
                    <a href="#tab-1" class="tab-link tab-link-active">
                        <i class="fa fa-home"></i>
                        <p>Home</p>
                    </a>
                    <a href="#tab-2" class="tab-link">
                        <i class="fa fa-bell"></i>
                        <p>Notifikasi</p>
                    </a>
                    <a href="#tab-5" class="tab-link">
                        <i class="fas fa-user"></i>
                        <p>Akun Saya</p>
                    </a>
                </div>
            </div>

            <!-- tabs -->
            <div class="tabs-animated-wrap">
                <div class="tabs">

                    <!-- tabs 1 -->
                    <div id="tab-1" class="tab tab-active page-content">

                        <!-- title -->
                        <div class="title-apps padding-middle background-primer">
                            <div class="container">
                                <div class="row row-no-margin-bottom">
                                    <div class="col">
                                        <h3 class="color-white">Kantin Digital</h3>
                                    </div>
                                    <div class="col">
                                        <a href="#tab-2" class="tab-link float-right">
                                            <span class="icon-middle margin-left-small float-right color-white">
                                                <i class="fas fa-bell"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end title -->

                        <!-- profile balance -->
                        <div class="border-radius-style background-circle background-primer">
                            <div class="container">
                                <div class="background-white border-radius padding-box-middle box-shadow">
                                    <div class="row row-no-margin-bottom">
                                        <div class="col-60">
                                            <div class="float-left margin-right-small">
                                                <?php if (!empty($user->foto)) : ?>
                                                    <img class="people" src="<?= base_url('assets/client/foto/' . $user->foto) ?>">
                                                <?php else : ?>
                                                    <img class="people" src="<?= base_url() ?>/assets/client/images/author.jpg" alt="">
                                                <?php endif ?>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h5><?= $user->nama ?></h5>
                                                <p><?= $user->kode ?></p>
                                            </div>
                                        </div>
                                        <div class="col-40">
                                            <button class="buttons float-right letter-spacing margin-top-small">Rp. <?= number_format($user->saldo, '0', '.', ',') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end profile balance -->

                        <!-- card total belanja bulan ini -->
                        <div class="container" style="margin-top: -10px; margin-bottom: 12px;">
                            <div class="background-white border-radius padding-box-middle box-shadow" style="border-left: 4px solid #ff793f;">
                                <div class="row row-no-margin-bottom">
                                    <div class="col-65">
                                        <span class="icon-small" style="color: #ff793f;"><i class="fa fa-shopping-cart"></i></span>
                                        <span style="font-size: 11px; color: #777;">Total Belanja Bulan Ini:</span>
                                        <h5 style="margin: 2px 0 0 0; color: #2d3436; font-weight: 700;">Rp. <?= number_format($total_bulan_ini->total_belanja ?? 0, 0, ',', '.') ?></h5>
                                        <span style="font-size: 10px; color: #888;"><?= $total_bulan_ini->jml_transaksi ?? 0 ?> transaksi (<?= nama_bulan(date('m')) . ' ' . date('Y') ?>)</span>
                                    </div>
                                    <div class="col-35 text-right" style="display: flex; align-items: center; justify-content: flex-end;">
                                        <a href="javascript:void(0)" class="external buttons" onclick="window.location.href='<?= base_url('siswa/history/transaksi') ?>'; return false;" style="font-size: 10px; padding: 5px 8px; background: #ff793f; color: #fff; border-radius: 4px; display: inline-block;">Rekap &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card total belanja bulan ini -->

                        <!-- separator -->
                        <div class="separator"></div>
                        <!-- end separator -->
                        <!-- menus -->
                        <div class="menus">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <a href="" onclick="location.href='<?= base_url('siswa/history/transaksi') ?>'">
                                            <div class="background-white text-center border-radius padding-box box-shadow">
                                                <span class="icon-big icon-color-red"><i class="fas fa-hamburger"></i></span>
                                                <h6 class="font-weight-500">Transaksi</h6>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="" onclick="location.href='<?= base_url('siswa/history/saldo') ?>'">
                                            <div class="background-white text-center border-radius padding-box box-shadow">
                                                <span class="icon-big icon-color-red"><i class="fa fa-redo"></i></span>
                                                <h6 class="font-weight-500">Riwayat</h6>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="" onclick="location.href='<?= base_url('siswa/profile') ?>'">
                                            <div class="background-white text-center border-radius padding-box box-shadow">
                                                <span class="icon-big icon-color-purple"><i class="fa fa-user"></i></span>
                                                <h6 class="font-weight-500">Profile</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <a href="" onclick="location.href='<?= base_url('siswa/profile/password') ?>'">
                                            <div class="background-white text-center border-radius padding-box box-shadow">
                                                <span class="icon-big icon-color-teal"><i class="fa fa-lock"></i></span>
                                                <h6 class="font-weight-500">Akun</h6>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="" onclick="location.href='<?= base_url('siswa/profile/kartu') ?>'">
                                            <div class="background-white text-center border-radius padding-box box-shadow">
                                                <span class="icon-big icon-color-green"><i class="fa fa-qrcode"></i></span>
                                                <h6 class="font-weight-500">Kartu</h6>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="" onclick="location.href='<?= base_url('login/logout') ?>'">
                                            <div class="background-white text-center border-radius padding-box box-shadow">
                                                <span class="icon-big icon-color-red"><i class="fa fa-power-off"></i></span>
                                                <h6 class="font-weight-500">Keluar</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end menus -->
                        <!-- separator -->
                        <div class="separator"></div>
                        <!-- end separator -->
                        <!-- follow us -->
                        <div class="container">
                            <div class="background-white border-radius box-shadow padding-box-middle text-center">
                                <h4 class="margin-bottom-small">Follow us on:</h4>
                                <ul>
                                    <li>
                                        <a href=""><span class="icon-small icon-width socmed-bg-facebook color-white">
                                                <i class="fab fa-facebook-f"></i>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href=""><span class="icon-small icon-width socmed-bg-twitter color-white">
                                                <i class="fab fa-twitter"></i>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href=""><span class="icon-small icon-width socmed-bg-whatsapp color-white">
                                                <i class="fab fa-whatsapp"></i>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href=""><span class="icon-small icon-width socmed-bg-google color-white">
                                                <i class="fab fa-google"></i>
                                            </span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- end follow us -->
                        <!-- separator -->
                        <div class="separator-bottom"></div>
                        <!-- end separator -->
                    </div>
                    <!-- end tabs 1 -->
                    <!-- tabs 2 -->
                    <div id="tab-2" class="tab page-content">
                        <div class="navbar navbar-page">
                            <div class="navbar-inner sliding">
                                <div class="title tabs-text-center">
                                    Notifikasi
                                </div>
                            </div>
                        </div>
                        <!-- history -->
                        <div class="history margin-top">
                            <div class="container">
                                <?php foreach ($notifikasi as $n) : ?>
                                    <div class="background-white box-shadow border-radius padding-box-middle">
                                        <div class="float-left margin-right-middle">
                                            <?php if ($n->jenis == 'in') : ?>
                                                <span class="icon-big icon-color-green">
                                                    <i class="fa fa-wallet"></i>
                                                </span>
                                            <?php else : ?>
                                                <span class="icon-big icon-color-red">
                                                    <i class="fa fa-wallet"></i>
                                                </span>
                                            <?php endif ?>
                                        </div>
                                        <div class="overflow-hidden">
                                            <span><?= format_indo($n->updated_at) ?></span>
                                            <h6 class="margin-bottom-5px"><?= $n->pesan ?></h6>
                                        </div>
                                    </div>
                                    <div class="separator-small"></div>
                                <?php endforeach ?>

                                <div class="separator-bottom"></div>
                            </div>
                        </div>
                        <!-- end history -->
                    </div>
                    <!-- end tabs 2 -->
                    <!-- tabs 5 -->
                    <div id="tab-5" class="tab page-content">
                        <div class="navbar navbar-page">
                            <div class="navbar-inner sliding">
                                <div class="title tabs-text-center">
                                    Akun Saya
                                </div>
                            </div>
                        </div>
                        <!-- account -->
                        <div class="list-pages account-list">
                            <div class="background-circle">
                                <div class="container">
                                    <div class="background-white border-radius padding-box-middle box-shadow">
                                        <div class="row row-no-margin-bottom">
                                            <div class="col-60">
                                                <div class="float-left margin-right-small">
                                                    <?php if (!empty($user->foto)) : ?>
                                                        <img class="people" src="<?= base_url('assets/client/foto/' . $user->foto) ?>">
                                                    <?php else : ?>
                                                        <img class="people" src="<?= base_url() ?>/assets/client/images/author.jpg" alt="">
                                                    <?php endif ?>
                                                </div>
                                                <div class="overflow-hidden">
                                                    <h6><?= $user->nama ?></h6>
                                                    <p><?= $user->kode ?></p>
                                                </div>
                                            </div>
                                            <div class="col-40">
                                                <button class="buttons float-right letter-spacing margin-top-small">Rp. <?= number_format($user->saldo, 0, ',', '.') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="separator-small"></div>
                            <div class="container">
                                <ul>
                                    <li>
                                        <a class="border-radius box-shadow" onclick="location.href='<?= base_url('siswa/history/transaksi') ?>'">
                                            <span class="margin-right-small icon-small icon-color-red"><i class="fa fa-hamburger"></i></span> Transaksi Saya <span class="float-right"><i class="fa fa-chevron-right"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="border-radius box-shadow" onclick="location.href='<?= base_url('siswa/history/saldo') ?>'">
                                            <span class="margin-right-small icon-small icon-color-red"><i class="fa fa-history"></i></span> Saldo Keluar <span class="float-right"><i class="fa fa-chevron-right"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="border-radius box-shadow" onclick="location.href='<?= base_url('siswa/profile') ?>'">
                                            <span class="margin-right-small icon-small icon-color-purple"><i class="fa fa-user"></i></span> Ubah Data Profile <span class="float-right"><i class="fa fa-chevron-right"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="border-radius box-shadow" onclick="location.href='<?= base_url('siswa/profile/password') ?>'">
                                            <span class="margin-right-small icon-small icon-color-green"><i class="fa fa-lock"></i></span> Ubah Password <span class="float-right"><i class="fa fa-chevron-right"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="border-radius box-shadow" href="#" onclick="location.href='<?= base_url('login/logout') ?>'">
                                            <span class="margin-right-small icon-small icon-color-orange"><i class="fa fa-power-off"></i></span> Keluar <span class="float-right"><i class="fa fa-chevron-right"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- end account -->
                        <div class="separator-bottom"></div>
                    </div>
                    <!-- end tabs 5 -->
                </div>
            </div>
            <!-- end tabs -->
        </div>
    </div>
</div>


<?php $this->endSection() ?>

<?php $this->section('js') ?>

<?php $this->endSection() ?>
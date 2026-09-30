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

                        <!-- profile balance & monthly expense card -->
                        <div class="border-radius-style background-primer" style="height: 48px; width: 100%;"></div>

                        <div class="container" style="margin-top: -38px; position: relative; z-index: 10;">
                            <div class="background-white border-radius box-shadow" style="padding: 16px 16px 14px 16px;">
                                
                                <!-- Top: Avatar, Nama Siswa, NIS & Sisa Saldo -->
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; padding-bottom: 12px; border-bottom: 1px dashed #e8ecef;">
                                    
                                    <!-- Left: Avatar + Info Siswa -->
                                    <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0;">
                                        <div style="flex-shrink: 0;">
                                            <?php if (!empty($user->foto)) : ?>
                                                <img src="<?= base_url('assets/client/foto/' . $user->foto) ?>" 
                                                     style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.12); display: block;">
                                            <?php else : ?>
                                                <img src="<?= base_url('assets/client/images/author.jpg') ?>" 
                                                     style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.12); display: block;">
                                            <?php endif ?>
                                        </div>

                                        <div style="flex: 1; min-width: 0;">
                                            <div style="font-size: 14px; font-weight: 700; color: #2d3436; line-height: 1.35; word-break: break-word; margin-bottom: 4px;">
                                                <?= $user->nama ?>
                                            </div>
                                            <div>
                                                <span style="font-size: 11px; color: #636e72; background: #f1f2f6; padding: 2px 7px; border-radius: 4px; font-weight: 600; display: inline-block;">
                                                    <?= $user->kode ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Sisa Saldo Pill -->
                                    <div style="flex-shrink: 0; text-align: right; align-self: center; padding-left: 4px;">
                                        <span style="display: block; font-size: 9px; color: #888; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Sisa Saldo</span>
                                        <div style="background: linear-gradient(135deg, #ff793f, #EB6025); color: #fff; font-size: 13px; font-weight: 700; padding: 6px 12px; border-radius: 20px; box-shadow: 0 3px 8px rgba(235,96,37,0.28); white-space: nowrap; display: inline-block;">
                                            Rp. <?= number_format($user->saldo, '0', '.', ',') ?>
                                        </div>
                                    </div>

                                </div>

                                <!-- Bottom: Total Belanja Bulan Ini -->
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; padding-top: 11px;">
                                    <div style="display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1;">
                                        <div style="width: 36px; height: 36px; border-radius: 9px; background: rgba(235, 96, 37, 0.1); display: flex; align-items: center; justify-content: center; color: #EB6025; font-size: 15px; flex-shrink: 0;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div style="min-width: 0;">
                                            <div style="font-size: 11px; color: #747d8c; line-height: 1.2;">
                                                Total Belanja Bulan Ini:
                                            </div>
                                            <div style="font-size: 14px; font-weight: 800; color: #2d3436; margin-top: 2px; white-space: nowrap;">
                                                Rp. <?= number_format($total_bulan_ini->total_belanja ?? 0, 0, ',', '.') ?>
                                                <span style="font-size: 10px; font-weight: 500; color: #888; margin-left: 2px;">
                                                    (<?= $total_bulan_ini->jml_transaksi ?? 0 ?> transaksi)
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="flex-shrink: 0;">
                                        <a href="javascript:void(0)" class="external" onclick="window.location.href='<?= base_url('siswa/history/transaksi') ?>'; return false;" 
                                           style="font-size: 11px; font-weight: 600; padding: 5px 12px; background: #EB6025; color: #fff; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; box-shadow: 0 2px 6px rgba(235,96,37,0.25);">
                                            Rekap &rarr;
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end profile balance & monthly expense card -->

                        <!-- spacing before menus -->
                        <div style="height: 18px;"></div>
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
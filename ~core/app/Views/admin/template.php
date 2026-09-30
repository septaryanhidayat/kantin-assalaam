<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Aplikasi E-Kantin" name="description" />
    <meta content="Pondok Pesantren As Salaam Jayapura" name="author" />
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.ico">

    <link href="<?= base_url() ?>/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <style>
        .vertical-menu {
            overflow-y: auto !important;
            max-height: 100vh !important;
        }
        .vertical-menu .h-100 {
            overflow-y: auto !important;
        }
        .vertical-menu::-webkit-scrollbar,
        .vertical-menu .h-100::-webkit-scrollbar {
            width: 6px;
        }
        .vertical-menu::-webkit-scrollbar-track,
        .vertical-menu .h-100::-webkit-scrollbar-track {
            background: transparent;
        }
        .vertical-menu::-webkit-scrollbar-thumb,
        .vertical-menu .h-100::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 4px;
        }
        .vertical-menu::-webkit-scrollbar-thumb:hover,
        .vertical-menu .h-100::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.45);
        }
        #sidebar-menu {
            padding-bottom: 90px !important;
        }
    </style>

    <?php $this->renderSection('css') ?>
</head>

<body data-layout="detached" data-topbar="colored">

    <div class="container-fluid">
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-end">


                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="<?= base_url() ?>/assets/images/users/avatar-2.jpg" alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ms-1"><?= $admin->nama ?></span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">

                                    <a class="dropdown-item" href="<?= base_url($segment[0] . '/profile') ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                        Profile</a>
                                    <a class="dropdown-item" href="<?= base_url($segment[0] . '/profile/password') ?>"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                                        Ubah Password</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="<?= base_url('/login/logout') ?>"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                                </div>
                            </div>

                        </div>
                        <div>
                            <div class="navbar-brand-box">
                                <a href="" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="<?= base_url() ?>/assets/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="<?= base_url() ?>/assets/images/logo-dark.png" alt="" height="17">
                                    </span>
                                </a>

                                <a href="" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="<?= base_url() ?>/assets/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="<?= base_url() ?>/assets/images/logo-light.png" alt="" height="19">
                                    </span>
                                </a>
                            </div>

                            <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect" id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>


                        </div>

                    </div>
                </div>
            </header>

            <?php if ($segment[1] != 'transaksi') : ?>
                <div class="vertical-menu">

                    <div data-simplebar class="h-100">

                        <div class="user-wid text-center py-4">
                            <div class="user-img">
                                <img src="<?= base_url() ?>/assets/images/users/avatar-2.jpg" alt="" class="avatar-md mx-auto rounded-circle">
                            </div>

                            <div class="mt-3">

                                <a href="#" class="text-dark fw-medium font-size-16"><?= $admin->nama ?></a>
                                <p class="text-body mt-1 mb-0 font-size-13">
                                    <?php if ($admin->level == 1) : ?>
                                        Administrator
                                    <?php endif ?>
                                    <?php if ($admin->level == 2) : ?>
                                        Super Admin
                                    <?php endif ?>
                                    <?php if ($admin->level == 3) : ?>
                                        Petugas Kantin
                                    <?php endif ?>
                                    <?php if ($admin->level == 4) : ?>
                                        Admin Kantin
                                    <?php endif ?>
                                </p>

                            </div>
                        </div>

                        <?php
                        if (empty($segment[2])) {
                            $dir  = $segment[0];
                            $menu = $segment[1];
                            $sub  = '';
                        } else {
                            $dir  = $segment[0];
                            $menu = $segment[1];
                            $sub  = $segment[2];
                        }
                        ?>

                        <div id="sidebar-menu">
                            <ul class="metismenu list-unstyled" id="side-menu">
                                <?php if ($admin->level == 1) : ?>
                                    <li class="menu-title">Menu Utama</li>

                                    <li <?= ($dir == 'admin' && $menu == 'dashboard') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('admin/dashboard') ?>" class=" waves-effect <?= ($dir == 'admin' && $menu == 'dashboard') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-airplay"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li <?= ($dir == 'admin' && $menu == 'user') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'user') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-shield-account-outline"></i>
                                            <span>User Manajer</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'user') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('admin/user/new') ?>" <?= ($menu == 'user' && $sub == 'new') ? 'class="active"' : '' ?>>Tambah Baru</a></li>
                                            <li><a href="<?= base_url('admin/user') ?>" <?= ($menu == 'user' && $sub == '') ? 'class="active"' : '' ?>">Daftar User</a></li>
                                        </ul>
                                    </li>
                                    <li <?= ($menu == 'kantin') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'siswa') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-food"></i>
                                            <span>Kantin</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'kantin') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('admin/kantin/new') ?>" <?= ($menu == 'kantin' && $sub == 'new') ? 'class="active"' : '' ?>>Tambah Kantin Baru</a></li>
                                            <li><a href="<?= base_url('admin/kantin') ?>" <?= ($menu == 'kantin' && $sub == '') ? 'class="active"' : '' ?>">Daftar Kantin</a></li>
                                            <li><a href="<?= base_url('admin/kantin/kartu') ?>" <?= ($menu == 'kantin' && $sub == 'kartu') ? 'class="active"' : '' ?>">Kartu Kantin Siswa</a></li>
                                            <li><a href="<?= base_url('admin/kantin/kartu_guru') ?>" <?= ($menu == 'kantin' && $sub == 'kartu_guru') ? 'class="active"' : '' ?>">Kartu Kantin Guru & Kary.</a></li>
                                        </ul>
                                    </li>
                                    <li <?= ($menu == 'guru') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'siswa') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-account-multiple-check-outline"></i>
                                            <span>Guru & Karyawan</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'guru') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('admin/guru/import') ?>" <?= ($menu == 'guru' && $sub == 'import') ? 'class="active"' : '' ?>>Import Data</a></li>
                                            <li><a href="<?= base_url('admin/guru/new') ?>" <?= ($menu == 'guru' && $sub == 'new') ? 'class="active"' : '' ?>>Tambah Baru</a></li>
                                            <li><a href="<?= base_url('admin/guru') ?>" <?= ($menu == 'guru' && $sub == '') ? 'class="active"' : '' ?>">Daftar Guru & Karyawan</a></li>
                                            <!-- <li><a href="<?= base_url('admin/guru/kartu') ?>" <?= ($menu == 'guru' && $sub == 'kartu') ? 'class="active"' : '' ?>">Kartu Kantin</a></li> -->
                                        </ul>
                                    </li>
                                    <li <?= (($dir == 'admin' && $menu == 'siswa') || ($dir == 'admin' && $menu == 'ortu')) ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'siswa') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-account-multiple-check-outline"></i>
                                            <span>Siswa & Orang Tua</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'siswa' || $menu == 'ortu') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('admin/siswa/import') ?>" <?= ($menu == 'siswa' && $sub == 'import') ? 'class="active"' : '' ?>>Import Siswa</a></li>
                                            <li><a href="<?= base_url('admin/siswa/new') ?>" <?= ($menu == 'siswa' && $sub == 'new') ? 'class="active"' : '' ?>>Tambah Siswa Baru</a></li>
                                            <li><a href="<?= base_url('admin/siswa') ?>" <?= ($menu == 'siswa' && $sub == '') ? 'class="active"' : '' ?>">Daftar Siswa</a></li>

                                            <li><a href="<?= base_url('admin/ortu/new') ?>" <?= ($menu == 'siswa' && $sub == 'ortu_new') ? 'class="active"' : '' ?>>Tambah Orang Tua</a></li>
                                            <li><a href="<?= base_url('admin/ortu') ?>" <?= ($menu == 'siswa' && $sub == 'ortu') ? 'class="active"' : '' ?>">Daftar Orang Tua</a></li>
                                        </ul>
                                    </li>

                                    <li <?= ($menu == 'deposit') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'deposit') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-currency-usd"></i>
                                            <span>Deposit</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'deposit') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('admin/deposit') ?>" <?= ($menu == 'deposit' && $sub == '') ? 'class="active"' : '' ?>>Deposit Wali</a></li>
                                            <li><a href="<?= base_url('admin/deposit/new') ?>" <?= ($menu == 'deposit' && $sub == 'new') ? 'class="active"' : '' ?>>Tambah Deposit Wali</a></li>
                                            <li><a href="<?= base_url('admin/deposit/history') ?>" <?= ($menu == 'deposit' && $sub == 'history') ? 'class="active"' : '' ?>">Riwayat Deposit Wali</a></li>

                                            <li><a href="<?= base_url('admin/deposit/guru') ?>" <?= ($menu == 'deposit' && $sub == 'deposit_guru') ? 'class="active"' : '' ?>>Deposit Guru</a></li>
                                            <li><a href="<?= base_url('admin/deposit/new_guru') ?>" <?= ($menu == 'deposit' && $sub == 'new_guru') ? 'class="active"' : '' ?>>Tambah Deposit Guru</a></li>
                                            <li><a href="<?= base_url('admin/deposit/history_guru') ?>" <?= ($menu == 'deposit' && $sub == 'history_guru') ? 'class="active"' : '' ?>">Riwayat Deposit Guru</a></li>
                                        </ul>
                                    </li>

                                    <li <?= ($dir == 'admin' && $menu == 'laporan') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'laporan') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-newspaper"></i>
                                            <span>Laporan</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'laporan') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('admin/laporan') ?>" <?= ($menu == 'laporan' && $sub == '') ? 'class="active"' : '' ?>>Laporan Deposit</a></li>
                                            <li><a href="<?= base_url('admin/laporan/saldo') ?>" <?= ($menu == 'laporan' && $sub == 'saldo') ? 'class="active"' : '' ?>>Laporan Saldo</a></li>
                                            <li><a href="<?= base_url('admin/laporan/transaksi') ?>" <?= ($menu == 'laporan' && $sub == 'transaksi') ? 'class="active"' : '' ?>>Laporan Transaksi</a></li>
                                        </ul>
                                    </li>

                                    <li <?= ($dir == 'admin' && $menu == 'setting') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('admin/setting') ?>" class=" waves-effect <?= ($menu == 'setting') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-cogs"></i>
                                            <span>Setting</span>
                                        </a>
                                    </li>

                                    <li <?= ($dir == 'admin' && $menu == 'database') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'database') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-database"></i>
                                            <span>Database</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'database') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('admin/database') ?>" <?= ($menu == 'database' && $sub == '') ? 'class="active"' : '' ?>>Daftar Tabel</a></li>
                                            <li><a href="<?= base_url('admin/database/query') ?>" <?= ($menu == 'database' && $sub == 'query') ? 'class="active"' : '' ?>>SQL Query Editor</a></li>
                                            <li><a href="<?= base_url('admin/database/backup') ?>" <?= ($menu == 'database' && $sub == 'backup') ? 'class="active"' : '' ?>>Download Backup (.sql)</a></li>
                                        </ul>
                                    </li>
                                <?php endif ?>

                                <!-- Menu Super Admin -->
                                <?php if ($admin->level == 2) : ?>
                                    <li class="menu-title">Menu Super Admin</li>
                                    <li <?= ($dir == 'super' && $menu == 'dashboard') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('super/dashboard') ?>" class=" waves-effect <?= ($menu == 'dashboard') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-airplay"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li <?= ($dir == 'super' && $menu == 'landing') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'landing') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-home"></i>
                                            <span>Landing Page</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'landing') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('super/landing') ?>" <?= ($menu == 'landing' && $sub == '') ? 'class="active"' : '' ?>>Header Section</a></li>
                                            <li><a href="<?= base_url('super/landing/featured') ?>" <?= ($menu == 'landing' && $sub == 'featured') ? 'class="active"' : '' ?>">Featured Section</a></li>
                                            <li><a href="<?= base_url('super/landing/kepala') ?>" <?= ($menu == 'landing' && $sub == 'kepala') ? 'class="active"' : '' ?>">Kepala Sekolah Section</a></li>
                                            <li><a href="<?= base_url('super/landing/gallery') ?>" <?= ($menu == 'landing' && $sub == 'gallery') ? 'class="active"' : '' ?>">Gallery Section</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="<?= base_url() ?>" class="waves-effect" target="_blank">
                                            <i class="mdi mdi-link"></i>
                                            <span>Lihat Landing Page</span>
                                        </a>
                                    </li>
                                <?php endif ?>

                                <!-- Menu Petugas Kantin -->
                                <?php if ($admin->level == 3) : ?>
                                    <li class="menu-title">Menu Petugas Kantin</li>
                                    <li <?= ($dir == 'petugas' && $menu == 'dashboard') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('petugas/dashboard') ?>" class=" waves-effect <?= ($menu == 'dashboard') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-airplay"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li <?= ($dir == 'petugas' && $menu == 'transaksi') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('petugas/transaksi/aktif') ?>" class=" waves-effect <?= ($menu == 'transaksi') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-table-large-plus"></i>
                                            <span>Transaksi Baru</span>
                                        </a>
                                    </li>

                                    <li <?= ($dir == 'petugas' && $menu == 'riwayat') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('petugas/laporan/riwayat') ?>" class=" waves-effect">
                                            <i class="mdi mdi-table-large-plus"></i>
                                            <span>Riwayat Transaksi</span>
                                        </a>
                                    </li>

                                    <li <?= ($dir == 'petugas' && $menu == 'laporan') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'laporan') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi  mdi-file-chart-outline"></i>
                                            <span>Laporan</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'laporan') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('petugas/laporan') ?>" <?= ($menu == 'laporan' && $sub == '') ? 'class="active"' : '' ?>>Laporan Transaksi</a></li>
                                            <!-- <li><a href="<?= base_url('petugas/laporan/keluar') ?>" <?= ($menu == 'laporan' && $sub == 'keluar') ? 'class="active"' : '' ?>">Laporan Uang Keluar</a></li> -->
                                        </ul>
                                    </li>
                                <?php endif ?>

                                <!-- Menu Admin Kantin -->
                                <?php if ($admin->level == 4) : ?>
                                    <li class="menu-title">Menu Admin Kantin</li>
                                    <li <?= ($dir == 'kantin' && $menu == 'dashboard') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('kantin/dashboard') ?>" class=" waves-effect <?= ($menu == 'dashboard') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-airplay"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li <?= ($dir == 'kantin' && $menu == 'barang') ? 'class="mm-active"' : '' ?>>
                                        <a href="javascript: void(0);" class="waves-effect has-arrow <?= ($menu == 'barang') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-shield-account-outline"></i>
                                            <span>Makanan & Minuman</span>
                                        </a>
                                        <ul class="sub-menu <?= ($menu == 'barang') ? 'class="mm-show"' : '' ?>" aria-expanded="false">
                                            <li><a href="<?= base_url('kantin/barang/new') ?>" <?= ($menu == 'barang' && $sub == 'new') ? 'class="active"' : '' ?>>Tambah Baru</a></li>
                                            <li><a href="<?= base_url('kantin/barang/import') ?>" <?= ($menu == 'barang' && $sub == 'import') ? 'class="active"' : '' ?>>Impor Data</a></li>
                                            <li><a href="<?= base_url('kantin/barang') ?>" <?= ($menu == 'barang' && $sub == '') ? 'class="active"' : '' ?>">Daftar Makanan & Minuman</a></li>
                                        </ul>
                                    </li>
                                    <li <?= ($dir == 'kantin' && $menu == 'riwayat') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('kantin/laporan/riwayat') ?>" class=" waves-effect">
                                            <i class="mdi mdi-table-large-plus"></i>
                                            <span>Riwayat Transaksi</span>
                                        </a>
                                    </li>
                                    <li <?= ($dir == 'kantin' && $menu == 'laporan') ? 'class="mm-active"' : '' ?>>
                                        <a href="<?= base_url('kantin/laporan') ?>" class=" waves-effect <?= ($menu == 'laporan') ? 'class="mm-active"' : '' ?>">
                                            <i class="mdi mdi-file-chart-outline"></i>
                                            <span>Laporan Penjualan</span>
                                        </a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <div class="main-content">

                <?php $this->renderSection('content') ?>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © 2025
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    All Right Reserved
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>

        </div>

    </div>



    <script src="<?= base_url() ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script> -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script src="<?= base_url() ?>/assets/js/sweetalert2.js"></script>

    <script>
        <?php if (session()->getFlashdata('alert') == true) : ?>
            <?php
            if (is_array(session()->getFlashdata('message')) == 1) {
                $message = '<ul>';
                foreach (session()->getFlashdata('message') as $list) {
                    $message .= '<li>' . $list . '</li>';
                }
                $message .= '</ul>';
            } else {
                $message = session()->getFlashdata('message');
            }
            ?>

            Swal.fire({
                title: '<?= session()->getFlashdata('title') ?>',
                html: '<?= $message ?>',
                icon: '<?= session()->getFlashdata('type') ?>',
                toast: true,
            });

        <?php endif ?>
    </script>

    <?php $this->renderSection('js') ?>
</body>

</html>
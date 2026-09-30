<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
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

    <div class="card">
        <div class="card-body">
            <h5>Data Master :</h5>
            <div class="d-grid gap-2 d-sm-block">
                <a href="<?= base_url('admin/user/new') ?>" class="btn btn-primary"><i class="fa fa-user-plus fa-3x"></i><br>Tambah User</a>
                <a href="<?= base_url('admin/siswa/new') ?>" class="btn btn-success"><i class="fa fa-user-graduate fa-3x"></i><br>Tambah Siswa</a>
                <a href="<?= base_url('admin/ortu/new') ?>" class="btn btn-warning"><i class="fa fa-user-circle fa-3x"></i><br>Tambah Wali</a>
                <a href="<?= base_url('admin/siswa/import') ?>" class="btn btn-danger"><i class="fa fa-upload fa-3x"></i><br>Import Siswa</a>
                <a href="<?= base_url('admin/kantin/new') ?>" class="btn btn-info"><i class="fa fa-store fa-3x"></i><br>Tambah Kantin</a>
            </div>
        </div>
        <div class="card-body">
            <h5>Pengaturan Website :</h5>
            <div class="d-grid gap-2 d-sm-block">
                <a href="<?= base_url('admin/landing') ?>" class="btn btn-primary"><i class="fa fa-map fa-3x"></i><br>Header Section</a>
                <a href="<?= base_url('admin/landing/featured') ?>" class="btn btn-success"><i class="fa fa-columns fa-3x"></i><br>Featured Section</a>
                <a href="<?= base_url('admin/landing/kepala') ?>" class="btn btn-danger"><i class="fa fa-address-card fa-3x"></i><br>Kepala Sekolah Section</a>
                <a href="<?= base_url('admin/landing/gallery') ?>" class="btn btn-info"><i class="fa fa-images fa-3x"></i><br>Gallery Section</a>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<?php $this->endSection() ?>
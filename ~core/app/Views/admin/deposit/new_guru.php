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

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <form action="<?= base_url('admin/deposit/save_guru') ?>" method="post">
                    <div class="card-header">
                        Form Deposit
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Nama Guru / Karyawan</label>
                            <div class="col-md-9">
                                <select name="id_guru" class="form-select" required>
                                    <option value="">Pilih</option>
                                    <?php foreach ($guru as $o) : ?>
                                        <option value="<?= $o->id ?>"><?= $o->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Nominal Deposit</label>
                            <div class="col-md-9">
                                <input class="form-control" min="1" type="number" name="jumlah" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Bank Tujuan</label>
                            <div class="col-md-9">
                                <select name="bank" class="form-select">
                                    <option value="">Pilih Bank</option>
                                    <option value="Manual">Manual Petugas</option>
                                    <option value="BRI">BSI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BNI">BNI</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="Jago">Jago</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-warning">Saldo akan langsung masuk ke Akun Guru, pastikan di input dengan benar.</div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <input type="submit" class="btn btn-success" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<?php $this->endSection() ?>
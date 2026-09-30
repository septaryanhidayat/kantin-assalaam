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
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <form action="" method="post">
                    <div class="card-header">
                        Form Kantin
                    </div>
                    <div class="card-body">
                        <p class="card-title-desc">Lengkapi Form di bawah ini, yang memiliki tanda
                            <code>*</code> tidak boleh kosong.
                        </p>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Kode <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" value="<?= kode_kantin($kode) ?>" readonly required>
                                <input type="hidden" name="kode" value="<?= $kode ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Nama Kantin <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="nama" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Pilih Admin/Pemilik Kantin <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="pemilik" class="form-select" required>
                                    <option value="">Silahkan Pilih</option>
                                    <?php foreach ($pemilik as $o) : ?>
                                        <option value="<?= $o->id ?>"><?= $o->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-5 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Pilih Petugas Kantin <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="petugas" class="form-select" required>
                                    <option value="">Silahkan Pilih</option>
                                    <?php foreach ($petugas as $p) : ?>
                                        <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <a href="<?= base_url('admin/kantin') ?>" class="btn btn-outline-warning">Batal</a>
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
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
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $ortu->id ?>">
                    <div class="card-header">
                        Form User
                    </div>
                    <div class="card-body">
                        <p class="card-title-desc">Lengkapi Form di bawah ini, yang memiliki tanda
                            <code>*</code> tidak boleh kosong.
                        </p>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">ID/Kode <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" name="kode" type="text" value="<?= $ortu->kode ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">NIK <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="nik" value="<?= $ortu->nik ?>" required>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="nama" value="<?= $ortu->nama ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Wali Dari Siswa <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="id_siswa" class="form-select select2" required>
                                    <?php foreach ($siswa as $s) : ?>
                                        <option value="<?= $s->id ?>" <?= ($ortu->id_siswa == $s->id) ? 'selected' : '' ?>><?= $s->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea name="alamat" class="form-control"><?= $ortu->alamat ?></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">No. WhatsApp</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="whatsapp" value="<?= $ortu->whatsapp ?>">
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <a href="<?= base_url('admin/user') ?>" class="btn btn-outline-warning">Batal</a>
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
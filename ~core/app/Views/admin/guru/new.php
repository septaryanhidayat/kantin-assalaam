<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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
                <form action="<?= base_url('admin/guru/save') ?>" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        Form Guru & Karyawan
                    </div>
                    <div class="card-body">
                        <p class="card-title-desc">Lengkapi Form di bawah ini, yang memiliki tanda
                            <code>*</code> tidak boleh kosong.
                        </p>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">ID/Kode <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" name="kode" type="text" value="<?= kode_guru($kode) ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="password" required>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="nama" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Jabatan</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="jabatan">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">No. WhatsApp</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="whatsapp">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto</label>
                            <div class="col-md-9">
                                <img id="output" width="100" class="img-thumbnail" />
                                <input type="file" name="foto" class="form-control" id="inputGroupFile02" onchange="loadFile(event)">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <a href="<?= base_url('admin/guru') ?>" class="btn btn-outline-warning">Batal</a>
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
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/form-advanced.init.js"></script>

<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
<?php $this->endSection() ?>
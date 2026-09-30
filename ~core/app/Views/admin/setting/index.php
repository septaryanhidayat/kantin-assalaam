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
                <form action="" method="post">
                    <div class="card-header">
                        Form Setting
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-12 col-form-label">Teks Transfer Deposit</label>
                            <div class="col-md-12">
                                <textarea id="elm1" name="teks_transfer"><?= $setting->teks_transfer ?></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-12 col-form-label">Header Struk Kantin<span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <textarea name="kop_kartu" class="form-control"><?= $setting->kop_kartu ?></textarea>
                            </div>
                        </div>
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
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/form-advanced.init.js"></script>
<script src="<?= base_url() ?>/assets/libs/tinymce/tinymce.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/form-editor.init.js"></script>
<?php $this->endSection() ?>
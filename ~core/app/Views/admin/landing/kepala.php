<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<link rel="stylesheet" href="https://demo.hazzardweb.com/imagepicker/assets/css/imgpicker.css">
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
                <form action="<?= base_url('/admin/landing/save_kepala') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $kepala->id ?>">
                    <div class="card-header">
                        Kepala Sekolah Section
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Nama Kepala Sekolah</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" name="nama" required><?= $kepala->nama ?></textarea>
                                <small class="text-muted">Bisa menggunakan Tag HTML</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto Kepala Sekolah</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="foto" value="<?= $kepala->foto ?>" id="image_kepala" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_kepala">Pilih</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Moto Teks 1</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="5" name="moto1" required><?= $kepala->moto1 ?></textarea>
                                <small class="text-muted">Bisa menggunakan Tag HTML</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Moto Teks 2</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="5" name="moto2" required><?= $kepala->moto2 ?></textarea>
                                <small class="text-muted">Bisa menggunakan Tag HTML</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Moto Teks 3</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="5" name="moto3" required><?= $kepala->moto3 ?></textarea>
                                <small class="text-muted">Bisa menggunakan Tag HTML</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Moto Teks 4</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="5" name="moto4" required><?= $kepala->moto4 ?></textarea>
                                <small class="text-muted">Bisa menggunakan Tag HTML</small>
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
<script>
    $(document).ready(function() {
        $("#btn_browse_kepala").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_kepala').val(filename);
                    window.KCFinder = null;
                }
            };
            window.open('<?php echo base_url(); ?>/assets/libs/kcfinder/browse.php?type=images', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            return false;
        });

    });
</script>

<?php $this->endSection() ?>
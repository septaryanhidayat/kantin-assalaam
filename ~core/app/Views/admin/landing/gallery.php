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
                <form action="<?= base_url('/admin/landing/save_gallery') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $gallery->id ?>">
                    <div class="card-header">
                        Gallery Section
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto 1</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="foto1" value="<?= $gallery->foto1 ?>" id="image_foto1" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_foto1">Pilih</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto 2</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="foto2" value="<?= $gallery->foto2 ?>" id="image_foto2" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_foto2">Pilih</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto 3</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="foto3" value="<?= $gallery->foto3 ?>" id="image_foto3" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_foto3">Pilih</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto 4</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="foto4" value="<?= $gallery->foto4 ?>" id="image_foto4" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_foto4">Pilih</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto 5</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="foto5" value="<?= $gallery->foto5 ?>" id="image_foto5" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_foto5">Pilih</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Foto 6</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="foto6" value="<?= $gallery->foto6 ?>" id="image_foto6" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_foto6">Pilih</span>
                                </div>
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
        $("#btn_browse_foto1").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_foto1').val(filename);
                    window.KCFinder = null;
                }
            };
            window.open('<?php echo base_url(); ?>/assets/libs/kcfinder/browse.php?type=images', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            return false;
        });

        $("#btn_browse_foto2").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_foto2').val(filename);
                    window.KCFinder = null;
                }
            };
            window.open('<?php echo base_url(); ?>/assets/libs/kcfinder/browse.php?type=images', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            return false;
            4
        });

        $("#btn_browse_foto3").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_foto3').val(filename);
                    window.KCFinder = null;
                }
            };
            window.open('<?php echo base_url(); ?>/assets/libs/kcfinder/browse.php?type=images', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            return false;
        });

        $("#btn_browse_foto4").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_foto4').val(filename);
                    window.KCFinder = null;
                }
            };
            window.open('<?php echo base_url(); ?>/assets/libs/kcfinder/browse.php?type=images', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            return false;
        });

        $("#btn_browse_foto5").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_foto5').val(filename);
                    window.KCFinder = null;
                }
            };
            window.open('<?php echo base_url(); ?>/assets/libs/kcfinder/browse.php?type=images', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            return false;
        });

        $("#btn_browse_foto6").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_foto6').val(filename);
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
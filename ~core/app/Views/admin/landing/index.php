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
                <form action="<?= base_url('/admin/landing/save_header') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $header->id ?>">
                    <div class="card-header">
                        Header Section
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Logo</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="logo" value="<?= $header->logo ?>" id="image_logo" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_logo">Pilih</span>
                                </div>

                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Hero Text</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="10" name="hero_text" required><?= $header->hero_text ?></textarea>
                                <small class="text-muted">Bisa menggunakan Tag HTML</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Hero Image</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="hero_image" value="<?= $header->hero_image ?>" id="image_hero" required>
                                    <span class="input-group-text bg-info text-white" style="cursor: pointer" id="btn_browse_hero">Pilih</span>
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
        $("#btn_browse_logo").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_logo').val(filename);
                    window.KCFinder = null;
                }
            };
            window.open('<?php echo base_url(); ?>/assets/libs/kcfinder/browse.php?type=images', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            return false;
        });

        $("#btn_browse_hero").click(function() {
            window.KCFinder = {
                callBack: function(url) {
                    var filename = url.split('/').pop();
                    $('#image_hero').val(filename);
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
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
                    <div class="card-header">
                        Form Ubah Password
                    </div>
                    <div class="card-body">
                        <p class="card-title-desc">Lengkapi Form di bawah ini, yang memiliki tanda
                            <code>*</code> tidak boleh kosong.
                        </p>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Password Baru <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" name="password" type="text" minlength="5" required>
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
<?php $this->endSection() ?>
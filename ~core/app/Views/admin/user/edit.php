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
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div class="card-header">
                        Form User
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Username</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="username" value="<?= $user->username ?>" required>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Nama Lengkap</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="nama" value="<?= $user->nama ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">No. WhatsApp</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="whatsapp" value="<?= $user->whatsapp ?>" required>
                            </div>
                        </div>
                        <div class="mb-5 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Level Login</label>
                            <div class="col-md-9">
                                <select name="level" class="form-select" required>
                                    <option value="">Pilih Level Login</option>
                                    <option value="1" <?= ($user->level == 1) ? 'selected' : '' ?>>Administrator</option>
                                    <option value="3" <?= ($user->level == 3) ? 'selected' : '' ?>>Petugas Kantin</option>
                                    <option value="4" <?= ($user->level == 4) ? 'selected' : '' ?>>Admin Kantin</option>
                                </select>
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
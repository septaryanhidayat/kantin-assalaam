<?php $this->extend('ortu/template'); ?>

<?php $this->section('css') ?>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="page">
    <div class="navbar navbar-page">
        <div class="navbar-inner sliding">
            <div class="left">
                <a onclick="location.href='<?= base_url() ?>/ortu/dashboard'" class="link back">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </div>
            <div class="title">
                Ubah Password
            </div>
        </div>
    </div>
    <div class="page-content">
        <!-- deposit -->
        <div class="deposit margin-pages">
            <div class="container">
                <form action="<?= base_url('ortu/profile/save_password') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div class="background-white border-radius box-shadow">
                        <input type="text" name="password" placeholder="Masukkan Password Baru" required>
                    </div>
                    <button type="submit" class="buttons buttons-full margin-top-small box-shadow">Simpan</button>
                </form>

                <div class="separator-bottom"></div>
            </div>
        </div>
        <!-- end deposit -->
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<?php $this->endSection() ?>
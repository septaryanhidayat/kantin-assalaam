<?php $this->extend('ortu/template'); ?>

<?php $this->section('css') ?>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="page">
    <div class="navbar navbar-page">
        <div class="navbar-inner sliding">
            <div class="left">
                <a onclick="location.href='<?= base_url() ?>/siswa/dashboard'" class="link back">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </div>
            <div class="title">
                Edit Profile
            </div>
        </div>
    </div>
    <div class="page-content">
        <!-- deposit -->
        <div class="deposit margin-pages">
            <div class="container">
                <form action="<?= base_url('siswa/profile/save') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div class="background-white border-radius box-shadow">
                        <input type="text" name="nama" placeholder="Nama Lengkap" value="<?= $user->nama ?>" required>
                    </div>
                    <div class="background-white border-radius box-shadow">
                        <input type="text" name="whatsapp" placeholder="Nomor Whatsapp" value="<?= $user->whatsapp ?>" required>
                    </div>
                    <span style="color:red;font-weight:bold">*PIN Transaksi</span>
                    <div class="background-white border-radius box-shadow">
                        <input type="password" maxlength="6" name="pin" placeholder="Masukkan PIN" value="<?= $user->pin ?>" required>
                    </div>
                    <div class="background-white border-radius box-shadow">
                        <textarea name="alamat" placeholder="Alamat" required><?= $user->alamat ?></textarea>
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
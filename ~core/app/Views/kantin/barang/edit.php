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
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $barang->id ?>">
                    <div class="card-header">
                        Form User
                    </div>
                    <div class="card-body">
                        <p class="card-title-desc">Lengkapi Form di bawah ini, yang memiliki tanda
                            <code>*</code> tidak boleh kosong.
                        </p>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Pilih Kantin <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="id_kantin" class="form-select" required>
                                    <option value="">Silahkan Pilih</option>
                                    <?php foreach ($kantin as $k) : ?>
                                        <option value="<?= $k->id ?>" <?= ($barang->id_kantin == $k->id) ? 'selected' : '' ?>><?= $k->kode . ' - ' . $k->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Kode <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="kode" value="<?= $barang->kode ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Nama Barang <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="nama" value="<?= $barang->nama ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Harga Beli <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="number" name="modal" value="<?= $barang->modal ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Harga Jual <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="number" name="harga" value="<?= $barang->harga ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Stok <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="number" name="stok" value="<?= $barang->stok ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-4 col-form-label">Foto</label>
                            <div class="col-md-8">
                                <img id="output" width="100" class="img-thumbnail" src="<?= base_url('assets/food/' . $barang->foto) ?>" />
                                <input type="file" name="foto" class="form-control" id="inputGroupFile02" onchange="loadFile(event)">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <a href="<?= base_url('kantin/barang') ?>" class="btn btn-outline-warning">Batal</a>
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
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
<?php $this->endSection() ?>
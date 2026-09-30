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

        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-6">
                    <a href="<?= base_url('petugas/dashboard') ?>" class="btn btn-success mb-3">Kembali ke Dashboard</a>
                    <a href="<?= base_url('petugas/transaksi/new') ?>" class="btn btn-success mb-3">Nota/Transaksi Baru</a>
                </div>
                <div class="col-lg-6 text-end">
                    <span class="btn btn-primary">No. Nota: <?= $nomor ?></span>
                </div>

            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Cari Barang</span>
                    <input type="text" name="search_text" id="search_text" placeholder="Masukkan Nama Makanan/Minuman/Barang" autofocus="true" class="form-control" />
                </div>
            </div>
            <br />
            <div id="result" class="row"></div>
        </div>

        <div class="col-lg-3">
            <div class="card text-white">
                <div class="card-body">
                    <h5 class="mb-4">Barang yang dibeli</h5>

                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script>
    $(document).ready(function() {

        load_data();

        function load_data(query) {
            $.ajax({
                url: "<?= base_url('petugas/transaksi/cari') ?>",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }
        $('#search_text').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });
    });
</script>


<?php $this->endSection() ?>
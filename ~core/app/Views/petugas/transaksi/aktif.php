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

        <div class="col-md-9">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="<?= base_url('petugas/dashboard') ?>" class="btn btn-success mb-3">Kembali ke Dashboard</a>
                </div>
                <div class="col-md-6 text-end">
                    <span class="btn btn-primary">No. Nota: <?= $transaksi_aktif->no_transaksi ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Cari Barang</span>
                    <input type="text" name="search_text" id="search_text" placeholder="Masukkan Nama Makanan/Minuman/Barang/Kode" autofocus="true" class="form-control" />
                </div>
            </div>
            <br />
            <div id="result" class="row"></div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Barang yang dibeli</h5>
                    <?php if (!empty($transaksi_detail)) : ?>
                        <table class="table table-sm" width="100%">
                            <?php $total = 0 ?>
                            <?php foreach ($transaksi_detail as $detail) : ?>
                                <tr>
                                    <td><a href="<?= base_url('petugas/transaksi/delete_item/' . $detail->id) ?>" class="badge bg-danger text-white" onclick="return confirm('Yakin?')">x</a> <?= $detail->barang ?></td>
                                    <td>x<?= $detail->jumlah ?></td>
                                    <td align="right"><?= number_format($detail->jumlah * $detail->harga, 0, ',', '.') ?></td>
                                </tr>
                                <?php $total += ($detail->jumlah * $detail->harga) ?>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="2">TOTAL</td>
                                <td align="right"><?= number_format($total, 0, ',', '.') ?></td>
                            </tr>
                        </table>
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('petugas/transaksi/selesai/' . $transaksi_aktif->id) ?>" class="btn btn-success">Lanjutkan</a>
                        </div>
                    <?php else : ?>
                        <p>Belum ada barang.</p>
                    <?php endif ?>

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
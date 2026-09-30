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

    <div class="card">
        <div class="card-body">

            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <input type="date" name="start" class="form-control" require>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end" class="form-control" require>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success" value="Proses">
                    </div>
                </div>

            </form>

            <?php if (!empty($_GET['start'])) : ?>
                <hr>
                <button id="btnExport" class="btn btn-primary mb-3" onclick="exportReportToExcel(this)">EXPORT REPORT</button>

                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead class="table-light">
                            <th>#</th>
                            <th>Tgl. Transaksi</th>
                            <th>No. Transaksi</th>
                            <th class="text-end">Total Modal</th>
                            <th class="text-end">Total Belanja</th>
                            <th class="text-end">Total Laba</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($transaksi)) : ?>
                                <?php $no = 1; ?>
                                <?php $total_modal = 0; ?>
                                <?php $total_belanja = 0; ?>
                                <?php $total_laba = 0; ?>
                                <?php foreach ($transaksi as $t) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $t->updated_at ?></td>
                                        <td><?= nomor_transaksi($t->no_transaksi) ?></td>
                                        <td align="right"><?= uang($t->modal) ?></td>
                                        <td align="right"><?= uang($t->total) ?></td>
                                        <td align="right"><?= uang($t->total - $t->modal) ?></td>
                                    </tr>
                                    <?php $total_modal += $t->modal; ?>
                                    <?php $total_belanja += $t->total; ?>
                                    <?php $total_laba += ($t->total - $t->modal); ?>
                                <?php endforeach ?>
                                <tr>
                                    <td colspan="3">TOTAL</td>
                                    <td align="right"><?= uang($total_modal) ?></td>
                                    <td align="right"><?= uang($total_belanja) ?></td>
                                    <td align="right"><?= uang($total_laba) ?></td>
                                </tr>
                            <?php else : ?>

                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script src="<?= base_url() ?>/assets/js/tableToExcel.js"></script>
<script>
    function exportReportToExcel() {
        let table = document.getElementsByTagName("table"); // you can use document.getElementById('tableId') as well by providing id to the table tag
        TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
            name: `export.xlsx`, // fileName you could use any name
            sheet: {
                name: 'Sheet 1' // sheetName
            }
        });
    }
</script>
<?php $this->endSection() ?>
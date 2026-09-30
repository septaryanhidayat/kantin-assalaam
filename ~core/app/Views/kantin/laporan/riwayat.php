<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<link href="<?= base_url() ?>/assets/css/datatables/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
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
                <div class="table-responsive">
                    <table id="table" class="table table-hover" width="100%">
                        <thead class="table-light">
                            <th>#</th>
                            <th>Tgl. Transaksi</th>
                            <th>No. Transaksi</th>
                            <th class="text-end">Total Modal</th>
                            <th class="text-end">Total Belanja</th>
                            <th class="text-end">Total Laba</th>
                            <th class="text-end">Struk</th>
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
                                        <?php if (is_null($t->id_guru)) : ?>
                                        <td align="right"><a href="<?= base_url() ?>/petugas/transaksi/struk/siswa/<?= $t->id ?>" target="_blank"><button class="btn btn-primary mb-3">Lihat Struk</button></a></td>
                                        <?php else : ?>
                                        <td align="right"><a href="<?= base_url() ?>/petugas/transaksi/struk/guru/<?= $t->id ?>" target="_blank"><button class="btn btn-primary mb-3">Lihat Struk</button></a></td>
                                        <?php endif ?>
                                    </tr>
                                    <?php $total_modal += $t->modal; ?>
                                    <?php $total_belanja += $t->total; ?>
                                    <?php $total_laba += ($t->total - $t->modal); ?>
                                <?php endforeach ?>
                            <?php else : ?>

                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script src="<?= base_url() ?>/assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/js/datatables/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url() ?>/assets/js/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/assets/js/datatables/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            order: []
        });
    });
</script>
<?php $this->endSection() ?>
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

    <div class="row">
        <div class="col-md-6">
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <h3 class="text-white">Total Saldo Siswa: <?= uang($saldo->saldo) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success">
                <div class="card-body text-center">
                    <h3 class="text-white">Total Saldo Guru: <?= uang($saldo_guru->saldo) ?></h3>
                </div>
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
            serverSide: true,
            responsive: true,
            order: [],
            ajax: '<?= base_url('admin/laporan/data_saldo') ?>',
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'kode'
                },
                {
                    data: 'nis'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'kelas'
                },
                {
                    data: 'saldo'
                },
            ]
        });
    });
</script>
<?php $this->endSection() ?>
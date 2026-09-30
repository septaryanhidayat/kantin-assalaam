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
                        <th>Tgl. Deposit</th>
                        <th>Nama Orang Tua</th>
                        <th>Jumlah Deposit</th>
                        <th>Bank Tujuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody></tbody>
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
            serverSide: true,
            responsive: true,
            order: [],
            ajax: '<?= base_url('petugas/deposit/data') ?>',
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'ortu'
                },
                {
                    data: 'jumlah'
                },
                {
                    data: 'bank'
                },
                {
                    data: 'status'
                },
                {
                    data: 'aksi',
                    orderable: false
                },
            ]
        });
    });
</script>
<?php $this->endSection() ?>
<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<style>
    .stat-card {
        background: #fff;
        border-radius: 8px;
        padding: 15px 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-right: 15px;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Database</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Ringkasan Database -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-primary text-white">
                    <i class="mdi mdi-database"></i>
                </div>
                <div>
                    <span class="text-muted font-size-12">Nama Database</span>
                    <h5 class="mb-0 font-size-15 text-primary"><?= $db_name ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-success text-white">
                    <i class="mdi mdi-table"></i>
                </div>
                <div>
                    <span class="text-muted font-size-12">Total Tabel</span>
                    <h5 class="mb-0 font-size-16"><?= count($tables) ?> Tabel</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-info text-white">
                    <i class="mdi mdi-harddisk"></i>
                </div>
                <div>
                    <span class="text-muted font-size-12">Ukuran Data</span>
                    <h5 class="mb-0 font-size-16"><?= number_format($total_size / 1024, 1) ?> KB</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-warning text-white">
                    <i class="mdi mdi-server"></i>
                </div>
                <div>
                    <span class="text-muted font-size-12">Versi MySQL/MariaDB</span>
                    <h5 class="mb-0 font-size-14"><?= substr($server_info, 0, 15) ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi Cepat -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="mdi mdi-format-list-bulleted me-1"></i> Daftar Tabel Database</h5>
            <div>
                <a href="<?= base_url('admin/database/query') ?>" class="btn btn-primary btn-sm me-2">
                    <i class="mdi mdi-console-line me-1"></i> SQL Query Editor
                </a>
                <a href="<?= base_url('admin/database/backup') ?>" class="btn btn-success btn-sm" onclick="return confirm('Download file backup database (.sql) sekarang?')">
                    <i class="mdi mdi-cloud-download me-1"></i> Download Backup (.sql)
                </a>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Tabel -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">No</th>
                                    <th>Nama Tabel</th>
                                    <th>Engine</th>
                                    <th class="text-end">Perkiraan Baris</th>
                                    <th class="text-end">Ukuran Data</th>
                                    <th>Collation</th>
                                    <th class="text-center" width="220">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($tables as $t) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/database/table/' . $t->table_name) ?>" class="fw-bold text-primary">
                                                <i class="mdi mdi-table me-1"></i> <?= $t->table_name ?>
                                            </a>
                                        </td>
                                        <td><span class="badge bg-secondary"><?= $t->engine ?></span></td>
                                        <td class="text-end"><?= number_format($t->table_rows, 0, ',', '.') ?></td>
                                        <td class="text-end"><?= number_format(($t->data_length + $t->index_length) / 1024, 1) ?> KB</td>
                                        <td><small class="text-muted"><?= $t->table_collation ?></small></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/database/table/' . $t->table_name) ?>" class="btn btn-sm btn-outline-primary" title="Lihat Data">
                                                <i class="mdi mdi-eye me-1"></i> Jelajahi
                                            </a>
                                            <a href="<?= base_url('admin/database/query?sql=' . urlencode('SELECT * FROM `' . $t->table_name . '` LIMIT 50;')) ?>" class="btn btn-sm btn-outline-info" title="Buka Query">
                                                <i class="mdi mdi-code-tags me-1"></i> SQL
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>

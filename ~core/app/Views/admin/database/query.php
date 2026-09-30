<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<style>
    .sql-editor {
        font-family: 'Consolas', 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.5;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }
    .table-badge {
        cursor: pointer;
        transition: all 0.2s;
        margin: 2px;
    }
    .table-badge:hover {
        background-color: #0d6efd !important;
        color: #fff !important;
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
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/database') ?>">Database</a></li>
                        <li class="breadcrumb-item active">Query Editor</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- SQL Editor Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="sql" class="form-label fw-bold mb-0">
                            <i class="mdi mdi-console me-1 text-primary"></i> Masukkan Perintah SQL:
                        </label>
                        <div>
                            <span class="font-size-12 text-muted me-2">Klik tabel untuk pasang nama:</span>
                            <?php foreach (array_slice($tables, 0, 10) as $tbl) : ?>
                                <span class="badge bg-light text-dark border table-badge" onclick="insertTable('<?= $tbl ?>')">
                                    <?= $tbl ?>
                                </span>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <form action="<?= base_url('admin/database/query') ?>" method="post">
                        <div class="mb-3">
                            <textarea name="sql" id="sql" rows="6" class="form-control sql-editor" placeholder="Contoh: SELECT * FROM setting;"><?= htmlspecialchars($sql) ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-play me-1"></i> Jalankan Query (Execute)
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2" onclick="document.getElementById('sql').value = '';">
                                    Bersihkan
                                </button>
                            </div>
                            <div>
                                <small class="text-muted">Template Cepat: </small>
                                <button type="button" class="btn btn-sm btn-light border" onclick="setQuery('SELECT * FROM setting;')">Setting</button>
                                <button type="button" class="btn btn-sm btn-light border" onclick="setQuery('SELECT * FROM siswa LIMIT 25;')">Siswa</button>
                                <button type="button" class="btn btn-sm btn-light border" onclick="setQuery('SELECT * FROM ortu LIMIT 25;')">Ortu</button>
                                <button type="button" class="btn btn-sm btn-light border" onclick="setQuery('SELECT * FROM transaksi ORDER BY id DESC LIMIT 25;')">Transaksi</button>
                                <button type="button" class="btn btn-sm btn-light border" onclick="setQuery('SHOW TABLES;')">Show Tables</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hasil Eksekusi Query -->
    <?php if (!empty($sql)) : ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="mdi mdi-text-box-search-outline me-1"></i> Hasil Eksekusi
                        </h6>
                        <div>
                            <span class="badge bg-info">Waktu: <?= $execution_time ?> ms</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($error !== null) : ?>
                            <!-- Error Message -->
                            <div class="alert alert-danger mb-0">
                                <h6 class="alert-heading fw-bold mb-1"><i class="mdi mdi-alert-circle-outline me-1"></i> Terjadi Kesalahan SQL:</h6>
                                <code><?= htmlspecialchars($error) ?></code>
                            </div>
                        <?php elseif ($is_select) : ?>
                            <!-- Select Result Table -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-success font-size-13 py-2 px-3">
                                    Ditemukan <?= count($result) ?> Baris Data
                                </span>
                            </div>

                            <?php if (!empty($result)) : ?>
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-bordered table-striped table-hover font-size-13 align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th width="40">#</th>
                                                <?php foreach ($columns as $col) : ?>
                                                    <th><?= htmlspecialchars($col) ?></th>
                                                <?php endforeach ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($result as $row) : ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <?php foreach ($columns as $col) : ?>
                                                        <td>
                                                            <?php if ($row[$col] === null) : ?>
                                                                <span class="text-muted fst-italic">NULL</span>
                                                            <?php else : ?>
                                                                <?= htmlspecialchars($row[$col]) ?>
                                                            <?php endif ?>
                                                        </td>
                                                    <?php endforeach ?>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning text-center mb-0">
                                    Query berhasil dijalankan, namun menghasilkan 0 baris data (kosong).
                                </div>
                            <?php endif ?>
                        <?php else : ?>
                            <!-- DML / DDL Result Message -->
                            <div class="alert alert-success mb-0">
                                <h6 class="alert-heading fw-bold mb-1"><i class="mdi mdi-check-circle-outline me-1"></i> Query Berhasil Dijalankan!</h6>
                                <p class="mb-0">Perintah berhasil dieksekusi. Jumlah baris yang terpengaruh: <strong><?= $affected_rows ?></strong> baris.</p>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>
<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script>
    function setQuery(q) {
        document.getElementById('sql').value = q;
    }
    function insertTable(tableName) {
        var editor = document.getElementById('sql');
        editor.value += ' ' + tableName;
        editor.focus();
    }
</script>
<?php $this->endSection() ?>

<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<style>
    .cell-truncate {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Tabel: <span class="text-primary"><?= $table_name ?></span></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/database') ?>">Database</a></li>
                        <li class="breadcrumb-item active"><?= $table_name ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Header & Action Buttons -->
    <div class="row mb-3">
        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <a href="<?= base_url('admin/database') ?>" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="mdi mdi-arrow-left me-1"></i> Daftar Tabel
                </a>
                <a href="<?= base_url('admin/database/create/' . $table_name) ?>" class="btn btn-success btn-sm me-2">
                    <i class="mdi mdi-plus-circle me-1"></i> Tambah Data Baru
                </a>
                <span class="badge bg-info font-size-13 py-2 px-3">Total: <?= number_format($total_rows, 0, ',', '.') ?> Baris Data</span>
            </div>
            <div>
                <a href="<?= base_url('admin/database/query?sql=' . urlencode('SELECT * FROM `' . $table_name . '` LIMIT 50;')) ?>" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-console-line me-1"></i> Buka di Query Editor
                </a>
            </div>
        </div>
    </div>

    <!-- Nav Tabs: Data & Struktur -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab-data" role="tab">
                                <i class="mdi mdi-table me-1"></i> Isi Data (Browse)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-struktur" role="tab">
                                <i class="mdi mdi-cogs me-1"></i> Struktur Kolom
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab 1: Data Tabel -->
                        <div class="tab-pane active" id="tab-data" role="tabpanel">
                            
                            <!-- Search & Filter Bar -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6 col-lg-5">
                                    <form action="<?= base_url('admin/database/table/' . $table_name) ?>" method="get" class="d-flex">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="q" class="form-control" placeholder="Cari di semua kolom..." value="<?= htmlspecialchars($search ?? '') ?>">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="mdi mdi-magnify me-1"></i> Cari
                                            </button>
                                            <?php if (!empty($search)) : ?>
                                                <a href="<?= base_url('admin/database/table/' . $table_name) ?>" class="btn btn-outline-secondary" title="Reset Pencarian">
                                                    <i class="mdi mdi-close"></i>
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    </form>
                                </div>
                                <?php if (!empty($search)) : ?>
                                    <div class="col-md-6 mt-2 mt-md-0">
                                        <span class="text-muted font-size-13">
                                            Menampilkan hasil pencarian: <strong>"<?= htmlspecialchars($search) ?>"</strong>
                                            (<?= number_format($total_rows, 0, ',', '.') ?> data)
                                        </span>
                                    </div>
                                <?php endif ?>
                            </div>

                            <?php if (!empty($rows)) : ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover font-size-13 align-middle mb-3">
                                        <thead class="table-light">
                                            <tr>
                                                <?php if ($primary_key) : ?>
                                                    <th width="85" class="text-center">Aksi</th>
                                                <?php endif ?>
                                                <?php foreach ($columns as $c) : ?>
                                                    <th>
                                                        <?= $c->Field ?>
                                                        <?php if ($c->Key == 'PRI') : ?>
                                                            <span class="badge bg-primary font-size-10">PK</span>
                                                        <?php endif ?>
                                                    </th>
                                                <?php endforeach ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rows as $r) : ?>
                                                <tr>
                                                    <?php if ($primary_key) : ?>
                                                        <td class="text-center text-nowrap">
                                                            <a href="<?= base_url('admin/database/edit/' . $table_name . '?pk=' . urlencode($primary_key) . '&val=' . urlencode($r[$primary_key] ?? '')) ?>" 
                                                               class="btn btn-warning btn-sm p-1 me-1" 
                                                               title="Edit Baris">
                                                                <i class="mdi mdi-pencil font-size-14 text-dark"></i>
                                                            </a>
                                                            <a href="<?= base_url('admin/database/delete_row/' . $table_name . '?pk=' . urlencode($primary_key) . '&val=' . urlencode($r[$primary_key] ?? '')) ?>" 
                                                               class="btn btn-danger btn-sm p-1" 
                                                               onclick="return confirm('Hapus baris data ini secara permanen?')" 
                                                               title="Hapus Baris">
                                                                <i class="mdi mdi-trash-can font-size-14"></i>
                                                            </a>
                                                        </td>
                                                    <?php endif ?>
                                                    <?php foreach ($columns as $c) : ?>
                                                        <td class="cell-truncate" title="<?= htmlspecialchars($r[$c->Field] ?? '') ?>">
                                                            <?php if ($r[$c->Field] === null) : ?>
                                                                <span class="text-muted fst-italic">NULL</span>
                                                            <?php else : ?>
                                                                <?= htmlspecialchars(substr($r[$c->Field], 0, 100)) ?>
                                                            <?php endif ?>
                                                        </td>
                                                    <?php endforeach ?>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <?php if ($total_pages > 1) : ?>
                                    <?php 
                                    $qParam = !empty($search) ? '&q=' . urlencode($search) : '';
                                    ?>
                                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                        <div>
                                            <small class="text-muted">Halaman <?= $page ?> dari <?= $total_pages ?> (Menampilkan baris <?= (($page - 1) * $limit) + 1 ?> - <?= min($page * $limit, $total_rows) ?>)</small>
                                        </div>
                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <?php if ($page > 1) : ?>
                                                    <li class="page-item"><a class="page-link" href="<?= base_url('admin/database/table/' . $table_name . '?page=' . ($page - 1) . $qParam) ?>">&laquo; Prev</a></li>
                                                <?php endif ?>
                                                <?php for ($p = max(1, $page - 3); $p <= min($total_pages, $page + 3); $p++) : ?>
                                                    <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                                                        <a class="page-link" href="<?= base_url('admin/database/table/' . $table_name . '?page=' . $p . $qParam) ?>"><?= $p ?></a>
                                                    </li>
                                                <?php endfor ?>
                                                <?php if ($page < $total_pages) : ?>
                                                    <li class="page-item"><a class="page-link" href="<?= base_url('admin/database/table/' . $table_name . '?page=' . ($page + 1) . $qParam) ?>">Next &raquo;</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </nav>
                                    </div>
                                <?php endif ?>
                            <?php else : ?>
                                <div class="alert alert-info text-center py-4 mb-0">
                                    <i class="mdi mdi-information-outline font-size-22 d-block mb-1"></i>
                                    <?php if (!empty($search)) : ?>
                                        Tidak ditemukan data yang cocok dengan kata kunci <strong>"<?= htmlspecialchars($search) ?>"</strong>.
                                        <br>
                                        <a href="<?= base_url('admin/database/table/' . $table_name) ?>" class="btn btn-sm btn-outline-info mt-2">
                                            <i class="mdi mdi-refresh me-1"></i> Reset Pencarian
                                        </a>
                                    <?php else : ?>
                                        Tabel ini masih kosong (belum ada baris data).
                                        <br>
                                        <a href="<?= base_url('admin/database/create/' . $table_name) ?>" class="btn btn-sm btn-success mt-2">
                                            <i class="mdi mdi-plus me-1"></i> Tambah Data Pertama
                                        </a>
                                    <?php endif ?>
                                </div>
                            <?php endif ?>
                        </div>

                        <!-- Tab 2: Struktur Kolom -->
                        <div class="tab-pane" id="tab-struktur" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover font-size-13 align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Field / Kolom</th>
                                            <th>Tipe Data</th>
                                            <th>Collation</th>
                                            <th>Null</th>
                                            <th>Key</th>
                                            <th>Default</th>
                                            <th>Extra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($columns as $c) : ?>
                                            <tr>
                                                <td class="fw-bold text-primary">
                                                    <?= $c->Field ?>
                                                    <?php if ($c->Key == 'PRI') : ?>
                                                        <i class="mdi mdi-key text-warning ms-1" title="Primary Key"></i>
                                                    <?php endif ?>
                                                </td>
                                                <td><code><?= $c->Type ?></code></td>
                                                <td><small class="text-muted"><?= $c->Collation ?? '-' ?></small></td>
                                                <td><?= ($c->Null == 'YES') ? '<span class="badge bg-secondary">YES</span>' : '<span class="badge bg-dark">NO</span>' ?></td>
                                                <td>
                                                    <?php if ($c->Key == 'PRI') : ?>
                                                        <span class="badge bg-warning text-dark">PRIMARY</span>
                                                    <?php elseif ($c->Key == 'UNI') : ?>
                                                        <span class="badge bg-info">UNIQUE</span>
                                                    <?php elseif ($c->Key == 'MUL') : ?>
                                                        <span class="badge bg-secondary">INDEX</span>
                                                    <?php else : ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td><small><?= $c->Default !== null ? htmlspecialchars($c->Default) : '<em>NULL</em>' ?></small></td>
                                                <td><small class="text-muted"><?= $c->Extra ?? '-' ?></small></td>
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
    </div>
</div>
<?php $this->endSection() ?>

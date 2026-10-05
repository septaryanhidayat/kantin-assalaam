<?php $this->extend('admin/template'); ?>

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
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/database/table/' . $table_name) ?>"><?= $table_name ?></a></li>
                        <li class="breadcrumb-item active"><?= ($action == 'create') ? 'Tambah' : 'Edit' ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-<?= ($action == 'create') ? 'plus-circle' : 'pencil' ?> me-1 text-primary"></i>
                        <?= ($action == 'create') ? 'Tambah Baris Baru pada Tabel: ' : 'Edit Baris Data pada Tabel: ' ?> 
                        <strong><?= $table_name ?></strong>
                    </h5>
                    <a href="<?= base_url('admin/database/table/' . $table_name) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="mdi mdi-arrow-left me-1"></i> Batal & Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/database/' . (($action == 'create') ? 'save_row/' : 'update_row/') . $table_name) ?>" method="post">
                        
                        <?php if ($action == 'edit') : ?>
                            <input type="hidden" name="pk_field" value="<?= $primary_key ?>">
                            <input type="hidden" name="pk_value" value="<?= htmlspecialchars($pk_value) ?>">
                        <?php endif ?>

                        <?php foreach ($columns as $c) : ?>
                            <?php 
                            $field = $c->Field;
                            $rawVal = $row[$field] ?? null;
                            $val = $rawVal ?? '';
                            $isPk = ($c->Key == 'PRI');
                            $isAutoInc = ($c->Extra == 'auto_increment');
                            $isNullable = ($c->Null == 'YES');
                            $isPassword = (stripos($field, 'password') !== false);
                            ?>

                            <div class="mb-3 row">
                                <label for="field_<?= $field ?>" class="col-sm-3 col-form-label fw-bold">
                                    <?= $field ?>
                                    <br>
                                    <small class="text-muted fw-normal">
                                        <code><?= $c->Type ?></code>
                                        <?php if ($isPk) : ?>
                                            <span class="badge bg-warning text-dark font-size-10">PRI</span>
                                        <?php endif ?>
                                        <?php if ($isAutoInc) : ?>
                                            <span class="badge bg-info font-size-10">AUTO_INC</span>
                                        <?php endif ?>
                                    </small>
                                </label>
                                <div class="col-sm-9">
                                    <?php if ($isAutoInc && $action == 'create') : ?>
                                        <input type="text" class="form-control" name="data[<?= $field ?>]" id="field_<?= $field ?>" placeholder="(Auto Increment - Dibuat otomatis jika dikosongkan)">
                                    
                                    <?php elseif ($isAutoInc && $action == 'edit') : ?>
                                        <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($val) ?>" readonly>
                                        <small class="text-muted">Primary key Auto Increment tidak dapat diubah.</small>

                                    <?php elseif ($isPassword) : ?>
                                        <input type="text" class="form-control" name="data[<?= $field ?>]" id="field_<?= $field ?>" 
                                               placeholder="<?= ($action == 'edit') ? '(Kosongkan jika tidak ingin mengubah password)' : 'Masukkan password' ?>">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="hash_bcrypt[<?= $field ?>]" value="1" id="hash_<?= $field ?>" checked>
                                            <label class="form-check-label font-size-12 text-primary" for="hash_<?= $field ?>">
                                                <i class="mdi mdi-lock-outline"></i> Enkripsi otomatis dengan BCRYPT (password_hash)
                                            </label>
                                        </div>

                                    <?php elseif (stripos($c->Type, 'text') !== false || stripos($c->Type, 'json') !== false) : ?>
                                        <textarea class="form-control font-monospace" name="data[<?= $field ?>]" id="field_<?= $field ?>" rows="4"><?= htmlspecialchars($val) ?></textarea>

                                    <?php elseif ($c->Type == 'date') : ?>
                                        <input type="date" class="form-control" name="data[<?= $field ?>]" id="field_<?= $field ?>" value="<?= htmlspecialchars($val) ?>">

                                    <?php elseif (stripos($c->Type, 'datetime') !== false || stripos($c->Type, 'timestamp') !== false) : ?>
                                        <input type="text" class="form-control" name="data[<?= $field ?>]" id="field_<?= $field ?>" 
                                               value="<?= htmlspecialchars(($action == 'create' && empty($val)) ? date('Y-m-d H:i:s') : $val) ?>" 
                                               placeholder="YYYY-MM-DD HH:MM:SS">

                                    <?php else : ?>
                                        <input type="text" class="form-control" name="data[<?= $field ?>]" id="field_<?= $field ?>" value="<?= htmlspecialchars($val) ?>">
                                    <?php endif ?>

                                    <?php if ($isNullable && !$isAutoInc) : ?>
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_null[<?= $field ?>]" value="1" id="null_<?= $field ?>" <?= ($action == 'edit' && $rawVal === null) ? 'checked' : '' ?>>
                                            <label class="form-check-label font-size-12 text-muted" for="null_<?= $field ?>">
                                                Set Nilai NULL
                                            </label>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endforeach ?>

                        <div class="row mt-4">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="mdi mdi-content-save me-1"></i> <?= ($action == 'create') ? 'Simpan Baris Baru' : 'Simpan Perubahan' ?>
                                </button>
                                <a href="<?= base_url('admin/database/table/' . $table_name) ?>" class="btn btn-secondary ms-2">
                                    Batal
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>

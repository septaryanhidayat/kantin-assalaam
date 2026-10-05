<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Database extends BaseController
{
    private function checkAuth()
    {
        if (session()->get('logged_in') == null || session()->get('level_admin') != true) {
            return false;
        }
        $admin = $this->admin->find(session()->get('id'));
        return ($admin && $admin->level == 1);
    }

    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $dbName = $db->database;

        $tables = $db->query("
            SELECT 
                TABLE_NAME as table_name,
                ENGINE as engine,
                TABLE_ROWS as table_rows,
                DATA_LENGTH as data_length,
                INDEX_LENGTH as index_length,
                TABLE_COLLATION as table_collation,
                UPDATE_TIME as update_time
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = ?
            ORDER BY TABLE_NAME ASC
        ", [$dbName])->getResult();

        $totalSize = 0;
        $totalRows = 0;
        foreach ($tables as $t) {
            $totalSize += ($t->data_length + $t->index_length);
            $totalRows += $t->table_rows;
        }

        $serverInfo = $db->getVersion();

        $data = [
            'title'       => 'Manajemen Database',
            'session'     => session()->get(),
            'segment'     => $this->request->uri->getSegments(),
            'admin'       => $this->admin->find(session()->get('id')),
            'db_name'     => $dbName,
            'tables'      => $tables,
            'total_size'  => $totalSize,
            'total_rows'  => $totalRows,
            'server_info' => $serverInfo,
        ];

        return view('admin/database/index', $data);
    }

    public function table($tableName = null)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($tableName) || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Nama tabel tidak valid.', 'type' => 'error']);
            return redirect()->to(base_url('admin/database'));
        }

        $db = \Config\Database::connect();

        if (!$db->tableExists($tableName)) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => "Tabel '$tableName' tidak ditemukan.", 'type' => 'error']);
            return redirect()->to(base_url('admin/database'));
        }

        // Get columns metadata
        $columns = $db->query("SHOW FULL COLUMNS FROM `" . $tableName . "`")->getResult();

        $primaryKey = null;
        foreach ($columns as $c) {
            if ($c->Key == 'PRI') {
                $primaryKey = $c->Field;
                break;
            }
        }

        // Search functionality
        $search = trim($this->request->getGet('q') ?? '');

        // Pagination
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 50;
        $offset = ($page - 1) * $limit;

        $queryBuilder = $db->table($tableName);

        if (!empty($search)) {
            $queryBuilder->groupStart();
            foreach ($columns as $c) {
                $queryBuilder->orLike($c->Field, $search);
            }
            $queryBuilder->groupEnd();
        }

        $totalRows = $queryBuilder->countAllResults(false);
        $totalPages = ceil($totalRows / $limit);

        if ($primaryKey) {
            $queryBuilder->orderBy($primaryKey, 'DESC');
        }
        $rows = $queryBuilder->limit($limit, $offset)->get()->getResultArray();

        $data = [
            'title'        => 'Tabel: ' . $tableName,
            'session'      => session()->get(),
            'segment'      => $this->request->uri->getSegments(),
            'admin'        => $this->admin->find(session()->get('id')),
            'table_name'   => $tableName,
            'columns'      => $columns,
            'primary_key'  => $primaryKey,
            'rows'         => $rows,
            'total_rows'   => $totalRows,
            'page'         => $page,
            'total_pages'  => $totalPages,
            'limit'        => $limit,
            'search'       => $search,
        ];

        return view('admin/database/table', $data);
    }

    public function create($tableName = null)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($tableName) || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            return redirect()->to(base_url('admin/database'));
        }

        $db = \Config\Database::connect();
        if (!$db->tableExists($tableName)) {
            return redirect()->to(base_url('admin/database'));
        }

        $columns = $db->query("SHOW FULL COLUMNS FROM `" . $tableName . "`")->getResult();

        $data = [
            'title'       => 'Tambah Baris Baru: ' . $tableName,
            'session'     => session()->get(),
            'segment'     => $this->request->uri->getSegments(),
            'admin'       => $this->admin->find(session()->get('id')),
            'table_name'  => $tableName,
            'columns'     => $columns,
            'action'      => 'create',
            'row'         => [],
            'primary_key' => null,
        ];

        return view('admin/database/form', $data);
    }

    public function save_row($tableName = null)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($tableName) || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            return redirect()->to(base_url('admin/database'));
        }

        $db = \Config\Database::connect();
        $columns = $db->query("SHOW FULL COLUMNS FROM `" . $tableName . "`")->getResult();

        $insertData = [];
        $rawPost = $this->request->getPost('data') ?? [];
        $nullPost = $this->request->getPost('is_null') ?? [];
        $hashPost = $this->request->getPost('hash_bcrypt') ?? [];

        foreach ($columns as $c) {
            $field = $c->Field;

            // If user checked set NULL
            if (isset($nullPost[$field]) && $c->Null == 'YES') {
                $insertData[$field] = null;
                continue;
            }

            // If auto-increment primary key and left blank, let MySQL auto-generate
            if ($c->Extra == 'auto_increment' && (!isset($rawPost[$field]) || trim($rawPost[$field]) === '')) {
                continue;
            }

            if (isset($rawPost[$field])) {
                $val = $rawPost[$field];

                // Check bcrypt hash option (e.g. for password)
                if (isset($hashPost[$field]) && !empty($val)) {
                    $val = password_hash($val, PASSWORD_BCRYPT);
                }

                if ($val === '' && $c->Null == 'YES') {
                    $insertData[$field] = null;
                } else {
                    $insertData[$field] = $val;
                }
            }
        }

        try {
            $db->table($tableName)->insert($insertData);
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => "Baris baru berhasil ditambahkan ke tabel '$tableName'.", 'type' => 'success']);
        } catch (\Throwable $e) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => $e->getMessage(), 'type' => 'error']);
            return redirect()->to(base_url('admin/database/create/' . $tableName))->withInput();
        }

        return redirect()->to(base_url('admin/database/table/' . $tableName));
    }

    public function edit($tableName = null)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($tableName) || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            return redirect()->to(base_url('admin/database'));
        }

        $pk = $this->request->getGet('pk');
        $val = $this->request->getGet('val');

        if (empty($pk) || $val === null || $val === '') {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Kunci primary key tidak valid.', 'type' => 'error']);
            return redirect()->to(base_url('admin/database/table/' . $tableName));
        }

        $db = \Config\Database::connect();
        $row = $db->table($tableName)->where($pk, $val)->get()->getRowArray();

        if (!$row) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Data tidak ditemukan.', 'type' => 'error']);
            return redirect()->to(base_url('admin/database/table/' . $tableName));
        }

        $columns = $db->query("SHOW FULL COLUMNS FROM `" . $tableName . "`")->getResult();

        $data = [
            'title'       => 'Edit Baris: ' . $tableName . ' (' . $pk . ' = ' . $val . ')',
            'session'     => session()->get(),
            'segment'     => $this->request->uri->getSegments(),
            'admin'       => $this->admin->find(session()->get('id')),
            'table_name'  => $tableName,
            'columns'     => $columns,
            'action'      => 'edit',
            'row'         => $row,
            'primary_key' => $pk,
            'pk_value'    => $val,
        ];

        return view('admin/database/form', $data);
    }

    public function update_row($tableName = null)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($tableName) || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            return redirect()->to(base_url('admin/database'));
        }

        $pk = $this->request->getPost('pk_field');
        $pkVal = $this->request->getPost('pk_value');

        if (empty($pk) || $pkVal === null || $pkVal === '') {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Kunci primary key tidak valid.', 'type' => 'error']);
            return redirect()->to(base_url('admin/database/table/' . $tableName));
        }

        $db = \Config\Database::connect();
        $columns = $db->query("SHOW FULL COLUMNS FROM `" . $tableName . "`")->getResult();

        $updateData = [];
        $rawPost = $this->request->getPost('data') ?? [];
        $nullPost = $this->request->getPost('is_null') ?? [];
        $hashPost = $this->request->getPost('hash_bcrypt') ?? [];

        foreach ($columns as $c) {
            $field = $c->Field;

            // Jangan update kolom primary key jika auto increment
            if ($field === $pk && $c->Extra == 'auto_increment') {
                continue;
            }

            // Jika dicentang set NULL
            if (isset($nullPost[$field]) && $c->Null == 'YES') {
                $updateData[$field] = null;
                continue;
            }

            if (isset($rawPost[$field])) {
                $val = $rawPost[$field];

                // Khusus kolom password: jika kosong di mode edit, jangan diubah
                if (stripos($field, 'password') !== false && trim($val) === '') {
                    continue;
                }

                // Check bcrypt hash option
                if (isset($hashPost[$field]) && !empty($val)) {
                    $val = password_hash($val, PASSWORD_BCRYPT);
                }

                if ($val === '' && $c->Null == 'YES') {
                    $updateData[$field] = null;
                } else {
                    $updateData[$field] = $val;
                }
            }
        }

        try {
            if (!empty($updateData)) {
                $db->table($tableName)->where($pk, $pkVal)->update($updateData);
            }
            session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => "Data pada tabel '$tableName' berhasil diperbarui.", 'type' => 'success']);
        } catch (\Throwable $e) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => $e->getMessage(), 'type' => 'error']);
            return redirect()->to(base_url('admin/database/edit/' . $tableName . '?pk=' . urlencode($pk) . '&val=' . urlencode($pkVal)))->withInput();
        }

        return redirect()->to(base_url('admin/database/table/' . $tableName));
    }

    public function delete_row($tableName = null)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($tableName) || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => 'Tabel tidak valid.', 'type' => 'error']);
            return redirect()->to(base_url('admin/database'));
        }

        $pk = $this->request->getGet('pk');
        $val = $this->request->getGet('val');

        if (!empty($pk) && $val !== null && $val !== '') {
            $db = \Config\Database::connect();
            try {
                $db->table($tableName)->where($pk, $val)->delete();
                session()->setFlashData(['alert' => true, 'title' => 'SUKSES', 'message' => 'Baris data berhasil dihapus.', 'type' => 'success']);
            } catch (\Throwable $e) {
                session()->setFlashData(['alert' => true, 'title' => 'ERROR', 'message' => $e->getMessage(), 'type' => 'error']);
            }
        }

        return redirect()->to(base_url('admin/database/table/' . $tableName));
    }

    public function query()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $sql = trim($this->request->getPost('sql') ?? $this->request->getGet('sql') ?? '');

        $result = null;
        $columns = [];
        $error = null;
        $affectedRows = 0;
        $executionTime = 0;
        $isSelect = false;

        if (!empty($sql)) {
            $startTime = microtime(true);
            try {
                // Determine query type
                $firstWord = strtoupper(strtok($sql, " \t\n\r;"));
                if (in_array($firstWord, ['SELECT', 'SHOW', 'DESCRIBE', 'DESC', 'EXPLAIN'])) {
                    $isSelect = true;
                    $queryObj = $db->query($sql);
                    $result = $queryObj->getResultArray();
                    if (!empty($result)) {
                        $columns = array_keys($result[0]);
                    }
                } else {
                    $isSelect = false;
                    $db->query($sql);
                    $affectedRows = $db->affectedRows();
                }
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }
            $executionTime = round((microtime(true) - $startTime) * 1000, 2);
        }

        // Get table names for auto-complete/quick click
        $dbName = $db->database;
        $tableList = $db->query("SHOW TABLES")->getResultArray();
        $tables = [];
        foreach ($tableList as $t) {
            $tables[] = reset($t);
        }

        $data = [
            'title'          => 'SQL Query Editor',
            'session'        => session()->get(),
            'segment'        => $this->request->uri->getSegments(),
            'admin'          => $this->admin->find(session()->get('id')),
            'sql'            => $sql,
            'result'         => $result,
            'columns'        => $columns,
            'error'          => $error,
            'affected_rows'  => $affectedRows,
            'execution_time' => $executionTime,
            'is_select'      => $isSelect,
            'tables'         => $tables,
        ];

        return view('admin/database/query', $data);
    }

    public function backup()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $dbName = $db->database;

        // Collect table list
        $tableList = $db->query("SHOW TABLES")->getResultArray();

        $sqlDump = "-- Database Backup: $dbName\n";
        $sqlDump .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sqlDump .= "-- Server Version: " . $db->getVersion() . "\n\n";
        $sqlDump .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sqlDump .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $sqlDump .= "START TRANSACTION;\n\n";

        foreach ($tableList as $row) {
            $tableName = reset($row);

            // Table structure
            $createTable = $db->query("SHOW CREATE TABLE `$tableName`")->getRowArray();
            $sqlDump .= "-- --------------------------------------------------------\n";
            $sqlDump .= "-- Table structure for `$tableName`\n";
            $sqlDump .= "-- --------------------------------------------------------\n";
            $sqlDump .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sqlDump .= $createTable['Create Table'] . ";\n\n";

            // Table data
            $rows = $db->table($tableName)->get()->getResultArray();
            if (!empty($rows)) {
                $sqlDump .= "-- Dumping data for `$tableName`\n";
                $columns = array_keys($rows[0]);
                $colNames = implode('`, `', $columns);

                foreach (array_chunk($rows, 100) as $chunk) {
                    $sqlDump .= "INSERT INTO `$tableName` (`$colNames`) VALUES\n";
                    $valueLines = [];
                    foreach ($chunk as $r) {
                        $escapedValues = array_map(function ($val) use ($db) {
                            if ($val === null) return 'NULL';
                            return $db->escape($val);
                        }, array_values($r));
                        $valueLines[] = '(' . implode(', ', $escapedValues) . ')';
                    }
                    $sqlDump .= implode(",\n", $valueLines) . ";\n\n";
                }
            }
        }

        $sqlDump .= "COMMIT;\n";
        $sqlDump .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $fileName = 'backup_' . $dbName . '_' . date('Y-m-d_His') . '.sql';

        return $this->response
            ->setHeader('Content-Type', 'application/sql')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->setBody($sqlDump);
    }
}

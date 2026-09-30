<?php

if (!function_exists('format_indo')) {
    function format_indo($date)
    {
        // array hari dan bulan
        $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        $hari = date("w", strtotime($date));
        $result = $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

        return $result;
    }
}

function kode_kantin($nomor)
{
    return 'K' . sprintf('%04d', $nomor);
}

function kode_siswa($nomor)
{
    return 'S' . sprintf('%04d', $nomor);
}

function kode_ortu($nomor)
{
    return 'W' . sprintf('%04d', $nomor);
}

function kode_guru($nomor)
{
    return 'G' . sprintf('%04d', $nomor);
}

function nomor_transaksi($nomor)
{
    return 'T' . sprintf('%07d', $nomor);
}

function uang($nominal)
{
    return 'Rp. ' . number_format($nominal, 0, ',', '.');
}

if (!function_exists('nama_bulan')) {
    function nama_bulan($bulan)
    {
        $bulan = (int)$bulan;
        $Bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        return isset($Bulan[$bulan]) ? $Bulan[$bulan] : '';
    }
}

if (!function_exists('format_bulan_tahun')) {
    function format_bulan_tahun($periode)
    {
        $parts = explode('-', $periode);
        if (count($parts) == 2) {
            return nama_bulan($parts[1]) . ' ' . $parts[0];
        }
        return $periode;
    }
}

if (!function_exists('foto_barang')) {
    function foto_barang($filename)
    {
        if (empty($filename)) {
            return base_url('assets/food/food.png');
        }

        $baseDir = defined('FCPATH') ? FCPATH : (ROOTPATH . '../');
        $foodDir = rtrim($baseDir, '\\/ ') . '/assets/food/';

        // If filename already ends with .webp
        if (substr(strtolower($filename), -5) === '.webp') {
            return base_url('assets/food/' . $filename);
        }

        // Check if corresponding .webp exists
        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $webpName = $nameWithoutExt . '.webp';
        if (is_file($foodDir . $webpName)) {
            return base_url('assets/food/' . $webpName);
        }

        // Check if original file exists
        if (is_file($foodDir . $filename)) {
            return base_url('assets/food/' . $filename);
        }

        // Fallback to food.webp or food.png
        if (is_file($foodDir . 'food.webp')) {
            return base_url('assets/food/food.webp');
        }

        return base_url('assets/food/food.png');
    }
}



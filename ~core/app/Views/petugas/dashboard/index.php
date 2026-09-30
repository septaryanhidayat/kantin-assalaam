<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<?php $this->endSection() ?>

<?php $this->section('content') ?>

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18"><?= $title ?></h4> <h4 style="color:#fff"><i class="fa fa-map-marker"></i> <?= $nama_kantin ?></h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Aplikasi Kantin</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card bg-info overflow-hidden">
                <div class="card-body text-center text-white">
                    <h2 class="text-white"><?= $trx ?></h2>
                    Total Transaksi Hari ini
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-primary overflow-hidden">
                <div class="card-body text-center text-white">
                    <h2 class="text-white"><?= uang($modal) ?></h2>
                    Total Modal Hari ini
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-success overflow-hidden">
                <div class="card-body text-center text-white">
                    <h2 class="text-white"><?= uang($total) ?></h2>
                    Total Penjualan Hari ini
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-warning overflow-hidden">
                <div class="card-body text-center text-white">
                    <h2 class="text-white"><?= uang($laba) ?></h2>
                    Total Laba Hari ini
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Grafik Transaksi</h4>

                    <div id="column_chart_datalabel" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!--end card-->
        </div>
    </div>
</div>


<?php
$today = date("Y-m-d");
$today_1 = date('Y-m-d', strtotime($today . "-1 days"));
$today_2 = date('Y-m-d', strtotime($today . "-2 days"));
$today_3 = date('Y-m-d', strtotime($today . "-3 days"));
$today_4 = date('Y-m-d', strtotime($today . "-4 days"));
$today_5 = date('Y-m-d', strtotime($today . "-5 days"));
$today_6 = date('Y-m-d', strtotime($today . "-6 days"));
$today_7 = date('Y-m-d', strtotime($today . "-7 days"));
$today_8 = date('Y-m-d', strtotime($today . "-8 days"));
$today_9 = date('Y-m-d', strtotime($today . "-9 days"));
$today_10 = date('Y-m-d', strtotime($today . "-10 days"));
$today_11 = date('Y-m-d', strtotime($today . "-11 days"));
$today_12 = date('Y-m-d', strtotime($today . "-12 days"));
$today_13 = date('Y-m-d', strtotime($today . "-13 days"));
$today_14 = date('Y-m-d', strtotime($today . "-14 days"));

$db = db_connect();
$t0  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t1  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_1%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t2  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_2%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t3  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_3%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t4  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_4%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t5  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_5%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t6  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_6%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t7  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_7%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t8  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_8%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t9  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_9%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t10  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_10%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t11  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_11%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t12  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_12%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t13  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_13%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();
$t14  = $db->query("SELECT updated_at FROM transaksi WHERE updated_at LIKE '$today_14%' AND status='1' AND id_kantin=$id_kantin")->getNumRows();

?>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>
<script>
    options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    position: "top"
                }
            }
        },
        dataLabels: {
            enabled: !0,
            formatter: function(e) {
                return e + " trx"
            },
            offsetY: -20,
            style: {
                fontSize: "12px",
                colors: ["#304758"]
            }
        },
        series: [{
            name: "Total Transaksi",
            data: [<?= $t14 ?>, <?= $t13 ?>, <?= $t12 ?>, <?= $t11 ?>, <?= $t10 ?>, <?= $t9 ?>, <?= $t8 ?>, <?= $t7 ?>, <?= $t6 ?>, <?= $t5 ?>, <?= $t4 ?>, <?= $t3 ?>, <?= $t2 ?>, <?= $t1 ?>, <?= $t0 ?>, ]
        }],
        colors: ["#3b5de7"],
        grid: {
            borderColor: "#f1f1f1"
        },
        xaxis: {
            categories: ["<?= $today_14 ?>", "<?= $today_13 ?>", "<?= $today_12 ?>", "<?= $today_11 ?>", "<?= $today_10 ?>", "<?= $today_9 ?>", "<?= $today_8 ?>", "<?= $today_7 ?>", "<?= $today_6 ?>", "<?= $today_5 ?>", "<?= $today_4 ?>", "<?= $today_3 ?>", "<?= $today_2 ?>", "<?= $today_1 ?>", "<?= $today ?>"],
            position: "bottom",
            labels: {
                offsetY: 0
            },
            axisBorder: {
                show: !1
            },
            axisTicks: {
                show: !1
            },
            crosshairs: {
                fill: {
                    type: "gradient",
                    gradient: {
                        colorFrom: "#D8E3F0",
                        colorTo: "#BED1E6",
                        stops: [0, 100],
                        opacityFrom: .4,
                        opacityTo: .5
                    }
                }
            },
            tooltip: {
                enabled: !0,
                offsetY: -35
            }
        },
        fill: {
            gradient: {
                shade: "light",
                type: "horizontal",
                shadeIntensity: .25,
                gradientToColors: void 0,
                inverseColors: !0,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            }
        },
        yaxis: {
            axisBorder: {
                show: !1
            },
            axisTicks: {
                show: !1
            },
            labels: {
                show: !1,
                formatter: function(e) {
                    return e + " trx."
                }
            }
        },
        title: {
            text: "Tanggal",
            floating: !0,
            offsetY: 350,
            align: "center",
            style: {
                color: "#444"
            }
        }
    };
    (chart = new ApexCharts(document.querySelector("#column_chart_datalabel"), options)).render();
</script>
<?php $this->endSection() ?>
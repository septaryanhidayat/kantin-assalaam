<html>

<head>
    <style>
        .padding {
            border: 1px solid #ff5722;
            margin: 5px;
            float: left;
            border-radius: 15px;
        }

        .header {
            width: 100%;
            color: #e6ebe0;
            position: absolute;
            z-index: 999;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .font {
            height: 300px;
            width: 220px;
            position: relative;
            border-radius: 10px;
        }

        .top {
            height: 30%;
            width: 100%;
            background-color: #ff5722;
            position: relative;
            z-index: 5;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .bottom {
            height: 70%;
            width: 100%;
            background-color: white;
            position: absolute;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .top img {
            height: 70px;
            width: 70px;
            background-color: #e6ebe0;
            border-radius: 10px;
            position: absolute;
            top: 60px;
            left: 34%;
        }

        .bottom p {
            position: relative;
            top: 50px;
            text-align: center;
            text-transform: capitalize;
            font-weight: bold;
            font-size: 20px;
            text-emphasis: spacing;
            margin: 0;
        }

        .bottom .desi {
            font-size: 12px;
            color: grey;
            font-weight: normal;
            margin: 0;
        }

        .bottom .no {
            font-size: 15px;
            font-weight: normal;
            margin: 0;
        }

        .barcode img {
            height: 100px;
            width: 100px;
            text-align: center;
        }

        .barcode {
            text-align: center;
            position: relative;
            top: 50px;
        }

        .btn {
            padding: 5px 10px;
            text-align: center;
            background-color: #005206;
            border-radius: 5px;
            color: #e6ebe0;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <a href="#" class="btn" onclick="printDiv('qrcode')">Cetak</a>
    <hr>
    <div id="qrcode">
        <?php if (!empty($siswa)) : ?>

            <div class="padding">
                <div class="font">
                    <div class="header">
                        KANTIN DIGITAL<br>
                        PONDOK PESANTREN AS SALAAM JAYAPURA
                    </div>
                    <div class="top">
                        <img src="<?= base_url('assets/client/foto/' . $siswa->foto) ?>">
                    </div>
                    <div class="bottom">
                        <p><?= $siswa->nama ?></p>
                        <p class="desi"><?= $siswa->nis ?></p>
                        <div class="barcode">
                            <img src="<?= base_url('assets/qrcode/' . $siswa->qrcode) ?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            Tida ada data.
        <?php endif ?>
        <div style="clear:both"></div>
    </div>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>
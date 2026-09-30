<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">
    <link rel="icon" href="<?= base_url() ?>/assets/client/images/favicon.png">
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/client/css/framework7.bundle.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/client/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/client/css/style.css">
    <style>
        html {
            background: url(<?= base_url('/assets/client/images/bg.jpg') ?>) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        @media only screen and (min-width: 600px) {
            body {
                width: 450px;
                margin: 0px auto;
            }
        }
    </style>

    <?php $this->renderSection('css') ?>
</head>

<body>

    <?php $this->renderSection('content') ?>


    <!-- script -->
    <script src="<?= base_url() ?>/assets/client/js/framework7.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/client/js/routes.js"></script>
    <script src="<?= base_url() ?>/assets/client/js/app.js"></script>
    <!-- end script -->
    <script src="<?= base_url() ?>/assets/js/sweetalert2.js"></script>

    <script>
        <?php if (session()->getFlashdata('alert') == true) : ?>
            <?php
            if (is_array(session()->getFlashdata('message')) == 1) {
                $message = '<ul>';
                foreach (session()->getFlashdata('message') as $list) {
                    $message .= '<li>' . $list . '</li>';
                }
                $message .= '</ul>';
            } else {
                $message = session()->getFlashdata('message');
            }
            ?>

            Swal.fire({
                title: '<?= session()->getFlashdata('title') ?>',
                html: '<?= $message ?>',
                icon: '<?= session()->getFlashdata('type') ?>',
                toast: true,
            });

        <?php endif ?>
    </script>

    <?php $this->renderSection('js') ?>
</body>

</html>
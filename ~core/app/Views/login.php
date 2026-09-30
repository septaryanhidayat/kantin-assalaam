<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Aplikasi E-Kantin" name="description" />
    <meta content="Pondok Pesantren Yayasan As Salaam Jayapura" name="author" />
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.ico">

    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="home-btn d-none d-sm-block">
        <a href="<?= base_url() ?>" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Selamat datang kembali!</h5>
                                <p class="text-white-50 mb-0">Silahkan Login ke Aplikasi Kantin.</p>
                                <a href="<?= base_url('login') ?>" class="logo logo-admin mt-4">
                                    <img src="<?= base_url() ?>/assets/images/logo-sm-dark.png" alt="" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form class="form-horizontal" action="" method="post">

                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customControlInline">
                                        <label class="form-check-label" for="customControlInline">Ingat saya</label>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-danger w-100 waves-effect waves-light" type="submit">MASUK</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <!-- <a href="#" class="text-muted"><i class="mdi mdi-lock me-1"></i> Lupa password?</a> -->
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Aplikasi Kantin Digital. Pondok Pesantren <i class="mdi mdi-heart text-danger"></i> As Salaam Jayapura
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
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
</body>

</html>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
  <link rel="icon" href="<?= base_url() ?>/assets/landing/images/favicon.png">
  <!-- Bootstrap CSS -->
  <link href="<?= base_url() ?>/assets/landing/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>/assets/landing/css/all.css" rel="stylesheet">
  <!-- Slider CSS -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/landing/css/owl.carousel.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/landing/css/owl.theme.default.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/landing/css/slick.css">
  <!-- Popup CSS -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/landing/css/magnific-popup.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/landing/css/meanmenu.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/landing/css/font-family/font-family-one.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/landing/css/preloader.css">
  <!-- KIDS CSS -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/landing/css/style.css">
  <!-- responsive css -->
  <link href="<?= base_url() ?>/assets/landing/css/responsive.css" rel="stylesheet">
</head>

<body>
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <!-- =======================
        end Preloader
======================== -->
  <header>
    <div class="menu">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="index.html"><img src="<?= base_url() ?>/assets/landing/images/<?= $header->logo ?>" alt=""></a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 ">
              <li class="nav-item dropdown">
                <a class="nav-link active" aria-current="page" href="">Home</a>
              </li>
              <li class="nav-item"><a class="nav-link btn btn-primary kids-active-btn" href="<?= base_url() ?>/login"> LOGIN</a> </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <!-- end menu -->
    <div class="container">
      <div class="header-wrap">
        <div class="row">
          <div class="col-md-7 col-sm-12 col-lg-7">
            <div class="header-text">
              <div class="text">
                <?= $header->hero_text ?>
                <a class="btn btn-primary kids-active-btn" href="<?= base_url() ?>/login">LOGIN DISINI</a>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-sm-12 col-lg-5">
            <div class="header-img">
              <img src="<?= base_url() ?>/assets/landing/images/<?= $header->hero_image ?>" alt="">
            </div>
          </div>
        </div>
      </div>
      <div class="cloud">
        <img src="<?= base_url() ?>/assets/landing/images/cloud-01.png" alt="">
      </div>
    </div>
    <div class="animation"><img src="<?= base_url() ?>/assets/landing/images/3.gif" alt=""></div>
    <div class="animation-two"><img src="<?= base_url() ?>/assets/landing/images/7.gif" alt=""></div>
  </header>
  <!-- ====================================
        End Header Here
========================================= -->
  <div class="header-bottom">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
          <div class="header-box-single box-one">
            <div class="box-text">
              <?= $featured->text1 ?>
            </div>
          </div>
        </div>
        <!-- col-md-4 -->
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
          <div class="header-box-single box-two">
            <div class="box-text">
              <?= $featured->text2 ?>
            </div>
          </div>
        </div>
        <!-- col-md-4 -->
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
          <div class="header-box-single box-three">
            <div class="box-text">
              <?= $featured->text3 ?>
            </div>
          </div>
        </div>
        <!-- col-md-4 -->
      </div>
    </div>
  </div>
  <!-- ====================================
        End Header Bottom Here
========================================= -->

  <!-- ====================================
        End About Here
========================================= -->

  <!-- ====================================
        End Counter Area Here
========================================= -->
  <section class="activities">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="section-title">
            <?= $kepala->nama ?>
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4">

          <div class="activities-single-box d-flex justify-content-between">
            <div class="activites-text">
              <?= $kepala->moto1 ?>
            </div>
            <div class="activities-img">
              <i class="fa-solid fa-futbol"></i>
            </div>
          </div>
          <div class="activities-single-box d-flex justify-content-between mt-4">
            <div class="activites-text">
              <?= $kepala->moto2 ?>
            </div>
            <div class="activities-img">
              <i class="fa-solid fa-heart"></i>
            </div>
          </div>
        </div>
        <!-- col-md-4 -->
        <div class="col-12 col-md-4 col-lg-4">
          <div class="activitics-main-img">
            <img src="<?= base_url() ?>/assets/landing/images/<?= $kepala->foto ?>" alt="">
          </div>
        </div>
        <!-- col-md-4 -->
        <div class="col-12 col-md-4 col-lg-4">
          <div class="activities-single-box d-flex justify-content-between m-left">
            <div class="activities-img">
              <i class="fa-solid fa-lightbulb"></i>
            </div>
            <div class="activites-text">
              <?= $kepala->moto3 ?>
            </div>
          </div>
          <div class="activities-single-box d-flex justify-content-between mt-4 m-left">
            <div class="activities-img">
              <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="activites-text">
              <?= $kepala->moto4 ?>
            </div>
          </div>
        </div>
        <!-- col-md-4 -->
      </div>
    </div>
    <div class="animation"><img src="<?= base_url() ?>/assets/landing/images/3.gif" alt=""></div>
    <div class="animation-two"><img src="<?= base_url() ?>/assets/landing/images/7.gif" alt=""></div>
  </section>
  <!-- ====================================
        End activities Area Here
========================================= -->

  <!-- ====================================
        End Our Classes Area Here
========================================= -->

  <!-- ====================================
        End Testimonial Area Here
========================================= -->
  <section class="gallery">
    <div class="container">
      <div class="grid">
        <div class="row">
          <div class="col-md-4 grid-item ct3 ct4">
            <div class="single-gallery-item">
              <div class="single-gallery-itemimg">
                <a href=""><img src="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto1 ?>" alt=""></a>
              </div>
              <div class="view">
                <a href="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto1 ?>" class="port-view"><i class="fa-solid fa-eye"></i></a>
              </div>
            </div>
          </div>
          <!-- item -->
          <div class="col-md-4 grid-item ct1">
            <div class="single-gallery-item ">
              <div class="single-gallery-itemimg">
                <a href=""><img src="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto2 ?>" alt=""></a>
              </div>
              <div class="view">
                <a href="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto2 ?>" class="port-view"><i class="fa-solid fa-eye"></i></a>
              </div>
            </div>
          </div>
          <!-- item -->
          <div class="col-md-4 grid-item ct3">
            <div class="single-gallery-item">
              <div class="single-gallery-itemimg">
                <a href=""><img src="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto3 ?>" alt=""></a>
              </div>
              <div class="view">
                <a href="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto3 ?>" class="port-view"><i class="fa-solid fa-eye"></i></a>
              </div>
            </div>
          </div>
          <?php if ($gallery->foto4 != '' || $gallery->foto4 != null) : ?>
            <div class="col-md-4 grid-item ct3">
              <div class="single-gallery-item">
                <div class="single-gallery-itemimg">
                  <a href=""><img src="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto4 ?>" alt=""></a>
                </div>
                <div class="view">
                  <a href="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto4 ?>" class="port-view"><i class="fa-solid fa-eye"></i></a>
                </div>
              </div>
            </div>
          <?php endif ?>
          <?php if ($gallery->foto5 != '' || $gallery->foto5 != null) : ?>
            <div class="col-md-4 grid-item ct3">
              <div class="single-gallery-item">
                <div class="single-gallery-itemimg">
                  <a href=""><img src="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto5 ?>" alt=""></a>
                </div>
                <div class="view">
                  <a href="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto5 ?>" class="port-view"><i class="fa-solid fa-eye"></i></a>
                </div>
              </div>
            </div>
          <?php endif ?>
          <?php if ($gallery->foto6 != '' || $gallery->foto6 != null) : ?>
            <div class="col-md-4 grid-item ct3">
              <div class="single-gallery-item">
                <div class="single-gallery-itemimg">
                  <a href=""><img src="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto6 ?>" alt=""></a>
                </div>
                <div class="view">
                  <a href="<?= base_url() ?>/assets/landing/images/<?= $gallery->foto6 ?>" class="port-view"><i class="fa-solid fa-eye"></i></a>
                </div>
              </div>
            </div>
          <?php endif ?>
          <!-- item -->
        </div>
        <!-- row -->

        <!-- row -->
        <!-- row -->
      </div>
    </div>
    <div class="g-bettarfly"><img src="<?= base_url() ?>/assets/landing/images/betterfly.png" alt=""></div>
    <div class="g-bettarfly-two"><img src="<?= base_url() ?>/assets/landing/images/betterfly.png" alt=""></div>
  </section>
  <!-- ====================================
        End Gellary Area Here
========================================= -->

  <!-- ====================================
        End Teachers Area Here
========================================= -->

  <!-- ====================================
        End Blog Area Here
========================================= -->
  <div class="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-md-4 clo-sm-6 cal-xxl-3">
          <div class="call-to-action-img"><img src="<?= base_url() ?>/assets/landing/images/calltoaction.png" alt=""></div>
        </div>
        <div class="col-md-8 clo-sm-6 cal-xxl-9">
          <div class="call-to-action-text">
            <div>
              <h3>As Salaam Shop</h3>
              <p>@2025 - Allright Reserved</p>
              <div class="footer-social">
                <ul>
                  <li><a href=""><i class="fa-brands fa-facebook-f"></i></a></li>
                  <li><a href=""><i class="fa-brands fa-linkedin-in"></i></a></li>
                  <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                  <li><a href=""><i class="fa-brands fa-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="call-shape-one"><img src="<?= base_url() ?>/assets/landing/images/white-cloud.png" alt=""></div>
    <div class="call-shape-two"><img src="<?= base_url() ?>/assets/landing/images/white-cloud.png" alt=""></div>
    <div class="call-shape-three"><img src="<?= base_url() ?>/assets/landing/images/dots.png" alt=""></div>
    <div class="call-shape-four"><img src="<?= base_url() ?>/assets/landing/images/airplane.png" alt=""></div>
  </div>
  <!-- ====================================
        End Call to Action Area Here
========================================= -->


  <!-- Theme Need JS -->
  <script src="<?= base_url() ?>/assets/landing/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/jquery.sticky.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/waypoints.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/jquery.counterup.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/owl.carousel.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/slick.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/isotope.pkgd.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/jquery.magnific-popup.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/jquery.meanmenu.min.js"></script>
  <script src="<?= base_url() ?>/assets/landing/js/kids.js"></script>
</body>

</html>
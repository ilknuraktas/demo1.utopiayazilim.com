<!DOCTYPE html>
<html lang="tr-TR">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="x-ua-compatible">
    <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, imgr-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
  <?= generateTemplateHead(); ?>
    <link rel="stylesheet"
          href="<?= mc_template("assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css") ?>">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="<?= mc_template("assets/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/plugins/owl-carousel/owl.carousel.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/plugins/magnific-popup/magnific-popup.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/plugins/jquery.countdown.css") ?>">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?= mc_template("assets/css/style.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/skins/skin-demo-9.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/demos/demo-9.css") ?>">
</head>
<body class="<?= "page-" . seoFix($_GET["act"] == "" ? "" : @$_GET["act"] . ' ' . @$_GET["op"]) ?>">
<div class="page-wrapper">
    <header class="header header-6">
        <div class="header-top">
            <div class="container">
                <div class="header-left">
                    <ul class="top-menu top-link-menu d-none d-md-block">
                        <li>
                            <a href="#">Links</a>
                            <ul>
                                <li>
                                    <a href="tel:<?= siteConfig("firma_tel"); ?>">
                                        <i class="icon-phone"></i><?= siteConfig("firma_tel"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul><!-- End .top-menu -->
                </div>
                <!-- End .header-left -->
                <div class="header-right">
                    <div class="social-icons social-icons-color">
                        <a href="<?= siteConfig("facebool_URL"); ?>" class="social-icon social-facebook"
                           title="Facebook" target="_blank">
                            <i class="icon-facebook-f"></i>
                        </a>
                        <a href="<?= siteConfig("twitter_URL"); ?>" class="social-icon social-twitter" title="Twitter"
                           target="_blank">
                            <i class="icon-twitter"></i>
                        </a>
                        <a href="<?= siteConfig("instagram_URL"); ?>" class="social-icon social-instagram"
                           title="Pinterest" target="_blank">
                            <i class="icon-instagram"></i>
                        </a>
                        <a href="<?= siteConfig("pinterest_URL"); ?>" class="social-icon social-pinterest"
                           title="Instagram" target="_blank">
                            <i class="icon-pinterest-p"></i>
                        </a>
                    </div>
                    <!-- End .soial-icons -->
                    <ul class="top-menu top-link-menu">
                        <li>
                            <a href="#">Links</a>
                            <ul>
                                <?php if($_SESSION["userID"]< 1):?>
                                <li>
                                    <a href="ac/login">
                                        <i class="icon-user"></i>
                                       Giriş Yap
                                    </a>
                                </li>
                                <li>
                                    <a href="ac/register">
                                        <i class="icon-user"></i>
                                       Kaydol
                                    </a>
                                </li>
                              <?php else :?>
                                    <li>
                                        <a href="ac/login">
                                            <i class="icon-user"></i>
                                            Hesabım
                                        </a>
                                    </li>

                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                    <!-- End .top-menu
                    <div class="header-dropdown">
                        <a href="#">USD</a>
                        <div class="header-menu">
                            <ul>
                                <li><a href="#">Eur</a></li>
                                <li><a href="#">Usd</a></li>
                            </ul>
                        </div>
                          </div>
                     End .header-menu -->

                    <!-- End .header-dropdown
                        <div class="header-dropdown">
                            <a href="#">Eng</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">Spanish</a></li>
                                </ul>
                            </div>
                             </div>
                             End .header-menu -->
                    <!-- End .header-dropdown -->
                </div>
                <!-- End .header-right -->
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="header-left">
                    <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                        <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                        <form action="page.php" method="get">
                            <div class="header-search-wrapper search-wrapper-wide">
                                <label for="q" class="sr-only">Ara</label>
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                <input type="hidden" name="act" value="arama">
                                <input type="search" class="form-control detailSearchKey" name="str" id="q"
                                       placeholder="Marka, Kategori, Ürün Ara..." required>
                            </div><!-- End .header-search-wrapper -->
                        </form>
                    </div><!-- End .header-search -->
                </div>
                <div class="header-center">
                    <a href="/" class="logo">
                        <img src="<?= mc_template("assets/images/demos/demo-9/logo.png") ?>" alt="" width="300"
                             height="20">
                    </a>
                </div><!-- End .header-left -->

                <div class="header-right">
                    <a href="ac/alarmList" class="wishlist-link">
                        <i class="icon-heart-o"></i>
                        <span class="wishlist-txt">Favorilerim</span>
                    </a>
                    <div class="dropdown cart-dropdown">
                        <a href="ac/sepet" class="dropdown-toggle imgSepetGoster" role="button">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count" id="toplamUrun"><?= basketInfo('toplamUrun', ''); ?></span>
                            <span class="cart-txt"
                                  id="toplamFiyat"><?php echo my_money_format('', basketInfo('ModulFarkiIle')); ?></span>
                        </a>
                    </div>
                    <!-- End .cart-dropdown -->
                </div>
            </div><!-- End .container -->
        </div><!-- End .header-middle -->

        <div class="header-bottom sticky-header">
            <div class="container">
                <div class="header-left">
                    <nav class="main-nav">
                      <?= mc_CategoryStyle("menu") ?>
                        <!-- End .menu -->
                    </nav><!-- End .main-nav -->

                    <button class="mobile-menu-toggler">
                        <span class="sr-only">Toggle mobile menu</span>
                        <i class="icon-bars"></i>
                    </button>
                </div><!-- End .header-left -->
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->

    <main class="main">
      <?php if ($_GET['act'] == ""): ?>
          <div class="intro-section">
              <div class="intro-section-slider">
                  <div class="container">
                      <div class="intro-slider-container slider-container-ratio mb-0">
                          <div class="intro-slider owl-carousel owl-simple owl-light" data-toggle="owl"
                               data-owl-options='{
                                    "nav": false,
                                    "dots": true,
                                    "responsive": {
                                        "1200": {
                                            "nav": true,
                                            "dots": false
                                        }
                                    }
                                }'>
                            <?= mc_Vitrin() ?>

                          </div><!-- End .intro-slider owl-carousel owl-simple -->

                          <span class="slider-loader"></span><!-- End .slider-loader -->
                      </div><!-- End .intro-slider-container -->
                  </div><!-- End .container -->
              </div><!-- End .intro-section-slider -->

              <div class="icon-boxes-container pt-0 pb-0">
                  <div class="container">
                      <div class="owl-carousel owl-simple" data-toggle="owl"
                           data-owl-options='{
                                "nav": false,
                                "dots": false,
                                "margin": 30,
                                "loop": false,
                                "autoplay": true,
                                "autoplayTimeout": 8000,
                                "responsive": {
                                    "0": {
                                        "items":1
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "992": {
                                        "items":3
                                    },
                                    "1200": {
                                        "items":4
                                    }
                                }
                            }'>
                          <div class="icon-box icon-box-side">
                                    <span class="icon-box-icon">
                                        <i class="icon-rocket"></i>
                                    </span>

                              <div class="icon-box-content">
                                  <h3 class="icon-box-title">Ücretsiz KARGO</h3><!-- End .icon-box-title -->
                                  <p>500TL üzeri</p>
                              </div><!-- End .icon-box-content -->
                          </div><!-- End .icon-box -->

                          <div class="icon-box icon-box-side">
                                    <span class="icon-box-icon">
                                        <i class="icon-rotate-left"></i>
                                    </span>

                              <div class="icon-box-content">
                                  <h3 class="icon-box-title">Kolay İade & Değişim</h3><!-- End .icon-box-title -->
                                  <p>14 Gün İçinde</p>
                              </div><!-- End .icon-box-content -->
                          </div><!-- End .icon-box -->

                          <div class="icon-box icon-box-side">
                                    <span class="icon-box-icon">
                                        <i class="icon-info-circle"></i>
                                    </span>

                              <div class="icon-box-content">
                                  <h3 class="icon-box-title">%100 Orijinal</h3><!-- End .icon-box-title -->
                                  <p>Harmoni Optik Güvencesiyle</p>
                              </div><!-- End .icon-box-content -->
                          </div><!-- End .icon-box -->

                          <div class="icon-box icon-box-side">
                                    <span class="icon-box-icon">
                                        <i class="icon-life-ring"></i>
                                    </span>

                              <div class="icon-box-content">
                                  <h3 class="icon-box-title">9 Taksit</h3><!-- End .icon-box-title -->
                                  <p>Tüm Kredi Kartlarına</p>
                              </div><!-- End .icon-box-content -->
                          </div><!-- End .icon-box -->
                      </div><!-- End .owl-carousel -->
                  </div><!-- End .container -->
              </div><!-- End .icon-boxes-container -->
          </div>
          <!-- End .intro-section -->
          <div class="icon-boxes-container">
              <div class="container">
                  <div class="owl-carousel mb-4 owl-simple owl-loaded owl-drag" data-toggle="owl"
                       data-owl-options="{
                        &quot;nav&quot;: false,
                        &quot;dots&quot;: true,
                        &quot;margin&quot;: 30,
                        &quot;loop&quot;: false,
                        &quot;responsive&quot;: {
                            &quot;0&quot;: {
                                &quot;items&quot;:2
                            },
                            &quot;420&quot;: {
                                &quot;items&quot;:3
                            },
                            &quot;600&quot;: {
                                &quot;items&quot;:4
                            },
                            &quot;900&quot;: {
                                &quot;items&quot;:5
                            },
                            &quot;1024&quot;: {
                                &quot;items&quot;:6
                            },
                            &quot;1200&quot;: {
                                &quot;items&quot;:6,
                                &quot;nav&quot;: true,
                                &quot;dots&quot;: false
                            }
                        }
                    }">
                      <div class="owl-stage-outer">
                          <div class="owl-stage"
                               style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1398px;">
                            <?= mc_CategoryStyle("showBrand") ?>
                          </div>
                      </div>
                      <div class="owl-nav">
                          <button type="button" role="presentation" class="owl-prev disabled"><i
                                      class="icon-angle-left"></i></button>
                          <button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i>
                          </button>
                      </div>
                      <div class="owl-dots disabled"></div>
                  </div>
              </div>
          </div>
          <!-- End .owl-carousel -->
          <div class="pt-3 pb-3">
              <div class="container">
                  <div class="banner-group">
                      <div class="row">
                          <div class="col-sm-6 col-lg-4">
                              <div class="banner banner-overlay banner-lg">
                                <?= mc_BannerList('banner1') ?>
                              </div><!-- End .banner -->
                          </div><!-- End .col-lg-4 -->

                          <div class="col-sm-6 col-lg-4 order-lg-last">
                              <div class="banner banner-overlay banner-lg">
                                <?= mc_BannerList('banner2') ?>
                              </div><!-- End .banner -->
                          </div><!-- End .col-lg-4 -->

                          <div class="col-12 col-lg-4">
                              <div class="row">
                                  <div class="col-sm-6 col-lg-12">
                                      <div class="banner banner-overlay">
                                        <?= mc_BannerList('banner3') ?>
                                      </div><!-- End .banner -->
                                  </div><!-- End .col-sm-6 col-lg-12 -->

                                  <div class="col-sm-6 col-lg-12">
                                      <div class="banner banner-overlay">
                                        <?= mc_BannerList('banner4') ?>
                                      </div><!-- End .banner -->
                                  </div><!-- End .col-sm-6 col-lg-12 -->
                              </div><!-- End .row -->
                          </div><!-- End .col-lg-4 -->
                      </div><!-- End .row -->
                  </div><!-- End .banner-group -->

              </div><!-- End .container -->
          </div>
          <!-- End .bg-lighter -->
          <div class="bg-lighter pt-6">
              <div class="container">
                  <div class="heading heading-flex mb-3">
                      <div class="heading-left">
                          <h2 class="title">Çok Satanlar</h2><!-- End .title -->
                      </div><!-- End .heading-left -->

                      <div class="heading-right">
                          <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                              <li class="nav-item">
                                  <a class="nav-link active" id="trending-women-link" data-toggle="tab"
                                     href="#trending-women-tab" role="tab" aria-controls="trending-women-tab"
                                     aria-selected="true">Güneş Gözlüğü</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" id="trending-men-link" data-toggle="tab" href="#trending-men-tab"
                                     role="tab" aria-controls="trending-men-tab" aria-selected="false">Optik Gözlük</a>
                              </li>
                          </ul>
                      </div><!-- End .heading-right -->
                  </div><!-- End .heading -->

                  <div class="tab-content tab-content-carousel">
                      <div class="tab-pane p-0 fade show active" id="trending-women-tab" role="tabpanel"
                           aria-labelledby="trending-women-link">
                          <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                               data-toggle="owl"
                               data-owl-options='{
                                    "nav": false,
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":2
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":3
                                        },
                                        "992": {
                                            "items":4
                                        },
                                        "1200": {
                                            "items":4,
                                            "dots": false
                                        }
                                    }
                                }'>
                            <?= urunList('select * from urun where active=1 and showCatIDs like "%|74|%" Order by seq desc,sold desc limit 0,12', 'empty', 'UrunListLiteShow'); ?>
                          </div><!-- End .owl-carousel -->
                      </div><!-- .End .tab-pane -->
                      <div class="tab-pane p-0 fade" id="trending-men-tab" role="tabpanel"
                           aria-labelledby="trending-men-link">
                          <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                               data-toggle="owl"
                               data-owl-options='{
                                    "nav": false,
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":2
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":3
                                        },
                                        "992": {
                                            "items":4
                                        },
                                        "1200": {
                                            "items":4,
                                            "dots": false
                                        }
                                    }
                                }'>
                            <?= urunList('select * from urun where active=1 and showCatIDs like "%|75|%" Order by seq desc,sold desc limit 0,12', 'empty', 'UrunListLiteShow'); ?>
                          </div><!-- End .owl-carousel -->
                      </div><!-- .End .tab-pane -->
                  </div><!-- End .tab-content -->
              </div><!-- End .container -->
          </div>
          <div class="container featured mt-4 pb-2">
              <div class="heading heading-flex mb-3">
                  <div class="heading-left">
                      <h2 class="title">Popüler Güneş Gözlükleri</h2><!-- End .title -->
                  </div><!-- End .heading-left -->

                  <div class="heading-right">
                      <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                          <li class="nav-item">
                              <a class="nav-link active" id="featured-women-link" data-toggle="tab"
                                 href="#featured-women-tab" role="tab" aria-controls="featured-women-tab"
                                 aria-selected="true">Kadın</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" id="featured-men-link" data-toggle="tab" href="#featured-men-tab"
                                 role="tab" aria-controls="featured-men-tab" aria-selected="false">Erkek</a>
                          </li>
                      </ul>
                  </div><!-- End .heading-right -->
              </div><!-- End .heading -->

              <div class="row">
                  <div class="col-lg-3">
                      <div class="banner banner-overlay product-banner">
                        <?= mc_BannerList('banner5') ?>
                      </div><!-- End .banner banner-overlay -->
                  </div><!-- End .col-lg-3 -->

                  <div class="col-lg-9">
                      <div class="tab-content tab-content-carousel">
                          <div class="tab-pane p-0 fade show active" id="featured-women-tab" role="tabpanel"
                               aria-labelledby="featured-women-link">
                              <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                                   data-toggle="owl"
                                   data-owl-options='{
                                        "nav": false,
                                        "dots": true,
                                        "margin": 20,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":2
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            },
                                            "992": {
                                                "items":3,
                                                "nav": true,
                                                "dots": false
                                            }
                                        }
                                    }'>
                                <?= urunList('select * from urun where anasayfa=1 and active=1 and showCatIDs like "%|74|%" and  filitre  like "%[3::Kadın],%" Order by seq desc,sold desc limit 0,12', 'empty', 'UrunListLiteShow'); ?>
                              </div><!-- End .owl-carousel -->
                          </div><!-- .End .tab-pane -->
                          <div class="tab-pane p-0 fade" id="featured-men-tab" role="tabpanel"
                               aria-labelledby="featured-men-link">
                              <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                                   data-toggle="owl"
                                   data-owl-options='{
                                        "nav": false,
                                        "dots": true,
                                        "margin": 20,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":1
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            },
                                            "992": {
                                                "items":3,
                                                "dots": false
                                            }
                                        }
                                    }'>
                                <?= urunList('select * from urun where anasayfa=1 and  active=1 and showCatIDs like "%|74|%" and  filitre  like "%[3::Erkek],%" Order by seq desc,sold desc limit 0,12', 'empty', 'UrunListLiteShow'); ?>
                              </div><!-- End .owl-carousel -->
                          </div><!-- .End .tab-pane -->
                      </div><!-- End .tab-content -->
                  </div><!-- End .col-lg-9 -->
              </div><!-- End .row -->
          </div>
          <!-- End .container -->
          <div class="container">
              <hr class="mt-3 mb-4">
          </div>
          <!-- End .container -->
          <div class="container pb-2">
              <div class="heading heading-flex mb-3">
                  <div class="heading-left">
                      <h2 class="title">Optik Gözlük</h2><!-- End .title -->
                  </div><!-- End .heading-left -->

                  <div class="heading-right">
                      <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                          <li class="nav-item">
                              <a class="nav-link active" id="bags-women-link" data-toggle="tab" href="#bags-women-tab"
                                 role="tab" aria-controls="bags-women-tab" aria-selected="true">Kadın</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" id="bags-men-link" data-toggle="tab" href="#bags-men-tab" role="tab"
                                 aria-controls="bags-men-tab" aria-selected="false">Erkek</a>
                          </li>
                      </ul>
                  </div><!-- End .heading-right -->
              </div><!-- End .heading -->

              <div class="row">
                  <div class="col-lg-3">
                      <div class="banner banner-overlay product-banner">
                        <?= mc_BannerList('banner6') ?>
                      </div><!-- End .banner banner-overlay -->
                  </div><!-- End .col-lg-3 -->

                  <div class="col-lg-9">
                      <div class="tab-content tab-content-carousel">
                          <div class="tab-pane p-0 fade show active" id="bags-women-tab" role="tabpanel"
                               aria-labelledby="bags-women-link">
                              <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                                   data-toggle="owl"
                                   data-owl-options='{
                                        "nav": false,
                                        "dots": true,
                                        "margin": 20,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":2
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            },
                                            "1200": {
                                                "items":3,
                                                "nav": true,
                                                "dots": false
                                            }
                                        }
                                    }'>
                                <?= urunList('select * from urun where active=1 and showCatIDs like "%|75|%" and  filitre  like "%[3::Kadın],%" Order by seq desc,sold desc limit 0,12', 'empty', 'UrunListLiteShow'); ?>
                              </div><!-- End .owl-carousel -->
                          </div><!-- .End .tab-pane -->
                          <div class="tab-pane p-0 fade" id="bags-men-tab" role="tabpanel"
                               aria-labelledby="bags-men-link">
                              <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                                   data-toggle="owl"
                                   data-owl-options='{
                                        "nav": false,
                                        "dots": true,
                                        "margin": 20,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":2
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            },
                                            "992": {
                                                "items":4
                                            },
                                            "1200": {
                                                "items":4,
                                                "nav": true,
                                                "dots": false
                                            }
                                        }
                                    }'>
                                <?= urunList('select * from urun where active=1 and showCatIDs like "%|75|%" and  filitre  like "%[3::Erkek],%" Order by seq desc,sold desc limit 0,12', 'empty', 'UrunListLiteShow'); ?>
                              </div><!-- End .owl-carousel -->
                          </div><!-- .End .tab-pane -->
                      </div><!-- End .tab-content -->
                  </div>
              </div>
          </div>
          <!-- End .container -->
          <div class="mb-5"></div>
          <!-- End .mb-5 -->
          <div class="bg-light deal-container pt-5 pb-3 mb-5">
              <div class="container">
                  <div class="row">
                      <div class="col-lg-9">
                        <?= urunList('select * from urun where active=1 and showCatIDs like "%|75|%" and  filitre  like "%[3::Erkek],%" Order by seq desc,sold desc limit 0,1', 'empty', 'UrunListDayShow'); ?>

                      </div><!-- End .col-lg-9 -->

                      <div class="col-lg-3">
                          <div class="banner banner-overlay banner-overlay-light text-center d-none d-lg-block">
                            <?= mc_BannerList('banner7') ?>
                          </div><!-- End .banner -->
                      </div><!-- End .col-lg-3 -->
                  </div><!-- End .row -->
              </div><!-- End .container -->
          </div>
          <div class="container">
              <hr class="mt-1 mb-6">
          </div>
          <!-- End .container -->
          <div class="blog-posts">
              <div class="container">
                  <h2 class="title text-center">Blog Yazılarımız</h2>
                  <!-- End .title-lg text-center -->
                  <div class="owl-carousel owl-simple carousel-with-shadow" data-toggle="owl"
                       data-owl-options='{
                            "nav": false,
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
                    <?= mc_CategoryStyle("showBlog") ?>
                  </div><!-- End .owl-carousel -->
                  <div class="more-container text-center mt-2">
                      <a href="blog" class="btn btn-outline-darker btn-more">
                          <span>Tümünü Gör</span>
                          <i class="icon-long-arrow-right"></i>
                      </a>
                  </div><!-- End .more-container -->
              </div><!-- End .container -->
          </div>
          <!-- End .blog-posts -->
      <?php else: ?>
        <div class="section-<?= "" . seoFix($_GET["act"] == "" ? "home" : @$_GET["act"] . '' . @$_GET["op"]) ?>-box">
          <?php
          $singleBlockArray = array('alarmList', 'profile', 'bakiye', 'modDavet', 'modDavet-liste', 'havaleBildirim', 'adres', 'urunlerim', 'showOrders', 'hataBildirim', 'iptal', 'shows');
          if (mc_user() == 'true') {
            array_push($singleBlockArray, "register", 'sifre', 'siparistakip');
          }
          if (in_array($_GET['act'], $singleBlockArray)) { ?>
              <div class="page-header text-center"
                   style="background-image: url('<?= mc_template("assets/images/page-header-bg.jpg") ?>')">
                  <div class="container">
                      <h1 class="page-title"><?= currentTitle(0) ?></h1>
                  </div>
                  <!-- End .container -->
              </div>
              <div class="container">
                  <div class="row">
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <?php echo $PAGE_OUT; ?>
                      </div>
                  </div>
              </div>
          <?php } ?>
          <?php $singleBlockArray = array("paketler", "markaList", "arama", "makale", "login", 'sepet', 'satinal', 'iletisim', 'basvuru', 'sss', 'showPage', 'showNews', 'haber', 'galeri', '404', 'makaleListe', 'showBlog', 'blog', 'puan');
          if (mc_user() == 'false') {
            array_push($singleBlockArray, "register", 'sifre', 'siparistakip');
          }
          if (in_array($_GET['act'], $singleBlockArray)) { ?>
              <div class="page-header text-center"
                   style="background-image: url('<?= mc_template("assets/images/page-header-bg.jpg") ?>')">
                  <div class="container">
                      <h1 class="page-title"><?= currentTitle(0) ?></h1>
                  </div>
                  <!-- End .container -->
              </div>
              <div class="page-content">
                  <div class="container">
                      <div class="row">
                          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <?php echo $PAGE_OUT; ?>
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
          <?php $singleBlockArray = array('yeni', 'cokSatanlar', 'indirimde', 'onerilenler');
          if (in_array($_GET['act'], $singleBlockArray)) { ?>
              <div class="page-header text-center"
                   style="background-image: url('<?= mc_template("assets/images/page-header-bg.jpg") ?>')">
                  <div class="container">
                      <h1 class="page-title"><?= currentTitle(0) ?></h1>
                  </div>
                  <!-- End .container -->
              </div>
              <div class="page-content">
                  <div class="container">
                            <?php echo $PAGE_OUT; ?>
                  </div>
              </div>
          <?php } ?>
          <?php $singleBlockArray = array('kategoriGoster');
          if (in_array($_GET['act'], $singleBlockArray)) { ?>

              <div class="page-header text-center"
                   style="background-image: url('<?= mc_template("assets/images/page-header-bg.jpg") ?>')">
                  <div class="container">
                      <h1 class="page-title"><?= currentTitle(0) ?></h1>
                  </div>
                  <!-- End .container -->
              </div>
              <!-- End .page-header -->
              <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                  <div class="container">
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                        <?= str_replace('<li>', '<li class="breadcrumb-item">', simpleBreadCrumb()) ?>
                      </ol>
                  </div>
                  <!-- End .container -->
              </nav>
              <!-- End .breadcrumb-nav -->
              <div class="page-content">
                  <div class="container">
                    <?php echo $PAGE_OUT; ?>
                      <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
                      <aside class="sidebar-shop sidebar-filter">
                          <div class="sidebar-filter-wrapper">
                              <div class="widget widget-clean">
                                  <label><i class="icon-close"></i>Filtrele</label>
                              </div><!-- End .widget -->
                            <?= generateFilter('FilterLists') ?>
                          </div><!-- End .sidebar-filter-wrapper -->
                      </aside><!-- End .sidebar-filter -->
                  </div><!-- End .container -->
              </div><!-- End .page-content -->

          <?php } ?>
          <?php $singleBlockArray = array('urunDetay');
          if (in_array($_GET['act'], $singleBlockArray)) { ?>
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                      <?= str_replace('<li>', '<li class="breadcrumb-item">', simpleBreadCrumb()) ?>
                    </ol>
                </div>
                <!-- End .container -->
            </nav>


          <?= str_replace("<STYLE>body,img,div img {width: 100%;}</STYLE>", "", $PAGE_OUT); ?>

        </div>
    <?php } ?>
</div>
<?php endif; ?>
<div class="container">
    <hr class="mt-3 mt-xl-1 mb-0">
</div>
<!-- End .container -->

<div class="cta pt-4 pt-lg-6 pb-5 pb-lg-7 mb-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="cta-heading text-center">
                    <h3 class="cta-title">E BÜLTEN</h3>
                    <!-- End .cta-title -->
                    <p class="cta-desc">Size özel fırsatlar ve kampanyalardan haberdar <br> olmak için lütfen e-posta
                        adresinizi giriniz.</p>
                    <!-- End .cta-desc -->
                </div>
                <!-- End .text-center -->

                <form action="#" onsubmit="ebultenSubmit('ebulten');return false;">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="E-Posta..." aria-label="Email Adress"
                               required id="ebulten">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" title="Sing up">
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div><!-- .End .input-group-append -->
                    </div><!-- .End .input-group -->
                </form>
            </div><!-- End .col-sm-10 col-md-8 col-lg-6 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div>
<!-- End .cta -->

</main>
<!-- End .main -->

<footer class="footer footer-2">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="widget widget-about">
                        <img src="<?= mc_template("assets/images/demos/demo-9/logo-footer.png") ?>" class="footer-logo"
                             alt="Footer Logo"
                             width="200">
                        <p><?= siteConfig("firma_adres") ?> </p>
                        <div class="widget-about-info">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <span class="widget-about-title">Bizi 7/24 Destek Hattı</span>
                                    <a href="tel:123456789"><?= siteConfig("firma_tel") ?></a>
                                </div><!-- End .col-sm-6 -->
                                <div class="col-sm-6 col-md-8">
                                    <span class="widget-about-title">Ödeme şekli</span>
                                    <figure class="footer-payments">
                                        <img src="<?= mc_template("assets/images/payments.png") ?>"
                                             alt="Payment methods" width="272" height="20">
                                    </figure><!-- End .footer-payments -->
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->
                        </div><!-- End .widget-about-info -->
                    </div><!-- End .widget about-widget -->
                </div>
                <!-- End .col-sm-12 col-lg-3 -->

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">MÜŞTERİ HİZMETLERİ</h4>
                        <!-- End .widget-title -->
                        <ul class="widget-list">
                          <?= mc_Page("showLeft") ?>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div>
                <!-- End .col-sm-4 col-lg-3 -->

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">HIZLI ERİŞİM</h4>
                        <!-- End .widget-title -->
                        <ul class="widget-list">
                          <?= mc_Page("showLeft") ?>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div>
                <!-- End .col-sm-4 col-lg-3 -->

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title"><?= siteConfig("firma_adi") ?></h4>
                        <!-- End .widget-title -->
                        <ul class="widget-list">
                          <?= mc_Page("showLeft") ?>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div>
                <!-- End .col-sm-64 col-lg-3 -->
            </div>
            <!-- End .row -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .footer-middle -->

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">Copyright © 2022 <?= siteConfig("firma_adi") ?>. All Rights Reserved.</p>
            <!-- End .footer-copyright -->
            <div class="social-icons social-icons-color">
                <span class="social-label">Sosyal Medyada Biz</span>
                <a href="<?= siteConfig("facebool_URL"); ?>" class="social-icon social-facebook"
                   title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                <a href="<?= siteConfig("twitter_URL"); ?>" class="social-icon social-twitter" title="Twitter"
                   target="_blank"><i class="icon-twitter"></i></a>
                <a href="<?= siteConfig("instagram_URL"); ?>" class="social-icon social-instagram"
                   title="Pinterest" target="_blank"><i class="icon-instagram"></i></a>
                <a href="<?= siteConfig("pinterest_URL"); ?>" class="social-icon social-pinterest"
                   title="Instagram" target="_blank"><i class="icon-pinterest-p"></i></a>
            </div><!-- End .soial-icons -->
        </div><!-- End .container -->
    </div>
    <!-- End .footer-bottom -->
</footer>
<!-- End .footer -->
</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="page.php" method="get" class="mobile-search">
            <input type="hidden" name="act" value="arama">
            <label for="mobile-search" class="sr-only">Ara</label>
            <input type="search" class="form-control" name="str" id="mobile-search" placeholder="Marka,Kategori veya Ürün ara..."
                   required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
        </form>

        <nav class="mobile-nav">
        <?=mc_CategoryStyle("showMobil")?>
        </nav><!-- End .mobile-nav -->

        <div class="social-icons">
            <a href="<?= siteConfig("facebool_URL"); ?>" class="social-icon "
               title="Facebook" target="_blank">
                <i class="icon-facebook-f"></i>
            </a>
            <a href="<?= siteConfig("twitter_URL"); ?>" class="social-icon " title="Twitter"
               target="_blank">
                <i class="icon-twitter"></i>
            </a>
            <a href="<?= siteConfig("instagram_URL"); ?>" class="social-icon "
               title="Pinterest" target="_blank">
                <i class="icon-instagram"></i>
            </a>
            <a href="<?= siteConfig("pinterest_URL"); ?>" class="social-icon"
               title="Instagram" target="_blank">
                <i class="icon-pinterest-p"></i>
            </a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div>
<!-- End .mobile-menu-container -->


<!-- Plugins JS File -->
<script src="<?= mc_template("assets/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.hoverIntent.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.waypoints.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/superfish.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/owl.carousel.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/bootstrap-input-spinner.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.plugin.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.magnific-popup.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.countdown.min.js") ?>"></script>
<!-- Main JS File -->
<script src="<?= mc_template("assets/js/main.js") ?>"></script>
<script src="<?= mc_template("assets/js/demos/demo-9.js") ?>"></script>

<?= generateTemplateFinish() ?>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-language" content="tr-TR"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <meta charset="utf-8">
    <?php echo generateTemplateHead(); ?>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400i,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= mc_template("assets/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/animate.min.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/font-awesome.min.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/nice-select.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/slick.min.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/style.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/main-color02.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/css-addition.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/home-09.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/main-color09.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/home-08.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/main-color08.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/main-color01.css") ?>">

    <link rel="stylesheet" href="<?= mc_template("assets/css/main-color01.css") ?>">
    <link rel="stylesheet" href="<?= mc_template("assets/css/home-11.css") ?>">


</head>
<body class="<?= "page-" . ($_GET["act"] == "" ? "" : @$_GET["act"] . ' ' . @$_GET["op"]) ?>">
<!-- Preloader -->
<div id="biof-loading">
    <div class="biof-loading-center">
        <div class="biof-loading-center-absolute">
            <div class="dot dot-one"></div>
            <div class="dot dot-two"></div>
            <div class="dot dot-three"></div>
        </div>
    </div>
</div>
<!-- ÇEREZ -->
<script> window.pupdata = {"headline":{"text":"Çerez Politikamız","fontSize":"28px"},"description":{"text":"Sizlere daha iyi hizmet sunulabilmesi için çerezler kullanılmaktayız. Detaylı bilgi için <a href=\"https://www.yoreseltrabzonurunleri.com/ic/cerezler-politikasi\">Gizlilik ve Çerez Politikasını</a> ve <a href=\"https://www.yoreseltrabzonurunleri.com/ic/kisisel-verilerin-korunmasi\">Kişisel Verilerin Korunması </a> hakkında açıklama metnini inceleyebilirsiniz. Devam etmeniz halinde çerez kullanımına izin verdiğinizi kabul edeceğiz. ","fontSize":"13px"},"okButton":{"borderRadius":"5px 5px 5px 5px","padding":"10px 10px 10px 10px","text":"Kabul Ediyorum","url":"function"},"exitIntend":false,"afterSeconds":0,"colors":{"color1":"#f7f7f7","color2":"#3f3f44","color3":"#3f3f44"},"borderRadius":"5px 5px 5px 5px","padding":"25px 25px 25px 25px","position":"TOP_LEFT"}; </script><script async src="assets/js/cookies.js"></script>
<!-- HEADER -->
<header id="header" class="header-area style-01 layout-02">
    <div class="header-top bg-main hidden-xs">
        <div class="container">
            <div class="top-bar left">
                <ul class="horizontal-menu">
                    <li><a href="mailto:info@kahvaltidunyasi.com"><i class="fa fa-envelope" aria-hidden="true"></i>info@kahvaltidunyasi.com</a>
                    </li>
                    <li><a href="tel:+90"><i class="fa fa-phone" aria-hidden="true"></i>+90 212 111 11 11</a></li>
                    <li><a href="#">100 TL VE ÜZERİ ALIŞVERİŞE ÜCRETSİZ KARGO</a></li>
                </ul>
            </div>
            <div class="top-bar right">
                <ul class="social-list">
                    <li><a href="<?= siteConfig("instagram_URL") ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </li>
                    <li><a href="<?= siteConfig("facebook_URL") ?>"><i class="fa fa-facebook"
                                                                       aria-hidden="true"></i></a></li>
                    <li><a href="<?= siteConfig("twitter_URL") ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                </ul>
                <ul class="horizontal-menu">
                    <li class="item-link"><a href="javascript:void(0)" class="dsktp-open-searchbox"><i
                                    class="biolife-icon icon-search"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-middle biolife-sticky-object ">
        <div class="container">
            <div class="row">

                <div class="col-lg-5 col-md-6 hidden-sm hidden-xs">
                    <div class="primary-menu">
                        <?= mc_CategoryStyle("menu") ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                    <a href="/" class="biolife-logo">
                        <img src="<?= mc_template("assets/images/organic-2.png") ?>" alt="biolife logo" width="500"
                             height="34">
                    </a>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-6 col-xs-6">
                    <div class="biolife-cart-info">
                        <div class="mobile-search">
                            <a href="javascript:void(0)" class="open-searchbox"><i class="biolife-icon icon-search"></i></a>
                            <div class="mobile-search-content">
                                <form class="form-search" name="mobile-seacrh" action="page.php" method="get">
                                    <input type="hidden" name="act" value="arama">
                                    <a href="#" class="btn-close"><span class="biolife-icon icon-close-menu"></span></a>
                                    <input type="text" name="str" class="input-text" value=""
                                           placeholder="Aradığınız Yöresel veya Organik tüm ürünler..">
                                    <select name="catID">
                                        <option value="0" selected>Tüm Kategoriler</option>
                                        <?= mc_CategoryStyle("optionCat") ?>
                                    </select>
                                    <button type="submit" class="btn-submit">ARA</button>
                                </form>
                            </div>
                        </div>
                        <div class="login-item">
                            <a href="ac/login" class="login-link"><i class="biolife-icon icon-login"></i>
                              <?=($_SESSION['loginStatus'] ? 'Hesabım' : 'Giriş/Üye Ol' ) ?></a>
                        </div>
                        <div class="wishlist-block hidden-sm hidden-xs">
                            <a href="ac/AlarmList" class="link-to">
                                    <span class="icon-qty-combine">
                                        <i class="icon-heart-bold biolife-icon"></i>
                                    </span>
                            </a>
                        </div>
                        <div class="minicart-block">
                            <div class="minicart-contain">
                                <a href="javascript:void(0)" class="link-to">
                                            <span class="icon-qty-combine">
                                                <i class="icon-cart-mini biolife-icon"></i>
                                                <span class="qty"
                                                      id="toplamUrun"><?= basketInfo('toplamUrun', ''); ?></span>
                                            </span>
                                    <span class="title">Sepetim -</span>
                                    <span class="sub-total">
                                        <b id="toplamFiyat"><?= my_money_format("", basketInfo('ModulFarkiIle', '')); ?></b>
                                        TL
                                    </span>
                                </a>
                                <div class="cart-content">
                                    <div class="cart-inner" id="SepetMobil">
                                        <?= SepetMobil($_SESSION['randStr']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-menu-toggle">
                            <a class="btn-toggle" data-object="open-mobile-menu" href="javascript:void(0)">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php if ($_GET['act'] == ""): ?>
    <!-- Page Contain -->
    <div class="page-contain">

        <!-- Main content -->
        <div id="main-content" class="main-content">

            <!--Block 01: Main Slide-->
            <div class="main-slide block-slider nav-change">
                <ul class="biolife-carousel"
                    data-slick='{"autoplay":true,"arrows": true, "dots": false, "slidesMargin": 0, "slidesToShow": 1, "infinite": false, "speed": 800}'>
                    <?= mc_Vitrin(); ?>
                </ul>
            </div>

            <!--Block 02: Carousel Öne Çıkanlar And Story -->
            <div class="home-09__elm-03 p-relative">
                <div class="container">
                    <!--Carousel story-->
                    <div class="biolife-category__carousel">
                        <div class="biolife-title-box biolife-title-box__bold-center">
                        </div>
                        <ul class="biolife-carousel nav-none-on-mobile nav__type-one"
                            data-slick='{"arrows": true, "dots": false, "slidesMargin": 35, "slidesToShow": 8, "infinite": true, "speed": 800, "responsive":[{"breakpoint":1210, "settings":{ "slidesMargin": 35}}, {"breakpoint":1200, "settings":{ "slidesToShow": 7, "slidesMargin": 30}}, {"breakpoint":992, "settings":{ "slidesToShow": 5, "slidesMargin": 30}}, {"breakpoint":768, "settings":{ "slidesMargin": 30, "slidesToShow": 3}}]}'>
                            <?= mcBannerList("Banner-Slider"); ?>
                        </ul>
                    </div>
                </div>
            </div>
			
            <!-- Block 04: Ürünler ve kategoriler-->
            <div class="product-tab home-08__elm-04">
                <div class="container">
                    <div class="box-title biolife-title__tab">
                        <span class="suptitle">yöresel</span>
                        <h3 class="main-title">Ürünlerimiz</h3>
                    </div>
                    <div class="biolife-tab biolife-tab-contain">
                        <?= mc_CategoryStyle("tabCat") ?>

                    </div>
                </div>
            </div>
                    <div class="product-tab">
                        <div class="biolife-title-box biolife-title-box__bold-center">
                            <span class="subtitle">Buraya metin gelebilir</span>
                            <h3 class="main-title">Öne Çıkanlar</h3>
                        </div>
                    </div>                    
            <!--Block 04: Banner Promotion 01 -->
            <div class="banner-promotion-01 xs-margin-top-50px sm-margin-top-100px">
                <div class="biolife-banner promotion biolife-banner__promotion">
					<div class="banner-contain">
                        <div class="media background-biolife-banner__promotion">
                            <div class="img-moving position-1">
                                <img src="<?= mc_template("assets/images/home-03/img-moving-pst-1.png") ?>" width="149"
                                     height="139" alt="img msv">
                            </div>
                            <div class="img-moving position-2">
                                <img src="<?= mc_template("assets/images/home-03") ?>" width="185"
                                     height="265" alt="img msv">
                            </div>
                            <div class="img-moving position-4">
                                <img src="<?= mc_template("assets/images/home-03") ?>" width="198"
                                     height="269" alt="img msv">
                            </div>
                        </div>
                        <div class="text-content">
                            <div class="container text-wrap">
                                <i class="first-line">Kahvaltı dünyası</i>
                                <span class="second-line">Kahvaltı Dünyası Banner</span>
                                <p class="third-line">Ürün açıklaması ürün açıklaması ürün açıklaması ürün açıklaması
                                    ürün açıklaması ürün açıklaması ürün açıklaması...</p>
                                <div class="product-detail">
                                    <a href="/" class="btn add-to-cart-btn">Ürünleri Listele</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--Block 02: Banners / Öne Çıkan 3 Ürün-->
            <div class="special-slide">
                <div class="container">
                    <ul class="biolife-carousel dots_ring_style"
                        data-slick='{"arrows": false, "dots": true, "slidesMargin": 30, "slidesToShow": 1, "infinite": true, "speed": 800, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 1}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":20, "dots": false}},{"breakpoint":480, "settings":{ "slidesToShow": 1}}]}'>
                        <?= urunList('select * from urun Where ucretsizKargo=1  order by ID desc limit 0,2', 'empty', 'urunListFeaturedShow'); ?>
                    </ul>
                </div>
            </div>


            <!--Block 07: Sertifikalar-->
            <div class="brand-slide sm-margin-top-100px background-fafafa xs-margin-top-80px xs-margin-bottom-80px">
                <div class="container">
                    <ul class="biolife-carousel nav-center-bold nav-none-on-mobile"
                        data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":30,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3}},{"breakpoint":768, "settings":{ "slidesToShow": 1}}]}'>
                        <?= mc_CategoryStyle("showBrand") ?>
                    </ul>
                </div>
            </div>

            <!-- Block 07: Blog posts-->
            <div class="blog-posts sm-margin-top-33px sm-padding-top-75px xs-margin-top-30px xs-padding-top-30px">
                <div class="container">
                    <div class="biolife-title-box biolife-title-box__bold-center">
                        <i class="subtitle">Blog yazısı metni</i>
                        <h3 class="main-title">Blog</h3>
                    </div>
                    <ul class="biolife-carousel nav-center xs-margin-top-34px nav-none-on-mobile"
                        data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":30,"slidesToShow":3, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 3}},{"breakpoint":992, "settings":{ "slidesToShow": 2}},{"breakpoint":768, "settings":{ "slidesToShow": 2}},{"breakpoint":600, "settings":{ "slidesToShow": 1}}]}'>
                        <?= mc_CategoryStyle("showBlog") ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
<?php else: ?>


    <aside class="<?= "aside-" . ($_GET["act"] == "" ? "" : @$_GET["act"] . ' ' . @$_GET["op"]) . 'user-login-' . mc_user() ?>">
        <?php $singleBlockArray = array('affilate','alarmList', 'profile', 'bakiye', 'modDavet', 'modDavet-liste', 'havaleBildirim', 'adres', 'urunlerim', 'showOrders', 'hataBildirim', 'iptal');
        if (mc_user() == 'true') {
            array_push($singleBlockArray, 'shows', 'login');
        }
        if (in_array($_GET['act'], $singleBlockArray)) { ?>


            <!--Hero Section-->
            <div class="hero-section hero-background">
                <h1 class="page-title"><?= $seo->currentTitle; ?></h1>
            </div>

            <!--Navigation section-->
            <div class="container">
                <nav class="biolife-nav">
                    <ul>
                        <li><a href="/">Anasayfa</a></li>
                        <li><a href="/ac/login">Profil</a></li>
                        <li>
                            <a href="ac/<?= $seo->act; ?>"><?= $seo->currentTitle; ?></a></li>
                    </ul>
                </nav>
            </div>

            <div class="page-contain single-product">
                <div class="container">
                    <?php echo $PAGE_OUT; ?>
                </div>
            </div>

        <?php } ?>

        <?php $singleBlockArray = array('sepet', 'satinal', 'iletisim', 'basvuru', 'sss', '404');
        if (mc_user() == 'false') {
            array_push($singleBlockArray, "login", "register", 'sifre', 'siparistakip');

        }
        if (in_array($_GET['act'], $singleBlockArray)) { ?>


            <!--Hero Section-->
            <div class="hero-section hero-background">
                <h1 class="page-title"><?= $seo->currentTitle; ?></h1>
            </div>

            <!--Navigation section-->
            <div class="container">
                <nav class="biolife-nav">
                    <ul>
                        <li><a href="/">Anasayfa</a></li>
                        <li><a href="ac/<?= $seo->act; ?>"><?= $seo->currentTitle; ?></a></li>
                    </ul>
                </nav>
            </div>

            <div class="page-contain single-product">
                <div class="container">
                    <?php echo $PAGE_OUT; ?>
                </div>
            </div>

        <?php } ?>
        <?php $singleBlockArray = array('procark','showPage', 'showNews', 'haber', 'galeri', 'makaleListe', 'showBlog', 'makale');

        if (in_array($_GET['act'], $singleBlockArray)) { ?>


            <!--Hero Section-->
            <div class="hero-section hero-background">
                <h1 class="page-title"><?= $seo->currentTitle; ?></h1>
            </div>

            <!--Navigation section-->
            <div class="container">
                <nav class="biolife-nav">
                    <ul>
                        <li><a href="/">Anasayfa</a></li>
                        <?= pageBreadCrumb() ?>
                    </ul>
                </nav>
            </div>

            <div class="page-contain single-product">
                <div class="container">
                    <?php echo $PAGE_OUT; ?>
                </div>
            </div>
        <?php } ?>
        <?php $singleBlockArray = array('urunDetay', 'kategoriGoster', 'arama');
        if (in_array($_GET['act'], $singleBlockArray)) { ?>


            <!--Hero Section-->
            <div class="hero-section hero-background">
                <h1 class="page-title"> <?= pageBreadCrumb() ?></h1>
            </div>

            <!--Navigation section-->
            <div class="container">
                <nav class="biolife-nav">
                    <ul>
                        <li class="nav-item"><a href="/">Anasayfa</a></li>
                        <li><?= str_replace(array(" &raquo; ", "BreadCrumb"), array("</li><li>", ""), ($_GET["act"] == "arama" ? ' <a href="ac/arama">Arama</a>' : breadCrumb())) ?></li>
                    </ul>
                </nav>
            </div>

            <div class="page-contain single-product">
                <div class="container">
                    <?php echo $PAGE_OUT; ?>
                </div>
            </div>
        <?php } ?>


    </aside>
<?php endif; ?>


<!-- FOOTER -->
<footer id="footer" class="footer layout-11 biolife-footer__eleven">
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-9">
                    <section class="footer-item">
                        <a href="/" class="logo footer-logo">
                            <img src="<?= mc_template("assets/images/organic-3-green.png") ?>" alt="biolife logo"
                                 width="300" height="36">
                        </a>
                        <div class="footer-phone-info">
                            <i class="biolife-icon icon-head-phone"></i>
                            <p class="r-info">
                                <span>Whatsapp Destek</span>
                                <span><a href="tel:+908503051000">0850 305 1 000</a></span>
                            </p>
                        </div>
                        <div class="newsletter-block layout-01">
                            <h4 class="title">Kampanyalardan haberdar olun</h4>
                            <div class="form-content">
                                <form action="#" name="new-letter-foter">
                                    <input type="email" class="input-text email" value=""
                                           placeholder="E-posta adresiniz...">
                                    <button type="submit" class="bnt-submit" name="ok">Gönder</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                    <section class="footer-item">
                        <h3 class="section-title">İletişim - Trabzon Fabrika</h3>
                        <div class="contact-info-block footer-layout xs-padding-top-10px">
                            <ul class="contact-lines">
                                <li>
                                    <p class="info-item">
                                        <i class="biolife-icon icon-location"></i>
                                        <b class="desc">Kahvaltı Dünyası Ambalaj Gıda San.Tic.Ltd.Şti<br> Üzümlü Köyü,
                                            Sürmene - Trabzon</b>
                                    </p>
                                </li>
                                <li>
                                    <p class="info-item">
                                        <i class="biolife-icon icon-phone"></i>
                                        <b class="desc">Telefon: 0462 738 42 30 - 0462 738 42 28</b>
                                    </p>
                                </li>
                                <li>
                                    <p class="info-item">
                                        <i class="biolife-icon icon-letter"></i>
                                        <b class="desc">Email: bilgi@kahvaltidunyasi.com</b>
                                    </p>
                                </li>
                                <li>
                                    <p class="info-item">
                                        <i class="biolife-icon icon-clock"></i>
                                        <b class="desc">Çalışma Saatlerimiz: Hafta içi 09:00 - 18:00</b>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="biolife-social inline">
                            <ul class="socials">
                                <li><a href="#" title="twitter" class="socail-btn"><i class="fa fa-twitter"
                                                                                      aria-hidden="true"></i></a></li>
                                <li><a href="#" title="facebook" class="socail-btn"><i class="fa fa-facebook"
                                                                                       aria-hidden="true"></i></a></li>
                                <li><a href="#" title="pinterest" class="socail-btn"><i class="fa fa-pinterest"
                                                                                        aria-hidden="true"></i></a></li>
                                <li><a href="#" title="youtube" class="socail-btn"><i class="fa fa-youtube"
                                                                                      aria-hidden="true"></i></a></li>
                                <li><a href="#" title="instagram" class="socail-btn"><i class="fa fa-instagram"
                                                                                        aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                    <section class="footer-item">
                        <h3 class="section-title">Hızlı Erişim<h3>
                        <div class="contact-info-block footer-layout xs-padding-top-10px">
                            <ul class="contact-lines">
                                <?=mc_Page("showBottom")?>
                            </ul>
                        </div>
                        <div class="biolife-social inline">
                            <ul class="socials">
                                <li><a href="#" title="twitter" class="socail-btn"><i class="fa fa-twitter"
                                                                                      aria-hidden="true"></i></a></li>
                                <li><a href="#" title="facebook" class="socail-btn"><i class="fa fa-facebook"
                                                                                       aria-hidden="true"></i></a></li>
                                <li><a href="#" title="pinterest" class="socail-btn"><i class="fa fa-pinterest"
                                                                                        aria-hidden="true"></i></a></li>
                                <li><a href="#" title="youtube" class="socail-btn"><i class="fa fa-youtube"
                                                                                      aria-hidden="true"></i></a></li>
                                <li><a href="#" title="instagram" class="socail-btn"><i class="fa fa-instagram"
                                                                                        aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="separator sm-margin-top-62px xs-margin-top-40px"></div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="copy-right-text"><p>Copyright © 2020 <b>Utopia Ajans & Yazılım</b> All rights reserved
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="payment-methods">
                        <ul>
                            <li><div id="ETBIS"><div id="6436717072866831"><a href="https://etbis.eticaret.gov.tr/sitedogrulama/6436717072866831" target="_blank"><img style='width:75px; height:90px' src="data:image/jpeg;base64, iVBORw0KGgoAAAANSUhEUgAAAQQAAAEsCAYAAAAl981RAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAIb+SURBVHhe7V0FgBVl1/6NTz8VDKS7BbsVFfXzs7EDuwsDbFFMBMVu/VQsxCZMQgQlt7tYuktApaQ9/3lm3su998yZ3Xd29u4ucB992N07542ZO/PMG+c97/8xqCbxxBNPJFucccYZah5hOGzYMJN7FM8995xqK7nHHnvQokWLTKrKwZo1a6hx48aesr7//ntjUfXIzMz01MePgwYNMqnKRm5urppe4zfffGNSRfHWW2957A455BBztHxcdtllnvS33XabOVo2Nm3aRK1bt/ak/+yzz4xFFO+//77HrgbwOuYWaAbVxqQgxCMpCF4mBaHSmRQEPyYFoXwkBSEeSUFIIIMIwumnn67mEYZhBGH33XenxYsXm1SVg7///psaNWrkKas6BSErK8tTHz9uD4KwefPmpCAkikEEoXPnzmoeYag9aLaCAK5cudKkqjzstddennKGDBlijlY9SkpKPPXx43fffWdSlY0gIvP555+bVFFognD44Yebo+Xj4osv9qS/+eabzdHy0bZtW0/6bUYQ8ACMHDky4bz22ms9ZQcRBNxEWr6SL7/8sqec3Xbbjb766iuP7dKlS03uUWiCsP/++3vS/vjjj3ThhRc6XZlYpqWlmZzKxuTJkz1pu3Tp4jz8sqwlS5aYVFHATqYPwokTJ5qcovj22289dscee6zneuy88840cOBATz3vuusuT/q3337b5B4FhFSm9aPWLdMEoXbt2p6y/fjGG294ynnhhRdUW0m0VHE/yfJtBaFFixaeshPFpk2bespnli0ItjdwWOCCy7KDCIIt8vLyPOXsueeetG7dOmNRNjRB8KsnxhGk7dChQ83RsoEHUqYFbVsd/fr1U9PbEgIp8fzzz6u2krvssgv9+eefJlUU5513nsc2yJvXFpogBKHW4urfv79qa0tbQTj44IPN0cQDLzJZPrNsQRg9erRJnlg8/fTTnrITIQgTJkzwlIO3h/aW1aAJwnHHHWeORrF69Wpq2LChxxYtBxtAiGVajEssWLDAWJSNV155xZM+CLWH4rXXXlNtJSEIc+bMMamiuOSSSzy23bt3N0crD2EFQRPDd999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"/></a></div></div></li>                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--Footer For Mobile-->
<div class="mobile-footer">
    <div class="mobile-footer-inner">
        <div class="mobile-block block-menu-main">
            <a class="menu-bar menu-toggle btn-toggle" data-object="open-mobile-menu" href="javascript:void(0)">
                <span class="fa fa-bars"></span>
                <span class="text">Menu</span>
            </a>
        </div>
        <div class="mobile-block block-sidebar">
            <a class="menu-bar filter-toggle btn-toggle" data-object="open-mobile-filter" href="javascript:void(0)">
                <i class="fa fa-sliders" aria-hidden="true"></i>
                <span class="text">Filtre</span>
            </a>
        </div>
        <div class="mobile-block block-minicart">
            <a class="link-to-cart" href="ac/sepet">
                <span class="fa fa-shopping-bag" aria-hidden="true"></span>
                <span class="text">Sepetim</span>
            </a>
        </div>
        <div class="mobile-block block-global">
            <a class="menu-bar myaccount-toggle btn-toggle" data-object="global-panel-opened" href="javascript:void(0)">
                <span class="fa fa-globe"></span>
                <span class="text">Hesabım</span>
            </a>
        </div>
    </div>
</div>

<div class="mobile-block-global">
    <div class="biolife-mobile-panels">
        <span class="biolife-current-panel-title">Hesabım</span>
        <a class="biolife-close-btn" data-object="global-panel-opened" href="#">&times;</a>
    </div>
    <div class="block-global-contain">
        <div class="glb-item my-account">
            <b class="title">Hesabım</b>
            <ul class="list">
                <?php if ($_SESSION['loginStatus']): ?>
                    <li><a href="profile_sp.html" rel="nofollow">Üye Bilgilerim</a></li>
                    <li><a href="adres_sp.html" rel="nofollow">Adreslerim</a></li>
                    <li><a href="bakiye_sp.html" rel="nofollow">Kredi Yükle</a></li>
                    <li><a href="ac/sepet" rel="nofollow">Alışveriş Sepetim</a></li>
                    <li><a href="ac/showOrders" rel="nofollow">Önceki Siparişlerim</a></li>
                    <li><a href="ac/hataBildirim" rel="nofollow">Sipariş Sorun Bildirim</a></li>
                    <li><a href="ac/havaleBildirim" rel="nofollow">Havale Bildirim Formu</a></li>
                    <li class=""><a href="<?php echo slink('logout') ?>">Çıkış</a></li>
                <?php else: ?>
                    <li><a href="ac/register" rel="nofollow">Kaydol</a></li>
                    <li><a href="ac/login" rel="nofollow">Giriş Yap</a></li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</div>

<!-- Scroll Top Button -->
<a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>
<!--FOOTER end-->
</body>
<script src="<?= mc_template("assets/js/cookies.js") ?>"></script>
<script src="<?= mc_template("assets/js/bootstrap.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.countdown.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.nice-select.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/jquery.nicescroll.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/slick.min.js") ?>"></script>
<script src="<?= mc_template("assets/js/biolife.framework.js") ?>"></script>
<script src="<?= mc_template("assets/js/functions.js") ?>"></script>
<?= generateTemplateFinish() ?>
</html>

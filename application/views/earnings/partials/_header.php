<!doctype html>
    <html lang="tr">

    <head>
        <meta charset="utf-8" />
        <title><?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?></title>
        <meta name="description" content="<?php echo xss_clean($description); ?>" />
        <meta name="keywords" content="<?php echo xss_clean($keywords); ?>" />
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url('uploads/logo/logo.png'); ?>" />
        <link href="<?php echo base_url(); ?>assets/store/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/store/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/store/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/store/assets/libs/gridjs/theme/mermaid.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="https://pro.fontawesome.com/releases/v5.15.0/css/all.css" rel="stylesheet">
        <link href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>

            .form-group{
                margin-top:10px;
            }
            .selectdiv{
                margin-top:10px;
            }
            #baguetteBox-overlay{
                display:none;
            }
            .tk-dash-nav {
                background-color: #333;
                color: #fff;
                padding: 5px 15px;
            }
            .form-box{
                margin-top:25px;
            }
            .tk-dash-nav .logo {
                max-height: 40px;
                margin-right: 20px;
            }

            .tk-dash-nav .nav-link {
                color: #fff;
                font-size: 15px;
                margin-right: 10px;
            }

            .tk-dash-nav .profile img {
                height: 48px;
                width: 48px;
                object-fit: cover;
                border-radius: 100%;
                margin-right: 6px;
            }

            .tk-dash-card {
                background-color: #fff;
                padding: 25px;
                border-radius: 6px;
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.06);
            }

            .tk-dash-card-title {
                font-size: 22px;
                margin-bottom: 15px;
                color: #000;
            }

            .tk-dash-stat {
                background-color: #f9f9f9;
                border-radius: 8px;
                padding: 15px 18px;
                margin-bottom: 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .tk-dash-stat .price {
                font-size: 24px;
                font-weight: 600;
                color: #000;
                margin: 0;
            }

            .tk-dash-stat .title {
                font-size: 15px;
                color: #707070;
                font-weight: 700;
                margin-bottom: 5px;
            }

            .tk-dash-stat .icon i {
                font-size: 40px;
                color: #000;
            }

            @media (max-width: 992px) {
                .tk-dash-nav {
                    padding: 15px;
                }
            }
        </style>
    </head>

    <body data-layout="horizontal" data-topbar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <!-- Left Sidebar End -->
            <header id="page-topbar" class="ishorizontal-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="/magazam" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url('uploads/logo/logo.png'); ?>" height="40" alt="logo">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo base_url('uploads/logo/logo.png'); ?>" height="40" alt="logo">
                                </span>
                            </a>

                            <a href="/magazam" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url('uploads/logo/logo-light.png'); ?>" height="40" alt="logo">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo base_url('uploads/logo/logo-light.png'); ?>" height="40" alt="logo">
                                </span>
                            </a>
                        </div>
                        <style>
                            .op{
                                content: "OR";
                                position: absolute;
                                font-size: 10px;
                                width: 22px;
                                height: 22px;
                                line-height: 22px;
                                border-radius: 50%;
                                background-color: #74788d;
                                color: #f5f6f8;
                                left: -12px;
                                top: 50%;
                                -webkit-transform: translateY(-50%);
                                transform: translateY(-50%);
                                z-index: 1;
                            }
                        </style>

                        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <div class="topnav">
                            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                                <div class="collapse navbar-collapse" id="topnav-menu-content">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a href="/magazam" class="nav-link"><i class="bx bx-tachometer"></i> Anasayfa</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-shopping-bag"></i>
                                                Ürünler
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="/satis-yap">Tekil Ürün Ekle</a>
                                                <a class="dropdown-item" href="/excel_aktar">Toplu Ürün Yükleme</a>
                                                <a class="dropdown-item" href="/toplu_veri">Toplu Ürün Verileri</a>
                                                <a class="dropdown-item" href="/urunlerim">Tüm Ürünler</a>
                                                <a class="dropdown-item" href="/urunlerim/bekleyen">Bekleyen Ürünler</a>
                                                <a class="dropdown-item" href="/urunlerim/pasif">Pasif Ürünler</a>
                                                <a class="dropdown-item" href="/urunlerim/taslak">Taslak Ürünler</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-shopping-bag"></i> Finans &  Muhasebe
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="/satislar">Aktif Satışlar</a>
                                                <a class="dropdown-item" href="/satislar/tamamlanan-satislar">Tamamlanan Satışlar</a>
                                                <a class="dropdown-item" href="/satis_kazanclari">Kazançlar</a>
                                                <a class="dropdown-item" href="/odemeler">Ödemeler</a>
                                                <a class="dropdown-item" href="/odeme-tanimlari">Ödeme Tanımları</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-shopping-bag"></i> Pazarlama
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="/ucretsiz-kargo">Ücretsiz Kargo Ayarları</a>
                                                <a class="dropdown-item" href="/toplu-al-az-ode">Toplu Al Az Öde</a>
                                            </div>
                                        </li>
                                        <li class="nav-item"><a href="/entegrasyon" class="nav-link"><i class="bx bx-link"></i>Entegrasyon</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="dropdown d-none d-sm-inline-block">
                            <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>" target="_blank">
                                <button type="button" class="btn header-item" style="display: flex; align-items: center;">
                                    <span class="align-center me-1">Mağazam</span>
                                    <i class="bx bx-log-in-circle font-size-18"></i>
                                </button>
                            </a>
                        </div>
                        <div class="dropdown d-none d-sm-inline-block">
                            <a href="<?php echo base_url(); ?>" target="_blank">
                                <button type="button" class="btn header-item" style="display: flex; align-items: center;">
                                    <span class="align-center me-1">Siteye Git</span>
                                    <i class="bx bx-log-in-circle font-size-18"></i>
                                </button>
                            </a>
                        </div>
                        <div class="dropdown d-none d-sm-inline-block">
                            <button type="button" class="btn header-item light-dark" id="mode-setting-btn">
                                <i data-feather="moon" class="icon-sm layout-mode-dark "></i>
                                <i data-feather="sun" class="icon-sm layout-mode-light"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?php echo get_user_avatar($this->auth_user); ?>" alt="Header Avatar">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <a class="dropdown-item" href="logout"><i class='bx bx-log-out text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Çıkış Yap</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="main-content">
                <div class="page-content">
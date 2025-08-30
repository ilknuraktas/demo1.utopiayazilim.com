<!doctype html>
    <html lang="tr">
    <head>
        <meta charset="utf-8" />
        <title><?php echo html_escape($title); ?> - <?php echo html_escape($this->general_settings->application_name); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url("<?php echo base_url(); ?>assets/admin/icon.png"); ?>" />
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url("<?php echo base_url(); ?>assets/admin/icon.png"); ?>" />
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
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
        </script>
    </head>

    <body data-layout="horizontal" data-topbar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <!-- Left Sidebar End -->
            <header id="page-topbar" class="ishorizontal-topbar" style="display: block;">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?php echo admin_url(); ?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url('uploads/logo/logo.png'); ?>" height="40" alt="logo">
                                </span>
                                <span class="logo-lg">
                                   <img src="<?php echo base_url('uploads/logo/logo.png'); ?>" height="40" alt="logo">
                               </span>
                           </a>

                           <a href="<?php echo admin_url(); ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?php echo base_url('uploads/logo/logo-light.png'); ?>" height="40" alt="logo">
                            </span>
                            <span class="logo-lg">
                             <img src="<?php echo base_url('uploads/logo/logo-light.png'); ?>" height="40" alt="logo">
                         </span>
                     </a>
                 </div>

                 <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <div class="topnav">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                               <li class="nav-item">
                                <a class="nav-link dropdown-toggle arrow-none"role="button" href="<?php echo admin_url(); ?>">
                                    <i class='bx bx-tachometer'></i>
                                    <span><?php echo trans("home"); ?></span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#">
                                    <i class="bx bx-dish"></i>
                                    <span><?php echo trans("orders"); ?></span>  <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>orders"> <?php echo trans("orders"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>transactions"> <?php echo trans("transactions"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>order-bank-transfers"> <?php echo trans("bank_transfer_notifications"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>invoices"> <?php echo trans("invoices"); ?></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#">
                                    <i class="bx bx-basket"></i>
                                    <span><?php echo trans("products"); ?></span>  <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo generate_url("sell_now"); ?>" target="_blank"> <?php echo trans("add_product"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>products"> <?php echo trans("products"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>pending-products"> <?php echo trans("pending_products"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>hidden-products"> <?php echo trans("hidden_products"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>drafts"> <?php echo trans("drafts"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>deleted-products"> <?php echo trans("deleted_products"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>digital-sales"><?php echo trans("digital_sales"); ?></a>
                                    <!--a class="dropdown-item" href="<?php echo admin_url(); ?>import_excel"> <?php echo "Excel ile içe aktar"; ?></a-->
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>quote-requests"> <?php echo trans("quote_requests"); ?></a>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                            <span><?php echo trans("featured_products"); ?></span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a class="dropdown-item" href="<?php echo admin_url(); ?>featured-products"> <?php echo trans("products"); ?></a>
                                            <a class="dropdown-item" href="<?php echo admin_url(); ?>featured-products-pricing"> <?php echo trans("pricing"); ?></a>
                                            <a class="dropdown-item" href="<?php echo admin_url(); ?>featured-products-transactions"> <?php echo trans("transactions"); ?></a>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>categories"><?php echo trans("categories"); ?></a>

								</div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button" href="#">
                                    <i class="bx bx-money"></i>
                                    <span><?php echo trans("earnings"); ?></span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>earnings"> <?php echo trans("earnings"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>seller-balances"> <?php echo trans("seller_balances"); ?></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button" href="#">
                                    <i class="bx bxs-credit-card"></i>
                                    <span><?php echo trans("payouts"); ?></span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                 <a class="dropdown-item" href="<?php echo admin_url(); ?>add-payout"> <?php echo trans("add_payout"); ?></a>
                                 <a class="dropdown-item" href="<?php echo admin_url(); ?>payout-requests"> <?php echo trans("payout_requests"); ?></a>
                                 <a class="dropdown-item" href="<?php echo admin_url(); ?>completed-payouts"> <?php echo trans("completed_payouts"); ?></a>
                                 <a class="dropdown-item" href="<?php echo admin_url(); ?>payout-settings"> <?php echo trans("payout_settings"); ?></a>
                             </div>
                         </li>
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button" href="#">
                                <i class="bx bx-copy-alt"></i>
                                <span>İçerik </span> <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo admin_url(); ?>slider"><?php echo trans("slider"); ?></a>
                                <a class="dropdown-item" href="<?php echo admin_url(); ?>stories"><?php echo trans("stories"); ?></a>

                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                        <span><?php echo trans("pages"); ?></span> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>add-page"> <?php echo trans("add_page"); ?></a>
                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>pages"> <?php echo trans("pages"); ?></a>
                                    </div>
                                </div>

                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                        <span><?php echo trans("blog"); ?></span> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>blog-add-post"> <?php echo trans("add_post"); ?></a>
                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>blog-posts"> <?php echo trans("posts"); ?></a>
                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>blog-categories"> <?php echo trans("categories"); ?></a>
                                    </div>
                                </div>

                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button" href="#">
                                <i class="bx bx-bx bx-cycling"></i> 
                                <span>Araçlar</span> <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu">

                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                        <span><?php echo trans("users"); ?></span> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="<?php echo admin_url(); ?>add-administrator"> <?php echo trans("add_administrator"); ?></a>
                                       <a class="dropdown-item" href="<?php echo admin_url(); ?>administrators"> <?php echo trans("administrators"); ?></a>
                                       <a class="dropdown-item" href="<?php echo admin_url(); ?>vendors"> <?php echo trans("vendors"); ?></a>
                                       <a class="dropdown-item" href="<?php echo admin_url(); ?>members"> <?php echo trans("members"); ?></a>
                                       <a class="dropdown-item" href="<?php echo admin_url(); ?>bayi"> <?php echo "Bayiler"; ?></a>
                                       <a class="dropdown-item" href="<?php echo admin_url(); ?>shop-opening-requests"> <?php echo trans("shop_opening_requests"); ?></a>
                                   </div>
                               </div>

                               <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                    <span><?php echo trans("newsletter"); ?></span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>send-email-subscribers"><?php echo trans("send_email_subscribers"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>subscribers"><?php echo trans("subscribers"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>contact-messages"><?php echo trans("contact_messages"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>reviews"><?php echo trans("reviews"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>storage"><?php echo trans("storage"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>cache-system"><?php echo trans("cache_system"); ?></a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                    <span><?php echo trans("comments"); ?></span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                    <?php if ($this->general_settings->comment_approval_system == 1) : ?>
                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>pending-product-comments"> <?php echo trans("product_comments"); ?></a>
                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>pending-blog-comments"> <?php echo trans("blog_comments"); ?></a>
                                    <?php else : ?>
                                        <a class="dropdown-item" class="dropdown-item" href="<?php echo admin_url(); ?>product-comments"> <?php echo trans("product_comments"); ?></a>
                                        <a class="dropdown-item" class="dropdown-item" href="<?php echo admin_url(); ?>blog-comments"> <?php echo trans("blog_comments"); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <a class="dropdown-item" href="<?php echo admin_url(); ?>seo-tools"><?php echo trans("seo_tools"); ?></a>
                            <a class="dropdown-item" href="<?php echo admin_url(); ?>ad-spaces"><?php echo trans("ad_spaces"); ?></a>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                    <span><?php echo trans("location"); ?></span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>countries"> <?php echo trans("countries"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>states"> <?php echo trans("states"); ?></a>
                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>cities"> <?php echo trans("cities"); ?></a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                                    <span><?php echo trans("custom_fields"); ?></span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu">
                                 <a class="dropdown-item" href="<?php echo admin_url(); ?>add-custom-field"> <?php echo trans("add_custom_field"); ?></a>
                                 <a class="dropdown-item" href="<?php echo admin_url(); ?>custom-fields"> <?php echo trans("custom_fields"); ?></a>
                             </div>
                         </div>

                     </a>
                 </div>
             </li>


             <!--li class="header text-uppercase"><?php echo trans("settings"); ?></li-->
             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button" href="#">
                    <i class="bx bxs-brightness"></i>
                    <span><?php echo trans("general_settings"); ?></span> <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu">
                   <a class="dropdown-item" href="<?php echo admin_url(); ?>evrak"> Gerekli Evraklar</a>
                   <a class="dropdown-item" href="<?php echo admin_url(); ?>settings"> <?php echo trans("general_settings"); ?></a>
                   <a class="dropdown-item" href="<?php echo admin_url(); ?>languages"> <?php echo trans("language_settings"); ?></a>
                   <a class="dropdown-item" href="<?php echo admin_url(); ?>social-login"> <?php echo trans("social_login"); ?></a>

                   <div class="dropdown">
                    <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                        <span><?php echo trans("system_settings"); ?></span> <div class="arrow-down"></div>
                    </a>
                    <div class="dropdown-menu">
                       <a class="dropdown-item" href="<?php echo admin_url(); ?>system-settings"> <?php echo trans("system_settings"); ?></a>
                       <a class="dropdown-item" href="<?php echo admin_url(); ?>route-settings"> <?php echo trans("route_settings"); ?></a>
                   </div>
               </div>

               <div class="dropdown">
                <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                    <span><?php echo trans("visual_settings"); ?></span> <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>navigation"><?php echo trans("navigation"); ?></a>
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>visual-settings"> <?php echo trans("visual_settings"); ?></a>
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>font-settings"> <?php echo trans("font_settings"); ?></a>
                </div>
            </div>

            <div class="dropdown">
                <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                    <span>Bildirim Ayarları</span> <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>email-settings">E-Posta Ayarları</a>
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>sms-ayarlari?lang=2">SMS Ayarları</a>
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>sms-mesaj">Sms Mesajları</a>
                </div>
            </div>

            <a class="dropdown-item" href="<?php echo admin_url(); ?>currency-settings"> <?php echo trans("currency_settings"); ?></a>
            <a class="dropdown-item" href="<?php echo admin_url(); ?>payment-settings"> <?php echo trans("payment_settings"); ?></a>
            <a class="dropdown-item" href="<?php echo admin_url(); ?>preferences"><?php echo trans("preferences"); ?></a>

            <div class="dropdown">
                <a class="dropdown-item dropdown-toggle arrow-none" href="#">
                    <span><?php echo trans("form_settings"); ?></span> <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>form-settings"> <?php echo trans("form_settings"); ?></a>
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>form-settings/shipping-options"> <?php echo trans("shipping_options"); ?></a>
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>form-settings/product-conditions"> <?php echo trans("product_conditions"); ?></a>
                </div>
            </div>

        </div>
    </li>
</ul>
</div>
</nav>
</div>
</div>

<div class="d-flex">
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
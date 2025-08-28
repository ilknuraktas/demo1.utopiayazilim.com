<?

$v5admin = new v5Admin;

$v5chart = new v5Chart;

$footerJS = '';

$brand = ($disablehelp?$disablehelp:'Utopia');

?>

<!DOCTYPE html>

<html lang="tr" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="../templates/system/admin/templatev5/assets/" data-template="horizontal-menu-template-no-customizer">



<head>

  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?=$brand?> v5 | E-Ticaret Yazılımı</title>

  <meta name="description" content="Utopia E-Ticaret Yazılımı" />

  <!-- Favicon -->

  <link rel="icon" type="image/x-icon" href="../templates/system/admin/templatev5/assets/img/favicon/favicon.ico" />

  <!-- Fonts -->

  <link rel="preconnect" href="https://fonts.googleapis.com" />

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons -->

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/fonts/boxicons.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/fonts/fontawesome.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/fonts/flag-icons.css" />

  <!-- Core CSS -->

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/css/rtl/core.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/css/rtl/theme-default.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/css/demo.css" />

  <!-- Vendors CSS -->

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/typeahead-js/typeahead.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/apex-charts/apex-charts.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/sweetalert2/sweetalert2.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/select2/select2.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/flatpickr/flatpickr.css" />

  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/bootstrap-fileupload/bootstrap-fileupload.min.css" />

  <link href="secureshare/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" type="text/css">

  <link href="../assets/css/sepet.css" rel="stylesheet" type="text/css">

  <!-- Page CSS -->

  <!-- Helpers -->

  <script src="../templates/system/admin/templatev5/assets/vendor/libs/jquery/jquery.js"></script>

  <script src="../templates/system/admin/templatev5/assets/vendor/js/helpers.js"></script>

  <script src="secureshare/flexigrid/flexigrid.js" type="text/javascript"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

  <script src="../templates/system/admin/templatev5/assets/js/config.js"></script>

</head>



<body>

  <!-- Layout wrapper -->

  <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">

    <div class="layout-container">

      <!-- Navbar -->

      <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">

        <div class="container-fluid">

          <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">

            <a href="s.php" class="app-brand-link gap-2">

              <span class="app-brand-logo container-xxl">
				  
				  <img src="https://utopiayazilim.com/assets/media/utopia-logo.png" alt="logo" width="160px" height="autp">
				  
              </span>

			</a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link d-xl-none text-large ms-auto">

              <i class="bx bx-x bx-sm align-middle"></i>

            </a>

          </div>

          <div class="layout-menu-toggle navbar-nav d-xl-none align-items-xl-center me-3 me-xl-0">

            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">

              <i class="bx bx-menu bx-sm"></i>

            </a>

          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <ul class="navbar-nav flex-row align-items-center ms-auto">

              <!-- Search -->

              <li class="nav-item navbar-search-wrapper me-2 me-xl-0">

                <a class="nav-item nav-link search-toggler" href="javascript:void(0);">

                  <i class="bx bx-search bx-sm"></i>

                </a>

              </li>

              <!-- /Search -->

              <!-- Quick links  -->

              <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">

                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">

                  <i class="bx bx-terminal bx-sm"></i>

                </a>

                <div class="dropdown-menu dropdown-menu-end py-0">

                  <div class="dropdown-menu-header border-bottom">

                    <div class="dropdown-header d-flex align-items-center py-3">

                      <h5 class="text-body me-auto mb-0">Servis Kısayolları</h5>

                      <!--<a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="bx bx-sm bx-plus-circle"></i></a>-->

                    </div>

                  </div>

                  <div class="dropdown-shortcuts-list scrollable-container">

                    <div class="row row-bordered overflow-visible g-0">

                      <div class="dropdown-shortcuts-item col">

                        <a href="javascript:void(0)" onclick="cleanCache();" class="stretched-link" id="cacheTemizle">Sistem Cache</a>

                        <small class="text-muted mb-0">Temizle</small>

                      </div>

                      <div class="dropdown-shortcuts-item col">

                        <a href="javascript:void(0)" onclick="cleanImageCache();" class="stretched-link">Resim Cache</a>

                        <small class="text-muted mb-0">Temizle</small>

                      </div>

                    </div>

                    <div class="row row-bordered overflow-visible g-0">

                      <div class="dropdown-shortcuts-item col">

                        <a href="javascript:void(0)" onclick="dovizGuncelle();" class="stretched-link">Döviz Kurunu</a>

                        <small class="text-muted mb-0">Güncelle</small>

                      </div>

                      <div class="dropdown-shortcuts-item col">

                        <a href="../update.php?up=1" target="_blank" class="stretched-link">Cron Servisi</a>

                        <small class="text-muted mb-0">Çalıştır</small>

                      </div>

                    </div>

                    <div class="row row-bordered overflow-visible g-0">

                      <div class="dropdown-shortcuts-item col">

                        <a href="s.php?f=teknik.php&act=optimizedb" class="stretched-link">Veri tabanı</a>

                        <small class="text-muted mb-0">Optimize et</small>

                      </div>

                      <div class="dropdown-shortcuts-item col">

                        <a href="s.php?f=yedek.php" class="stretched-link">Veri tabanı</a>

                        <small class="text-muted mb-0">Yedekle</small>

                      </div>

                    </div>

                  </div>

                </div>

              </li>

              <!-- Quick links -->

              <!-- Notification -->

              <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">

                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">

                  <i class="bx bx-chat bx-sm"></i>

                  <span class="badge rounded-pill badge-notifications bg-danger"><?= $v5chart->iletisimCevapBekleyen ?></span>

                </a>

                <ul class="dropdown-menu dropdown-menu-end py-0">

                  <?= $v5chart->iletisimListe() ?>

                  <li class="dropdown-menu-footer border-top">

                    <a href="s.php?f=iletisim.php" class="dropdown-item d-flex justify-content-center p-3">

                      Tüm mesajları görüntüle

                    </a>

                  </li>

                </ul>

              </li>

              <!--/ Notification -->

              <!--/ Notification -->

              <!-- Style Switcher -->

              <li class="nav-item me-2 me-xl-0" data-bs-toggle="modal" data-bs-target="#modalTop">

                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">

                  <i class="bx bx-info-circle bx-sm"></i>

                </a>

              </li>

              <!--/ Style Switcher -->

              <!-- User -->

              <li class="nav-item navbar-dropdown dropdown-user dropdown">

                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">

                  <div class="avatar avatar-online">

                    <span class="avatar-initial rounded-circle"><i class="bx bx-user"></i></span>

                  </div>

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                  <li>

                    <a class="dropdown-item" href="s.php?f=profile.php&y=d&ID=<?= $_SESSION['userID'] ?>">

                      <div class="d-flex">

                        <div class="flex-shrink-0 me-3">

                          <div class="avatar avatar-online">

                            <span class="avatar-initial rounded-circle"><i class="bx bx-user"></i></span>

                          </div>

                        </div>

                        <div class="flex-grow-1">

                          <span class="lh-1 d-block fw-semibold"><?= $_SESSION['name'] . ' ' . $_SESSION['lastname'] ?></span>

                          <small><?= ($_SESSION['admin_isAdmin'] ? 'Admin' : 'Kullanıcı') ?></small>

                        </div>

                      </div>

                    </a>

                  </li>

                  <li>

                    <div class="dropdown-divider"></div>

                  </li>

                  <li>

                    <a class="dropdown-item" href="s.php?f=profile.php&y=d&ID=<?= $_SESSION['userID'] ?>">

                      <i class="bx bx-user me-2"></i>

                      <span class="align-middle">Kullanıcı Bilgilerim</span>

                    </a>

                  </li>

                  <li>

                    <a class="dropdown-item" target="_blank" href="https://sorular.utopiayazilim.com">

                      <i class="bx bx-help-circle me-2"></i>

                      <span class="align-middle">SSS</span>

                    </a>

                  </li>

                  <li>

                    <a class="dropdown-item" target="_blank" href="../">

                      <i class="bx bx-desktop me-2"></i>

                      <span class="align-middle">Siteyi Göster</span>

                    </a>

                  </li>

                  <li>

                    <a class="dropdown-item" href="login.php?logout=true">

                      <i class="bx bx-power-off me-2"></i>

                      <span class="align-middle">Çıkış</span>

                    </a>

                  </li>

                </ul>

              </li>

              <!--/ User -->

            </ul>

          </div>

          <!-- Search Small Screens -->

          <div class="navbar-search-wrapper search-input-wrapper container-fluid d-none">

            <input id="textfield" type="text" class="form-control search-input border-0" placeholder="Arama..." aria-label="Arama..." />

            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>

          </div>

        </div>

      </nav>

      <!-- / Navbar -->

      <!-- Layout container -->

      <div class="layout-page">

        <!-- Content wrapper -->

        <div class="content-wrapper">

          <!-- Menu -->

          <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0 bg-menu-theme">

            <div class="container-fluid d-flex h-100">

              <ul class="menu-inner">

                <?= $v5admin->topMenu() ?>

              </ul>

            </div>

          </aside>

          <!-- / Menu -->

          <div class="container-fluid flex-grow-1 container-p-y">
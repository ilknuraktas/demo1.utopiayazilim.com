<?php $brand = ($disablehelp?$disablehelp:'ShopPHP');?><!DOCTYPE html>



<html

  lang="tr"

  class="light-style customizer-hide"

  dir="ltr"

  data-theme="theme-default"

  data-assets-path="../templates/system/admin/templatev5/assets/"

  data-template="horizontal-menu-template-no-customizer"

>

  <head>

    <meta charset="utf-8" />

    <meta

      name="viewport"

      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"

    />



    <title>Utopia Yazılım v5 | E-Ticaret Yazılımı</title>



    <meta name="description" content="" />



    <!-- Favicon -->

    <link rel="icon" type="image/x-icon" href="../templates/system/admin/templatev5/assets/img/favicon/favicon.ico" />



    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com" />

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link

      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"

      rel="stylesheet"

    />



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

    <!-- Vendor -->

    <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />



    <!-- Page CSS -->

    <!-- Page -->

    <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->

    <script src="../templates/system/admin/templatev5/assets/vendor/js/helpers.js"></script>



    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="../templates/system/admin/templatev5/assets/js/config.js"></script>

  </head>



  <body>

    <!-- Content -->



    <div class="container-xxl">

      <div class="authentication-wrapper authentication-basic container-p-y">

        <div class="authentication-inner py-4">

          <!-- Register -->

          <div class="card">

            <div class="card-body">

              <!-- Logo -->

              <div class="app-brand justify-content-center">

                <a href="index.html" class="app-brand-link gap-2">

                  <span class="app-brand-logo demo">

                    <svg

                      width="26px"

                      height="26px"

                      viewBox="0 0 26 26"

                      version="1.1"

                      xmlns="http://www.w3.org/2000/svg"

                      xmlns:xlink="http://www.w3.org/1999/xlink"

                    >

                      <title>icon</title>

                      <defs>

                        <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="linearGradient-1">

                          <stop stop-color="#5A8DEE" offset="0%"></stop>

                          <stop stop-color="#699AF9" offset="100%"></stop>

                        </linearGradient>

                        <linearGradient x1="0%" y1="0%" x2="100%" y2="100%" id="linearGradient-2">

                          <stop stop-color="#FDAC41" offset="0%"></stop>

                          <stop stop-color="#E38100" offset="100%"></stop>

                        </linearGradient>

                      </defs>

                      <g id="Pages" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                        <g id="Login---V2" transform="translate(-667.000000, -290.000000)">

                          <g id="Login" transform="translate(519.000000, 244.000000)">

                            <g id="Logo" transform="translate(148.000000, 42.000000)">


                            </g>

                          </g>

                        </g>

                      </g>

                    </svg>

                  </span>

                  <span class="app-brand-text demo h3 fw-bold mb-0">Utopia E-Ticaret v5</span>

                </a>

              </div>

              <!-- /Logo -->

              <h4 class="mb-2">Yönetici Girişi</h4>

              <p class="mb-4"></p>

			  <?php

			  if($_POST['username'] && $_POST['password'])

			  {

				  echo adminErrorv5('Hatalı kullanıcı adı veya şifre.');					

			  }



			  ?>



              <form id="formAuthentication" class="mb-3" method="POST">

                <div class="mb-3">

                  <label for="email" class="form-label">Kullanıcı adı veya E-Posta Adresi</label>

                  <input

                    type="text"

                    class="form-control"

                    id="email"

                    name="username"

                    placeholder="Kullanıcı adı"

                    <?=($shopphp_demo?'value="admin"':'')?>

                    autofocus

                  />

                </div>

                <div class="form-password-toggle mb-3">

                  <div class="d-flex justify-content-between">

                    <label class="form-label" for="password">Şifre</label>

                    <a href="https://sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=328&autoOpen=108" target="_blank" <?=($disablehelp?'class="d-none"':'')?>>

                      <small>Şifrenizi mi unuttunuz?</small>

                    </a>

                  </div>

                  <div class="input-group input-group-merge">

                    <input

                      type="password"

                      id="password"

                      class="form-control"

                      name="password"

                      <?=($shopphp_demo?'value="admin2"':'')?>

                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"

                      aria-describedby="password"

                    />

                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                  </div>

                </div>

                <div class="mb-3">

                  <button class="btn btn-primary d-grid w-100" type="submit">Giriş Yap</button>

                </div>

              </form>

            </div>

          </div>

          <!-- /Register -->

        </div>

      </div>

    </div>



    <!-- / Content -->



    <!-- Core JS -->

    <!-- build:js assets/vendor/js/core.js -->

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/jquery/jquery.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/popper/popper.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/js/bootstrap.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/hammer/hammer.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/i18n/i18n.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/typeahead-js/typeahead.js"></script>



    <script src="../templates/system/admin/templatev5/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->



    <!-- Vendors JS -->

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>

    <script src="../templates/system/admin/templatev5/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>



    <!-- Main JS -->

    <script src="../templates/system/admin/templatev5/assets/js/main.js"></script>



    <!-- Page JS -->

    <script src="../templates/system/admin/templatev5/assets/js/pages-auth.js"></script>

  </body>

</html>


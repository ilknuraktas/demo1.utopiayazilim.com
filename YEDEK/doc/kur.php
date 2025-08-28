<?php

if (!ini_get("short_open_tag"))

    exit('<div style="font-family:Tahoma; font-size:16px; text-align:center; padding:100px; font-weight:bolder; color:red;">Hata : Lütfen sunucunuzdan short_open_tag değerini aktif ettirin.');

ini_set('display_errors', '1');

error_reporting(E_ALL);

require('../include/lib-db.php');

require('import-lib.php');



/* */

$v = file_get_contents('../secure/include/v.txt');

/* */

$max_execution_time = ini_get('max_execution_time');

@set_time_limit(0);

$pDir = str_replace('//', '/', str_replace('/doc/' . basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) . '/');

error_reporting('~E_NOTICE & ~E_DEPRICATED % E_ALL');



function dosyayaz($dosyaadi, $data)

{

    if (get_magic_quotes_gpc())

        $data = stripslashes($data);

    $out = "";

    if (!$dene = fopen($dosyaadi, 'w')) {

        $out = false;

    } else {

        if (fwrite($dene, $data) === false) {

            $out = false;

        } else $out = true;

    }

    return $out;

}



function config()

{

    $_POST['serial'] = str_replace(' ', '', $_POST['serial']);

    global $pDir;

    $config = "<" . "?php

error_reporting(E_ERROR | E_PARSE);

ini_set('display_errors', '0');

" . '$connection_type' . " = '" . $_POST['ext'] . "';	

" . '$baglanti' . " = my_mysql_connect('" . $_POST['server'] . "','" . $_POST['username'] . "','" . $_POST['password'] . "');

my_mysql_select_db('" . $_POST['db'] . "'," . '$baglanti' . ");



" . '$siteDili' . " = 'tr';

" . '$serial' . " = '" . $_POST['serial'] . "';

" . '$shopphp_demo' . " = 0;

" . '$siteDizini' . "='" . $pDir . "';

" . '$yonetimDizini' . " = 'secure/';

" . '$yonetimKoruma' . " = 'SCRIPT'; 

// Hata Gösterimi - Yazılım Geliştirme

// error_reporting(E_ALL);

// ini_set('display_errors', '1');

?" . ">";

    return dosyayaz('../include/conf.php', $config);

}





function sField($label, $name, $value, $title)

{

    return '<div class="col-md-12 form-group" style="display: block;">

    <div class="row mb-3"><label class="col-form-label col-sm-4 text-sm-end">' . $label . '</label><div class="col-sm-8 relative "><input class="form-control" type="text"  name="' . $name . '" value="' . $value . '" placeholder="' . $label . '"><div class="badge bg-primary uppercase-off custom-info">' . $title . '</div>

<div class="clear"></div></div></div></div>';

}



function kurNotify($type, $content)

{

    return '<div class="alert alert-' . $type . '">' . $content . '</div>';

}



function readcURL($url)

{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $out = curl_exec($ch);

    curl_close($ch);

    return $out;

}

function getMaximumFileUploadSize()

{

    return (min((ini_get('post_max_size')), (ini_get('upload_max_filesize'))));

}





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">



<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>ShopPHP v

        <?= $v ?>

    </title>



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



    <style type="text/css">

        .kur-container {

            width: 800px;

            margin: auto;

            margin-top: 30px;

            margin-bottom: 30px;

            border-radius: 10px;

        }



        .kur-input {

            width: 500px;

        }



        .kur-success-container {

            inline-table;

            width: auto;

            margin-left: 300px;

        }



        .kur-success-container .ui-pnotify-icon {

            padding: 30px;

            border-radius: 10px;

            background-color: #47a447;

        }



        .kur-success-container .ui-pnotify-icon span {

            color: white;

            font-size: 60px;

        }



        .kur-tamamlandi input {

            padding: 20px;

            font-size: 20px;

            width: 100%;

        }



        .kur-panel-info {

            font-size: 16px;

        }



        .kur-help-block {

            display: block;

            width: 500px;

        }



        .kur-clear,

        .kur-clear-space {

            clear: both;

        }



        .kur-clear-space {

            height: 15px;

            clear: both;

        }



        .panel-body>div>img {

            margin: auto;

            display: block;

            margin-top: 15px;

        }

        .custom-info { text-align: left; padding: 10px; line-height: 14px; margin-top: 10px; width: 100%;}

        .text-right { text-align: right;}

    </style>

</head>



<body>

    <!-- Layout wrapper -->

    <div class="kur-container layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">

        <div class="layout-container ">

            <div class="layout-page">

                <!-- Content wrapper -->

                

                <div class="content-wrapper">

                    <div class="container-fluid flex-grow-1 container-p-y">

                    <center><img alt="Utopia E-Ticaret v5.0" width="150" src="../templates/system/admin/templatev5/assets/img/logo.png" class="mb-4" /></center>

                    

                        <div class="col-xxl">

                            <div class="card mb-4">

                                <div class="card-header d-flex justify-content-between align-items-center">

                                    <h5 class="mb-0"><span class="float-right text-muted">v<?= $v ?></span><span class="float-left">Kurulum Bilgileri</span></h5>

                                </div>

                                <div class="card-body col-lg-12">

                                    <?

                                    if ($_POST['serial'] && $_POST['username'] && $_POST['db'] && (filesize('../include/conf.php') > 1)) {

                                        echo kurNotify('danger', '<b>Hata:</b> include/conf.php dosyası zaten dolu durumda.');

                                    }

                                    if ($_POST['serial'] && $_POST['username'] && $_POST['db'] && (filesize('../include/conf.php') <= 1)) {

                                        $baglanti = my_mysql_connect($_POST['server'], $_POST['username'], $_POST['password']);

                                        my_mysql_select_db($_POST['db'], $baglanti);

                                        header("Content-Type: text/html; charset=utf-8");

                                        my_mysql_query("SET NAMES 'utf8'");

                                        my_mysql_query("set SESSION character_set_client = utf8");

                                        my_mysql_query("set SESSION character_set_connection = utf8");

                                        my_mysql_query("set SESSION character_set_results = utf8");



                                        if (my_mysql_num_rows(my_mysql_query("SELECT * FROM information_schema.tables WHERE table_schema = '" . $_POST['db'] . "' AND table_name = 'adminmenu'"))) {

                                            echo kurNotify('danger', '<b>Hata:</b> Veritabanı boş değil. Yeni kurulum için tanımlı veritabanının boş olması gerekmektedir.<br><a href="kur.php">Kuruluma geri dönmek için tıklayın</a>.');

                                        } else if (mysql_import('sql/sql.txt')) {

                                            echo '<div>

                        	  <center>							



															<div class="kur-clear"></div>

																<h2>Kurulum Tamamlandı</h2>

														</center>

														<div class="button-box kur-tamamlandi mb-3" >

															<input type="submit" target="_blank" name="" value="Siteye Girmek için Tıklayın." class="mb-xs mt-xs mr-xs btn btn-primary" onclick="window.open(\'../\');"/>

														</div>

														<div class="button-box kur-tamamlandi" >

															<input type="submit" target="_blank" name="" value="Yönetim Paneline girmek için Tıklayın." class="mb-xs mt-xs mr-xs btn btn-success" onclick="window.open(\'../secure/\');"/>

														</div>

                        </div>

													<div class="kur-clear-space"></div>';

                                            if (config()) {

                                                $password = substr(str_shuffle('_-!,.abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);

                                                my_mysql_query("update user set password = '" . md5($password) . "' where username = 'admin'",1);

                                                echo kurNotify('info kur-panel-info', '<a href="../secure/" target="_blank"><h3>Yönetim Paneli Giriş Bilgileri :</h3></a><br><strong>Kullanıcı adı : </strong>admin<br><strong>Şifre : </strong>' . $password . '</a>');

                                                // echo kurNotify('info','<b>Bilgi:</b> <a target="_blank" href="http://sorular.utopiayazilim.com/">Yönetin paneli bilgileri ve SSS arşivi için tıklayın.</a>');

                                                echo kurNotify('warning', '<b>Uyarı:</b> <a target="_blank" href="http://sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=324&autoOpen=5">Siteniz açılmıyorsa olası nedenleri görmek için tıklayın.</a>');

                                            }

                                        } else {

                                            echo kurNotify('danger', '<b>Hata:</b> Veritabanı kurulumunda hata oluştu. Lütfen girdiğiniz giriş bilgilerini kontrol edip tekrar deneyin.');

                                        }

                                    } else if (filesize('../include/conf.php') <= 1) {

                                    ?>

                                        <div class="rowx">

                                            <div>

                                                <section class="panel">

                                                    <div class="panel-body">

                                                        <form method="post" action="" class="form-horizontal form-bordered">

                                                            <?= sField('Serial No', 'serial', $_POST['serial'], 'Serial numaranızı bilmiyorsanız, <br/>IP ve Domain adınızı <a class="text-white" href=\'mailto:serial@shopphp.net\'>serial@shopphp.net</a> adresine<br />gönderip serial numaranızı alabilirsiniz.'); ?>

                                                            <?= sField('Veri Tabanı Tipi', 'ext', ($_POST['ext'] ? $_POST['ext'] : 'mysqli'), ''); ?>

                                                            <?= sField('Veri Tabanı Sunucusu', 'server', ($_POST['server'] ? $_POST['server'] : 'localhost'), ''); ?>

                                                            <?= sField('Veri Tabanı Adı', 'db', $_POST['db'], ''); ?>

                                                            <?= sField('Veri Tabanı Kullanıcı Adı', 'username', $_POST['username'], ''); ?>

                                                            <?= sField('Veri Tabanı Şifre', 'password', $_POST['password'], ''); ?>

                                                            <?= sField('Kurulum Dizini', 'pDir', ($_POST['pDir'] ? $_POST['pDir'] : $pDir), ''); ?>

                                                            <div class="row mt-4">

                            <div class="col-md-12">

                              <div class="row ">

							  <div class="col-sm-4"></div>

                                <div class="col-sm-8 relative" style="padding-left: calc(var(--bs-gutter-x) * 0.75);">

                                  <button type="submit" class="btn btn-primary me-1 me-sm-3">Kurulumu Başla</button>

                                  <button type="reset" class="btn btn-label-secondary">Geri Al</button>

                                </div>

                              </div>

                            </div>

                          </div>

                                                        </form>

                                                    </div>

                                                </section>

                                            </div>

                                            </div> </div> </div>

                                    <?

                                    } ?>

                                    <div class="kur-clear-space"></div>

                                    <? if (!($_POST['serial'] && $_POST['username'] && $_POST['db'])) { ?>

                                        <div class="card mb-4">

                                <div class="card-body col-lg-12">

                                                <?

                                                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                                                $lisansKontrol = readcURL(str_replace('doc/kur.php', 'testio.php', $actual_link));



                                                if ($_GET['hata'] == 'PHP_SURUMU') {

                                                    echo kurNotify('danger', '<b>Hata:</b> Sunucuda PHP Sürümü asgari v7.4 ve üzeri olmalıdır.');

                                                    exit();

                                                }



                                                if (extension_loaded("IonCube Loader") &&  (stristr($lisansKontrol, 'TEST OK!') === false) && $lisansKontrol) {

                                                    echo kurNotify('danger', '<b>Hata:</b> Lisans ve/veya domain adı hatası.');

                                                    exit();

                                                }

                                                if (filesize('../include/conf.php') > 1) {

                                                    echo kurNotify('danger', '<b>Hata:</b> include/conf.php dosyası kurulu durumda. Kurulum yapmak için include/conf.php dosyasının ve veritabanının boşaltılması gerekmektedir.');

                                                }



                                                if (version_compare(phpversion(), '7.4.0', '<')) {

                                                    echo kurNotify('danger', '<b>Hata:</b> Sunucuda PHP Sürümü asgari v7.4 ve üzeri olmalıdır.');

                                                } else {

                                                    echo kurNotify('info', '<b>Başarılı:</b> PHP Sürümü ' . phpversion());

                                                }



                                                if (!extension_loaded("IonCube Loader")) {

                                                    echo kurNotify('danger', '<b>Hata:</b> Sunucunuzda <a href="http://www.ioncube.com" target="_blank">ioncube loader</a> yüklü değil. ShopPHP yazılımını kurmak için, sunucu yöneticinizden ioncube kurulumu talep etmeniz gerekmektedir.');

                                                } else {

                                                    echo kurNotify('info', '<b>Başarılı:</b> Sunucunuzda Ioncube yüklü durumda.');

                                                }



                                                if (!is_writable('../include/')) {

                                                    echo kurNotify('danger', '<b>Hata:</b> include/conf.php dosyası yazılabilir değil.');

                                                } else {

                                                    echo kurNotify('info', '<b>Başarılı:</b> include/conf.php dosyası yazılabilir.');

                                                }





                                                $checkDirArray = array('banka', 'banner', 'cache', 'upload', 'urunler');

                                                $else = true;

                                                foreach ($checkDirArray as $check) {

                                                    if (!is_writable('../images/' . $check) && $else) {

                                                        $else = false;

                                                        echo kurNotify('warning', '<b>Uyarı:</b> images/ altındaki tüm klasörler yazılabilir değil.');

                                                    }

                                                }

                                                if ($else) {

                                                    echo kurNotify('info', '<b>Başarılı:</b> images/ altındaki tüm klasörler yazılabilir.');

                                                }

                                                $checkDirArray = array('gallery_data.xml', 'sitemap.xml');

                                                $else = true;

                                                foreach ($checkDirArray as $check) {

                                                    if (!is_writable('../' . $check) && !$else) {

                                                        $else = false;

                                                        echo kurNotify('warning', '<b>Uyarı:</b> Ana dizindeki XML uzantılı dosyalar yazılabilir.');

                                                    }

                                                }

                                                if ($else) {

                                                    echo kurNotify('info', '<b>Başarılı:</b>  Ana dizindeki XML uzantılı dosyalar yazılabilir.');

                                                }



                                                if (!is_writable('../secure/backup/')) {

                                                    echo kurNotify('danger', '<b>Hata:</b> /secure/backup/ klasörü yazılabilir değil.');

                                                } else {

                                                    echo kurNotify('info', '<b>Başarılı:</b> /secure/backup/ dosyası yazılabilir.');

                                                }



                                                if (!is_writable('../secure/bayiXML/')) {

                                                    echo kurNotify('danger', '<b>Hata:</b> /secure/bayiXML/ klasörü yazılabilir değil.');

                                                } else {

                                                    echo kurNotify('info', '<b>Başarılı:</b> /secure/bayiXML/ klasörü yazılabilir.');

                                                }





                                                /*

										$stream = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));

										$read = fopen("https://".$_SERVER['HTTP_HOST'], "rb", false, $stream);

										$cont = stream_context_get_params($read);

										$var = ($cont["options"]["ssl"]["peer_certificate"]);

										$sslresult = (!is_null($var)) ? true : false;	

													 */

                                                ?>

                                            </div>

                                        </div>

                                        <div class="kur-clear-space"></div>

                                        <div class="card mb-4">

                                <div class="card-header d-flex justify-content-between align-items-center">

                                    <h5 class="mb-0">Genel Bilgiler</h5>

                                </div>

                                <div class="card-body col-lg-12">



                                                <ul class="statistics">

                                                    <li>Yazılım Sürümü

                                                        <p> <span class="green">ShopPHP v

                                                                <?= $v ?>

                                                            </span> </p>

                                                    </li>

                                                    <li>PHP Sürümü

                                                        <p> <span class="green">PHP v

                                                                <?= phpversion() ?>

                                                            </span></p>

                                                    </li>

                                                    <li>Ioncube Sürümü

                                                        <p>

                                                            <?= (function_exists('ioncube_loader_version') ? '<span class="green">' . ioncube_loader_version() . '</span>' : '<span class="red"><strong>Yüklü değil</strong></span>') ?>

                                                        </p>

                                                    </li>

                                                    <? $gd = gd_info(); ?>

                                                    <li>GD Library Sürümü

                                                        <p> <span class="green">

                                                                <?= $gd['GD Version'] ?></span>

                                                        </p>

                                                    </li>

                                                    <? $curl = curl_version(); ?>

                                                    <li>cURL Sürümü

                                                        <p> <span class="green">v

                                                                <?= $curl['version'] ?></span>

                                                        </p>

                                                    </li>

                                                    <li>SOAP

                                                        <p> <?= (class_exists("SOAPClient") ? '<span class="green">Aktif</span>' : '<span class="red"><strong>Pasif</strong></span>') ?>

                                                        </p>

                                                    </li>

                                                    <li>Allow URL Fopen

                                                        <p> <?= (ini_get('allow_url_fopen') ? '<span class="green">Aktif</span>' : '<span class="red"><strong>Pasif</strong></span>') ?>

                                                        </p>

                                                    </li>

                                                    <li>Memory Limit

                                                        <p> <span class="green">

                                                                <?= ini_get('memory_limit') ?>

                                                            </span> </p>

                                                    </li>

                                                    <li>Timeout Limit (Saniye)

                                                        <p> <span class="green">

                                                                <?= $max_execution_time ?>

                                                            </span> </p>

                                                    </li>

                                                    <li>Upload Size Limit

                                                        <p> <span class="green">

                                                                <?= getMaximumFileUploadSize() ?>

                                                            </span> </p>

                                                    </li>

                                                    <li>Sunucu IP Adresi

                                                        <p> <span class="green">

                                                                <?= $_SERVER['SERVER_ADDR'] ?>

                                                            </span> </p>

                                                    </li>

                                                </ul>

                                            </div>



                                        <?

                                    } ?>

                                        </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <script src="../templates/system/admin/templatev5/assets/vendor/libs/popper/popper.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/js/bootstrap.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/hammer/hammer.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/i18n/i18n.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/typeahead-js/typeahead.js"></script>



        <script src="../templates/system/admin/templatev5/assets/vendor/js/menu.js"></script>

        <!-- endbuild -->



        <!-- Vendors JS -->



        <!-- Main JS -->

        <script src="../templates/system/admin/templatev5/assets/js/main.js"></script>



        <!-- Page JS -->



        <script src="../templates/system/admin/templatev5/assets/vendor/libs/apex-charts/apexcharts.js"></script>

        <script src="../templates/system/admin/templatev5/assets/js/ui-popover.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/sweetalert2/sweetalert2.js""></script>

<script src=" ../templates/system/admin/templatev5/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/flatpickr/flatpickr.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/select2/select2.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/chartjs/chartjs.js"></script>

        <script src="../templates/system/admin/templatev5/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>

        <script src="../templates/system/admin/templatev5/assets/js/dashboards-ecommerce.js"></script>

        <script src="../templates/system/admin/templatev5/assets/js/dashboards-analytics.js"></script>

        <script src="../templates/system/admin/templatev5/assets/js/charts-chartjs.js"></script>



        <script src="secureshare/CKEditor/ckeditor.js" type="text/javascript"></script>

        <script src="../templates/system/admin/templatev5/js/shopphp.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />



</body>



</html>
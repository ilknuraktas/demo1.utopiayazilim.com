<?
/*
user_lib

	$_SESSION['yasOnay'] = 1;
if ($_SESSION['yasOnay'] && !$_SESSION['ageconfirm'] && (stristr($_SERVER['PHP_SELF'],'/'.$yonetimDizini) === false) && (stristr($_SERVER['PHP_SELF'],'/acheck') === false) && !$_SESSION['admin_isAdmin']) 
	redirect('acheck/');
	
*/
include('../include/all.php');
if ($_GET['ageconfirm']) {
  $_SESSION['ageconfirm'] = 1;
  redirect('./');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>+18 Giriş Onay Ekranı</title>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <style type="text/css">
        body {
            background: #900 url(images/girisbg.jpg) center center fixed;
            background-size: 100%;
            font-size: 13px;
            font-family: 'Ubuntu', sans-serif;
            margin: 0px;
            padding: 0px;
            color: #fff;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .s_wrapper {
            width: 700px;
            margin-left: auto;
            margin-right: auto;
            text-align: center
        }

        .logo {
            height: 140px;
            margin-top: 150px;

        }

        .s_baslik h2 {
            font-weight: bold;
            font-size: 17px;
            color: #fff;
            margin-top: 50px;
            text-shadow: 1px 2px #000;
        }

        .s_aciklama {
            font-size: 12px;
            line-height: 19px;
        }

        .tarihsec {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .myButton {
            float: left;
            background-color: #2c8c46;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            border: 1px solid #158c21;
            display: inline-block;
            cursor: pointer;
            color: #ffffff;
            font-size: 18px;
            padding: 9px 26px;
            text-decoration: none;
            text-shadow: 0px 0px 0px #2f6627;
        }

        .myButton:active {
            position: relative;
            top: 1px;
        }

        .myButtonout {
            float: right;
            background-color: #333;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            border: 1px solid #222;
            display: inline-block;
            cursor: pointer;
            color: #ffffff;
            font-size: 18px;
            padding: 9px 26px;
            text-decoration: none;
            text-shadow: 0px 0px 0px #283966;
        }

        .myButtonout:active {
            position: relative;
            top: 1px;
        }

        .s_btn {
            width: 500px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 35px;
        }

        @media only screen and (max-width: 480px) {

            #gun,
            #ay,
            #yil {
                width: 80px;
                height: 60px;
                font-size: x-large;
            }

            #onay {
                font-size: 34px !important;
                width: 50px;
                height: 50px;
            }

            label {
                font-size: 34px
            }
        }

        @media only screen and (max-width: 667px) {

            #gun,
            #ay,
            #yil {
                width: 80px;
                height: 60px;
                font-size: x-large;
            }

            #onay {
                font-size: 34px !important;
                width: 50px;
                height: 50px;
            }

            label {
                font-size: 34px
            }
        }

        @media only screen and (max-width: 1025px) {

            #gun,
            #ay,
            #yil {
                width: 80px;
                height: 60px;
                font-size: x-large;
            }

            #onay {
                font-size: 34px !important;
                width: 50px;
                height: 50px;
            }

            label {
                font-size: 34px
            }
        }
    </style>
</head>

<body>
    <div class="s_wrapper">
        <div class="logo"><img src="<?= slogoSrc('templates/workshop/img/logo.png') ?>" alt="<?= siteConfig('seo_title') ?>" /></div>
        <div class="s_baslik">
            <h2>18 YASINDAN KÜÇÜKLERIN BU SITEYE GIRMESI YASAKTIR.</h2>
        </div>
        <div class="s_aciklama">Türk Ceza Kanunu'nun 226. maddesi uyarinca 18 yasindan küçüklerin bu siteyi gezmeleri ve alisveris yapmalari yasaktir.
            Websitemiz T.C.K'nin 226. maddesi D bendinde yer alan müstehcen ürünlerin satisina mahsus alisveris yeri kapsamindadir.
        </div>
        <div class="clear-space">&nbsp;</div>
        <div class="clear-space">
            18 yasindan büyük olduğumu ve bu sitede sergilenen ürünlerin 18 yasindan küçükler<br>tarafindan görüntülenmemesi için gereken özeni gösterecegimi beyan ederim.
        </div>

        <!--onay bitiş-->

        <div class="s_btn">
            <a href="./?ageconfirm=true" class="myButton"><i class="fa fa-sign-out" aria-hidden="true"></i> ONAYLIYORUM</a>
            <a href="https://www.google.com.tr/" target="_blank" class="myButtonout"><i class="fa fa-sign-out" aria-hidden="true"></i> ONAYLAMIYORUM</a>
        </div>
        <div style="clear:both"></div>

        <!-- FİRMA BİLGİLERİ -->

        <div class="s_baslik">
            <h2>
                <?= siteConfig('firma_adi') ?>
            </h2>
        </div>

        <div class="s_aciklama">
            <p>
                <?= siteConfig('firma_adres') ?><br>
                Telefon: <strong>
                    <?= siteConfig('firma_tel') ?></strong></p>
        </div>

    </div>
</body>

</html> 
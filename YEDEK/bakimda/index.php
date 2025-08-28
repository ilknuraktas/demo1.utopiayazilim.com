<?
$bakimda = true;
	include('../include/all.php');		
	list($tarih,$saat) = explode(' ',siteConfig('salterTarih'));	
	list($yil,$ay,$gun) = explode('-',$tarih);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Art Sound Group">
	
	<!--Title-->
    <title><?=siteConfig('seo_title')?></title>
	
	<!--Seo Tags-->
	<meta name="description" content="" />
	<meta name="keywords" content=""/>
	<meta name="robots" content="noindex"> 

	<!--Favicon-->
	<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
	
	<!--Fonts-->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="assets/fonts/font-awesome.css" >
	
	<!--General Style-->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="assets/css/trackpad-scroll-emulator.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
	<link rel="stylesheet" href="assets/css/vegas.min.css" type="text/css">
	<link rel="stylesheet" href="assets/css/mailform.css" type="text/css">

</head>

<body>

<!-- Content -->	
<div id="outer-wrapper" class="animate translate-z-in">
    <div id="inner-wrapper">
        <div id="table-wrapper">
            <div class="container center">
                <div id="row-content">
                    <div id="content-wrapper">
                        <div id="content" class="animate translate-z-in animation-time-2s delay-1-5s">
						  <header><img src="assets/img/logo.png" class="animate animate fade-in animation-time-3s" alt=""></header>
                            <h1><?=str_replace('www.','',strtolower($_SERVER['HTTP_HOST']))?></h1>
							<h2><?=siteConfig('salterInfo')?></h2>
                            <div class="center count-down animate small" data-countdown-year="<?=$yil?>" data-countdown-month="<?=$ay?>" data-countdown-day="<?=$gun?>"></div>
								<a href="#modal-subscribe" class="button-xs" data-toggle="modal" data-target="#modal-subscribe">e-bülten</a>
                                <a href="#about-us" class="button-xs open-side-panel"><span>hakkımızda</span></a>
                                <a href="#contact" class="button-xs open-side-panel"><span>iletişim</span></a>
                        </div>
                    </div>
                </div>
                <div id="row-footer">
                    <footer>
                        <div class="social animate translate-z-in delay-2s">
                            <a href="mailto:<?=siteConfig('firma_email')?>"><span class="fa fa-envelope" title="Email"></span></a>
							<a href="<?=siteConfig('facebook_URL')?>"><span class="fa fa-facebook" title="Facebook"></span></a>
                            <a href="<?=siteConfig('twitter_URL')?>"><span class="fa fa-twitter" title="Twitter"></span></a>
                            <a href="<?=siteConfig('instagram_URL')?>"><span class="fa fa-instagram" title="Instagram"></span></a>
                            <a href="<?=siteConfig('google_URL')?>"><span class="fa fa-google-plus" title="Google Plus"></span></a>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

		<!-- Background -->
        <div class="background-wrapper overlay">
             <div class="bg-transfer opacity-50"><img src="../assets/images/bakimda.webp" alt=""></div>
        </div>
    </div>
</div>

<!-- Subscribe -->
<div class="modal fade" id="modal-subscribe">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 id="modal-subscribe-label">E-Bülten</h2>
				<p>
				E-bültenimize şimdi abone olun, indirime ve fırsatlardan ilk siz yararlanın.
                </p>
            </div>
            <div class="modal-body">
                   <div id="subscribe" class="form-wrap">
						<form action="" method="post" id="subscribe-form" onsubmit="ebulten(); return false;">
							<p class="form-field">
								<input type="text" name="subscribe_email" id="subscribe_email" value="" placeholder="eposta@adresiniz.com" />
							</p>
							<p class="form-submit">
								<input type="submit" name="subscribe_submit" id="subscribe_submit" value="Gönder"/>
							</p>
						</form>
					</div>
            </div>
        </div>
    </div>
</div>

<!--Side Panel About-->
<div class="side-panel" id="about-us">
    <div class="close-panel right right"><i class="fa fa-times"></i></div>
    <div class="wrapper">
        <div class="tse-scrollable">
            <div class="tse-content">
                <div class="wrapper">
                    <div class="container center">
                        
						<!--Content-->
						<h2>HAKKIMIZDA</h2>
                        <section>
                            <h3><?=siteConfig('firma_adi')?></h3>
                            <p><?=hq("select body from pages where ID=12")?> </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Side Panel Contacts-->
<div class="side-panel" id="contact">
    <div class="close-panel"><i class="fa fa-times"></i></div>
    <div class="wrapper">
        <div class="tse-scrollable">
            <div class="tse-content">
                <div class="wrapper">
                    <div class="container center">
                       <section>
						<!--Content-->
						<h2>İLETİŞİM</h2>
						<h3><?=siteConfig('firma_adi')?></h3>
                        </section>
						
						<section>
						<h2>ADRES</h2>
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <h3><i class="fa fa-map-marker"></i> Adres</h3>
                                    <address>
                                        <?=siteConfig('firma_adres')?>
                                    </address>
                                </div>
								 <div class="col-md-4 col-sm-4">
                                    <h3><i class="fa fa-phone"></i> Telefon</h3>
                                    <address>
									<?=siteConfig('firma_tel')?><br/><?=siteConfig('firma_gsm')?>
                                    </address>
                                </div>
								 <div class="col-md-4 col-sm-4">
                                    <h3><i class="fa fa-envelope-o"></i> E-posta</h3>
                                    <address>
                                        <a href="mailto:<?=siteConfig('firma_email')?>"><?=siteConfig('firma_email')?></a>
                                    </address>
                                </div>
                            </div>
                        </section>
                        
						<!--Google Map-->
						<section>
                            <h3>Harita</h3>
                            <?=siteConfig('google_map')?>?>
                        </section> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="backdrop"></div>

<!--Java Scripts-->
<script type="text/javascript" src="assets/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.plugin.min.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>

</body>
</html>
	<?php //print_r($_GET['act']);

$cleanPages = array('satinal','register','iletisim','profile'); 
if(in_array($_GET['act'],$cleanPages)) { $PAGE_OUT = str_replace(array('&nbsp;','<br>'),array('',''),$PAGE_OUT); }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr-TR">
<head>
<meta charset="utf-8">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo generateTemplateHead(); ?> 
<link href="templates/aqua/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">        
<link href="templates/aqua/assets/css/style.css" rel="stylesheet" type="text/css">
<link href="templates/aqua/assets/css/media.css" rel="stylesheet" type="text/css">
<link href="templates/aqua/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css">        
<link href="templates/aqua/assets/plugins/owl-carousel/owl.theme.css" rel="stylesheet" type="text/css">   
<link href="templates/aqua/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
<link href="templates/aqua/assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="templates/aqua/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="templates/aqua/assets/css/jquery.mmenu.all.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="templates/aqua/assets/plugins/iesupport/html5shiv.js"></script>
<script src="templates/aqua/assets/plugins/iesupport/respond.js"></script>
<![endif]-->
</head>

<body id="home" class="wide page<?=$_GET["act"]?>">
<main class="wrapper"> 
<header class="light-bg">
	<section class="top-bar"> 
		<div class="bg-with-mask box-shadow">
			<span class="blue-color-mask color-mask"></span>
			<div class="container theme-container">           
				<nav class="navbar navbar-default top-navbar">  
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
							<span class="sr-only">MENÜ</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						 <a class="visible-xs logo" href="./"><img src="<?=slogoSrc('templates/aqua/images/logo.png')?>" alt="<?=siteConfig('seo_title')?>"></a>
					</div>                           
					<div class="collapse navbar-collapse no-padding" id="bs-example-navbar-collapse-1">
					
					<ul class="nav navbar-nav pull-left">  
						<li><a href="ac/iletisim"><span class="fa fa-phone-square"></span>TEL: <?=siteConfig('firma_tel')?></a></li>
					</ul>
					
					<ul class="nav navbar-nav pull-right hidden-sm">                                   
					
					<? if(!$_SESSION['userID']) { ?>
					<li><a href="<?=slink('login')?>"><span class="fa fa-sign-in"></span> ÜYE GİRİŞİ</a></li>
					<li><a href="<?=slink('register')?>"><span class="fa fa-user-plus"></span> KAYIT OL</a></li>
					<li><a href="./ac/siparistakip"><span class="fa fa-truck"></span> SİPARİŞ TAKİBİ</a></li>
					<li><a href="ac/iletisim"><span class="fa fa-phone-square"></span>İLETİŞİM</a></li>
					
					<? } else { ?>
					<li><a href="./ac/siparistakip"><span class="fa fa-truck"></span> SİPARİŞ TAKİBİ</a></li>
					<li><a href="ac/iletisim"><span class="fa fa-phone-square"></span>İLETİŞİM</a></li>
					<li><a href="<?=slink('login')?>"><span class="fa fa-sign-in"></span> HESABIM</a></li>
					<li><a href="<?=slink('logout')?>" class="btn pink-btn btn-signout"><span class="fa fa-sign-out"></span>ÇIKIŞ YAP</a></li>								
					<? } ?>

						</ul>
					</div>                         
				</nav>                            
			</div>                       
		</div>
	</section>

	<section class="header-wrapper white-bg header">
		<article class="header-middle">
			<div class="container theme-container ">       

				<div class="logo hidden-xs col-md-4  col-sm-4">
					<a href="./"><img src="<?=slogoSrc('templates/aqua/images/logo.png')?>" alt="<?=siteConfig('seo_title')?>"></a>
				</div>

				<div class="header-search col-md-5  col-sm-4">     
				<form action="page.php" method="get" class="search-form">
					<input type="hidden" name="act" value="arama" />							
						<div class="no-padding col-sm-12 search-cat">
							<label>
								<span class="screen-reader-text">Sitede Ara...</span>
								<input type="search" title="Aranacak Kelime.." name="str" id="detailSearchKeyxx" value="" placeholder="Aranacak Kelime.." class="search-field search-form">
							</label>
							<input type="submit" value="Ara" class="search-submit">
						</div>
					</form>                             
				</div>

				<div class="header-cart col-md-3 col-sm-4 hidden-xs">
					<div class="cart-wrapper">
					<?php if (basketInfo('toplamUrun') > 0) { ?>
					   <a href="<?=slink('sepet')?>" id="imgSepetGoster" class="btn cart-btn green-btn cart-btn">
							<i class="fa fa-shopping-cart white-color"></i>
							<span><b>SEPETTE <?=basketInfo('toplamUrun')?> ÜRÜN VAR</b></span>
							<span class="fa fa-caret-down"></span>
						</a>
					<?php } else { ?>	
					
					<a href="<?=slink('sepet')?>" id="imgSepetGoster" class="btn cart-btn default-btn cart-btn">
							<i class="fa fa-shopping-cart blue-color"></i>
							<span><b>SEPETİNİZ BOŞ</b></span>
							<span class="fa fa-caret-down"></span>
						</a>
					<?php } ?>			
					</div>                            
				</div>
			</div>
		</article>

		<article class="header-navigation urunkatmenu">
			<div class="container theme-container">       
				<nav class="navbar navbar-default product-menu"> 
					<div class="navbar-header">
						<a href="#menu" class="navbar-toggle collapsed">
							<span class="sr-only">ÜRÜN KATEGORİLERİ</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>                               
					</div>
					<div class="collapse navbar-collapse no-padding" id="product-menu">
						<ul class="nav navbar-nav">
							<?=aquaTopMenu(false,24)?> 
								
								<li class="dropdown dropmenu markali"><a class="dropdown-toggle" href="#" role="button" aria-haspopup="true">Markalar</a><i class="fa fa-caret-down"></i>
									<ul class="dropdown-menu dropdown-menu2col">
										<?=aquaMarkalar(false,24)?> 
									</ul>
								</li>
							
						</ul>
					</div>
				</nav>
			</div>
		</article>
	</section>  
</header>

<div class="menufix hidden-lg hidden-md">
	<a class="home" href="./"><i class="fa fa-home"></i>Anasayfa</a>
	<? if(!$_SESSION['userID']) { ?>
	<a href="<?=slink('login')?>"><i class="fa fa-user"></i>Üye Girişi</a>
	<? } else { ?>
	<a href="<?=slink('login')?>"><i class="fa fa-user"></i>Hesabım</a>
	<? } ?>
	<?php if (basketInfo('toplamUrun') > 0) { ?>
	<a href="./ac/sepet"><span class="cart_total"><?=basketInfo('toplamUrun')?></span><i class="fa fa-shopping-bag"></i>Sepetim</a>
	<?php } else { ?>
	<a href="./ac/sepet"><i class="fa fa-shopping-bag"></i>Sepetim</a>
	<?php } ?>
	<a href="./ac/siparistakip"><i class="fa fa-truck"></i>Sipariş Takibi</a>
	<a href="./ac/iletisim"><i class="fa fa-phone-square"></i>İletişim</a>
</div>
	
<?php if(!$_GET['act']) { ?>

<section class="carousel slide main-slider style-1 light-bg slide-bg" >   
	<div class="container">
		<div class="row space-top-10 space-bottom-20 slider_wrap">
			<div class="slider mainsliderx">
				<?=aquaSlider()?>
			</div>
		</div>            
	</div>            
</section>

<section id="category" class="space-0 hidden-xs">
<div class="container theme-container">
<div class="row">
<div class="col-md-12 category-wrap">
	<?=insertBannerv5('slider-alt')?>
</div>
</div>
</div>
</section>

<section id="category" class="space-0 hidden-lg hidden-md hidden-sm">
<div class="container theme-container">
<div class="row">
<div class="col-md-12 category-wrap">
	<img src="templates/aqua/images/mobil_bankalar.png" alt="orta banner"/>
</div>
</div>
</div>
</section>


<section id="product-tabination-1" class="space-bottom-5 space-top-10">
<div class="container theme-container">

	<div class="light-bg product-tabination">
		<div class="tabination">
			<div class="product-tabs" role="tabpanel">

				<ul role="tablist" class="nav nav-tabs navtab-horizontal home-tabs">
					<li role="presentation">
						<a class="pink-background" data-toggle="tab" role="tab"  href="#firsat" aria-expanded="true">FIRSAT ÜRÜNLERİ</a>
					</li>  
				</ul>

				<div class="tab-content">
				
					<div id="firsat" class="tab-pane fade active in" role="tabpanel">
						<div class="product-wrap urun-slider">

							<div class="product-slider product-slider-warp owl-carousel owl-theme"> 
							
							<?php echo urunlist('select * from urun where active=1 AND stok>0 AND indirimde=1 order by sold desc,ID desc limit 0,12','UrunList','UrunListHomeFirsat'); ?>

							</div>
						</div>
					</div>

			   </div>
			</div>
		</div>
	</div>
</div>            
</section>

 <section id="product-tabination-1" class="space-35">
                <div class="container theme-container">
  
                    <div class="light-bg product-tabination">
                        <div class="tabination">
                            <div class="product-tabs" role="tabpanel">

                                <ul role="tablist" class="nav nav-tabs navtab-horizontal home-tabs">
                                    <li role="presentation">
                                        <a class="blue-background" data-toggle="tab" role="tab"  href="#sizinicin" aria-expanded="true">SİZİN İÇİN SEÇTİKLERİMİZ</a>
                                    </li>
                                    
                                </ul>

                                <div class="tab-content">
								
                                    <div id="sizinicin" class="tab-pane fade active in" role="tabpanel">
                                        <div class="col-md-12 product-wrap">
                                            <div class="row product-slider-warp">   
											
											<?php echo urunlist('select * from urun where stok>0 AND anasayfa=1 order by ID desc limit 0,12','','UrunListHome'); ?>
											</div>
                                        </div>
                                    </div>

							   </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </section>
			
			<section id="category" class="space-0 hidden-xs">
				<div class="container theme-container">
				<div class="row">
				<div class="col-md-12 category-wrap text-center">
				<h4><i class="fa fa-instagram"></i> İnstagram'da @aquashop hesabını takip edin hediyeleri kaçırmayın.</h4>
					<!--iframe src="https://snapwidget.com/embed/474966" class="snapwidget-widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:100%; height:160px"></iframe--->
				</div>
				</div>
				</div>
			</section>
		
			<section id="category" class="space-bottom-20 hidden-lg hidden-md hidden-sm">
				<div class="container theme-container">
				<div class="row">
				<div class="col-md-12 category-wrap">
				<img src="templates/aqua/images/mobil_bankalar.png" alt="mobil_bankalar"/>
				</div>
				</div>
				</div>
			</section>

			 <section id="testimonials-slider" class="space-top-35">
                <div class="bg2-with-mask space-15">
                    <span class="blue-color-mask color-mask"></span>
                    <div class="container theme-container">
                        <div class="testimonials-wrap space-bottom-15">
							<div class="row">
								<div class="testimonials-content col-md-12 col-sm-12">
									<h3><span class="page-heading-title">
									<?php if(tempData('footerSEO')) { echo tempData('footerSlogan'); 
									} else { ?> <?=siteConfig('firma_adi')?> <?php } ?>
									</span></h3>
									
									<?php if(tempData('footerSEO')) { ?> <p><?=tempData('footerSEO');?></p>
									<?php } else { ?>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut mollis mi. Donec condimentum mauris quis eleifend elementum. Phasellus commodo cursus mi, id sagittis nisl pretium quis. Praesent sit amet cursus turpis. Pellentesque egestas ipsum sit amet nunc posuere maximus. Duis ac egestas orci, eu efficitur risus. Etiam condimentum urna nisi, non molestie dui tincidunt vel.</p>
									<?php } ?>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </section>
			
	<?php } ?>

	<?php 
		$singleBlockArray = array('kategoriGoster');
			if(in_array($_GET['act'],$singleBlockArray)) {
	?>	
		
		  <section class="breadcrumb-bg margin-bottom-40">     
                <span class="gray-color-mask color-mask"></span>
                <div class="theme-container container">
                    <div class="site-breadcrumb relative-block space-45">
                        <?=katMarka()?>
                        <hr class="dash-divider">
                        <ol class="breadcrumb breadcrumb-menubar">
                            <li><a href="./">Anasayfa</a></li>                             
                           <?php echo simpleBreadCrumb(); ?>                       
                        </ol>
                    </div>  
                </div>
            </section>
			
			<article class="container theme-container"> 
                <section class="product-category">
                    <div class="row">
					<aside class="col-md-3 col-sm-12" id="katfilter">
                            
							<div class="sidebar-widget light-bg default-box-shadow">
                                <h4 class="widget-title green-bg filterdown"><span class="title"> ALT KATEGORİLER </span><span class="downicon pull-right fa fa-caret-down"></span></h4>
                                <div class="widget-content widget_content">
                                    <ul id="green-scroll">
									<?php echo simpleCatList(hq('select ID from kategori where parentID=\''.currentCat().'\'')?currentCat():currentParentCatID());  ?>                            
                                    </ul>
                                </div>
                            </div>
							
                            <div class="sidebar-widget light-bg default-box-shadow">
                                <h4 class="widget-title pink-bg filterdown"> <span class="title"> FİLTRELE</span> <span class="downicon pull-right fa fa-caret-down"></span></h4>
                                <div class="widget-content widget_content">
                                    <ul id="pink-scroll">
                                       <?php echo generateTableBox('SEÇİMİ DARALTIN',generateFilter('FilterLists'),'FilterLeft'); ?>
                                    </ul>
                                </div>
                            </div>
                        </aside>
						
					<aside class="col-md-9 col-sm-12">
                            <section id="product-category" class="space-bottom-45">                							
                                <div class="tab-content">
                                    <div id="grid-view" class="tab-pane fade active in" role="tabpanel">
                                        <div class="row urunkat">
											<?=$PAGE_OUT?>
										</div>
                                    </div>
                                </div>
               
                            </section>
                        </aside>    
                    </div>
                </section>
            </article>
		
	<?php } ?>
	
	<?php 
		$singleBlockArray = array('urunDetay');
			if(in_array($_GET['act'],$singleBlockArray)) {
	?>	
	
		<section class="breadcrumb-bg margin-bottom-20">     
                <span class="gray-color-mask color-mask"></span>
                <div class="theme-container container">
                    <div class="site-breadcrumb relative-block space-15">
                        <ol class="breadcrumb breadcrumb-menubar">
                            <li><a href="./">Anasayfa</a></li>                             
                           <?php echo simpleBreadCrumb(); ?>                       
                        </ol>
                    </div>  
                </div>
            </section>
			
			<div class="container theme-container">
			<div class="row">
			<div class="col-md-12">
				<?=$PAGE_OUT?>
			</div>
			</div>
			</div>
			
	<?php } ?>

	<?php 
		$usedArray = array('kategoriGoster','urunDetay');
		if($_GET['act'] && !in_array($_GET['act'],$usedArray)) {
		?>

		<div class="container theme-container detayblok">
		<div class="row">
		<div class="col-md-12">
			<?=$PAGE_OUT?>
		<div class="clearfix"></div>
		</div>	
		</div>	
		</div>	
		<?php } ?>
		

           <footer class="footer">
                <div class="bg2-with-mask footer_widget space-35">
                    <span class="black-mask color-mask"></span>
                    <div class="container theme-container">
                        <div class="row space-top-35">
                            <aside class="col-md-3 col-sm-6">
                                <div class="footer-widget space-bottom-35">
                                    <h3 class="footer-widget-title"> <i class="fa fa-phone-square blue-color"></i> İLETİŞİM BİLGİLERİMİZ</h3>
									
                                    <div class="address">
                                        <ul> 
											<li> <i class="fa fa-map-marker blue-color"></i> <span> <?=siteConfig('firma_adres')?> </span>
                                            <li> <i class="fa fa-phone blue-color"></i> <span> <?=siteConfig('firma_tel')?></span> </li>
                                            <li> <i class="fa fa-envelope blue-color"></i> <a href="#"> <span> <?=siteConfig('firma_email')?> </span> </a></li>
                                            </li>                                       
                                        </ul>
                                    </div>
                                    <div class="social-icon">
                                        <ul>
                                            <li> <a href="<?=siteConfig('facebook_URL')?>"> <i class="fa fa-facebook-square"></i> </a> </li>
                                            <li> <a href="<?=siteConfig('twitter_URL')?>"> <i class="fa fa-twitter-square"></i>  </a></li>
                                            <li> <a href="<?=siteConfig('instagram_URL')?>"> <i class="fa fa-instagram"></i>  </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                            <aside class="col-md-3 col-sm-6">
                                <div class="footer-widget footer-widgetx space-bottom-35">
                                    <h3 class="footer-widget-title"> <i class="fa fa-user pink-color"></i> KURUMSAL  </h3>                                    
                                    <ul>
                                        <?=simplePageList(1)?>
                                    </ul>
                                </div>
                            </aside>
                            <aside class="col-md-3 col-sm-6">
                                <div class="footer-widget footer-widgetx space-bottom-35">
                                    <h3 class="footer-widget-title"> <i class="fa fa-info-circle green-color"></i> MÜŞTERİ HİZMETLERİ </h3>                                    
                                    <ul>
                                      <?=simplePageList(2)?>
                                    </ul>
                                </div>
                            </aside>
                            <aside class="col-md-3 col-sm-6 hidden-xs">
                                <div class="footer-widget footer-widgetx space-bottom-35">
                                    <h3 class="footer-widget-title"> <i class="fa fa-bars golden-color"></i> BİZDEN HABERLER </h3>
                                    <div class="recent-post">
                                        <ul>
                                        <?=generateLastNews(5)?>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
                <div class="bg2-with-mask space-20 footer-meta">
                    <span class="black-mask color-mask"></span>                    
                    <div class="container theme-container">
                        <div class="row">
                            <aside class="col-md-6 col-sm-6 copy-rights">
                                <p><?=siteConfig('firma_adi')?> © Copyright 2018 - Tüm Hakları Saklıdır</p>
                            </aside>
                            <aside class="col-md-6 col-sm-6 payment-options">
                                <ul>
                                    <li><i class="fa fa-cc-visa"></i></li>
                                    <li><i class="fa fa-cc-mastercard"></i></li>    
                                </ul>
                            </aside>
                        </div>
                    </div>
                </div>

            </footer> 

            <div id="to-top" class="to-top hidden"><i class="fa fa-angle-up"></i></div>
            
        </main>
		
		<?php if(isReallyMobile()) { ?>
		<nav id="menu" class="hidden-lg hidden-md">
			<ul>
			<?=aquaMobileMenu(false,50)?>
			<li><a href="#">Markalar</a>
				<ul><?=aquaMarkalar(false,24)?></ul>
			</li>
			</ul>
		</nav>	
		<?php } ?>
		
         <script src="templates/aqua/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
         <script src="templates/aqua/assets/plugins/bootstrap/js/jquery.cookie.js"></script>
        <script src="templates/aqua/assets/plugins/owl-carousel/owl.carousel.min.js"></script>  
        <script src="templates/aqua/assets/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>   
        <script src="templates/aqua/assets/js/jquery.mmenu.all.min.js"></script>   
        <script src="templates/aqua/assets/js/theme.js"></script>
		<?php echo generateTemplateFinish();?>
	

    </body>
</html>
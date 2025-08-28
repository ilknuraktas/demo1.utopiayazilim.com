<!DOCTYPE HTML>
<html lang="tr-TR">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo generateTemplateHead(); ?> 
	<!-- css -->
	<link rel="stylesheet" href="templates/workshop/css/style.css" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>	
	<!-- //css -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<!-- header -->
<div class="header">
	<div id="yukari"></div>
	<div class="wrapper">
		<!-- header left -->
		<div class="header-left">
			<div class="support"><img src="templates/workshop/img/support.png" alt="" /> Bilgi ve Danışma <span><?=siteConfig('firma_tel')?></span></div>
			<div class="logo"><a href="./"><img src="<?=slogoSrc('templates/workshop/img/logo.png')?>" alt="<?=siteConfig('seo_title')?>" /></a></div>
		</div>
		<!-- //header left -->
		<!-- header middle -->
		<div class="header-middle">
			<div class="head-menu">
				<ul>
					<?=simplePageList(2)?>
				</ul>
			</div>
			<div style="clear:both;"></div>
			<div class="search">
				<form action="page.php" method="get">
                	<input type="hidden" name="act" value="arama" />
					<input type="text" placeholder="<?=_lang_arama?>" name="str" class="s-box" id="detailSearchKey" />
					<input type="submit" value="" class="s-btn" />
				</form>
				<div style="clear:both;"></div>
			</div>
		</div>
		<!-- //header middle -->
		<!-- header right -->
		<div class="header-right">
			<div class="user-menu">
				<ul>
                	<?
						if(!$_SESSION['userID']) 
						{
						?>
							<li><a href="<?=slink('login')?>"><img src="templates/workshop/img/login.png" alt="<?=_lang_titleLogin?>" /> <?=_lang_titleLogin?></a></li>
							<li><a href="<?=slink('register')?>"><img src="templates/workshop/img/register.png" alt="<?=_lang_uyeOlmakIstiyorum?>" /> <?=_lang_uyeOlmakIstiyorum?></a></li>
                        <?
						}
						else
						{
						?>
							<li><a href="<?=slink('login')?>"><img src="templates/workshop/img/login.png" alt="<?=_lang_hesabim?>" /> <?=_lang_hesabim?></a></li>
							<li><a href="<?=slink('logout')?>"><img src="templates/workshop/img/register.png" alt="<?=_lang_cikis?>" /> <?=_lang_cikis?></a></li>
                        <?
						}
						?>						
						
				</ul>
			</div>
			<div style="clear:both;"></div>
			<div class="basket" id="imgSepetGoster"><a href="<?=slink('sepet')?>" id="toplamUrun"><?=basketInfo('toplamUrun')?></a></div>
		</div>
		<!-- //header right -->
		<div style="clear:both;"></div>
	</div>
	<!-- main menu -->
	<div class="main-menu">
		<div class="wrapper">
			<ul>
				<li><a href="<?=slink('tumKategoriler')?>"><img src="templates/workshop/img/home.png" alt="<?=_lang_tumKategoriler?>" /> <?=_lang_tumKategoriler?></a>
                	<div class="ws-sub-menu"><ul><?=simpleCatList2()?></ul></div>
                </li>
				<li><a href="<?=slink('indirimde')?>"><?=_lang_titleIndirimde?></a></li>
				<li><a href="<?=slink('yeni')?>"><?=_lang_titleSonEklenenler?></a></li>
			</ul>
		</div>
	</div>
	<!-- //main menu -->
</div>
<!-- //header -->
<!-- content -->
<div class="content">
	<div class="wrapper">
        <?
			$singleBlockArray = array('urunDetay','tumKategoriler','satinal','login','sepet','pcToplama');
			if(!in_array($_GET['act'],$singleBlockArray))
			{
				?>
				<!-- sidebar -->
				<div class="sidebar">
					<!-- sidebarmenu -->
					<div class="sidebar-menu sidebar-box">
						<ul>
							<?=simpleCatList(hq('select ID from kategori where parentID=\''.currentCat().'\'')?currentCat():currentParentCatID())?>
						</ul>
					</div>
					<!-- //sidebarmenu -->
					<!-- survey -->
					<div class="survey sidebar-box">
						<div class="sidebar-title">ANKET</div>
						<div class="survey-answer">
							<?=anket()?>
						</div>
					</div>
					<!-- //survey -->
                    <? if($_GET['act'] == 'kategoriGoster')
					{
						echo generateTableBox('SEÇİMİ DARALTIN',generateFilter('FilterLists'),'LeftBlock');
					}
					?>
					<!-- populars -->
					<div class="populars sidebar-box">
						<div class="sidebar-title"><?=_lang_titleCokSatanlar?></div>
						<ul>
							<?=urunBlockList('select * from urun where active=1 order by sold desc limit 0,3')?>
							<!-- //product -->
						</ul>
					</div>
					<!-- //populars -->
					<!-- banner -->
					<div class="banner"><img src="templates/workshop/img/banner.png" alt="Reklam" /></div>
					<!-- //banner -->
					<!-- news -->
					<div class="news sidebar-box">
						<div class="sidebar-title">HABERLER</div>
						<ul>
							<?=generateLastNews(3)?>
						</ul>
					</div>
                    <? if($_GET['act'])
					{
						echo generateTableBox('BLOG',makaleCatList(0),'LeftBlockUL');
						echo generateTableBox('GALERİ',simpleGalleryCatList(),'LeftBlockUL');
					}
					echo generateTableBox('Para Birimi',curSelectOption(),'LeftBlockUL');
					//echo generateTableBox(lang_titleSeciniz ,langSelectOption(),'LeftBlockUL');
					?>
                    <?php echo insertBanner('spsol');?>
					<!-- //news -->
				</div>
				<!-- //sidebar -->
                <?
			}
		?>
		<!-- content area -->
		<div class="main-content <?=(in_array($_GET['act'],$singleBlockArray)?'single-block':'')?>">
			<div style="clear:both;"></div>
            
			<!-- main slider -->
			<?=$PAGE_OUT?>
		</div>
		<!-- //content area -->
		<div style="clear:both;"></div>
	</div>
</div>
<!-- //content -->
<?php echo insertBanner('spfooter');?>
<!-- footer  -->
<div class="footer">
	<div class="footer-top">
		<div class="wrapper">
			<div class="ebulten">
				<span>Ebülten Aboneliği</span>
				<form action="" onSubmit="ebultenSubmit('ebulten'); return false;">
					<input type="text" placeholder="<?=_lang_formEpostaAdresiniz?>" id="ebulten" class="b-box" />
					<input type="submit" value="" class="b-btn" />
				</form>
			</div>
			<div class="up-btn"><a href="#yukari" class="anchorLink"><img src="templates/workshop/img/upbtn.png" alt="" /></a></div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div class="wrapper">
		<!-- footer left -->
		<div class="footer-left">
			<div class="footer-logo"><a href=""><img src="templates/workshop/img/footerlogo.png" alt="<?=siteConfig('seo_title')?>" /></a></div>
			<div class="footer-address">
           <?=siteConfig('firma_adi')?><br>
            <?=siteConfig('firma_tel')?><br>
            <?=siteConfig('firma_adres')?><br>     
			</div>
		</div>
		<!-- //footer left -->
		<!-- footer menu -->
		<div class="footer-menu">
			<div class="footer-title">KURUMSAL</div>
			<ul>
				<?=simplePageList(1)?>
			</ul>
		</div>
		<!-- //footer menu -->
		<!-- footer menu -->
		<div class="footer-menu">
			<div class="footer-title">MÜŞTERİ HİZMETLERİ</div>
			<ul>
				<?=simplePageList(2)?>
			</ul>
		</div>
		<!-- //footer menu -->
		<!-- footer social -->
		<div class="footer-social">
			<?=modSocial()?>
		</div>
		<!-- //footer social -->
		<!-- footer bank -->
		<div class="footer-bank"><img src="templates/workshop/img/footerbank.png" alt="" /></div>
		<!-- //footer bank -->
		<div style="clear:both;"></div>
		<!-- footer copyright -->
		<div class="footer-copyright">
			<?=$_SERVER['HTTP_HOST']?> bulunan tüm ürün ürünlere ait açıklayıcı bilgiler, görseller telif hakları kanununca korunmakta olup izinsiz paylaşılması, kopyalanması veya herhangi biri yazılı ya da görsel mecralarda kullanılması kanunen yasaklanmış olup hukuki yaptırıma tabi tutulmaktadır.
		</div>
		<!-- //footer copyright -->
	</div>
</div>
<!-- //footer  -->
<?php echo generateTemplateFinish();?>
	<!-- javascript -->
	<script type="text/javascript" src="templates/workshop/js/jquery.bxslider.js"></script>
	<script type="text/javascript" src="templates/workshop/js/jquery.anchor.js"></script>
	<script type="text/javascript" language="javascript" src="templates/workshop/js/easytabs.js"></script>
	<!-- //javascript -->
</body>
</html>
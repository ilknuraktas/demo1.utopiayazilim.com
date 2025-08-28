<?php
if($_GET['act'] == 'kategoriGoster')
{
	require_once('include/mod_CatSlider.php');
	$actHeaderArray['kategoriGoster'] = modCatSlider();
}
function myurunDetay()
{
		if (!hq("select ID from urun where ID='".$_GET['urunID']."'"))
				exit("<script>window.location.href ='index.php';</script>");
			if ($siteTipi == 'TEKURUN' || $siteTipi == 'GRUPSATIS')
			{
				header('location:index.php?urunID='.$_GET['urunID']);
				exit();
			}
			$out .= generateTableBox(breadCrumb(),showItem($_GET['urunID']),tempConfig('urundetay'));
			$out .= '<br>';	
			// $caprazSonra = 1;
			$out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler,caprazPromosyonUrunList(),tempConfig('urunliste'));	
			$out .= paketIndirim($_GET['urunID'],'UrunListLite','UrunListLiteShow',tempConfig('urunliste'));
			$out .= generateTableBox(_lang_ilgiliUrunler,'<div class="home-slider"><ul class="home-product-slider">'.ilgiliUrunList('empty','UrunListSliderShow').'</ul></div>',tempConfig('urunliste'));			
			$out .= generateTableBox(_lang_kategorininEnCokSatanlari,'<div class="home-slider"><ul class="home-product-slider">'.urunlist('select * from urun where catID=\''.urun('catID').'\' AND ID!= \''.$_GET['urunID'].'\' order by sold desc limit 0,10','empty','UrunListSliderShow').'</ul></div>',tempConfig('urunliste'));
	return $out;
}


function wsVitrinContent()
{
	$cacheName= __FUNCTION__;
	$cache = cacheout($cacheName);
	if ($cachex)
		return $cache;
	$i=0;
	$q = my_mysql_query("select link,resim from kampanyaBanner order by seq");
	while ($d=my_mysql_fetch_array($q))
	{
		$i++;
		$out.="<div id='tabcontent$i'><a href='".$d['link']."'><img alt='Kampanya' src='images/kampanya/".$d['resim']."' /></a></div>\n";
	}
	return cachein($cacheName,$out);
}

function wsVitrinContentDemo()
{
	return '<!--Start Tabcontent 1 -->
				<div id="tabcontent1"><img src="templates/workshop/img/slider1.jpg" alt="" /></div>
				<!--End Tabcontent 1-->

				<!--Start Tabcontent 2-->
				<div id="tabcontent2"><img src="templates/workshop/img/slider2.jpg" alt="" /></div>
				<!--End Tabcontent 2 -->

				<!--Start Tabcontent 3-->
				<div id="tabcontent3"><img src="templates/workshop/img/slider3.jpg" alt="" /></div>
				<!--End Tabcontent 3-->

				<!--Start Tabcontent 4-->
				<div id="tabcontent4"><img src="templates/workshop/img/slider4.jpg" alt="" /></div>
				<!--End Tabcontent 4-->
				
				<!--Start Tabcontent 5-->
				<div id="tabcontent5"><img src="templates/workshop/img/slider5.jpg" alt="" /></div>
				<!--End Tabcontent 5-->
				
				<!--Start Tabcontent 6-->
				<div id="tabcontent6"><img src="templates/workshop/img/slider6.jpg" alt="" /></div>
				<!--End Tabcontent 6-->
				
				<!--Start Tabcontent 7-->
				<div id="tabcontent7"><img src="templates/workshop/img/slider7.jpg" alt="" /></div>
				<!--End Tabcontent 7-->
				
				<!--Start Tabcontent 8-->
				<div id="tabcontent8"><img src="templates/workshop/img/slider8.jpg" alt="" /></div>
				<!--End Tabcontent 8-->
				
				<!--Start Tabcontent 9-->
				<div id="tabcontent9"><img src="templates/workshop/img/slider9.jpg" alt="" /></div>
				<!--End Tabcontent 9-->
				
				<!--Start Tabcontent 10-->
				<div id="tabcontent10"><img src="templates/workshop/img/slider10.jpg" alt="" /></div>
				<!--End Tabcontent 10-->';	
}

function wsVitrinThumb()
{
	$cacheName= __FUNCTION__;
	$cache = cacheout($cacheName);
	if ($cachex)
		return $cache;
	$i=0;
	$q = my_mysql_query("select link,thumb,resim from kampanyaBanner order by seq");
	while ($d=my_mysql_fetch_array($q))
	{
		$i++;
		$out.='<li><a href="#" onmouseover="easytabs(\'1\', \''.$i.'\');" onfocus="easytabs(\'1\', \''.$i.'\');" onclick="return false;"  title="" id="tablink'.$i.'"><img src="images/kampanya/'.($d['thumb']?$d['thumb']:$d['resim']).'" alt="" /></a></li>'."\n";
	}
	return cachein($cacheName,$out);
}

function wsVitrinThumbDemo()
{
	return '<li><a href="#" onmouseover="easytabs(\'1\', \'1\');" onfocus="easytabs(\'1\', \'1\');" onclick="return false;"  title="" id="tablink1"><img src="templates/workshop/img/thumb1.png" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'2\');" onfocus="easytabs(\'1\', \'2\');" onclick="return false;"  title="" id="tablink2"><img src="templates/workshop/img/thumb2.png" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'3\');" onfocus="easytabs(\'1\', \'3\');" onclick="return false;"  title="" id="tablink3"><img src="templates/workshop/img/thumb3.png" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'4\');" onfocus="easytabs(\'1\', \'4\');" onclick="return false;"  title="" id="tablink4"><img src="templates/workshop/img/thumb4.jpg" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'5\');" onfocus="easytabs(\'1\', \'5\');" onclick="return false;"  title="" id="tablink5"><img src="templates/workshop/img/thumb5.jpg" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'6\');" onfocus="easytabs(\'1\', \'6\');" onclick="return false;"  title="" id="tablink6"><img src="templates/workshop/img/thumb6.jpg" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'7\');" onfocus="easytabs(\'1\', \'7\');" onclick="return false;"  title="" id="tablink7"><img src="templates/workshop/img/thumb7.png" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'8\');" onfocus="easytabs(\'1\', \'8\');" onclick="return false;"  title="" id="tablink8"><img src="templates/workshop/img/thumb8.png" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'9\');" onfocus="easytabs(\'1\', \'9\');" onclick="return false;"  title="" id="tablink9"><img src="templates/workshop/img/thumb9.png" alt="" /></a></li>
						<li><a href="#" onmouseover="easytabs(\'1\', \'10\');" onfocus="easytabs(\'1\', \'10\');" onclick="return false;"  title="" id="tablink10"><img src="templates/workshop/img/thumb10.png" alt="" /></a></li>';	
}
?>
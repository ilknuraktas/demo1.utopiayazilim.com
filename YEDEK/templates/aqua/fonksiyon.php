<?php

function tukendim($d) {
	if($d['stok'] <=0)
		$out.='<div class="product-etiket tukendi"><img class="img_tukendi" src="templates/aqua/images/stoktayok.png" alt="tükendi"/></div>';
	return $out;
}

function indirimde($d) {
	if($d['indirimde']==1)
		$out.='<div class="indirimde">İNDİRİM</div>';
	return $out;
}

function urunKod($d) {
	if($d['tedarikciCode']) {
		$out.= $d['tedarikciCode'];
	} else {
		$out.= "#".$d['ID'];
	}
	return $out;
}

function anindaGonderim($d) {
	if($d['anindaGonderim']==1)
		$out.='<div class="product-etiket hidden-xs"><img class="img_anindaGonderim" src="templates/aqua/images/anindaGonderim.png" alt="anindaGonderim"/></div>';
	return $out;
}

function kargobeles($d) { 
	if($d['ucretsizKargo']==1)
		$out.='<div class="product-etiket"><img class="img_kargobeles" src="templates/aqua/images/ucretsizkargo.png" alt="ücretsiz kargo"/></div>';
	return $out;
}
function yeniUrun($d) {
	if($d['yeni'])
		$out.='<div class="product-etiket"><img class="img_yeniurun" src="templates/aqua/images/yeniurun.png" alt="yeni ürün"/></div>';
	return $out;
}

function piyasafiyatx($d) {
	if(fixFiyat($d['piyasafiyat']) > fixFiyat($d['fiyat'])) {
	$out.='<h4 class="grey-btn-small old-price">'.fixFiyat($d['piyasafiyat']).' TL</h4>';
	return $out;
	}
}

function markaID($d) {
	if($d['markaID'])
		$out.= $d['markaID'];
	return $out;
}

function indirimOran($d) {
	
	if(fixFiyat($d['piyasafiyat']) > fixFiyat($d['fiyat'])) {
	$oranx = (($d['fiyat'] / $d['piyasafiyat']) * 100);
	$yuzdem = round(100 - $oranx);
	$out.='<div class="product-indirim hidden"><div class="pink-new-tag new-tag"><a class="funky-font" href="#">%'.$yuzdem.'</a><span>İNDİRİM</span></div></div>';
	return $out;
	
	}
}

function urunResim2($d) {

	$foto1 = "templates/aqua/resizer.php?src=images/urunler/".$d['resim']."&h=250&w=313&zc=2";
	$foto2 = "templates/aqua/resizer.php?src=images/urunler/".$d['resim2']."&h=250&w=313&zc=2";
	
	if($d['resim2']) {

	$out.= '<span class="hover-image white-bg"><img src="'.$foto2.'" alt="'.$d['name'].'"></span>';

	} else {
		$out.= '<span class="hover-image white-bg"><img src="'.$foto1.'" alt="'.$d['name'].'"></span>';
	}
	return $out;
			
}

function katMarka()
{
	if (($_GET['markaID'])>0) {
	$q = my_mysql_query("select * from marka where ID='".$_GET['markaID']."'");
	if (!my_mysql_num_rows($q)) return;
	$d = my_mysql_fetch_array($q);	
	$out ='<h2 class="kat-title sub-title">'.$d['name'].' Ürünleri</h2>';
	} else {
	$out ='<h2 class="kat-title sub-title">'.kat('name').'</h2>';	
	}
return $out;
}

function aquaMobileMenu($parentID,$limit) 
{
    global $siteConfig,$langPrefix; 
    $cacheName= __FUNCTION__.$parentID.$limit; 
    $cache = cacheout($cacheName); 
    if ($cache) 
        return $cache; 
    $q = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active =1 AND parentID='$parentID' order by seq,name limit 0,$limit"); 
    while($d = my_mysql_fetch_array($q)) 
    { 
        $d = translateArr($d); 
        $link= kategoriLink($d); 
        if(catCheck($d['ID'])) 
        {    

            if (hq("select name from kategori where active = 1 AND parentID='".$d['ID']."'")) 
            {
            	$out.='<li><span>'.$d['name'].'</span>'."\n";

                $q2 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d['ID']."' order by seq"); 
                if (my_mysql_num_rows($q2)) 
                {
					 $out.='<ul>'."\n";
                    while ($d2 = my_mysql_fetch_array($q2)) 
                    {
                        $d2 = translateArr($d2); 
                        $linkSub= kategoriLink($d2); 
                        if(catCheck($d2['ID'])) 
                        { 
                            if (hq("select name from kategori where active = 1 AND parentID='".$d2['ID']."'")) 
                            {
								$out.='<li><span>'.$d2['name'].'</span>'."\n";
								
                                $q3 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d2['ID']."' order by seq,name"); 
                                if (my_mysql_num_rows($q3)) 
                                {
                                    $out.='<ul>'."\n"; 
                                    while ($d3 = my_mysql_fetch_array($q3)) 
                                    { 
                                        $d3= translateArr($d3); 
                                        $link2Sub= kategoriLink($d3); 
                                        if(catCheck($d3['ID'])) 
                                        {
                                        	 if (hq("select name from kategori where active = 1 AND parentID='".$d3['ID']."'")) 
					                            {
													$out.='<li><span>'.$d3['name'].'</span>'."\n";
													
					                                $q4 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d3['ID']."' order by seq,name"); 
					                                if (my_mysql_num_rows($q4)) 
					                                {
					                                    $out.='<ul>'."\n"; 
					                                    while ($d4 = my_mysql_fetch_array($q4)) 
					                                    { 
					                                        $d4= translateArr($d4); 
					                                        $link3Sub= kategoriLink($d4); 
					                                        if(catCheck($d4['ID'])) 
					                                            $out.='<li><a id="a'.$d4['ID'].'"  href="'.$link3Sub.'">'.$d4['name'].'</a></li>'."\n"; 
					                                    }

					                                 	$out.='<li class="item"><a href="'.$link2Sub.'" class="parent"><i class="fa fa-chevron-right"></i> Tümünü Göster</a>'."\n";

					                                    $out.='</ul>'."\n"; 
					                                    
					                                }
					                              $out.='</li>';
					                            } else {
													
													$out.='<li><a href="'.$link2Sub.'">'.$d3['name'].'</a>'."\n"; 
												}
                                        }
                                    }

                                 	$out.='<li class="item"><a href="'.$linkSub.'" class="parent"><i class="fa fa-chevron-right"></i> Tümünü Göster</a>'."\n";

                                    $out.='</ul>'."\n"; 
                                    
                                }
                              $out.='</li>';
                            } else {
								
								$out.='<li><a href="'.$linkSub.'">'.$d2['name'].'</a>'."\n"; 
							}                            
                        }
                    }
                    $out.='<li class="item"><a href="'.$link.'" id="a'.$d['ID'].'" class="parent"><i class="fa fa-chevron-right"></i> Tümünü Göster</a>'."\n";
                    $out.='</ul>'."\n"; 
                }
            	$out.='</li>';
            } else {
	        	$out.='<li class="item"><a href="'.$link.'" id="a'.$d['ID'].'" class="parent">'.$d['name'].'</a></li>'."\n"; 
	   		 }
	    }
	}
return cachein($cacheName,$out);
}

function aquaTopMenu($parentID,$limit) 
{
    global $siteConfig,$langPrefix; 
    $cacheName= __FUNCTION__.$catID.$_SESSION['groupID']; 
    $cache = cacheout($cacheName); 
    if ($cache) 
        return $cache; 
    $q = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active =1 AND parentID='$parentID' order by seq,name limit 0,$limit"); 
    while($d = my_mysql_fetch_array($q)) 
    {
		
		$d = translateArr($d);
		$link= kategoriLink($d);
		if(catCheck($d['ID']))
		{	
			if (hq("select name from kategori where parentID='".$d['ID']."'")) {
				$out.='<li class="dropdown dropmenu '.$d['seo'].'"><a id="a'.$d['ID'].'" class="dropdown-toggle" href="'.$link.'" role="button" aria-haspopup="true">'.$d['name'].'</a><i class="fa fa-caret-down"></i>'."\n";
			}
			else
			{
				$out.='<li class="dropdown '.$d['seo'].'"><a id="a'.$d['ID'].'" class="dropdown-toggle
				" href="'.$link.'" role="button" aria-haspopup="true">'.$d['name'].'</a>'."\n";
			}
			if (hq("select name from kategori where parentID='".$d['ID']."'"))
			{
				$q2 = my_mysql_query("select * from kategori where active = 1 AND parentID='".$d['ID']."' order by seq,name");
				if (my_mysql_num_rows($q2))
				{
					$out.='<ul class="dropdown-menu dropdown-menu2col">'."\n";
					while ($d2 = my_mysql_fetch_array($q2))
					{
						$d2 = translateArr($d2);
						$linkSub= kategoriLink($d2);
						if(catCheck($d2['ID']))
						{	
							$out.='<li><a id="a'.$d2['ID'].'"  class="'.$d['seo'].'" href="'.$linkSub.'">'.$d2['name'].'</a>'."\n";
								//$out.='<ul class="sub-menu2">'.simpleCatList($d2['ID']).'</ul>';
							$out.='</li>';
						}
							
					}
					$out.='</ul>'."\n";
					
				}
			}
			$out.='</li>';
		}
	}
	return cachein($cacheName,$out);	
}

function mykategoriGoster()
{
	$defaultOrderBy = 'urun.seq desc,urun.ID desc';
	//$out .= generateTableBox(breadCrumb(),itemOrder(),tempConfig('formlar'));
	//$out .= generateTableBox(currentCatName().' Kategorileri',showCategoryPictures('KategoriList'),tempConfig('formlar'));
	//$out .= showCategoryBanner();
	if($_GET['catID'])
		$out .= generateTableBox(_lang_titleSikcaSorularnSorular,sss(),tempConfig('bilgi_sayfalari'));
	
	if(function_exists('getOrderBy'))
		$order = getOrderBy();
	else
	$order =  ($_GET['orderBy']?$_GET['orderBy']:$defaultOrderBy);

	$baslik = ($_GET['catID']?currentCatName():dbInfo('marka','name',$_GET['markaID']));
	
	if ($_GET['fID'] && !$_GET['catID']) $baslik = $_GET['fVal'];
	if($_GET['catID']) $showCategoryinfo = showCategoryBanner();
	
	$out .= generateTableBox('<div class="col-md-12 katBaslik">'.$baslik.'</div><div class="clearfix"></div>','<div class="col-md-12 katDesc">'.$showCategoryinfo.'</div><div class="col-md-12 katOrder">'.itemOrder().'</div>'.showCategory($_GET['catID'],$order),tempConfig('urunliste')).'<div class="clearfix"></div>';

	my_mysql_query('update kategori set hit = hit + 1 where ID=\''.$_GET['catID'].'\' limit 1');
	setStats('updateKategori');	
	return $out;
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
	$out .= showItem($_GET['urunID']);
	// $caprazSonra = 1;
	$out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler,caprazPromosyonUrunList(),tempConfig('urunliste'));	
	$out .= generateTableBox('Bu Ürünler de İlginizi Çekebilir',ilgiliUrunList('UrunList','UrunListBenzer'),'UrunDetayInnerBlock');	
	$out .= paketIndirim($_GET['urunID'],'UrunListLite','UrunListLiteShow',tempConfig('urunliste'));		
	return $out;	 
}

function aquafooterMenu($catID)
{
	$cacheName= __FUNCTION__.$catID.$_SESSION['groupID'];
	$cache = cacheout($cacheName);
	if ($cache)
	return $cache;
	$q = my_mysql_query("select * from kategori where active =1 AND parentID='$catID' order by seq,name limit 0,5");
	while($d = my_mysql_fetch_array($q))
	{
		$d = translateArr($d);
		$link= kategoriLink($d);
		if(catCheck($d['ID']))
		{	
			$out.='<li class="footer-list-item"><a href="'.$link.'">'.$d['name'].'</a></li>'."\n";
		}
	}
	return cachein($cacheName,$out);	
}

function aquaMarkalar($catID,$limit)
{
	$cacheName= __FUNCTION__.$catID.$limit;
	$cache = cacheout($cacheName);
	if ($cache)
		return $cache;
	global $siteConfig;
	if ($catID)
		$q = my_mysql_query("select marka.*,kategori.ID as catID from urun,kategori,marka where urun.markaID = marka.ID AND urun.catID=kategori.ID AND (urun.showCatIDs like '%|$catID|%' OR urun.catID='$catID') group by marka.ID order by marka.name limit 0,$limit") or die(my_mysql_error());
	else 
		$q = my_mysql_query("select marka.*,kategori.ID as catID from urun,kategori,marka where urun.markaID = marka.ID AND urun.catID=kategori.ID  group by marka.ID order by marka.name limit 0,$limit") or die(my_mysql_error());
	while($d=my_mysql_fetch_array($q))
	{
		if ($siteConfig['seoURL']) 
			$out.='<li><a href="'.seoFix($d['name']).'-kat0-marka'.$d['ID'].'.html">'.($d['name']).'</a></li>'."\n";
		else
			$out.='<li><a href="page.php?act=kategoriGoster&catID=0&markaID='.$d['ID'].'">'.($d['name']).'</a></li>'."\n";	
	}
	return cachein($cacheName,$out);
}


function mobileProductSlider($d)
{
		for($i=0;$i<=5;$i++)
		{
			$str = ($i?'resim'.$i:'resim');
			if (!$d[$str]) continue;
				$resimx = '';
			if ($d[$str])
				 $fotob = "images/urunler/" . $d[$str] . "";
            $fotok  = "include/resize.php?path=images/urunler/" . $d[$str] . "&amp;width=700";
				$resimx='<li class="item"><a href="'.$fotob.'" class="lightboxx"><img src="'.$fotok.'" alt="'.$d['name'].'" /></a></li>';
			$out.= $resimx;
		}

	return $out;
}


function aquaSlider()
{
	$out = '';
	$q = my_mysql_query("select * from kampanyaJSBanner order by seq asc");
	while ($d=my_mysql_fetch_array($q))
	{	
		$out.='<div class="item"><a href="'.$d['link'].'"><img src="images/kampanya/'.$d['resimJS'].'"  alt="'.$d['title'].'"></a></div>'."\n";				
	}
	return $out;
}

?>
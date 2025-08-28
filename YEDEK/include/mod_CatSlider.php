<?php
/*
if($_GET['act'] == 'kategoriGoster')
{
	require_once('include/mod_CatSlider.php');
	$actHeaderArray['kategoriGoster'] = modCatSlider('400');
}
 */

function simpleCatSlider($tag = 'li', $tagAttr = '', $imgAttr = '')
{
	$q = my_mysql_query("select * from sliderkategori where catIDs = '" . $_GET['catID'] . "' OR catIDs like '%," . $_GET['catID'] . ",%' OR catIDs like '%," . $_GET['catID'] . "' OR catIDs like '" . $_GET['catID'] . ",%' order by seq limit 0,4");
	if (!my_mysql_num_rows($q)) return;
	$i = 0;
	while ($d = my_mysql_fetch_array($q)) {
		$li .= '<' . $tag . ' ' . $tagAttr . '>
				<a href="' . $d['link'] . '"><img ' . $imgAttr . '  src="images/kampanya/' . $d['resim'] . '"  alt=""></a>
			</' . $tag . '>' . "\n";
		$i++;
	}
	return $li;
}

function modCatSlider($act = null)
{
	global $jsLoad, $globalFilter;
	if($_GET['catID'])
		return simpleCatSlider();
	$out = $li = $cat_pager = '';
	if ($_GET['catID'] && hq("select ID from sliderkategori where catIDs = '" . $_GET['catID'] . "' OR catIDs like '%," . $_GET['catID'] . ",%' OR catIDs like '%," . $_GET['catID'] . "' OR catIDs like '" . $_GET['catID'] . ",%' limit 0,1")) {
		$q = my_mysql_query("select * from sliderkategori where catIDs = '" . $_GET['catID'] . "' OR catIDs like '%," . $_GET['catID'] . ",%' OR catIDs like '%," . $_GET['catID'] . "' OR catIDs like '" . $_GET['catID'] . ",%' order by seq limit 0,9");
		if (!my_mysql_num_rows($q)) return;
		$i = 0;
		while ($d = my_mysql_fetch_array($q)) {
			$li .= '<li>
				<a href="' . $d['link'] . '"><img src="images/kampanya/' . $d['resim'] . '"  alt=""></a>
			</li>' . "\n";
			$cat_pager .= '<li>
					<a rel="' . $i . '" href="javascript:;" class="pagenum">
					  <img src="images/kampanya/' . $d['resim'] . '" alt="" />			  
					</a>
				  </li>';
			$i++;
		}
	} else {
		if ($globalFilter)
			$globalFilterString = '(' . $globalFilter . ') AND ';

		$filter = '';
		if(!$act)
		{
			if($_GET['act'] == 'sepet')
			{	
				$c = hq("select count(*) from urun where active = 1 AND kasa = 1");
				$filter = ($c?'urun.kasa=1':'urun.indirimde = 1 OR urun.anasayfa=1');
			}
			$q = ($_GET['act'] == 'sepet' ?
				my_mysql_query("select urun.* from urun,kategori where urun.ID NOT IN(select urunID from sepet where adet > 0 AND randStr = '" . $_SESSION['randStr'] . "') AND urun.catID = kategori.ID AND urun.stok > 0 AND ($filter) AND urun.active = 1 AND kategori.active = 1 order by rand() limit 0,12") :
				my_mysql_query("select urun.* from urun,kategori where $globalFilterString urun.catID=kategori.ID AND (kategori.idPath like '" . currentCatPatern() . "' OR kategori.idPath like '" . currentCatPatern() . "/%') AND piyasafiyat != '' AND indirimde=1 AND urun.active = 1 AND kategori.active = 1 order by rand() limit 0,12"));
		}
		else
		{
			switch($act)
			{
				case 'ilgili':
					$iu = '';
					$qs = my_mysql_query("select ilgiliUrunler from urun where ID IN(select urunID from sepet where randStr='".$_SESSION['randStr']."')");
					while($ds = my_mysql_fetch_array($qs))
					{
												
					}
					break;
			}
		}

		if (!my_mysql_num_rows($q)) return;
		$i = 0;
		while ($d = my_mysql_fetch_array($q)) {
			$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
			if (!$_SESSION['cache_setfiyatBirim']) {
				$piyasaFiyat = $d['piyasafiyat'];
				$fiyatBirim = fiyatBirim($d['fiyatBirim']);
				$fiyat = $d['fiyat'];
			} else {
				$fiyatBirim = fiyatBirim($_SESSION['cache_setfiyatBirim']);
				$piyasaFiyat = fiyatCevir($d['piyasafiyat'], $d['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
				$fiyat = fiyatCevir($d['fiyat'], $d['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
			}


			$fiyatBirim = fiyatBirim('TL');
			$piyasaFiyat = fiyatCevir($d['piyasafiyat'], $d['fiyatBirim'], 'TL');
			$fiyat = fiyatCevir($d['fiyat'], $d['fiyatBirim'], 'TL');


			$resim = ($d['resimvitrin'] ? $d['resimvitrin'] : 'include/resize.php?path=images/urunler/' . $d['resim'] . '&width=400');
			$li .= '<li>
			<div class="sldimg"><center><a href="' . urunLink($d) . '"><img src="' . $resim . '"></a></center></div>
			<div class="sldinfo"><strong>' . $d['name'] . '<br/><a class="sldmarka" href="{%MARKA_LINK%}">{%MARKA_ADI%}</a></strong> <span class="cat-slider-fiyat"><span>' . ($piyasaFiyat?my_money_format('', $piyasaFiyat) . ' ' . $fiyatBirim:'') . '</span> ' . my_money_format('', $fiyat) . ' ' . $fiyatBirim . '</span></div>
			
			<div class="gitbtn"><a href="' . urunLink($d) . '">' . _lang_urunIncele . '</a> </div>
			{%SAYAC%}
			</li>' . "\n";
			$cat_pager .= '<li>
					<a rel="' . $i . '" href="javascript:;" class="pagenum">
					  <img src="include/resize.php?path=images/urunler/' . $d['resim'] . '&width=400" alt="' . $d['name'] . '" alt="" />
					  
					</a>
				  </li>';
			$li = urunTemplateReplace($d,$li);
			$i++;
		}
	}
	$out .= '
	<div class="catSlider">
            <div class="viewport">
              <ul class="overview">
                ' . $li . '
              </ul>
            </div><!-- /.viewport -->
            <ul class="cat_pager">
              ' . $cat_pager . '
            </ul>
			<div class="clear"></div>
          </div>';

	$out .= '<style>
	.sldimg{float:left; width:300px;}
	.sldmarka { font-size:10px; color:#ccc !important; }
	.gitbtn{padding:9px 18px; border:1px solid #ebebeb; position:absolute; top:150px; margin-left:300px; font-size:15px; background:#f4f4f4;}
	.sldinfo{float:left; text-align:left; position:absolute; margin-top:5px; margin-left:300px; font-size:20px;}
	.sldinfo strong { min-height:80px; overflow:hidden; display:block; }
	    .catSlider {position: relative; width: 100%; }
      .catSlider .viewport { float: left; width: calc(100% - 320px); min-width:580px !important;  position: relative;}
        .catSlider .overview { list-style: none;  padding: 0; margin: 0; left: 0; top: 0; }
          .catSlider .overview li { float: left;  position: relative; width:100%;}
            .catSlider .overview li img {max-width: 90%; max-height: 350px; margin-top:5px;}
      .catSlider .cat_pager {float:left; width: 300px;  font-size:14px; line-height:10px; margin:0px;margin-left:20px;  box-sizing:content-box; padding:0;}
        .catSlider .cat_pager li {float: left; width: 100px; height: 100px;margin-bottom: 1px; position: relative; box-}
          .catSlider .cat_pager li a {display: block; width: 100px; padding: 10px 8px; height: 100px; position: absolute; right: 0; line-height: 1.4; text-align: right; border-radius:0; border:none;}
            .catSlider .cat_pager li a img {float: left; margin-top: -5px;}

			.catSlider .pagenum img { width:80px; padding:5px; border:1px solid #ccc; border-radius:5px; background-color:#fff; }
			.catSlider .pagenum.active img { border-color:#67b500; }
			.catSlider a { color:#555; }
			.cat-slider-fiyat { font-size:22px !important; font-weight:bold; color:red; display:block; margin-top:10px; white-space:nowrap; }
			.cat-slider-fiyat span { color:grey; text-decoration:line-through; font-weight:normal; font-size:19px; padding-top:5px; }
			.urun-sayac { position:absolute; top:233px; left:300px; }
			
			@media (max-width: 800px) {
				.sldmarka { display:none; }
				.urun-sayac { top:0; right:0; width:20px; left:auto; }
				.catSlider .cat_pager { padding-top:30px; margin-right: auto; margin-left:auto; float:none; clear:both; }
				.catSlider { height:600px; }
				.catSlider .viewport { height:180px; width:100%; min-width:auto !important;}
				.catSlider .overview li { width:100%; height:180px; }
				.catSlider .overview li img { margin-top:10px; }
				.catSlider .sldimg { width:100px; }
				.catSlider .sldinfo { margin-left:110px; margin-top:0; }
				.catSlider .gitbtn { margin-left:110px; top:130px; bottom:inherit; }
				.cat-slider-fiyat { margin-top:0; }
				.sldinfo strong { margin-top:10px; }
			}
	</style>
	<script>
			$(".catSlider ul.overview li").hide();
			$(".catSlider .pagenum").click(
				function(){
					$(".catSlider .pagenum").removeClass("active");
					$(this).addClass("active");
					$(".catSlider ul.overview li").hide();
					$(".catSlider ul.overview li:eq("+$(this).attr("rel")+")").fadeIn("fast");
				}
			);
			$(".catSlider .pagenum:first").click();
	</script>
	
	';
	return $out;
}
?>
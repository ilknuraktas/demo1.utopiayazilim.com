<?php

function mypaketler()
{

  global $seo;
  $seo->currentTitle = _lang_kampanyaliPaketler;
  $out .=generateTableBox("", mc_CategoryStyle("showPacket"), tempConfig('urunpack'));
  return $out;
}

function my404()
{

  $e404ID = hq("select ID from pages where e404 = 1 limit 0,1");
  $_GET['ID'] = $e404ID;
  $out .= generateTableBox(dbInfo("pages", "title", $_GET["ID"]), dbInfo("pages", "body", $_GET["ID"]), tempConfig('makale_sayfalari'));
  return $out;

}

function mymakaleListe()
{

  global $siteConfig, $siteDizini, $seo;
  if (!$_GET['mcatID']) {
    redirect(slink('makale'));
  }
  $seo->currentTitle = hq("select name from makalekategori where ID='" . $_GET['mcatID'] . "'");
  $out .= generateTableBox($seo->currentTitle, '<div class="row">' . makaleList(12) . '</div>', tempConfig('makale_sayfalari'));
  $out .= articlePager();
  return $out;

}

function myshowBlog()
{

  global $siteConfig, $siteDizini, $seo;
  $seo->currentTitle = dbInfo("makaleler", "Baslik", $_GET['ID']);
  $catID = hq("select catID from makaleler where ID= '" . $_GET['ID'] . "'");
  $out .= generateTableBox(hq("select Baslik from makaleler where ID= '" . $_GET['ID'] . "'"), makaleShow($_GET['ID']) . '<hr>' . showArticleComments($_GET['ID']), tempConfig('makale_sayfalari'));

  return $out;

}

function myMakale()
{

  global $siteConfig, $siteDizini, $seo;
  $seo->currentTitle = hq("select Baslik from makaleler where ID= '" . $_GET['ID'] . "'");
  $catID = hq("select catID from makaleler where ID= '" . $_GET['ID'] . "'");
  $out .= generateTableBox('BLOG', '<div class="row">' . makaleList(12, "MakaleListShow") . '</div>', tempConfig('makale_sayfalari'));

  return $out;

}

function myiletisim()
{
  global $siteConfig, $siteDizini, $seo;
  $seo->currentTitle = _lang_titleMusteriHizmetleri;
  telFix('ceptel');
  $out .= generateTableBox(_lang_titleMusteriHizmetleri, '<div class="row">
            <div class="col-sm-12">' . dbInfo('pages', 'body' . $langPrefix, 4) . '</div>
            <div class="col-sm-12">' . ($_POST['data_message'] ? contactFormSubmit() : contactForm()) . '</div></div>', tempConfig('formlar'));
  if ($_POST['data_subject']) {
    $_POST['data_tarih'] = date('Y-m-d H:i:s');
    insertToDb('iletisim');
  }
  return $out;
}

function myarama()
{
  global $siteConfig, $siteDizini, $seo;
  $seo->currentTitle = _lang_titleDetayliArama . ' ' . stripslashes($_GET['str']);
  $out .= generateTableBox(_lang_titleDetayliArama, searchForm(), tempConfig('formlar'));
  $out .= generateTableBox(_lang_titleAramaSonuclari . ($_GET['str'] ? ' (' . (int)mysql_num_rows(mysql_query(getSearchQuery($_GET['str']))) . ')' : ''), searchResults(), tempConfig('arama'));
  //$out .= generateTableBox(_lang_titlecokArananlar,topResults(),tempConfig('formlar'));
  //$out .= generateTableBox(_lang_titleEtiket,topSearchResults(),tempConfig('formlar'));
  return $out;

}

function myurundetay()
{
  global $siteConfig, $siteDizini, $seo;
  if (!hq("select ID from urun where ID='" . $_GET['urunID'] . "'"))
    exit("<script>window.location.href ='index.php';</script>");
  $out .= generateTableBox(breadCrumb(), showItem($_GET['urunID']), tempConfig('urundetay'));
  // $out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler, caprazPromosyonUrunList(), tempConfig('urunliste'));

  $out .= generateTableBox(_lang_ilgiliUrunler, ilgiliUrunList(), tempConfig('urunlistlite'));
  $out .= generateTableBox(_lang_kategorininEnCokSatanlari, urunlist('select * from urun where catID=\'' . urun('catID') . '\' AND ID!= \'' . $_GET['urunID'] . '\' order by sold desc limit 0,10', 'UrunListLite', 'UrunListLiteShow'), tempConfig('urunlistlite'));

  return $out;
}

function myGetOrderBySelect($attr)
{


  global $defaultOrderBy;
  return '<select onchange="$(\'#urunsirala\').submit();" name="orderBy" id="orderBy" ' . $attr . '>
<option selected value="if(urun.stok > 0,0,1),urun.seq desc,urun.ID desc">' . _lang_sirala . '</option>
<option value="tarih desc">' . _lang_tariheGore . '</option>
<option value="fiyat asc">' . _lang_fiyataGore . ' Artan</option>
<option value="fiyat desc">' . _lang_fiyataGore . ' Azalan</option>
<option value="name asc">' . _lang_urunAdinaGore . '</option>

</select>' . (getOrderBy() != $defaultOrderBy ? jselect('orderBy', getOrderBy()) : '');
}


function mykategoriGoster()
{

  global $siteConfig, $siteDizini, $seo, $defaultOrderBy, $langPrefix;
  if (isset($_GET['mc_list_type']))
    $_SESSION['mc_list_type'] = $_GET['mc_list_type'];
  $out = '';
  $order = ($_GET['orderBy'] ? $_GET['orderBy'] : $defaultOrderBy);
  $baslik = ($_GET['catID'] ? breadCrumb() : dbInfo('marka', 'name', $_GET['markaID']));
  if ($_GET['fID'] && !$_GET['catID']) $baslik = $_GET['fVal'];
  // $out .= mc_showCatBanner($_GET["catID"]);
  $out .= generateTableBox($baslik . '', itemOrder() . showCategory($_GET['catID'], $order), tempConfig('urunliste'));
  my_mysql_query('update kategori set hit = hit + 1 where ID=\'' . $_GET['catID'] . '\' limit 1');
  setStats('updateKategori');
  if (function_exists('iFrameKontrol'))
    $out .= iFrameKontrol();
  return $out;
}

function myalarmList()
{


  uyeKontrol();
  global $seo;
  $seo->currentTitle = _lang_titleAlarmList;
  $out .= generateTableBox(_lang_aklimdakiler, urunlist("select urun.* from urun,alarmListe where urun.ID=alarmListe.urunID AND urun.active=1 and alarmListe.userID=" . $_SESSION["userID"] . " and  alarmListe.type='AlarmListem' order by urun.sold desc", 'UrunList', 'UrunListShow'), tempConfig('urunliste')) . '<br>';
  return $out;
}

function ShowCategorySeo($type)
{
  global $siteConfig, $siteDizini, $seo, $defaultOrderBy, $langPrefix;
  return generateTableBox(($_GET['catID'] ? dbInfo('kategori', 'name', $_GET['catID']) : dbInfo('marka', 'name', $_GET['markaID'])) . ' ile ilgili şeyler', showCategoryBanner($type . $langPrefix), tempConfig('seo'));

}

?>
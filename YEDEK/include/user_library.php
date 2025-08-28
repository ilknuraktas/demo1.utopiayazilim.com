<?php


function adminSepetInfo($d)
{
  $c = hq("select tedarikciCode from urun where ID='" . $d['urunID'] . "'");
  if ($c)
    return 'Ürün Kodu : ' . $c . '<br />';
}
/* Aşağıdaki fonkisyonda urunListShow ve/veya urunGoster.php için yeni makro ekleyebilirsiniz. */
function myUrunTemplateReplace($d, $contents)
{

  if (function_exists('myUrunTemplateReplace2')) return myUrunTemplateReplace2($d['ID'], $contents);
  if (function_exists('myUrunTemplateReplaceX')) return myUrunTemplateReplaceX($d['ID'], $contents);
  return $contents;
}

function updateAutoStock($filter = '')
{
  if (!siteConfig('kodeslestirme'))
    return;
  $q = my_mysql_query("SELECT ID,tedarikciCode, COUNT(*) c FROM urun where tedarikciCode != '' AND stok > 0 " . ($filter ? ' AND (' . $filter . ')' : '') . " GROUP BY tedarikciCode HAVING c > 1 order by fiyat asc");
  while ($d = my_mysql_fetch_array($q)) {
    my_mysql_query("update urun set active = 0 where tedarikciCode like '" . $d['tedarikciCode'] . "'");
    my_mysql_query("update urun set active = 1 where ID = '" . $d['ID'] . "' limit 1");
  }
}

function facebookYorum()
{
  global $siteConfig;
  $width = '100%';

  if (!$_SESSION['lang'])
    $lang = 'tr-TR';
  else
    $lang = $_SESSION['lang'] . '-' . strtoupper($_SESSION['lang']);

  $out = '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;



  js.src = \'https://connect.facebook.net/' . $lang . '/sdk.js#xfbml=1&version=v2.12&appId=' . siteConfig('facebook_appID') . '&autoLogAppEvents=1\';
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
<div class="fb-comments" data-href="' . selfURL() . '" data-width="' . $width . '" data-numposts="5"></div>';
  return $out;
}


function paytrTaksit()
{

  $username = hq("select clientID from banka where paymentModulURL like '%payment_paytr%' AND active = 1 limit 0,1");
  $token = hq("select modData1 from banka where paymentModulURL like '%payment_paytr%' AND active = 1 limit 0,1");
  if (!$username || !$token)
    return;
  $qu = my_mysql_query("select * from urun where ID='" . $_GET['urunID'] . "'");
  $du = my_mysql_fetch_array($qu);
  $du['fiyat'] = fixFiyat($du['fiyat'], 0, $du['ID']);
  $du['fiyat'] = YTLfiyat($du['fiyat'], $du['fiyatBirim']);
  $du['fiyat'] = my_money_format('', $du['fiyat']);
  $du['fiyat'] = str_replace(array(','), '', $du['fiyat']);
  $amount = $du['fiyat'];
  $azami = azamiTaksit($_GET['urunID']);
  if ($azami == 1)
    return 'Bu üründe taksit yapılamamaktadır.';
  if (!$azami || $azami > 12)
    $azami = 12;

  return '

	<style>
    #paytr_taksit_tablosu{clear: both;font-size: 12px;max-width: 1200px;text-align: center;font-family: Arial, sans-serif;}
    #paytr_taksit_tablosu::before {display: table;content: " ";}
    #paytr_taksit_tablosu::after {content: "";clear: both;display: table;}
    .taksit-tablosu-wrapper{margin: 5px;width: 280px;padding: 12px;cursor: default;text-align: center;display: inline-block;border: 1px solid #e1e1e1;}
    .taksit-logo img{max-height: 28px;padding-bottom: 10px;}
    .taksit-tutari-text{float: left;width: 126px;color: #a2a2a2;margin-bottom: 5px;}
    .taksit-tutar-wrapper{display: inline-block;background-color: #f7f7f7;}
    .taksit-tutar-wrapper:hover{background-color: #e8e8e8;}
    .taksit-tutari{float: left;width: 126px;padding: 6px 0;color: #474747;border: 2px solid #ffffff;}
    .taksit-tutari-bold{font-weight: bold;}
    @media all and (max-width: 600px) {.taksit-tablosu-wrapper {margin: 5px 0;}}
</style>
<div id="paytr_taksit_guncelle"><div id="paytr_taksit_tablosu"></div></div>
<script>
paytrURL = \'https://www.paytr.com/odeme/taksit-tablosu/v2?token=' . $token . '&merchant_id=' . $username . '&taksit=' . $azami . '&tumu=0\';
</script>
<script src="https://www.paytr.com/odeme/taksit-tablosu/v2?token=' . $token . '&merchant_id=' . $username . '&amount=' . $amount . '&taksit=' . $azami . '&tumu=0"></script>';
}

function iyziTaksit()
{
  $username = hq("select username from banka where paymentModulURL like '%payment_iyzi%' limit 0,1");
  if (!$username) return;

  $qu = my_mysql_query("select * from urun where ID='" . $_GET['urunID'] . "'");
  $du = my_mysql_fetch_array($qu);
  $du['fiyat'] = fixFiyat($du['fiyat'], 0, $du['ID']);
  $du['fiyat'] = YTLfiyat($du['fiyat'], $du['fiyatBirim']);
  $du['fiyat'] = my_money_format('', $du['fiyat']);
  $du['fiyat'] = str_replace(array(',', '.'), '', $du['fiyat']);
  $amount = $du['fiyat'];
  $currency = 'TL';
  $timestamp = date('YmdHis'); // Timestamp
  $apiID = $username; // Merchant API ID - in current eg., 
  $publicKey = sha1($apiID);
  $hash = sha1($apiID . $timestamp . $amount);
  $out = "<iframe height='500' width='900' src='https://www.iyzico.com/installment/amount/$amount/currency/$currency/publicKey/$publicKey/timeStamp/$timestamp/hash/$hash' seamless='seamless'></iframe>";
  return $out;
}

$saatler = array('10:30', '13:30', '15:00', '18:00');
$maxGun = 3;
$saatKoruma = 2;

function siparisSaati()
{
  global $saatler, $maxGun, $saatKoruma;
  $out = '<table class="siparisSaati" cellpadding="0" cellspacing="1"><tr>
			<td>Saatler</td>';
  for ($i = 0; $i <= $maxGun; $i++) {
    $tarih = date('Y-m-d', mktime((date('H')), date('i'), date('s'), date('m'), (date('d') + $i), date('Y')));
    $out .= '<td>' . mysqlTarih($tarih) . '</td>' . "\n";
  }
  $out .= '</tr>';
  foreach ($saatler as $saat) {
    $out .= '<tr class="saat"><td>' . $saat . '</td>';
    for ($i = 0; $i <= $maxGun; $i++) {
      $tarih = date('Y-m-d', mktime((date('H')), date('i'), date('s'), date('m'), (date('d') + $i), date('Y')));
      list($s, $d) = explode(':', $saat);
      $stop = false;
      if ($i == 0) {
        if (date('H') > ($s - $saatKoruma)) $stop = true;
        else
					if (date('H') == ($s - $saatKoruma))
          if (date('i') > $m)
            $stop = true;
        if (hq("select ID from stats where k like 'teslimatSaati' AND v like '" . $tarih . ':' . $saat . "'"))
          $stop = true;
      }
      if (!$stop)
        $out .= '<td><center><input name="data_data1" type="radio" value="' . mysqlTarih($tarih) . ' : ' . $saat . '"></center></td>' . "\n";
      else
        $out .= '<td class="dolu"><center>' . _lang_dolu . '</center></td>' . "\n";
    }
    $out .= '</tr>';
  }
  $out .= '</table>';

  $out .= '
	<style>
		.siparisSaati  {  background-color:#ccc; padding:0; margin:0; border:none; width:100%; }
		.siparisSaati td { background-color:white; }
		.siparisSaati tr.saat:hover td { background-color:#555; color:white; }
		.siparisSaati .dolu { background-color:#555; color:white; font-weight:bold; }

	</style>
	';
  return $out;
}

/* Aşağıdaki fonkisyonda açıp, sepet ve satın alma ekranınlarını gösteren bar'ı aktif edebilirsiniz. */
// $actHeaderArray['sepet'] = $actHeaderArray['satinal'] = siraGoster();

/* Aşağıdaki fonkisyonda satın alma adımlarını gösteren bar'ı kişiselleştirebilirsiniz. */
function siraGoster()
{
  $out = '<div class="multi-step five-steps">&nbsp;<br />
			<ol>
				<li id="ms_1">
					<div class="wrap">
						<p class="title">' . _lang_sepet . '</p>
						<p class="subtitle">' . _lang_sepetiniziOnaylayin . '</p>
					</div>
				</li>
				<li id="ms_2">
					<div class="wrap">
						<p class="title">' . _lang_adres . '</p>
						<p class="subtitle">' . _lang_teslimatBilgileriniziGirin . '</p>
					</div>
				</li>
				<li id="ms_3">
					<div class="wrap">
						<p class="title">' . _lang_odemeSecim . '</p>
						<p class="subtitle">' . _lang_odemeTipiSecimiYapin . '</p>
					</div>
				</li>
				<li id="ms_4">
					<div class="wrap">
						<p class="title">' . _lang_odemeGiris . '</p>
						<p class="subtitle">' . _lang_odemeBilgileriniGirin . '</p>
					</div>
				</li>
				<li id="ms_5">
					<div class="wrap">
						<p class="title">' . _lang_onay . '</p>
						<p class="subtitle">' . _lang_odemenizTamamlandi . '</p>
					</div>
				</li>
			</ol>
		</div>';
  $out .= "<script type='text/javascript'>$('.multi-step li:eq(" . (alisverisSirasix() - 1) . ")').addClass('current');</script>";
  return $out;
}

function alisverisSirasix()
{
  global $tamamlandi;
  $out = 1;
  list($x, $_GET['op']) = explode('-', $_GET['replaceGet']);
  if ($_GET['act'] == 'satinal') {
    if ($_GET['op'] == 'adres') $out = 2;
    if ($_GET['op'] == 'adres' && $_POST['data_address']) $out = 3;
    if ($_GET['paytype']) $out = 4;
    if ($tamamlandi) $out = 5;
  }
  return $out;
}

function textBox($backColor, $textColor, $fontSize, $text)
{
  $out = '<div class="textBox">' . "\n";
  $out .= '<div style="background-color:' . $backColor . ';color:' . $textColor . ';font-size:' . $fontSize . 'px;">' . $text . '</div></div>' . "\n";
  return $out;
}



function scriptmenu()
{
  $out = '';

  if (siteConfig('proCark_useractive')) {
    include_once('include/mod_page_myprocark.php');
    $out .= procarkScreen();
  }


  if (siteConfig('promosyonTeklifAktif'))
    include('mod_Promosyon.php');

  if (siteConfig('splash_active') && (!siteConfig('sadeceUye') || $_SESSION['userID']))
    include('mod_Splash.php');

  stats_update();
  require_once('include/mod_FacebookPopup.php');
  if (function_exists('facebookPopup') && !$_SESSION['facebookPopup'] && siteConfig('facebook_URL') && siteConfig('facebook_Popup')) {
    $out .= facebookPopup();
    $_SESSION['facebookPopup'] = 1;
  }

  if (function_exists('facebookFloating') && siteConfig('facebook_Floating')) {
    $out .= facebookFloating();
  }
  if (siteConfig('criteoAccountID')) {
    include_once('mod_CriteoTracking.php');
    $out .= criteoReconversion();
  }
  $out .= googleDynr();
  if (function_exists('googleDataLayer'))
    $out .= googleDataLayer();

  if (function_exists('userInsiderTracker'))
    $out .= userInsiderTracker();
  if (function_exists('pinterestTracker'))
    $out .= pinterestTracker();
  if (siteConfig('cookie')) {
    $out .= '<script type="text/javascript">
						window.cookieconsent_options = {"message":"' . addslashes(_lang_cookieAccept) . '","dismiss":"' . _lang_onayliyorum . '","learnMore":"More info","link":null,"theme":"dark-bottom"};
					</script>					
					<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
					<!-- End Cookie Consent plugin -->';
  }

  $out .= str_replace('&#39;', "'", siteConfig('google_analytics'));
  $out .= str_replace('&#39;', "'", siteConfig('pc_code'));
  $out .= str_replace('&#39;', "'", siteConfig('google_remarketing'));
  if (siteConfig('facebook_pixel') || siteconfig('facebook_token')) {
    $out .= str_replace('&#39;', "'", siteConfig('facebook_pixel'));
    $out .= facebookPixel();
  }
  $out .= googleReconversion();
  if (function_exists('searchRichSnippets'))
    $out .= searchRichSnippets();
  if (function_exists('googleOdeme'))
    $out .= googleOdeme();
  if ($_SESSION['googleConversion']) {
    $out .= $_SESSION['googleConversion'];
    unset($_SESSION['googleConversion']);
  }
  if ($_SESSION['googleConversionUye']) {
    $out .= $_SESSION['googleConversionUye'];
    unset($_SESSION['googleConversionUye']);
  }
  if (siteConfig('google_purchases')) {
    require_once('mod_GooglePurchases.php');
    $out .= googlePurchases();
  }
  $out .= "<script>$(function() { $.get('update.php',function(data){ console.log(data); }); });</script>";
  return $out;
}

function tr2eu($str, $ucFirst = false)
{
  if ($ucFirst) $str = strtolower($str);
  $str = str_replace(array('ğ', 'ü', 'ş', 'ı', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'), array('g', 'u', 's', 'i', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'), $str);
  if ($ucFirst) $str = tr_ucfirst($str, 'UTF-8');
  return $str;
}

function trupper($str)
{
  $str = str_replace(array('ğ', 'ü', 'ş', 'ı', 'ö', 'ç', 'i'), array('Ğ', 'Ü', 'Ş', 'I', 'Ö', 'Ç', 'İ'), $str);
  return strtoupper($str, 'utf8');
}

function tr_ucfirst($string, $encoding)
{
  $strlen = mb_strlen($string, $encoding);
  $firstChar = mb_substr($string, 0, 1, $encoding);
  $then = mb_substr($string, 1, $strlen - 1, $encoding);
  return mb_strtoupper($firstChar, $encoding) . $then;
}

function ajaxfix($tck, $iconv = false)
{
  return $tck;
}

function utf8fix($tck, $iconv = false, $tr = false)
{
  return $tck;
}

function tr_cevir($str)
{
  $str = str_replace(array('&amp;', '&Ccedil;', '&ccedil;', '&#286;', '&#287;', '&#304;', '&#305;', '&Ouml;', '&ouml;', '&#350;', '&#351;', '&Uuml;', '&uuml;'), array('&', 'Ç', 'ç', 'Ğ', 'ğ', 'İ', 'ı', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü'), $str);
  return $str;
}

function generateTemplateFinish()
{
  global $disablehelp, $shopphp_demo, $tempCanChange, $footerJS, $bodyHTML;
  $out = $bodyHTML;
  $out .= scriptmenu();
  //$out .= str_replace(array('satinal_sp__op-adres.html','ac/satinal/adres'), 'ac/sepet/hizli', sepetGoster());
  require_once('include/mod_Whatsapp.php');
  $out .= whatsappFooterSupport();

  if (!siteConfig('telif-footer') && !$disablehelp && !$tempCanChange && !$shopphp_demo && !isset($_GET['viewPopup']) && (!basename($_SERVER['SCRIPT_FILENAME']) || basename($_SERVER['SCRIPT_FILENAME']) == 'index.php' || basename($_SERVER['SCRIPT_FILENAME']) == 'page.php'))
    $out .= '<div class="powered-by"><a class="shopphp" title="ShopPHP" href="https://www.shopphp.net/" target="_blank"> ShopPHP</a> | v5</div>';
  $out .= '<script type="text/javascript" src="assets/js/all-js.php" type="text/javascript"></script>' . "\n";
  if ($_GET['op'] == 'odeme')
    $out .= '<script language="javascript" src="templates/system/odeme/card-master/lib/js/jquery.card.js" type="text/javascript"></script>' . "\n";
  $out .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js" integrity="sha512-vDRRSInpSrdiN5LfDsexCr56x9mAO3WrKn8ZpIM77alA24mAH3DYkGVSIq0mT5coyfgOlTbFyBSUG7tjqdNkNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
  $out .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js" integrity="sha512-nUuQ/Dau+I/iyRH0p9sp2CpKY9zrtMQvDUG7iiVY8IBMj8ZL45MnONMbgfpFAdIDb7zS5qEJ7S056oE7f+mCXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
  $out .= '<script src="templates/' . siteConfig('templateName') . '/temp.js" type="text/javascript"></script>' . "\n";
  $out .= '<script language="javascript" type="text/javascript">$(document).ready(function() { tempStart(); });</script>';
  $out .= $footerJS;
  return $out;
}

function generateTemplateHead()
{
  global $siteDizini, $shopphp_demo, $noindex, $disableJquery, $headerCSS;
  $out  = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
  $out .= '<meta name="keywords" content="' . cleanForMetaTags(siteConfig('metaKeywords')) . '" />' . "\n";
  $out .= '<meta name="description" content="' . cleanForMetaTags(siteConfig('metaDescription')) . '" />' . "\n";
  $out .= '<meta http-equiv="x-dns-prefetch-control" content="on">
  <link rel="dns-prefetch" href="https://ajax.googleapis.com" />';
  if ($_GET['paytype'])
    $out .= '<meta http-equiv="refresh" content="600;url=' . $siteDizini . '" />';
  if (!$_GET['flt'] && !$shopphp_demo && !$noindex)
    $out .= '<meta name="robots" content="index, follow"/>' . "\n";
  else
    $out .= '<meta name="robots" content="noindex, nofollow"/>' . "\n";
  if ($_GET['urunID'] && !dbInfo('urun', 'stok', $_GET['urunID']))
    $out .= '<meta name="robots" content="noindex, nofollow"/>' . "\n";
  if($_SESSION['lang'] && $_SESSION['lang'] != 'tr')
    $lang  = hq("select name from langs where code like '" . $_SESSION['lang'] . "'");
  if (!$lang) $lang = 'Turkish';
  $out .= '<meta name="Language" content="' . $lang . '" />' . "\n";
  $lang = null;
  if($_SESSION['lang'] && $_SESSION['lang'] != 'tr')
    $lang  = hq("select code from langs where code like '" . $_SESSION['lang'] . "'");
  if (!$lang) 
    $lang = 'tr';
  $out .= '<meta http-equiv="Content-Language" content="' . $lang . '" />' . "\n";
  $out .= SEO::setCanonicalURL();
  $out .= '<base href="http' . (isSSL() ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $siteDizini . '" />' . "\n";
  if (siteConfig('google_meta')) {
    $googleMeta = siteConfig('google_meta');

    if (!(stristr($googleMeta, 'content') === false)) {
      $array = array();
      preg_match('/content="([^"]*)"/i', $googleMeta, $array);
      $googleMeta = $array[1];
    }
    $out .= '<meta name="google-site-verification" content="' . $googleMeta . '"/>' . "\n";
  }
  $nofArray = array('login', 'register', 'profile', 'siparistakip', 'sepet', 'satinal');
  if (in_array($_GET['act'], $nofArray))
    $out .= '<meta name="robots" content="noindex, nofollow" />' . "\n";
  $out .= SEO::socialMetaTags();

  $out .= '<title>' . siteConfig('title') . '</title>' . "\n";
  $out .= '<link rel="shortcut icon" type="image/png" href="images/' . (siteConfig('favicon') ? siteConfig('favicon') : 'shop.png') . '"/>' . "\n";
  $out .= '<link rel="stylesheet" href="assets/css/all-css.php" />' . "\n";
  $out .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css" integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />' . "\n";
  $out .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/css-stars.min.css" integrity="sha512-Epht+5WVzDSqn0LwlaQm6dpiVhajT713iLdBEr3NLbKYsiVB2RiN9kLlrR0orcvaKSbRoZ/qYYsmN1vk/pKSBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />' . "\n";
  $out .= '<link rel="stylesheet" href="templates/' . siteConfig('templateName') . '/style.css" />' . "\n";
  $out .= '<link rel="manifest" href="manifest.json">';
  if ($_GET['act'] == 'urunDetay')
    $out .= '<link rel="stylesheet" href="assets/css/popup.cc.css" />';
  if (!$disableJquery) {
    $out .= '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>' . "\n";
  }
  $out .= str_replace(array('&#39;'), array("'"), siteConfig('google_head'));
  $out .= str_replace(array('&#39;'), array("'"), siteConfig('chatcode'));
  $out .= $headerCSS;
  $out .= '<script>var currentact = \'' . addslashes(strip_tags($_GET['act'])) . '\';</script>';
  return $out;
}

function myShowItemTab($urunID)
{
  global $langPrefix;
  $tabBaslik = hq("select tabbaslik$langPrefix from urun where ID='$urunID'");
  $out = '<div id="tabs1">
  <ul>
    <li><a id="option1" href="#" onclick="openTab(1); return false;" title="' . _lang_urunOzellikleri . '"><span>' . _lang_urunOzellikleri . '</span></a></li>
    <li><a id="option8" href="#" onclick="openTab(8); return false;" ' . (hq("select video from urun where ID='$urunID'") ? '' : 'style="display:none;"') . '  title="Video"><span>' . _lang_video . '</span></a></li>    
    <li><a id="option5" href="#" onclick="openTab(5); return false;" title="' . _lang_odemeBilgileri . '"><span>' . _lang_odemeBilgileri . '</span></a></li>
    <li><a id="option2" href="#" onclick="openTab(2); return false;" title="' . _lang_urunResimleri . '"><span>' . _lang_urunResimleri . '</span></a></li>
    <li><a id="option4" href="#" onclick="openTab(4); return false;" title="' . _lang_urunYorumlari . '"><span>' . _lang_urunYorumlari . '</span></a></li>
    <li><a id="option7" href="#" onclick="openTab(7); return false;" title="' . _lang_titleSikcaSorularnSorular . '"><span>' . _lang_titleSikcaSorularnSorular . '</span></a></li>
    <li><a id="option3" href="#" onclick="openTab(3); return false;" title="' . _lang_geriBildirim . '"><span>' . _lang_geriBildirim . '</span></a></li>
    ' . ($tabBaslik ? '<li><a id="option9" href="#" onclick="openTab(9); return false;" title="' . $tabBaslik . '"><span>' . $tabBaslik . '</span></a></li>' : '') . '

  </ul>
</div>';
  $out .= '<img src="images/spacer.gif" width=1 height=15><br /><div id="tabData" class="tabData">';
  $out .= '<div id="tabData1" style="display:none;">' . hq("select detay$langPrefix from urun where ID='$urunID'") . '<div style="clear:both">&nbsp;</div>' . urunTemplateReplace($urunID, '{%FILTRE_TABLO%}') . '</div>';
  $out .= '<div id="tabData8" style="display:none;">' . hq("select video from urun where ID='$urunID'") . '</div>';
  if ($tabBaslik)
    $out .= '<div id="tabData9" style="display:none;">' . hq("select tabdetay$langPrefix from urun where ID='$urunID'") . '</div>';
  $out .= '<div id="tabData2" style="display:none;">' . showItemPictures($urunID) . '</div>';
  $out .= '<div id="tabData3" style="display:none;">' . generateFeedback($urunID) . '</div>';
  $out .= '<div id="tabData4" style="display:none;">' . showItemComments($urunID) . '</div>';
  $out .= '<div id="tabData5" style="display:none;">' . showTaksit() . '</div>';
  $out .= '<div id="tabData7" style="display:none;">' . showItemQst($urunID) . '</div>';
  $out .= '</div>';
  $openTab = ($_POST['SpcForm'] == 'feedback' ? 4 : 1);
  if ($openTab == 1) $openTab = ($_POST['SpcForm'] == 'qst' ? 7 : 1);
  if ($openTab == 1) $openTab = ($_POST['data_urun'] ? 3 : 1);
  $out .= '<script>openTab(' . $openTab . ');</script>';
  return $out;
}



function showTaksit()
{
  if (siteConfig('fiyatUyelikZorunlu') && !$_SESSION['userID']) return _lang_fiyatIcinUyeGirisiYapin;
  $urunID = $_GET['urunID'];
  $qUrun = my_mysql_query("select * from urun where ID='$urunID'");
  $d = my_mysql_fetch_array($qUrun);
  $out = '';
  if ($_SESSION['cache_setfiyatBirim'] && $_SESSION['cache_setfiyatBirim'] != 'TL')
    $out = _lang_urunFiyati . ' : {%URUN_FIYAT%} ';
  else {
    if (!$_GET['fiyat']) {
      if (siteConfig('tekCekimIndirim'))
        $out .= '<b style="display:block; padding-bottom:4px;">Kredi Kartı Tek Çekim (%' . (siteConfig('tekCekimIndirim') * 100) . ') :</b>{%URUN_TEKCEKIM_FIYAT_YTL%} TL (KDV Dahil)><br /><br />';
      if (siteConfig('havaleIndirim') && !hq("select ID from banka where (cat like '%," . urun('catID') . ",%' OR marka like '%," . urun('markaID') . ",%') AND paymentModulURL like '%havale%' AND active =1 "))
        $out .= '<b style="display:block; padding-bottom:4px;" class="b-hi">Havale / EFT (%' . (siteConfig('havaleIndirim') * 100) . ') :</b>{%URUN_HAVALE_FIYAT_YTL%} TL (KDV Dahil)<br /><br />';
      $out .= '<b>' . _lang_bankaOzelTaksit . '</b><br /><br />';
    }

    $paytrTaksit = paytrTaksit();
    if ($paytrTaksit)
      $out .= $paytrTaksit;
    else {
      $q = my_mysql_query("select banka.* from banka,bankaVade where banka.taksitOrani = 1 AND banka.active = 1 AND bankaVade.ay > 0 AND banka.ID=bankaVade.bankaID group by banka.ID order by banka.seq");
      $i = 1;
      while ($dt = my_mysql_fetch_array($q)) {

        $list = true;
        if (($dt['cat'] && $dt['cat'] != '0') || ($dt['marka'] && $dt['marka'] != '0')) {
          if ($dt['cat'] && $dt['cat'] != '0') if (!(stristr($dt['cat'], ',' . $d['catID'] . ',') === false)) {
            $list = false;
            $catArray = explode('|', $d['showCatIDs']);
            foreach ($catArray as $catVal) {
              if (!(stristr($dt['cat'], ',' . $catVal . ',') === false) && ((int)$catVal))
                $list = true;
            }
          }
          if ($dt['marka'] && $dt['marka'] != '0') if (!(stristr($dt['marka'], ',' . $d['markaID'] . ',') === false)) {
            $list = false;
          }
        }
        if ($dt['bakiye']) $list = false;
        if ($list) {
          $out .= '<div id="taksitGosterim">';
          $out .= '<div class="taksit-container">';
          $out .= taksit($dt['ID'], $urunID);
          $out .= '</div>';
          $out .= '</div>';
          if (!($i % 3)) $out .= "<div class='clear-space'></div>";
          $i++;
        }
      }
    }
  }
  $out .= "<div class='clear-space'></div>";
  return urunTemplateReplace($d, $out);
}

function pesinTaksitFix2($dVade, $urunID = 0)
{
  if ($urunID)
    $c = hq("select pesintaksit from urun where ID='$urunID' limit 0,1");
  else
    $c = hq("select urun.pesintaksit from urun,sepet where sepet.urunID=urun.ID AND sepet.randStr = '" . $_SESSION['randStr'] . "' order by pesintaksit desc limit 0,1");

  if ((int)$dVade['ay'] <= (int)$c)
    $dVade['vade'] = 0;
  return $dVade;
}

function taksit($bankaID, $urunID)
{
  $_GET['bankaID'] = $bankaID;
  $_GET['urunID'] = $urunID;

  $q = my_mysql_query("select * from banka where ID='" . $_GET['bankaID'] . "'");
  $d = my_mysql_fetch_array($q);
  $v = my_mysql_query("select * from bankaVade where bankaID='" . $_GET['bankaID'] . "' order by ay");
  $d['taksitSayisi'] = (my_mysql_num_rows($v) + 1);

  $arka = $d['bcolor'];
  $font = $d['fcolor'];
  if (!$arka && !$font)
    list($arka, $font) = explode(',', $d['taksitGosterimCSS']);
  $d['taksitGosterimCSS'] = 'genel_';
  $qu = my_mysql_query("select * from urun where ID='" . $_GET['urunID'] . "'");
  $du = my_mysql_fetch_array($qu);
  $du['fiyat'] = fixFiyat($du['fiyat'], 0, $du['ID']);
  $du['fiyat'] = YTLfiyat($du['fiyat'], $du['fiyatBirim']);

  if ($_GET['fiyat'])
    $du['fiyat'] = $_GET['fiyat'];
  // $pesinFiyatinaTaksitOrani = dbinfo('urun','pesinTaksitOrani',$_GET['urunID']);
  $out .= '<div class="' . $d['taksitGosterimCSS'] . 'taksitDiv" style="margin:0; padding:0;">';
  $out .= '<table cellspacing="1" cellpadding="0" width="100%">';
  $out .= '<tr>';
  $out .= '<td colspan="3" valign="top" class="taksitTopHeader" style=" background-color:' . $arka . '; color:' . $font . ';">' . ($d['taksitGosterimBaslik'] ? $d['taksitGosterimBaslik'] : '<img src="images/banka/' . $d['taksitUrunLogo'] . '" />') . '</td></tr>';
  $out .= '<tr><td class="taksitHeaderEmpty" style=" background-color:' . $arka . '; color:#' . $font . ';"></td><td class="taksitHeader" style=" background-color:' . $arka . '; color:' . $font . ';">' . _lang_taksitTutari . '</td><td class="taksitHeader" style=" background-color:' . $arka . '; color:' . $font . ';">' . _lang_toplam . '</td></tr>';
  //$out.='<tr height=2><td></td></tr>';
  $azamiTaksit = azamiTaksit($urunID);
  while ($vade = my_mysql_fetch_array($v)) {
    if (function_exists('pesinTaksitFix2'))
      $vade = pesinTaksitFix2($vade, $urunID);
    if (!$vade['ay'] || ($azamiTaksit < $vade['ay'])) continue;
    $i = $vade['ay'];
    $p = $vade['plus'];
    $goster = ($p ? $i . ' (+' . $p . ')' : $i);
    $toplamFaiz = $vade['vade'];
    $toplamOdenecek = (($toplamFaiz + 1) * $du['fiyat']);
    $taksit = ($i == 1 ? '' : ($toplamOdenecek / $i));
    $pesinFiyatina = ($toplamOdenecek == $du['fiyat'] ? true : false);
    $trClass = ($pesinFiyatina ? 'class="pesin"' : '');

    $out .= "<tr $trClass><td class='td1'>" . ($i == 1 ? 'Peşin' : $goster) . "</td>";
    $out .= "<td class='td2'>" . ($taksit ? my_money_format('%i', $taksit) . ' TL' : '-') . "</td>";
    $out .= "<td class='td3'>" . my_money_format('%i', $toplamOdenecek) . " TL</td>";
    $out .= '</tr>';
    if ($i != $d['taksitSayisi']) $out2 .= '<tr height=2><td></td></tr>';
  }


  for ($i = 1; $i <= $d['taksitSayisi']; $i++) {
    // $toplamFaiz = ($i * $d['taksitOrani']);

  }
  $out .= '</table>';
  $out .= '</div>';
  return $out;
}


function urunSayac($urunID)
{
  if (!$urunID) return;
  $tarihArray = explode(' ', hq("select finish from urun where ID='$urunID'"));
  list($yil, $ay, $gun) = explode('-', $tarihArray[0]);
  list($dak, $san) = explode(':', $tarihArray[1]);

  return '<script>
			function liftOff() 
			{
				window.location.reload();
			}
			$(\'#sayac\').countdown({tickInterval: 1,onExpiry: liftOff,until: new Date(' . $yil . ', (' . $ay . ' - 1), ' . $gun . ', ' . $dak . ', ' . $san . '),timezone: +2,     layout: \'{dn} - {hnn}:{mnn}:{snn}\'});	
			
			</script>';
}

function seoURLFix($str)
{
  $str = strtolower(trim(tr2eu($str)));
  $str = preg_replace('/[^a-z0-9-\/]/', '-', $str);
  $str = preg_replace('/-+/', "-", $str);
  $str = strtolower($str);
  return $str;
  /*
	$str = str_replace(' ','_',tr2eu($str,false));
	$str = str_replace("'",'',$str);
	$str = str_replace("&#39;",'',$str);	
	$str = str_replace('"','',$str);
	$str = str_replace('/','_',$str);
	return $str;
	 */
}

function seoFix($str)
{
  if (function_exists('mySeoFix')) return mySeoFix($str);
  $str = strtolower(trim(tr2eu($str)));
  $str = str_replace(array('&#39;', '&amp;'), '', $str);
  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
  $str = preg_replace('/-+/', "-", $str);
  $str = strtolower($str);
  $str = str_replace('--', '-', $str);
  $last = substr($str, -1);
  if ($last == '-')
    $str =  substr($str, 0, -1);
  return $str;
  /*
	$str = str_replace(' ','_',tr2eu($str,false));
	$str = str_replace("'",'',$str);
	$str = str_replace("&#39;",'',$str);	
	$str = str_replace('"','',$str);
	$str = str_replace('/','_',$str);
	return $str;
	 */
}

function kargoSuresi($d)
{
  if (!$d['kargoGun'] && !$d['anindaGonderim'])
    return;
  $gun = date('N', strtotime(date('Y-m-d') . ' + ' . (int)$d['kargoGun'] . ' days'));
  if (date('H') > 15) {
    $gun++;
    $d['kargoGun']++;
  }
  if ($gun == 6)
    $d['kargoGun'] += 2;
  else if ($gun == 7)
    $d['kargoGun'] += 1;

  $gun = date('N', strtotime(date('Y-m-d') . ' + ' . (int)$d['kargoGun'] . ' days'));
  $haftaArr = array('Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma');
  return '<strong>En geç ' . mysqlTarih(date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . (int)$d['kargoGun'] . ' days'))) . ' ' . $haftaArr[($gun - 1)] . ' günü kargoda.</strong>';
}

/*
function cal_days_in_month($calendar,$month, $year) { 
if(checkdate($month, 31, $year)) return 31; 
if(checkdate($month, 30, $year)) return 30; 
if(checkdate($month, 29, $year)) return 29; 
if(checkdate($month, 28, $year)) return 28; 
return 0; // error 
} 
 */
function googleFinish($code, $randStr)
{
  $q = my_mysql_query("select * from siparis where randStr = '" . $randStr . "'");
  $siparisData = my_mysql_fetch_array($q);
  $out = '<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push([\'_setAccount\', \'' . $code . '\']); // 
_gaq.push([\'_trackPageview\']);
_gaq.push([\'_addTrans\',
\'' . $randStr . '\', // 
\'' . siteConfig('seo_urunTitle') . '\', // Affiliate/Mağaza Adı
\'' . basketInfo('toplamKDVHaric', $randStr) . '\', // Toplam Tutar - Gerekli
\'' . basketInfo('toplamKDV', $randStr) . '\', // Vergi
\'' . basketInfo('Kargo', $randStr) . '\', // Kargo Ücreti
\'' . hq("select name from iller where plakaID='" . $siparisData['city'] . "'") . '\', // Şehir
\'' . hq("select name from iller where plakaID='" . $siparisData['city'] . "'") . '\', // Bölge veya Eyalet
\'Turkey\' // Ülke
]);';

  // Satın alınan her farklı ürün için addItem döngüsü kullanılmalıdır

  $q2 = my_mysql_query("select * from sepet where randStr like '$randStr'");
  while ($d2 = my_mysql_fetch_array($q2)) {
    $catID = hq("select markaID from urun where ID='" . $d2['urunID'] . "'");
    $catName = hq("select name from marka where ID='" . $catID . "'");
    $out .= '
		_gaq.push([\'_addItem\',
		\'' . $d2['ID'] . '\', //
		\'DD' . $d2['urunID'] . '\', // SKU/code - Gerekli
		\'' . $d2['urunName'] . '\', // Ürün İsmi
		\'' . $catName . '\', // Kategori veya Varyasyon
		\'' . $d2['ytlFiyat'] . '\', // Birim Fiyatı - Gerekli
		\'' . $d2['adet'] . '\' // Miktar - Gerekli
		]);';
  }
  $out .= '
_gaq.push([\'_trackTrans\']);
(function() {
var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>';
  return $out;
}

function urunDuzenle($d)
{
  if (strtolower(basename($_SERVER['SCRIPT_FILENAME'])) == 'page.php' && $_SESSION['admin_isAdmin']) {
    $out = '
		<div class="adminTools">
		<a class="btn-duzenle" target="_blank" href="secure/s.php?f=urun.php&y=d&ID=' . $d['ID'] . '">Düzenle</a>&nbsp;
		<a class="btn-stok">Stok :<strong class="pink-color"> ' . $d['stok'] . '</strong></a>';
    if ($d['bayifiyat'] > 0) {
      $out .= '&nbsp;<a class="btn-stok">AF :<strong class="pink-color"> ' . $d['bayifiyat'] . ' '.$d['fiyatBirim'].'</strong></a>';
    }
    $out .= '</div>';
    return $out;
  }
}


$hArray = array('0-9', 'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'H', 'I', 'İ', 'J', 'K', 'L', 'M', 'N', 'O', 'Ö', 'P', 'Q', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'W', 'X', 'Y', 'Z');

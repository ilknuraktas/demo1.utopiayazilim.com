<?
include('include/all.php');
ignore_user_abort(true);
include('include/xmlExport.php');
try{
	@ini_set('memory_limit', '94096M');
}
catch(Exception $ex)
{
}

switch($_GET['c'])
{
	case 'ptt':
		redirect('pttavm.php');
	break;
	case 'hb-excel':
		redirect('hb-excel.php');
	break;	
	case 'trendyol-excel':
	redirect('trendyol-excel.php');
break;
}

if (strtolower($_GET['c']) != 'excel') header ("content-type: text/xml");
else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=export.csv");
    header("Content-Type: text/csv");
    header("Content-Transfer-Encoding: binary");
}

if($_GET['username'] && $_GET['password'])
{
	$_SESSION['userID'] = hq("select ID from user where (username = '".$_GET['username']."' OR email = '".$_GET['username']."') AND password = '".$_GET['password']."' ");
	if(!$_SESSION['userID'])
		exit('<hata>Hatali kullanıcı adı veya şifre.</hata>');	
}

if($_GET['custom'])
{
	$siteConfig['fiyatUyelikZorunlu'] = 0;


	$qx = my_mysql_query("select * from xmlout where code like '".addslashes($_GET['custom'])."' order by ID desc limit 0,1");
	$dx = my_mysql_fetch_array($qx);
	if(!my_mysql_num_rows($qx))
		exit();
	$out.=$dx['xmlheader'];	
	
	$order = 'order by catID';
	$start = ($_GET['start']?$_GET['start']:0);
	if($_SESSION['userGroupID'])
	{
		$userID = $_SESSION['userID'];
		$xmlCat = hq("select xmlcat from userGroups where ID='".$_SESSION['userGroupID']."'");
		$xmlMarka = hq("select xmlmarka from userGroups where ID='".$_SESSION['userGroupID']."'");
	}
/*
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int)$_GET['limit'];
	if ($_GET['urunID']) $filter = 'AND urun.ID= ' . (int)$_GET['urunID'];
	if ($_GET['markaID']) $filter = 'AND urun.markaID= ' . (int)$_GET['markaID'];
	if ($_GET['filter']) $filter = 'AND urun.' . $_GET['filter'] . ' = 1';
	*/
	//if ($_GET['order']) $order = 'order by urun.'.$_GET['order'];
	if ($_GET['tID']) $filter = 'AND urun.tedarikciID= ' . (int)$_GET['tID'];
	if ($_GET['catID']) $filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
	if ($_GET['tIDs']) {
		$filter = 'AND (';
		$tIDs = explode(',', $_GET['tIDs']);
		foreach ($tIDs as $tID) {
			$tID = (int)$tID;
			if ($tID)
				$filter .= 'urun.tedarikciID = \'' . $tID . '\' OR ';
		}
		$filter .= ' 1 = 2) ';
	}

	$q = my_mysql_query("select urun.*,kategori.ckar,kategori.gg_Kod ,kategori.namePath from urun,kategori where urun.catID=kategori.ID AND catID!=0 AND markaID!=0 AND bakiyeOdeme=0 AND urun.active=1 AND urun.noxml != 1 AND kategori.noxml != 1 AND urun.stok > 0 AND urun.sigorta = 0 AND kategori.active = 1  $filter $order $limit");	
	while($d = my_mysql_fetch_array($q))
	{
		$safeArray = array('name','detay','onDetay');
		foreach($safeArray as $safe)
		{
			$d[$safe] = '<![CDATA['.$d[$safe].']]>';
		}
		
		$d['marka'] = '<![CDATA['.hq("select name from marka where ID='".$d['markaID']."'").']]>';
		
		
		for($i=1;$i<=10;$i++)
		{
			$check = 'resim'.($i>1?$i:'');
			$d[$check] = 'http'.(siteConfig('httpsAktif')?'s':'').'://'.$_SERVER['SERVER_NAME'].$siteDizini.'images/urunler/'.$d[$check];
		}
		
		$stoklar = '';
		if($d['varID1'] || $d['varID2'])
		{
			$stoklar = '<var_stoklar>';
			$var1 = trim(cleanstr(hq("select ozellik from var where ID='".$d['varID1']."'")));
			$var2 = trim(cleanstr(hq("select ozellik from var where ID='".$d['varID2']."'")));
			
			$vq = my_mysql_query("select kod,stok,var1,var2 from urunvarstok where urunID='".$d['ID']."'");
			while($vd = my_mysql_fetch_array($vq))
			{
				$stoklar.= '<stok>';
				$price1 =  hq("select fark from urunvars where urunID='".$d['ID']."' AND varID='".$d['varID1']."' AND var like '".$vd['var1']."'");						
				$stoklar.= '<stok1 isim="'.$var1.'" varyasyon="'.trim($vd['var1']).'" fiyat_farki="'.$price1.'" />';
				if($var2)
				{
					$price2 =  hq("select fark from urunvars where urunID='".$d['ID']."' AND varID='".$d['varID2']."' AND var like '".$vd['var2']."'");
					$stoklar.= '<stok2 isim="'.$var2.'" varyasyon="'.trim($vd['var2']).'" fiyat_farki="'.$price2.'" />';
				}
				$stoklar.= '<stok_adet>'.$vd['stok'].'</stok_adet>';	
				$stoklar.= '<stok_kod>'.$vd['kod'].'</stok_kod>';	
				$stoklar.= '</stok>';						
			}
			$stoklar.='</var_stoklar>';
		}
		
		$xml = str_replace('{%STOKLAR%}',$stoklar,$dx['xml']);
		$xml = str_replace('{%KATEGORI_ADI%}','<![CDATA['.hq("select name from kategori where ID='".$d['catID']."'").']]>',$xml);
		$xml = str_replace('{%MARKA_ADI%}','<![CDATA['.hq("select name from marka where ID='".$d['markaID']."'").']]>',$xml);
				
		$out.=urunTemplateReplace($d,$xml);	
	}
	$out.=$dx['xmlfooter'];
	exit($out);
}

function toIdeaPrice($fiyat)
{
	$fiyat = my_money_format('',$fiyat);
	$fiyat = str_replace('.','_',$fiyat);
	$fiyat = str_replace(',','.',$fiyat);	
	$fiyat = str_replace('_',',',$fiyat);	
	return $fiyat;
}

$func = 'build'.ucfirst($_GET['c']).'XMLFile';
$funcauto = 'buildauto'.ucfirst($_GET['c']).'XMLFile';
$view = hq("select status from xmlexport where code like '".$_GET['c']."'");

if(!$view)
{
	$userID = $_SESSION['userID'];
	$view = hq("select xmlactive from user,userGroups,userGroupMembers where user.ID = userGroupMembers.userID AND user.ID = '".$userID."' AND userGroups.ID = userGroupMembers.userGroupID AND (userGroups.xmlIP = '' OR userGroups.xmlIP like '%".$_SERVER['REMOTE_ADDR']."%') order by xmlactive asc limit 0,1");	
}
if ($view)
{
	if(!$_GET['autolang'])
	{
		$_SESSION['lang'] = $_SESSION['cache_setfiyat'] = $_SESSION['cache_setfiyatbirim'] = $langPrefix = null;
	}
	
	$code = substr(md5($_GET['c'].$serialx),0,10); // Eski
	$code2 = substr(md5($_GET['c'].checkx()),0,10);

	if($_GET['xmlc'] == $code || $_GET['xmlc'] == $code2 || $_GET['c'] == 'google' || $_GET['c'] == 'googleimage') 
	{
		checkForXmlCache();
		exit($func());	
	}
	else
		exit('<?xml version="1.0" encoding="utf-8"?><errorGeçersiz XML kodu.</error>');
}
else
	exit('<?xml version="1.0" encoding="utf-8"?><error>İlgili servis pasif durumda.</error>');
//  if(function_exists($funcauto) && ($_SESSION['admin_isAdmin'] || $_SERVER['REMOTE_ADDR'] == '88.248.143.155')) exit($funcauto());
?>
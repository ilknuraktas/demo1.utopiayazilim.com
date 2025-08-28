<?php include('include/all.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="KEYWORDS" CONTENT="<?=$siteConfig['metaKeywords'];?>" />
<? echo '<base href="http'.(siteConfig('httpsAktif')?'s':'').'://'.$_SERVER['HTTP_HOST'].$siteDizini.'">'; ?>

<title><?=$siteConfig['title'];?></title>
<link rel="stylesheet" href="assets/css/popup.compare.css" />
<link rel="stylesheet" href="templates/<?php echo $siteConfig['templateName'] ?>/style.css" />
</head> 
<body onload="<?=$siteConfig['onLoad'];?>">
<table class='compareTable' cellspacing="1" cellpadding="1">
<?php

##############################################
# Veritabanindan cekilecek fieldlar asagidaki arraya yazilacak. Field nameleri lang define dosyasindan _lang_compare prefix'i ile cekiliyor. 
$infoArray = array(_lang_compareName=>'name',_lang_compareOnDetay=>'onDetay',_lang_compareFiyat=>'fiyat',_lang_compareKDV=>'kdv',_lang_form_kategori=>'catID',_lang_compareMarka=>'markaID',_lang_compareGaranti=>'garanti',_lang_compareTarih=>'tarih',_lang_compareStok=>'stok',_lang_comparePuan=>'puan',lc('_lang_filtreOzellikleri','Filtre Özellikleri')=>'_filtre',_lang_compareOzellikler=>'detay');
##############################################
//foreach ($infoArray as $k=>$v) $infoArray[_lang_compare_.$v]=$v; 
unset($_GET['pIDs']);
if($_GET['pIDs'])
{
	unset($_SESSION['urunKarsilastirmaList_'.$i]);
	$pIDs = explode(',',addslashes($_GET['pIDs']));
}

for ($i=0;$i<=10;$i++) {
	$check = (int)($pIDs[$i]?$pIDs[$i]:$_SESSION['urunKarsilastirmaList_'.$i]);
	if ($check) 
		$urunWhere.="urun.ID = '".$check."' OR ";
}
$urunWhere.=" 1=2";
$query="select urun.* from urun,kategori where kategori.ID=urun.catID AND idPath AND ($urunWhere)";
$q = my_mysql_query($query);

if(!my_mysql_num_rows($q)) exit("<script>window.close();</script>");
$i=0;
while ($d = my_mysql_fetch_array($q)) {
	foreach ($d as $k=>$v) 
	{	
		$urun[$i][$k]=$v;	
	}
	$fArray = explode('],[',$d['filitre']);
	foreach($fArray as $f)
	{
		list($k,$v) = explode('::',$f);
		if (!$k) continue;
		$k = str_replace('[','',$k);
		$v = str_replace('],','',$v);
		$v = str_replace(']','',$v);
		
		$k = hq("select baslik from filitre where ID='".$k."'");
		$result[$i][$k].=$v.', ';
		if(!$result[0][$k])
			$result[0][$k] = '-';
	}
	$result[$i][$k] = substr($result[$i][$k],0,-2);	
	$i++;
}

echo "<tr>";
for ($j=-1;$j<my_mysql_num_rows($q);$j++) {
	if($j == -1)
		echo '<td align="center"></td>';
	else
		echo '<td align="center"><a href="'.urunLink((int)$urun[$j]['ID']).'"><img src="include/resize.php?path=images/urunler/'.$urun[$j]['resim'].'&width=100&height=100"></a><br></td>';
}
echo "</tr>";
foreach ($infoArray as $k=>$v) {
	if (!is_numeric($k)) {
		if($k == '_filtre')
		{
			echo filtreCompareList($result,$q);
			continue;	
		}
		echo "<tr>";
		for ($j=-1;$j<my_mysql_num_rows($q);$j++) {
			switch ($v) {
				case 'indirim':
					$urun[$j][$v] = (($urun[$j][$v] || ($urun[$j]['piyasafiyat'] > $urun[$j]['fiyat']))?_lang_evet:_lang_hayir);		
					break;
				case 'name':
					$urun[$j][$v] = '<strong style="color:#0bc15c ">'.$urun[$j][$v].'</strong>';
				break;
				case 'catID':
					$urun[$j][$v] = dbInfo('kategori','namePath',$urun[$j][$v]);
				break;
				case 'markaID':
					$urun[$j][$v] = dbInfo('marka','name',$urun[$j][$v]);
				break;
				case 'kdv':
					$urun[$j][$v] = str_replace('0.','%',$urun[$j][$v]);
				break;
				case 'fiyat':
					if($_SESSION['userID'] || !siteConfig('fiyatUyelikZorunlu'))
						$urun[$j][$v] = my_money_format('%i',kdvHaricFiyat($urun[$j])).' '.$urun[$j]['fiyatBirim'].' + KDV ('.my_money_format('%i',YTLfiyat(($urun[$j][$v]),$urun[$j]['fiyatBirim'])).' TL)';
					else
						$urun[$j][$v] = strip_tags(($urun[$j]['sigorta']?str_replace('{%DB_ID%}',$d['ID'],_lang_sorunuz):_lang_fiyatIcinUyeGirisiYapin));
				break;
				case 'secenek':
					$out='<table cellpadding="0" cellspacing="0">';
					$d=$urun[$j];
					for ($i=1;$i<=5;$i++) {
						if ($d['ozellik'.$i]) $out.='<tr><td>'.$d['ozellik'.$i].'<br>'.showItemOptions('urun',$d['ID'],'ozellik'.$i.'detay').'</td></tr>';
					}
					$urun[$j][$v] = $out.'</table>';
				break;
				case 'tarih':
					$urun[$j][$v] = mysqlTarih($urun[$j][$v]);
				break;
				case 'stok':
					$urun[$j][$v] = ($urun[$j][$v] ? _lang_compareStokVar:_lang_compareStokYok);
				break;
				case 'puan':
					if ($siteConfig['urunOnay']) $qo = 'AND onay=1';
					$toplamPuan = hq("select sum(puan) as toplampuan from urunYorum where urunID='".$urun[$j]['ID']."' $qo");
					$qPuan = my_mysql_query("select * from urunYorum where urunID='".$urun[$j]['ID']."' $qo");
					@$ortalamaPuan = (int)($toplamPuan / my_mysql_num_rows($qPuan));
					$urun[$j][$v] = '<img src="images/stars_'.$ortalamaPuan.'.png">';
				break;
			}	
		
			if($j == -1)
				echo '<td valign="top"><div class="label">'.$k.'</div></td>'."\n";
			else
				echo '<td valign="top"<div 	class="">'.$urun[$j][$v].'</div></td>'."\n";
		}
		echo "</tr>";
	}
}
if($_GET['act'])
{
	echo "<tr>";
	for ($j=-1;$j<my_mysql_num_rows($q);$j++) {
		if($j == -1)
			echo '<td align="center"></td>';
		else
			echo '<td align="center"><input type="button" value="Satın Al" onclick="window.location.href = \''.urunLink((int)$urun[$j]['ID']).'\'"><br></td>';
	}
	echo "</tr>";
}

echo '</table>';
if(!$_GET['act'])
	echo "<br><input type='button' class='btn btn-secondary' value='"._lang_listeyiTemizle."' onclick=\"window.location.href = 'compare.php?KarsilastirmaListeTemizle=true'\">";
//else
//	echo "<br><input type='button' value='"._lang_listeyiTemizle."' onclick=\"window.location.href = 'page.php?act=karsilastir&KarsilastirmaListeTemizle=true'; return false;\">";

function filtreCompareList($result,$q)
{
	if(is_array($result))
	{
		foreach ($result[0] as $k=>$v) {
			$out.= "<tr>";
			for ($j=-1;$j<my_mysql_num_rows($q);$j++) 
			{				
				if($j == -1)
					$out.= '<td valign="top"><div class="label">'.$k.'</div></td>'."\n";	
				else
					$out.= '<td valign="top"><div class="data">'.$result[$j][$k].'</div></td>'."\n";	
			}	
			$out.= "</tr>";	
		}
	}
	return $out;	
}
?>
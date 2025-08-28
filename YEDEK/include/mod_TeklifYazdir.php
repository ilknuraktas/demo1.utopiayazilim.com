<?php 
include('all.php');
$kasaKategoriCode = 14;
$LCDKategoriCode = 23;
$KlavyeKategoriCode = 10;
$MouseKategoriCode = 23;

$q = my_mysql_query("select * from teklif where randStr = '".$_GET['tekNo']."'");
$d = my_mysql_fetch_array($q);
?>
<style>
	body { font-family:Tahoma; font-size:12px; line-height:18px; }
	h4,h3 { color:#CCCCCC; font-weight:bolder; font-size:20px; }
	h3 { font-size:14px; }
	hr { height:1px; background-color:#ccc; }
	a { color:black; }
</style>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<link href="../templates/system/admin/template/css/shopphp.css" rel="stylesheet" type="text/css" />
<title>Teklif Yazdır</title>
</head>
<body>
<center>
<div style="padding:20px; width:800px; margin-left:auto; margin-right:auto; text-align:left;">
	<h4><?php echo $_GET['tekNo']?> No'lu Teklif Bilgileri</h4>
	<hr />
	<div style="float:left">         
            
		<strong>Firma Adı :</strong> <?=hq("select concat(name,' ',lastname) x from user where ID='".$d['userID']."'")?><br />
		<strong>Teklif Tarihi :</strong> <?=mysqlTarih($d['tarihStart'])?><br />
		<strong>Teklif Konusu :</strong> <?=$d['konu']?><br />
        <strong>Teklifi Alan :</strong> <?=$d['alan']?><br />
        <strong>İlgili Kişi :</strong> <?=$d['ilgiliKisi']?><br />
        <strong>Teklif Notu :</strong> <?=$d['not']?><br />
	</div>
	<div style="clear:both">&nbsp;</div>
    <?
		$query = "select urun.* from teklif,kategori,urun where randStr like '".$_GET['tekNo']."' AND teklif.urunID = urun.ID AND urun.catID=kategori.ID AND teklif.data1=1 group by urun.ID";
		//echo $query;
		$q= my_mysql_query($query);
		while($d = my_mysql_fetch_array($q))
		{
			$out.="<div style='float:left; margin-right:10px;'><img src='http://".$_SERVER['SERVER_NAME'].$siteDizini."/include/resize.php?path=images/urunler/".$d['resim']."&width=170' /></div>";
		}
	?>
    
    
	<div style="float:left; width:770px; border:3px solid #ccc; padding:20px; ">
		<h3>Teklif Bilgileri</h3>
		<?
			$out.='<table class="sepet teklif" cellpadding=0 cellspacing=2><tr>';
			$out.='<th>ID</th>';
			$out.='<th>Ürün Adı</th>';
			$out.='<th>Miktar</th>';
			$out.='<th>Fiyat</th>';
			$out.='<th>Birim</th>';
			$out.='<th>Toplam</th>';
			$out.='<th>KDV</th>';
			$out.='</tr>';
	
			$query = "select * from teklif where randStr like '".$_GET['tekNo']."'";
			$q= my_mysql_query($query);
			$i=1;
			while ($d = my_mysql_fetch_array($q)) {
				$link = ('page.php?act='.$_GET['act'].'&sn='.$d['randStr'].'&rID='.$d['ID']);
				
				$class=(!($i%2)?'tr_normal':'tr_alternate');
				$out.='<tr class="'.$class.' teklifSatir">';
				$out.='<td>'.$d['urunID'].'</td>';
				$out.='<td>'.$d['urunName'].'</td>';
				$out.='<td>'.$d['ID'].'</td>';
				$out.='<td>'.str_replace(',','',my_money_format('%i',$d['fiyat'])).'</td>';
				$out.='<td>TL</td>';
				$out.='<td class="toplam">'.my_money_format('%i',($d['fiyat'] * $d['adet'])).'</td>';
				$out.='<td class="kdv">%'.(hq("select kdv from urun where ID='".$d['urunID']."'") * 100).'</td>';
				$out.='<tr>'."\n";
				$kdvDahil+=($d['fiyat'] * $d['adet']);
				$kdvHaric+=(($d['fiyat'] * $d['adet']) / ((float)hq("select kdv from urun where ID='".$d['urunID']."'") + 1));
				$i++;		
			}
			$out.='</table>';
			$out.='<div class="sepetToplam">';
			$out.='<table>';
			$out.='<tr><td class="td1">Sistem Toplami (KDV Dahil)</td><td class="td2">:</td><td class="td3"><span ID="kdvdahil">'.my_money_format('%i',$kdvDahil).'</span> TL</td></tr>';
			$out.='<tr><td class="td1">Sistem Toplami (KDV Hariç)</td><td class="td2">:</td><td class="td3"><span ID="kdvharic">'.my_money_format('%i',$kdvHaric).'</span> TL</td></tr>';
			$out.='<tr><td class="td1">KDV</td><td class="td2">:</td><td class="td3"><span ID="toplamkdv">'.my_money_format('%i',($kdvDahil - $kdvHaric)).'</span> TL</td></tr>';
			$out.='<tr><td colspan="3" class="gri_menu_sep_td"><div class="gri_menu_sep_div"></div></td></tr>';	
			$out.='<tr><td class="toplam">TOPLAM (TL)</td><td class="td2">:</td><td class="toplam"><span ID="toplamytl">'.my_money_format('%i',$kdvDahil).'</span> TL</td></tr>';
			$out.='<tr><td class="toplam">TOPLAM (Dolar)</td><td class="td2">:</td><td class="toplam"><span ID="dolar">'.my_money_format('%i',($kdvDahil / hq("select value from fiyatbirim where code like 'USD'"))).'</span> USD</td></tr>';
			$out.='<tr><td class="toplam">TOPLAM (Euro)</td><td class="td2">:</td><td class="toplam"><span ID="euro">'.my_money_format('%i',($kdvDahil / hq("select value from fiyatbirim where code like 'EUR'"))).'</span> EUR</td></tr>';
			$out.='</table>';
			echo $out;
		?>
	</div>
</div>
</center>
<script>
window.print();
</script>
</body>
</html>
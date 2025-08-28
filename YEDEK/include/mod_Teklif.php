<?php
function showOffer($info = false) {
	global $siteConfig,$siteDizini;	
	if ($_GET['sil'])
	{
		 my_mysql_query("delete from teklif where userID='".$_SESSION['userID']."' AND randStr = '".$_GET['sn']."'");
		 redirect('page.php?act=tekliflerim');
	}
	switch($_POST['teklifDo'])
	{
		case 'ekle':
			if (!hq("select ID from urun where ID='".$_POST['teklifData']."'"))
			{
				$msg = '<div class="error" style="padding:2px;">Girdiğiniz ürün numarasına ait ürün bulunamadı.</div>';
			}			
			else if (hq("select ID from teklif where urunID='".$_POST['teklifData']."' AND randStr like '".$_GET['sn']."'"))
			{
				$msg = '<div class="error" style="padding:2px;">Eklediğiniz ürün listenizde kayıtlı olduğundan eklenmedi.</div>';
			}
			else
			{
				$q = my_mysql_query("select * from urun where ID='".$_POST['teklifData']."'");
				$d = my_mysql_fetch_array($q);;
				$fiyat = fixFiyat($d['fiyat'],0,$d['ID']);
				$query = "insert into teklif(`ID`,`userID`,`konu`,`alan`,`ilgiliKisi`,`not`,`urunID`,`urunName`,`adet`,`fiyat`,`randStr`) values (null,'".$_SESSION['userID']."','".$_POST['konu']."','".$_POST['alan']."','".$_POST['ilgiliKisi']."','".$_POST['not']."','".$_POST['teklifData']."','".$d['name']."',1,'$fiyat','".$_GET['sn']."');";
				my_mysql_query($query);
			}
		break;
		case 'eposta':
		case 'yazdir';
		case 'kaydet':
			my_mysql_query("update teklif set konu = '".$_POST['konu']."',alan = '".$_POST['alan']."',ilgiliKisi = '".$_POST['ilgiliKisi']."',`not` = '".$_POST['not']."' where randStr = '".$_GET['sn']."'");
			$q = my_mysql_query("select * from teklif where userID='".$_SESSION['userID']."' AND randStr like '".$_GET['sn']."'");
			while($d = my_mysql_fetch_array($q))
			{
				my_mysql_query("update teklif set data1='".$_POST['resim_'.$d['ID']]."', urunName='".$_POST['urunName_'.$d['ID']]."', adet='".$_POST['adet_'.$d['ID']]."', fiyat='".$_POST['fiyat_'.$d['ID']]."' where ID='".$d['ID']."'");	
			}
			if ($_POST['teklifDo'] == 'kaydet') 
				return 'Teklif bilgileriniz güncellendi.';
			if ($_POST['teklifDo'] == 'yazdir')
				$out.="<script>window.open('include/mod_TeklifYazdir.php?tekNo=".$_GET['sn']."','teklif','width=900,height=600,scrollbars=1');</script>";	
			if ($_POST['teklifDo'] == 'eposta')
			{
				$body = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$siteDizini.'/include/mod_TeklifYazdir.php?tekNo='.$_GET['sn']);
				$body = str_replace('width:800px;','width:500px;',$body);
				$body = str_replace('width:770px;','width:470px;',$body);
				$header = getHeaders(siteConfig('adminMail'));
				
				$mail = new spEmail();
				$mail->headers = $header;
				$mail->to = $_POST['teklifData'];
				$mail->subject = hq("select concat(name,' ',lastname) x from user where ID='".$_SESSION['userID']."'")." Teklif Bilgileri";
				$mail->body = $body;			
				$mail->send();	
				$msg = '<div style="padding:2px;"><strong>E-Posta gönderildi.</strong></div>';		
				$msg.='Mail Basla';
				$msg.=$body;
				$msg.='Mail Bitis';
						
			}
		break;	
	}
	
	$out.="<script>
			var dolar = '".hq("select value from fiyatbirim where code like 'USD'")."';
			var euro = '".hq("select value from fiyatbirim where code like 'EUR'")."';
	   </script>";
	if ($_GET['rID']) my_mysql_query("delete from teklif where userID='".$_SESSION['userID']."' AND ID='".$_GET['rID']."'");	   
	$q = my_mysql_query("select * from teklif where userID='".$_SESSION['userID']."' AND randStr like '".$_GET['sn']."' limit 0,1");
	$d = my_mysql_fetch_array($q);
	
		$out.=$msg.'<table class="teklifForm generatedForm">
			<form id="teklifForm" action=""  method="post">
			<input type="hidden" name="teklifSubmit" value="1">
			<input type="hidden" id="teklifDo" name="teklifDo" value="">
			<input type="hidden" id="teklifData" name="teklifData" value="">
			<tr><td>Firma Adı</td><td> : </td><td>'.hq("select concat(name,' ',lastname) x from user where ID='".$_SESSION['userID']."'").'</td></tr>
			<tr><td>Teklif Tarihi</td><td> : </td><td>'.mysqlTarih($d['tarihStart']).'</td></tr>
			<tr><td>Teklif Konusu</td><td> : </td><td><input type="text" class="gf_input" name="konu" value="'.$d['konu'].'" size="75"></td></tr>
			<tr><td>Teklifi Alan</td><td> : </td><td><input type="text" class="gf_input" name="alan" value="'.$d['alan'].'" size="75"></td></tr>
			<tr><td>İlgili Kişi</td><td> : </td><td><input type="text" class="gf_input" name="ilgiliKisi" value="'.$d['ilgiliKisi'].'" size="75"></td></tr>
			<tr><td valign="top">Mesaj</td><td valign="top"> : </td><td valign="top"><textarea class="gf_textarea" name="not" size="75">'.$d['not'].'</textarea></td></tr>
			</table><div style="clear:both"></div>
			';
	
	$out.='<table class="sepet teklif" cellpadding=0 cellspacing=2><tr>';
	$out.='<th>ID</th>';
	$out.='<th>Ürün Adı</th>';
	$out.='<th>Miktar</th>';
	$out.='<th>Fiyat</th>';
	$out.='<th>Birim</th>';
	$out.='<th>Toplam</th>';
	$out.='<th>KDV</th>';
	$out.='<th>Resim Göster</th>';
	$out.='<th></th>';
	$out.='</tr>';
	$query = "select * from teklif where userID='".$_SESSION['userID']."' AND randStr like '".$_GET['sn']."'";
	$q= my_mysql_query($query);
	$i=1;
	while ($d = my_mysql_fetch_array($q)) {
		$link = ('page.php?act='.$_GET['act'].'&sn='.$d['randStr'].'&rID='.$d['ID']);
		
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$out.='<tr class="'.$class.' teklifSatir">';
		$out.='<td class="teklifUrunID">'.$d['urunID'].'</td>';
		$out.='<td><input class="urunName" name="urunName_'.$d['ID'].'" value="'.$d['urunName'].'"></td>';
		$out.='<td><input class="adet" name="adet_'.$d['ID'].'" value="'.$d['adet'].'" size="2"></td>';
		$out.='<td><input class="fiyat" name="fiyat_'.$d['ID'].'" value="'.str_replace(',','',my_money_format('%i',$d['fiyat'])).'" size="5"></td>';
		$out.='<td>TL</td>';
		$out.='<td class="toplam">'.my_money_format('%i',($d['fiyat'] * $d['adet'])).'</td>';
		$out.='<td class="kdv">%'.(hq("select kdv from urun where ID='".$d['urunID']."'") * 100).'</td>';
		$out.='<td><input type="checkbox" name="resim_'.$d['ID'].'" value="1" '.($d['data1']?'checked="checked"':'').'></td>';
		$out.='<td style="cursor:pointer" onclick="if (confirm(\'İlgili ürünü kaldırmak istediğinizden emin misiniz?\')) window.location.href =\''.$link.'\'">'.textBox('#90be00','white',10,'x').'</td>';
		$out.='<tr>'."\n";
		$i++;		
	}
	$out.='</table>';
	$out.='<div class="sepetToplam">';
	$out.='<table>';
	$out.='<tr><td class="td1">Sistem Toplami (KDV Dahil)</td><td class="td2">:</td><td class="td3"><span ID="kdvdahil">0</span> TL</td></tr>';
	$out.='<tr><td class="td1">Sistem Toplami (KDV Hariç)</td><td class="td2">:</td><td class="td3"><span ID="kdvharic">0</span> TL</td></tr>';
	$out.='<tr><td class="td1">KDV</td><td class="td2">:</td><td class="td3"><span ID="toplamkdv">0</span> TL</td></tr>';
	$out.='<tr><td colspan="3" class="gri_menu_sep_td"><div class="gri_menu_sep_div"></div></td></tr>';	
	$out.='<tr><td class="toplam">TOPLAM (TL)</td><td class="td2">:</td><td class="toplam"><span ID="toplamytl">0</span> TL</td></tr>';
	$out.='<tr><td class="toplam">TOPLAM (Dolar)</td><td class="td2">:</td><td class="toplam"><span ID="dolar">0</span> USD</td></tr>';
	$out.='<tr><td class="toplam">TOPLAM (Euro)</td><td class="td2">:</td><td class="toplam"><span ID="euro">0</span> EUR</td></tr>';
	$out.='</table>';
	$link = ('page.php?act='.$_GET['act'].'&sn='.$_GET['sn']);
	
	$out.='</div><div style="clear:both">&nbsp;</div>
	<table style="float:left"><tr><td>Teklif fiyatını</td><td>%<input id="oran" size="2"></td><td><input type="button" value="yükselt" id="arttir"></td><td><input type="button" value="indir" id="azalt"></td></tr></table>
	<div class="teklifInfoTable"><table style="float:right"><tr><td><input type="button" value="Ürün Ekle" onclick="var urunID = prompt(\'Eklemek istediğiniz Ürün ID\',\'\'); if(!urunID) return; $(\'#teklifDo\').val(\'ekle\'); $(\'#teklifData\').val(urunID); $(\'#teklifForm\').submit();"></td><td><input type="button" value="E-Posta" onclick="var email = prompt(\'Göndermek istediğiniz e-posta adresi\',\'\'); if(!email) return; $(\'#teklifDo\').val(\'eposta\'); $(\'#teklifData\').val(email); $(\'#teklifForm\').submit();"></td><td><input type="button" value="Yazdır" onclick="$(\'#teklifDo\').val(\'yazdir\'); $(\'#teklifForm\').submit();"></td><td><input type="button" value="Sepete Ekle" onclick="teklifSepetEkle();"></td><td><input type="button" value="Kaydet" onclick="$(\'#teklifDo\').val(\'kaydet\'); $(\'#teklifForm\').submit();"></td></tr></table></div>
	<div style="clear:both"></div>
	</form>
	<script>teklifFiyatGuncelle();</script>';
	return $out;
}

function listOffers() {

	global $siteConfig;	
	$out ='<table class="sepet" cellpadding=0 cellspacing=2><tr>';
	$out.='<th>ID</th>';
	$out.='<th>Teklif No</th>';
	$out.='<th>Tutar</th>';
	$out.='<th>Teklif Tarihi</th>';
	// $out.='<th>Bitiş Tarihi</th>';
	$out.='<th></th>';
	$out.='</tr>';
	
	$query = "select * from teklif where userID='".$_SESSION['userID']."' group by randStr";
	$q= my_mysql_query($query);
	$i=1;
	while ($d = my_mysql_fetch_array($q)) {
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$link = (siteConfig('seoURL') ? $_GET['act'].'_sp__sn-'.$d['randStr'].($_GET['status'] ? ',status-'.$_GET['status']:'').'.html':'page.php?act='.$_GET['act'].'&sn='.$d['randStr'].($_GET['status'] ? '&status='.$_GET['status']:''));
		$linkSil = ('page.php?act='.$_GET['act'].'&sil=1&sn='.$d['randStr'].($_GET['status'] ? '&status='.$_GET['status']:''));
		$siparisTekrarla = (siteConfig('seoURL') ?'reOrder_sp__sn-'.$d['randStr'].($_GET['status'] ? ',status-'.$_GET['status']:'').'.html':'page.php?act=reOrder&sn='.$d['randStr'].($_GET['status'] ? '&status='.$_GET['status']:''));
		$out.='<tr class="'.$class.'">';
		$out.='<td>'.$i.'</td>';
		$out.='<td><a href="page.php?act=tekliflerim&sn='.$d['randStr'].'">'.$d['randStr'].'</a></td>';
		$out.='<td>'.teklifToplam($d['randStr']).' TL</td>';
		$out.='<td>'.mysqlTarih($d['tarihStart']).'</td>';
		//$out.='<td>'.mysqlTarih($d['tarihFinish']).'</td>';
		$out.='<td style="cursor:pointer" onclick="window.location=\''.$link.'\'">'.textBox('#90be00','white',10,'detay').'</td>';
		$out.='<td style="cursor:pointer" onclick="if (confirm(\'Emin misiniz?\')) window.location.href =\''.$linkSil.'\'">'.textBox('#90be00','white',10,'sil').'</td>';
		$out.='<tr>'."\n";
		$i++;		
	}
	$out.='</table>';
	return $out;
}

function teklifToplam($randStr)
{
	$q = my_mysql_query("select * from teklif where randStr = '$randStr'");
	while($d = my_mysql_fetch_array($q))
	{
		$toplam += ($d['adet'] * $d['fiyat']);	
	}
	return my_money_format('',$toplam);
}
?>
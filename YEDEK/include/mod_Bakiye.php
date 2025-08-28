<?php
function bakiyeTakipGiris() {
	global $siteConfig;	
	$out ='<table class="sepet" cellpadding=0 cellspacing=2><tr>';
	$out.='<th>'._lang_siparis_no.'</th>';
	$out.='<th>'._lang_siparis_tutar.'</th>';
	$out.='<th>'._lang_siparis_tarih.'</th>';
	$out.='</tr>';

	$query = "select * from urun,sepet where sepet.urunID=urun.ID AND sepet.durum > 1 AND urun.userID='".$_SESSION['userID']."' AND urun.bakiyeOdeme=1";
	$q= my_mysql_query($query);
	$i=1;
	$toplam = 0;
	while ($d = my_mysql_fetch_array($q)) {
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$out.='<tr class="'.$class.'">';
		$out.='<td>'.$i.'</td>';
		$out.='<td>'.my_money_format('%i',basketInfo('ToplamKargoDahil',$d['randStr'])).' '.fiyatBirim('TL').'</td>';
		$out.='<td>'.mysqlTarih($d['tarih']).'</td>';
		$out.='<tr>'."\n";
		$i++;		
		$toplam+=basketInfo('ToplamKargoDahil',$d['randStr']);
	}

	$class=(!($i%2)?'tr_normal':'tr_alternate');
	$out.='<tr class="'.$class.'">';
	$out.='<td><strong>'.ucfirst(_lang_sepet_toplam).'</strong></td>';
	$out.='<td>'.my_money_format('%i',$toplam).' '.fiyatBirim('TL').'</td>';
	$out.='<td></td>';
	$out.='<tr>'."\n";		
	$out.='</table><div style="clear:both">&nbsp;</div>';
	return $out;
}


function bakiyeTakipCikis()
{
	global $siteConfig;	
	$out.='<table class="sepet" cellpadding=0 cellspacing=2><tr>';
	$out.='<th>'._lang_siparis_no.'</th>';
	$out.='<th>'._lang_siparis_tutar.'</th>';
	$out.='<th>'._lang_siparis_tarih.'</th>';
	$out.='<th>'._lang_siparis_detaylar.'</th>';
	$out.='</tr>';

	$query = "select * from siparis where bakiyeileOdeme = 1 AND userID='".$_SESSION['userID']."' AND durum > 1";
	$q= my_mysql_query($query);
	$i=1;
	$toplam = 0;
	while ($d = my_mysql_fetch_array($q)) {
		$link = (siteConfig('seoURL') ? $_GET['act'].'_sp__sn-'.$d['randStr'].($_GET['status'] ? ',status-'.$_GET['status']:'').'.html':'page.php?act='.$_GET['act'].'&sn='.$d['randStr'].($_GET['status'] ? '&status='.$_GET['status']:''));
		
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$link = (siteConfig('seoURL') ? $_GET['act'].'_sp__sn-'.$d['randStr'].($_GET['status'] ? ',status-'.$_GET['status']:'').'.html':'page.php?act='.$_GET['act'].'&sn='.$d['randStr'].($_GET['status'] ? '&status='.$_GET['status']:''));
		$siparisTekrarla = (siteConfig('seoURL') ?'reOrder_sp__sn-'.$d['randStr'].($_GET['status'] ? ',status-'.$_GET['status']:'').'.html':'page.php?act=reOrder&sn='.$d['randStr'].($_GET['status'] ? '&status='.$_GET['status']:''));
		$out.='<tr class="'.$class.'">';
		$out.='<td>'.$i.'</td>';
		$out.='<td>'.my_money_format('%i',basketInfo('ToplamKargoDahil',$d['randStr'])).' '.fiyatBirim('TL').'</td>';
		$out.='<td>'.mysqlTarih($d['tarih']).'</td>';
		$out.='<td style="cursor:pointer" onclick="window.location=\''.$link.'\'">'.textBox('#90be00','white',10,'&raquo;').'</td>';
		$out.='<tr>'."\n";
		$i++;
		$toplam+=basketInfo('ToplamKargoDahil',$d['randStr']);		
	}
	$class=(!($i%2)?'tr_normal':'tr_alternate');
	$out.='<tr class="'.$class.'">';
	$out.='<td><strong>'.ucfirst(_lang_sepet_toplam).'</strong></td>';
	$out.='<td>'.my_money_format('%i',$toplam).' '.fiyatBirim('TL').'</td>';
	$out.='<td></td>';
	$out.='<td></td>';
	$out.='<tr>'."\n";
	$out.='</table>';
	return $out;
}

function bakiyeAktarForm() {
	$form[] = array('Bakiye Aktarılacak e-posta',"email","EMAIL",1,'',1,0);
	$form[] = array('Tutar',"tutar","TEXTBOX",1,'',1,0);
	$out = generateForm($form,'','',$hiddenInfo);	
	return $out;
}

function mybakiyeAktar()
{
	if ($_POST['data_tutar'])
	{
		$sUserID = hq("select ID from user where email like '".$_POST['data_email']."' OR username like '".$_POST['data_email']."'");
		if(!$sUserID)
			return '<span class="errror">HATA : Bakiye gönderilecek kullanıcı, veri tabanında bulunamadı.</span>';
		if(!is_numeric($_POST['data_tutar']))
			return '<span class="errror">HATA : Geçersiz giriş.</span>';
		if((float)hq("select bakiye from user where ID= '".$_SESSION['userID']."'") <= (float)$_POST['data_tutar'])
			return '<span class="errror">HATA : Yetersiz bakiye.</span>';
		
		$_POST['data_tutar'] = str_replace(',','',$_POST['data_tutar']);
		my_mysql_query("update user set bakiye = (bakiye - '".(float)$_POST['data_tutar']."' where ID='".$_SESSION['userID']."'");
		my_mysql_query("update user set bakiye = (bakiye + '".(float)$_POST['data_tutar']."' where ID='".$sUserID."'");
		return 'İlgili kullanıcıya '.(float)$_POST['data_tutar'].' '.fiyatBirim('TL').' değerinde bakiye aktarımı yapıldı.';
	}
	else
		$out .= generateTableBox(_lang_mb_bakiyeAktarimFormu,bakiyeAktarForm(),tempConfig('formlar'));
	return $out;
}

function bakiye()
{
	global $showSPError;
	if ($_POST['tutar'])
	{
		$_POST['tutar'] = str_replace(',','',$_POST['tutar']);
		$_SESSION['bakiyeOdeme'] = 1;
		$_GET['hemenal'] = true;
		my_mysql_query("insert into sepet (ID,randStr,adet,urunName,fiyat,ytlFiyat,userID,tarih) values(0,'".$_SESSION['randStr']."',1,'Bakiye Ödeme','".(float)$_POST['tutar']."','".(float)$_POST['tutar']."','".(int)$_SESSION['userID']."',now())");
		$q = my_mysql_query("select * from user where ID ='".$_SESSION['userID']."'");
		$d = my_mysql_fetch_array($q);
		$form = getSiparisForm();
		foreach($form as $t)
		{
			if (is_array($t) && $t[1] != 'satinalKural') $_POST['data_'.$t[1]] = $d[$t[1]];
		}
		$_POST["txtCaptcha"] = $_SESSION["security_code"];
		//siparisAdresSubmit();
		my_mysql_query("update siparis set bakiyeOdeme=1 where randStr = '".$_SESSION['randStr']."'");

        redirect('page.php?act=satinal&op=adres');
	}
	$bakiye = hq("select bakiye from user where ID='".$_SESSION['userID']."'");
	$out.="<fieldset class='sf-form-container'><ul><form method='POST' action='".slink('bakiye')."'>";
	$out.='<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">'._lang_mb_kullanilabilirKrediniz."</label> ".my_money_format('%i',$bakiye).' '.fiyatBirim('TL').'</div></li>';	
	$out.='<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">'._lang_mb_yuklenecekKredi." (".fiyatBirim('TL').")</label><input name='tutar' class='sf-form-input' type='text' value='".($bakiye < 0?($bakiye * -1):'')."'></div></li>";
	$out.='<li><input class="bakiyeGonder sf-button sf-button-large sf-neutral-button" type="submit" value="'._lang_gonder.'"  /></li>';
	$out.="</ul></fieldset></form>";
	return $out;
}
?>
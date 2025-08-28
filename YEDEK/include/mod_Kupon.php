<?php
/* Ayarlar */
$seo->currentTitle = "Kupon Onay Formu";
$firma['Grupfoni'] = 1;
$firma['Grupanya'] = 1;
$firma['Sehirfirsati'] = 1;

$user['Grupfoni']['user'] = '';
$user['Grupfoni']['pass'] = '';
$user['Grupfoni']['appId'] = '';
/* Ayarlar */

foreach($_POST as $k=>$v) $_SESSION['cache'][$k] = $v;
foreach($_SESSION['cache'] as $k=>$v) if (!$_POST[$k]) $_POST[$k] = $v;
$q = my_mysql_query("select * from user where ID ='".$_SESSION['userID']."'");
$data = my_mysql_fetch_array($q);	
foreach ($_POST as $k=>$v) $data[str_replace('data_','',$k)] = $v;
$data['site'] = $_GET['firmaS'];
$out .= generateTableBox('Kupon Onay Formu',($_POST['data_name']?basvuruFormSubmit():basvuruForm()).'<div style="clear:both;">&nbsp;</div>'.dbInfo('pages','body',4),tempConfig('formlar'));
$out.="<script>$('#gf_site').change(function() { window.location.href ='page.php?act=modKupon&firmaS=' + $(this).val(); });</script>";

function basvuruForm() {
	global $data;
	$out = generateForm(getBasvuruForm(),$data,'','');
	if ($_GET['firmaS'])
	{
		$out.="<script>$('#gf_site').parent().parent().css('visibility','hidden').parents().find('table:first').css('margin-top','-30px');</script>";	
	}
	return $out;
}

function basvuruFormSubmit() {
	global $siteConfig,$data,$user;
	
	unset($_SESSION['cache']);
	$_SESSION['MailSent']++;
	telfix('tel');
	switch($_GET['firmaS'])
	{
		case 'Grupfoni':
			list($x,$ID) = explode('ID : ',$_POST['data_urun']);
			$urunID = substr($ID,0,-1);
			$sonuc = file_get_contents('http://www.grupfoni.com/CouponCheck?username='.$user['Grupfoni']['user'].'&password='.$user['Grupfoni']['pass'].'&couponCode='.$_POST['data_kod']);
			$sonucXML = $katalog = new SimpleXMLElement($sonuc); 			
			   

			if (utf8fix($sonucXML->Result)=='OK')
			{
					$kuponOnay = 1;
			}
			else
			{
				$sonuc = utf8fix($sonucXML->errorMessage);
			}
		break;	
		case 'Grupanya':
			list($x,$ID) = explode('ID : ',$_POST['data_urun']);
			$urunID = substr($ID,0,-1);
			$firma['Grupanya']['OzelKod'] = hq("select kuponFirmaData from urun where ID='".$urunID."'");
			$sonuc = file_get_contents('http://onay.grupanya.com/s/KodSorgula.ashx?k='.$_POST['data_kod'].'&ci=so&x='.$firma['Grupanya']['OzelKod']);
			if ($sonuc == 1)
			{
				$dogrula = file_get_contents('http://onay.grupanya.com/s/KodDogrula.ashx?k='.$_POST['data_kod'].'&ci=so&x='.$firma['Grupanya']['OzelKod']);
				$kuponOnay = 1;
			}
			else {
				$hataArray['-1'] = 'Parametre Hatası Yönetici Kodu Hatalı';
				$hataArray['-2'] = 'Kupon Kodunu Hatalı Girdiniz Lütfen Tekrar Deneyiniz. (Kupon kodu size bildirildiği şekilde aradaki tire işaretleriyle girilmelidir) ';
				$hataArray['-3'] = 'Verdiğiniz Kupon Kodu Başka Bir Ürüne Aittir. Lütfen Kontrol Edip Tekrar Giriniz. ';
				$hataArray['-4'] = 'Bu Kupon Kodu Grupanya Tarafından İptal Edilmiştir.';
				$hataArray['-5'] = 'Bu Kod Daha Önceden Kullanılmıştır.';
				$sonuc = $hataArray[substr($sonuc,0,2)];
			}			
		break;
		default:
			if($_GET['firmaS'])
			{
				$kuponOnay = 1;	
			}
		break;
	}
	if ($kuponOnay)
	{
		list($x,$ID) = explode('ID : ',$_POST['data_urun']);
		$ID = substr($ID,0,-1);
		my_mysql_query("update urun set stok = (stok - 1) where ID='$ID'");	
		if ((!$_SESSION['MailSent'] || $_SESSION['MailSent'] < 9995) && generateMailFromForm(getBasvuruForm(),siteConfig('adminMail'),'Kupon Onay Girişi')) 
		{
			
			$out.='<div class="success">Bilgileriniz kaydedildi. Size tekrar dönülecektir.</div><br>';		
			$out.=viewForm(getBasvuruForm(),$data,'','');
		}
		else $out.='<div class="success">'._lang_formGonderilemedi.'</div><br>';
		saveform(getBasvuruForm(),$data,array('name','email','urun','site','tel','kod','adres'));	
		generateMailFromForm(getBasvuruForm(),siteConfig('adminMail'),'Kupon Sipariş Detayları');
		generateMailFromForm(getBasvuruForm(),$_POST['data_email'],'Kupon Sipariş Detaylarınız');
	}
	else{
		$out .= '<span class="error">HATA : '.$sonuc.'</span><br /><br />'.generateForm(getBasvuruForm(),$data,'','');	
	}
	return $out;
}

function getBasvuruForm() {
	// Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
	// $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
	// Örnek : 
	// $form[] = array("TC Kimlik No","data1","TEXTBOX",1,'',1,10);
	// $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
	
	global $firma;
	$uArray = array();
	foreach($firma as $k=>$v)
	{
		if ($firma[$k])
			$fArray[] = ucfirst($k);	
	}
	if ($_GET['firmaS'])
	{
		$q = my_mysql_query("select * from urun where kuponFirma like '".addslashes($_GET['firmaS'])."'");
		while($d = my_mysql_fetch_array($q))
		{
			$uArray[] = $d['name'].' (ID : '.$d['ID'].')';	
		}
	}
	
	$form[] = array("Kupon Satın Aldığınız Site","site","SELECT",1,$fArray,1,0);
	$form[] = array("Satın Aldığınız Ürün","urun","SELECT",1,$uArray,1,0);
	$form[] = array("Kupon Kodu","kod","TEXTBOX",1,'',1,0);
	$form[] = array(_lang_form_adinizSoyadiniz,"name","TEXTBOX",1,'',1,0);
	$form[] = array(_lang_form_emailAdresiniz,"email","EMAIL",1,'',1,0);
	$form[] = array("Telefon Numaranız","tel","TEXTBOX",1,'',1,0);			
	$form[] = array('Adres',"adres","TEXTAREA",1,'',1,0);	
	return $form;
}


?>
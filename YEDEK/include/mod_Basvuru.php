<?php
/* Ayarlar */

function mybasvuru()
{
	uyeKontrol();
	global $seo;
	$seo->currentTitle = "Bayi Başvuru Formu";
	
	$q = my_mysql_query("select * from user where ID ='".$_SESSION['userID']."'");
	$data = my_mysql_fetch_array($q);	
	$out = generateTableBox('Bayi Başvuru Formu',($_POST['data_name']?basvuruFormSubmit():basvuruForm($data)).'<div style="clear:both;">&nbsp;</div>'.dbInfo('pages','body',4),tempConfig('formlar'));
	return $out;
}

function basvuruForm($data) {
	$out = generateForm(getBasvuruForm(),$data,'','');
	return $out;
}

function basvuruFormSubmit() {	
	unset($_SESSION['cache']);
	$_SESSION['MailSent']++;
	telfix('tel');
	$out = '';
	if (generateMailFromForm(getBasvuruForm(),siteConfig('adminMail'),'Proje Başvuru Girişi')) 
	{
		
		$out.='<div class="success">Bilgileriniz kaydedildi. Projeniz incelendikten sonra bilgilendirileceksiniz.</div><br>';		
		$out.=viewForm(getBasvuruForm(),$data,'','');
	}
	else 
		$out.='<div class="success">'._lang_formGonderilemedi.'</div><br>';
	saveform(getBasvuruForm(),$data,array('name','email','urun','site','tel','kod','adres'));	
	return $out;
}

function getBasvuruForm() {
	// Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
	// $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
	// Örnek : 
	// $form[] = array("TC Kimlik No","data1","TEXTBOX",1,'',1,10);
	// $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
	
	$cArray = array('Spor','Sanat','Teknoloji','Tekstil','Gıda','Diğer');
	$aArray = array('Fikir','Prototip','Satış');
	
	
	$form[] = array("Proje İsmi","name","SELECT",1,$fArray,1,0);
	$form[] = array("Proje Kategorisi","cat","SELECT",1,$cArray,1,0);
	$form[] = array("Firma Adı","firma","TEXTBOX",1,'',1,0);
	$form[] = array('Projeni 180 Karakter ile Özetle',"ozet","TEXTAREA",1,'',1,0);
	$form[] = array('Projeni Kısaca Tanımla',"kisa","TEXTAREA",1,'',1,0);
	$form[] = array('Özgeçmişin ve Ekibin Hakkında Kısaca Bilgilendir',"ozgecmis","TEXTAREA",1,'',1,0);
	$form[] = array("Proje Aşaması","asama","SELECT",1,$aArray,1,0);
	$form[] = array('En az Bir Rakip Örneği',"rakip","TEXTAREA",1,'',1,0);
	$form[] = array('Hedef Kitlen Kim?',"hedef","TEXTBOX",1,'',1,0);	
	$form[] = array('Birlikte Çalıştığın bir İnkübasyon Merkezi ya da Teknokent var mı?',"teknokent","TEXTBOX",1,'',1,0);	
	$form[] = array('Projenin Ne Kadarlık Fon Desteğine İhtiyacı var? ',"destek","TEXTBOX",1,'',1,0);
	$form[] = array('Proje Görseli 1 (jpg,png)',"resim","RESIMUPLOAD",1,'',0,5);
	$form[] = array('Proje Görseli 2 (jpg,png)',"resim2","RESIMUPLOAD",1,'',0,5);
	$form[] = array('Proje Görseli 3 (jpg,png)',"resim3","RESIMUPLOAD",1,'',0,5);
	return $form;
}
?>
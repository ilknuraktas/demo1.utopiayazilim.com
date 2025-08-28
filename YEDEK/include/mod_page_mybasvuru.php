<?php
/* Ayarlar */

function mybasvuru()
{
	uyeKontrol();
	global $seo;
	$seo->currentTitle = "Bayi Başvuru Formu";
	
	$q = my_mysql_query("select * from user where ID ='".$_SESSION['userID']."'");
	$data = my_mysql_fetch_array($q);	
	$out = generateTableBox('Bayi Başvuru Formu',($_POST['data_name']?basvuruFormSubmit():generateForm(getBasvuruForm(),$data,'','')).'<div style="clear:both;">&nbsp;</div>'.dbInfo('pages','body',4),tempConfig('formlar'));
	return $out;
}

function basvuruFormSubmit() {	
	unset($_SESSION['cache']);
	$_SESSION['MailSent']++;
	telfix('tel');
	/*
	for($i=0;$i<=3;$i++)
	{
		$n = $i?$i:'';
		if(!(stristr(file_get_contents($_FILES['file_resim'.$n]["tmp_name"]),'GIF89') === false))
		{
			unset($_FILES['file_resim'.$n]);
		}
		if ($_FILES['file_resim'.$n]['name'])
		{
			list($name,$ext) = explode('.',$_FILES['file_resim'.$n]["name"]);
			$ext = strtolower($ext);
			if ($ext != 'jpg' && $ext != 'gif' && $ext != 'jpeg' && $ext != 'png')
			{
			}
			else 
			{
				$urunname = 'resim'.$n.'-'.((int)hq("select (ID + 1) from saveform order by ID desc limit 0,1")).'.'.$ext;						
				if ($_FILES['file_resim'.$n]["size"] < 5000000)
				{
					move_uploaded_file($_FILES['file_resim'.$n]["tmp_name"], "images/urunler/" .$urunname);
					$_POST['data_resim'.$n] = $urunname;
				}
			}
		}
	}
	*/
	foreach ($_POST as $k=>$v) $data[str_replace('data_','',$k)] = $v;
	$dataView = $data;
	for($i=0;$i<=3;$i++)
	{
		$n = $i?$i:'';
		if($data['resim'.$n])
			$dataView['resim'.$n] = '<img src="images/urunler/'.$data['resim'.$n].'" style="max-width:300px;" />';
	}
	
	generateMailFromForm(getBasvuruForm(),siteConfig('adminMail'),'Proje Başvuru Girişi');
	$out ='<div class="success">Bilgileriniz kaydedildi. Başvurunuz incelendikten sonra bilgilendirileceksiniz.</div><br>';		
	$out.=viewForm(getBasvuruForm(),$dataView,'','');
	saveform(getBasvuruForm(),$data,array('name','lastname','firmaUnvani','vergiNo','vergiDaire','resim','istel','email'),'bayi');	
	return $out;
}

function getBasvuruForm() {
	// Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
	// $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
	// Örnek : 
	// $form[] = array("TC Kimlik No","data1","TEXTBOX",1,'',1,10);
	// $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
	
	$form[] = _lang_kisiselBilgiler;
	$form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
	$form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
	$form[] = '<div class="Kurumsal">';
	$form[] = array("Firma İsmi", "firmaUnvani", "TEXTBOX", 1, '', 1, 0);
	$form[] = array("Vergi No", "vergiNo", "TEXTBOX", 1, '', 0, 0);
	$form[] = array("Vergi Dairesi", "vergiDaire", "TEXTBOX", 1, '', 0, 0);
	$form[] = array("Vergi Levhası", "resim", "RESIMUPLOAD", 1, '', 0, 0);
	$form[] = array(_lang_form_sehir, "city", "CITY", 1, '', 1, 4);
	$form[] = array(_lang_form_semt, "semt", "TOWN", 1, '', 1, 3);
	$form[] = array(_lang_form_adresiniz, "address", "TEXTAREA", 1, '', 1, 10);
	$form[] = array(_lang_form_isTelefonunuz, "istel", "TELEPHONE", 1, '', 0, 0);
	$form[] = array(_lang_form_cepTelefonunuz, "ceptel", "TELEPHONE", 1, '', 1, 0);
	$form[] = array(_lang_form_emailAdresiniz, "email", "EMAIL", 1, '', 1, 0);
	$form[] = '</div>';
	return $form;
}
?>
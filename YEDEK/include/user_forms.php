<?php
/* Aşağıdaki fonkisyonda login olan kullanıcı menüsünü kişiselleştirebilirsiniz. */
function myUserMenuList()
{
  $userID = $_SESSION['userID'];
  $menuArray[_lang_uyeBilgilerim] = slink('profile');
  if (siteConfig('aff_active')) {
    $menuArray['Affilate Hesabım'] = slink('affilate');
    $menuArray['Banka Bilgilerim'] = slink('banka');
  }
  if (siteConfig('ds_active')) {
    $menuArray['Dropshipping Hesabım'] = slink('dropshipping');
    $menuArray['Banka Bilgilerim'] = slink('banka');
  }
  $menuArray[_lang_adreslerim] = slink('adres');
  if (hq("select urunEkleyebilir from user,userGroups,userGroupMembers where user.ID = userGroupMembers.userID AND user.ID = '" . $userID . "' AND userGroups.ID = userGroupMembers.userGroupID limit 0,1")) {
    $menuArray[_lang_urunlerim] = slink('urunlerim');
    $menuArray[_lang_urunSiparislerim] = slink('showUserOrders');
  }
  if (file_exists('include/mod_Teklif.php') && hq("select user.ID from user,userGroups,userGroupMembers where user.ID = userGroupMembers.userID AND user.ID = '" . $userID . "' AND userGroups.ID = userGroupMembers.userGroupID limit 0,1")) {
    //$menuArray[_lang_tekliflerim]=(siteConfig('seoURL') ? 'tekliflerim_sp.html':'page.php?act=tekliflerim');	
  }
  if (($_SESSION['admin_isAdmin'] || (hq("select siparisolustur from userGroups where ID='" . userGroupID() . "'") && userGroupID()))) 
  {
    $menuArray[lc('_lang_hizliSiparisOlustur','Hızlı Sipariş Oluştur')]=slink('siparisolustur');	
  }
  $menuArray[_lang_bakiyeYukle] = slink('bakiye');
  if (file_exists('include/mod_Davet.php')) {
    $menuArray[_lang_siteDavet] = slink('modDavet');
    $menuArray[_lang_siteDavetListe] = slink('modDavetListe');
  }
 // $menuArray[_lang_alisverisSepetim] = slink('sepet');
  $menuArray[_lang_oncekiSiparislerim] = slink('showOrders');
  $menuArray[_lang_hataBildirimi] = slink('hataBildirim');
  $menuArray[_lang_havaleBildirimi] = slink('havaleBildirim');
  $menuArray[_lang_alarmListem] = slink('alarmList');
  $menuArray[_lang_cikis] = slink('logout');
  $menuArray[_lang_uyelikIptal] = 'javascript:uyelikIptal(\'' . _lang_uyelikIptalConfirm . '\');';
  return $menuArray;
}

/* Aşağıdaki fonkisyonda kullanıcı ürün ekleme formunu kişiselleştirebilirisniz. */
function getMakaleUrunEkleForm()
{
  if (function_exists('myGetMakaleUrunEkleForm')) return myGetMakaleUrunEkleForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  // Aşağıdaki satırı açarak kullanıcının sadece 99 ID'li kategori altındaki kategorilere ürün ekleyebilmesini sağlayabilirsiniz.
  // $urunEkleRootID = 99;

  switch ($_GET['mcatID']) {
    default:
      $form[] = array(_lang_form_urunAdi, "name", "TEXTBOX", 1, '', 1, 2);
      $form[] = array(_lang_form_urunMarka, "markaID", "MARKALIST", 1, '', 1, 0);
      $form[] = array(_lang_form_urunKategori, "catID", "KATEGORILIST", 1, '', 1, 5);
      $form[] = array(_lang_form_urunResim . ' 1 (jpg,gif)', "resim", "RESIMUPLOAD", 1, '', 0, 5);
      $form[] = array(_lang_form_urunResim . ' 2 (jpg,gif)', "resim2", "RESIMUPLOAD", 1, '', 0, 5);
      $form[] = array(_lang_form_urunResim . ' 3 (jpg,gif)', "resim3", "RESIMUPLOAD", 1, '', 0, 5);
      $form[] = array(_lang_form_urunListeAciklama, "listeDetay", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunOnDetay, "onDetay", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunDetay, "detay", "TEXTAREA", 1, '', 0, 5);
      $form[] = array(_lang_form_urunSatisFiyatiKDVDahil, "fiyat", "TEXTBOX", 1, '', 1, 0);
      $form[] = array(_lang_form_urunSatisBirim, "fiyatBirim", "SELECT", 1, array('TL', 'USD', 'EUR'), 1, 0);
      $form[] = array(_lang_form_urunSatisKDV, "kdv", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunGaranti, "garanti", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunStok, "stok", "TEXTBOX", 1, '', 1, 0);
      $form[] = array(_lang_form_urunDesi, "desi", "TEXTBOX", 1, '', 0, 5);
      break;
  }


  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı ürün ekleme formunu kişiselleştirebilirisniz. */
function getUrunEkleForm()
{
  if (function_exists('myGetUrunEkleForm')) return myGetUrunEkleForm();
  global $urunEkleRootID;

  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  // Aşağıdaki satırı açarak kullanıcının sadece 99 ID'li kategori altındaki kategorilere ürün ekleyebilmesini sağlayabilirsiniz.
  // $urunEkleRootID = 99;

  $form[] = array(_lang_form_urunAdi, "name", "TEXTBOX", 1, '', 1, 2);
  $form[] = array(_lang_form_urunMarka, "markaID", "MARKALIST", 1, '', 1, 0);
  $form[] = array(_lang_form_urunKategori, "catID", "KATEGORILIST", 1, '', 1, 5);
  $form[] = array(_lang_form_urunResim . ' 1 (jpg,gif)', "resim", "RESIMUPLOAD", 1, '', 0, 5);
  $form[] = array(_lang_form_urunResim . ' 2 (jpg,gif)', "resim2", "RESIMUPLOAD", 1, '', 0, 5);
  $form[] = array(_lang_form_urunResim . ' 3 (jpg,gif)', "resim3", "RESIMUPLOAD", 1, '', 0, 5);
  $form[] = array(_lang_form_urunListeAciklama, "listeDetay", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunOnDetay, "onDetay", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunDetay, "detay", "TEXTAREA", 1, '', 0, 5);
  $form[] = array(_lang_form_urunSatisFiyatiKDVDahil, "fiyat", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_urunSatisBirim, "fiyatBirim", "SELECT", 1, array('TL', 'USD', 'EUR'), 1, 0);
  $form[] = array(_lang_form_urunSatisKDV, "kdv", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunGaranti, "garanti", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunStok, "stok", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_urunDesi, "desi", "TEXTBOX", 1, '', 0, 5);
  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı adres ekleme formunu kişiselleştirebilirsiniz. */
function getAdresEkleForm()
{
  if (function_exists('myGetAdresEkleForm')) return myGetAdresEkleForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  $form[] = array(_lang_form_adresAdi, "baslik", "TEXTBOX", 1, '', 1, 2);
  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
  $form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
  $form[] = array(_lang_form_telefonNumaraniz, "ceptel", "TELEPHONE", 1, '', 1, 14);
  $form[] = array(_lang_form_tckno, "tckNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_adresiniz, "address", "TEXTAREA", 1, '', 1, 10);
  $form[] = array(_lang_form_ulke,"country","COUNTRY",1,'',1,4);
  $form[] = array(_lang_form_sehir, "city", "CITY", 1, '', 1, 4);
  $form[] = array(_lang_form_semt, "semt", "TOWN", 1, '', 1, 3);
  $form[] = array(_lang_form_mahalle, "mah", "TOWN2", 1, '', 1, 3);

  $form[] = array(_lang_form_firmaUnvani, "firmaUnvani", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiDaireniz, "vergiDaire", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiNumaraniz, "vergiNo", "TEXTBOX", 1, '', 0, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda ürün geri bildirim formunu kişiselleştirebilirsiniz. */
function getFeedbackForm()
{
  if (function_exists('myGetFeedbackForm')) return myGetFeedbackForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
  $form[] = '<li class="feedback-container"><ul>';
  $form[] = array(_lang_form_aciklamaYetersiz, "aciklama", "CHECKBOX", 0);
  $form[] = array(_lang_form_hataliBilgi, "hatalibilgi", "CHECKBOX", 0);
  $form[] = array(_lang_form_urunPahali, "pahali", "CHECKBOX", 0);
  $form[] = array(_lang_form_resimKalitesiz, "resimhatali", "CHECKBOX", 0);
  $form[] = array(_lang_form_tekinHata, "teknikhata", "CHECKBOX", 0);
  $form[] = array(_lang_form_yazimHatasi . '<br /><br />', "yazimhatasi", "CHECKBOX", 0);
  $form[] = '</ul></li>';
  $form[] = array(_lang_form_adinizSoyadiniz, "namelastname", "TEXTBOX", 1);
  $form[] = array(_lang_form_telefonNumaraniz, "tel", "TELEPHONE", 1);
  $form[] = array(_lang_form_emailAdresiniz . '|' . lc('_lang_emailAdresinizPlaceHolder', 'email@adresiniz.com'), "email", "EMAIL", 1);
  $form[] = array(_lang_form_detaylar, "message", "TEXTAREA", 1);
  return $form;
}

function getQstForm()
{
  if (function_exists('myGetQstForm')) return myGetQstForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  $form[] = array(_lang_form_adinizSoyadiniz, "namelastname", "TEXTBOX", 1, '', 1);
  $form[] = array(_lang_form_emailAdresiniz . '|' . lc('_lang_emailAdresinizPlaceHolder', 'email@adresiniz.com'), "email", "EMAIL", 1, '', 1);
  $form[] = array(_lang_form_sorunuz, "message", "TEXTAREA", 1, '', 1);
  return $form;
}

function getIptalForm()
{
  if (function_exists('myGetIptalForm')) return myGetIptalForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
  $form[] = array(_lang_form_iptalNeden, "message", "TEXTAREA", 1, '', 1);
  return $form;
}


/* Aşağıdaki fonkisyonda iletişim formunu kişiselleştirebilirsiniz. */
function getContactForm()
{
  if (function_exists('myGetContactForm')) return myGetContactForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  $form[] = array(_lang_form_adinizSoyadiniz, "namelastname", "TEXTBOX", 1, '', 1, 5);
  $form[] = array(_lang_form_telefonNumaraniz, "ceptel", "TELEPHONE", 1, '', 0, 0);
  $form[] = array(_lang_form_emailAdresiniz . '|' . lc('_lang_emailAdresinizPlaceHolder', 'email@adresiniz.com'), "email", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_mesajinizibKonusu, "subject", "TEXTBOX", 1, '', 1, 1);
  $form[] = array(_lang_form_mesajiniz, "message", "TEXTAREA", 1, '', 1);
  $form[] = array(_lang_form_kvkkOkudum, "kvkk", "ACCEPTRULES", 1, "", 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı kayıt formunu kişiselleştirebilirsiniz. */
function getQuickRegisterForm()
{
  if (function_exists('myGetQuickRegisterForm')) return myGetQuickRegisterForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  //$form[] = array(_lang_form_kullaniciAdiniz,"username","TEXTBOX",1,'',1,5);
  //if($_GET['act'] == 'register')
  //	$form[] = '<li class="sf-form-header"><input name="uye-tipi" type="radio" value="bireysel" id="bireysel"> <label for="bireysel">Bireysel Üyelik</label> - <input name="uye-tipi" type="radio" value="kurumsal" id="kurumsal"> <label for="kurumsal">Kurumsal Üyelik</label></li>';
  $form[] = _lang_epostaAdresiniz;
  $form[] = array(_lang_form_emailAdresiniz . '|' . lc('_lang_emailAdresinizPlaceHolder', 'email@adresiniz.com'), "email", "EMAIL", 1, '', 1, 0);
  $form[] = _lang_guvenlik;
  $form[] = array(_lang_form_sifreniz, "password", "PASSWORD", 1, '', 1, 5);

  $form[] = _lang_kisiselBilgiler;
  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
  $form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
  $form[] = '<div class="bireysel">';
  $form[] = array(_lang_form_dogumTarihiniz, "birthdate", "DATE", 1, '', 1, 0);
  //$form[] = array(_lang_form_Resim.' 1 (jpg,gif,png)',"resim","RESIMUPLOAD",1,'',1,0);
  //$form[] = array(_lang_form_Resim.' 2 (jpg,gif,png)',"resim2","RESIMUPLOAD",1,'',0,0);
  $form[] = '</div>';

  if ($_GET['act'] == 'register') $form[] = array(_lang_form_uyelikKurallariOkudum, "uyelikKural", "ACCEPTRULES", 1, "", 1, 0);
  checkForFields($form, 'user');
  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı kayıt formunu kişiselleştirebilirsiniz. */
function getRegisterForm()
{
  if (function_exists('myGetRegisterForm')) return myGetRegisterForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  //$form[] = array(_lang_form_kullaniciAdiniz,"username","TEXTBOX",1,'',1,5);
  //if($_GET['act'] == 'register')
  $form[] = '<li class="sf-form-header register-tab"><label for="bireysel" id="bireysel" class="active">' . lc('_lang_bireyselUyelik', 'Bireysel Üyelik') . '</label> <label id="kurumsal" for="kurumsal">' . lc('_lang_kurumsalUyelik', 'Kurumsal Üyelik') . '</label></li>';
  $form[] = _lang_kisiselBilgiler;
  $form[] = array(_lang_form_emailAdresiniz . '|' . lc('_lang_emailAdresinizPlaceHolder', 'email@adresiniz.com'), "email", "EMAIL", 1, '', 1, 0);
  $form[] = array(_lang_form_emailAdresinizTekrar . '|' . lc('_lang_emailAdresinizPlaceHolder', 'email@adresiniz.com'), "check_email", "EMAIL", 1, '', 1, 0);
  if ($_GET['act'] == 'profile') {
    /* Profile 'de şifre zorunlu değil. Boşsa eski şifre geçerli */
    $form[] = '';
    $form[] = array(_lang_form_sifreniz, "password", "PASSWORD", 1, '', 0, 5);
    $form[] = array(_lang_form_sifrenizTekrar, "check_password", "PASSWORD", 1, '', 0, 5);
  } else {
    $form[] = '';
    $form[] = array(_lang_form_sifreniz, "password", "PASSWORD", 1, '', 1, 5);
    $form[] = array(_lang_form_sifrenizTekrar, "check_password", "PASSWORD", 1, '', 1, 5);
  }
  $form[] = '';
  // $form[] = array(_lang_davetKullanici,"davetUserID","USERLIST",1,'',1,0);
  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
  $form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
  $form[] = '<div class="bireysel">';
  //$form[] = array(_lang_form_dogumTarihiniz, "birthdate", "DATE", 1, '', 1, 0);
  //	$form[] = array(_lang_form_cinsiyetiniz, "sex", "SELECT", 1, array(_lang_form_kadin, _lang_form_erkek), 1, 0);
  $form[] = array(_lang_form_tckno, "tckNo", "TEXTBOX", 1, '', 0, 0);
  //$form[] = array(_lang_form_Resim.' 1 (jpg,gif,png)',"resim","RESIMUPLOAD",1,'',1,0);
  //$form[] = array(_lang_form_Resim.' 2 (jpg,gif,png)',"resim2","RESIMUPLOAD",1,'',0,0);
  $form[] = '</div>';
  $form[] = '<div class="kurumsal" style="display:none;">';
  $form[] = lc('_lang_kurumsalBilgiler', 'Kurumsal Bilgiler');
  $form[] = array(_lang_form_firmaUnvani, "firmaUnvani", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiDaireniz, "vergiDaire", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiNumaraniz, "vergiNo", "TEXTBOX", 1, '', 0, 0);
  //$form[] = array('E-Fatura', "efatura", "SELECT", 1, array(_lang_formEvet, _lang_formHayir), 0, 0);
  $form[] = '</div>';
  $form[] = _lang_iletisimBilgileri;
  //$form[] = array(_lang_form_ulke,"country","COUNTRY",1,'',1,4);
  $form[] = array(_lang_form_sehir, "city", "CITY", 1, '', 1, 4);
  $form[] = array(_lang_form_semt, "semt", "TOWN", 1, '', 1, 3);
  $form[] = array(_lang_form_mahalle, "mah", "TOWN2", 1, '', 1, 3);
  $form[] = array(_lang_form_cepTelefonunuz, "ceptel", "TELEPHONE", 1, '', 1, 14);

  $form[] = array(_lang_form_adresiniz, "address", "TEXTAREA", 1, '', 1, 10);
  $form[] = '';
  $form[] = array(_lang_ebulten . ' (Email)', "ebulten", "CHECKBOX", 1, '', 0, 0);
  // if (siteConfig('SMS_kullan'))
  $form[] = array(_lang_ebulten . ' (SMS)', "ebultenSMS", "CHECKBOX", 1, '', 0, 0);
  if ($_GET['act'] == 'register') {
    $form[] = '';
    $form[] = array(_lang_form_uyelikKurallariOkudum, "uyelikKural", "ACCEPTRULES", 1, "", 1, 0);
  }
//  $form[] = '';
  checkForFields($form, 'user');
  return $form;
}

/* Aşağıdaki fonkisyonda affilate banka hesabı formunu kişiselleştirebilirsiniz. */
function getBankaForm()
{
  if (function_exists('myGetBankaForm')) return myGetBankaForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  $form[] = array(_lang_form_bankaAdi, "aff_banka", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaHesapAdi, "aff_name", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaIbanNo, "aff_iban", "TEXTBOX", 1, '', 0, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda affilate başvuru formunu kişiselleştirebilirsiniz. */
function getAffBasvuruForm()
{
  if (function_exists('myGetAffBasvuruForm')) return myGetAffBasvuruForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  $form[] = array(_lang_form_aff_siteAdresi, "aff_web", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_bankaAdi, "aff_banka", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaHesapAdi, "aff_name", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaIbanNo, "aff_iban", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_aff_not, "aff_not", "TEXTAREA", 1, '', 0, 0);
  $form[] = array(_lang_form_aff_kural, "aff_kural", "ACCEPTRULES", 1, "", 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda affilate başvuru formunu kişiselleştirebilirsiniz. */
function getDsBasvuruForm()
{
  if (function_exists('myGetDsBasvuruForm')) return myGetDsBasvuruForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  // $form[] = array(_lang_form_aff_siteAdresi,"aff_web","TEXTBOX",1,'',1,0);
  $form[] = array(_lang_form_bankaAdi, "aff_banka", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaHesapAdi, "aff_name", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaIbanNo, "aff_iban", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_mesajiniz, "ds_not", "TEXTAREA", 1, '', 0, 0);
  $form[] = array('Dropshipping ' . _lang_form_uyelikKurallariOkudum, "ds_kural", "ACCEPTRULES", 1, "", 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda affilate başvuru formunu kişiselleştirebilirsiniz. */
function getSortForm()
{
  if (function_exists('myGetSortForm')) return myGetSortForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  $form[] = array(_lang_form_BaslangicTarihi, "start", "DATE", 1, '', 1, 0);
  $form[] = array(_lang_form_BitisTarihi, "finish", "DATE", 1, '', 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda sipariş formunu kişiselleştirebilirsiniz. */
function getSiparisForm()
{
  if (function_exists('myGetSiparisForm')) return myGetSiparisForm();
  global $siteConfig;
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",1,'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
  // $form[] = array("Ek Bilgi","data3","TEXTBOX",1,'',1,5);


  //  $form[] = array('Kullanıcı', "userID", "USERLIST", 1, '', 0, 9);
  $form[] = '<li class="sf-form-header register-tab"><label for="bireysel" id="bireysel" class="active">' . lc('_lang_biryselSiparis', 'Bireysel Sipariş') . '</label> <label id="kurumsal" for="kurumsal">' . lc('_lang_kurumsalSiparis', 'Kurumsal Sipariş') . '</label></li>';
  $form[] = _lang_kisiselBilgiler;
  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
  $form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
  $form[] = array(_lang_form_emailAdresiniz . '|' . lc('_lang_emailAdresinizPlaceHolder', 'email@adresiniz.com'), "email", "EMAIL", 1, '', 1, 0);
  //$form[] = array(_lang_form_evTelefonunuz, "evtel", "TELEPHONE", 1, '', 0, 0);
  //$form[] = array(_lang_form_isTelefonunuz, "istel", "TELEPHONE", 1, '', 0, 0);
  $form[] = array(_lang_form_cepTelefonunuz . '|(xxx) xxx-xxxx', "ceptel", "TELEPHONE", 1, '', 1, 14);
  $form[] = '<div class="bireysel">';
  $form[] = array(_lang_form_tckno, "tckNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = '</div>';
  $form[] = '<div class="kurumsal d-none">';
  $form[] = _lang_vergiBilgileri;
  $form[] = array(_lang_form_vergiDaireniz, "vergiDaire", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiNumaraniz, "vergiNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_firmaUnvani, "firmaUnvani", "TEXTBOX", 1, '', 0, 0);
  $form[] = '</div>';

  $form[] = _lang_teslimatAdresi;
  if ($_SESSION['userID'] && hq('select ID from useraddress where userID=\'' . $_SESSION['userID'] . '\'')) $form[] = array(_lang_form_kayitliAdresleriniz, "addressID", "ADDRESS", 1, '', 0, 10);
  $form[] = array(_lang_form_adresiniz, "address", "TEXTAREA", 1, '', 1, 10);
  //$form[] = array(_lang_form_ulke,"country","COUNTRY",1,'',1,4);
  $form[] = array(_lang_form_sehir, "city", "CITY", 1, '', 1, 4);
  $form[] = array(_lang_form_semt, "semt", "TOWN", 1, '', 1, 3);
  $form[] = array(_lang_form_mahalle, "mah", "TOWN2", 1, '', 1, 3);

  if (!isReallyMobile())
    $form[] = '<li class="sf-form-header"><div class="checkbox-fa"><input id="fatura" type="checkbox"><label for="fatura">' . _lang_faturaAdresimFarkli . '</label></div></li><div class="fatura">';
  // $form[] = 'Fatura Adresi';
  if ($_SESSION['userID'] && hq('select ID from useraddress where userID=\'' . $_SESSION['userID'] . '\'')) $form[] = array(_lang_form_kayitliAdresleriniz, "addressID2", "ADDRESS", 1, '', 0, 10);
  $form[] = array(_lang_form_faturaAdresi, "address2", "TEXTAREA", 1, '', 0, 0);
  //$form[] = array(_lang_form_ulke,"country2","COUNTRY",1,'',1,4);
  $form[] = array(_lang_form_sehir, "city2", "CITY", 1, '', 0, 0);
  $form[] = array(_lang_form_semt, "semt2", "TOWN", 1, '', 0, 0);
  $form[] = array(_lang_form_mahalle, "mah2", "TOWN2", 1, '', 0, 3);


  if (!isReallyMobile())
    $form[] = '</div>';



  // Eğer kargo firması eklendiyse bu satırı göster.
  if (sizeof(getKargoArray())) {
    // $form[] = _lang_kargoSecenegi;
    $form[] = array(_lang_form_kargo, "kargoFirmaID", "KARGO", 1, '', 1, 0);
  }
  // Eğer teslimat saati eklendiyse bu satırı göster.
  if (hq("select ID from teslimat")) {
    $form[] = array(_lang_form_teslimat, "teslimatID", "TESLIMAT", 1, '', 1, 0);
  }
  //$form[] = _lang_hediyeindirim;

  //	$form[] = '';
  $form[] = array(_lang_form_siparisNotu, "notAlici", "TEXTAREA", 1, '', 0, 0);
  // $form[] = array(_lang_form_hediyePaketi, "hediye", "SELECT", 1, array(_lang_formEvet, _lang_formHayir), 0, 0);

  if (isReallyMobile() && basketInfo('toplamKDVDahil', $_SESSION['randStr']) >= siteConfig('promosyonAlisverisSiniri'))
    $form[] = array(_lang_form_promosyonKodu, "promotionCode", "TEXTBOX", 1, '', 0, 0);



  //$form[] = array('Sipariş Saati',"data1","CUSTOM",1,siparisSaati(),0,0);

  if (siteConfig('ds_active') && userGroupID() && hq("select ds_active from userGroups where ID='" . userGroupID() . "'") && hq("select ds_onay from user where ID='" . $_SESSION['userID'] . "'")) {
    $form[] = '';
    $form[] = array('Dropshipping Tahsilat Tutarı (TL)', "ds_tutar", "TEXTBOX", 1, '', 0, 0);
  }

  //$form[] = '';

  //$form[] = array('KDV İstemiyorum', "kdvsiz", "SELECT", 1, array(_lang_evet . '|' . _lang_evet, '0|' . _lang_hayir . '|0'), 1, 0);


  if (siteConfig('sepet_odeme') == '2' || siteConfig('sepet_odeme') == '1' || isReallyMobile()) {
    /*
    $form[] = array(_lang_titleOdemeSekliniz, "odemeTipi", "SELECTV", 1, siparisOdemeSecimArray(), 1, 0);
    $form[] = '';
    $form[] = array(_lang_form_satinAlmaKurallariOkudum, "satinalKural", "ACCEPTRULES", 1, "", 1, 0);
    */
  }
  /*
	if($_GET['sn'])
		$form[] = array('Site Mesaj',"notYonetici","TEXTAREA",1,'',1,10);
	 */
  checkForFields($form, 'siparis');
  return $form;
}

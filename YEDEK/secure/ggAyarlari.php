<?php
$dbase = "siteConfig";
$title = 'Gitti Gidiyor Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'API Role Kullanıcı Adı',
		db => 'gg_username',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'API Role Şifre',
		db => 'gg_password',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'API Key',
		db => 'gg_api',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'API Secret Key',
		db => 'gg_secret',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Açıklama Header',
		db => 'gg_header',
		info => 'Her ürün açıklamasının üst kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Açıklama Footer',
		db => 'gg_footer',
		info => 'Her ürün açıklamasının alt kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Fiyat Tablosu',
		db => 'gg_fiyatAlani',
		stil => 'simplepulldown',
		align => 'left',
		info => 'Üründe, seçime ait bir fiyat girilmemişse ana fiyat geçerli olur.',
		width => 80,
		simpleValues => '0|Normal Fiyat,1|Fiyat 1,2|Fiyat 2,3|Fiyat 3,4|Fiyat 4,5|Fiyat 5',
		gerekli => '1'
	),
	array(
		isim => 'Otomatik Fiyat Ekleme için Azami Ürün Tutarı',
		info => 'Fiyat ekleme, buraya girilen tutarın altındaki ürünlere yapılır',
		db => 'gg_azami',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Fiyat Ekle (TL)',
		db => 'gg_fiyat',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Oran Ekle (Ör: 0.2 = %20)',
		db => 'gg_oran',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Piyasa Fiyatı Otomatik Oran (Ör: 0.2 = %20)',
		info=> 'Eğer bir oran girilmezse ürüne girilen piyasa fiyatı baz alınır. Bir oran girilirse, hesaplanan satış fiyatına bu oran eklenerek piyasa fiyatı olarak gönderilir.',
		db => 'gg_poran',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Dükkan No (Zorunlu Değil)',
		db => 'gg_DukkanNo',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Sayfa Düzeni',
		db => 'gg_SayfaDuzeni',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '1,2,3,4,5,6',
		gerekli => '1'
	),
	array(
		isim => 'Ürün Formatı',
		db => 'gg_UrunFormati',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => 'F|Sabit Fiyatlı Ürün Formatı,S|Dükkan Formatlı',
		gerekli => '1'
	),
	array(
		isim => 'Süre',
		db => 'gg_Sure',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '3|3 Gün,5|5 Gün,7|7 Gün,10|10 Gün,30|30 Gün (Dükkan Formatı İçin),60|60 Gün (Dükkan Formatı İçin),,30|30 Gün (Dükkan Formatı İçin),60|60 Gün (Dükkan Formatı İçin),60|60 Gün (Dükkan Formatı İçin),60|60 Gün (Dükkan Formatı İçin),180|180 Gün (Dükkan Formatı İçin),360|360 Gün (Dükkan Formatı İçin)',
		gerekli => '1'
	),
	array(
		isim => 'Şehir',
		db => 'gg_Sehir',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'iller',
			base => 'plakaID',
			name => 'name',
		),
		gerekli => '1'
	),
	array(
		isim => 'Kargo Desi Tutarını Fiyata Ekle',
		db => 'gg_desi',
		stil => 'checkbox',
		info => 'Azami tutar değerinin altındaki ürünlere kargo, desi hesaplamasına göre tutarı eklenir. Birden fazla bölgey ait desi fiyatı girilmişse, en yüksek tutar baz alınır.',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Kargo Desi Hesaplanacak Firma',
		db => 'gg_kargoID',
		width => 94,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'kargofirma',
			base => 'ID',
			name => 'name',
			order => 'ID'
		),
		gerekli => '1'
	),
	array(
		isim => 'Kargo Gönderim Saati',
		db => 'gg_Saat',
		info => 'Ör saat : 17:00',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Gönderim Yapılacak Kargo Firması',
		db => 'gg_Kargo',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => 'aras|Aras Kargo,dhl|DHL Kargo,fedex|Fedex Kargo,fillo|Fillo Kargo,mng|MNG Kargo,surat|Sürat Kargo,ptt|PTT Kargo,surat|Sürat Kargo,tnt|TNT Kargo,yurtici|Yutiçi Kargo,ups|UPS Kargo,varan|Varan Kargo,diger|Diğer',
		gerekli => '1'
	),
	array(
		isim => 'Kargo Gönderim Tipi',
		db => 'gg_KargoUcreti',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => 'S|Satıcı Öder,B|Alıcı Öder,D|Diğer (bkz. Ürün Açıklaması),O|Online',
		gerekli => '1'
	),
	array(
		isim => 'Kargo Ücreti (TL)',
		info => 'Sadece <span style="color:red">Kargo Alıcı Öder</span> gönderim tipinde geçerli olur.',
		db => 'gg_KargoAliciUcreti',
		stil => 'normaltext',
		align => 'left',
		gerekli => '1'
	),
	array(
		isim => 'Kargo Açıklama',
		db => 'gg_KargoAciklamasi',
		stil => 'textarea',
		rows => '6',
		cols => '64',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Gönderi Yapılacak Alanlar',
		db => 'gg_GonderiYapilacakAlanlar',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => 'country|Tüm Türkiyeye Gönderilir,city|Sadece Şehir İçi Gönderilir,world|Türkiye ve Dünyanın her bölgesine gönderilir',
		gerekli => '1'
	),
	array(
		isim => 'Alt Başlıkları Gönderme',
		db => 'gg_Subtitle',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'İş Ortaklığı Aktif',
		db => 'gg_IsOrtakligi',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Kalın Yazı',
		db => 'gg_KalinYazi',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Katalog',
		db => 'gg_Katalog',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Vitrin',
		db => 'gg_Vitrin',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Spec girilmeyen ürünleri, kategorideki diğer ürünler ile eşitle',
		info=>'İşaretlendiğinde spec girilmeyen ürünlerde, aynı kategorideki diğer ürünlerin specleri baz alınır. Böylece yeni girilen bir ürün, spec seçilmediği halde otomatik eklenebilir. Eğer kategori ürünleriniz farklı spec seçimleri gerektiriyorsa bu kısmı aktif etmeyin.',
		db => 'gg_esitle',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Zorunlu Olmayan Ürün Seçimlerini de Getir',
		db => 'gg_zorunlu',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Ürünlerin Kargosunu Alıcı Sepette Öder',
		info=>'İşaretlenebilmesi için ürünlere desi girilmiş olması gerekir.',
		db => 'gg_ksepet',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Ürünleri Gerçek Zamanlı Gönder',
		db => 'gg_hemen',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
);
if($_POST['gg_secret'])
{
	my_mysql_query("update urun set ggup=1 where barkodNo != ''");
}
if (!file_exists('../include/mod_GittiGidiyor.php'))
	$tempInfo .= adminWarnv3('Paketinize GittiGidiyor Entegrasyon Modülü bulunmamaktadır.');
else
{
	$tempInfo .= adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <br/><br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-gg.php</strong> ve<br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-gg.php?siparis=true</strong><br/><br/> URL adreslerinin, en az 3dk, en fazla 15dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-gg.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
	$tempInfo .= adminInfov3('GittiGidiyor entegrasyonu için sunucunuzda SOAP ext. desteğinin aktif olması gerekmektedir.');
	$tempInfo .= adminInfov3('GittiGidiyor Role kullanıcı adı ve şifresini "API entegrasyon desteği" kullanılacağını belirtip GittiGidiyor firmasından talep edilmelidir. Api role kullanıcı adı ve şifre, GittiGidiyor sitesine giriş yaparken kullandığınız kullanıcı adı ve şifre değildir.');
	$tempInfo .= adminInfov3('GittiGidiyor entegrasyona sadece *GittiGidiyor kodu tanımlanmış kategorilerdeki* ürünler gönderilmektedir.');
	$tempInfo .= adminInfov3('GittiGidiyor Otomatik Oran Ekle (Ör: 0.2 = %20) girişi, ilgili kategoride, "Varsayılan Çıkış Kar Marjı" girilmeyen ürünller için geçerlidir. Bir kategoriye "Varsayılan Çıkış Kar Marjı" tanımlıysa, o geçerli olur.');
	if (!class_exists("SOAPClient"))
		$tempInfo .= adminErrorv3('Sunucunuzda SOAP yüklü veya aktif değil. API entegrasyonu kullanabilmek için SOAP özelliğinin aktif olması gerekiyor. Sunucu yöneticinize bunu ileterek SOAP desteğini aktif edebilirsiniz.');
	if(siteConfig('gg_username') && siteConfig('gg_password'))
		$tempInfo .= '<div class="float-left">'.v5Admin::simpleButtonWithImage('', 'window.open(\'../cron-gg.php\');', 'menu', 'Cron Servisini Çalıştır', 'success') . ''.v5Admin::simpleButtonWithImage('', 'window.open(\'../cron-gg.php?siparis=true\');', 'cart', 'Sipariş Servisini Çalıştır', 'success') . '</div><div class="clear">&nbsp;</div>';
}

admin($dbase, $where, $icerik, $ozellikler);
				//if ($_POST['y'] == 'du') echo "<script>$(document).ready(function() { window.location.href = 'gg.php'; });</script>";

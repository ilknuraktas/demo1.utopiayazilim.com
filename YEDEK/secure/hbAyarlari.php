<?
my_mysql_query("CREATE TABLE IF NOT EXISTS `hepsiburada` ( `ID` int(11) NOT NULL AUTO_INCREMENT, `urunID` int(11) NOT NULL, `filter` longtext CHARACTER SET latin5 NOT NULL, `hbUpdate` int(20) NOT NULL DEFAULT '0', PRIMARY KEY (`ID`) 	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;", 1);
$dbase = "siteConfig";
$title = 'HepsiBurada Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);
if (!file_exists('../include/mod_HepsiBurada.php'))
	$tempInfo .= adminWarnv3('Paketinize HepsiBurada Entegrasyon Modülü bulunmamaktadır.');
else
{
	$tempInfo .= adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <br/><br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-hb.php</strong> ve<br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-hb.php?siparis=true</strong><br/><br/> URL adreslerinin, en az 3dk, en fazla 15dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-hb.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
	$tempInfo .= adminInfov3('HepsiBurada Otomatik Oran Ekle (Ör: 0.2 = %20) girişi, ilgili kategoride, "Varsayılan Çıkış Kar Marjı" girilmeyen ürünller için geçerlidir. Bir kategoriye "Varsayılan Çıkış Kar Marjı" tanımlıysa, o geçerli olur.');
	if(siteConfig('hb_mID'))
		$tempInfo .= '<div class="float-left">'.v5Admin::simpleButtonWithImage('', 'window.open(\'../cron-hb.php\');', 'menu', 'Cron Servisini Çalıştır', 'success') . ''.v5Admin::simpleButtonWithImage('', 'window.open(\'../cron-hb.php?siparis=true\');', 'cart', 'Sipariş Servisini Çalıştır', 'success') . '</div><div class="clear">&nbsp;</div>';
}

$icerik = array(
	/*
				array(isim=>'API Panel Kullanıcı Adı',
					  db=>'hb_username',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'API Panel Şifre',
					  db=>'hb_password',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
	*/
	array(
		isim => 'API Merchant ID',
		db => 'hb_mID',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 1
	),
	/*
	array(
		isim => 'API Username',
		db => 'hb_username',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 0
	),
	array(
		isim => 'API Password',
		db => 'hb_password',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 0
	),
*/
	array(
		isim => 'Açıklama Header',
		db => 'hb_header',
		info => 'Her ürün açıklamasının üst kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Açıklama Footer',
		db => 'hb_footer',
		info => 'Her ürün açıklamasının alt kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Fiyat Tablosu',
		db => 'hb_fiyatAlani',
		stil => 'simplepulldown',
		align => 'left',
		info => 'Üründe, seçime ait bir fiyat girilmemişse ana fiyat geçerli olur.',
		width => 80,
		simpleValues => '0|Normal Fiyat,1|Fiyat 1,2|Fiyat 2,3|Fiyat 3,4|Fiyat 4,5|Fiyat 5',
		gerekli => '1'
	),
	array(
		isim => 'Otomatik Fiyat Ekleme için Azami Ürün Tutarı',
		db => 'hb_azami',
		stil => 'normaltext',
		info=>'Fiyat ekleme, buraya girilen tutarın altındaki ürünlere yapılır',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Fiyat Ekle (TL)',
		db => 'hb_fiyat',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Oran Ekle (Ör: 0.2 = %20)',
		db => 'hb_oran',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Zorunlu Olmayan Ürün Seçimlerini de Getir',
		db => 'hb_zorunlu',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Kargo desi tutarını fiyata ekle',
		db => 'hb_desi',
		stil => 'checkbox',
		info => 'Azami tutar değerinin altındaki ürünlere kargo, desi hesaplamasına göre tutarı eklenir. Birden fazla bölgeye ait desi fiyatı girilmişse, en yüksek tutar baz alınır.',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Varsayılan Kargo Süresi (Gün)',
		db => 'hb_kargo_gun',
		stil => 'checkbox',
		info => 'Eğer üründe anında kargo işaretliyse bu süre 1 gün olarak gönderilir. Kargo gün değeri varsa o gönderilir. İkisi de yoksa bu değer geçerli olur.',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Kargo Desi Hesaplanacak Firma',
		db => 'hb_kargoID',
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
);
admin($dbase, $where, $icerik, $ozellikler);

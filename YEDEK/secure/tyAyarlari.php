<?php
my_mysql_query("CREATE TABLE IF NOT EXISTS `trendyol` ( `ID` int(11) NOT NULL AUTO_INCREMENT, `urunID` int(11) NOT NULL, `filter` longtext CHARACTER SET latin5 NOT NULL, `tyUpdate` int(20) NOT NULL DEFAULT '0', PRIMARY KEY (`ID`) 	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;", 1);

$dbase = "siteConfig";
$title = 'Trendyol Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);
if (!file_exists('../include/mod_Trendyol.php'))
	$tempInfo .= adminWarnv3('Paketinize Trendyol Entegrasyon Modülü bulunmamaktadır.');
else {
	require_once('../include/mod_Trendyol.php');
	$tempInfo .= adminInfov3('Trendyol ürünlerde <strong>XML Ürün kodu (Model No), Barkod Numarası ve Piyasa Fiyatı</strong> gönderimini zorunlu tutmaktadır.');
	$tempInfo .= adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <br/><br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-ty.php</strong> ve<br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-ty.php?siparis=true</strong><br/><br/> URL adreslerinin, en az 3dk, en fazla 15dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-ty.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
	$tempInfo .= adminInfov3('Trendyol Otomatik Oran Ekle (Ör: 0.2 = %20) girişi, ilgili kategoride, "Varsayılan Çıkış Kar Marjı" girilmeyen ürünller için geçerlidir. Bir kategoriye "Varsayılan Çıkış Kar Marjı" tanımlıysa, o geçerli olur.');
	if(siteConfig('ty_username') && siteConfig('ty_password'))
		$tempInfo .= '<div class="float-left">'.v4Admin::simpleButtonWithImage('', 'window.open(\'../cron-ty.php\');', 'menu', 'Cron Servisini Çalıştır', 'success') . ''.v4Admin::simpleButtonWithImage('', 'window.open(\'../cron-ty.php?siparis=true\');', 'cart', 'Sipariş Servisini Çalıştır', 'success') . '</div><div class="clear">&nbsp;</div>';	

}
$icerik = array(
	array(
		isim => 'API Kullanıcı Adı',
		db => 'ty_username',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'API Şifre',
		db => 'ty_password',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Tedarikci ID',
		db => 'ty_ID',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Açıklama Header',
		db => 'ty_header',
		info => 'Her ürün açıklamasının üst kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Açıklama Footer',
		db => 'ty_footer',
		info => 'Her ürün açıklamasının alt kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Kargo Firması',
		db => 'ty_kargoFirmasi',
		stil => 'simplepulldown',
		align => 'left',
		width => 80,
		simpleValues => Trendyol::getShipmentProviders(),
		gerekli => '1'
	),
	array(
		isim => 'Fiyat Tablosu',
		db => 'ty_fiyatAlani',
		stil => 'simplepulldown',
		align => 'left',
		info => 'Üründe, seçime ait bir fiyat girilmemişse ana fiyat geçerli olur.',
		width => 80,
		simpleValues => '0|Normal Fiyat,1|Fiyat 1,2|Fiyat 2,3|Fiyat 3,4|Fiyat 4,5|Fiyat 5',
		gerekli => '1'
	),
	array(
		isim => 'Otomatik Fiyat Ekleme için Azami Ürün Tutarı',
		db => 'ty_azami',
		info=>'Fiyat ekleme, buraya girilen tutarın altındaki ürünlere yapılır',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Fiyat Ekle (TL)',
		db => 'ty_fiyat',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Oran Ekle (Ör: 0.2 = %20)',
		db => 'ty_oran',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),

	array(
		isim => 'Piyasa Fiyatı Otomatik Oran (Ör: 0.2 = %20)',
		info=> 'Eğer bir oran girilmezse ürüne girilen piyasa fiyatı baz alınır. Bir oran girilirse, hesaplanan satış fiyatına bu oran eklenerek piyasa fiyatı olarak gönderilir.',
		db => 'ty_poran',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),

	array(
		isim => 'Piyasa Fiyatı Olarak Ürün Fiyatını Gönder',
		db => 'ty_piyasafix',
		stil => 'checkbox',
		info => 'işaretlendiğinde, ürün piyasa fiyatı ve marj ne olursa olsun ürün fiyatı ile piyasa fiyatı aynı gider.',
		width => 29,
		gerekli => '0'
	),

	array(
		isim => 'Kargo Desi Tutarını Fiyata Ekle',
		db => 'ty_desi',
		stil => 'checkbox',
		info => 'Azami tutar değerinin altındaki ürünlere kargo, desi hesaplamasına göre tutarı eklenir. Birden fazla bölgeye ait desi fiyatı girilmişse, en yüksek tutar baz alınır.',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Kargo Desi Hesaplanacak Firma',
		db => 'ty_kargoID',
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
		isim => 'Zorunlu Olmayan Ürün Seçimlerini de Getir',
		db => 'ty_zorunlu',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Barkod Olmayan Ürünlere Otomatik Barkod Gönder',
		db => 'tygtin',
		info => 'Gereksiz / hatalı kullanımı ürünlerin kabul edilmemesi ile sonuçlanabilir.',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Asgari Ürün Tutarı',
		db => 'ty_asgari',
		info => 'Örneğin 100 girilirse, 100 TL altı ürünler Trendyol\'a gönderilmez.',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	)
);
admin($dbase, $where, $icerik, $ozellikler);

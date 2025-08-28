<?php
my_mysql_query("CREATE TABLE IF NOT EXISTS `n11` ( `ID` int(11) NOT NULL AUTO_INCREMENT, `urunID` int(11) NOT NULL, `filter` longtext CHARACTER SET latin5 NOT NULL, `n11_Hash` varchar(40) NOT NULL DEFAULT '0', `n11_Update` int(20) NOT NULL DEFAULT '0', PRIMARY KEY (`ID`) 	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;");
$dbase = "siteConfig";
$title = 'N11 Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);
if (!file_exists('../include/mod_N11.php'))
	$tempInfo .= adminWarnv3('Paketinize N11 Entegrasyon Modülü bulunmamaktadır.');
else {
	$tempInfo .= adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <br/><br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-n11.php</strong> ve<br/><strong>https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-n11.php?siparis=true</strong><br/><br/> URL adreslerinin, en az 3dk, en fazla 15dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-n11.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
	$tempInfo .= adminInfov3('N11 Alışveriş Şablonunu, N11 panelinizdeki <a href="https://so.n11.com/selleroffice/product/shippingInformationList" target="_blank">https://so.n11.com/selleroffice/product/shippingInformationList</a> adresinden oluşturabilirsiniz.');
	$tempInfo .= adminInfov3('N11 Otomatik Oran Ekle (Ör: 0.2 = %20) girişi, ilgili kategoride, "Varsayılan Çıkış Kar Marjı" girilmeyen ürünller için geçerlidir. Bir kategoriye "Varsayılan Çıkış Kar Marjı" tanımlıysa, o geçerli olur.');
	if (!class_exists("SOAPClient"))
		$tempInfo .= adminErrorv3('Sunucunuzda SOAP yüklü veya aktif değil. API entegrasyonu kullanabilmek için SOAP özelliğinin aktif olması gerekiyor. Sunucu yöneticinize bunu ileterek SOAP desteğini aktif edebilirsiniz.');
	if(siteConfig('n11_username') && siteConfig('n11_password'))
		$tempInfo .= '<div class="float-left">'.v5Admin::simpleButtonWithImage('', 'window.open(\'../cron-n11.php\');', 'menu', 'Cron Servisini Çalıştır', 'success') . ''.v5Admin::simpleButtonWithImage('', 'window.open(\'../cron-n11.php?siparis=true\');', 'cart', 'Sipariş Servisini Çalıştır', 'success') . '</div><div class="clear">&nbsp;</div>';	
}
$icerik = array(
	array(
		isim => 'API Kullanıcı Adı',
		db => 'n11_username',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 1
	),
	array(
		isim => 'API Şifre',
		db => 'n11_password',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 1
	),
	array(
		isim => 'Açıklama Header',
		db => 'n11_header',
		info => 'Her ürün açıklamasının üst kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Açıklama Footer',
		db => 'n11_footer',
		info => 'Her ürün açıklamasının alt kısmına eklenir.',
		stil => 'HTML',
		en => '450',
		boy => '150',
		gerekli => '0',
	),
	array(
		isim => 'Alışveriş (Teslimat) Şablonu<br />(Normal Ürünler)',
		db => 'n11_sablon',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 1
	),
	array(
		isim => 'Alışveriş (Teslimat) Şablonu<br />(Ücretsiz Kargo Ürünleri)',
		db => 'n11_sablon_ucretsiz',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 1
	),
	array(
		isim => 'Alışveriş (Teslimat) Şablonu<br />(Anında Kargo Ürünler)',
		db => 'n11_sablon_aninda',
		stil => 'normaltext',
		unlist => true,
		zorunlu => 1
	),
	array(
		isim => 'Fiyat Tablosu',
		db => 'n11_fiyatAlani',
		stil => 'simplepulldown',
		align => 'left',
		info => 'Üründe, seçime ait bir fiyat girilmemişse ana fiyat geçerli olur.',
		width => 80,
		simpleValues => '0|Normal Fiyat,1|Fiyat 1,2|Fiyat 2,3|Fiyat 3,4|Fiyat 4,5|Fiyat 5',
		gerekli => '1'
	),
	array(
		isim => 'Otomatik Fiyat Ekleme için Azami Ürün Tutarı',
		db => 'n11_azami',
		info => 'Fiyat ekleme, buraya girilen tutarın altındaki ürünlere yapılır',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Fiyat Ekle (TL)',
		db => 'n11_fiyat',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Otomatik Oran Ekle (Ör: 0.2 = %20)',
		db => 'n11_oran',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Piyasa Fiyatı Otomatik Oran (Ör: 0.2 = %20)',
		info=> 'Eğer bir oran girilmezse ürüne girilen piyasa fiyatı baz alınır. Bir oran girilirse, hesaplanan satış fiyatına bu oran eklenerek piyasa fiyatı olarak gönderilir.',
		db => 'n11_poran',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Kargo Desi Tutarını Fiyata Ekle',
		db => 'n11_desi',
		stil => 'checkbox',
		info => 'Azami tutar değerinin altındaki ürünlere kargo, desi hesaplamasına göre tutarı eklenir. Birden fazla bölgeye ait desi fiyatı girilmişse, en yüksek tutar baz alınır.',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Kargo Desi Hesaplanacak Firma',
		db => 'n11_kargoID',
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
		isim => 'Varsayılan Kargo Gün Sayısı',
		db => 'n11_gun',
		stil => 'normaltext',
		info => 'Eğer üründe farklı bir tanım yoksa geçerli olur. Buraya bir değer girilmezse, varsayılan gün 3 olarak gönderilir.',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Asgari Ürün Tutarı',
		db => 'n11_asgari',
		info => 'Örneğin 100 girilirse, 100 TL altı ürünler N11\'e gönderilmez.',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Zorunlu Olmayan Ürün Seçimlerini de Getir',
		db => 'n11_zorunlu',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Spec girilmeyen ürünleri, kategorideki diğer ürünler ile eşitle',
		info=>'İşaretlendiğinde spec girilmeyen ürünlerde, aynı kategorideki diğer ürünlerin specleri baz alınır. Böylece yeni girilen bir ürün, spec seçilmediği halde otomatik eklenebilir. Eğer kategori ürünleriniz farklı spec seçimleri gerektiriyorsa bu kısmı aktif etmeyin.',
		db => 'n11_esitle',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Ürünleri Gerçek Zamanlı Gönder',
		db => 'n11_hemen',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
);
if($_POST['n11_username'])
{
	my_mysql_query("update urun set n11up=1 where barkodNo_n11 != ''");
}
admin($dbase, $where, $icerik, $ozellikler);

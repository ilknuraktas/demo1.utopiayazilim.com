<?php
$dbase = "siteConfig";
$title = 'Sosyal Medya Ayaları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Sosyal Medya Tanıtım Resmi',
		db => 'ogimage',
		stil => 'file',
		uploadto => 'images/',
		info => 'Sosyal medyada share edildiğiniz bu resim gözükür.',
		gerekli => '0'
	),
	array(
		isim => 'Facebook Page URL',
		db => 'facebook_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Site Girişinde Facebook Page Like Popup Ekle',
		db => 'facebook_Popup',
		info=>'Facebook Page URL tanımlandığında, kullanıcıya like edebileceği page, her session\'da bir defa kullanıcıya POP-UP ile gösterilir. Spalsh Screen reklam aktifken, 2. popup olarak bunu aktif edilmesi tavsiye edilmez.',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Siteye Facebook Float Button Ekle',
		db => 'facebook_Floating',
		info=>'Sitenin sağ tarafında, tıklandığında açılan bir facebook like ekranı gösterilir.',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Twitter Page URL',
		db => 'twitter_URL',
		stil => 'normaltext',
		gerekli => '0'
	),

	/*
				array(isim=>'Twitter Username',
					  db=>'twitter_Username',
					  stil=>'normaltext',
					  gerekli=>'0'),				  
				array(isim=>'Twitter Consumer Key<br /><a href="http://www.pontikis.net/blog/auto_post_on_twitter_with_php" target="_blank">pontikis.net</a>',
					  db=>'twitter_ckey',
					  stil=>'normaltext',
					  gerekli=>'0'),	
				array(isim=>'Twitter Consumer Secret',
					  db=>'twitter_csecret',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Twitter Access Token',
					  db=>'twitter_akey',
					  stil=>'normaltext',
					  gerekli=>'0'),	
				array(isim=>'Twitter Access Token Secret',
					  db=>'twitter_asecret',
					  stil=>'normaltext',
					  gerekli=>'0'),
					  */
	array(
		isim => 'Youtube Page URL',
		db => 'youtube_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram Feed Access Token',
		db => 'instagram_token',
		info=>'Bu kısmı eğer instagram modülü yüklü ise doldurun. Token bilginizi almak için <a href="http://services.chrisriversdesign.com/how-to-instagram-graph-api-token/" target="_blank">tıklayın</a>.',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram UserID',
		db => 'instagram_UserID',
		info=>'Bu kısmı eğer instagram modülü yüklü ise doldurun. Instagram UserID bilginizi almak için <a href="https://www.instafollowers.co/find-instagram-user-id" target="_blank">tıklayın</a>.',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram Username',
		db => 'instagram_Username',
		info=>'Bu kısmı eğer instagram modülü yüklü ise doldurun.',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram Page URL',
		db => 'instagram_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Google + Page URL',
		db => 'google_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'LinkedIn Page URL',
		db => 'linkedin_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Pinterest Page URL',
		db => 'pinterest_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	/*
	array(
		isim => 'Admitad Campaign Code (Sipariş Sonrası Bildirim)',
		db => 'admitadCapaignCode',
		stil => 'normaltext',
		gerekli => '0'
	),

	array(
		isim => 'Bilio Account GUID (Sipariş Sonrası Bildirim)',
		db => 'bilioAccountGUID',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Criteo Tracking Account ID',
		db => 'criteoAccountID',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'User Insider Tarcking Aktif',
		db => 'userInsiderTracker',
		info => '"Head İçerisine Eklenti Kodu" kısmına User Insider kodunun eklenmiş ve insider-sw-sdk.js dosyasının FTP ana dizinine kopyalanmış olması gerekir.',
		stil => 'checkbox',
		gerekli => '0'
	),
	*/
	array(
		isim => 'Pinterest Tarcking Aktif',
		db => 'pinterestTracker',
		info => 'Google Ayarları panelindeki "Head İçerisine Eklenti Kodu" kısmına Pinterest kodunun eklenmiş olması gerekir.',
		stil => 'checkbox',
		gerekli => '0'
	),
);
$tempInfo .= adminInfov5('Tüm sosyal medya URL adresleri https:// ile başlayarak girilmelidir.');
if ($_POST['facebook_URL'])
	$_SESSION['facebookPopup'] = 0;
admin($dbase, $where, $icerik, $ozellikler);

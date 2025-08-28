<?
$dbase = "siteConfig";
$title = 'E-Posta Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Gönderen E-Posta Başlığı',
		db => 'mailFrom',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Yönetici E-Posta Ad.',
		db => 'adminMail',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Sipariş Bilgi E-Posta Ad.',
		db => 'siparisMail',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'İletişim Bilgi E-Posta Ad.',
		db => 'iletisimMail',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'E-Postalar için SMTP Sunucusu Kullan',
		db => 'SMTP_kullan',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'E-Postaları Gerçek Zamanlı Gönder',
		db => 'SMTP_hemen',
		info => 'İşaretlendiğinde e-postalar gerçek zamanlı gönderilir. Diğer türlü sıra ile cron servisinden gönderilir. Sunucunda aralıklı SMTP bağlantı problemi olanlarda aktif edilmemelidir.',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'SMTP Sunucu',
		db => 'SMTP_server',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Port',
		db => 'SMTP_port',
		defaultValue => '25',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Kullanıcı Adı',
		db => 'SMTP_username',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Şifre',
		db => 'SMTP_password',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Sunucu Güvenliği',
		db => 'SMTP_secure',
		stil => 'simplepulldown',
		simpleValues => '|Normal,ssl|SSL,tls|TLS',
		gerekli => '1'
	),
	array(
		isim => 'E-Posta Reklam Resim',
		db => 'epostabanner',
		info=>'Bir resim girilirse, her e-posta sonunda reklam olarak bu banner eklenir. Resmin eni 600px olmalıdır. Resmin boyutu konusunda bir sınır olmamakla birlikte 200-300px aralığında olması tavsiye edilir.',
		stil => 'file',
		uploadto => 'images/'
	),
	array(
		isim => 'E-Posta Reklam URL',
		db => 'epostabannerURL',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	/*
	array(
		isim => 'MadMimi API Kullanıcı Adı',
		db => 'madmimi_username',
		info=>'MadMimi API Entegrasyonu sadece e-bülten gönderimlerinde kullanılmaktadır.',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'MadMimi API Şifre',
		db => 'madmimi_password',
		info=>'MadMimi API Entegrasyonu sadece e-bülten gönderimlerinde kullanılmaktadır.',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	*/
	array(
		isim => 'E-Posta Şablon Footer Info',
		db => 'footer',
		multilang => true,
		stil => 'HTML',
		gerekli => '0'
	),
	array(
		isim => 'Tek IP için Günlük E-Posta Limiti',
		db => 'mailiplimit',
		info =>'Boş bırakırsak sınır olmaz. 20 girersek x IP üzerinden o gün site içerisinde en fazla 20 e-posta gönderimi yapılabilir. (Yönetici girişi yapanlarda bu limit uygulanmaz.)',
		multilang => true,
		stil => 'normaltext',
		gerekli => '0'
	),

	array(
		isim => 'PHP Mailer Sürüm',
		db => 'phpMailer',
		stil => 'simplepulldown',
		align => 'left',
		info =>'Bazı sunucu ayarları nedeniyle sadece bir sürüm PHPMailer ile düzgün çalışmaktadır. Bir sürüm ile sorun yaşıyorsanız, diğer PHPMailer sürümünü seçin.',
		width => 40,
		simpleValues => '5|v5,8|v8',
		gerekli => '1'
	),

	array(
		isim => 'Toplu E-Posta Gönderimi',
		db => 'gonderilenEpostaSayisi',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '50|Bir Seferde 50 E-Posta,100|Bir Seferde 100 E-Posta,250|Bir Seferde 250 E-Posta,500|Bir Seferde 500 E-Posta,0|Tümü Tek Seferde',
		gerekli => '1'
	),

);

$tempInfo .= adminInfov5('Yandex ve Google gibi e-posta sunucularını kullanabilmek için, sunucunuzda "SMTP Restrictions" pasif durumda olmalıdır. Bu ayarı Tweak Settings altındaki Mail Fonksiyonu Ayarlarından kişiselleştirebilirsiniz.','envelope');
echo adminv5($dbase, $where, $icerik, $ozellikler);
?>
<?
$dbase = "siteConfig";
$title = 'Akakçe Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);
if (!file_exists('../include/mod_Akakce.php'))
	$tempInfo .= adminWarnv3('Paketinize Akakçe Entegrasyon Modülü bulunmamaktadır.');
else {
	$tempInfo .= adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <strong>http://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-akakce.php</strong> URL adresinin, en az 5dk, en fazla 15dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null http://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'cron-akakce.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
}
$icerik = array(

	array(
		isim => 'API Kullanıcı Adı',
		db => 'akakce_username',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'API Şifre',
		db => 'akakce_password',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Varsayılan Gönderilen Kargo Firması',
		db => 'akakce_kargoID',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '1|Yurtiçi Kargo,2|Aras Kargo,3|Sürat Kargo,4|UPS Kargo,5|MNG Kargo,6|PTT Kargo,7|Horoz Lojistik,8|Ceva Lojistik,9|Borusan Lojistik,10|Tezel Lojistik',
		gerekli => '1'
	),
);
admin($dbase, $where, $icerik, $ozellikler);
?>
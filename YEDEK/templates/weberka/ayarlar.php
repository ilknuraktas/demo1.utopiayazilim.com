<?
$dbase = "temp_weberka";
$tempInfo.=adminInfo('Bu şablona <a href="s.php?f=bannerYonetim.php">"Banner Yönetiminden"</a> kolayca banner ekleyebilirsiniz. Ekleyebileceğiniz banner kodları; 
<br /><br />
<strong>index-1</strong><br />
<strong>index-2</strong><br />
<strong>index-3</strong><br />
<strong>index-buyuk</strong><br />
');

$icerik = array(
	array(
		isim => 'Index Footer Yazısı',
		db => 'footerSEO',
		unlist => true,
		stil => 'textarea',
		multilang => true,
		rows => '4',
		cols => '64'
	),
);

<?
$title = ucfirst($siteConfig['templateName']).' Tema Ayarları';
include('../templates/'.$siteConfig['templateName'].'/ayarlar.php');
if(!file_exists('../templates/'.$siteConfig['templateName'].'/ayarlar.php'))
	echo adminInfo('Şablonunuzda özel ayar dosyası bulunmamaktadır.');
if(!hq("select ID from $dbase order by ID desc limit 0,1"))
	my_mysql_query("insert into $dbase (ID) values (null)");
if(!$dbase)
	$dbase="temp_".strtolower($siteConfig['templateName']);	
	
	$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);
admin($dbase,$where,$icerik,$ozellikler);
?>
<?
$dbase="siteConfig";
$title = 'Dropshipping Ayaları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(

				array(isim=>'Asgari Ödeme Talebi (TL)',
					  db=>'ds_min',
					  stil=>'normaltext',
					  gerekli=>'0'),

				array(isim=>'Banlı IP\'ler (Ör : 192.100.*)',
					  db=>'ds_ban',
					  stil=>'textarea',
					  style=>'width:510px; height:100px;',
					  gerekli=>'0'),
				array(isim=>'Dropshipping Üyelik Kuralları',
					  db=>'ds_kural',
					  stil=>'textarea',
					  style=>'width:510px; height:100px;',
					  gerekli=>'0'),
				array(isim=>'Dropshipping Aktif',
					  db=>'ds_active',
					  stil=>'checkbox',
					  gerekli=>'0'),	
				
				);
				


if (file_exists('../include/lib-dropshipping.php'))
{
	admin($dbase,$where,$icerik,$ozellikler);
}
else
{
	echo v4Admin::adminHeader();
	echo v4Admin::fullBlock('Hata','Paketinizde affilate desteği bulunmuyor.');
}
?>
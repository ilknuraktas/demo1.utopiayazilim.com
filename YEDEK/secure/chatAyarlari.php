<?
$dbase="siteConfig";
$title = 'Canlı Destek Ayaları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(
				array(isim=>'Chat Adı',
					  db=>'chat_name',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Giriş Yazısı',
					  db=>'chat_welcome',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Chat Zamanaşımı (Saniye)',
					  db=>'chat_chattimeout',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Log Zamanaşımı (Gün)',
					  db=>'chat_logtimeout',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Online Logo',
					  db=>'chat_imgonline',
					  stil=>'file',
					  uploadto=>'images/',
					  gerekli=>'0'),
				array(isim=>'Offline Logo',
					  db=>'chat_imgoffline',
					  stil=>'file',
					  uploadto=>'images/',
					  gerekli=>'0'),
				array(isim=>'Canlı Destek Aktif',
					  db=>'chat_active',
					  stil=>'checkbox',
					  gerekli=>'0'),	
				
				);

if(!modVarMi('canlidestek'))
{
	$tempInfo.=adminWarnv3('Paketinizde Canlı Destek modülü bulunmuyor. ');			
	
}
else
{	
	$tempInfo.=adminInfov3('Online destek konuşma loglarını, istatistikler menüsü altındaki <a href="s.php?f=chatLog.php"><strong>Canlı Destek Logları</strong></a> kısmından inceleyebilirsiniz.');
	$chatLoginScript = "<script>
	$('.shortcuts-icons:first').html('<a class=\"button-green\" href=\"#\" onclick=\"window.open(\'../include/3rdparty/CanliDestek/chatadmin.php\',\'destek\'); return false;\">Canlı Desteği Aç</a>');
</script>";
}
admin($dbase,$where,$icerik,$ozellikler);
echo $chatLoginScript;
?>
<?                                                                                                                               
$dbase="siteConfig";
$title = 'StockMount Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);
if(!file_exists('../include/mod_StockMount.php'))
	$tempInfo.=adminWarnv3('Paketinize StockMount Entegrasyon Modülü bulunmamaktadır.');
$icerik = array(
				array(isim=>'API Kullanıcı Adı',
					  db=>'sm_username',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'API Şifre',
					  db=>'sm_password',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>
<?                                                                                                                               
$dbase="siteConfig";
$title = 'Firebase Notification Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);
$tempInfo.= adminInfov3('Ayarlarınızı kaydettikten sonra, <a href="s.php?f=pn.php" target="_blank">buraya tıklayarak</a>, onay veren kullanıcılarınıza anlık notification gönderebilirsiniz.');

$icerik = array(
	
				array(isim=>'Notification Logo',
				db=>'pc_logo',
				stil=>'file',
				uploadto=>'images/',
				gerekli=>'0'),
	
				array(isim=>'Firebase API Access Key',
					  db=>'pc_key',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'Firebase JS Code',
					  db=>'pc_code',
					  stil=>'textarea',
					  style=>'width:510px; height:100px;',
					  gerekli=>'0'),

			 	);
				admin($dbase,$where,$icerik,$ozellikler);


?>
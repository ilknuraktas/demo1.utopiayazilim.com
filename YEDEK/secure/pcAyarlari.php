<?                                                                                                                               
$dbase="siteConfig";
$title = 'PushCrew Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$tempInfo.= adminInfov3('PushCrew, Chrome (Desktop veya Android Mobile) kullanıcılarına anlık bilgilendirme gönderebilmek için bir altyapıdır.');
$tempInfo.= adminInfov3('1 - <a href="https://pushcrew.com/free-push-notifications-account/" target="_blank">https://pushcrew.com/free-push-notifications-account/</a> adresinden üye olup, giriş yapın. ');	
$tempInfo.= adminInfov3('2 - <a href="https://pushcrew.com/admin/settings-customize.php" target="_blank">https://pushcrew.com/admin/settings-customize.php</a> adresinden kişiselleştirmelerinizi yaptın. ');
$tempInfo.= adminInfov3('3 - <a href="https://pushcrew.com/admin/settings-apiaccess.php" target="_blank">https://pushcrew.com/admin/settings-apiaccess.php</a> adresindeki token değerini, ilgili alana girin. ');
$tempInfo.= adminInfov3('4 - <a href="https://pushcrew.com/admin/dashboard.php" target="_blank">https://pushcrew.com/admin/dashboard.php</a> adresindeki <strong>"Copy and Paste this code before </head> tag on your website page(s)."</strong> altındaki kısmı, aşağıdaki <strong>"PushCrew JS Code"</strong> alanına paste edin.');
$tempInfo.= adminInfov3('5 - Artık <a href="s.php?f=pc.php" target="_blank">buraya tıklayarak</a> kullanıcılarımıza anlık notification gönderebiliriz.');

$icerik = array(
	array(isim=>'PushCrew Logo (192 x 192 PNG)',
	db=>'pc_logo',
	stil=>'file',
	uploadto=>'images/',
	gerekli=>'0'),
				array(isim=>'PushCrew API Token ( <a href="https://pushcrew.com/admin/settings-apiaccess.php" target="_blank">https://pushcrew.com/admin/settings-apiaccess.php</a> )',
					  db=>'pc_token',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'PushCrew JS Code ( <a href="https://pushcrew.com/admin/dashboard.php" target="_blank">https://pushcrew.com/admin/dashboard.php</a> ) ',
					  db=>'pc_code',
					  stil=>'textarea',
					  style=>'width:510px; height:100px;',
					  gerekli=>'0'),

			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>
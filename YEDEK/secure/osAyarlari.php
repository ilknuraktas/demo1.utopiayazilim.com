<?                                                                                                                               
$dbase="siteConfig";
$title = 'OneSignal Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);
/*
$tempInfo.= adminInfov3('PushCrew, Chrome (Desktop veya Android Mobile) kullanıcılarına anlık bilgilendirme gönderebilmek için bir altyapıdır.');
$tempInfo.= adminInfov3('1 - <a href="https://pushcrew.com/free-push-notifications-account/" target="_blank">https://pushcrew.com/free-push-notifications-account/</a> adresinden üye olup, giriş yapın. ');	
$tempInfo.= adminInfov3('2 - <a href="https://pushcrew.com/admin/settings-customize.php" target="_blank">https://pushcrew.com/admin/settings-customize.php</a> adresinden kişiselleştirmelerinizi yaptın. ');
$tempInfo.= adminInfov3('3 - <a href="https://pushcrew.com/admin/settings-apiaccess.php" target="_blank">https://pushcrew.com/admin/settings-apiaccess.php</a> adresindeki token değerini, ilgili alana girin. ');
$tempInfo.= adminInfov3('4 - <a href="https://pushcrew.com/admin/dashboard.php" target="_blank">https://pushcrew.com/admin/dashboard.php</a> adresindeki <strong>"Copy and Paste this code before </head> tag on your website page(s)."</strong> altındaki kısmı, aşağıdaki <strong>"PushCrew JS Code"</strong> alanına paste edin.');
$tempInfo.= adminInfov3('5 - Artık <a href="s.php?f=pc.php" target="_blank">buraya tıklayarak</a> kullanıcılarımıza anlık notification gönderebiliriz.');
*/

$tempInfo.= adminInfov3('OneSignal, Chrome / Firefox (Desktop veya Android Mobile) kullanıcılarına anlık bilgilendirme gönderebilmek için bir altyapıdır.');
$tempInfo.= adminInfov3('1 - <a href="https://onesignal.com/" target="_blank">https://onesignal.com/</a> adresinden üye olup, giriş yapın. ');
$tempInfo.= adminInfov3('2 - Kayıt sonrasında gelen ekrandan "Add a new App" ekranına tıklayın. Gelen ekranda site adınızı yazın. Ör : ShopPHP ');
$tempInfo.= adminInfov3('3 - Select Platform ekranıdnan "WebsitePush" iconuna tıklayın. Sonraki ekrandan "Google Chrome & Mozilla Firefox" iconuna tıklayın. ');
$tempInfo.= adminInfov3('4 - Configura Platform ekranında web sitesi adresinizi (destekliyorsa https ile) ve notification için gözükecek icon dosyası adresinizi girin. ');
$tempInfo.= adminInfov3('5 - Select SKD ekranında, "Server API" iconuna tıklayın. Gelen API bilgisini aşağıdaki OneSignal APP ID alanına girin. ');



$icerik = array(
				array(isim=>'OneSignal APP ID',
					  db=>'pc_token',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				/*
				array(isim=>'PushCrew JS Code ( <a href="https://pushcrew.com/admin/dashboard.php" target="_blank">https://pushcrew.com/admin/dashboard.php</a> ) ',
					  db=>'pc_code',
					  stil=>'textarea',
					  style=>'width:510px; height:100px;',
					  gerekli=>'0'),
				array(isim=>'PushCrew Logo (192 x 192 PNG)',
					  db=>'pc_logo',
					  stil=>'file',
					  uploadto=>'images/',
					  gerekli=>'0'),
				*/
			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>
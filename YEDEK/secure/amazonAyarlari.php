<?                                                                                                                               
$dbase="siteConfig";
$title = 'Amazon Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(

				array(isim=>'Satıcı Kimliği',
					  db=>'amazon_merchant_id',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'Pazar Yeri Kimliği',
					  db=>'amazon_marketplace_id',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'MWS Yetkilendirme Kodu',
					  db=>'amazon_mws_auth_token',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 					  
				array(isim=>'Fiyat Tablosu',
					  db=>'amazon_fiyatAlani',
					  stil=>'simplepulldown',
					  align=>'left',
					  info=>'Üründe, seçime ait bir fiyat girilmemişse ana fiyat geçerli olur.',
					  width=>80,
					  simpleValues=>'0|Normal Fiyat,1|Fiyat 1,2|Fiyat 2,3|Fiyat 3,4|Fiyat 4,5|Fiyat 5',
					  gerekli=>'1'),
				array(isim=>'Otomatik Fiyat Ekleme için Azami Ürün Tutarı',
					  db=>'amazon_azami',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Otomatik Fiyat Ekle (TL)',
					  db=>'amazon_fiyat',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Otomatik Oran Ekle (Ör: 0.2 = %20)',
					  db=>'amazon_oran',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Ürünleri Gerçek Zamanlı Gönder',
					  db=>'amazon_hemen',
					  stil=>'checkbox',
					  width=>29,
					  gerekli=>'0'), 	
			 	);
				if(!file_exists('../include/mod_Amazon.php'))
					$tempInfo.= adminWarnv3('Paketinize mod_Amazon Entegrasyon Modülü bulunmamaktadır.');
				$tempInfo.= adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <strong>http://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron-amazon.php</strong> URL adresinin, en az 1dk, en fazla 5dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null http://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron-gg.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
				$tempInfo.= adminInfov3('Amazon entegrasyonu için sunucunuzda SOAP ext. desteğinin aktif olması gerekmektedir.');
				$tempInfo.= adminInfov3('Amazon Role kullanıcı adı ve şifresini "API entegrasyon desteği" kullanılacağını belirtip Amazon firmasından talep edilmelidir. Api role kullanıcı adı ve şifre, Amazon sitesine giriş yaparken kullandığınız kullanıcı adı ve şifre değildir.');
				$tempInfo.= adminInfov3('Amazon entegrasyona sadece *Amazon kodu tanımlanmış kategorilerdeki* ürünler gönderilmektedir.');
				$tempInfo.= adminInfov3('Amazon Otomatik Oran Ekle (Ör: 0.2 = %20) girişi, ilgili kategoride, "Varsayılan Çıkış Kar Marjı" girilmeyen ürünller için geçerlidir. Bir kategoriye "Varsayılan Çıkış Kar Marjı" tanımlıysa, o geçerli olur.');
				if(!class_exists("SOAPClient"))
					$tempInfo.=adminErrorv3('Sunucunuzda SOAP yüklü veya aktif değil. API entegrasyonu kullanabilmek için SOAP özelliğinin aktif olması gerekiyor. Sunucu yöneticinize bunu ileterek SOAP desteğini aktif edebilirsiniz.');
				admin($dbase,$where,$icerik,$ozellikler);
				//if ($_POST['y'] == 'du') echo "<script>$(document).ready(function() { window.location.href = 'gg.php'; });</script>";
?>
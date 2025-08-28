<? 
$dbase="kampanyaBannerConfig";
$title = 'Vitrin Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					rowid=>1,
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					);

$icerik = array(
				array(isim=>'Seçim Ekranı',
					  db=>'secim',
					  stil=>'simplepulldown',
					  simpleValues=>'numbers|Sayılar,images|Resimler',
					  gerekli=>'1'),				  
				array(isim=>'Maximum Resim Eni',
					  db=>'resimen',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),				
				array(isim=>'Maximum Resim Boyu',
					  db=>'resimboy',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),	
				array(isim=>'Thumbnail Resim Eni',
					  db=>'thumben',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),				
				array(isim=>'Thumbnail Resim Boyu',
					  db=>'thumbboy',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),				  			
				array(isim=>'Efekt',
					  db=>'effect',
					  stil=>'simplepulldown',
					  simpleValues=>'fade,zoom,squeeze,pixeldissolve,blinds,wipe,iris,photo,fly',
					  gerekli=>'1'),
				array(isim=>'Numara Pozisyonu',
					  db=>'pozisyon',
					  stil=>'simplepulldown',
					  simpleValues=>'left|Sol,right|Sağ,top|Üst,bottom|Alt',
					  gerekli=>'1'),
				array(isim=>'Resim Geçiş Hızı (Saniye)',
					  db=>'hiz',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),	
					  		
			 	);
echo adminInfo('Bu ayarlar Flash vitrin kullanan şablonlarda (green,hean,clean) etkindir.');
admin($dbase,$where,$icerik,$ozellikler);
generateCampXML();
?>
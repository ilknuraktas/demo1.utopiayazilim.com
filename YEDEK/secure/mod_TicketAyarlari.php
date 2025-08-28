<?
$dbase="ticketConfig";
$title = 'Ticklet Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(

				array(isim=>'Açık Ticket Limiti',
					  db=>'ulimit',
					  info=>'Ör : Buraya 5 girilirse, kullanıcı 5 *açık* ticket sayısına ulaştığında, ticketlar kapanmadan yeni ticket açamaz.',
					  multilang=>true,
					  stil=>'normaltext',
					  gerekli=>'0'),

				array(isim=>'Ticket Cevap Süresi',
					  db=>'dlimit',
					  info=>'Ör : Buraya 30 girilirse, kullanıcı kapanmış olan bir ticketa 30 gün sonra yeni bir mesaj ekleyemez.',
					  multilang=>true,
					  stil=>'normaltext',
					  gerekli=>'0'),
					  
				array(isim=>'Ticket Mod Aktif',
					  db=>'active',
					  stil=>'checkbox',
					  gerekli=>'0'),	
						  						 	);
				
if(!hq("select ID from ticketConfig"))
	my_mysql_query("insert into ticketConfig (ID) values (1)");
echo adminv3($dbase,$where,$icerik,$ozellikler);
?>
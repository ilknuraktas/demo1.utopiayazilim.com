<? 
//my_mysql_query("INSERT INTO `adminmenu` (`ID`, `parentID`, `Adi`, `Icon`, `Dosya`, `Aktif`, `Sira`, `SiteTipi`) VALUES ('0', '58', 'Promosyon Çarkı', '', 'mod_ProCark.php', '1', '60', '');");
$dbase="procark";
$title='Promosyon Çarkı';
$listTitle = 'Promosyonlar';

$ozellikler = array(ekle=>1, 
					baseid=>'ID',
					orderby=>'ID',
					sil=>1,
					orderdesc=>'desc'
					);

$icerik = array(

				array(isim=>'Başlık',
					  db=>'title',					 
					  width=>80,					  
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'İndirim Oranı',
					  info=>'İndirim Oranı ve Tutarı kısmından sadece biri doldurulmalıdır. Bu panele ör : %5 için 0.05 girilmelidir.',
					  width=>69,
					  db=>'percent',
					  unlist=>true,
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'İndirim Tutarı',
					  info=>'İndirim Oranı ve Tutarı kısmından sadece biri doldurulmalıdır. Tutar TL bazındadır.',
					  db=>'ammount',
					  unlist=>true,
					  stil=>'normaltext',
					  gerekli=>'1')
			 	);

if($_GET['y'] && !$_POST['code'])
{
	echo adminInfo('İndirim Tutarı veya İndirim Oranından sadece bir tanesini girin.');
	echo adminInfo('İndirim oranında Ör : %10 indirim için 0.1 girin.');
	echo adminInfo('Tutar Bilgileri TL bazındandır.');
}
else
{
	echo adminInfo('Promosyon çarkı ile müşterileriniz, onaylı siparişlerinin hemen ardından gelen e-posta ile promosyon çarkı sayfasına giriş yaparak, girdiğiniz promosyonlardan birini kazanır. Promosyon çarkının kullanılabilmesi için <a href="s.php?f=sepetAyarlari.php"><strong>Sepet Ayarları</strong></a> panelinden aktif edilmesi gerekir. Girişleri yaptıktan sonra test etmek için <a target="_blank" href="../'.slink('procark','demo').'"><strong>buraya</strong></a> tıklayın.');
}
admin($dbase,$where,$icerik,$ozellikler);
?>
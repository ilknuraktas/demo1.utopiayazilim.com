<?

$dbase="siteConfig";

$title = 'Watermark Ayarları';

$ozellikler = array(ekle=>'0', 

					baseid=>'ID',

					listDisabled => true,

					listBackMsg => 'Kaydedildi',

					editID=>1,

					);



$icerik = array(

				array(isim=>'PNG Logo',

					  db=>'wm_resim',

					  stil=>'file',

					  info=>'Logo veya yazıdan bir tanesi eklenmelidir.',

					  uploadto=>'images/',

					  unlist=>true,

					  gerekli=>'0'),

				array(isim=>'Watermark Pozisyonu',

					  db=>'wm_pos',

					  stil=>'simplepulldown',

					  align=>'left',

					  width=>40,

					  simpleValues=>'5|Resmi Ortala,1|Sol Üst,2|Sağ Üst,3|Sol Alt,4|Sağ Alt',

					  gerekli=>'1'),

				array(isim=>'Text Ekle',

					  db=>'wm_text',

					  info=>'Logo veya yazıdan bir tanesi eklenmelidir.',

					  stil=>'normaltext',

					  gerekli=>'0'),	

				array(isim=>'Font Rengi',

					  db=>'wm_fcolor',

					  stil=>'normaltext',

					  customType=>'color',

					  gerekli=>'0'),

				array(isim=>'Font Boyutu',

					  db=>'wm_fsize',

					  customType=>'number',

					  stil=>'normaltext',

					  gerekli=>'0'),	

				array(

						isim => 'Font Seçimi',

						db => 'wm_font',

						info=>'Yeni bir font seçeneği eklemek için, <a href="https://www.fontsquirrel.com/fonts/list/popular" target="_blank">Fontsquirrel.com</a> sitesinden yeni bir TTF font download edip, FTP üzerinden include/3rdparty/PHPThumb/fonts diznine kopyalayabilirsiniz.',

						stil => 'simplepulldown',

						align => 'left',

						width => 40,

						simpleValues => allFileList('include/3rdparty/PHPThumb/fonts/'),

						gerekli => '1'

					),					  					  

				array(isim=>'Padding (pixel)',

					  db=>'wm_padding',

					  customType=>'number',

					  stil=>'normaltext',

					  gerekli=>'0'),				

				array(isim=>'Opacity (0-100)',

					  db=>'wm_opacity',

					  customType=>'number',

					  stil=>'normaltext',

					  gerekli=>'0'),

				array(isim=>'Watermark Desteği Aktif',

					  db=>'wm_active',

					  stil=>'checkbox',

					  gerekli=>'0'),

			

			 	);

				$tempInfo.= adminInfov5('Watermark logo / text sadece resize edilen ürün resimlerine uygulanır.','image');

				$tempInfo.= adminInfov5('Watermark logo veya text girişlerinden sadece biri girilmelidir.','image');

				$tempInfo.= adminInfov5('100px\'den ufak ürün resimlerine watermark logo uygulanmaz.','image');		

				$tempInfo.= adminInfov5('Watermark kullanabilmek için, "Ayarlar &gt; <a href="s.php?f=siteAyarlari.php" target="_blank">Genel Ayarlar</a> &gt; Görünüm" panelinden Resim Boyutlandırma Seçimi, "PHP Thumb" olarak seçilmelidir.','image');		

				$tempInfo.= adminInfov5('Watermark eklediğinizde, <a href="https://sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=326&autoOpen=392" target="_blank">resmin orijinal hallerini korumak için tıklayın</a>.','image');			



				admin($dbase,$where,$icerik,$ozellikler);

?>
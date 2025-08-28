<? 

$title = 'Vitrin Resimleri';

$listTitle = 'Resim Bilgileri';

$bannerType = 'JS';

if ($siteConfig['templateName'] == 'web20') $bannerType = 'JS';

if ($siteConfig['templateName'] == 'office') $bannerType = 'JS';

if ($siteConfig['templateName'] == 'efirsatci') $bannerType = 'JS';

if ($siteConfig['templateName'] == 'fancy') $bannerType = 'JS';

if ($siteConfig['templateName'] == 'tpblue') $bannerType = 'JS';

if ($siteConfig['templateName'] == 'hean') $bannerType = 'Flash';

if ($siteConfig['templateName'] == 'green') $bannerType = 'Flash';

if ($siteConfig['templateName'] == 'clean') $bannerType = 'Flash';

if ($siteConfig['templateName'] == 'selective') $bannerType = 'Flash';

if ($siteConfig['templateName'] == 'storeplus') $bannerType = 'Flash';

if ($siteConfig['templateName'] == 'qplus') $bannerType = 'Flash';

if ($siteConfig['templateName'] == 'workshop') $bannerType = 'Flash';



if ($bannerType == 'JS') $dbase="kampanyaJSBanner";

if ($bannerType == 'Flash') $dbase="kampanyaBanner";

$ozellikler = array(ekle=>'1', 

					baseid=>'ID',

					orderby=>'seq',

					);

if ($bannerType == 'Flash') {

	$icerik = array(

				array(isim=>'Başlık',

					  db=>'title',

					  width=>300,

					  stil=>'normaltext',

					  multilang=>true,

					  gerekli=>'1'),

				array(isim=>'Resim Büyük',

					  db=>'resim',

					  stil=>'file',

					  multilang=>true,

					  uploadto=>'images/kampanya/',

					  unlist=>true,

					  gerekli=>'0'),					  

				array(isim=>'Resim Küçük',

					  db=>'thumb',

					  stil=>'file',

					  multilang=>true,

					  uploadto=>'images/kampanya/',

					  unlist=>true,

					  gerekli=>'0'),					  

				array(isim=>'Link',

					  db=>'link',

					  width=>221,

					  stil=>'normaltext',

					  gerekli=>'1'),			  				

				array(isim=>'Sıra',

					  db=>'seq',

					  width=>50,

					  stil=>'normaltext',

					  gerekli=>'1')						  

			 	);

}

if ($bannerType == 'JS') {

	$icerik = array(

				array(isim=>'Başlık #1',

					  db=>'title',

					  width=>300,

					  multilang=>true,

					  stil=>'normaltext',

					  gerekli=>'1'),

				array(isim=>'Başlık #2',

					  db=>'title2',

					  multilang=>true,

					  stil=>'normaltext',

					  unlist=>true,

					  gerekli=>'0'),

				array(isim=>'Bilgi #1',

					  db=>'info',

					  multilang=>true,

					  stil=>'normaltext',

					  unlist=>true,

					  gerekli=>'0'),

				array(isim=>'Bilgi #2',

					  db=>'info2',

					  multilang=>true,

					  stil=>'normaltext',

					  unlist=>true,

					  gerekli=>'0'),

		
    array(isim => 'Resim Mobil',

      db => 'resimMJS',

      multilang => true,

      stil => 'file',

      uploadto => 'images/kampanya/',

      unlist => true,

      gerekli => '0'),



    array(isim => 'Resim Arka Plan',

      db => 'resimBJS',

      multilang => true,

      stil => 'file',

      uploadto => 'images/kampanya/',

      unlist => true,

      gerekli => '0'),

		

				array(isim=>'Link',

					  db=>'link',

					  width=>221,

					  stil=>'normaltext',

					  gerekli=>'1'),			  				

				array(isim=>'Sıra',

					  db=>'seq',

					  width=>50,

					  stil=>'normaltext',

					  gerekli=>'1')						  

			 	);

}

admin($dbase,$where,$icerik,$ozellikler);

?>
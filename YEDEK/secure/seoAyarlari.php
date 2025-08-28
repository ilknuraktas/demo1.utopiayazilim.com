<?

$dbase="siteConfig";

$title = 'SEO Ayarları';

$ozellikler = array(ekle=>'0', 

					baseid=>'ID',

					listDisabled => true,

					listBackMsg => 'Kaydedildi',

					editID=>1,

					);



$icerik = array(

				array(isim=>'Site Başlığı',

					  db=>'seo_title',

					  multilang=>true,

					  stil=>'normaltext',

					  gerekli=>'0'),	

				array(isim=>'Meta Keywords',

					  db=>'seo_metaKeywords',

					  multilang=>true,

					  stil=>'normaltext',

					  gerekli=>'0'),					  

				array(isim=>'Meta Description',

					  db=>'seo_metaDescription',

					  multilang=>true,

					  stil=>'normaltext',

					  gerekli=>'0'),

				array(isim=>'İçerik Site Başlığı',

					  db=>'seo_icerikTitle',

					  stil=>'normaltext',

					  gerekli=>'0'),					  

				array(isim=>'İçerik Meta Keywords',

					  db=>'seo_icerikMetaKeywords',

					  stil=>'normaltext',

					  gerekli=>'0'),					  

				array(isim=>'İçerik Meta Description',

					  db=>'seo_icerikMetaDescription',

					  stil=>'normaltext',

					  gerekli=>'0'),				

				array(isim=>'Ürün Detay Site Başlığı',

					  db=>'seo_urunTitle',

					  info=>'Kullanılabilecek makrolar için <a href="//sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=325&autoOpen=16" target="_blank">tıklayın</a>.',

					  stil=>'normaltext',

					  gerekli=>'0'),					  

				array(isim=>'Ürün Detay Meta Keywords',

					  db=>'seo_urunMetaKeywords',

					  info=>'Kullanılabilecek makrolar için <a href="//sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=325&autoOpen=16" target="_blank">tıklayın</a>.',

					  stil=>'normaltext',

					  gerekli=>'0'),					  

				array(isim=>'Ürün Detay Meta Description',

					  db=>'seo_urunMetaDescription',

					  info=>'Kullanılabilecek makrolar için <a href="//sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=325&autoOpen=16" target="_blank">tıklayın</a>.',

					  stil=>'normaltext',

					  gerekli=>'0'),

				array(isim=>'Ürün Etiket',

					  db=>'seo_urunEtiket',

					  info=>'Kullanılabilecek makrolar için <a href="//sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=325&autoOpen=16" target="_blank">tıklayın</a>.',

					  stil=>'normaltext',

					  gerekli=>'0'),		  					   

				array(isim=>'Kategori Site Başlığı',

					  db=>'seo_kategoriTitle',

					  stil=>'normaltext',

					  gerekli=>'0'),					  

				array(isim=>'Kategori Meta Keywords',

					  db=>'seo_kategoriMetaKeywords',

					  stil=>'normaltext',

					  gerekli=>'0'),					  

				array(isim=>'Kategori Meta Description',

					  db=>'seo_kategoriMetaDescription',

					  stil=>'normaltext',

					  gerekli=>'0'),

				array(isim=>'SEO URL Destegi',

					  db=>'seoURL',

					  stil=>'simplepulldown',

					  align=>'left',

					  width=>40,

					  simpleValues=>'0|Kapalı,3|Sadece Başlık,1|Klasik (Sayfa-Adı.html),2|Detaylı (Kategori/Sayfa-adı.html)',

					  gerekli=>'1'),

			

			 	);

				echo adminInfo('SEO URL desteği için sunucuda apache mod_rewrite modülünün yüklü olması gerekmektedir.');

				admin($dbase,$where,$icerik,$ozellikler);

?>
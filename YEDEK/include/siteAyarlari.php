<?
$dbase = "siteConfig";
$title = 'Genel Ayarlar';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Site Başlığı',
		db => 'seo_title',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Şablon Logo',
		db => 'templateLogo',
		stil => 'file',
		uploadto => 'images/',
		gerekli => '0'
	),
	array(
		isim => 'Favicon Logo (.png)',
		db => 'favicon',
		stil => 'file',
		uploadto => 'images/',
		gerekli => '0'
	),
	array(
		isim => 'Ürün Varsayılan Resim',
		info=>'Resmi olmayan ürünlerde, site ve pazaryerlerinde varsayılan ürün resmi olarak bu gösterilir.',
		db => 'nopic',
		stil => 'file',
		uploadto => 'images/',
		gerekli => '0'
	),
	array(
		isim => 'Aktif Şablon Dizini',
		db => 'templateName',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => sablonList(),
		gerekli => '1'
	),
	array(
		isim => 'Ana Sayfa Ürün Sayısı',
		db => 'anaSayfaUrun',
		stil => 'normaltext',
		gerekli => '0'
	),

	array(
		isim => 'İç Sayfa Ürün Sayısı',
		db => 'icSayfaUrun',
		stil => 'normaltext',
		gerekli => '0'
	),

	array(
		isim => 'Liste Ürün Sayısı',
		db => 'listelemeUrun',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Panel Ürün Varyasyon Sayısı',
		db => 'var',
		stil => 'simplepulldown',
		simpleValues => '2,3,4,5,6,7,8,9,10',
		autoSelected => '2',
		info => 'Tek ürün için girilebilecek azami ürün varyasyon başlık sayısını seçin.<br />Ör : En çok varyasyon olan üründe seçimler, Renk, Beden, Kumaş ise 3 olarak girin..',
		gerekli => '0'
	),
	array(
		isim => 'Yönetici Stok E-Posta Uyarı Limiti',
		info=>'-1 girilirse uyarı gönderilmez.',
		db => 'stokMail',
		stil => 'normaltext',
		gerekli => '0'
	),

	array(
		isim => 'Kritik Stok',
		db => 'cstok',
		info=>'Ör : 3 girilirse, 3 stok ve altında düştüğünde satış yapılmaz.',
		stil => 'normaltext',
		gerekli => '0'
	),

	/*
	array(
		isim => 'Kategori Sayfalama Tipi',
		db => 'useAjaxPager',
		stil => 'simplepulldown',
		simpleValues => '0|Ürün/Sayfa sayısına göre listeme,1|Ajax ile sınırsız listeleme',
		autoSelected => '1',
		gerekli => '0'
	),
	*/
	array(
		isim => 'Kategori Listeleme',
		db => 'listType',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '0|Detay ve Liste,1|Sadece Ürün Detay,2|Sadece Ürün Liste',
		gerekli => '1'
	),
	/*				  
				array(isim=>'Upload İzinli Uzantılar',
					  db=>'uploadAllowed',
					  stil=>'normaltext',
					  gerekli=>'0'),	
	 */
	array(
		isim => 'Kişisel Verilerin Korunması Kuralları',
		db => 'kvkk',
		stil => 'textarea',
		multilang => true,
		gerekli => '0'
	),
	array(
		isim => 'Üyelik Kuralları',
		db => 'uyelikKural',
		stil => 'textarea',
		multilang => true,
		gerekli => '0'
	),
	array(
		isim => 'Satın Alma Kuralları',
		db => 'satinalKural',
		stil => 'textarea',
		multilang => true,
		info => ($disablehelp ? '' : 'Kullanılabilecek makro listesi için <a href="https://yardim.shopphp.net/page.php?act=kategoriGoster&katID=327&autoOpen=174" target="_blank">tıklayın</a>.'),
		gerekli => '0'
	),
	
	array(
		isim => 'Mesafeli Ön satış Sözleşmesi',
		db => 'onKural',
		multilang => true,
		stil => 'textarea',
		info => ($disablehelp ? '' : 'Kullanılabilecek makro listesi için <a href="https://yardim.shopphp.net/page.php?act=kategoriGoster&katID=327&autoOpen=174" target="_blank">tıklayın</a>.'),
		gerekli => '0'
	),
	
	array(
		isim => 'Resim Boyutlandırma Seçimi',
		db => 'digerparabirim',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '3|C-Image (+Cache),|PHP Thumb (+Cache +Watermark),2|Tim Thumb (+Cache),4|Direkt Cache Dosyasından Okuma,1|Direkt Boyutlandırma (Cache Yok)',
		gerekli => '1'
	),
	array(
		isim => 'Resim Boyutlandırma Tipi',
		db => 'resizeconfig',
		info => 'Resim boyutlandırma C-Image,PHPThumb veya TimThumb seçildiğinde geçerli olur.',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '0|Orijinal : Resmi orantıyı koruyarak boyutlandırır.,1|Strech : Resmi verilen en ve boya göre orantıyı korumadan boyutlandırır.,2|Crop To Fit : Resmi boyutlandırırken fazla kısımları siler.,3|Fill to Fit : Resmi boyutlandırırken fazla olan kısmı silmez ve diğer alana arka olan rengi ekler.',
		gerekli => '1'
	),

	array(
		isim => 'Form Koruma',
		db => 'captcha',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		info => 'Google reCAPTCHA v2 seçildiğinde, <a href="s.php?f=googleAyarlari.php">Google Ayarları</a> kısmından ilgili KEY bilgilerini girmek gerekmektedir.',
		simpleValues => '0|Captcha Kapalı,2|Google reCAPTCHA v2',
		gerekli => '1'
	),

	array(
		isim => 'Canlı İstatistikler',
		db => 'onLoad',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '0|Kapalı,1|Açık (İşlemci kullanımı artar)',
		gerekli => '1'
	),
	array(
		isim => 'HTTPS (SSL) Aktif',
		db => 'httpsAktif',
		stil => 'simplepulldown',
		info=>'Kredi kartı ödemesi alınacaksa, mutlaka aktif olmalıdır.',
		simpleValues => '0|Pasif (SSL Kurulu Değil),1|Akfit (SSL Kurulu)',
		gerekli => '0'
	),
	array(
		isim => 'Otomatik www Yönlendirme Aktif',
		db => 'wwwAktif',
		stil => 'checkbox',
		info => 'Sunucunda .htaccess ile yönlendirme desteği yoksa, işaretlemeniz tavsiye edilir.',
		gerekli => '0'
	),
	
	array(
		isim => 'Tek Sonuçlu Aramaları Yölendir.',
		db => 'aramaredirect',
		stil => 'checkbox',
		info => 'Arama sonucunda tek ürün geliyorsa, arama sonuçları yerine ürün detay ekranına yönlendirilir. ',
		gerekli => '0'
	),
	
	array(
		isim => 'Ürün Yorumları İçin Facebook Kullan',
		db => 'facebookYorum',
		stil => 'checkbox',
		gerekli => '0'
	),
	/*array(isim=>'Ürün Yorumları Onay Gerektirir (Facebook Seçiminde Pasif Olur.)',
					  db=>'urunOnay',
					  stil=>'checkbox',
					  gerekli=>'0'),
	 */
	array(
		isim => 'Üyelik E-Posta Onay Gerektirir',
		db => 'uyeOnay',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Üyelik SMS Onay Gerektirir',
		db => 'smsOnay',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Sadece Üyeler Girebilir',
		db => 'sadeceUye',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Fiyatları Sadece Üyeler Görebilir',
		db => 'fiyatUyelikZorunlu',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Giriş yaş onayı gerektirir',
		db => 'yasOnay',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Yeni Üyeliklerde Yöneticiyi Bilgilendir',
		db => 'uyeAdminMail',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Sipariş İçin Üyelik Zorunlu',
		db => 'uyelikZorunlu',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Ürün Yorum İçin Üyelik Zorunlu',
		db => 'yorumUyelikZorunlu',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Üyeliksiz Siparişlerde Otomatik Üye Kaydet',
		db => 'autoRegister',
		stil => 'checkbox',
		gerekli => '0'
	),
	
	array(
		isim => 'Resim Lazyload Aktif',
		db => 'captchaClose',
		info=>'Sadece desteklenen şablonlarda aktif olur. Ana sayfada resim görüntülenemiyorsa bunu pasif edin.',
		stil => 'checkbox',
		gerekli => '0'
	),
	
	array(
		isim => 'Sepete Tek Marka Eklenebilir',
		db => 'privateSepetMarkaKontrol',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Formları İki Sütun Halinde Göster',
		db => 'formv2',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Yönetici için Ürün Detay Sayfasına Düzenle Button Ekle',
		db => 'urunduzenle',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),

	array(
		isim => 'URL Yönlendirme Kontorlü Aktif',
		info => '<a href="s.php?f=yonlendir.php">Buraya tıklayarak</a>, yönlendirilecek URL adreslerini girebilirsiniz.',
		db => 'urlredirect',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Dil Otomatik Yönlendirme Aktif',
		info => 'Çoklu dil desteği olan paketlerde geçerlidir.',
		db => 'autolang',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Cookie İçin Onay Bilgisi Aktif.',
		db => 'cookie',
		info => 'Yurtdışına satış yapan siteler için.',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Yabancı Kredi Kartına Kapalı',
		db => 'fcccheck',
		info => 'İşaretlenirse, yabancı kredi kartları ile ödeme alınmaz.',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Footer Yazılım Bilgisini Gizle',
		db => 'telif-footer',
		stil => 'checkbox',
		gerekli => '0'
	),
	
	array(
		isim => 'Şalter',
		db => 'salter',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Şalter Bilgilendirme Yazısı',
		db => 'salterInfo',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),

	array(
		isim => 'Şalter Bilgi Tarih',
		db => 'salterTarih',
		stil => 'date',
		gerekli => '0'
	),
/*
	array(
		isim => 'Panel Dil Seçim Aktif',
		info=> 'Google Translate desteği ile sağlanmaktadır. Aktif edildikten sonra seçim, sol menü altında gözükür.',
		db => 'multilang',
		stil => 'checkbox',
		gerekli => '0'
	),
*/
	array(
		db => 'cacheSuresi',
		isim => 'Cache Tipi',
		stil => 'customtext',
		text => '

					  	<select class="form-control mb-md" id="cacheSuresi" name="cacheSuresi">
					  		<option value="0">Cache Kapalı</option>
							<option value="1">Disk Cache</option>
							<option value="2" ' . (class_exists('Memcache') ? '' : 'disabled="disabled"') . '>Memcached ' . (class_exists('Memcache') ? '' : '(Sunucuda Kurulu Değil)') . '</option>
							<option value="3">Database Cache (Tavsiye Edilir)</option>
					  	</select>
						<a class="mb-xs mt-xs mr-xs btn btn-info" href="#" style="float:right;" id="resimTemizle">' . ($_GET['cleanImgCache'] && !$shopphp_demo ? cleanimgcache() . 'Resim Cache Temizlendi' : 'Resim Cache Temizle') . '</a>
						<a class="mb-xs mt-xs mr-xs btn btn-success" href="#" style="float:right;" id="cacheTemizle">' . ($_GET['cleanCache'] && !$shopphp_demo ? cleancache() . 'Sistem Cache Temizlendi' : 'Sistem Cache Temizle') . '</a>'
	),
);
if(!siteConfig('httpsAktif') && !is_https())
	$tempInfo.=adminWarnv3('Kredi kartlarından ödeme alabilmek için, sunucuda SSL yüklü ve bu panelden "https aktif" olmalıdır.');
if ($_POST['salter'] || hq("select salter from siteConfig where ID='1' limit 0,1"))
	$tempInfo .= adminWarnv3('Şalter kapalı olduğundan site sadece admin statüsünde kullanıcılar tarafından görüntülenebilecektir.');
$serialInfo = adminInfov3('<strong>' . $serial . ' ( v' . $siteConfig['version'] . ' )</strong>');
$serialInfo = str_replace('Bilgi', 'Serial No', $serialInfo);
$tempInfo .= $serialInfo;

if($_GET['cleanImgCache'])
{

	$path = '../images/cache/';
	if ($handle = opendir($path)) {
	   while (false !== ($file = readdir($handle))) {
		  {  
			unlink($path.$file);
		  }
	   }
	 }

	 $path = '../images/resized/';
	 if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {
		   {  

			 unlink($path.$file);
		   }
		}
	  }
}

echo adminv3($dbase, $where, $icerik, $ozellikler);
echo "<script type=\"text/javascript\">$('#cacheSuresi').val('" . (isset($_POST['cacheSuresi']) ? $_POST['cacheSuresi'] : siteConfig('cacheSuresi')) . "');
$('#info_templateName').html('Seçtiğiniz şablonu, aktif etmeden kontrol etmek için  <a href=\"#\" onclick=\"window.open(\\'../?temp=\\' + $(\\'#templateName\\').val());\">tıklayın.</a>');

</script>";
if ($_POST['templateName'])
	$_SESSION['templateName'] = $_POST['templateName']; 
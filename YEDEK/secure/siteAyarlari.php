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

		intab => 'genel'

	),

	array(

		isim => 'Şablon Logo',

		db => 'templateLogo',

		stil => 'file',

		uploadto => 'images/',

		intab => 'sablon'

	),

	array(

		isim => 'Favicon Logo (.png)',

		db => 'favicon',

		stil => 'file',

		uploadto => 'images/',

		intab => 'sablon'

	),

	array(

		isim => 'Ürün Varsayılan Resim',

		info => 'Resmi olmayan ürünlerde, site ve pazaryerlerinde varsayılan ürün resmi olarak bu gösterilir.',

		db => 'nopic',

		stil => 'file',

		uploadto => 'images/',

		intab => 'sablon'

	),

	array(

		isim => 'Aktif Şablon Dizini',

		db => 'templateName',

		intab => 'genel,sablon',

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

		info => 'Şablonda manuel bir giriş olmadığı sürece, ana sayfada bir block içerinde listelenen ürün sayısını belirler.',

		intab => 'sablon'

	),



	array(

		isim => 'İç Sayfa Ürün Sayısı',

		db => 'icSayfaUrun',

		info => 'Tüm iç sayfa ürün listeleme (kategoriler, arama, yeni ürünler, indirimli ürünler ...) sayfalarındaki ürün listeleme sayısı',

		stil => 'normaltext',

		intab => 'sablon'

	),



	array(

		isim => 'Liste Ürün Sayısı',

		db => 'listelemeUrun',

		info => 'Ürün detay sayfasında bulunan ilgili ürünler listeleme sayısısı',

		stil => 'normaltext',

		intab => 'sablon'

	),

	array(

		isim => 'Form Gösterim',

		db => 'formv2',

		info => 'Mobile gösterim, varsayılan olarak tek sütun gösterilir.',

		stil => 'simplepulldown',

		simpleValues => '0|2 Sütun,1|3 Sütun',

		intab => 'sablon'

	),

	array(

		isim => 'Panel Ürün Varyasyon Sayısı',

		db => 'var',

		stil => 'simplepulldown',

		simpleValues => '2,3,4,5,6,7,8,9,10',

		autoSelected => '2',

		info => 'Tek ürün için girilebilecek azami ürün varyasyon başlık sayısını seçin.<br />Ör : En çok varyasyon olan üründe seçimler, Renk, Beden, Kumaş ise 3 olarak girin..',

		intab => 'genel'

	),

	array(

		isim => 'Yönetici Stok E-Posta Uyarı Limiti',

		info => '-1 girilirse uyarı gönderilmez.',

		db => 'stokMail',

		stil => 'normaltext',

		intab => 'genel'

	),



	array(

		isim => 'Fiyatı Olmayan Ürünleri Gizle',

		db => 'hideNoPrice',

		intab => 'sablon',

		stil => 'checkbox',

		gerekli => '0'

	),

	array(

		isim => 'Stoğu Olmayan Ürünleri Gizle',

		db => 'hideNoStock',

		intab => 'sablon',

		stil => 'checkbox',

		gerekli => '0'

	),

	array(

		isim => 'Resmi Olmayan Ürünleri Gizle',

		db => 'hideNoPic',

		intab => 'sablon',

		stil => 'checkbox',

		gerekli => '0'

	),



	array(

		isim => 'Kategori Sayfalama Tipi',

		db => 'useAjaxPager',

		stil => 'simplepulldown',

		simpleValues => '0|Ürün/Sayfa sayısına göre listeme,1|Ajax ile sınırsız listeleme',

		autoSelected => '1',

		intab => 'sablon'

	),

	/*

	array(

		isim => 'Kategori Listeleme',

		db => 'listType',

		stil => 'simplepulldown',

		intab => 'sablon',

		align => 'left',

		width => 40,

		simpleValues => '0|Detay ve Liste,1|Sadece Ürün Detay,2|Sadece Ürün Liste',

		gerekli => '1'

	),

		  

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

		intab => 'sozlesme'

	),

	array(

		isim => 'Üyelik Kuralları',

		db => 'uyelikKural',

		stil => 'textarea',

		multilang => true,

		intab => 'sozlesme'

	),

	array(

		isim => 'Satın Alma Kuralları',

		db => 'satinalKural',

		stil => 'textarea',

		multilang => true,

		info => ($disablehelp ? '' : 'Kullanılabilecek makro listesi için <a href="https://sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=327&autoOpen=174" target="_blank">tıklayın</a>.'),

		intab => 'sozlesme'

	),



	array(

		isim => 'Mesafeli Ön satış Sözleşmesi',

		db => 'onKural',

		multilang => true,

		stil => 'textarea',

		info => ($disablehelp ? '' : 'Kullanılabilecek makro listesi için <a href="https://sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=327&autoOpen=174" target="_blank">tıklayın</a>.'),

		intab => 'sozlesme'

	),



	array(

		isim => 'Resim Boyutlandırma Seçimi',

		db => 'digerparabirim',

		stil => 'simplepulldown',

		align => 'left',

		width => 40,

		intab => 'sablon',

		// ,4|Direkt Cache Dosyasından Okuma

		simpleValues => '|PHP Thumb (+Webp +Cache +Watermark),3|C-Image (+Webp +Cache),2|Tim Thumb (+Cache),1|Direkt Boyutlandırma',

		gerekli => '1'

	),

	array(

		isim => 'Resim Boyutlandırma Tipi',

		db => 'resizeconfig',

		info => 'Resim boyutlandırma C-Image,PHPThumb veya TimThumb seçildiğinde geçerli olur.',

		stil => 'simplepulldown',

		align => 'left',

		width => 40,

		intab => 'sablon',

		simpleValues => '0|Orijinal : Resmi orantıyı koruyarak boyutlandırır.,1|Strech : Resmi verilen en ve boya göre orantıyı korumadan boyutlandırır.,2|Crop To Fit : Resmi boyutlandırırken fazla kısımları siler.,3|Fill to Fit : Resmi boyutlandırırken fazla olan kısmı silmez ve diğer alana arka olan rengi ekler.',

		gerekli => '1'

	),



	array(

		isim => 'Form Koruma',

		db => 'captcha',

		stil => 'simplepulldown',

		align => 'left',

		width => 40,

		intab => 'genel',

		info => 'Google reCAPTCHA v2 seçildiğinde, <a href="s.php?f=googleAyarlari.php">Google Ayarları</a> kısmından ilgili KEY bilgilerini girmek gerekmektedir.',

		simpleValues => '0|Captcha Kapalı,2|Google reCAPTCHA v2',

		gerekli => '1'

	),



	array(

		isim => 'Canlı İstatistikler',

		db => 'onLoad',

		intab => 'genel',

		stil => 'simplepulldown',

		align => 'left',

		width => 40,

		simpleValues => '0|Kapalı,1|Açık (İşlemci kullanımı artar)',

		gerekli => '1'

	),

	array(

		isim => 'Https Kullanım (SSL)',

		db => 'httpsAktif',

		stil => 'simplepulldown',

		simpleValues => '0|Pasif (SSL Kurulu Değil),1|Akfit (SSL Kurulu)',

		info => 'Banka pos kullanımı, Google index sırası, tarayıcı güvenlik bilgisi gibi nedenlerden dolayı en kısa sürede aktif edilmeli.',

		intab => 'genel'

	),

	array(

		isim => 'Otomatik www Yönlendirme Aktif',

		db => 'wwwAktif',

		stil => 'checkbox',

		info => 'Sunucunda .htaccess ile yönlendirme desteği yoksa, işaretlemeniz tavsiye edilir.',

		intab => 'genel'

	),



	array(

		isim => 'Tek Sonuçlu Aramaları Yölendir.',

		db => 'aramaredirect',

		stil => 'checkbox',

		info => 'Arama sonucunda tek ürün geliyorsa, arama sonuçları yerine ürün detay ekranına yönlendirilir. ',

		intab => 'genel'

	),



	array(

		isim => 'Ürün Yorumları İçin Facebook Kullan',

		db => 'facebookYorum',

		stil => 'checkbox',

		intab => 'genel'

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

		intab => 'genel'

	),

	array(

		isim => 'Üyelik SMS Onay Gerektirir',

		db => 'smsOnay',

		stil => 'checkbox',

		intab => 'genel'

	),

	array(

		isim => 'Sadece Üyeler Girebilir',

		db => 'sadeceUye',

		stil => 'checkbox',

		intab => 'genel'

	),

	array(

		isim => 'Fiyatları Sadece Üyeler Görebilir',

		db => 'fiyatUyelikZorunlu',

		stil => 'checkbox',

		intab => 'genel'

	),

	array(

		isim => 'Giriş 18 yaş onayı gerektirir',

		db => 'yasOnay',

		info => 'İşaretlendiğinde site direkt açılmaz ve yaş onayı alınır.',

		stil => 'checkbox',

		intab => 'genel'

	),

	array(

		isim => 'Yeni Üyeliklerde Yöneticiyi Bilgilendir',

		db => 'uyeAdminMail',

		info => 'İşaretlendiğinde bir kullanıcı kayıt olduğunda, yönetici e-posta adresine bilgilendirme gönderilir.',

		stil => 'checkbox',

		intab => 'genel'

	),

	array(

		isim => 'Sipariş İçin Üyelik Zorunlu',

		db => 'uyelikZorunlu',

		info => 'İşaretlendiğinde sadece üyeler alışveriş yapabilir. Üye giriş yapılmadıysa, sepet onayı sonrasında kullanıcı kayıt / üye girişi sayasına yönlendirilir.',

		stil => 'checkbox',

		intab => 'genel'

	),

	/*

	array(

		isim => 'Ürün Yorum İçin Üyelik Zorunlu',

		db => 'yorumUyelikZorunlu',

		stil => 'checkbox',

		intab=>'genel'

	),

	*/

	array(

		isim => 'Üyeliksiz Siparişlerde Otomatik Üye Kaydet',

		db => 'autoRegister',

		info => 'İşaretlendiğinde, kullanıcı sipariş formunda girdiği bilgiler baz alınarak üye kaydı yapılır ve e-posta ile giriş bilgileri iletilir.',

		stil => 'checkbox',

		intab => 'genel'

	),

	/*

	array(

		isim => 'Resim Lazyload Aktif',

		db => 'captchaClose',

		info => 'Sadece desteklenen şablonlarda aktif olur. Ana sayfada resim görüntülenemiyorsa veya şablonda soruna neden oluyorsa bunu seçimi pasif edin.',

		stil => 'checkbox',

		intab => 'sablon'

	),

*/

	array(

		isim => 'Yönetici için Ürün Detay Sayfasına Düzenle Button Ekle',

		db => 'urunduzenle',

		info => 'İşaretlendiğinde, ürün detay sayası, sağ üst köşesine "sadece yöneticilerin" görebileceği bir düzenle ve stok bilgisi buttonu eklenir.',

		stil => 'checkbox',

		unlist => true,

		intab => 'genel'

	),



	array(

		isim => 'URL Yönlendirme Kontorlü Aktif',

		info => '<a href="s.php?f=yonlendir.php">Buraya tıklayarak</a>, yönlendirilecek URL adreslerini girebilirsiniz.',

		db => 'urlredirect',

		stil => 'checkbox',

		intab => 'genel'

	),



	array(

		isim => 'Dil Otomatik Yönlendirme Aktif',

		info => 'Çoklu dil desteği olan paketlerde geçerlidir. Kullanıcı tarayıcı diline göre ilk dil yönlendirmesi otomatik olarak yapılır.',

		db => 'autolang',

		stil => 'checkbox',

		intab => 'genel'

	),



	array(

		isim => 'Cookie İçin Onay Bilgisi Aktif.',

		db => 'cookie',

		info => 'İşaretlendiğinde site footer kısmında, cookie (çerez) onay bilgilendirmesi gösterilir. Bir defa onaylandıktan sonra tekrar gösterilmez.',

		stil => 'checkbox',

		intab => 'genel'

	),



	array(

		isim => 'Yabancı Kredi Kartına Kapalı',

		db => 'fcccheck',

		info => 'İşaretlenirse, yabancı kredi kartları ile ödeme alınmaz.',

		stil => 'checkbox',

		intab => 'genel'

	),

	array(

		isim => 'Footer Yazılım Bilgisini Gizle',

		db => 'telif-footer',

		info => 'İşaretlendiğinde şablon alt tarafında gözüken ShopPHP.net linki kaldırılır.',

		stil => 'checkbox',

		intab => 'genel'

	),



	array(

		isim => 'Şalter',

		db => 'salter',

		info => 'İşaretlendiğinde sadece yöneticiler siteye girebilir. Son kullanıcı bakımda sayfasını görürler.',

		stil => 'checkbox',

		intab => 'genel'

	),



	array(

		isim => 'Şalter Bilgilendirme Yazısı',

		db => 'salterInfo',

		info => 'Eğer şalter check işaretliyse, gelen bakım sayfasında burada yazan bilgilendirme gösterilir.',

		stil => 'normaltext',

		unlist => true,

		intab => 'genel'

	),



	array(

		isim => 'Şalter Bilgi Tarih',

		db => 'salterTarih',

		info => 'Eğer şalter check işaretliyse, gelen bakım sayfasında burada yazan yazan tarihe geri sayım başlar.',

		//	intabKey => 'tarih_gun',

		stil => 'date',

		intab => 'genel'

	),

	/*

	array(

		isim => 'Panel Dil Seçim Aktif',

		info=> 'Google Translate desteği ile sağlanmaktadır. Aktif edildikten sonra seçim, sol menü altında gözükür.',

		db => 'multilang',

		stil => 'checkbox',

		intab=>'genel'

	),

*/

	array(

		isim => 'Canlı Destek Eklenti Kodu',

		info => 'ShopPHP, site canlı yardım hizmeti için <a href="https://www.jivochat.com.tr/?partner_id=39450" target="_blank">JivoChat</a> uygulamasını önerir.',

		db => 'chatcode',

		stil => 'textarea',

		intab => 'sablon',

		style => 'width:100%; height:100px;',

		gerekli => '0'

	),

	/*

	array(

		isim => 'Head İçerisine Eklenti Kodu',

		info => 'Head kısmına eklenmesini istediğiniz HTML kodlarını buraya ekleyebilirsiniz.',

		db => 'google_head',

		stil => 'textarea',

		style => 'width:100%; height:100px;',

		intab => 'sablon',

		gerekli => '0'

	),

	array(

		isim => 'Body İçerisine Eklenti Kodu',

		info => 'Body kısmına (Google analytics, Tag manager, Canlı Destek App Javascript kodu vs.) eklenmesini istediğiniz HTML kodlarını buraya ekleyebilirsiniz.',

		db => 'google_analytics',

		stil => 'textarea',

		intab => 'sablon',

		style => 'width:100%; height:200px;',

		gerekli => '0'

	),

	*/

	array(

		db => 'cacheSuresi',

		isim => 'Cache Tipi',

		stil => 'customtext',

		intab => 'genel',

		text => '



					  	<select class="form-select mb-md" id="cacheSuresi" name="cacheSuresi">

					  		<option value="0">Cache Kapalı</option>

							<option value="1">Disk Cache</option>

							<option value="2" ' . (class_exists('Memcache') ? '' : 'disabled="disabled"') . '>Memcached ' . (class_exists('Memcache') ? '' : '(Sunucuda Kurulu Değil)') . '</option>

							<option value="3">Database Cache (Tavsiye Edilir)</option>

					  	</select>'

	),

);



if (!siteConfig('httpsAktif') && !is_https())

	$tempInfo .= adminErrorv3('Kredi kartlarından ödeme alabilmek için, sunucuzda SSL yüklü ve bu panelden "Https Kullanım (SSL)" başlığı "Aktif" olarak seçilmelidir".');

if ($_POST['salter'] || siteConfig('salter'))

	$tempInfo .= adminWarnv3('Şalter kapalı olduğundan site sadece admin statüsünde kullanıcılar tarafından görüntülenebilecektir.');









if ($_GET['cleanCache']) {

	cleancache();

	exit();

}

if ($_GET['cleanImgCache']) {

	rrmdir('../images/cache/');

	mkdir("../images/cache", 0777);

	rrmdir('../images/resized/');

	mkdir("../images/resied", 0777);

	rrmdir('../cache/');

	mkdir("../cache", 0777);

	exit('OK');

}



$adminTabs[] = array('genel', 'fa-shopping-cart', 'Genel Ayarlar');

$adminTabs[] = array('sablon', 'fa-cube', 'Genel Görünüm');

$adminTabs[] = array('sozlesme', 'fa-cube', 'Sözleşmeler');



$tempInfo .= v5Admin::generateTabMenu($adminTabs, $icerik, $dbase);



echo adminv3($dbase, $where, $icerik, $ozellikler);

echo "<script type=\"text/javascript\">$('#cacheSuresi').val('" . (isset($_POST['cacheSuresi']) ? $_POST['cacheSuresi'] : siteConfig('cacheSuresi')) . "');

$('#info_templateName').html('Seçtiğiniz şablonu, aktif etmeden kontrol etmek için  <a href=\"#\" onclick=\"window.open(\\'../?temp=\\' + $(\\'#templateName\\').val());\">tıklayın.</a>');



</script>";

if ($_POST['templateName'])

	$_SESSION['templateName'] = $_POST['templateName'];


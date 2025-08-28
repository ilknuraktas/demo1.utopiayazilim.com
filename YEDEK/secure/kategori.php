<?php
$ggForm =
	autoModalForm('gg', 'GittiGidiyor', 'mod_GittiGidiyor.php') .
	autoModalForm('n11', 'N11', 'mod_N11.php') .
	autoModalForm('ty', 'Trendyol', 'mod_Trendyol.php') .
	autoModalForm('hb', 'HepsiBurada', 'mod_HepsiBuradav2.php') .
	autoModalForm('cs', 'ÇiçekSepeti', 'mod_cicekSepeti.php') .
	autoModalForm('amazon', 'Amazon', 'mod_Amazon.php') . v5Admin::simpleModal('gg-dialog-specs','GittiGidiyor Kategori Varyasyonları','<div id="gg-cat-specs"></div>','<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>');
	
$ggForm .= "
<script>
	function loadGGSpecs()
	{
		if(!$('#gg_Kod').val())
		{
			notify('','Önce GittiGidiyor kategorisini seçmelisiniz','error');
			return;	
		}
	  $.ajax({
	  url: 'ajax.php?act=ggCatSpecs&catID='+$('#gg_Kod').val()+'&r='+ Math.floor(Math.random()*99999),
	  success: function(data) 
			   {
				   $('#gg-cat-specs').html(data);
			   },
	  error: function (xhr, ajaxOptions, thrownError) {
				notify('','GittiGidiyor kategorileri varyasyonları çekilemedi. Lütfen giriş ayarlarınızı kontrol edin.','error');
      		 }
	  });	

	}
	
	function openGGSpecs()
	{
		$('#gg-dialog-specs').modal('show');
		loadGGSpecs();
		return;
	}
</script>
";
if (!hq("select count(*) from kategori where parentID='" . (int) $_GET['ID'] . "'")) {
	$pazarYeriGoster = true;
} else if ($_GET['y'] == 'd') {
	$tempInfo .= adminWarnv3('Bu kateogrinin alt kategorileri olduğundan, XML / API altındaki pazaryerleri kategori eşleştirme kısımları kapalıdır. Kategori eşleştirmelerini en alt seviye kategorilerde yapabilirsiniz.');
} else
	$pazarYeriGoster = true;

	$pazarYeriGoster = true;
	
$dbase = "kategori";
$title = 'Kategori Yönetimi';
$listTitle = 'Kategoriler';
$ozellikler = array(
	ekle => '1',
	baseid => 'ID',
	orderby => 'level,name',
	ordersort => 'asc',
	excelLoad => 1,
	allowCopy => 1,
	// moveParentCat=>1,
);

$icerik = array(
	array(
		isim => 'Meta Tag Keywords',
		disableFilter => true,
		unlist => true,
		multilang => true,
		maxlength => 320,
		intab => 'seo',
		db => 'metaKeywords',
		stil => 'normaltext'
	),
	array(
		isim => 'Meta Tag Description',
		disableFilter => true,
		unlist => true,
		maxlength => 320,
		multilang => true,
		intab => 'seo',
		db => 'metaDescription',
		stil => 'normaltext'
	),
	array(
		isim => 'Custom Tile (Opsiyonel)',
		disableFilter => true,
		unlist => true,
		multilang => true,
		maxlength => 70,
		intab => 'seo',
		db => 'customTitle',
		stil => 'normaltext'
	),
	/*
				array(isim=>'Custom CanonicalURL (Opsiyonel)',
					  disableFilter=>true,
					  unlist=>true,
					  multilang=>true,
					  maxlength=>70,
					  db=>'customCanonicalURL',
					  stil=>'normaltext',
					  gerekli=>'0'), 
	 */
	array(
		isim => 'Paraşüt ID',
		db => 'parasutID',
		unlist => true,
		stil => 'normaltext',
		width => 100,
		intab => 'pazaryeri'
	),
	array(
		isim => 'Kategori Adı',
		db => 'name',
		multilang => true,
		zorunlu => 1,
		stil => 'normaltext',
		intab => 'genel',
		width => 299,
		gerekli => '1'
	),
	array(
		isim => 'Üst Kategori',
		db => 'parentID',
		stil => 'dbpulldown',
		intab => 'genel',
		dbpulldown_data => array(
			db => 'kategori',
			base => 'ID',
			name => 'namePath',
		),
		width => 221
	),
	array(
		isim => 'SEO URL girişi<br/>(Girilmezse, otomatik oluşturulur.)',
		db => 'seo',
		unlist => true,
		stil => 'normaltext',
		multilang => true,
		intab => 'seo',
		width => 226
	),
	array(
		isim => 'Kategori Resmi',
		db => 'resim',
		stil => 'file',
		intab => 'genel',
		uploadto => 'images/kategoriler/',
		unlist => true
	),
	/*
				array(isim=>'Varsayılan Bayi',
					  db=>'tedarikciID',
					  stil=>'dbpulldown',
					  dbpulldown_data =>array(db=>'tedarikciler',
					  						  base=>'ID',
											  name=>'name',
											  ),
					  gerekli=>'1'),
			
				array(isim=>'Bayi Kategori Kodu',
					  db=>'tedarikciCode',
					  unlist=>true,
					  stil=>'normaltext',
					  gerekli=>'1'),
	 */
	array(
		isim => 'Google Merchant Name <br /><a href="https://support.google.com/merchants/answer/1705911" target="_blank">Detaylar</a> (ID veya İsimden biri yeterlidir.)',
		db => 'googleMerchant',
		unlist => true,
		stil => 'normaltext',
		intab => 'seo',
		gerekli => '0'
	),
	array(
		isim => 'Çiçek Sepeti Kategori Kodu',
		db => 'cscode',
		intab => 'pazaryeri',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'E-PTT Avm Kategori Kodu',
		db => 'pttcode',
		intab => 'pazaryeri',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Asgari Sipariş Tutarı',
		disableFilter => true,
		db => 'minsiparis',
		unlist => true,
		stil => 'normaltext',
		intab => 'diger',
		width => 20,
		gerekli => '1'
	),
	array(
		isim => 'Asgari Sipariş Adeti',
		disableFilter => true,
		db => 'minsiparisadet',
		unlist => true,
		stil => 'normaltext',
		intab => 'diger',
		width => 20,
		gerekli => '1'
	),

	array(
		isim => 'Azami Taksit Limiti<br>(0 = varsayılan)',
		disableFilter => true,
		db => 'taksit',
		unlist => true,
		stil => 'normaltext',
		intab => 'diger',
		width => 20,
		gerekli => '1'
	),
	array(
		isim => 'XML / API Servislerinde Gönderme',
		db => 'noxml',
		stil => 'checkbox',
		unlist => true,
		intab => 'pazaryeri',
		gerekli => '0'
	),
	array(
		isim => 'Google Merchant Servislerinde Gönderme',
		db => 'gnoxml',
		stil => 'checkbox',
		unlist => true,
		intab => 'pazaryeri',
		gerekli => '0'
	),
	array(
		isim => 'Varsayılan E-PTT Avm Çıkış Kar Marjı (0.10 = %10)',
		disableFilter => true,
		db => 'pttkar',
		unlist => true,
		stil => 'normaltext',
		intab => 'pazaryeri',
		gerekli => '1'
	),
	array(
		isim => 'Varsayılan XML Giriş Kar Marjı (0.10 = %10)',
		disableFilter => true,
		db => 'kar',
		unlist => true,
		stil => 'normaltext',
		intab => 'pazaryeri',
		gerekli => '1'
	),
	array(
		isim => 'Sıra',
		disableFilter => true,
		db => 'seq',
		stil => 'normaltext',
		info=> 'Kategori sıralaması, varsayılan olarak harfe göre yapılır. Eğer bir sıra numarası verilirse öncelik sıra numarasında olur.',
		intab => 'genel',
		gerekli => '1'
	),
	array(
		isim => 'Ürünleri Sigortalanabilir',
		db => 'sigorta',
		info => 'Aktif edilirse, "Sigorta Ücretlerinin" <a href="s.php?f=sigorta.php" target="_blank">bu panelden</a> tanımlanması gerekir.',
		unlist => true,
		intab => 'diger',
		stil => 'checkbox'
	),
	array(
		isim => 'Google Mercant Servisinde Yetişkin Kategorisi',
		db => 'yetiskin',
		unlist => true,
		intab => 'diger',
		stil => 'checkbox'
	),
	array(
		isim => 'PC Toplama Kategorilerine Ekle',
		db => 'PCToplama',
		unlist => true,
		intab => 'diger',
		stil => 'checkbox'
	),
	array(
		isim => 'Şablon Listeleme Kontrol 1',
		db => 'menu',
		info => 'Kullanılan şablonun desteklemesi gerekir.',
		intab => 'diger',
		stil => 'checkbox'
	),

	array(
		isim => 'Şablon Listeleme Kontrol 2',
		db => 'menu2',
		info => 'Kullanılan şablonun desteklemesi gerekir.',
		intab => 'diger',
		stil => 'checkbox'
	),

	array(
		isim => 'Bu Kategoride Havale İndirimi Uygulanmaz',
		db => 'nohavale',
		unlist => true,
		stil => 'checkbox',
		intab => 'genel',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Aktif',
		db => 'active',
		intab => 'genel',
		stil => 'checkbox'
	),
	array(
		isim => 'Pazaryeri',
		db => 'idPath',
        'readonly' => true,
		stil => 'pazaryeri',
		noedit=>true,
		width => 160
	),
	array(
		isim => '<img id="google-label" src="images/google.png" />',
		offline => true,
		unlist => true,
		stil => 'customtext',
		intab => 'seo',
		text => '<div name="seo" id="seopreview-google"></div>'
	),
);
/*
if (file_exists('mod_CustomBot_<firma>.php')) {
	require_once('mod_CustomBot_<firma>.php');
	$icerik = array_merge(SpCustomBot_<firma>::getAdminKategoriArray(), $icerik);
}
*/
if ($pazarYeriGoster) {
	if (file_exists('../include/mod_GittiGidiyor.php')) {
		include_once('../include/mod_GittiGidiyor.php');
		$ggIcerik = array(
			array(
				isim => 'Varsayılan GittiGidiyor Çıkış Kar Marjı (0.10 = %10)',
				disableFilter => true,
				db => 'ckar',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				gerekli => '1'
			),
			array(
				isim => 'GittiGidiyor Dükkan No<br/>(Store Cat ID / Zorunlu Değil)',
				disableFilter => true,
				db => 'gg_Dukkan',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 20,
				gerekli => '1'
			),
			array(
				isim => 'GittiGidiyor Kodu',
				db => 'gg_Kod',
				unlist => true,
				stil => 'normaltext',
				align => 'left',
				intab => 'pazaryeri',
				width => 40,
				simpleValues => gg_catList(),
				gerekli => '1'
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		$ggIcerik = array(

			array(
				db => 'data1',
				stil => 'customtext',
				isim => 'GG API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>'<span name="data1"></span>'.
					v5Admin::simpleButtonWithImage('', ' openGgDialog();', 'download', 'Kategorileri Çek', 'primary') .
					v5Admin::simpleButtonWithImage('', ' openGGSpecs();', 'layer',  'GG Varyasyon Listesi', 'primary') .
					v5Admin::simpleButtonWithImage('', 'if ($(\'#gg_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&gg_upload=1&ggcatID=\' + $(\'#gg_Kod\').val(); else notify(\'\',\'Lütfen en alt seviye GittiGidiyor kategori kodunu girin.\',\'error\'); return false;', 'upload', ($_GET['gg_upload'] ? 'Ürünler Yüklendi' : 'Ürünleri Yükle'), 'success')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
	}

	if (file_exists('../include/mod_Trendyol.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan Trendyol Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'tykar',
				unlist => true,
				intab => 'pazaryeri',
				stil => 'normaltext',
				gerekli => '1'
			),

			array(
				isim => 'Trendyol Kodu',
				disableFilter => true,
				db => 'ty_Kod',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),

			array(
				isim => 'Bu kategoride varyantları ayrı ürün olarak gönder.',
				db => 'tyvar',
				stil => 'checkbox',
				unlist => true,
				intab => 'pazaryeri',
				gerekli => '0'
			),

			array(
				db => 'data4',
				stil => 'customtext',
				isim => 'Trendyol API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>'<span name="data4"></span>'.
				v5Admin::simpleButtonWithImage('#', 'return openTyDialog();', 'download', 'Kategorileri Çek', 'primary') .
					v5Admin::simpleButtonWithImage('#', 'if ($(\'#ty_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&ty_upload=1&tycatID=\' + $(\'#ty_Kod\').val(); else alert(\'Lütfen en alt seviye Trendyol kategori kodunu girin.\'); return false;', 'upload', ($_GET['gg_upload'] ? 'Ürünler Yüklendi' : 'Ürünleri Yükle'), 'success')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}

	if (file_exists('../include/mod_N11.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan N11 Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'nckar',
				unlist => true,
				intab => 'pazaryeri',
				stil => 'normaltext',
				gerekli => '1'
			),

			array(
				isim => 'N11 Kodu',
				disableFilter => true,
				db => 'yc_Kod',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),

			array(
				isim => 'Kategoride 150 Karakter Sınırı Var',
				db => 'n11catlimit',
				stil => 'checkbox',
				unlist => true,
				intab => 'pazaryeri',
				gerekli => '0'
			),
			array(
				db => 'data2',
				stil => 'customtext',
				isim => 'N11 API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>'<span name="data2"></span>'.
				v5Admin::simpleButtonWithImage('', 'return openN11Dialog();', 'download', 'Kategorileri Çek', 'primary') .
					v5Admin::simpleButtonWithImage('', 'if ($(\'#yc_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&n11_upload=1&n11catID=\' + $(\'#yc_Kod\').val(); else alert(\'Lütfen en alt seviye N11 kategori kodunu girin.\'); return false;', 'upload', ($_GET['gg_upload'] ? 'Ürünler Yüklendi' : 'Ürünleri Yükle'), 'success')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}

	if (file_exists('../include/mod_HepsiBuradav2.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan HepsiBurada Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'hbkar',
				unlist => true,
				intab => 'pazaryeri',
				stil => 'normaltext',
				gerekli => '1'
			),

			array(
				isim => 'HB Kodu',
				disableFilter => true,
				db => 'hb_Kod',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),
			array(
				db => 'data3',
				stil => 'customtext',
				isim => 'HepsiBurada API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>'<span name="data3"></span>'.
				v5Admin::simpleButtonWithImage('#', 'return openHbDialog();', 'download', 'Kategorileri Çek', 'primary') .
				v5Admin::simpleButtonWithImage('#', 'if ($(\'#hb_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&hb_upload=1&hbcatID=\' + $(\'#hb_Kod\').val(); else alert(\'Lütfen en alt seviye HepsiBurada kategori kodunu girin.\'); return false;', 'upload', ($_GET['hb_upload'] ? 'Ürünler HepsiBurada\'ya Yüklendi' : 'Ürünleri Yükle'), 'success')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}


	if (file_exists('../include/mod_CicekSepeti.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan ÇiçekSepeti Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'cskar',
				unlist => true,
				intab => 'pazaryeri',
				stil => 'normaltext',
				gerekli => '1'
			),

			array(
				isim => 'ÇiçekSepeti Kodu',
				disableFilter => true,
				db => 'cs_Kod',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),
			array(
				db => 'data4',
				stil => 'customtext',
				isim => 'ÇiçekSepeti API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>'<span name="data3"></span>'.
				v5Admin::simpleButtonWithImage('#', 'return openCsDialog();', 'download', 'Kategorileri Çek', 'primary') .
				v5Admin::simpleButtonWithImage('#', 'if ($(\'#cs_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&cs_upload=1&cscatID=\' + $(\'#cs_Kod\').val(); else alert(\'Lütfen en alt seviye ÇiçekSepeti kategori kodunu girin.\'); return false;', 'upload', ($_GET['cs_upload'] ? 'Ürünler ÇiçekSepeti\'ne Yüklendi' : 'Ürünleri Yükle'), 'success')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}

	if (file_exists('../include/mod_Amazon.php') && 1==2) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan Amazon Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'amazonkar',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				gerekli => '1'
			),
			array(
				isim => 'Amazon Kodu',
				disableFilter => true,
				db => 'amazon_Kod',
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),
			array(
				db => 'data5',
				stil => 'customtext',
				isim => 'Amazon API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>'<span name="data5"></span>'.
				v5Admin::simpleButtonWithImage('#', 'return openAmazonDialog();', 'success', '<i name="data5" class="fa fa-download"></i> Amazon Kategorileri Çek', 'primary') .
					v5Admin::simpleButtonWithImage('#', 'if ($(\'#amazon_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&amazon_upload=1&amazoncatID=\' + $(\'#amazon_Kod\').val(); else alert(\'Lütfen en alt seviye Amazon kategori kodunu girin.\'); return false;', 'primary', '<i class="fa fa-upload"></i> ' . ($_GET['gg_upload'] ? 'Ürünler Amazon\'a Yüklendi' : 'Kategori Ürünlerini Amazon\'a Yükle'), 'primary')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}
}

if($_GET['cs_upload'] || $_GET['hb_upload'] || $_GET['n11_upload'] || $_GET['ty_upload'] || $_GET['gg_upload'])
{
	unset($icerik);
	$stopTabs = true;
	echo "<style>.form-group,.col-sm-7.relative { display:none; }</style>";
}

if (($_GET['y'] == 'd') && !$stopTabs) {
	$url = '//' . $_SERVER["SERVER_NAME"] . kategoriLink((int) $_GET['ID']);
	$tempInfo .= adminInfov5('Bu kategoriye kayıtlı ürün sayısı : '.hq("select count(*) from urun where catID='".$_GET['ID']."' OR showCatIDs like '%|".$_GET['ID']."|%'").' ('.hq("select count(*) from urun where (catID='".$_GET['ID']."' OR showCatIDs like '%|".$_GET['ID']."|%') AND active = 1").' Aktif, '.hq("select count(*) from urun where (catID='".$_GET['ID']."' OR showCatIDs like '%|".$_GET['ID']."|%') AND active = 0").' Pasif)','cube');
	$tempInfo .= adminInfov5('Düzenleme yapılan kategorinin URL adresi :<br /> <a href="' . $url . '" target="_blank">https:' . $url . '</a>');
	$tempInfo .= adminInfov5('<a href="s.php?f=pn.php&y=e&catID=' . $_GET['ID'] . '">Kategoriyi PushCrew ile göndermek için tıklayın.</a>','mobile');
}
if (($_GET['y'] == 'd' || $_GET['y'] == 'e') && !$stopTabs) {
	$adminTabs[] = array('genel', 'fa-shopping-cart', 'Genel Bilgiler');
	$adminTabs[] = array('seo', 'fa-search', 'SEO');
	$adminTabs[] = array('pazaryeri', 'fa-cubes', 'XML / API');
	$adminTabs[] = array('diger', 'fa-puzzle-piece', 'Diğer');
	$tempInfo .= v4Admin::generateTabMenu($adminTabs, $icerik, $dbase);
}
if ($_POST['ID'] && $_POST['ID'] == $_POST['parentID']) {
	$tempInfo .= adminInfov5('Hata : Kategorinin üst kategorisi kendisi olamaz.');
	$_POST['parentID'] = dbInfo('kategori', 'parentID', $_POST['ID']);
	unset($_POST);
}



setAdminPostSEOField();

admin($dbase, $where, $icerik, $ozellikler);

if ($_POST['name']) {
	buildCatBreadCrumb();
	cleancache();

	foreach ($pazarArray as $p) {
		my_mysql_query("update urun set $p = 1 where catID='".$_POST['ID']."'");
	}

	//setUrunStatus();
}

echo googlePreview('catID','kategoriGoster',kategoriLink($_GET['ID']));

function autoModalForm($prefix, $name, $fileName)
{
	global $tempInfo;
	if ($_GET[$prefix . 'catID']) {
		my_mysql_query("update kategori set " . ($prefix == 'n11' ? 'yc' : $prefix) . "_Kod = '" . $_GET[$prefix . 'catID'] . "' where ID='" . $_GET['ID'] . "'");
	}

	if ($_GET[$prefix . '_upload']) {
		include_once('../include/' . $fileName);
		$functionName = $prefix . '_uploadProducts';
		$tempInfo .= $functionName($_GET['ID']);
	}
	$prefix2 = ($prefix == 'n11' ? 'yc' : $prefix);


	return v5Admin::simpleModal($prefix . '-dialog-form',$name,
	
		adminInfov5('Seçtiğiniz kategori en alt seviye olmalıdır.') . '
				<select class="form-select mb-2" id="' . $prefix . 'level_1" onchange="load' . ucfirst($prefix) . 'Dir(\'2\',$(this).val());">
				<option value="">Lütfen bekleyin..</option>
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_2" onchange="load' . ucfirst($prefix) . 'Dir(\'3\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_3" onchange="load' . ucfirst($prefix) . 'Dir(\'4\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_4" onchange="load' . ucfirst($prefix) . 'Dir(\'5\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_5" onchange="load' . ucfirst($prefix) . 'Dir(\'6\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_6" onchange="load' . ucfirst($prefix) . 'Dir(\'7\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_7" onchange="load' . ucfirst($prefix) . 'Dir(\'8\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_8" onchange="load' . ucfirst($prefix) . 'Dir(\'9\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_9" onchange="load' . ucfirst($prefix) . 'Dir(\'10\',$(this).val());">
				</select>
				<select class="form-select mb-2" id="' . $prefix . 'level_10" onchange="load' . ucfirst($prefix) . 'Dir(\'11\',$(this).val());">
				</select>
	
	','<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button><button onclick="' . $prefix . 'Kaydet();" type="button" class="btn btn-primary">Kaydet</button>')
	. "<script type='text/javascript'>

function load" . ucfirst($prefix) . "Dir(level,parentID)
{
  $.ajax({
  url: 'ajax.php?act=" . $prefix . "Cats&parentID='+parentID+'&r='+ Math.floor(Math.random()*99999),
  success: function(data) 
		   {
			   var check = data.replace(/^\s+|\s+$/g,'');
			   if(level == '1' && check == '')
			   {
					notify('','$name kategorileri çekilemedi. Lütfen giriş ayarlarınızı kontrol edin.','error');
			   }
				if(data.length > 40)
					$('select#" . $prefix . "level_' + level).html(data).show();
				var nlevel = (parseInt(level) + 1);
				for(var i=nlevel;i<=5;i++)
				{
					$('select#" . $prefix . "level_' + i).html('').hide();	
				}
		   },
  error: function (xhr, ajaxOptions, thrownError) {
			notify('','$name kategorileri çekilemedi. Lütfen API giriş ayarlarınızı kontrol edin.','error');
		   }
  });	

}
function " . $prefix . "Kaydet()
{	
	if($('#" . $prefix . "level_10').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_10').val());
	else if($('#" . $prefix . "level_9').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_9').val());
	else if($('#" . $prefix . "level_8').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_8').val());
	else if($('#" . $prefix . "level_7').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_7').val());
	else if($('#" . $prefix . "level_6').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_6').val());
	else if($('#" . $prefix . "level_5').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_5').val());
	else if($('#" . $prefix . "level_4').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_4').val());
	else if($('#" . $prefix . "level_3').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_3').val());
	else if($('#" . $prefix . "level_2').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_2').val());
	else if($('#" . $prefix . "level_1').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_1').val());
	$('#".$prefix . "-dialog-form').modal('hide');

}

function open" . ucfirst($prefix) . "Dialog()
{
	$('#" . $prefix . "-dialog-form').modal('show');
	if($('#" . $prefix . "level_1 option').length <= 5)
	{
		load" . ucfirst($prefix) . "Dir(1,0); 
	}
	return;
}

</script>
<style>
	#" . $prefix . "level_2,#" . $prefix . "level_3,#" . $prefix . "level_4,#" . $prefix . "level_5,#" . $prefix . "level_6,#" . $prefix . "level_7,#" . $prefix . "level_8,#" . $prefix . "level_9,#" . $prefix . "level_10 { display:none; }
</style>
";
}

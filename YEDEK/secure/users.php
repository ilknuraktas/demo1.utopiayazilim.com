<?
$dbase = "user";
$title = 'Kullanıcı Yönetimi';
$listTitle = 'Kullanıcılar';
$ozellikler = array(
	ekle => (int) (strtolower($yonetimKoruma) == 'script'),
	baseid => 'ID',
	orderby => 'isAdmin desc,isMod desc,bayiStatus desc,name',
	excelLoad => 1,
);


$icerik = array(
	array(
		isim => 'Yönetici Notu',
		db => 'notYonetici',
		unlist => true,
		intab => 'genel,diger',
		stil => 'textarea',
		rows => '3',
		cols => '64',
		gerekli => '1'
	),

	array(
		isim => 'Paraşüt ID',
		db => 'parasutID',
		unlist => true,
		stil => 'normaltext',
		width => 100,
		intab => 'pazaryeri'
	),
	array(
		isim => 'Kullanıcı Adı',
		db => 'username',
		zorunlu => 1,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Şifre',
		db => 'password',
		zorunlu => 1,
		isPassword => true,
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Davet Eden Kullanıcı',
		db => 'davetUserID',
		width => 70,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'user',
			base => 'ID',
			name => 'username',
		),
		detailLink => 's.php?f=users.php&y=d&ID={%%}',
		detailText => '<i class="fa fa-user"></i> Kullanıcı Detayları',
		nullValue => 'Direkt Kayıt',
		unlist => '1'
	),

	array(
		isim => 'Adı',
		db => 'name',
		zorunlu => 1,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Soyadı',
		db => 'lastname',
		zorunlu => 1,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'E-Posta Adresi',
		db => 'email',
		width => 139,
		zorunlu => 1,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Doğum Tarihi',
		db => 'birthdate',
		unlist => true,
		stil => 'date',
		gerekli => '1'
	),

	array(
		isim => 'Cinsiyeti',
		db => 'sex',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Adres',
		db => 'address',
		unlist => true,
		stil => 'textarea',
		rows => '4',
		cols => '32',
		gerekli => '1'
	),
	
	array(
        intab => 'adres',
        isim => 'Mahalle',
        db => 'mah',
        stil => 'dbpulldown',
        unlist => true,
        dbpulldown_data => array(
            db => 'mahalleler',
            base => 'ID',
            name => 'name',
            where=> 'parentID='.(int)hq("select semt from user where ID='".$_GET['ID']."'"),
        ),
        gerekli => '1'
    ),

	array(
		isim => 'Semt',
		unlist => true,
		db => 'semt',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ilceler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Şehir',
		unlist => true,
		db => 'city',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'iller',
			base => 'plakaID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Ülke',
		db => 'country',
		width => 282,
		unlist => true,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ulkeler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),


	array(
		isim => 'Fatura Adres',
		db => 'address2',
		unlist => true,
		stil => 'textarea',
		rows => '4',
		cols => '32',
		gerekli => '1'
	),

	array(
		isim => 'Fatura Semt',
		unlist => true,
		db => 'semt2',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ilceler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Fatura Şehir',
		unlist => true,
		db => 'city2',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'iller',
			base => 'plakaID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Fatura Ülke',
		db => 'country2',
		width => 282,
		unlist => true,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ulkeler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),


	array(
		isim => 'Ev Telefonu',
		db => 'evtel',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'İş Telefonu',
		db => 'istel',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Cep Telefonu',
		db => 'ceptel',
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'TC Kimlik Numarası',
		db => 'tckNo',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Firma Ünvanı',
		db => 'firmaUnvani',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Vergi Numarası',
		db => 'vergiNo',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Vergi Dairesi',
		db => 'vergiDaire',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'İzin Verilen (-) Bakiye (TL)',
		db => 'arti',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Kullanılabilir Bakiye (TL)',
		db => 'bakiye',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Sipariş Adet',
		db => 's_adet',
		width => 70,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Sipariş Toplam TL',
		db => 's_ciro',
		width => 90,
		stil => 'normaltext',
		align => 'right',
		gerekli => '1'
	),
	array(
		isim => 'E-Bülten Üyeliği',
		db => 'ebulten',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '1|Evet,2|Hayır',
		unlist => '1'
	),
	array(
		isim => 'SMS-Bülten Üyeliği',
		db => 'ebultenSMS',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '1|Evet,2|Hayır',
		unlist => '1'
	),
	/*
	array(
		isim => 'Varsayılan Dil',
		db => 'autolang',
		width => 400,
		unlist => true,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'langs',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),
	*/
	array(
		isim => 'Sadece BU IP Adreslerinden Girebilir',
		db => 'IPs',
		unlist => true,
		stil => 'textarea',
		rows => '4',
		cols => '32',
		gerekli => '1'
	),
	array(
		isim => 'Onaylı Üye',
		db => 'bayiStatus',
		width => 70,
		stil => 'checkbox',
		//  disable_inline => 1,
		//unlist=>(!siteConfig('uyeOnay') && !siteConfig('smsOnay')),
		gerekli => '0'
	),
	array(
		isim => 'Kayıt Tarihi',
		db => 'submitedDate',
		unlist => true,
		stil => 'date',
		gerekli => '1'
	),
);


if ($_SESSION['admin_isAdmin']) {
	$checkUser = array(
		array(
			isim => 'Admin Statüsünde Kullanıcı',
			db => 'isAdmin',
			width => 70,
			stil => 'checkbox',

			gerekli => '0'
		),
		array(
			isim => 'Yönetici Paneline Girebilir',
			db => 'isMod',
			width => 70,
			stil => 'checkbox',

			gerekli => '0'
		),
		array(
			isim => 'Erişebileceği Bölümler',
			db => 'accessTo',
			stil => 'multiplechoice',
			unlist => true,
			info => 'Admin statüsünde olan kullanıcılar, bu kısıma bakılmaksızın her yere erişebilir.',
			multiplechoice_data => array(
				db => 'adminmenu',
				base => 'ID',
				name => 'Adi',
				where => 'ID != 10 AND (parentID = 0 OR parentID = 10)',
				order => 'parentID,Sira',
			),
			gerekli => '0'
		),
	);
	$icerik = array_merge($icerik, $checkUser);
}
if ($_POST['bayiStatus']) {
	$oncekiDurum = hq("select bayiStatus from user where ID='" . $_POST['ID'] . "'");
	if (!$oncekiDurum && $_POST['bayiStatus'] == 'on') {
		$q = my_mysql_query("select * from sablonEmail where code='Kullanici_Onay'");
		$mergeArray = $_POST;
		$mail = my_mysql_fetch_array($q);		
		if($_POST['autolang'])
		{
			$body = $mail['body_'.$_POST['autolang']];
			$title = $mail['title_'.$_POST['autolang']];
			if($body)
				$mail['body'] = $body;
			if($title)
				$mail['title'] = $title;
		}
		$mail['body'] = mergeText($mail['body'], $mergeArray);
		my_mail($_POST['email'], $mail['title'], $mail['body'], getHeaders($siteConfig['adminMail']));
	}
}

if ($_GET['y'] == 'd') {
	updateUserOrderDB($_GET['ID']);
	$tempInfo .= adminInfov5('Bu kullanıcın bugüne kadar toplam <strong>' . (int) hq("select sum(adet) from sepet where userID='" . $_GET['ID'] . "' AND durum > 0 AND durum < 90") . '</strong> ürün satın aldı.<br /> Sepet bazında görüntülemek için <a target="_blank" href="s.php?f=sepet.php&userID=' . $_GET['ID'] . '"><strong>tıklayın</strong></a>.<br />Ürün bazında görüntülemek için <a target="_blank" href="s.php?f=sepetToplam.php&userID=' . $_GET['ID'] . '"><strong>tıklayın</strong></a>.','user');
	$tempInfo .= adminInfov5('Bu kullanıcın bugüne kadar <strong>' . my_money_format('', hq("select sum(toplamTutarTL) from siparis where userID='" . $_GET['ID'] . "' AND durum > 0 AND durum < 90")) . ' TL</strong> tutarında toplam <strong>' . (int) hq("select count(*) from siparis where userID='" . $_GET['ID'] . "' AND durum > 0 AND durum < 90") . '</strong> siparişi var.<br /> Siparişlerini görüntülemek için <a target="_blank" href="s.php?f=tumSiparisler.php&userID=' . $_GET['ID'] . '"><strong>tıklayın</strong></a>.','user');
}

if ($_GET['y'] == 'd' && $siteConfig['aff_active'] && $_GET['showAff']) {
	$logDetay = '<div style="padding:10px;">' . affKazancTablo($_GET['ID'], 1) . '</div>';
	$payDetay = '<div style="padding:10px;">' . affLogTablo($_GET['ID']) . '</div>';
	$tempInfo .= v3Admin::generateSimpleBlock('Kullanıcı Affilate Log', '', $logDetay, 'grid740');
	$tempInfo .= v3Admin::generateSimpleBlock('Kullanıcı Ödeme Log', '', $payDetay, 'grid740');
}

if ($_GET['ID'] && !$_POST['email']) {
	if (!$_GET['setpay'])
		$tempInfo .= v5Admin::simpleButtonWithImage('', "$('#odemeModalForm').modal('show');", 'credit-card', 'Bu kullanıcıya ödeme URL oluştur', 'secondary');
	else {
		$payurl = 'https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'page.php?act=autopay&key=' . encrypt_decrypt('encrypt', $_GET['tutar'] . '|' . $_GET['bankaID'] . '|' . $_GET['ID']);

		$tel = str_replace(array(' ', '-', '+', '(', ')'), '', hq("select ceptel from user where ID='" . $_GET['ID'] . "'"));
		//if ($tel) 
		{
			$telPrefix = '9' . (substr($tel, 0, 1) == '0' ? '' : '0');
			$autoPaymentButtons .= '<br/>'.v5Admin::simpleButton('#', "window.open('https://api.whatsapp.com/send?phone=" . $telPrefix . $tel . "&text=Selamlar, Ödeme için bu bağlantıyı kullanabilirsiniz. " . urlencode($payurl) . "')", 'message-rounded-dots', 'WhatsApp ile Gönder', 'secondary');
		}
		//	$autoPaymentButtons.=v4Admin::simpleButtonWithImage('#',"window.open('https://api.whatsapp.com/send?phone=".$telPrefix.$tel."')",'btn-warning','<i class="fa fa-envelope-square"></i> SMS  ile Gönder','_self');
		//	$autoPaymentButtons.=v4Admin::simpleButtonWithImage('#',"window.open('https://api.whatsapp.com/send?phone=".$telPrefix.$tel."')",'btn-primary','<i class="fa fa-envelope"></i> E-Posta ile Gönder','_self');
		$tempInfo .= adminInfov5('Ödeme için kullanıcıya <a href="' . $payurl . '" target="_blank">' . $payurl . '</a> adresini iletebilirsiniz.<br />'.$autoPaymentButtons,'credit-card');
	}
}

if(file_exists('../cron-parasut.php') && $_GET['ID'] && !$_POST['email'])
{
	$tempInfo .= v5Admin::simpleButtonWithImage('', "window.open('../cron-parasut.php?up=PARASUT_USER&userID=".$_GET['ID']."');", 'user', 'Paraşüt Sisteminde Güncelle', 'success');
	
}
$tempInfo.='<div class="mb-5"></div>';
admin($dbase, $where, $icerik, $ozellikler);
if ($_GET['y'] == 'd' || $_GET['y'] == 'e') {
	echo "<script type='text/javascript'>$('.panel').css('marginBottom','600px');</script>";
}
echo v5Admin::simpleModal('odemeModalForm','Ödeme URL Oluşturma','<form id="demo-form" class="form-horizontal mb-lg" novalidate="novalidate">
<div class="form-group mb-3">
	<div class="">
		<input type="text" id="tutar" placeholder="Tutar (TL)" class="form-control" required="">
	</div>
</div>
<div class="form-group">
	<div class="">
		<select id="bankaID" class="form-select">
			'.getOptions('banka', 'bankaAdi', '(active=1 AND taksitOrani=1)', 'bankaAdi', 0).'
		</select>
	</div>
</div>
</form>','<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button><button onclick="odemeKaydet();" type="button" class="btn btn-primary">URL Oluştur</button>').'
	<script type="text/javascript">
		' . "
		function odemeKaydet()
		{
			window.location.href= 's.php?f=users.php&y=d&ID=".$_GET['ID']."&setpay=true&tutar=' + $('#tutar').val() + '&bankaID=' + $('#bankaID').val();
		}
	</script>
";
?>
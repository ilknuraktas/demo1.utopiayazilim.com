<?php
if(!isset($_SESSION['randStr']))
{
	require_once('session.php');
	require_once('lib-db.php');
	require_once('conf.php');
	require_once('lib-sec.php');
	require_once('sec.php');
	require_once('start.php');
	require_once('lib.php');
}
//error_reporting(E_ALL);
//if ($_GET['act'] == 'win' && siteConfig('proCark_active') && $_GET['ID'] && $_GET['check'] == md5($_SESSION['modCark_randStr'] . $_GET['ID']) && !hq("select ID from promosyon where code = '" . addslashes($_SESSION['modCark_randStr']) . "'")) 
if ($_GET['act'] == 'win') 
{
	$code = (string)addslashes($_SESSION['modCark_randStr']);
	$q = my_mysql_query("select * from procark where ID='" . (int)$_GET['ID'] . "'");
	$d = my_mysql_fetch_array($q);
	if (!my_mysql_num_rows($q))
		exit('Veri Tabanı Hatası Alındı!');
	my_mysql_query("insert into promosyon (code,percent,ammount,min,userID,starih,tarih) values('$code','" . $d['percent'] . "','" . $d['amount'] . "','" . siteConfig('proCark_min2') . "','".$_SESSION['userID']."',now(), '" . date('Y-m-d', mktime((date('H')), date('i'), date('s'), date('m'), date('d') + (int)siteConfig('proCark_gun'), date('Y'))) . "')",1);
	if($_SESSION['randStr'] == $_SESSION['modCark_randStr'])
	{
		if(!hq("select ID from siparis where randStr = '$code'"))
			my_mysql_query("insert into siparis (ID,randStr,tarih) values(null,'" . $_SESSION['randStr'] . "','" . date('Y-m-d H:i:s') . "')");
		my_mysql_query("update siparis set promotionCode = '". $code . "' where randStr like '" . $code . "'",1);
	}
	
	unset($_SESSION['modCark_randStr']);
	exit('Promosyon Kodunuz sepetinize tanımlandı.<br /><div class="basket-button"><a href=\''.slink('sepet').'\'>Sepete Dön</a></div>');
	
} else if ($_GET['act'] == 'win' && ($_SESSION['admin_isAdmin'] || $shopphp_demo)) {
	exit('Promosyon Kodu :<br /><input type="text" class="pro-code" value="DEMO-' . rand(10000, 99999) . '">');
} else if ($_GET['act'] == 'win') {
	exit('Hatalı Giriş');
}

if ($_GET['act'] == 'wheel_data') {

	header('Content-type: application/json');
	if (!$shopphp_demo && (!$_SESSION['modCark_randStr'] || (!siteConfig('proCark_active') && !siteConfig('proCark_preactive') && !$_SESSION['admin_isAdmin'])))
		exit();
	$q = my_mysql_query("select * from procark");
	while ($d = my_mysql_fetch_array($q)) {
		$segmentValuesArray[] = array(
			"probability" => 100,
			"type" => "string",
			"value" => str_replace('"', '', addslashes($d['title'])),
			"win" => true,
			"resultText" => "TEBRİKLER!",
			"userData" => array("ID" => $d['ID'], "check" => md5($_SESSION['modCark_randStr'] . $d['ID']))
		);
	}

	$data = array(
		"colorArray" => array("#364C62", "#F1C40F", "#E67E22", "#E74C3C", "#95A5A6", "#16A085", "#27AE60", "#2980B9", "#8E44AD", "#2C3E50", "#F39C12", "#D35400", "#C0392B", "#BDC3C7", "#1ABC9C", "#2ECC71", "#E87AC2", "#3498DB", "#9B59B6", "#7F8C8D"),

		"segmentValuesArray" => $segmentValuesArray,
		"svgWidth" => 1024,
		"svgHeight" => 768,
		"wheelStrokeColor" => "#D0BD0C",
		"wheelStrokeWidth" => 18,
		"wheelSize" => 700,
		"wheelTextOffsetY" => 80,
		"wheelTextColor" => "#EDEDED",
		"wheelTextSize" => "2.3em",
		"wheelImageOffsetY" => 40,
		"wheelImageSize" => 50,
		"centerCircleSize" => 360,
		"centerCircleStrokeColor" => "#F1DC15",
		"centerCircleStrokeWidth" => 12,
		"centerCircleFillColor" => "#EDEDED",
		"segmentStrokeColor" => "#E2E2E2",
		"segmentStrokeWidth" => 4,
		"centerX" => 512,
		"centerY" => 384,
		"hasShadows" => false,
		"numSpins" => -1,
		"spinDestinationArray" => array(),
		"minSpinDuration" => 6,
		"gameOverText" => "TEŞEKKÜRLER!",
		"invalidSpinText" => "HATA OLUŞTU. LÜTFEN TEKRAR DENEYİN",
		"introText" => "HEMEN KAZAN!",
		"hasSound" => true,
		"gameId" => $_SESSION['randStr'],
		"clickToSpin" => true,
		"spinDirection" => "ccw"

	);

	exit(json_encode($data));
}

function proCarkInfo()
{	
	$check = date('Y-m-d H:i:s',mktime(date('H') - 24,date('i'),date('s'),date('m'),date('d'),date('Y')));
	if(hq("select ID from promosyon where userID='".$_SESSION['userID']."' AND starih > '" . $check ."'"))
	{
		$tarih = hq("select starih from promosyon where userID='".$_SESSION['userID']."' order by ID desc limit 0,1");
		$datetime1 = new DateTime(date('Y-m-d H:i:s'));
		$datetime2 = new DateTime($tarih);
		$datetime2->modify('+1 day');
		$difference = $datetime1->diff($datetime2);
		$out = $difference->h.' saat '.$difference->i.' dakika sonra promosyon çarkı kampanyasından tekrar faydalanabilirsiniz.';
	}
	
	else if(!$_SESSION['userID'] || !siteConfig('proCark_preactive') || hq("select ID from promosyon where code = '" . addslashes($_SESSION['randStr'])."'") || hq("select ID from siparis where  bakiyeOdeme=1 AND randStr = '" . addslashes($_SESSION['randStr'])."'") )
	{
		return;
	}
	else if(basketInfo('ModulFarkiIle', $_SESSION['randStr']) >= siteConfig('proCark_min1'))
	{
		$url =  slink('procark', $_SESSION['randStr'] . '_' . md5(hq("select ID from siparis where randStr = '".$_SESSION['randStr']."'"). $_SESSION['randStr']));

		if(siteConfig('proCark_min1')) 
			$out = '<div style="clear:both">&nbsp;</div>Tebrikler. Yaptığınız <strong>' . my_money_format('', siteConfig('proCark_min1')) . ' ' . fiyatBirim('TL') . '</strong> üzeri alışveriş ile birlikte promosyon kodu çekilişine hak kazandınız. Hemen <a href="'.$url.'">buraya tıklayın</a> ve bu alışverişinizde kullanabileceğiniz promosyon kodunuzu hemen alın.';	
			
	}
	else
	{
		$fark = my_money_format('', (siteConfig('proCark_min1') - basketInfo('ModulFarkiIle', $_SESSION['randStr']) ));
		$out = '<div style="clear:both">&nbsp;</div>Tebrikler. Sepetinize <strong>' . $fark . ' ' . fiyatBirim('TL') . '</strong> \'lik daha ürün ekeyerek, bu alışverişinizde kullanabileceğiniz promnosyon kodu çarkını çevirmeye hak kazanabilirsiniz.';	
	}
	return '<div class="sepet-info">' . $out .'</div>';
}

function procarkURL($d)
{
	global $siteDizini;
	if ($d['durum'] == '2') {
		return 'http' . (siteConfig('httpsAktif') ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . slink('procark', $d['randStr'] . '_' . md5($d['ID']. $d['randStr']));
	}
}
if($shopphp_demo || !siteConfig('proCark_preactive'))
	$siteConfig['proCark_active'] = 1;
function proarckMailGonder($randStr)
{
	if(!hq("select userID from siparis where randStr = '$randStr'"))
		return;
	if (!siteConfig('proCark_active') && !siteConfig('proCark_preactive'))
		return generateTableBox('Hata', 'Promosyon Çarkı Pasif Durumda', tempConfig('formlar'));
	global $siteDizini;

	$qTemplate = my_mysql_query("select * from sablonEmail where code like 'Promosyon_Cark'");
	if (!my_mysql_num_rows($qTemplate) || hq("select toplamTutarTL from siparis where randStr = '$randStr'") < siteConfig('proCark_min1') || ((int)hq("select durum from siparis where randStr = '$randStr'") < 2))
		return;
	$dTemplate = my_mysql_fetch_array($qTemplate);
	$actURL = 'http' . (siteConfig('httpsAktif') ? 's' : 's') . '://' . $_SERVER['HTTP_HOST'] . $siteDizini . slink('procark', $randStr . '_' . md5(hq("select ID from siparis where randStr = '$randStr'"). $randStr));
	$str = '<div style="clear:both">&nbsp;</div>Tebrikler. Yaptığınız <strong>' . my_money_format('', siteConfig('proCark_min1')) . ' ' . fiyatBirim('TL') . '</strong> üzeri alışveriş ile birlikte promosyon kodu çekilişine hak kazandınız. Hemen <a href="'.$actURL.'"><strong>buraya tıklayın</strong></a> ve bir sonraki <strong>' . my_money_format('', siteConfig('proCark_min2')) . ' ' . fiyatBirim('TL') . '</strong> ve üzerindeki alışverişinizde kullanabileceğiniz promosyon kodunuzu hemen alın.';
	$mergeArray = array(
		'TUTAR_1' => my_money_format('', siteConfig('proCark_min1')) . ' ' . fiyatBirim('TL'),
		'TUTAR_2' => my_money_format('', siteConfig('proCark_min2')) . ' ' . fiyatBirim('TL'),
		'ACT_procark' => $actURL
	);
	$header = getHeaders(siteConfig('adminMail'));
	$mail = new spEmail();
	$mail->headers = $header;
	$mail->to = hq("select email from siparis where randStr like '" . $randStr . "'");
	$mail->subject = $dTemplate['title'];
	$mail->body = autoPaymentMerge($randStr,$dTemplate['body']);
	$mail->mergeArray = $mergeArray;
	$mail->send();

	return $str;
}

$procarkIsBlock = false;
function procarkBlock()
{
	if ($_GET['act'] == 'procark')
		return;
	global $procarkIsBlock, $shopphp_demo;
	$procarkIsBlock = true;
	return ($shopphp_demo ? '<div style="min-height:220px; cursor:pointer" onclick="window.location.href = \'' . slink('procark', 'demo') . '\'">' : '<div style="min-height:220px;">') . myprocark() . '</div>';
}

function procarkScreen()
{
	$check = date('Y-m-d H:i:s',mktime(date('H') - 24,date('i'),date('s'),date('m'),date('d'),date('Y')));

	if(!siteConfig('proCark_useractive') || $_SESSION['user_procark_loaded'] || hq("select ID from promosyon where userID='".$_SESSION['userID']."' AND starih > '".$check."'")) return;

	global $procarkIsBlock,$proCarkInfo;

	$proCarkInfo = '<center><h5>'.(float)siteConfig('proCark_min1') . ' ' . fiyatBirim('TL') . ' ve üzeri alışverişerde...</h5></center><br><br>';
	$procarkIsBlock = true;
	$code = $_SESSION['randStr'];
	if(!hq("select ID from siparis where randStr = '$code'"))
		my_mysql_query("insert into siparis (ID,randStr,tarih) values(null,'" . $_SESSION['randStr'] . "','" . date('Y-m-d H:i:s') . "')");
	$_GET['op'] = $_SESSION['randStr'] . '_' . md5(hq("select ID from siparis where randStr = '".$_SESSION['randStr']."'"). $_SESSION['randStr']);

	$style = '
		<style>
			.open_splash {display: none;}
			#shopphp-auto-splash2 { width:1024px; height:800px; overflow:hidden; } 
			#shopphp-auto-splash { width:800px;  height:800px; overflow:hidden; } 
			@media only screen and (max-width: 800px) {
				#procark button { font-size:16px; }
				#shopphp-auto-splash { width:750px; height:800px;  overflow:hidden; } 
			}
			@media only screen and (max-width: 600px) {
				#shopphp-auto-splash { width:550px; height:600px;  overflow:hidden; } 
			}
			@media only screen and (max-width: 400px) {
				#shopphp-auto-splash { width:100%; height:400px;  overflow:hidden; } 
			}

	
		</style>
	';
	$js = '<script type="text/javascript">
			window.addEventListener("load", (event) => { 
			  $.fancybox("#shopphp-auto-splash");
			  $(".toast").click(function() { $(".spinBtn").click();  });
			});
	     </script>';
	$out = '<div class="open_splash"><div id="shopphp-auto-splash" class="splash">';
	$out.=myprocark().'</div></div>';

	$_SESSION['user_procark_loaded'] = 1;
	return $style .  $out . $js ;
}

function myprocark()
{
	global $procarkIsBlock, $shopphp_demo, $proCarkInfo;

	if(!$_SESSION['userID'])
		return generateTableBox('Hata', 'Promosyon çarkını kullanabilmek için lütfen <a href="'.slink('login').'">üye girişi</a> yapın.', tempConfig('formlar'));
	if (!siteConfig('proCark_active') && !siteConfig('proCark_preactive') && !$_SESSION['admin_isAdmin'])
		return generateTableBox('Hata', 'Promosyon Çarkı Pasif Durumda', tempConfig('formlar'));
	
	autoAddFormField('promosyon', 'starih', 'DATE');
	autoAddFormField('promosyon', 'userID', 'INT');

	$check = date('Y-m-d H:i:s',mktime(date('H') - 24,date('i'),date('s'),date('m'),date('d'),date('Y')));

	if(hq("select ID from promosyon where userID='".$_SESSION['userID']."' AND starih > '".$check."'"))
		return generateTableBox('Hata', 'Promosyon çarkı kampanyasından 24 saat içerisinde bir defa yararlanabilirsiniz.', tempConfig('formlar'));
	list($randStr, $check) = explode('_', $_GET['op']);
	$randStr = addslashes($randStr);
	$check = addslashes($check);

	if ($_GET['op'] == 'info')
		$procarkIsBlock = true;

	if ((!$procarkIsBlock && ($_GET['op'] != 'info') && !($_GET['op'] == 'demo' && $_SESSION['admin_isAdmin']) && !$shopphp_demo && $check != md5(hq("select ID from siparis where randStr = '" . $randStr . "' && (durum <90)  && ".basketInfo('ModulFarkiIle', $randStr)." >= '" . (float)siteConfig('proCark_min1') . "'").$randStr)) || hq("select ID from promosyon where code = '".$randStr."'") && $_GET['act'] == 'procark')
		return generateTableBox('Hata', 'Sipariş numarası / güvenlik kodu hatalı veya bu sipariş için daha önce promosyon kodu kullanılmış.', tempConfig('formlar'));

	$_SESSION['modCark_randStr'] = $randStr;
	if (!$_SESSION['modCark_randStr'] && $shopphp_demo)
		$_SESSION['modCark_randStr'] = 'demo';
	
	$out = '';
	if($randStr != $_SESSION['randStr'])
		$out.= '<div class="cark-tebrik"><p>TEBRİKLER!</p><br/>Yaptığınız alışveriş sonucunda, bir sonraki <strong>' . my_money_format('', siteConfig('proCark_min2')) . ' ' . fiyatBirim('TL') . ' ve üzeri</strong> alışverişinizde kullanabileceğiniz promosyon kodu kazanma şansı yakaladınız. Alacağınız promosyon kodunu <strong>' . siteConfig('proCark_gun') . ' gün</strong> içerisinde kullanabilirsiniz.<div class="clear-space">&nbsp;</div></div>';
	$out .= '
	
	<link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="include/3rdparty/ProCark/css/style.css">
	<div id="procark">
	'.$proCarkInfo.'
	' . ($procarkIsBlockx ? '<style>.toast,.cark-tebrik { display:none;}</style> Yapacağınız <strong>' . my_money_format('', siteConfig('proCark_min1')) . ' ' . fiyatBirim('TL') . '</strong> üzeri alışverişten sonra ücretsiz çekilişe katılın. ' : '<button class="spinBtn">ÇEVİR KAZAN!</button>') . '
    <div class="wheelContainer">
        <svg class="wheelSVG" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" text-rendering="optimizeSpeed">
            <defs>
                <filter id="shadow" x="-100%" y="-100%" width="550%" height="550%">
                    <feOffset in="SourceAlpha" dx="0" dy="0" result="offsetOut"></feOffset>
                    <feGaussianBlur stdDeviation="9" in="offsetOut" result="drop" />
                    <feColorMatrix in="drop" result="color-out" type="matrix" values="0 0 0 0   0
              0 0 0 0   0 
              0 0 0 0   0 
              0 0 0 .3 0" />
                    <feBlend in="SourceGraphic" in2="color-out" mode="normal" />
                </filter>
            </defs>
            <g class="mainContainer">
                <g class="wheel">

                </g>
            </g>
            <g class="centerCircle" />
            <g class="wheelOutline" />
            <g class="pegContainer" opacity="1">
                <path class="peg" fill="#EEEEEE" d="M22.139,0C5.623,0-1.523,15.572,0.269,27.037c3.392,21.707,21.87,42.232,21.87,42.232 s18.478-20.525,21.87-42.232C45.801,15.572,38.623,0,22.139,0z" />
            </g>
            <g class="valueContainer" />
        </svg>
       <div class="toast">
            <p/>
        </div> 
    </div>
	</div>
	<div class="clear-space"></div>
	' . "
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/utils/Draggable.min.js'></script>
    <script src='include/3rdparty/ProCark/js/ThrowPropsPlugin.min.js'></script>
    <script src='include/3rdparty/ProCark/js/Spin2WinWheel.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/TextPlugin.min.js'></script>
	<script src='include/3rdparty/ProCark/js/index.js'></script>
	<div style='clear:both;'></div>
";
	return ($procarkIsBlock && $_GET['op'] != 'info' ? $out : generateTableBox('Promosyon Çarkı ' . ($shopphp_demo ? '*** Demo ***' : ''), $out, tempConfig('formlar')));
}

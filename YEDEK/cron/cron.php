<?
/* 
Yönetim panelinden admin yetlisine sahip bir kullanıcı ekleyin. Yetkili kullanıcı adı ve şifreyi aşağıya, iki tek tırnak arasına tanımlayın. 
Örnek :
$user = 'cron-admin';
$pass = 'QTg4diOQTs';
*/
$user = '';
$pass = '';

/* 
Bu satıra, iki tek tırnak arasında secure/XML/ klasöründe bulunan update dosyası ismini yazın. 
Örnek : (/secure/XML/updatearenav4.php dosyası için ise)
$dosya = 'updatearenav4.php'; 
*/
$dosya = ''; 

/* Bu satıra 1 değeri verirseniz ürün ve kategori bilgileri güncellenir. 0 değeri verirseniz ürünler güncellenmez.*/
$indexKatalog = 1; 

/* 
Hem bir üst satıra (indexKatalog) hem de bu satıra 1 değeri verirseniz ürün bilgileri ile birlikte resimleri de download edilir. Eğer resim zaten download edilmişse, tekrar download edilmez. 0 değeri verirseniz resimler güncellenmez
*/
$indexResim = 1;

/* Üründe fiyat ve stok güncellemesi yapmak istiyorsanız bu satırı 1 olarak girin. */
$indexFiyat = 1; 

/*	indexFiyat açıksa ve satırada 1 değeri verildiyse fiyatları günceller. */
$indexFSStok = 1;

/*	indexFiyat açıksa ve satırada 1 değeri verildiyse stokları günceller. */
$indexFSFiyat = 1; 

/*
Fiyat güncellerken set edilen kar marjı. 0.20 ile gelen fiyata %20 eklenir. Eğer bir kategoride, XML kar marjı girilmişse, sadece o kategori için bu değer değil, kategoriye girilen değer geçerli olur.
Örnek :
$kar = 0.20

yaparsak fiyatlara %20 kar marjı eklenerek kayıt edilir. 0 yaparsan kar eklenmeden kayıt edilir.
*/
$kar = 0; 

/* Bu satırdan sonrasını düzenlemenize gerek yoktur. */
include('../include/all.php');

@set_time_limit(0);
ignore_user_abort(true);
my_mysql_query("SET GLOBAL TRANSACTION ISOLATION LEVEL READ UNCOMMITTED");

$url = 'https://'.$_SERVER['HTTP_HOST'].$siteDizini;
for($i = 0;$i<=9;$i++)
{
	
	$u = $url.'/secure/s.php?username='.$user.'&password='.$pass.'&f=XML/'.$dosya.'&isCron=1&xmlUpdate=1&y=e&kar='.$kar.'&parentID=&indexKatalog='.$indexKatalog.'&indexFiyat='.$indexFiyat.'&indexResim='.$indexResim.'&indexFSStok='.$indexFSStok.'&indexFSFiyat='.$indexFSFiyat.'&dilim='.$i.'&rand='.rand(0,1000);

	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_URL,$u);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 59);
	$x = curl_exec($ch);
	curl_close($ch);

	$durum = (substr($x,-2) == 'OK' ? 'Tamamlandı.':'Hata var.');
	$out.= $i.' '.$dosya.': OK. Size : '.strlen($x).'.'.$ux.'. Durum : '.$durum.'<br>';
	
}

function adminErrorv3($d)
{
	return $d.'<br>';
}

function adminInfov3($d)
{
	return $d.'<br />';
}

if($_SESSION['admin_isAdmin']) 
{	
	include('secure/include/xmlImport.php');
	echo 'Log : <br>'.$out.'<pre>'.utf8_decode(getTemp('xmlLog')).'</pre>';
}
else
	echo 'Detay görmek için yönetici girişi yaptın. <br />Log : <br>'.$out;
?>
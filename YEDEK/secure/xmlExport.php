<?
$disablehelp = 0;
$userGroupFirstID = (int)hq("select ID from userGroups Order by ID desc limit 0,1");
$xmlArray = array(
	'Shopphp' => array('kar'=>1,'code'=>'shopphp','url'=>'xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.checkx()),0,10),'info'=>'<hr />* URL adresine &username=KULLANICI_ADI&password=SIFRE ekleyip bayi gruba özel XML çıktı alabilirsiniz. Örnek Kullanım : <br /><nobr>/xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.checkx()),0,10).'&username=KULLANICI_ADI&password=SIFRE</nobr><hr />
	<br>* URL adresine &start=0&limit=100 ekleyerek row için başlangıç değeri ve row sayısı verebilirsiniz. Örnek Kullanım : <br /><nobr>/xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.checkx()),0,10).'&start=0&limit=100</nobr>
	<br /><nobr>/xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.checkx()),0,10).'&start=100&limit=100<br /></nobr>'),
	'Alternatif' => array('code'=>'alter','url'=>'xml.php?c=alter&xmlc='.substr(md5('alter'.checkx()),0,10)),   
	'Alternatif 2' => array('code'=>'alter2','url'=>'xml.php?c=alter2&xmlc='.substr(md5('alter2'.checkx()),0,10)),    
	'RSS' => array('code'=>'rss','url'=>'xml.php?c=rss&xmlc='.substr(md5('rss'.checkx()),0,10)),
	'Google Sitemap'=>array('code'=>'google','url'=>'sitemap.xml','info'=>'<br/>* Aktif servis her 3 saatte bir Google\'a otomaik submit edilir.<br/>* Sitemap XML servisini bölmek için sitemap.xml yerine <br /><br />sitemap_&lt;Başlanıç Ürün&gt;_&lt;Toplam Ürün&gt;.xml<br /><br /> gibi kullanabilirsiniz. Örneğin sitemap_0_100.xml 0. üründen başlayarak 100 adet ürün getirir.'),
	'Google Image Map'=>array('code'=>'googleimage','url'=>'imagemap.xml'),
	'Google Merchant'=>array('code'=>'googlemerchant','url'=>'xml.php?c=googlemerchant&xmlc='.substr(md5('googlemerchant'.checkx()),0,10),'info'=>'<br /><br />Tam entegrasyon için kategorilere Google Merchant Kategori karşılığının dolduruması gerekir.'),
	'Akakçe'=>array('code'=>'akakce','url'=>'xml.php?c=akakce&xmlc='.substr(md5('akakce'.checkx()),0,10)),
	'Bayi Cepte'=>array('code'=>'bayicepte','url'=>'xml.php?c=bayicepte&xmlc='.substr(md5('bayicepte'.checkx()),0,10)),
	'Çiçek Sepeti'=>array('kar'=>1,'code'=>'ciceksepeti','url'=>'xml.php?c=ciceksepeti&xmlc='.substr(md5('ciceksepeti'.checkx()),0,10)),
	'Facebok Product'=>array('code'=>'facebookproduct','url'=>'xml.php?c=facebookproduct&xmlc='.substr(md5('facebookproduct'.checkx()),0,10),'info'=>'<br /><br />Tam entegrasyon için kategorilere Google Merchant Kategori karşılığının dolduruması gerekir.'),
	'Yandex Market'=>array('code'=>'yandexmarket','url'=>'xml.php?c=yandexmarket&xmlc='.substr(md5('yandexmarket'.checkx()),0,10)),
	'Cimri' => array('code'=>'cimri','url'=>'xml.php?c=cimri&xmlc='.substr(md5('cimri'.checkx()),0,10)),
	'Fırsat bu Fırsat' => array('code'=>'fbf','url'=>'xml.php?c=fbf&xmlc='.substr(md5('fbf'.checkx()),0,10)),
	'Fiyat Var' => array('code'=>'fiyatvar','url'=>'xml.php?c=fiyatvar&xmlc='.substr(md5('fiyatvar'.checkx()),0,10)),
	'Hızlı Al' => array('code'=>'hizlial','url'=>'xml.php?c=hizlial&xmlc='.substr(md5('hizlial'.checkx()),0,10)),
	'HepsiBurada XML' => array('code'=>'hb','url'=>'xml.php?c=hb&xmlc='.substr(md5('hb'.checkx()),0,10)),
	//'N11' => array('code'=>'n11','url'=>'xml.php?c=n11&xmlc='.substr(md5('n11'.checkx()),0,10)),
	'PTTAvm' => array('kar'=>1,'code'=>'pttavm','url'=>'xml.php?c=pttavm&xmlc='.substr(md5('pttavm'.checkx()),0,10)),
	'StockMount' => array('code'=>'stockmount','url'=>'xml.php?c=stockmount&xmlc='.substr(md5('stockmount'.checkx()),0,10)),
	'Ne Kadar' => array('code'=>'nekadar','url'=>'xml.php?c=nekadar&xmlc='.substr(md5('nekadar'.checkx()),0,10)),	
	'Tüm Fırsatlar' => array('code'=>'tf','url'=>'xml.php?c=tf&xmlc='.substr(md5('tf'.checkx()),0,10)),
	'Bilio (Ucuzu)' => array('code'=>'ucuzcu','url'=>'xml.php?c=ucuzcu&xmlc='.substr(md5('ucuzcu'.checkx()),0,10)),
	'Gelir Ortakları' => array('code'=>'go','url'=>'xml.php?c=go&xmlc='.substr(md5('go'.checkx()),0,10)),
	'Siparişler' => array('code'=>'siparisler','url'=>'xml.php?c=siparisler&xmlc='.substr(md5('siparisler'.checkx()),0,10)),
	'Siparişler (BirFatura)' => array('code'=>'birfaturasiparisler','url'=>'xml.php?c=birfaturasiparisler&xmlc='.substr(md5('birfaturasiparisler'.checkx()),0,10)),
	'Siparişler (Entegra)' => array('code'=>'entegrasiparisler','url'=>'xml.php?c=entegrasiparisler&xmlc='.substr(md5('entegrasiparisler'.checkx()),0,10)),
	'Siparişler (Logo)' => array('code'=>'automSiparisLogo','url'=>'xml.php?c=automSiparisLogo&xmlc='.substr(md5('automSiparisLogo'.checkx()),0,10)),
	'Yurtici Kargo Siparişler' => array('code'=>'yurticikargosiparisler','url'=>'xml.php?c=yurticikargosiparisler&xmlc='.substr(md5('yurticikargosiparisler'.checkx()),0,10)),
	'Kullanıcı Listesi' => array('code'=>'kullanicilar','url'=>'xml.php?c=kullanicilar&xmlc='.substr(md5('kullanicilar'.checkx()),0,10)),	
	'HepsiBurada Excel' => array('code'=>'hb-excel','url'=>'xml.php?c=hb-excel&xmlc='.substr(md5('hb-excel'.checkx()),0,10)),
	//'Trendyol Excel' => array('code'=>'trendyol-excel','url'=>'xml.php?c=trendyol-excel&xmlc='.substr(md5('trendyol-excel'.checkx()),0,10)),
	'Ürün Varyasyon Listesi Excel' => array('code'=>'urun-var','url'=>'secure/excelProductVar.php'),
	'Bayi Grubu Ürün Listesi Excel'  => array('code'=>'bayi','url'=>'secure/excelUserGroup.php?userGroupID='.$userGroupFirstID,'info'=>'<hr />* userGroupID=&lt;Bayi Grubu ID&gt; ekleyip bayi gruba özel ürün excel listesi alabilirsiniz. Örnek ID '.$userGroupFirstID.' olan Bayi Grubu için Kullanım : <br /><nobr>https://'.$_SERVER['HTTP_HOST'].$siteDizini.'secure/excelUserGroup.php?userGroupID='.$userGroupFirstID.''),
);
$dbase='xmlexport';
$title = 'XML Servis Ayarları';
$listTitle = 'XML Servisleri';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					orderby=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					updateDisabled =>true,
					insertDisabled =>true,
					editID=>1,
					);

if($_POST['ID'] && $_POST['y'] == 'du')
{
	my_mysql_query("update xmlexport set status = 0");	
}
$icerik[] = array(isim=>'XML Çıktı Cache Süresi / Saniye<br />(3600 = 1 saat)',
					  db=>'xml_cache',
					  stil=>'normaltext',
					  gerekli=>'0');
if(isset($_POST['xml_cache']))
{
	autoAddFormField('siteConfig','xml_cache','TEXTBOX');
	$siteConfig['xml_cache'] = (int)$_POST['xml_cache'];
	my_mysql_query("update siteConfig set xml_cache = '".(int)$_POST['xml_cache']."' where ID = 1");
}
$lang = getLangArr();
unset($lang['tr']);
foreach($xmlArray as $k=>$v)
{
	$showSPError = 1;
	if($_POST[$v[code]])
	{
		my_mysql_query("update xmlexport set status = 1,data1='".$_POST[$v[code].'_kar']."' where code like '".$v[code]."'");
		if(!my_mysql_affected_rows())
			my_mysql_query("insert into xmlexport (ID,code,status,data1) VALUES (0,'".$v[code]."',1,'".$_POST[$v[code].'_kar']."')");			
	}
	else if($_POST[$v[code].'_kar'])
	{
		my_mysql_query("update xmlexport set data1='".$_POST[$v[code].'_kar']."' where code like '".$v[code]."'");
		if(!my_mysql_affected_rows())
			my_mysql_query("insert into xmlexport (ID,code,data1) VALUES (0,'".$v[code]."','".$_POST[$v[code].'_kar']."')");			
	}
	$checked = hq("select status from xmlexport where code like '".$v[code]."'");
	$val = hq("select data1 from xmlexport where code like '".$v[code]."'");
	$url = '<a href="https://'.$_SERVER['HTTP_HOST'].$siteDizini.$v['url'].'" target="_blank">https://'.$_SERVER['HTTP_HOST'].$siteDizini.$v['url'].'</a>';
	foreach($lang as $kx=>$vx)
	{
		$url.='<br />'.'<a href="https://'.$_SERVER['HTTP_HOST'].$siteDizini.'ln-'.$kx.'/'.$v['url'].'" target="_blank">https://'.$_SERVER['HTTP_HOST'].$siteDizini.'ln-'.$kx.'/'.$v['url'].'</a> - ('.$vx.')';
	}

	if($checked)
		$script.="$('#".$v[code]."').attr('checked','checked');\n";
	$icerik[] = array(isim=>$k,
					  db=>$v['code'],
					  stil=>'checkbox',
					  info => $url.$v['info'],
					  gerekli=>'0');	
	if($v['kar'])
		$icerik[] = array(isim=>$k.' Kar Marjı',
					db=>$v['code'].'_kar',
					stil=>'normaltext',
					info => '<script>$(\'#'.$v[code].'_kar\').val(\''.addslashes($val).'\');</script>Ör : %10 kar marjı için 0.1 girin.',
					gerekli=>'0');
}
if ($_GET['code'] == 'XML_Shopphp') 
	$tempInfo.= adminInfov5('https://'.$_SERVER['HTTP_HOST'].$siteDizini.'xml.php?c='.strtolower(str_replace('XML_','',$_GET['code'])).'&username=KULLANICIADI&password=SIFRE<br>adresi ile bayileriniz kendilerine özel tanımlanan fiyatlar ile XML çekimi yapabilir.');
echo adminv3($dbase,$where,$icerik,$ozellikler);
?>
<style>
	.overflow-x-auto { overflow: visible !important;}
	</style>
<script type="text/javascript">
	$('#xml_cache').val('<?=siteConfig('xml_cache')?>');
	$('#bayi,#urun-var').attr('checked','checked');
	<?=$script?>
</script>
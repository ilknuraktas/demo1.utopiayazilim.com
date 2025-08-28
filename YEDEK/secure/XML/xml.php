<?
@set_time_limit(0);
//@ini_set('memory_limit', '4096M');
$dbase="urunXML";
if($_POST['indexFSFiyat'] || $_POST['indexFSStok'])
	$_POST['indexFiyat'] = 1;
if ($_GET['debug-xml'])
{
	$_GET['xmlUpdate'] = $_POST['indexKatalog'] = $_GET['err'] = 1;
	if(!$_GET['dilim'])
		$_GET['dilim'] = 0;
}

if ($_GET['debug-fiyat'])
{
	$_GET['xmlUpdate'] = $_POST['indexFiyat'] = $_GET['err'] = 1;
	if(!$_GET['dilim'])
		$_GET['dilim'] = 0;
}

if ($_GET['debug-cat'])
{
	$_GET['xmlUpdate'] = $_POST['indexKatalog'] = $_GET['err'] = 1;
	if(!$_GET['dilim'])
		$_GET['dilim'] = 0;
	$_GET['xmlCatCache'] = 1;
}

if ($_GET['xmlUpdate']) {
	if($_GET['err']) 
	{
		ini_set('display_errors', '1');	
		error_reporting(E_ALL);
	}
	include ('XML/'.$_GET['dosya']);	
}
//mysql_query("delete from xmlcatcache");
// simplexml_load_string($xml,'SimpleXMLElement', LIBXML_PARSEHUGE);
// $katalog = simplexml_load_file('bayiXML/xml.xml',SimpleXMLElement);
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					orderby=>'ID',
					listDisabled => true,
					updateDisabled =>true,
					insertDisabled =>true,
					buttonDisabled => false,
					//listBackMsg => $_POST['indexKatalog'],
					);

$icerik = array(
				array(isim=>'Güncelleme Durumu',
					  stil=>'customtext',
					  text=>'
					  	<div class="loadingbox" style="display:none;">
						  <div class="d-flex justify-content-center mb-2">
						  <div class="spinner-border" role="status">
							<span class="sr-only">Yükleniyor...</span>
						  </div>
						</div>
					  </div>
					  
					  <div id="xml-progress-bar-c" class="progress progress-striped light active m-md">
						<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="xml-progress-bar">
							0%
						</div>
					  </div>

					
					<div style="display:none;" class="xmlstats"></div>'), 
				array(isim=>'Entegrasyon Firma',
					  db=>'dosya',
					  stil=>'simplepulldown',
					  simpleValues=>xmlUpdateList(),
					  gerekli=>'1'),
				
				array(isim=>'Firma Kategorileri',
					  stil=>'customtext',
					  text=>'					  
					  
					  <div class="xmlcatcache"></div>
					  
					  <link rel="stylesheet" href="../templates/system/admin/templatev5/assets/vendor/libs/jstree/jstree.css" />
					  <script src="../templates/system/admin/templatev5/assets/vendor/libs/jstree/jstree.js"></script>			  
					  '),
				
				array(isim=>'Üst Kategori',
					  db=>'parentID',
					  stil=>'dbpulldown',
					  info=>'Seçilirse, XML servisinden gelen tüm kategoriler, bu kategorinin altına açılır.',
					  dbpulldown_data =>array(db=>'kategori',
					  						  base=>'ID',
											  name=>'namePath',
											  ),
					  gerekli=>'1'),
				
				array(isim=>'Varsayılan Kar Marjı',
					  info=>'%20 kar marjı için 0.2 girilmelidir.<br />%5 kar marjı için 0.05 girilmelidir.',
					  db=>'kar',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Hepsini Seç',
					  db=>'hepsi',
					  stil=>'checkbox',
					  gerekli=>'0'),  
				array(isim=>'Kategori Güncelle',
					  db=>'indexKategori',
					  info=>'Seçilmezse, olmayan bir kategoriyi açar, fakat olan bir kategori ağacına dokunmaz. Seçilirse, kategori ağaç tipini XML deki gelen veri ile eşitler.',
					  stil=>'checkbox',
					  gerekli=>'0'),  								  
				array(isim=>'Ürün Güncelle',
					  db=>'indexKatalog',
					  stil=>'checkbox',
					  gerekli=>'0'),
				array(isim=>'Ürün İsimlerini Güncelle',
					  db=>'indexIsim',
					  info=>'Sonradan yapılan düzenlemelerin üzerine yazar.',
					  stil=>'checkbox',
					  gerekli=>'0'),
				array(isim=>'Ürün Açıklamalarını Güncelle',
					  db=>'indexAciklama',
					  info=>'Sonradan yapılan düzenlemelerin üzerine yazar.',
					  stil=>'checkbox',
					  gerekli=>'0'),
				array(isim=>'Resim Güncelle',
					  db=>'indexResim',
					  stil=>'checkbox',
					  info=>'Resimleri download etmek için sunucu cron servisinize <strong>*** wget kullanarak***</strong><br /><a class="badge bg-primary uppercase-off mt-1 mb-1" href="https://'.$_SERVER['HTTP_HOST'].$siteDizini.'curl-download.php" target="_blank">https://'.$_SERVER['HTTP_HOST'].$siteDizini.'curl-download.php</a><br /> adresini 5dk da bir çağrılacak şekilde ekleyin. Sunucunuzda bu destek yoksa, <a href="https://www.cron-job.org" target="_blank">https://www.cron-job.org</a> adresinden ücretsiz hizmet alabilirsiniz.<hr />Eğer bir üründe resim kayıtlıysa, resim tekrar download edilmez.',
					  gerekli=>'0'),	
				array(isim=>'Fiyat Güncelle',
					  db=>'indexFSFiyat',
					  stil=>'checkbox',
					  gerekli=>'0'),
				array(isim=>'Stok Güncelle',
					  db=>'indexFSStok',
					  stil=>'checkbox',
					  gerekli=>'0'),	
				array(isim=>'',
					  stil=>'customtext',
					  text=>'<div style=" font-size:9px; color:#ccc;"><a href="#" onclick="debugXML(); return false;" style="color:#ccc;">Debug XML</a> | <a href="#" onclick="debugFiyat(); return false;" style="color:#ccc;">Debug Fiyat</a> | <a href="../curl-download.php" target="_blank" style="color:#ccc;">Debug Images #1</a> / <a href="../cron-download.php" target="_blank" style="color:#ccc;">Debug Images #2</a></div>'
					  ),	
					  
			 	);
$tempInfo.= adminInfov5('XML Servisinden gelen kategori yapısını dilediğiniz gibi kişiselleştirebilirsiniz. Tekrar kategori güncelleme yapmadığınız sürece, kategoriler kişiselleştirildiği gibi kalır. Firma tarafından yeni bir kategori eklendiğinde, kategori güncelleme seçilmediyse bile sitenize eklenir.');
$tempInfo.= adminInfov5('XML Servisi IP tanımlama gerektiriyorsa, ilgili firmaya <a href="https://'.$_SERVER['HTTP_HOST'].$siteDizini.'ip.php" target="_blank">https://'.$_SERVER['HTTP_HOST'].$siteDizini.'ip.php</a> adresinde gözüken IP numarasını iletin.');
$tempInfo.= adminInfov5('Resimleri download etmek için sunucu cron servisinize *** wget kullanarak*** <a href="https://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron/cron-download.php" target="_blank">https://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron/cron-download.php</a> veya <a href="https://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron/curl-download.php" target="_blank">https://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron/curl-download.php</a> adresini 5dk da bir çağrılacak şekilde ekleyin. Sunucunuzda bu destek yoksa, <a href="https://www.cron-job.org" target="_blank">https://www.cron-job.org</a> adresinden ücretsiz hizmet alabilirsiniz.');
$tempInfo.= adminInfov5('Entegrasyon sırasında sunucu yükünü ve timeout\'a düşme şansını azaltmak için ilk güncellemede kategori,ürün ve resim, sonraki güncellemede fiyat ve stok güncellemesi yapabilirsiniz.');
$tempInfo.= adminInfov5('Kategorileri çektikten sonra, kategori yönetiminden, her kategoriye özel farklı kar marjı tanımlayabilirsiniz.');


admin($dbase,$where,$icerik,$ozellikler);
?>
<script>
	$('.btn.btn-primary:first').click(function() {
		if (xmlCheckFields('indexKatalog,indexFSFiyat,indexFSStok,indexResim,indexIsim,indexAciklama', '<?php echo $_SERVER['REQUEST_URI'] . '&xmlUpdate=1&kar='; ?>' + $('#kar').val() + '&parentID=' + $('select[name=parentID]').val() + '&indexKatalog=' + $('#indexKatalog').is(':checked') + '&indexKategori=' + $('#indexKategori').is(':checked') + '&indexFSFiyat=' + $('#indexFSFiyat').is(':checked') + '&indexResim=' + $('#indexResim').is(':checked') + '&indexResimMulti=' + $('#indexResimMulti').is(':checked') + '&indexFSStok=' + $('#indexFSStok').is(':checked') + '&indexIsim=' + $('#indexIsim').is(':checked') + '&indexAciklama=' + $('#indexAciklama').is(':checked') + '&dosya=' + $('#dosya').val()));
		return false;
	});
	$('.body form').submit(function() {
		return false;
	});
	$(document).ready(function() {
		$('#dosya').change(xmlCatCacheUpdate);
	});
	$("#hepsi").change(function() {
		$('input:checkbox').not(this).prop('checked', this.checked);
	});
</script>
<?php 
include('include/all.php');
if (!$_GET['sipNo'] && $_GET['sipID']) $_GET['sipNo'] = dbInfo('siparis','randStr',$_GET['sipID']);
$q = my_mysql_query("select * from siparis where randStr = '".$_GET['sipNo']."'");
$siparisData = my_mysql_fetch_array($q);
if($siparisData['kargoSeriNox'])
	$siparisData['kargoSeriNo'] = $siparisData['kargoSeriNox'];
if($siparisData['upslabel'])
{
	exit(readcURL($siparisData['upslabel']));
}
$durum = $siparisData['durum'];
$firmaID = ($siparisData['kargoFirma']?$siparisData['kargoFirma']:$siparisData['kargoFirmaID']);
list($pazaryeri,$sipNo) = explode('-',$_GET['sipNo']);
?><html>
	<head>
		<title><?=$siparisData['randStr']?> Nolu Sipariş Kargo Detayları</title>
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/bootstrap/css/bootstrap.css" />
        <link href="../css/sepet.css" rel="stylesheet" type="text/css" />
        <style>
			#kargo-container { margin:auto; margin-top:10px; width:580px; padding:10px; height:auto; border:1px solid #ccc; }
			.img-logo { font-size:16px; font-weight:bolder; font-family:Tahoma; display:inline; }
			#site-logo { float:left; }
			#kargo-logo { float:right; }
			.basket-wrap { visibility:visible !important;}
			.basket-left { clear:both; width:100% !important; }
			.basket-right { clear:both; float:right; margin-top:15px !important; }
			.cart-detail img { max-height:65px; max-width:100px;}
			.cart-info h3 { padding:10px; color:#000 !important; font-size:12px !important;}
			.kargo-sepet {width:100%;}
            .kargo-sepet th,.kargo-sepet td { padding:5px; }
            .kargo-sepet .c { text-align: center; }
			.kapida-odeme { font-weight:bold; color:red; font-size:16px; text-align:center; }
			#yazdir { float:right; margin:10px; }
			th { font-size:16px;}
		</style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div id="kargo-container">
			<div id="site-logo">
				<?=($siteConfig['templateLogo']?'<img src="../images/'.$siteConfig['templateLogo'].'" alt="'.siteConfig('firma_adi').' Sipariş No '.$sipNo.'" />':'<div class="img-logo">'.$_SERVER['HTTP_HOST'].'</div>')?>
				<?
					
					switch(strtolower($pazaryeri))
					{
						case 'aka':
							$pazar = 'Akakçe';
						break;
						case 'az':
							$pazar = 'Amazon';
						break;
						case 'ty':
							$pazar = 'Trendyol';
						break;
						case 'n11':
							$pazar = 'N11';
						break;
						case 'hb':
							$pazar = 'Hepsiburada';
						break;
						case 'gg':
							$pazar = 'GittiGidiyor';
						break;
					}
					if($pazar)
						echo '<div style="clear:both"></div><div class="img-logo">('.$pazar.')</div>';
				?>
			</div>
			<div id="kargo-logo">
				<div class="img-logo"><?=hq("select name from kargofirma where ID='".$firmaID."'")?> <?=$siparisData['kargostr']?></div>
			</div>
			<div style="clear:both"></div>
			<center>
			<?
			/*
				if(siteConfig('kargo_arasUsername') && $durum > 50 && $durum < 90 && (int)$firmaID == (int)siteConfig('kargo_arasID'))
					echo arasKargoBarkod($siparisID);
				else
				*/
					echo '<img width="80%" src="../include/3rdparty/barcode.php?randStr='.($siparisData['kargoSeriNo']?$siparisData['kargoSeriNo']:$_GET['sipNo']).'">';
			?>
			</center>
			<div class="img-logo">Ürünler</div>
			<hr />
			<table class="kargo-sepet">
				<tr>
                    <th></th>
					<th>Ürün Adı</th>
					<th>Stok Kodu</th>
					<th>Adet</th>
					<th>Desi</th>

				</tr>
				<?
					$q = mysql_query("select sepet.* from sepet where sepet.randStr = '".$_GET['sipNo']."'") or die(mysql_error());
					while($d = my_mysql_fetch_array($q))
					{
						$d['tedarikciCode'] = hq("select tedarikciCode from urun where ID='".$d['urunID']."'");
						$kargoTR.='
                        <tr>
                            <td><img src="../images/urunler/'.hq("select resim from urun where ID=".$d['urunID']).'" width="50" /></td>
							<td>'.$d['urunName'].' | '.$d['ozellik1'].' '.$d['ozellik2'].' '.$d['ozellik3'].'</td>
							<td>'.($d['tedarikciCode']?$d['tedarikciCode'].' ('.$d['urunID'].')':$d['urunID']).'</td>
                            <td class="c">'.$d['adet'].'</td>
							<td class="c">'.hq("select desi from urun where ID=".$d['urunID']).'</td>
                            
						</tr>
						';
					}
					echo $kargoTR;
				?>
				</table>
			</table>
			<?
				$kapida = hq("select ID from banka where ID='".$siparisData['odemeID']."' AND paymentModulURL like '%kapida%'");
				if($kapida)
					echo "<hr /><div class='kapida-odeme'>Kapıda Ödemeli Gönderi : ".my_money_format('',$siparisData['toplamTutarTL'])." TL</div>";
			?>
			<hr />
			<div class="img-logo">Kargo Bilgileri</div>
			<hr />
			<?=$siparisData['name']?> <?=$siparisData['lastname']?>
			<br/>
			<?=$siparisData['address']?> <?=hq("select name from ilceler where ID='".$siparisData['semt']."'")?> / <?=hq("select name from iller where plakaID='".$siparisData['city']."'")?>
			<br/>
			Tel : <?=$siparisData['ceptel']?> <?=$siparisData['istel']?> <?=$siparisData['evtel']?>
			<hr />
			<input type="button" id="yazdir" onClick="document.getElementById('yazdir').style.display = 'none'; window.print();" value="Yazdır" />	
			<div style="clear:both"></div>		
		</div>
		
	</body>
</html>
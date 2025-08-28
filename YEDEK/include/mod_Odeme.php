<?php
if(isset($_GET['setPayType']))
{
	include('all.php');
	my_mysql_query("update siparis set odemeID='".(int)$_GET['setPayType']."' where randStr = '".$_SESSION['randStr']."'",1);
	exit('OK');
}

class SpSiparisOdeme
{
	public static function ptype($ID,$icon, $title, $desc, $ajax)
	{
		return '<div class="col-md-12 col-12 m-0 p-0 card-content mb-4">
					<div class="card px-4 py-3 pay-items tabs-items">
					<div class="card-headers mb-2 d-flex align-items-center justify-content-between" onclick="setPayType(\''.$ID.'\');">
						<div class="d-flex align-items-center justify-content-between w-100">
						<label for="pay-items-1 mb-0"><i class="fa fa-' . $icon . '"></i> ' . $title . '</label>
						<div class="radius"></div>
						</div>
					</div>
					' . ($desc ? '<div style="display: none" class="card-bodys border-top d-none"><div class="d-flex flex-wrap mt-4 mobile-payment">' . $desc . '</div></div>' : '') . $ajax . '
					</div>
				</div>';
	}

	public static function getDeliveryForm()
	{
		if (!hq("select ID from teslimat limit 0,1"))
			return;
		$out = '<div class="clear">&nbsp;</div>
				<h4>' . lc('_lang_teslimatSecimi', 'Teslimat Seçimi') . '</h4>
				<table class="kargo-liste">
					<theader>
						<tr>
							<th colspan="2">' . lc('_lang_teslimatTipi', 'Teslimat Tipi') . '</th>
							<th>' . lc('_lang_fiyatFarki', 'Fiyat Farkı') . '</th>
						</tr>
					</theader>
					<tbody class="teslimat-secim">';
		$deliveryQuery = my_mysql_query('select * from teslimat order by seq desc');
		while ($d = my_mysql_fetch_array($deliveryQuery)) {
			if ($d['degisimYuzde']) {
				$fark = (basketInfo('toplamKDVDahil', $_SESSION['randStr']) * abs($d['degisimYuzde']));
				$isaret = ($d['degisimYuzde'] > 0 ? '+' : '-');
			}
			if ($d['degisimYTL']) {
				$fark = $d['degisimYTL'];
				$isaret = ($d['degisimYTL'] > 0 ? '+' : '-');
			}
			$fark = $isaret . $fark;
			$out .= '<tr>
						<td class="radio-td"><input type="radio" name="teslimat" teslimatID="' . $d['ID'] . '" id="teslimat-secim-' . $d['ID'] . '">&nbsp;</td>
						<td><label for="teslimat-secim-' . $d['ID'] . '">' . $d['name'] . '</label></td>
						<td><label for="teslimat-secim-' . $d['ID'] . '">' . my_money_format('', (float)$fark) . ' ' . fiyatBirim('TL') . '</label></td>
					</tr>' . "\n";
		}
		$out .= ' 	</tbody>
				</table>';
		return $out;
	}

	public static function getShippingList()
	{
		if (!basketInfo('toplamUrun', $_SESSION['randStr']))
			exit("<script type='text/javascript'>window.location.href = '" . slink('sepet') . "';</script>");

		$kargoArray = getKargoArray();
		$out = '';
		foreach ($kargoArray as $kargok => $kargov) {
			$tutar = sepetKargoHesapla($_SESSION['randStr'], $kargok);
			$tutarStr = my_money_format('', $tutar) . ' ' . fiyatBirim('TL');
			if (hq("select alici from kargoFirma where ID='$kargok'"))
				$tutarStr =  lc('_lang_aliciOdemeli', 'Alıcı Ödemeli');
			$out .= '<tr>
						<td><input type="radio" name="kargo" kargoFirmaID="' . $kargok . '" id="kargo-secim-' . $kargok . '">&nbsp;</td>
						<td><label for="kargo-secim-' . $kargok . '">' . $kargov . '</label></td>
						<td><label for="kargo-secim-' . $kargok . '">' . $tutarStr . '</label></td>
						<td><label for="kargo-secim-' . $kargok . '">' . kargoGun($kargok) . '</label></td>
				    </tr>';
		}
		return $out;
	}

	public static function getPaymentList($bankListArray)
	{
		global $ccPayType;
		$bankList = array();
		foreach ($bankListArray as $d) {
			$type = 'diger';
			$desc = '';
			$icon = 'money';
			$ajax = '<div class="pay-auto-finish" data-loadID="' . $d['ID'] . '"></div>';
			if ($d['taksitOrani'])
				$type = 'cc';
			if (stristr($d['paymentModulURL'], 'payment_iyzipay')) {
				$icon = 'credit-card';
				$type = 'iyzipay';
			}

			if (stristr($d['paymentModulURL'], 'payment_havale')) {
				$icon = 'university';
				$type = 'havale';
				$desc = '<table width="100%" class="havaleBilgileri" cellspacing="0" cellpadding="0">
							<tr>
								<th align="left">' . _lang_banka_banka . '</th>
								<th align="left">' . _lang_banka_sube . '</th>
								<th align="left">' . _lang_banka_hesapNo . '</th>
								<th align="left">' . _lang_banka_hesapSahibi . '</th>
							</tr>';
				$qx = my_mysql_query('select * from bankaHavale order by bankaAdi');
				while ($dx = my_mysql_fetch_array($qx)) {
					$desc .= '<tr>
								<td align="left">' . $dx['bankaAdi'] . '</td>
								<td align="left">' . $dx['bankaSubeAdi'] . '</td>
								<td align="left">' . $dx['bankaHesapNo'] . ' ' . ($dx['bankaSubeKodu'] ? '(' . $dx['bankaSubeKodu'] . ')' : '') . '</td>
								<td align="left"> ' . $dx['bankaKullaniciAdi'] . '</td>
							</tr>';
				}
				$desc .= '</table>';
			}

			if (stristr($d['paymentModulURL'], 'payment_kapida')) {
				$icon = 'map-marker';
				$type = 'kapida';
			}

			if (stristr($d['paymentModulURL'], 'payment_mobil')) {
				$icon = 'mobile';
				$type = 'mobile';
			}

			switch($type)
			{
				case 'cc':
					$bankList['ccID'][] = $d['ID'];
					$bankList[$type] .= '
					<div class="col-md-3 p-0 m-0 font-12 cc-choice-container credit-card" data-bankID="'.$d['ID'].'">
						<div class="radiussub float-left mr-2"></div> ' . $d['bankaAdi'] . '<div class="cc-choice">
							<div class="credit-card-view" style="background-color:' . $d['bcolor'] . '; color:' . $d['fcolor'] . ';">' . $d['taksitGosterimBaslik'] . ($d['oran'] ? '<span class="s3">' . $d['oran'] . '</span>' : '') . '<span class="s1">' . $d['paytotal'] . '</span><span class="s2">' . (hq('select ID from bankaVade where bankaID= \'' . $d['ID'] . '\' AND ay > 1') ? 'Peşin / Taksit' : 'Tek Çekim') . '</span></div>
						</div>
					</div>';
				break;
				default:
					$bankList[$type] .= SpSiparisOdeme::ptype($d['ID'],$icon, $d['bankaAdi'] . ($d['oranfull'] ? '<span ' . (substr($d['oranfull'], 0, 1) == '+' ? 'class="oranp"' : '') . '>' . $d['oranfull'] . '</span>' : ''), ($desc ? $desc : $d['odemeAciklama']), $ajax);
				break;

			}
		}
		$openCC = '';
		$ccList = $bankList['cc'];
		if($ccPayType)
		{
			$ccList = '';
			$ccAuto = $ccPayType.'<script>$(".baska-kart").css("visibility","visible");</script>';
			$openCC = 'active';
			unset($bankList);
		}
		else if(sizeof($bankList['ccID']) == 1)
		{
			$ccList = '<div class="pay-auto-load" data-loadID="' . (int)$bankList['ccID'][0]. '"></div>';
		}
		$kurallar = '';
		
		if(!$_GET['paytype'])
			$kurallar = '<li class="sf-form-item-fullwidth width-100" id="siparis-kurallar">
								<div><label class="sf-text-label">'._lang_form_satinAlmaKurallariOkudum.'</label>
									<div class="checkbox-fa"><input id="gf_acceptRulesCB_satinalKural" class="sf-form-checkbox" type="checkbox" checked="checked"><label for="gf_acceptRulesCB_satinalKural" class="sf-form-info st-form-onay">'._lang_odemeOnay.'</label></div>
									<div class="stn-dialog viewStnOB" title="'.$_SESSION['randStr'].' '._lang_pageSiparisSozlesme.'">
										' . _lang_js_lutfenBekleyin . '
									</div>
									<div class="stn-dialog viewStnSAK" title="'.$_SESSION['randStr'].' '._lang_pageSiparisSozlesme2.'">
										' . _lang_js_lutfenBekleyin . '
									</div>
								</div>
							</li>';
		if($ccPayType && !hq("select taksitOrani from banka where ID='".$_GET['paytype']."'"))
		{
			$icon = 'cc';
			$mod = hq("select paymentModulURL from banka where ID='".$_GET['paytype']."'");
			if (stristr($mod, 'payment_kapida')) {
				$icon = 'map-marker';
			}

			if (stristr($mod, 'payment_mobil')) {
				$icon = 'mobile';
			}

			return SpSiparisAdres::header('2') . '
					<div class="tab-content payment">
						<div class="col-md-12 col-12 m-0 p-0 card-content mb-4">
							<div class="card px-4 py-3 pay-items tabs-items active">
								<div class="card-headers mb-2 d-flex align-items-center justify-content-between">
									<div class="d-flex align-items-center justify-content-between w-100">
									<label for="pay-items-1 mb-0"><i class="fa fa-' . $icon . '"></i> ' . hq("select bankaAdi from banka where ID='".(int)$_GET['paytype']."'") . '</label>
									<div class="radius"></div>
									</div>
								</div>
								' . ($ccAuto ? '<div style="display: block" class="card-bodys border-top"><div class="d-flex flex-wrap mt-4 mobile-payment">' . $ccAuto . '</div></div>' : '') . '
							</div>
						</div>
					</div>


			' . SpSiparisAdres::footer() . '<input type="button" onclick="siparisiOnayla(); return false;" class="siparis-onayla-button sf-button sf-button-large sf-neutral-button" value="Siparişi Onayla" />';
		}
		return SpSiparisAdres::header('2') . '
			<div class="tab-content payment">
				<!--<h4 class="my-4">Ödeme Şekliniz</h4>-->
				' . $bankList['havale'] . '
				<div class="col-md-12 col-12 m-0 p-0 card-content mb-4">
				<div class="card px-4 py-3 pay-items tabs-items '.$openCC.'">
					<div
					class="card-headers mb-2 d-flex align-items-center justify-content-between"
					>
					<div class="d-flex align-items-center justify-content-between w-100">
						<label for="pay-items-1 mb-0"
						><i class="fa fa-credit-card"></i> '.lc('_lang_krediKartiIleOdeme','Kredi Kartı ile Ödeme').'</label
						>
						<div class="radius"></div>
					</div>
					</div>
					<div class="pay-auto-cc border-top" '.($ccAuto?'style="display:block !important;"':'').'>' . $ccAuto . '</div>
					<div class="card-bodys border-top '.($openCC?'':'d-none ml-4').'">
					<div class="d-flex flex-column py-4">
						<div class="row">' . $ccList . '</div>
					</div>
					</div>
				</div>
				</div>
				' . $bankList['iyzi'] . '
				' . $bankList['kapida'] . '
				' . $bankList['mobile'] . '
				' . $bankList['diger'] . '
				<div class="clear"></div>
			</div>
			'.SpSiparisOdeme::sozlesme().'
			' . SpSiparisAdres::footer() . '<input type="button" onclick="siparisiOnayla(); return false;" class="siparis-onayla-button sf-button sf-button-large sf-neutral-button" value="'.lc('_lang_siparisiOnayla','Siparişi Onayla').'" />'.$kurallar;
	}

	public static function sozlesme()
	{
		$out = '                   
		<!-- Sözleşme listesi -->
		<div id="sozlesme" class="sozlesme-v5 mt-4">
			<h5>'.$_SESSION['randStr'].' '._lang_pageSiparisSozlesme2.'</h5>
			<div class="sozlesme-content p-3 rounded mt-2">
				<div id="cayma" class="sozlesme-items">
					<p><textarea readonly>'.Sepet::sozlesme2($_SESSION['randStr'], $_GET['email']).'</textarea></p>
				</div>
			</div>
		</div>
		<div id="sozlesme2" class="sozlesme-v5 mt-4">
			<h5>'.$_SESSION['randStr'].' '._lang_pageSiparisSozlesme.'</h5>
			<div class="sozlesme-content p-3 rounded mt-2">
				<div id="cayma" class="sozlesme-items">
					<p><textarea readonly>'.Sepet::sozlesme($_SESSION['randStr'], $_GET['email']).'</textarea></p>
				</div>
			</div>
		</div>
		<div id="sozlesme3" class="sozlesme-v5 mt-4">
			<h5>'.$_SESSION['randStr'].' '._lang_pageSiparisSozlesme3.'</h5>
			<div class="sozlesme-content p-3 rounded mt-2">
				<div id="cayma" class="sozlesme-items">
					<p><textarea readonly>'.Sepet::sozlesme3($_SESSION['randStr'], $_GET['email']).'</textarea></p>
				</div>
			</div>
		</div><div class="clear"></div>';
		return '<div class="sozlesme-odeme">'.generateTableBox(lc('_lang_titlesozlesmeVeFormlar','Sözleşmeler ve Formlar'), $out , tempConfig('formlar')).'</div>';
	}
}

function mySiparisOdemeSecim()
{
	userAdresKontrol();
	$out = '';
	if ($_SESSION['bakiyeOdeme']) {
		$filter = 'AND paymentModulURL != \'include/payment_kredi.php\'';
		if (hq("select ID from banka where active = 1  AND bakiye = 1")) {
			$filter .= ' AND taksitOrani = 1';
		}
	}
	if (!$_SESSION['userID']) {
		$filter = 'AND paymentModulURL != \'include/payment_kredi.php\'';
	}
	if (basketInfo('Promosyon', $_SESSION['randStr']) && (basketInfo('ModulFarkiIle', $_SESSION['randStr']) <= 0)) {
		$filter .= " AND paymentModulURL = 'include/payment_promosyon.php'";
	} else {
		$filter .= " AND paymentModulURL != 'include/payment_promosyon.php'";
	}
	if ($_GET['cconly']) {
		$filter .= " AND taksitOrani = 1";
	}
	if (userGroupID() && hq("select ID from banka where userGroup != '' AND userGroup != '0' AND active =1")) {
		$query = "select * from banka where minsiparis <= " . basketInfo('ModulFarkiIle', $_SESSION['randStr']) . " AND active = 1 AND (userGroup like '%," . userGroupID() . ",%' OR userGroup = '') AND paymentModulURL != '' $filter order by seq";
	} else {
		$query = "select * from banka where minsiparis <= " . basketInfo('ModulFarkiIle', $_SESSION['randStr']) . " AND active = 1 AND (userGroup='' OR userGroup = '0') AND paymentModulURL != '' $filter order by seq";
	}
	$q = my_mysql_query($query);
	$i = 1;
	$listArray = array();
	while ($d = my_mysql_fetch_array($q)) {
		if ($d['hide']) {
			continue;
		}
		$d = translateArr($d);
		$list = true;
		if ($d['maxsiparis'] && basketInfo('ModulFarkiIle', $_SESSION['randStr']) > $d['maxsiparis']) {
			continue;
		}
		if (($d['cat'] && $d['cat'] != '0') || ($d['marka'] && $d['marka'] != '0')) {
			$qSepet = my_mysql_query("select * from sepet where randStr like '" . $_SESSION['randStr'] . "'");
			while ($dSepet = my_mysql_fetch_array($qSepet)) {
				$qUrun = my_mysql_query("select * from urun where ID='" . $dSepet['urunID'] . "'");
				$urun = my_mysql_fetch_array($qUrun);
				if ($d['cat'] && $d['cat'] != '0') {
					if (!(stristr($d['cat'], ',' . $urun['catID'] . ',') === false)) {
						$list = false;
					}
				}
				if ($d['marka'] && $d['marka'] != '0') {
					if (!(stristr($d['marka'], ',' . $urun['markaID'] . ',') === false)) {
						$list = false;
					}
				}
			}
		}
		if ($list && ($d['langs'] && $d['langs'] != '0')) {
			if ((stristr($d['langs'], ',' . $_SESSION['lang'] . ',') === false)) {
				$list = false;
			}
		}
		if ($list) {
			$degisimYuzde = (float) dbInfo('banka', 'degisimYuzde', $d['ID']);
			$degisimYTL = (float) dbInfo('banka', 'degisimYTL', $d['ID']);
			$isaret = (($degisimYuzde + $degisimYTL) >= 0 ? '+' : '-');
			$desc = ($isaret == '+' ? '' : _lang_sepet_indirimli);
			$orgGet = $_GET;
			$_GET['paytype'] = $d['ID'];
			$_GET['act'] = 'satinal';
			$_GET['op'] = 'odeme';
			$yeniTutar = basketInfo('ModulFarkiIle', $_SESSION['randStr']);
			$fiyatBirim = fiyatBirim($_SESSION['cache_setfiyatBirim']);
			//  $yeniTutar = ($degisimYuzde ? ($toplamTutarTL + ($toplamTutarTL * $degisimYuzde)) : $toplamTutarTL + $degisimYTL);
			$_GET = $orgGet;
			$oran = '';
			if ($degisimYuzde != 0 || $degisimYTL != 0) {
				$degisim = $degisimYTL;
				$fiyatBirim = fiyatBirim('TL');
				if ($_SESSION['cache_setfiyatBirim']) {
					$degisim = fiyatCevir($degisimYTL, 'TL', $_SESSION['cache_setfiyatBirim']);
					$yeniTutar = fiyatCevir($yeniTutar, 'TL', $_SESSION['cache_setfiyatBirim']);
				}
				//$payPercent = '(' . ($degisimYuzde ? '%' . abs($degisimYuzde * 100) : abs($degisim) . ' ' . $fiyatBirim . '') . ' ' . ($isaret == '-' ? '' : '') . ') ' . my_money_format('', $yeniTutar) . ' ' . $fiyatBirim;
				$paytotal = my_money_format('', $yeniTutar) . ' ' . $fiyatBirim;
				$oran = ($degisimYuzde ? '%' . abs($degisimYuzde * 100) : abs($degisim) . ' ' . $fiyatBirim);
				$oranfull = $oran . ' ' . ($isaret == '-' ? _lang_sepet_indirimli : '');
				$oranfull = ($isaret == '-' ? '' : '+ ') . $oranfull;
			} else {
				$paytotal = my_money_format('', $yeniTutar) . ' ' . $fiyatBirim;
			}
			$d['paytotal'] = $paytotal;
			$d['oran'] = $oran;
			$d['oranfull'] = $oranfull;
			$i++;
			$listArray[] = $d;
		}
	}
	return siparisOdemeSecimY($listArray);
}
?>
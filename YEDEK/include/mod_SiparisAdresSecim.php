<?php
include_once('mod_Odeme.php');

if (isset($_GET['siparisKargoListe'])) {
	include('all.php');
	exit(SpSiparisOdeme::getShippingList());
}
if (isset($_GET['getAjaxAddressID'])) {
	include('all.php');
	exit('<div id="adres-guncelle">
			<h2 class="mb-3">Adres Güncelle</h2>'
			. SpSiparisAdres::getForm(hq("select ID from useraddress where ID='" . (int)$_GET['getAjaxAddressID'] . "' AND userID='" . $_SESSION['userID'] . "'")) . '
		  </div>');
}
if (isset($_GET['setAjaxAddressID'])) {
	include('all.php');
	if ($_GET['setAjaxAddressID'] && !hq("select ID from useraddress where ID='" . (int)$_GET['setAjaxAddressID'] . "' AND userID='" . $_SESSION['userID'] . "'"))
		exit('ok-but-why?');
	exit(adresEkleGuncelle(false, $_POST));
}
if (isset($_GET['deleteAjaxAddressID'])) {
	include('all.php');
	exit(my_mysql_query(("delete from useraddress where ID='" . (int)$_GET['deleteAjaxAddressID'] . "' AND userID='" . $_SESSION['userID'] . "'")));
}

class SpSiparisAdres
{
	public static function getForm($addressID)
	{
		$out = '';
		$q = my_mysql_query("select * from useraddress where ID='" . (int)$addressID . "' AND userID='" . $_SESSION['userID'] . "'");
		$d = my_mysql_fetch_array($q);
		$d['country'] = ($d['country'] ? $d['country'] : 1);
		$cityOption = $townOption = $mahOption = $coOption = '';

		$coQuery = my_mysql_query('select * from ulkeler order by name');
		while ($coRow = my_mysql_fetch_array($coQuery)) {
			$coOption .= '<option value="' . $coRow['ID'] . '" ' . ($coRow['ID'] == $d['country'] ? 'selected' : '') . '>' . $coRow['name'] . '</option>' . "\n";
		}

		$cityQuery = my_mysql_query('select * from iller where cID=0 OR cID=\'' . $d['country'] . '\' order by name');
		while ($cityRow = my_mysql_fetch_array($cityQuery)) {
			$cityOption .= '<option value="' . $cityRow['plakaID'] . '" ' . ($cityRow['plakaID'] == $d['city'] ? 'selected' : '') . '>' . $cityRow['name'] . '</option>' . "\n";
		}
		$qt = my_mysql_query("select * from ilceler where parentID='" . $d['city'] . "' order by name");
		while ($dt = my_mysql_fetch_array($qt)) {
			$attr = ($dt['disabled'] ? '0' : '1');
			$townOption .= '<option ' . ($dt['ID'] == $d['semt'] ? 'selected' : '') . ' kargo="' . $attr . '" value="' . $dt['ID'] . '">' . $dt['name'] . '</option>' . "\n";
		}
		$qt = my_mysql_query("select * from mahalleler where parentID='" . $d['semt'] . "' order by name");
		while ($dt = my_mysql_fetch_array($qt)) {
			$attr = ($dt['disabled'] ? '0' : '1');
			$mahOption .= '<option ' . ($dt['ID'] == $d['mah'] ? 'selected' : '') . ' kargo="' . $attr . '" value="' . $dt['name'] . '">' . $dt['name'] . '</option>' . "\n";
		}
		$out .= '<form id="adres_form_' . (int)$addressID . '">
					<div class="addres-add-form">
						<div>
							<div>
								<input id="name' . (int)$addressID  . '" name="name" type="text" placeholder="" value="' . $d['name'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
								<label for="name' . (int)$addressID  . '">Adı</label>
							</div>
							<div>
								<input id="lastname' . (int)$addressID  . '" name="lastname" type="text" placeholder="" value="' . $d['lastname'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
								<label for="lastname' . (int)$addressID  . '">Soyadı</label>
							</div>
				
							<div>
								<select name="country" id="gf_country' . (int)$addressID  . '" class="col-two" onchange="formCountryChange(this);" style=" margin: 0; width: 100%;">
									<option value="">Ülke</option>
									' . $coOption . '
								</select>
								<select name="city" id="gf_city' . (int)$addressID  . '" class="col-two marginLeft" onchange="formCityChange(this);" style=" margin: 0; width: 100%;">
									<option value="">İl</option>
									' . $cityOption . '
								</select>
				
							</div>
							<div ' . ($d[' country'] && ($d['country']> 1) ? 'style="display:none;"' : '') . '>
								<select name="semt" id="gf_semt' . (int)$addressID  . '" class="col-two " onchange="formTownChange(this);">
									<option value="">İlçe</option>
									' . $townOption . '
								</select>
								<select name="mah" id="gf_mah' . (int)$addressID  . '" class="col-two marginLeft">
									<option value="">Mahalle</option>
									' . $mahOption . '
								</select>
							</div>
							<div>
								<textarea id="address' . (int)$addressID  . '" name="address" id="" placeholder="" onkeyup="this.setAttribute(\'value\', this.value);">' . $d['address'] . '</textarea>
								<label for="address' . (int)$addressID  . '">Adres</label>
							</div>
						</div>
						<div>
				
							<div>
								<input type="text" id="ceptel' . (int)$addressID  . '" name="ceptel" placeholder="" value="' . $d['ceptel'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
								<label for="ceptel' . (int)$addressID  . '">Cep Telefonu</label>
							</div>
							<div>
								<input type="text" id="tckNo' . (int)$addressID  . '" name="tckNo" placeholder="" value="' . $d['tckNo'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
								<label for="tckNo' . (int)$addressID  . '">TC Kimlik No</label>
							</div>
							<div>
				
								<input type="text" id="baslik' . (int)$addressID  . '" placeholder="" name="baslik" value="' . $d['baslik'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
								<label for="baslik' . (int)$addressID  . '">Adres Başlığı</label>
							</div>
							<!--
												<div class="radio-list">
														<div class="radio-backed" style="width: 100%;">
															<input id="type-3' . (int)$addressID  . '" value="' . _lang_evet . '" type="checkbox" name="efatura" ' . ($d['efatura'] == _lang_evet ? 'checked' : '') . '>
															<label for="type-3' . (int)$addressID  . '">
																	E-Fatura Mükellefiyim.
															</label>
														</div>									
													</div>
													-->
							<div class="clear"></div>
							<div class="radio-list">
								<h3>Fatura Türü</h3>
								<div class="radio-backed">
									<input id="type-1' . (int)$addressID  . '" type="radio" name="x1" onchange=\'$(".kurumsalForm").hide();\' ' . (($d[' firmaUnvani'] || $d['vergiDaire'] || $d['vergiNo'] || $d['efatura']) ? '' : 'checked' ) . '>
																<label for="type-1' . (int)$addressID . '">
																		Bireysel
																</label>
															</div>
															<div class="radio-backed">
															<input id="type-2' . (int)$addressID . '" type="radio" name="x1" onchange=\' $(".kurumsalForm").show();\' ' . (($d[' firmaUnvani'] || $d['vergiDaire'] || $d['vergiNo'] || $d['efatura']) ? 'checked' : '' ) . '>
															<label for="type-2' . (int)$addressID . '">
																	Kurumsal
															</label>
														</div>
													</div>
													<div class="kurumsalForm" ' . (($d['firmaUnvani'] || $d['vergiDaire'] || $d['vergiNo']) ? '' : 'style="display:none"' ) . '>
															<div>
																	<input type="text" id="firmaUnvani' . (int)$addressID . '" name="firmaUnvani" placeholder="" class="" value="' . $d['firmaUnvani'] . '" onkeyup="this.setAttribute(\' value\', this.value);">
									<label for="firmaUnvani' . (int)$addressID  . '">Firma Adı</label>
								</div>
								<div class="kurumsalForm50">
									<div>
				
										<input type="text" id="vergiDaire' . (int)$addressID  . '" name="vergiDaire" placeholder="" class="" value="' . $d['vergiDaire'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
										<label for="vergiDaire' . (int)$addressID  . '">Vergi Dairesi</label>
				
									</div>
									<div>
										<input type="text" id="vergiNo' . (int)$addressID  . '" name="vergiNo" placeholder="" class="" value="' . $d['vergiNo'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
										<label for="vergiNo' . (int)$addressID  . '">Vergi Numarası</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<button addressID="' . $addressID . '" onclick="return adresKayit(this,\'#adres_form_' . (int)$addressID . '\')" class="addres-button">' . ($addressID ? 'Kaydet' : 'Adreslerime Ekle') . '</button>
				</form>
				';

		return $out;
	}

	public static function header($active)
	{
		return '<div class="container w-100">
					<div class="row">
						<div class="col-md-12">
							<div class="d-flex flex-wrap w-100 border rounded tabs mb-4">
								<div
									id="delivery"
									class="w-50 p-3 border-right tab ' . ($active == '1' ? 'active' : '"
									onclick="window.location.href= \'ac/satinal/adres\';') . '">
									<p class="font-weight-bold p-0 m-0">'._lang_titleTeslimatBilgileriniz.'</p>
								</div>
								<div
									id="payment"
									class="w-50 p-3 tab ' . ($active == '2' ? 'active' : '') . '" '.($active?'onclick="window.location.href = \'ac/satinal/secim\';"':'').'>
									<p class="font-weight-bold p-0 m-0">'._lang_titleOdemeSekliniz.'</p>
								</div>
							</div>';
	}
	public static function footer()
	{
		return '</div></div></div>';
	}
	public static function getAddressList()
	{
		adresEkleGuncelle(_lang_kayitAdresim, user());

		/*
		$lastAddressID = hq("select adresID from siparis where userID = '" . $_SESSION['userID'] . "' order by ID desc limit 0,1 ");
		if(!$lastAddressID)
			$lastAddressID = hq("select ID from useraddress where userID = '" . $_SESSION['userID'] . "' order by ID desc limit 0,1 ");
		*/
		$out = SpSiparisAdres::header('1') . '
					<input type="hidden" name="adresID" id="adresID" value="" />
					<input type="hidden" name="faturaID" id="faturaID" value="" />
					<input type="hidden" name="kargoID" id="kargoFirmaID" value="" />
					<input type="hidden" name="teslimatID" id="teslimatID" value="" />
					<!-- Tab Content -->
					<!-- Teslimat Seç.. tab kısmı -->
					<div class="tab-content delivery" id="teslimat-adres">
						<!--<h4 class="my-4">Teslimat Bilgileriniz</h4>-->
						<div class="d-flex flex-wrap pb-4 border-bottom adress-list">';

		$i = 1;
		$q = my_mysql_query("select * from useraddress where userID='" . $_SESSION['userID'] . "' group by baslik order by if(useraddress.baslik = '" . _lang_kayitAdresim . "',0,1),ID desc");
		while ($d = my_mysql_fetch_array($q)) {
			my_mysql_query("delete from useraddress where baslik = '" . $d['baslik'] . "' AND userID='" . $d['userID'] . "' AND ID != '" . $d['ID'] . "'");
			$ilce = $d['semt'];
			$ilce = hq("SELECT name FROM `ilceler` WHERE `ID` = '{$ilce}' LIMIT 0,1");
			$mah = $d['mah'];
			$mah = hq("SELECT name FROM `mahalleler` WHERE `ID` = '{$d['mah']}' LIMIT 0,1");
			$il = $d['city'];
			$il = hq("SELECT name FROM `iller` WHERE `ID` = '{$il}' LIMIT 0,1");
			$ulke = $d['country'];
			$ulke = hq("SELECT name FROM `ulkeler` WHERE `ID` = '{$ulke}' LIMIT 0,1");

			$address2 = $mah . ' / ' . $ilce . ' / ' . $il ;
			if($ulke)
				$address2 = $il.' / '.$ulke;

				

			$out .= '<div class="col-lg-6 col-md-12 m-0 p-0 card-content mb-4">
						<div class="card py-2 px-3 adres-items tabs-items" adresID="' . $d['ID'] . '">
							<div class="card-headers mb-3 mt-2 d-flex align-items-center justify-content-between">
								<div class="d-flex align-items-center">
									<div class="radius"></div>
									<label for="adres-items-' . $i . '" class="mb-0"> ' . $d['baslik'] . '</label>
								</div>
								<div class="setting">
									<span class="edit" addressID="' . $d['ID'] . '" onclick="return adresGuncelle(this)">Düzenle</span>
									<a href="#" addressID="' . $d['ID'] . '" onclick="return adresSil(this)">
					
										<button data-line="5" data-urunid="5" class="hizli-sepet-satir-sil hover:text-red-600 text-red-400 text-lg cursor-pointer"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
												<polyline points="3 6 5 6 21 6"></polyline>
												<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
												<line x1="10" y1="11" x2="10" y2="17"></line>
												<line x1="14" y1="11" x2="14" y2="17"></line>
											</svg></button>
									</a>
								</div>
							</div>
							<div class="card-bodys border-top d-flex flex-column">
								<span class="mt-2 font-weight-bold adres-ad-soyad font-12">' . $d['name'] . ' ' . $d['lastname'] . '</span>
								<span class="mb-2 font-12 adres-adres">
									' . substr($d['address'], 0, 40) . (strlen($d['address']) > 40 ? '...' : '') . '<br />'.$address2.'
									</span>
								<span class="tel-users d-flex align-items-center">
									<i class="fa fa-mobile"></i>
									<span class="ceptel">' . $d['ceptel'] . '</span>
								</span>
							</div>
						</div>
					</div>';
			$i++;
		}


		$out .= '<div class="col-lg-6 col-md-12 m-0 p-0 card-content mb-4 adres-ekle">
					<div class="card py-2 px-3 new-adres-items justify-content-center align-items-center d-flex add-adress">
						<div class="card-bodys d-flex flex-column text-center">
							<a href="#adres-ekle" class="fancybox color-555"><span class="font-weight-bold">Yeni Adres Ekle</span>
								<i class="fa fa-plus-square"></i></a>
						</div>
					</div>
				</div>
				</div>
				<h4 class="my-4">Fatura Bilgileriniz</h4>
				<div class="">
					<input type="checkbox" checked id="fatura-adres-load" name="fatura" value="">
					<label for="fatura-adres-load">Teslimat Adresimle Aynı</label>
				</div>
				<div class="adress-list" id="fatura-adres"></div>';
		if(!$_SESSION['bakiyeOdeme'])
		{
			if (hq('select count(*) from teslimat') || (isReallyMobile() && sizeof(getKargoArray()) > 1))
			$out .= '<div class="containter">
						<div class="adress-container pt-0 mt-0">
								<div class="adress-list">' . SpSiparisOdeme::getDeliveryForm() . '<div class="clear"></div>
								</div>';

			if (isReallyMobile() && sizeof(getKargoArray()) > 1)
				$out .= '<h4>Kargo Seçim</h4>
							<table class="kargo-liste">
								<theader>
									<tr>
										<th colspan="2">Firma</th>
										<th>Tutar</th>
										<th>Süre</th>
									</tr>
								</theader>
								<tbody class="kargo-secim disabled">
									<tr>
										<td colspan="4">Lütfen önce teslimat adresini seçin.</td>
									</tr>
								</tbody>
							</table>';
			if (hq('select count(*) from teslimat') || (isReallyMobile() && sizeof(getKargoArray()) > 1))
				$out .= '</div>';
		}

		$out .= '
						<div class="clear">
							<h4>' . _lang_form_siparisNotu . '</h4>
							<textarea maxlength="120" placeholder="' . lc('_lang_textareaSiparisNot', '120 Karakter Sipariş Notu İletebilirsiniz.') . '" name="data_notAlici" id="data_notAlici" value="" class="sf-form-textarea gf_notAlici notAliciUpdate"></textarea>
						</div>';
		$out .= '<div id="adres-ekle">
					<h2 class="mb-3">Yeni Adres Ekle</h2>
					' . SpSiparisAdres::getForm(0) . '
				</div>
				';
		if (file_exists('templates/' . siteConfig('templateName') . '/images/form_Gonder.png'))
			$button = '<input type="image" class="formGonderButton" onclick="shopPHPPaymentStep2(); return false;" src="templates/' . siteConfig('templateName') . '/images/form_Gonder.png" value="' . _lang_gonder . '" />';
		else
			$button = '<input type="button" onclick="shopPHPPaymentStep2(); return false;" class="sf-button sf-button-large sf-neutral-button" value="' . (constant('_lang_gonder_' . $_GET['act']) ? constant('_lang_gonder_' . $_GET['act']) : _lang_gonder) . '" />';
		$out .= $button . "\n				
			</div>";
		$out .= SpSiparisAdres::footer();
		return $out;
	}
}
function siparisOdemeSecimY($query)
{
	return SpSiparisOdeme::getPaymentList($query);
}
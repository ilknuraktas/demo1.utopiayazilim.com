<?
	$suAnkiToplamOdeme = basketInfo('ModulFarkiIle',$_SESSION['randStr']);
	$totalToSend = str_replace(',','',my_money_format('%i',$suAnkiToplamOdeme));
	$total = my_money_format('%i',taksitliOdemeHesalpa($suAnkiToplamOdeme,$_POST['taksit'],$_GET['paytype']));
	$odemeTipi 			=  dbInfo('banka','bankaAdi',$_GET['paytype']);	
	$odemeDurum = 2;	
	$_SESSION['payu_DS']['username'] = hq("select username from banka where ID='".$_GET['paytype']."'");
	$_SESSION['payu_DS']['password'] = hq("select password from banka where ID='".$_GET['paytype']."'");
	
	$amount = str_replace(',','',$$suAnkiToplamOdeme);
	if (!$_SESSION['scheck'])
		$_SESSION['scheck'] = substr(md5(microtime()),0,5);
	
	if($_GET['scheck'] == $_SESSION['scheck'])
	{
		$tamamlandi = true;
		$sepetTemizle = true;	
	}
// echo debugPost('POST');

function generatePayuTaksitSelection3D($bankaID,$total,$clientId , $oid , $amount , $okUrl , $failUrl ,$islemtipi, $taksit  ,$rnd , $storekey) {
		$q = my_mysql_query("select * from banka where ID='$bankaID'");
		$d = my_mysql_fetch_array($q);
		$d['taksitSayisi'] = (my_mysql_num_rows(my_mysql_query("select ay from bankaVade where bankaID='$bankaID'")) + 1);
		
		$du['fiyat'] = $total;

		$out.='<table cellspacing=0 cellpadding=2 width="100%">';
		$qVade = my_mysql_query("select * from bankaVade where bankaID='$bankaID' order by ay,minfiyat desc");	
		$taksitArray = array();	
		while ($dVade = my_mysql_fetch_array($qVade)) {
			$i = $dVade['ay'];				
			if($dVade['minfiyat'] > $du['fiyat'] || (azamiTaksit() < $dVade['ay'])) continue;		
			if($taksitArray[$i]) continue;	
			$taksitArray[$i] = true;
			$toplamFaiz = $dVade['vade'];
			$rx[$i] = $dVade['vade']; 		
			$toplamOdenecek = ($i<=$pesinFiyatinaTaksitSayisi?$du['fiyat']:(($toplamFaiz + 1) * $du['fiyat']));
			$toplamOdenecek = $toplamOdenecek - sepetKapmanyaIndirimleri($dVade);
$amount=my_money_format('%i',$toplamOdenecek);
$amount=str_replace(',','',$amount);
			$taksit = ($i==1?'':($toplamOdenecek / $i));
			$pesinFiyatina = ($toplamOdenecek == $du['fiyat']?true:false);
			if ($i > 1 && $rx[($i - 1)] >= $rx[$i]) $pesinFiyatina = 1;
		$radioClick = "onClick=\"document.getElementById('radio_$i').click();\" style='cursor:pointer;'";
		$taksitStr = ($i==1?_lang_pesin:$i.' '._lang_taksit);	
		$out.="<tr onmouseover=\"this.style.backgroundColor='#eeeeee'\" onmouseout=\"this.style.backgroundColor='#ffffff'\"><td class='td1'><input id='radio_$i' type='radio' onclick=\"if (document.getElementById('amount')) { document.getElementById('amount').value = '$amount'; getHash('$clientId' , '$oid' , '$amount' , '$okUrl' , '$failUrl' ,'$islemtipi', '".($i>1?$i:'')."'  ,'$rnd' , '$storekey')  }\" name='taksit' value='".($i>1?$i:'')."'></td><td $radioClick>$taksitStr</td>";			 
		$out.="<td class='td2' $radioClick>".($taksit?my_money_format('%i',$taksit).' '.fiyatBirim('TL').' X '.$i:'')."</td><td ".($pesinFiyatina?'style="font-weight:bold;"':'')." $radioClick>: ";
		$out.="".my_money_format('%i',$toplamOdenecek)." ".fiyatBirim('TL')."</td>";
		$out.='</tr>';
			if ($i != $d['taksitSayisi']) {
				$out.='<tr height=2><td></td></tr>';
				$out.='<tr height=1 bgcolor="#eeeeee"><td colspan="4"></td></tr>';
				$out.='<tr height=2><td></td></tr>';
			}
		}
		$out.='</table>';		
	return $out;
}

function payment() {
	global $siteConfig,$stop,$tamamlandi,$msg,$errmsg,$suAnkiToplamOdeme,$bankaMesaj,$numpad,$amount,$okUrl,$failUrl,$oid,$rnd,$hash,$islemtipi,$taksit,$clientId,$storekey,$totalToSend;
	if (!$tamamlandi) {
		$sq = my_mysql_query("select * from siparis where randStr like '".$_SESSION['randStr']."' limit 0,1");
		$sd = my_mysql_fetch_array($sq);
		$out.='		<script src="https://secure.payu.com.tr/openpayu/v2/client/json2.js"></script>		
		<script src="https://secure.payu.com.tr/openpayu/v2/client/openpayu-2.0.js"></script>		
		<script src="https://secure.payu.com.tr/openpayu/v2/client/plugin-payment-2.0.js"></script>
		<script src="https://secure.payu.com.tr/openpayu/v2/client/plugin-installment-2.0.js"></script>
		
		
		<!--  Style class for preloader -->
		<link rel="stylesheet"  type="text/css" href="https://secure.payu.com.tr/openpayu/v2/client/openpayu-builder-2.0.css">';

		$bankaLogo = hq("select odemeLogo from banka where ID='".$_GET['paytype']."'");
		if ($bankaLogo) 
			$out.='<img src="images/banka/'.$bankaLogo.'">';
		if ($errmsg) $out.='<br><br>Hata : '.$errmsg.'<br>'.$bankaMesaj;
		$out.='<br><br>
				<style>.card {
    border: 1px solid #CDCDCD;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0 0 3px #CDCDCD;
    height: 20px;
    margin-bottom: 8px;
    padding: 4px;
    width: 200px;
}

.namer {
    display: block;
    font-family: arial;
    font-size: 13px;
    font-weight: bold;
    margin-left: 18px;
    margin-top: -16px;
    position: absolute;
}

#payu-card-expm, #payu-card-expy {
    border: 1px solid #CDCDCD;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 1px 1px 3px #CDCDCD;
    margin-bottom: 13px;
    padding: 3px;
	margin-right:9px;
}
td {font-size:11px;}
#payu_card_cardholder {padding:8px !important;}
 "}</style>
				<table cellspacing="2" cellpadding="2" width="100%">
				  <form method="post" action="'.dbInfo('banka','postURL',$_GET['paytype']).'" onsubmit="document.getElementById(\'gonderTD\').innerHTML = \''._lang_lutfenBekleyin.'\';" >
				  <input type="hidden" name="act" value="'.$_GET['act'].'">	
				  <input type="hidden" name="op" value="'.$_GET['op'].'">	
				  <input type="hidden" name="paytype" value="'.$_GET['paytype'].'">	
				  <input type="hidden" id="amount" name="amount" value="'. $totalToSend.'">
				  <input type="hidden" id="payu-card-installment" name="taksit" value="0">
				  <tr><td><img src="images/spacer.gif" height="1" width="200"></td><td></td></tr>	
				  <tr>
					<td>
					<span class="namer">Kart Üzerindeki İsim:</span></td>
					<td width="100%" ><div id="payu-card-cardholder-placeholder" class="card" style="background-color:white; padding:6px;" ></div></td>
				  </tr>
				  <tr>
				
					<td style="padding-top:2px;" valign="top"><br><span class="namer">Kart Numarası:</span> </td>
					<td><div id="payu-card-number-placeholder" class="card" style="background-color:white; padding:6px;"></div>
						<br />
					  <div style="position: absolute; margin-left: 220px; font-size: 11px; margin-top: -36px;">(rakamlar arasında boşluk bırakmayınız)</div>
				
					  </td>
				  </tr>
				  <tr>
					 <td ><span class="namer">Kartın son kullanma tarihi:</span></td>
					<td ><select name="Ecom_Payment_Card_ExpDate_Month" id="payu-card-expm">
					  <option value="0" selected="selected">Seçiniz</option>
					  <option value="01">1</option>
					  <option value="02">2</option>
					  <option value="03">3</option>
					  <option value="04">4</option>
					  <option value="05">5</option>
					  <option value="06">6</option>
					  <option value="07">7</option>
					  <option value="08">8</option>
					  <option value="09">9</option>
					  <option value="10">10</option>
					  <option value="11">11</option>
					  <option value="12">12</option>
					</select>';
				$out.='<select name="Ecom_Payment_Card_ExpDate_Year" id="payu-card-expy" ><option value="0" selected="selected">Seçiniz</option>'."\n";
				for ($i=date('Y');$i<=(date('Y') + 20);$i++) $out.='<option>'.$i.'</option>'."\n";		    
				$out.='</select>
					</td>
				  </tr>
				  <tr>
					 <td ><span class="namer">Güvenlik Kodu (CVC2):</span></td>
					<td ><div id="payu-card-cvv-placeholder" class="card" style="background-color:white; padding:6px;"></div></td>
				  </tr>
				   <tr>
					 <td valign="top" style="padding-top:2px;"><span class="namer" style="margin-top:-12px;">Taksit Seçenekleri:</span></td>
					<td ><div style="margin-top:25px; margin-bottom:+25px;">'.generatePayuTaksitSelection3D($_GET['paytype'],$suAnkiToplamOdeme,$clientId , $oid , $amount , $okUrl , $failUrl ,$islemtipi, $taksit  ,$rnd , $storekey).'</div></td>
				  </tr>
								  
				  <tr><td></td><td id="gonderTD"><img id="payu-cc-form-submit" src="templates/'.$siteConfig['templateName'].'/images/form_Gonder.gif" style="cursor:pointer;"></td></tr></form>
				</table>
				';
		$out.="<script>


			$(function() {
				
				OpenPayU.Payment.setup({id_account : \"".$_SESSION['payu_DS']['username']."\",orderCreateRequestUrl:\"include/payu/ocr.php\"});

			    $('input[name=\"taksit\"]').click(function() { $('#payu-card-installment').val($(this).val()); $('#amount').val('".$totalToSend."'); });
				$('#payu-cc-form-submit').click(function() {

					//add preloader
					OpenPayU.Builder.addPreloader('Lütfen bekleyin ... ');
					
					//**********************************************************
					//begin payment 
					//**********************************************************
					OpenPayU.Payment.create({
						//merchant can send to his server side script other additional data from page. (OPTIONAL)
						orderCreateRequestData : {
							Email :			'".$sd['email']."',
							FirstName :		'".$sd['name']."', 
							LastName :		'".$sd['lastname']."',
							Amount :		$('#amount').val(),
							Description :	'".$_SESSION['randStr']." nolu siparis odemesi',
							Phone:			'".str_replace('-','',$sd['ceptel'])."',
							Currency : 'TRY'
						}
					},function(response) {
						//update buyer experience
						if (response.Status.StatusCode == 'OPENPAYU_SUCCESS') {
							// alert('Thank for payment.'  + '\\n' + JSON.stringify(response) );
							window.location.href = 'page.php?act=satinal&op=odeme&paytype=".$_GET['paytype']."&scheck=".$_SESSION['scheck']."&taksit=' + $('#payu-card-installment').val();
						} else {
							alert('Banka Hata : ' + response.Status.StatusDesc + ' : Kod (' + response.Status.StatusCode + ')');
							// $('#error').html(response.status + '\\n' + JSON.stringify(response) );
						}
					
						//remove preloader
						OpenPayU.Builder.removePreloader();
						return false;
					});
					return false;
				});
			}());

		</script>
";
	}
	else {
		$out = 'Durum : '.$bankaMesaj.'<br>';
		$out.= spPayment::finalizePayment();
	}
	return $out;
}
?>
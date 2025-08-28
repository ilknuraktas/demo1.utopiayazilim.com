<?php
/*
	Şablon urunGoster.php 'de kullanılabilir.
	Makro {%LOAD_Cicek%}
*/

if($_GET['setAddress'])
{
	require_once('session.php');
	$_SESSION['set_gf_semt'] = (int)$_GET['semt'];
	$_SESSION['set_gf_city'] = (int)$_GET['city'];
	exit('true');
}

function mod_Cicek()
{
	$modCicek = array();
	$out = '';
	$modCicek['saatler'] = array('08:00','10:30','13:30','15:00','18:00');
	$modCicek['saat-koruma'] = 2;
	
	$out.='<input type="hidden" id="urunSecim_ozellik4detay" />';	

	$out.='<div class="m-CicekContainer">';
	
	/* Sehir:Start */
	$out.='<div class="m-CicekSelect">';
	$out.='<select class="sf-form-select" id="gf_city" '.$status.' name="data_city"><option value="">'._lang_form_sehir.' '.lang_titleSeciniz.'</option>';
	$cityQuery = my_mysql_query('select * from iller where cID=0 OR cID=1 order by name');
	while ($cityRow = my_mysql_fetch_array($cityQuery)) {
		$out.='<option value="'.$cityRow['plakaID'].'" '.($cityRow['plakaID']==$data[$k[1]]?'selected':'').'>'.$cityRow['name'].'</option>'."\n";
	}
	$out.='</select>';
	$out.='</div>';
	/* Sehir:Finish */
	
	/* Semt:Start */
	$out.='<div class="m-CicekSelect">';
	$out.='<select class="sf-form-select" id="gf_semt" '.$status.' filter="true" name="data_semt"><option value="">'._lang_form_semt.' '.lang_titleSeciniz.'</option></select>';
	$out.='</div>';
	/* Semt:Finish */
	
	/* Tarih:Start */
	$out.='<div class="m-CicekSelect">';
	$out.='<select class="sf-form-select" id="gf_tarih" '.$status.' name="data_tarih"><option value="">'._lang_teknikTakipTarih.' '.lang_titleSeciniz.'</option>';
	
	// ;
	for($i=0;$i<=31;$i++)
	{
		$haftaArr = array('Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar');
		$mktime = mktime(date('H'),date('i'),date('s'),date('m'),(date('d') + $i),date('Y'));
		$tarihSet = date('Y-m-d',$mktime);
		$tarihValue = date('d.m.Y',$mktime);
		$tarihView = mysqlTarih($tarihSet).', '.$haftaArr[date('N',$mktime) -1];
		$out.='<option '.(!$i && (date('H') > (int)end($modCicek['saatler']) - (int)$modCicek['saat-koruma'])?"disabled='disabled'":'').' value="'.$tarihValue.'">'.$tarihView.'</option>'."\n";
	}
	
	$out.='</select>';
	$out.='</div>';
	/* Tarih:Finish */
	
	/* Saat:Start */
	$out.='<div class="m-CicekSelect">';
	$out.='<select class="sf-form-select" id="gf_saat" '.$status.' name="data_saat"><option value="">'._lang_form_saat.' '.lang_titleSeciniz.'</option>';
	
	foreach($modCicek['saatler'] as $saat)
	{
		list($s,$d) =explode(':',$saat);
		$out.='<option '.(date('H') > (int)$s - (int)$modCicek['saat-koruma']?"disabled='disabled'":'').' value="'.$saat.'">'.$saat.'</option>'."\n";
	}
	
	$out.='</select>';
	$out.='</div>';
	/* Saat:Finish */

	$out.='</div>';
	
	$out.="
	<style>
		.m-CicekContainer { width:100%; }
		.m-CicekSelect { width:50%; float:left; }
		.m-CicekSelect select { width:100%; padding:15px; margin-bottom:5px; }
	</style>
	<script type=\"text/javascript\">
		window.addEventListener('load', (event) => { 
			var bugunsaatHTML = $('#gf_saat').html();
			var modCicekValue = '';
			var modCicekStop = false;
			$('#gf_saat').find('option[value!=\"\"]').remove();
			$('#gf_tarih').change(function()
			{
				$('#gf_saat').html(bugunsaatHTML);
				if($('#gf_tarih').val() != '".date('d.m.Y')."')
					$('#gf_saat').find('option').removeAttr('disabled');	
			});
			$('.m-CicekSelect select').change(function()
			{
				modCicekStop = false;
				$('.m-CicekSelect select').each(function() { 
					if(!$(this).val())
					{
						modCicekStop = true;
						modCicekValue = '';
					}			
				});
				if(!modCicekStop)
					modCicekValue = $('#gf_semt option:selected').text() + ' / ' + $('#gf_city option:selected').text() + ' - ' + $('#gf_tarih').val() + ' - ' + $('#gf_saat').val();
			});
		});
		function preSepetEkleKontrol()
		{
			$('#urunSecim_ozellik4detay').val(modCicekValue);
			if(modCicekValue == '')
			{
				alerter.show(lang_eksiksizDoldurun);
				sepetEkleKontrolValue = false
			}
			else
			{
				$.ajax({
					url: 'include/mod_Cicek.php?setAddress=1&semt=' + $('#gf_semt').val() + '&city='+$('#gf_city').val(),
					type: 'GET',
					async: false,
					cache: false,
					timeout: 30000,
					error: function(){
						alerter.show('Bir hata oluştu');
						sepetEkleKontrolValue = false;
					},
					success: function(msg){ 
						sepetEkleKontrolValue = true;
					}
				});	
			}
			return sepetEkleKontrolValue;	 
		}
	</script>
	";
	return $out;
}
?>
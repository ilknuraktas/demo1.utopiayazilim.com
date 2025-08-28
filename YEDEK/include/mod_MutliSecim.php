<?php
function mod_MS_alterVar($d)
{
	if ($d['alter']) {

		return '
		<style type="text/css">
			.udUrunNotLayout { margin:0 !important; }
			.udUrunNotLayout li { clear:both; }
			.udUrunNotUsr { clear:both; margin-top:15px; }
			.udUrunNotLayout li label { text-transform:none !important; min-width:80% !important;  }
			.udUrunNotLayout li input { float:left; }
			.udUrunNotLayout li textarea { clear:both; float:left; width:400px; height:80px; }
			.udUrunNotLayout span { clear:both; color:green; display:block; width:100%; }
		</style>
		
		<div class="udUrunNotLayout">
					  <div class="udUrunNotTxt">Seçtiğim ürünlerin stoklarınızda olmaması halinde</div>
					  <div class="udUrunNotUsr">
						<ul class="udAlternatifList">
						  <li>
							<input type="radio" name="req_alt_products_1" id="opt1" value="">
							<label for="opt1">Alternatifi benim yerime siz seçin.</label>
						  </li>
						  <li>
							<input type="radio" name="req_alt_products_1" id="show_textarea_label" value="" onclick="">
							<label for="show_textarea_label" class="show_textarea_label">Alternatifi kendim belirlemek istiyorum.</label>
							<div style="display: none;" id="req_alt_product_note_area">
							  <textarea maxlength="80" id="altProductNote" rows="2" class="sKeyword"></textarea>
							</div>
						  </li>
						  <li>
							<input type="radio" name="req_alt_products_1" id="opt3">
							<label for="opt3">Alternatif istemiyorum.</label>
						  </li>
						  <li>
							<input type="radio" name="req_alt_products_1" id="opt4">
							<label for="opt4">Alternatif için beni arayın</label>
							<span class="maviText">(Bu seçeneği işaretlediğiniz takdirde, teslimat adresi bölümünde gireceğiniz telefondan aranacaksınız.)</span></li>
						</ul>
					  </div>
					</div>
					<input type="hidden" id="urunSecim_ozellik31detay" value="" />
					
		<script type="text/javascript">
		window.addEventListener("load", (event) => { 
			$(".udUrunNotLayout li input").click(function() { $("#urunSecim_ozellik31detay").val($(this).parent().find("label").text()); $(\'#req_alt_product_note_area\').hide(); });
			$("#show_textarea_label,.show_textarea_label").click(function() { $(\'#req_alt_product_note_area\').show(); });
			$("#altProductNote").on("change keyup paste", function() {
				$("#urunSecim_ozellik31detay").val($(".show_textarea_label").text() + " : "  + $("#altProductNote").val());
			});
		});
		</script>
					';
	}
}

$output_dir = "../images/upload/";
if ($_POST['mod_MS_ajaxUpload']) {
	require_once('session.php');

	if ($_SESSION['upload_' . $_POST['mod_MS_urunID']]) {

		$ext = pathinfo($_FILES['mod_MS_filesecim']["tmp_name"], PATHINFO_EXTENSION);
		$filename = $_SESSION['randStr'] . '-' . ($_POST['mod_MS_urunID']) . '-' . $_POST['mod_MS_ajaxFileNum'] . '-' . date('Y_m_d-H_i_s') . '.jpg';
		if (!(stristr(file_get_contents($_FILES['mod_MS_filesecim']["tmp_name"]), 'GIF89') === false)) {
			unset($_FILES[$k]);
		}

		if (is_array(getimagesize($_FILES['mod_MS_filesecim']["tmp_name"])) && $_FILES['mod_MS_filesecim']['size'] < 1000000)
			move_uploaded_file($_FILES['mod_MS_filesecim']["tmp_name"], $output_dir . $filename);
		else
			exit('error');
	}
	exit($filename);
}

function mod_MS_secim($d)
{
	if (!$d['talepText'] && !$d['talepDosya'] && !$d['talepSelect'] && !$d['talepAdet'])
		return;

	$out = mod_MS_textSecim($d);
	if ($d['talepText'])
		$onay = 1;
	$out .= mod_MS_selectSecim($d);
	$out .= mod_MS_selectAdet($d);
	$outx.= mod_MS_upload($d);
	$out .= $outx;

	if ($outx)
		$_SESSION['upload_' . $d['ID']] = true;
	if (!$out) return;
	$out = '<div class="mod_MS_secim_container">' . $out . '</div>';
	$out .= "
	<div class='clear-space'>&nbsp; </div>
	" . ($onay ? "<input type='checkbox' id='mmOnay' checked='checked'> <label for='mmOnay'>Girişimi onaylıyorum.</label>" : '') . "
	<input type='hidden' id='urunSecim_ozellik31detay' />
	
	<style type='text/css'>
		<!--
		.mod_MS_secim_container { border:1px solid #ccc; border-radius:5px; padding:10px; clear:both; background-color:#fff; width:90%; clear:both; float:none; display:block; }
		-->
	</style>
	<script type='text/javascript'>
		<!--
		function preSepetEkleKontrol()
		{
			sepetEkleKontrolValue = true;
			var valx = '';
			/*
			$('input[name=\"mod_MS_filesecim\"]').each(
                function() {   if(!$(this).val().length)  { sepetEkleKontrolValue =false; alerter.show('Lütfen yüklencek resmi seçin.'); return false; }  }
            );
			*/
            $('.mod_MS_text.zorunlu').each(
                function() {   if(!$(this).val())  { sepetEkleKontrolValue =false; alerter.show('Lütfen içerikleri doldurun.'); return false; }  }
            );
			if($('#mmOnay').length && !$('#mmOnay').is(':checked'))
			{
				sepetEkleKontrolValue = false;
				alerter.show('Lütfen girişinizi onaylayın.');
				return false;	
			}
			
			$('.mod_MS_text').each(function()
			{
				if($(this).parent().find('.mod_MS_text').val())
					valx+=($(this).parent().parent().find('.sf-text-label').text()) + ' : ' + ($(this).val()) + ', ';
					
			}
			);
			

			$('#urunSecim_ozellik31detay').val($('#urunSecim_ozellik31detay').val() + valx.substr(0,(valx.length-2)));
			-->
		}
	</script>
	";
	return $out;
}

function mod_MS_selectSecim($d)
{
	$out = '<fieldset class="sf-form-container"><ul>';
	$arr = explode("\n", $d['talepSelect']);
	$i = 1;
	foreach ($arr as $a) {
		if (!$a)
			continue;

		$a = trim(htmlspecialchars(str_replace(array('"', "\r", "\n"), '', $a)));
		list($a, $fark) = explode('|', $a);
		if (substr($a, 0, 1) == '*') {
			if ($out)
				$out .= '</select></li>' . "\r\n";
			$out .= '<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">' . substr($a, 1, strlen($a) - 1) . '</label><select class="secim" name="' . substr($a, 1, strlen($a) - 1) . '" onchange="updateUrunSecim3(this)"><option value="">' . _lang_form_lutfenSecin . '</option>';
		} else
			$out .= '<option fark="' . (float)$fark . '" value="' . $a . '">' . $a . ((float)$fark != 0 ? ' (' . ($fark ? '+' : '') . my_money_format('', $fark) . ' ' . fiyatBirim(urun('fiyatBirim')) . ' )' : '') . '</option>' . "\r\n";
		$i++;
	}
	if ($out)
		$out .= '</select></li>' . "	
				<script type='text/javascript'>
					function updateUrunSecim3(obj)
					{
						var fark = 0;
						$('select').each(
								function() { 
									if(parseFloat($(this).find('option:selected').attr('fark')) > 0)
									fark += parseFloat($(this).find('option:selected').attr('fark'));
								}
						);
						//updateShopPHPUrunFiyat(fark);
						$('#urunSecim_ozellik31detay').val('');
						$('select.secim').each(
							function() { 
								if($(this).val().toString())
									$('#urunSecim_ozellik31detay').val($('#urunSecim_ozellik31detay').val() + $(this).attr('name') + ' : [' + $(this).val().toString() + '], ');	
							}							
						);
						ajaxFiyatGuncelle('".$d['ID']."');
					}
				</script>";
	$out .= '</ul></fieldset>';
	return $out;
}

function mod_MS_selectAdet($d)
{
	$out = '<fieldset class="sf-form-container"><ul>';
	$arr = explode("\n", $d['talepAdet']);
	if (sizeof($arr) < 2) return;
	$i = 1;
	$ilkAdet = 1;
	$out .= '<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">Paket Seçimi</label><select class="secim secim" name="paket" id="paket-adet">';
	foreach ($arr as $a) {
		if (!$a)
			continue;

		$a = trim(htmlspecialchars(str_replace(array('"', "\r", "\n"), '', $a)));
		list($a, $adet) = explode('|', $a);
		if($i == 1)
		{
			$ilkAdet = $adet;
		}
		$out .= '<option '.($i == 1?'selected':'').' value="' . $adet . '">' . $a . ' (' . $adet . ' ad.)</option>' . "\r\n";
		$i++;
	}
	$out .= '</select></div></li>';
	$out .= '</ul></fieldset>';
	$out .= "<script type='text/javascript'>
		window.addEventListener('load', (event) => { 
			$('#paket-adet').change(function() { 
				urunSepeteEkleAdet = $(this).val(); 
				$('.urunSepeteEkleAdet').val($(this).val());  
			}); 
	});
		
	</script>";
	return $out;
}


function mod_MS_textSecim($d)
{
	$out .= '<fieldset class="sf-form-container"><ul>';
	$arr = explode("\n", $d['talepText']);
	$i = 1;
	foreach ($arr as $a) {
		if (!$a)
			continue;
		list($a, $fark) = explode('|', $a);
		$a = trim($a);
		$fark = trim($fark);
		switch (substr($a, 0, 1)) {
			case '_':
				$a = str_replace('_', '', $a);
				$out .= '<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">' . trim($a) . '</label><textarea fark="' . $fark . '" class="mod_MS_text sf-form-input st-form-textarea" name="mod_MS_text"></textarea></div></li>' . "\n";
				break;
			case '-':
				$a = str_replace('-', '', $a);
				$out .= '<li class="sf-form-item-fullwidth"><h3>' . trim($a) . '</h3></li>' . "\n";
				break;
			default:
				$zorunlu = (substr($a, 0, 1) == '*');
				$a = str_replace('*', '', $a);
				$out .= '<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">' . trim($a) . '</label><input type="text" fark="' . ($fark ? $fark : 0) . '" class="mod_MS_text sf-form-input ' . ($zorunlu ? 'zorunlu' : '') . '" name="mod_MS_text" /></div></li>' . "\n";
				break;
		}

		$i++;
	}
	$out .= '</ul></fieldset>';
	return $out;
}

function mod_MS_upload($d)
{
	$out .= '<script src="assets/js/jquery.form.js"></script>
		   		<fieldset class="sf-form-container"><ul>';
	$arr = explode("\n", $d['talepDosya']);
	$i = 1;
	foreach ($arr as $a) {
		if (!$a)
			continue;
		$out .= '<form action="include/mod_MutliSecim.php" method="post" enctype="multipart/form-data" class="uploadForm" id="form_ms_' . $i . '">
		   <input type="hidden" name="mod_MS_ajaxUpload" value="1" />
		   <input type="hidden" name="mod_MS_ajaxFileNum" value="' . seofix(trim($a)) . '" />
		   <input type="hidden" name="mod_MS_urunID" value="' . $d['ID'] . '" />
		   <input type="hidden" name="mod_MS_filevalue" value="" />';

		$out .= '<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">' . trim($a) . '</label><input onchange="$(\'#form_ms_' . $i . '\').submit();" type="file" name="mod_MS_filesecim" /><span class="sf-form-filename"></span></div></li>' . "\n";
		$out .= '</form>';
		$i++;
	}
	$out .= '</ul></fieldset>';

	$out .= '  <script>
			window.addEventListener("load", (event) => { 
			  $(".uploadForm").ajaxForm({
                beforeSend: function() 
                {

                },
                uploadProgress: function(olay, yuklenen, toplam, yuzde) 
                {
 
                },
                success: function(response) 
                {
					alerter.show(\'Dosya yükleme başarıyla tamamlandı.\'); 
				   $(this).find("#mod_MS_filevalue").val(response);
                },
                complete: function(response) 
                {

                },
                error: function(response)
                {
                    alerter.show(\'Hata \' + response.responseText);
 
                }
            });
		});</script>';
	return $out;
}

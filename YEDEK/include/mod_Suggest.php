<?
	function modSuggest($d)
	{
		global $shopphp_demo,$langPrefix;
		if (!esantiyonSecim($_GET['urunID']) && !$shopphp_demo) return;
		
		$q = my_mysql_query("select * from urun where ID='".$d['ID']."'");
		$d = my_mysql_fetch_array($q);
		
		$JS = "<script>
			function updateMS()
			{
				if(!anaUrunFiyat)
					anaUrunFiyat = moneyFormat(".YTLfiyat(fixFiyat($d['fiyat'],0,$d),$d['fiyatBirim']).");
				$('ul.ms li').hide();
				$('ul.ms li.ms:first,ul.ms li.msplus:first').show();
				$('#ms_Toplam').text(anaUrunFiyat);
				$('input.ms').not(':checked').each(
					function() { 
						$(this).parent().find('table').hide();
					}
				);
				$('input.ms:checked').each(
					function() { 
						$(this).parent().find('table').show();
						var price = 0;
						price = ($(this).parent().find('select.urunSecim:last option:selected').attr('fiyat') * (1 - parseFloat($(this).parent().find('select.urunSecim:first').attr('d'))));
						if(price)
						{
							$(this).parent().find('.efiyat').html(moneyFormat($(this).parent().find('select.urunSecim:last option:selected').attr('fiyat')));
							$(this).parent().find('.yfiyat').html(moneyFormat($(this).parent().find('select.urunSecim:last option:selected').attr('fiyat')* (1 - parseFloat($(this).parent().find('select.urunSecim:first').attr('d')))));
						}
						else
						{
							$(this).parent().find('.efiyat').html($(this).parent().find('.efiyat').attr('data-fiyat'));
							$(this).parent().find('.yfiyat').html($(this).parent().find('.yfiyat').attr('data-fiyat'));
						}
						
						if(!price)
							price = $(this).attr('price'); 
						$('#ms_Toplam').text(moneyFormat(parseFloat($('#ms_Toplam').text().replace(',','')) + parseFloat(price))); 
						var urunID = $(this).attr('urunID'); 
						$('li#ms_' + urunID).show(); $('li#ms_' + urunID).next('li.msplus').show(); 
					}
				);	
			}
			function MSSepetEkle()
			{
				var stop = false;
				$('.suggest select:visible').each(
					function() { 
						if(!$(this).val())
						{
							myalert(lang_urunVarSecim, '');
							stop = true;
						}
					}
				);
				if(stop)
					return false;
				/*				
				var url = 'include/ajaxLib.php?act=sepetEkle&urunID=".$d['ID']."&adet=1&ajax=1'; 
				//window.open(url);
				$.get(url, function(data) {
						//alert(data);
					$('#sepetGoster').html(data);				
				});	
				*/
				var urunler = '';
				var adetler = '';		
				var varSecimURL = '';
				$('input.ms:checked').each(function()
				{
					var urunID = $(this).attr('urunID');
					urunler += urunID + ',';
					adetler += '&ekle_adet_'+urunID+'=1';
		
					for (i = 1; i <= 50; i++) {
					  if ($('select[name=\"suggest_' + urunID + '_ozellik'+i+'detay\"]').val())
					  	varSecimURL +=
						'&ozellik' + i + 'detay_'+urunID+'=' +
						encodeURIComponent($('select[name=\"suggest_' + urunID + '_ozellik'+i+'detay\"]').val());
					}
						
				});
				updateSecimURL();
				var url = 'include/ajaxLib.php?act=sepetEkle&urunID=".$d['ID']."&adet=1&beraberUrunler=' + urunler + adetler + '&relUrunID=".$d['ID']."' + varSecimURL + '&' + secimURL; 
				//	alert(url);
						 // window.open(url);
						$.get(url, function(data) {
							sepetHTMLGuncelle(data);
							document.querySelector('.imgSepetGoster,#imgSepetGoster').click();
						});	
					
				return false;
			}
		</script>
		";
		
		$css ='<style>
				.suggest input { display:inline-block; }
				.suggest table td { padding:16px; padding-top:4px; font-weight:bold;  }
				.suggest table td select { font-weight:normal; }
				.suggest {
				float: left;
				width: 100%;
				padding: 5px 0;
				}
				.suggest h3 {
				float: left;
				width: 100%;
				font-size: 18px;
				font-weight: normal;
				border-bottom: 1px solid #ddd;
				padding: 0 0 5px;
				margin: 0 0 10px 0;
				}
				.suggest strong {
				font-weight: bold;
				}
				.suggest .submit {
				float: right;
				margin: 5px 0 0 0;
				border: 0 none;
				color: #fff;
				font-size: 12px;
				font-weight: bold;
				padding: 8px;
				background: #21791F;
				border-radius:2px;
				cursor:pointer;
				}
				.suggest ul {
				float: left;
				width: 100%;
				background:none;
				height:auto;
				}
				.suggest ul li {
				float: left;
				height: 150px;
				line-height: 150px;
				margin: 10px;
				margin-left:0;
				clear:none;
				width:auto;
				background:none;
				}
				.suggest .img {
				display: inline-block;
				height: 150px;
				width: 150px;
				}
				.suggest img {
				max-width: 150px;
				max-height: 150px;
				vertical-align: middle;
				}
				.suggest .sep {
				clear:both;
				margin:5px 0 5px 0;
				height:1px;
				background-color:#ccc;	
				}
				.ms-border { border-bottom:1px dashed #ccc; padding-bottom:5px; margin-bottom:10px; } 
				.suggest .total { float:left; font-size:14px; }
		</style>';
		$out='	<div class="suggest">
	   <ul class="ms">';
		$resim.='<li id="ms_'.$d['ID'].'" class="ms"><img src="include/resize.php?path=images/urunler/'.$d['resim'].'&width=150" alt="'.$d['name'].'"></li>'."\n";
		$qEsn =  my_mysql_query("select urunler from esantiyon where (kategoriler = ".$d['ID']." OR kategoriler like '".$d['ID'].",%' OR kategoriler like '%,".$d['ID']."' OR kategoriler like '%,".$d['ID'].",%')");
		while($dEsn = my_mysql_fetch_array($qEsn))
		{
			$esn.=$dEsn['urunler'].',';
		}

		$eArray = explode(',',$esn);
		$wEsn = '1=2 OR ';
		foreach ($eArray as $v)
		{
			if($v) $wEsn.='ID = '.$v.' OR ';
		}
		$wEsn .= '1=2';
		$qU = my_mysql_query('select * from urun where urun.stok > 0 AND active =1 AND ('.$wEsn.')');
		while($dU = my_mysql_fetch_array($qU))
		{
			$urunID = $dU['ID'];
			$indirimOran = hq("select indirimOran from esantiyon where (kategoriler = ".$d['ID']." OR kategoriler like '".$d['ID'].",%' OR kategoriler like '%,".$d['ID']."' OR kategoriler like '%,".$d['ID'].",%') AND (urunler = ".$urunID." OR urunler like '".$urunID.",%' OR urunler like '%,".$urunID."' OR urunler like '%,".$urunID.",%') order by indirimOran asc limit 0,1");
			
			$urunIndDahil = mf(YTLfiyat(fixFiyat($dU['fiyat'],0,$dU) - (fixFiyat($dU['fiyat'],0,$dU) * $indirimOran),$dU['fiyatBirim']));
			
			$urunFiyat = YTLfiyat(fixFiyat($dU['fiyat'],0,$dU),$dU['fiyatBirim']);
			
			$resim.='<li class="msplus">+</li>';
			$resim.='<li id="ms_'.$dU['ID'].'" class="ms"><img src="include/resize.php?path=images/urunler/'.$dU['resim'].'&width=150" alt="'.$dU['name'].'"></li>'."\n";
			$checkbox .= '<div class="ms-border"><input type="checkbox" onclick="updateMS();" class="checkbox ms" price="'.str_replace(',','',$urunIndDahil).'" urunID="'.$dU['ID'].'" checked="checked"> <a href="'.urunLink($dU['ID']).'">'.$dU['name'].'</a> <strong>Eski Fiyat:</strong> <span data-fiyat="'.mf($urunFiyat).'" class="efiyat">'.mf($urunFiyat).'</span> TL <strong>Özel Fiyat:</strong> <span data-fiyat="'.$urunIndDahil.'" class="yfiyat">'.$urunIndDahil.'</span> TL<br /><table><tr>';
			
			for ($i = 1; $i <= 10; $i++) {
				if ($dU['varID' . $i]) {
					$checkbox .= '<td class="UrunSecenekleriHeader">' . hq("select ozellik$langPrefix from var where ID='" . $dU['varID' . $i] . "'") . '<br />' . generateItemOptions($dU, $i, '', 'suggest_'.$dU['ID'].'_',$indirimOran) . '</td>';
				}
			}
			
			$checkbox.='</tr></table></div>';
		}
	   
	   
	   $out.=$resim.'
	   </ul>
	   <p class="ms-border"><input type="checkbox" class="checkbox" disabled="disabled" checked="checked"> Bu ürün: '.$d['name'].'</p>
	  	'.$checkbox.'

	   <p class="total"><strong>Toplam İndirimli Fiyat :</strong> <span id="ms_Toplam">0</span> TL</p>
	   <input type="submit" class="submit" value="Hepsini Sepete Ekle" onclick="MSSepetEkle();" />
	</div><!-- /.suggest --><script>$(document).ready(function() { updateMS(); }); $(".suggest .urunSecim").change(function() { updateMS(); });</script><div style="clear:both"></div>';
		return $JS.$css.$out;
	}
?>
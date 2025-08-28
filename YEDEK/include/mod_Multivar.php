<?php
function multiVar($d)
{

	if (!$d['varID1'])
		return;
	$title = $body = '';
	$var1 = hq("select ozellikdetay from var where ID='" . $d['varID1'] . "'");
	$var2 = hq("select ozellikdetay from var where ID='" . $d['varID2'] . "'");

	$varr1 = explode("\n", $var1);
	$varr2 = explode("\n", $var2);

	foreach ($varr1 as $v) {
		$v = trim($v);
		if (hq("select ID from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '$v' AND up=1"))
			$title .= '<span>' . $v . '</span>';
	}


	foreach ($varr2 as $v) {
		$v = trim($v);
		if (hq("select ID from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '$v' AND up=1")) {
			$body .= '<div class="size-mv-block">
					<span>' . $v . '</span>';

			foreach ($varr1 as $vx) {
				$vx = trim($vx);
				if (hq("select stok from urunvarstok where urunID='" . $d['ID'] . "' AND var1 like '$vx' AND var2 like '$v' AND up=1") > 0 || !hq("select ID from urunvarstok where urunID='" . $d['ID'] . "' AND var1 like '$vx' AND var2 like '$v' AND up=1"))
					$body .= '<span><a href="" class="mv-choose-btn" var1="' . $vx . '" var2="' . $v . '" kod="' . hq("select kod from urunvarstok where urunID='" . $d['ID'] . "' AND var1 like '$vx' AND var2 like '$v' AND up=1") . '">SEÇ</a></span>' . "\n";
				else
					$body .= '<span>x</span>' . "\n";
			}
			$body .= '</div>';
		}
	}
	if (!$body) {
		$v = false;
		$body .= '<div class="size-mv-block">
					<span>' . $v . '</span>';

		foreach ($varr1 as $vx) {
			$vx = trim($vx);
			if (!hq("select ID from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '$vx' AND up=1"))
				continue;
			$vx = trim($vx);
			if ((hq("select stok from urunvarstok where urunID='" . $d['ID'] . "' AND var1 like '$vx' AND var2 like '$v' AND up=1") > 0) || !hq("select ID from urunvarstok where urunID='" . $d['ID'] . "' AND var1 like '$vx' AND var2 like '$v' AND up=1"))
				$body .= '<span><a href="" class="mv-choose-btn" var1="' . $vx . '" var2="' . $v . '" kod="' . hq("select kod from urunvarstok where urunID='" . $d['ID'] . "' AND var1 like '$vx' AND var2 like '$v' AND up=1") . '">SEÇ</a></span>' . "\n";
			else
				$body .= '<span>x</span>' . "\n";
		}
		$body .= '</div>';
	}

	return '	
		
		<style>
		.mv-block{margin:20px; float:left;}
		.mv-color-titles{background:#fafafa; border-top:1px solid #dbdbdb; border-bottom:1px solid #dbdbdb; font-size:12px; font-weight:bold; height:30px; line-height:30px;}
		.mv-color-titles span{display:block; float:left; width:60px; text-align:center; margin-right:5px; height:30px;}
		.size-mv-block{font-size:14px; font-weight:bold; height:30px; line-height:30px;}
		.size-mv-block span{display:block; float:left; width:60px; text-align:center; height:30px; margin-right:5px;}
		.mv-choose-btn{background:url(images/mv_pasif.png); width:21px; height:21px; display:block; text-indent:-9999px; margin:5px auto;}
		.mv-choose-btn.active{background:url(images/mv_aktif.png); }

		</style>
		
		<div class="mv-block">
		<div class="mv-color-titles">
			<span></span>
			' . $title . '
		</div>
		' . $body . '
	</div>' . "
	<input type='hidden' id='urunSecim_ozellik1detay' />
	<input type='hidden' id='urunSecim_ozellik2detay' />
	<input type='hidden' id='urunSecim_ozellik3detay' />
	<script>
	window.addEventListener('load', (event) => { 
		$('.mv-choose-btn').click(function() { $('.mv-block').find('.active').removeClass('active'); $(this).addClass('active'); $('#urunSecim_ozellik1detay').val($(this).attr('var1')); $('#urunSecim_ozellik2detay').val($(this).attr('var2')); $('#urunSecim_ozellik3detay').val($(this).attr('kod')); $('#urun_code').val($(this).attr('kod')); return false; });
	});
	</script>	
	";
}
?>
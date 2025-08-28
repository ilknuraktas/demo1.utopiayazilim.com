<?
function kampanyaKategori()
{
	$out.='<link rel="stylesheet" href="css/kampanyakategori.css" />'."\n";
	$out.='<script src="js/jquery.countdown.pack.js" type="text/javascript"></script>'."\n";
	$out.='<script src="js/jquery.countdown-tr.js" type="text/javascript"></script>'."\n";
	$out.='<script src="js/grayscale.js" type="text/javascript"></script>'."\n";
		
	
	$q = my_mysql_query('select * from kampanyakategori where bitis > now() AND baslangic < now() order by baslangic');
	
	$out.='<div class="ks">';	
	while($d = my_mysql_fetch_array($q))
	{
		$d['name'] = hq('select name from kategori where ID='.$d['catID']);
		$kategoriLink = kategoriLink($d['catID']);
		
		$out.='<div class="kb"><div class="resim"><a href="'.$kategoriLink.'"><img src="images/kampanya/'.$d['banner'].'"></a></div><div class="info"><span id="tarih_'.$d['ID'].'"></span></div></div>';

		$tArraySpace = explode(' ',$d['bitis']);
		$t1 = explode('-',$tArraySpace[0]);
		$t2 = explode(':',$tArraySpace[1]);
		$out.="
		<script type='text/javascript'>						
			$('#tarih_".$d['ID']."').countdown({until: new Date(".$t1[0].", (".$t1[1]." - 1), ".$t1[2]."),timezone: +2,     layout: '"._lang_kampanyaBitis." <b>{dn} {dl} {mn} {ml} {hn} {hl} {sn} {sl}</b>'});
		</script>
		";
	}
	$out.='</div>';
	
	$out.='<div class="kstitle">Yakında</div>';
	
	$q = my_mysql_query('select * from kampanyakategori where baslangic > now() order by baslangic');
	$out.='<div class="ks inactive">';	
	while($d = my_mysql_fetch_array($q))
	{
		$d['name'] = hq('select name from kategori where ID='.$d['catID']);
		$kategoriLink = kategoriLink($d['catID']);
		
		$out.='<div class="kb"><div class="resim"><img src="images/kampanya/'.$d['banner'].'"></div><div class="info"><span id="tarih_'.$d['ID'].'"></span></div></div>';

		$tArraySpace = explode(' ',$d['baslangic']);
		$t1 = explode('-',$tArraySpace[0]);
		$t2 = explode(':',$tArraySpace[1]);
		$out.="
		<script type='text/javascript'>						
			$('#tarih_".$d['ID']."').countdown({until: new Date(".$t1[0].", (".$t1[1]." - 1), ".$t1[2]."),timezone: +2,     layout: '"._lang_kampanyaBaslangic." <b>{dn} {dl} {mn} {ml} {hn} {hl} {sn} {sl}</b>'});
		</script>
		";
	}
	$out.='</div>';
	
	$out.="<script>$('.kb .info').fadeTo('',0.5); $('.inactive .resim img').each(function() { grayscale(this); }); </script>";
	return $out;
}
?>
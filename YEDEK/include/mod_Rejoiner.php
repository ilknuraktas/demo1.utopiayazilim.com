<?
$actHeaderArray['sepet'] = nanoSepet();
//$actHeaderArray['urunDetay'] = nanoProduct();
// $actHeaderArray['kategoriGoster'] = nanoCategory();
function nanoSepet()
{
	global $siteDizini;
	$q = my_mysql_query("select * from siparis where randStr like '".$_SESSION['randStr']."'");
	$d = my_mysql_fetch_array($q);
	$out.= "<script type='text/javascript'>";
	if($d)
	{	
		$out.="
		_rejoiner.push(['setCartData', {
			'email' : '".$d['email']."', 
			'value': '".$d['randStr']."', 
			'totalItems': '".basketInfo('toplamUrun','')."', 
			'returnUrl': 'http://'".$_SERVER['HTTP_HOST'].$siteDizini."'page.php?act=sepet' 
		}]); ";
		
	$q2 = my_mysql_query("select * from sepet where randStr like '".$_SESSION['randStr']."'");
	while($d2 = my_mysql_fetch_array($q2))
	{
		$out.="_rejoiner.push(['setCartItem', { 
			'product_id': '".$d2['urunID']."', 
			'qty_price': '".$d2['ytlFiyat']."', 
			'name': '".$d2['urunName']."', 
			'description': '".hq("select onDetay from urun where ID='".$d2['urunID']."'")."', 
			'price': '".($d2['ytlFiyat'] * $d2['adet'])."', 
			'image_url': 'http://'".$_SERVER['HTTP_HOST'].$siteDizini."'/images/urunler/".hq("select resim from urun where ID='".$d2['urunID']."'")."' 
		}]);"; 
	}
	$out.="</script> ";
		return $out;
	}
	
}

?>
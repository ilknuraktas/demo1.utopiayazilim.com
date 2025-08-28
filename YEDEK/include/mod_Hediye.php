<?
	$hediyeKategoriID = 47;
	if($_GET['act'] == 'sepet' && $_GET['op'] == 'ekle')
	{
		// Şu anki sepette var mı?
		$eklenecekUrunCat = hq("select catID from urun where ID='".$_GET['urunID']."'");
		if ($eklenecekUrunCat == $hediyeKategoriID)
		{
			if (hq("select sepet.ID from sepet,urun where sepet.urunID=urun.ID AND sepet.randStr = '".$_SESSION['randStr']."' AND urun.catID='".$hediyeKategoriID."'"))
			{
				$_GET['op'] = $_GET['urunID'] = '';
				$sepetMesaj = 'Hediye ürünlerden azami bir adet sepete atılabilmektedir.';
			}

			if (hq("select sepet.ID from sepet,urun where sepet.urunID=urun.ID AND sepet.durum > 0 AND urun.catID='".$hediyeKategoriID."' AND sepet.userID = '".$_SESSION['userID']."'"))
			{
				$_GET['op'] = $_GET['urunID'] = '';
				$sepetMesaj = 'Daha önce hediye aldığınızdan ürün sepete eklenemedi.';
			}			
			$_GET['adet'] = 1;
		}
	}
?>
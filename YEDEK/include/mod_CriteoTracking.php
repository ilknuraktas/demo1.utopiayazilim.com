<?
$orandStr = $_SESSION['randStr'];

function criteoOdeme()
{
	global $tamamlandi,$orandStr,$siteConfig,$criteoAccountID,$criteoEmail,$criteoSiteType;
	
	$criteoAccountID = siteConfig('criteoAccountID');
	$criteoEmail = $_SESSION['userID']?hq("select email from user where ID='".$_SESSION['userID']."'"):hq("select email from siparis where randStr='".$orandStr."'");
	$criteoSiteType = (isReallyMobile()?'m':'d');


	if($_GET['op'] == 'odeme' && $tamamlandi)	
	{
		
		return '<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
					<script type="text/javascript">
					window.criteo_q = window.criteo_q || [];
					window.criteo_q.push(
					{ event: "setAccount", account: '.(int)$criteoAccountID.' },
					{ event: "setEmail", email: "'.$criteoEmail.'" },
					{ event: "setSiteType", type: "'.$criteoSiteType.'" },
					{ event: "trackTransaction", id: "'.$orandStr.'", item: [
					'.criteoSepetList().'
					/* kullan�c�n�n sepetindeki her ��e i�in bir sat�r ekleyin */
					]}
					);
				</script>
					';
	}
}
function criteoSepetList()
{
	global $tamamlandi,$orandStr,$siteConfig,$criteoAccountID,$criteoEmail,$criteoSiteType;
	
	$criteoAccountID = siteConfig('criteoAccountID');
	$criteoEmail = $_SESSION['userID']?hq("select email from user where ID='".$_SESSION['userID']."'"):hq("select email from siparis where randStr='".$orandStr."'");
	$criteoSiteType = (isReallyMobile?'m':'d');


		$q = my_mysql_query("select sepet.*,kategori.name catName from urun,kategori,sepet where urun.ID = sepet.urunID AND urun.catID = kategori.ID AND sepet.randStr like '$orandStr'");
		while($d = my_mysql_fetch_array($q))
		{
			$items.=($items?',':'').'{ id: "'.$d['urunID'].'", price: '.$d['ytlFiyat'].', quantity: '.$d['adet'].' }';
		}
	return $items;
}
function criteoUrunList($catID)
{
	global $orandStr;
	
	$criteoAccountID = siteConfig('criteoAccountID');
	$criteoEmail = $_SESSION['userID']?hq("select email from user where ID='".$_SESSION['userID']."'"):hq("select email from siparis where randStr='".$orandStr."'");
	$criteoSiteType = (isReallyMobile()?'m':'d');
	
	$q = my_mysql_query("select ID from urun where catID = '".$catID."' OR showCatIDs like '%|$catID|%' order by seq desc, ID desc limit 0,3");
	while($d = my_mysql_fetch_array($q))
	{
		$out.='"'.$d['ID'].'",';
	}
	if($out) return substr($out,0,-1);	
}
function criteoReconversion()
{
	global $siteConfig,$criteoAccountID,$criteoEmail,$criteoSiteType;
	
	$criteoAccountID = siteConfig('criteoAccountID');
	$criteoEmail = $_SESSION['userID']?hq("select email from user where ID='".$_SESSION['userID']."'"):hq("select email from siparis where randStr='".$orandStr."'");
	$criteoSiteType = (isReallyMobile()?'m':'d');
	
	switch($_GET['act'])
	{
		case 'urunDetay':
			return '<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
						<script type="text/javascript">
						window.criteo_q = window.criteo_q || [];
						window.criteo_q.push(
						{ event: "setAccount", account: '.(int)$criteoAccountID.' },
						{ event: "setEmail", email: "'.$criteoEmail.'" },
						{ event: "setSiteType", type: "'.$criteoSiteType.'" },
						{ event: "viewItem", item: "'.$_GET['urunID'].'" }
						);
					</script>
						';
		break;
		case 'sepet':
		case 'satinal':
			if(!criteoSepetList()) return;
			return '<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
				<script type="text/javascript">
				window.criteo_q = window.criteo_q || [];
				window.criteo_q.push(
				{ event: "setAccount", account: '.(int)$criteoAccountID.' },
				{ event: "setEmail", email: "'.$criteoEmail.'" },
				{ event: "setSiteType", type: "'.$criteoSiteType.'" },
				{ event: "viewBasket", item: [
				'.criteoSepetList().'
				]}
				);
				</script>
				';
		break;
		case 'kategoriGoster':
			return '<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
					<script type="text/javascript">
					
					window.criteo_q = window.criteo_q || [];
					
					window.criteo_q.push(
					
					{ event: "setAccount", account: '.(int)$criteoAccountID.' },
					{ event: "setEmail", email: "'.$criteoEmail.'" },
					{ event: "setSiteType", type: "'.$criteoSiteType.'" },
					
					{ event: "viewList", item:[ '.criteoUrunList($_GET['catID']).' ]}
					
					);
					
					</script>
					';
		break;	
		case 'arama':
			$pID = $_GET['str'];
			$total = '0';
		break;	
		default:
			return '<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
						<script type="text/javascript">						
						window.criteo_q = window.criteo_q || [];						
						window.criteo_q.push(						
						{ event: "setAccount", account: '.(int)$criteoAccountID.' },						
						{ event: "setEmail", email: "'.$criteoEmail.'" },						
						{ event: "setSiteType", type: "'.$criteoSiteType.'" },						
						{ event: "viewHome" }						
						);						
						</script>
						';
		break;	

	}
}

?>
<?
$actHeaderArray['sepet'] = nanoSepet();
$actHeaderArray['urunDetay'] = nanoProduct();
$actHeaderArray['kategoriGoster'] = nanoCategory();
function nanoSepet()
{
	return "<!-- Begin of JS-PROFILING-PX V1.2 TAG created by HEIAS AdServer on 2013/04/03 12:32:06 -->
<script type=\"text/javascript\">
(function(d){

var HEIAS_PARAMS = [];
HEIAS_PARAMS.push(['type', 'ppx'], ['ssl', 'auto'], ['n', '6451'], ['cus', '19877']);
HEIAS_PARAMS.push(['pb', '1']);
HEIAS_PARAMS.push(['order_article', '".nanoArticle()."']);


if (typeof window.HEIAS === 'undefined') { window.HEIAS = []; }
window.HEIAS.push(HEIAS_PARAMS);

var scr = d.createElement('script');
scr.async = true;
scr.src = (d.location.protocol === 'https:' ? 'https:' : 'http:') + '//ads.heias.com/x/heias.async/p.min.js';
var elem = d.getElementsByTagName('script')[0];
elem.parentNode.insertBefore(scr, elem);

}(document));
</script>

<!-- End of JS-PROFILING-PX -->";	
}

function nanoProduct()
{
	return "<!-- Begin of JS-PROFILING-PX V1.2 TAG created by HEIAS AdServer on 2013/04/03 12:31:17 -->
<script type=\"text/javascript\">
(function(d){

var HEIAS_PARAMS = [];
HEIAS_PARAMS.push(['type', 'ppx'], ['ssl', 'auto'], ['n', '6451'], ['cus', '19877']);
HEIAS_PARAMS.push(['pb', '1']);
HEIAS_PARAMS.push(['product_id', '".$_GET['urunID']."']);
HEIAS_PARAMS.push(['shop_id', '".$_SESSION['randStr']."']); 
HEIAS_PARAMS.push(['product_brand', '".hq("select marka.name from urun,marka where urun.ID='".$_GET['urunID']."' AND urun.markaID = marka.ID limit 1")."']);

if (typeof window.HEIAS === 'undefined') { window.HEIAS = []; }
window.HEIAS.push(HEIAS_PARAMS);

var scr = d.createElement('script');
scr.async = true;
scr.src = (d.location.protocol === 'https:' ? 'https:' : 'http:') + '//ads.heias.com/x/heias.async/p.min.js';
var elem = d.getElementsByTagName('script')[0];
elem.parentNode.insertBefore(scr, elem);

}(document));
</script>

<!-- End of JS-PROFILING-PX -->";	
}

function nanoCategory()
{
	return "<!-- Begin of JS-PROFILING-PX V1.2 TAG created by HEIAS AdServer on 2013/04/03 12:31:17 -->
<script type=\"text/javascript\">
(function(d){

var HEIAS_PARAMS = [];
HEIAS_PARAMS.push(['type', 'ppx'], ['ssl', 'auto'], ['n', '6451'], ['cus', '19877']);
HEIAS_PARAMS.push(['pb', '1']);
HEIAS_PARAMS.push(['category_id', '".$_GET['catID']."']);
HEIAS_PARAMS.push(['shop_id', '".$_SESSION['randStr']."']); 

if (typeof window.HEIAS === 'undefined') { window.HEIAS = []; }
window.HEIAS.push(HEIAS_PARAMS);

var scr = d.createElement('script');
scr.async = true;
scr.src = (d.location.protocol === 'https:' ? 'https:' : 'http:') + '//ads.heias.com/x/heias.async/p.min.js';
var elem = d.getElementsByTagName('script')[0];
elem.parentNode.insertBefore(scr, elem);

}(document));
</script>

<!-- End of JS-PROFILING-PX -->";	
}

function nanoOdeme()
{
	global $tamamlandi;
	if($_GET['op'] == 'odeme' && $tamamlandi)	
	{
		return "<!-- Begin of CPA-CountPX V2.2 TAG created by HEIAS AdServer on 2013/04/03 12:33:01   -->
<script type=\"text/javascript\">
(function(d){

var HEIAS_PARAMS = [];
HEIAS_PARAMS.push(['type', 'cpx'], ['ssl', 'force'], ['n', '6451'], ['cus', '19877']);
HEIAS_PARAMS.push(['pb', '1']);
HEIAS_PARAMS.push(['order_article', '".nanoArticle()."']);
HEIAS_PARAMS.push(['order_id', '".$_SESSION['randStr']."]']);
HEIAS_PARAMS.push(['order_total', '".basketInfo('ModulFarkiIle',$_SESSION['randStr'])."']);
HEIAS_PARAMS.push(['product_quantity', '".nanoQuantity()."']);
HEIAS_PARAMS.push(['customer_gender', '".hq("select sex from user where ID='".$_SESSION['userID']."'")."']);

    
if (typeof window.HEIAS == 'undefined') window.HEIAS = [];
window.HEIAS.push(HEIAS_PARAMS);

var scr = d.createElement('script'); 
scr.async = true; 
scr.src = (d.location.protocol === 'https:' ? 'https:' : 'http:') + '//ads.heias.com/x/heias.async/p.min.js';
var elem = d.getElementsByTagName('script')[0]; 
elem.parentNode.insertBefore(scr, elem);
    
}(document));
</script>
<!-- End of CPX-CountPX -->";	
	}
}

function nanoArticle()
{
	$q = my_mysql_query("select * from sepet where randStr like '".$_SESSION['randStr']."'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.=$d['urunID'].',';
	}
	if($out) return substr($out,0,-1);	
}

function nanoQuantity()
{
	$q = my_mysql_query("select * from sepet where randStr like '".$_SESSION['randStr']."'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.=$d['adet'].',';
	}
	if($out) return substr($out,0,-1);	
}
?>
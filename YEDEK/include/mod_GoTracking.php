<?
/*
all.php : 

if($_GET['gotrack'])
	$_SESSION['gotrack'] = 1;
if(($_SESSION['gotrack'] && !isset($_GET['f'])) || hq("select ID from siparis where randstr = '".$_POST['randStr']."' AND data5 = 'gotrack' AND durum = 1"))
{
	require('mod_GoTracking.php');	
	$_SESSION['refForSession'] = 'gotrack';
}


s.php :

if(hq("select ID from siparis where randstr = '".$_POST['randStr']."' AND data5 = 'gotrack' AND durum = 1"))
{
	require('../include/mod_GoTracking.php');	
}


*/
$orandStr = $_SESSION['randStr'];
function modAfterPayment($odemeDurum,$orandStr)
{
	if($odemeDurum >=2)
	{
		$out= '<iframe src="https://tr.rdrtr.com/GL8Tq?adv_sub='.$orandStr.'&amount='.basketInfo('ModulFarkiIle',$orandStr).'"
scrolling="no" frameborder="0" width="1" height="1"></iframe>';

		$out.='<script type="text/javascript"> var go_prodid = ["'.goSepetList().'"];
var go_orderid ="'.$orandStr.'" ;
var go_amount="'.basketInfo('ModulFarkiIle',$orandStr).'";
var go_catname = ['.goSepetCatList().'];
</script>';
	}
	return $out;
}

function goReconversion()
{
	global $orandStr;
	switch($_GET['act'])
	{
		case 'kategoriGoster':
			$out.='<script type="text/javascript"> 
					var go_prodid = ["'.goCatList().'"];
					var go_catname="'.hq("select namePath from kategori where ID='".$_GET['catID']."'").'";
					</script>';
		break;	
		case 'urunDetay':
			$out.='<script type="text/javascript"> var go_prodid = "'.$_GET['urunID'].'";
			var go_catname = ["'.hq("select namePath from kategori where ID='".hq("select catID from urun where ID='".$_GET['urunID']."'")."'").'"];
			</script>';
			
		break;
		case 'sepet':
			$out.='<script type="text/javascript"> var go_ prodid = ["'.goSepetList().'"];
			var go_catname = ['.goSepetCatList().'];
			</script>';
		break;
	}
	
	$out .= "<!-- SUPERTAG CODE ASYNC v2.9.6 -->
<script type=\"text/javascript\">
(function(s,d,src) {
var st = d.createElement(s); st.type = 'text/javascript';st.async = true;st.src = src;
var sc = d.getElementsByTagName(s)[0]; sc.parentNode.insertBefore(st, sc);
})('script', document, '//c.supert.ag/p/000255/supertag-async.js');
</script>";	

	return $out;
}

function goSepetList()
{
	global $orandStr;
	$q = my_mysql_query("select urunID from sepet where randStr like '".$orandStr."'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.=$d['urunID'].',';
	}
	if($out) return substr($out,0,-1);	
}

function goSepetCatList()
{
	global $orandStr;
	$q = my_mysql_query("select kategor.name from sepet,urun,kategori where kategori.ID=urun.catID AND sepet.urunID = urun.ID AND sepet.randStr like '".$orandStr."'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.='"'.$d['name'].'",';
	}
	if($out) return substr($out,0,-1);	
}

function goCatList()
{
	$q = my_mysql_query("select ID from urun where catID='".$_GET['catID']."' OR showCatIDs like '%|".$_GET['catID']."|%'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.=$d['ID'].',';
	}
	if($out) return substr($out,0,-1);	
}?>
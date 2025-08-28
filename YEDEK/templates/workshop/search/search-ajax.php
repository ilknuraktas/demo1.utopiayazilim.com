<?php 
ob_start();

header('Content-Type: text/html; charset=utf-8');

if($_POST["keyword"]):

	function mumiSearch_ajax($keyword){
		
	function trsil($tr)
	{
	$bul = array ('Z', 'X', 'C', 'V', 'B', 'N', 'M', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', '|'); 
			$degis = array ('z', 'x', 'c', 'v', 'b', 'n', 'm', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'ı', 'o', 'p',' '); 
			$sef=str_replace($bul, $degis,$tr );
		
		$bul   = array ('â€™', '.', 'Ä°', 'Ã‡', 'Ãœ', 'Ã¼', 'Ã–', 'Ã¶', 'ÅŸ', 'Å', 'ÄŸ', 'Ä', 'Ã§', 'Ä±', ' ', 'ı', 'İ', 'ç', 'Ç', 'Ü', 'ü', 'Ö', 'ö', 'ş', 'Ş', 'ğ', 'Ğ', '(',')','&'); 
			$degis = array ('-', '-', 'i', 'c', 'u', 'u', 'o', 'o', 's', 's', 'g', 'g', 'c', 'i', '-', 'i', 'i', 'c', 'c', 'u', 'u', 'o', 'o', 's', 's', 'g', 'g','-','-','-'); 
			$sef = str_replace($bul, $degis, $sef); 
			
			$bul = array('&quot;', '&amp;', '\r\n', '\n', '/', '\\', '+', '<', '>');
		$sef = str_replace ($bul, '-', $sef);
			$bul = array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ë', 'Ê');
		$sef = str_replace ($bul, 'e', $sef);
		
		 $bul = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
	   $sef = preg_replace ($bul, $repl, $sef);

	   $bul=array('---','--','----','-----','-----');
	   $degis=array('-','-','-','-','-');
	   $sef = str_replace($bul, $degis, $sef);
	   return $sef;
	}
	
	
	set_time_limit(0);

	include('../../../include/conf.php');

	$i = 0;
 
	$q = mysql_query("select * From urun WHERE name LIKE '$keyword%' and active=1 LIMIT 10");
	
	$out.="<ul>";
	
	if(!empty($q)):
	
	while ($d = mysql_fetch_array($q)) 	{
		$i++;
		
		if($i % 2 == 0 )
			
			 { $out.='<li class="last">'; }
		 
		else {  $out.='<li>'; }

		$out.="<img src='../../../include/resize.php?path=images/urunler/".$d["resim"]."&width=50' />";
		
		$out.="<h3>".trsil($d['name'])."</h3>";
		$out.="<a href='".$d['seo']."'>İncele <i class='fa fa-reply-all'></a></i>";

		$out.="</li>\n";
		
		}
		
		$out.='<li class="incorrect"><b><a href="page.php?act=arama&str='.$keyword.'"><i class="fa fa-share"></i> Detaylı Arama Yapınız</a></b> </li>';

		
	endif;
	
	

 

	$out.="</ul>";
	return $out;	
	
	
}
echo mumiSearch_ajax($_POST["keyword"]);
else:

die();

endif;

ob_end_flush();

?>
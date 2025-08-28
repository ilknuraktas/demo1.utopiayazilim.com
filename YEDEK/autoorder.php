<?php 
set_time_limit(0);
include('include/all.php');
$q = mysql_query("select * from siparis where tekrarlaAktif=1 AND takrarSure > 0");
while($d = mysql_fetch_array($q))
{
	list($rd) = explode(' ',$d['tarih']);
	list($y,$m,$d) = explode('-',$rd);
	$dateSQL = date('Y-m-d', mktime(0, 0, 0, $m, $d , $y));
	$dateCheck = date('Y-m-d', mktime(0, 0, 0, $m, ($d + ((int)$d['tekrarSure'])) , $y));
	$dateNow = date('Y-m-d');
	if(strtotime($dateNow) >= strtotime($dateCheck))
	{
		echo Sepet::autoreOrder($d['randStr']);
		mysql_query("update siparis set tekrarAktif =0 where randStr like '".$d['randStr']."'");
	}
}
?>
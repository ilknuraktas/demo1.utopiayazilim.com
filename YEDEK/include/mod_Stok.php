<?php
$modStok['al'] = true;
$modStok['gonder'] = 'http://www.test.com/';
$modStok['IP'][] = '127.0.0.1';

function mymodStokUpdate()
{
	global $modStok;
	if(!$modStok['al']) exit('stokUpdateDisabled');
	if(!in_array($_SERVER['REMOTE_ADDR'],$modStok['IP'])) exit('invalidIp');
		$uq = my_mysql_query("select * from urun where ID='".$_GET['urunID']."'");
		$ud = my_mysql_fetch_array($uq);
		$_GET['urunID'] = hq("select ID from urun where tedarikciCode like '".$_GET['uCode']."'");	
		$query = "update urun set stok = (stok - ".$_GET['adet'].")  where ID='".$_GET['urunID']."'";
		my_mysql_query($query);
		$uq = my_mysql_query("select * from urun where ID='".$_GET['urunID']."'");
		$ud = my_mysql_fetch_array($uq);				
		for($oi=0;$oi<=3;$oi++)
		{
			if (!$ud['ozellik'.$oi.'detay']) continue;
			$ozellik = $ud['ozellik'.$oi.'detay'];
			$lines = explode("\n",$ozellik);
			foreach($lines as $line)
			{
				list($opt,$price,$stok) = explode('|',$line);
				$stok = trim($stok);
				$price = trim($price);
				$opt = trim($opt);
				
				if($opt == $_GET['ozellik'.$oi] && ($stok != ''))
				{ 
					$stok = ((int)$stok - $_GET['adet']);
				}
				if (trim($opt)) $val.=trim("$opt|$price|$stok")."\n";
				$val = str_replace('||','',$val);
			}
			if ($val) 
				my_mysql_query("update urun set ozellik".$oi."detay = '$val' where ID='".$_GET['urunID']."'");
		}
		exit('Stok_Update_OK');		
}

function modStokSend($randStr)
{
	global $modStok;
	if(!$modStok['gonder']) return;
	$q = my_mysql_query("select * from sepet where randStr like '$randStr'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.=file_get_contents($modStok['gonder'].'/page.php?act=modStokUpdate&uCode='.hq("select tedarikciCode from urun where ID='".$d['ID']."'").'&adet='.$d['ID'].'&ozellik1='.$d['ozellik1'].'&ozellik2='.$d['ozellik2'].'&ozellik3='.$d['ozellik3']);	
	}
	return $out;
}
?>
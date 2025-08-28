<?
function myfeed()
{
	$style='
	<style>
	.cfeed { width:100%; border-bottom:1px solid #ccc; padding-bottom:10px; margin-bottom:10px; }
	.cfeed table { width:100%;}
	.cfeed a { color:#2477e6}
	.cfeed .l1 { padding-bottom:5px; }
	.cfeed .l31 { font-size:10px; color:#bbb; float:left; margin-right:10px; }
	.cfeed .l32 { float:left; }
	.cfeed .l32 img { border:1px solid #ccc; padding:5px; }
		</style>
	';
	$q = my_mysql_query("select * from sepet where userID > 0 group by userID order by ID desc limit 0,20");
	$i = 1;

	while($d = my_mysql_fetch_array($q))
	{			
		$line1 = $line2 = $line3 = $urarr = '';
		$add = '';
		$urarr = array();
		$name = hq("select name from user where ID='".$d['userID']."'");
		$lastname = hq("select lastname from user where ID='".$d['userID']."'");
		
		if(!$name)
		{
			$name = $d['name'];
			$lastname = $d['lastname'];	
		}
		$user = ucfirst($name).' '.ucfirst(substr($lastname,0,1)).'.';
		
		$urun = '<a href="'.urunLink($d['urunID']).'">'.hq("select name from urun where ID='".$d['urunID']."'").'</a>';
		$q2 = my_mysql_query("select urunID from sepet where randStr = '".$d['randStr']."' AND urunID != '".$d['urunID']."'");
		while($d2 = my_mysql_fetch_array($q2))
		{
			$urarr[] = $d2['urunID'];	
		}
		
		if($d['durum'] == 0)
		{
			$t = hq("select count(*) from sepet where randStr = '".$d['randStr']."'");
			if($t > 1)
			{
				$add = 've '.($t -1).' ürünü daha';	
			}
			$line1 = "<strong>$user</strong> $urun ürününü $add sepetine ekledi.";
			if(sizeof($urarr) > 0)
				$line3 = 'Sepetteki diğer ürünler';
			
		}
		else
		{
			$t = hq("select count(*) from sepet where randStr = '".$d['randStr']."'");
			if($t > 1)
			{
				$add = 've '.($t -1).' ürünü daha';	
			}
			$line1 = "<strong>$user</strong> $urun ürününü $add satın aldı.";
			$line2 = "<strong>$user</strong>".' bu zamana kadar '.hq("select count(*) from sepet where userID = '".$d['userID']."' AND durum > 0 group by randStr").' defa sipariş verdi. ';
			if(sizeof($urarr) > 0)
				$line3 = "<strong>$user</strong>".' şu ürünleri de aldı.';			
		}
		$out.=feedtemp($d['urunID'],$line1,$line2,$line3,$urarr,$d['tarih']);
		$i++;
		if(!($i %3))
		{
			$q3 = my_mysql_query("select * from urun where sold > 0 AND hit > 0 AND active = 1 AND stok > 0 order by rand() limit 0,1");
			$d3 = my_mysql_fetch_array($q3);
			if(my_mysql_num_rows($q3))
			{
				$urun = '<a href="'.urunLink($d3['ID']).'">'.$d3['name'].'</a>';			
				$out.=feedtemp($d3['ID'],$urun.' bugüne kadar '.$d3['hit'].' defa incelendi ve '.$d3['sold'].' adet satın alındı.','','',array(),$d['tarih']);	
			}
		}
		
	}
	return $style.generateTableBox('Canlı Takip',$out,tempConfig('formlar'));;
}

function feedtemp($urunID,$line1,$line2,$line3,$urarr,$date)
{
	foreach($urarr as $uID)
	{
		$line4.='<td><a href="'.urunLink($uID).'"><img src="include/resize.php?path=images/urunler/'.hq("select resim from urun where ID='$uID'").'&width=32" style="width:32px; height:32px;" /></a></td>';	
	}
	$line4 = '<table style="width:100%"><tr>'.$line4.'</tr></table>';
	$sablon = '<div class="cfeed"><table >
				<tr>
					<td style="width:100px"><a href="'.urunLink($urunID).'"><img src="include/resize.php?path=images/urunler/'.hq("select resim from urun where ID='$urunID'").'&width=100" style="width:85px;"></a></td>
					<td valign="top" style="vertical-align:top; padding-top:10px; padding-left:20px; width:100%">
						<div class="l1">'.$line1.'</div>
						<div class="l2">'.$line2.'</div>
						<div class="l31">'.$line3.'</div>
						<div class="l32">'.$line4.'</div>
					</td>
					<td style="width:150px" class="l31" valign="top">'.mysqlTarih($date).'</td>
				</tr></table></div>';	
	return $sablon;
}
?>
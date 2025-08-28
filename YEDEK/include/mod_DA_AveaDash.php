<?
function insertScore($date = 0)
{
	echo '../extra/aveadash/score_'.$date.'.xml';
	if(!$date) 
		$date = date('dmY');
	$file = file_get_contents('extra/aveadash/score_'.$date.'.xml');
	$xml = new SimpleXMLElement($file);
	foreach($xml->User as $user)
	{
		if(!hq("select ID from aveadash where ntwid = '".$user['ntwid']."' AND row_date = '".$user['row_date']."'"))
		{
			$sql = "INSERT INTO `aveadash` (`ID`, `ntwid`, `row_date`, `manager`, `net_eBill_count`, `musteriRizasi_count`, `moral_activity_count`, `realod_amount`) 
						VALUES  (NULL, '".$user['ntwid']."', '".$user['row_date']."', '".$user['manager']."', '".$user->net_eBill_count."', '".$user->musteriRizasi_count."', '".$user->moral_activity_count."', '".$user->realod_amount."');";	
			my_mysql_query($sql);
		}
	}
}

function myaveadash()
{
	if (!$_SESSION['loginStatus']) return;


		
	if($_POST['tarih_start_gun'])
	{	
		$_SESSION['tarih_start_gun'] = $_POST['tarih_start_gun'];
		$_SESSION['tarih_start_ay'] = $_POST['tarih_start_ay'];
		$_SESSION['tarih_start_yil'] = $_POST['tarih_start_yil'];
		$_SESSION['tarih_finish_gun'] = $_POST['tarih_finish_gun'];
		$_SESSION['tarih_finish_ay'] = $_POST['tarih_finish_ay'];
		$_SESSION['tarih_finish_yil'] = $_POST['tarih_finish_yil'];
	}
	else
	{
		$_POST['tarih_start_gun'] = $_SESSION['tarih_start_gun'];
		$_POST['tarih_start_ay'] = $_SESSION['tarih_start_ay'];
		$_POST['tarih_start_yil'] = $_SESSION['tarih_start_yil'];
		$_POST['tarih_finish_gun'] = $_SESSION['tarih_finish_gun'];
		$_POST['tarih_finish_ay'] = $_SESSION['tarih_finish_ay'];
		$_POST['tarih_finish_yil'] = $_SESSION['tarih_finish_yil'];
	}
		
	tarihFix('start');
	tarihFix('finish');		

	foreach ($_POST as $k=>$v) $d[str_replace('data_','',$k)] = $v;
	$out.= generateTableBox('Periyod Aralığı Sorgula',generateForm(getSortForm(),$d,'',''),tempConfig('formlar'));
	$tl = hq("select data5 from user where ID='".$_SESSION['userID']."'");
	if(isset($_GET['tl'])) 
		$_SESSION['tl'] = $_GET['tl'];
	$tl = $_SESSION['tl'];
	if($tl) 
		$_SESSION['username'] = '27131';
	else
		$_SESSION['username'] = '25390';
	if($_POST['tarih_start_gun'])
	{	
		if(!$tl)
		{		
			$out .= generateTableBox('<span style="float:left;">Periyod Toplam Puan :  '.
				(
					hq("select sum(net_eBill_count) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND net_eBill_count > 0") + 
					hq("select sum(moral_activity_count) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND moral_activity_count > 0") + 
					hq("select sum(realod_amount) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND realod_amount > 0") +
					hq("select sum(musteriRizasi_count) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND musteriRizasi_count > 0") +
					hq("select sum(hediye) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND hediye > 0") + 
					hq("select sum(mma) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND mma > 0") 
				 ).'</span><span style="float:right;">('.mysqlTarih($_POST['data_start']).' - '.mysqlTarih($_POST['data_finish']).')</span>',listTotalPeriod(),tempConfig('sepet'));
			$out .= '<br />'.generateTableBox('Periyod Detay Liste',listDetailPeriod(),tempConfig('sepet'));
			$out .= '<br />'.generateTableBox('Periyod Grafik',chartTotalPeriod('ntwid'),tempConfig('sepet'));
		}
		else
		{
			if($_GET['ntwid'])
				$out .= generateTableBox($_GET['ntwid'].' Sicil Nolu Periyod Puanları',listTLUserDetailPeriod(),tempConfig('sepet'));
			
			$out .= generateTableBox('<span style="float:left;">Periyod Toplam Puan : '.hq("select (sum(net_eBill_count) + sum(moral_activity_count) + sum(realod_amount) + sum(musteriRizasi_count) + sum(hediye) + sum(mma)) from aveadash where manager = '".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."'").'</span><span style="float:right;">('.mysqlTarih($_POST['data_start']).' - '.mysqlTarih($_POST['data_finish']).')</span>',listTLParentPeriod(),tempConfig('sepet'));
			$out .= generateTableBox('Periyod Puanları',listTLDetailPeriod(),tempConfig('sepet'));
			$out .= '<br />'.generateTableBox('Periyod Grafik',chartTotalPeriod('manager'),tempConfig('sepet'));
			
		}
	}
	return $out;
}

function listTLParentPeriod() {
	$out='<table class="sepet" cellpadding="0" cellspacing=2><tr>';
	$out.='<th>Müşteri Temsilcisi</th>';
	$out.='<th>TL İlişkili Puan</th>';
	$out.='<th>Total Puan</th>';
	$out.='</tr>';
	$q = my_mysql_query("select * from aveadash where manager='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' group by ntwid");
	$i = 1;
	while($d = my_mysql_fetch_array($q))
	{
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$out.='<tr class="'.$class.'">';
		$out.='<td><a href="page.php?act=aveadash&ntwid='.$d['ntwid'].'">'.$d['ntwid'].' - '.hq("select concat(name,' ',lastname) from user where username like '".$d['ntwid']."'").'</a></td>';
		$out.='<td>'.hq("select (sum(net_eBill_count) + sum(moral_activity_count) + sum(realod_amount) + sum(musteriRizasi_count) + sum(hediye) + sum(mma)) from aveadash where ntwid like '".$d['ntwid']."' AND manager = '".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."'").'</td>';
		$out.='<td>'.
			(hq("select (sum(net_eBill_count) + sum(moral_activity_count) + sum(realod_amount) + sum(musteriRizasi_count) + sum(hediye) + sum(mma)) from aveadash where ntwid like '".$d['ntwid']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."'") / hq("select count(*) from aveadash where ntwid like '".$d['ntwid']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' ")
			)
			.'</td>';
		$out.='<tr>'."\n";
		$i++;		
	}
	$out.='</table>';	
	return $out;
}

function getManagerSum($f,$d)
{
	return my_money_format('',((float)hq("select sum($f) from aveadash where manager='".$_SESSION['username']."' AND row_date = '$d'") / (float)hq("select count(*) from aveadash where manager='".$_SESSION['username']."' AND row_date = '$d'")) * 1.5) ;
}

function listTLDetailPeriod() {
	$out='<table class="sepet" cellpadding="0" cellspacing=2><tr>';
	$out.='<th>Tarih</th>';
	$out.='<th>E-Fatura</th>';
	$out.='<th>Veri Gizliliği</th>';
	$out.='<th>MMA Kalite</th>';
	$out.='<th>Moral</th>';
	$out.='<th>TL Yükleme</th>';
	$out.='<th>Hediye</th>';
	$out.='<th>Toplam</th>';
	$out.='</tr>';
	$q = my_mysql_query("select * from aveadash where manager='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' group by row_date");
	$i = 1;
	while($d = my_mysql_fetch_array($q))
	{
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$out.='<tr class="'.$class.'">';
		$out.='<td>'.mysqlTarih($d['row_date']).'</td>';
		$out.='<td>'.(float)getManagerSum('net_eBill_count',$d['row_date']).'</td>';
		$out.='<td>'.(float)getManagerSum('musteriRizasi_count',$d['row_date']).'</td>';
		$out.='<td>'.(int)getManagerSum('mma',$d['row_date']).'</td>';
		$out.='<td>'.(float)getManagerSum('moral_activity_count',$d['row_date']).'</td>';
		$out.='<td>'.(float)getManagerSum('realod_amount',$d['row_date']).'</td>';
		$out.='<td>'.(float)getManagerSum('hediye',$d['row_date']).'</td>';
		$out.='<td>'.(getManagerSum('net_eBill_count',$d['row_date']) + getManagerSum('musteriRizasi_count',$d['row_date']) + getManagerSum('mma',$d['row_date']) + getManagerSum('moral_activity_count',$d['row_date']) + getManagerSum('realod_amount',$d['row_date']) + getManagerSum('hediye',$d['row_date'])).'</td>';
		$out.='<tr>'."\n";
		$i++;		
	}
	$out.='</table>';
	
	$out.='<div style="clear:both;">&nbsp;</div><input class="sf-button sf-button-large sf-neutral-button" onclick="window.location.href = (\'aveadash.php?excel=1&type=tldetail&start='.$_POST['data_start'].'&finish='.$_POST['data_finish'].'\');" type="button" value="Excel Kaydet" style="float:right;"><div style="clear:both;">&nbsp;</div>';
	
	return $out;
}

function listTLUserDetailPeriod() {
	$out='<table class="sepet" cellpadding="0" cellspacing=2><tr>';
	$out.='<th>Tarih</th>';
	$out.='<th style="color:red;">Toplam Puan</th>';
	$out.='<th>Sicil No</th>';
	$out.='<th>Ad-Soyad</th>';
	$out.='<th>Takım Lideri</th>';
	$out.='<th>Çalışma Süresi</th>';
	$out.='<th>E-Fatura</th>';
	$out.='<th>Veri Gizliliği</th>';
	$out.='<th>MMA Kalite</th>';
	$out.='<th>Moral</th>';
	$out.='<th>TL Yükleme</th>';
	$out.='<th>Hediye</th>';
	$out.='</tr>';
	$q = my_mysql_query("select * from aveadash where ntwid='".$_GET['ntwid']."' AND manager= '".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."'");
	$i = 1;
	while($d = my_mysql_fetch_array($q))
	{
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$out.='<tr class="'.$class.'">';
		$out.='<td>'.mysqlTarih($d['row_date']).'</td>';
		$out.='<td>'.($d['net_eBill_count'] + $d['musteriRizasi_count'] + $d['mma'] + $d['moral_activity_count'] + $d['realod_amount'] + $d['hediye']).'</td>';
		$out.='<td>'.$d['ntwid'].'</td>';
		$out.='<td>'.hq("select concat(name,' ',lastname) from user where username like '".$d['ntwid']."'").'</td>';
		$out.='<td>'.hq("select concat(name,' ',lastname) from user where username like '".$d['manager']."'").'</td>';
		$out.='<td>'.(float)$d['calisma'].'</td>';
		$out.='<td>'.(float)$d['net_eBill_count'].'</td>';
		$out.='<td>'.(float)$d['musteriRizasi_count'].'</td>';
		$out.='<td>'.(int)$d['mma'].'</td>';
		$out.='<td>'.(float)$d['moral_activity_count'].'</td>';
		$out.='<td>'.(float)$d['realod_amount'].'</td>';
		$out.='<td>'.(float)$d['hediye'].'</td>';
		
		$out.='<tr>'."\n";
		$i++;		
	}
	$out.='</table>';
	
	$out.='<div style="clear:both;">&nbsp;</div><input class="sf-button sf-button-large sf-neutral-button" onclick="window.location.href = (\'aveadash.php?excel=1&type=tl&ntwid=ALL&start='.$_POST['data_start'].'&finish='.$_POST['data_finish'].'\');" type="button" value="Tüm MTleri Excel Kaydet" style="float:right;"><input class="sf-button sf-button-large sf-neutral-button" onclick="window.location.href = (\'aveadash.php?excel=1&type=tl&ntwid='.$_GET['ntwid'].'&start='.$_POST['data_start'].'&finish='.$_POST['data_finish'].'\');" type="button" value="MTi Excel Kaydet" style="float:right;"><div style="clear:both;">&nbsp;</div>';
	
	return $out;
}

function listDetailPeriod() {
	$out='<table class="sepet" cellpadding="0" cellspacing=2><tr>';
	$out.='<th>Tarih</th>';
	$out.='<th>E-Fatura</th>';
	$out.='<th>Veri Gizliliği</th>';
	$out.='<th>MMA Kalite</th>';
	$out.='<th>Moral</th>';
	$out.='<th>TL Yükleme</th>';
	$out.='<th>Hediye</th>';
	$out.='<th>Toplam</th>';
	$out.='</tr>';
	$q = my_mysql_query("select * from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."'");
	$i = 1;
	while($d = my_mysql_fetch_array($q))
	{
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$out.='<tr class="'.$class.'">';
		$out.='<td>'.mysqlTarih($d['row_date']).'</td>';
		$out.='<td>'.(float)$d['net_eBill_count'].'</td>';
		$out.='<td>'.(float)$d['musteriRizasi_count'].'</td>';
		$out.='<td>'.(int)$d['mma'].'</td>';
		$out.='<td>'.(float)$d['moral_activity_count'].'</td>';
		$out.='<td>'.(float)$d['realod_amount'].'</td>';
		$out.='<td>'.(float)$d['hediye'].'</td>';
		$out.='<td>'.($d['net_eBill_count'] + $d['musteriRizasi_count'] + $d['mma'] + $d['moral_activity_count'] + $d['realod_amount'] + $d['hediye']).'</td>';
		$out.='<tr>'."\n";
		$i++;		
	}
	$out.='</table>';
	
	$out.='<div style="clear:both;">&nbsp;</div><input class="sf-button sf-button-large sf-neutral-button" onclick="window.location.href = (\'aveadash.php?excel=1&type=mt&start='.$_POST['data_start'].'&finish='.$_POST['data_finish'].'\');" type="button" value="Excel Kaydet" style="float:right;"><div style="clear:both;">&nbsp;</div>';
	
	return $out;
}

function listTotalPeriod() {
	global $siteConfig,$siteDizini;	
	$out ='<table class="sepet" cellpadding="0" cellspacing=2><tr>';
	$out.='<th style="text-align:left;">Aktivite</th>';
	$out.='<th>Adet</th>';
	$out.='<th>Puan</th>';
	$out.='</tr>';
 	
	$class = 'tr_normal';
	$out.='<tr class="'.$class.'">';
	$out.='<td style="text-align:left;">E-Fatura</td>';
	$out.='<td>'.hq("select count(*) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND net_eBill_count > 0").'</td>';
	$out.='<td>'.hq("select sum(net_eBill_count) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND net_eBill_count > 0").'</td>';
	$out.='<tr>'."\n";	
	    
	$class = 'tr_alternate';
	$out.='<tr class="'.$class.'">';
	$out.='<td style="text-align:left;">Moral Durumu</td>';
	$out.='<td>'.hq("select count(*) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND moral_activity_count > 0").'</td>';
	$out.='<td>'.hq("select sum(moral_activity_count) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND moral_activity_count > 0").'</td>';
	$out.='<tr>'."\n";
	
	$class = 'tr_normal';
	$out.='<tr class="'.$class.'">';
	$out.='<td style="text-align:left;">TL Yükleme</td>';
	$out.='<td>'.hq("select count(*) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND realod_amount > 0").'</td>';
	$out.='<td>'.hq("select sum(realod_amount) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND realod_amount > 0").'</td>';
	$out.='<tr>'."\n";	
		
	$class = 'tr_alternate';
	$out.='<tr class="'.$class.'">';
	$out.='<td style="text-align:left;">Veri Gizliliği</td>';
	$out.='<td>'.hq("select count(*) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND musteriRizasi_count > 0").'</td>';
	$out.='<td>'.hq("select sum(musteriRizasi_count) from aveadash where ntwid='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' AND musteriRizasi_count > 0").'</td>';
	$out.='<tr>'."\n";	
		
	$out.='</table>';
	return $out;
}

function chartTotalPeriod($filter = 'ntwid')
{
	$q = my_mysql_query("select sum(net_eBill_count) net_eBill_count,sum(moral_activity_count) moral_activity_count,sum(realod_amount) realod_amount,sum(musteriRizasi_count) musteriRizasi_count,sum(hediye) hediye,sum(mma) mma from aveadash where $filter ='".$_SESSION['username']."' AND row_date >= '".$_POST['data_start']."' AND row_date <= '".$_POST['data_finish']."' group by $filter");
	while($d = my_mysql_fetch_array($q))
	{
		list($yil,$ay,$gun) = explode('-',$d['row_date']);
		$k = $gun.'-'.$ay;
		$cats.="'$k',";
		$efat.=$d['net_eBill_count'].',';
		$moral.=$d['moral_activity_count'].',';
		$tl.=$d['realod_amount'].',';
		$veri.=$d['musteriRizasi_count'].',';
		$hediye.=$d['hediye'].',';
		$mma.=$d['mma'].',';
	}
	$cats = substr($cats,0,-1);
	$efat = substr($efat,0,-1);
	$moral = substr($moral,0,-1);
	$tl = substr($tl,0,-1);
	$veri = substr($veri,0,-1);
	$hediye = substr($hediye,0,-1);
	$mma = substr($mma,0,-1);
	$out = '<script src="extra/aveadash/js/highcharts.js"></script>
			<script src="extra/aveadash/js/modules/exporting.js"></script>

		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';	

	$out.="<script>$(function () {
		$('#container').highcharts({
			credits: {
				  enabled: false
			  },
			title: {
				text: 'Periyod Grafik',
				x: -20 //center
			},
			subtitle: {
				text: '".'('.mysqlTarih($_POST['data_start']).' - '.mysqlTarih($_POST['data_finish']).')'."',
				x: -20
			},
			xAxis: {
				categories: [".$cats."]
			},
			yAxis: {
				title: {
					text: 'Puan'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: ' Puan'
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			},
			series: [{
				name: 'E-Fatura',
				data: [".$efat."]
			}, {
				name: 'Moral Durumu',
				data: [".$moral."]
			}, {
				name: 'TL Yükleme',
				data: [".$tl."]
			}, {
				name: 'Veri Gizliliği',
				data: [".$veri."]
			}, {
				name: 'Hediye',
				data: [".$hediye."]
			}, {
				name: 'MMA',
				data: [".$mma."]
			}]
		});
	});</script>";
	return $out;
}


?>
<?
function myteknik()
{
	global $seo;
	$seo->currentTitle = _lang_titleTeknikServis;
	$out .= generateTableBox($seo->currentTitle,teknikTakip(),tempConfig('formlar'));
	if($_GET['code'] && !$_POST['data_code'])
		$_POST['data_code'] = $_GET['code'];
	if ($_POST['data_code']) 
		$out .= generateTableBox($_POST['data_code'].' '._lang_orderNumaraliTakipDetaylari,showTeknik(),tempConfig('sepet'));
	return $out;
}


function teknikTakip() {
	$form[] = array(_lang_teknikTakipNumaraniz,"code","TEXTBOX",1,'',1,3);
	foreach ($_POST as $k=>$v) $d[str_replace('data_','',$k)] = $v;
	$out = generateForm($form,$d,'',$hiddenInfo);	
	return $out;
}


function showTeknik() {
	global $siteConfig,$siteDizini;	
	$out ='
	<style>
		table.teknik tbody tr td { text-align:left; vertical-align:top; }
	</style>
	<table class="sepet teknik" cellpadding="0" cellspacing=2>';
	$q= my_my_mysql_query("select * from teknikservis where code like '".addslashes($_POST['data_code'])."' order by sdate desc");
	if(!my_mysql_num_rows($q))
		return _lang_userConfirm_codeerror;
	$i=1;
	while ($d = my_mysql_fetch_array($q)) {
		$class=(!($i%2)?'tr_normal':'tr_alternate');
		$out.='<tr class="tr_alternate"><td valign="top"><strong>'._lang_siparis_no.'</strong></td><td>'.$i.'</td</tr>';
		$out.='<tr class="tr_normal"><td valign="top"><strong>'._lang_teknikTakipTarih.'</strong></td><td>'.mysqlTarih($d['sdate']).'</td></tr>';
		$out.='<tr class="tr_normal"><td valign="top"><strong>'._lang_teknikTakipIcerik.'</strong></td><td style="text-align:left;"><strong>'.$d['title'].'</strong><hr />'.$d['body'].'</td></tr>'."\n";
		$i++;		
	}
	$out.='</table>';
	return $out;
}
?>
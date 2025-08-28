<?
if($_SESSION['lang'] && $_SESSION['lang'] != $siteDili)
	$lang = '_'.$_SESSION['lang'];

$QueryResult = unserialize(generateDefineList());
define('_lang_tr','Türkçe');
foreach($QueryResult as $d)
{	
	@define($d['key'],$d['value']);	
}
unset($QueryResult);

function generateDefineList()
{
	global $siteDili,$lang;	
	$cacheName= __FUNCTION__.$siteDili;
	$cache = cacheout($cacheName);
	if ($cache) return $cache;	
	$q = my_mysql_query("select `key`,`value` ".($_SESSION['lang'] == $siteDili?'':",`value".$lang."`")." from lang") or $q = my_mysql_query("select `key`,`value` from lang");
	while ($d = my_mysql_fetch_array($q))
	{
		if($_SESSION['lang'] != $siteDili && $d[2]) 
		{
			$d['value'] = $d[2];
			unset($d[2]);
			unset($d['value'.$lang]);
		}
		$outArray[] = $d;	
	}
	//print_r($outArray);
	$out = serialize($outArray);
	return cachein($cacheName,$out);
}

function translateArr($arr)
{
	if(!$_SESSION['lang'] || $_SESSION['lang'] == 'tr')
		return $arr;
	foreach($arr as $k=>$v)
	{
		if(!(stristr($k,'_') === false)) 
			continue;
		if($arr[$k.'_'.$_SESSION['lang']])
			$arr[$k] = $arr[$k.'_'.$_SESSION['lang']];	
	}
	return $arr;
}

if(!$_SESSION['lang'] || strtolower(trim($_SESSION['lang'])) == 'tr')
	$langPrefix = '';
else
	$langPrefix = '_'.$_SESSION['lang'];

$aylar= array('',_lang_ocak,_lang_subat,_lang_mart,_lang_nisan,_lang_mayis,_lang_haziran,_lang_temmuz,_lang_agustos,_lang_eylul,_lang_ekim,_lang_kasim,_lang_aralik);
?>
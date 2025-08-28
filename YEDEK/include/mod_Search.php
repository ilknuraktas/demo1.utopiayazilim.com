<?php
include('all.php');

exit(searchResult($_GET['s']));

function searchResult($s)
{
	global $langPrefix;
	if(strlen($s) < 3) return;

	$kat = $mar = $icerik = $urun = '';

	$q = my_mysql_query("select * from kategori where name$langPrefix like '%".$_GET['s']."%' AND active order by seq,name$langPrefix limit 0,3");
	while($d = my_mysql_fetch_array($q))
	{
		$d = translateArr($d);
		$kat.='<div class="pw-autocomplete-suggestion pw-taxonomy-suggestion">
		<span class="pw-taxonomy-suggestion-name pw-text-clamp" style="">
			<a href="'.kategoriLink($d).'">'.$d['namePath'].'</a> 
		</span>
		<span class="pw-taxonomy-suggestion-type">'._lang_form_kategori.'</span>
	</div>';
	}

	$q = my_mysql_query("select * from marka where name$langPrefix like '%".$_GET['s']."%' order by name$langPrefix limit 0,3");
	while($d = my_mysql_fetch_array($q))
	{
		$d = translateArr($d);
		$kat.='<div class="pw-autocomplete-suggestion pw-taxonomy-suggestion">
		<span class="pw-taxonomy-suggestion-name pw-text-clamp" style="">
			<a href="'.markaLink($d).'">'.$d['name'].'</a> 
		</span>
		<span class="pw-taxonomy-suggestion-type">'._lang_form_marka.'</span>
	</div>';
	}

	$q = my_mysql_query("select * from pages where title$langPrefix like '%".$_GET['s']."%' AND hide = 0 order by seq,title$langPrefix limit 0,3",1);
	while($d = my_mysql_fetch_array($q))
	{
		$d = translateArr($d);
		$icerik.='<div class="pw-autocomplete-suggestion pw-taxonomy-suggestion">
		<span class="pw-taxonomy-suggestion-name pw-text-clamp" style="">
			<a href="'.pageLink($d).'">'.$d['title'].'</a> 
		</span>
		<span class="pw-taxonomy-suggestion-type">'.lc('_lang_icerik','İçerik').'</span>
	</div>';
	}

	$q = my_mysql_query(getSearchQuery($s).' limit 0,'.(isReallyMobile()?'6':'5'));
	while($d = my_mysql_fetch_array($q))
	{
		$d = translateArr($d);
		$urun.='<div class="pw-autocomplete-suggestion pw-product-suggestion">
		<a class="block-110" title="'.str_replace('"','',$d['name']).'" href="'.urunLink($d).'"><img class="pw-product-suggestion-image" alt="'.str_replace('"','',$d['name']).'" src="include/resize.php?path=images/urunler/'.$d['resim'].'&width=200"></a>
		<div class="pw-product-suggestion-name"><a class="pw-text-clamp-2" title="'.str_replace('"','',$d['name']).'" href="'.urunLink($d).'">'.$d['name'].'</a></div>
		<div class="pw-product-suggestion-price search-price">
			<div>
				<div class="pw-product-suggestion-old-price">'.urunFiyat($d,'piyasafiyat').'</div>
				<div class="pw-product-suggestion-current-price">'.urunFiyat($d,'fiyat').'</div>
			</div>
		</div>
	</div>';
	}



	return '<div id="pw-search-autocomplete" class="pw-autocomplete-is-visible">
	<div class="pw-autocomplete-dropdown">
	  <div class="pw-autocomplete-suggestions" style="display: block">
		<div
		  class="pw-autocomplete-suggestion-section pw-autocomplete-taxonomy-section pw-autocomplete-category-section pw-autocomplete-use-history"
		>
		  '.$kat.'
		</div>
		<div
		  class="pw-autocomplete-suggestion-section pw-autocomplete-taxonomy-section pw-autocomplete-brands-section pw-autocomplete-use-history"
		>
		  '.$mar.'
		</div>
		<div
		class="pw-autocomplete-suggestion-section pw-autocomplete-taxonomy-section pw-autocomplete-brands-section pw-autocomplete-use-history"
	  >
		'.$icerik.'
	  </div>
		<div
		  class="pw-autocomplete-suggestion-section pw-autocomplete-product-section"
		>
		  <div class="pw-autocomplete-section-title">Eşlelen Ürünler</div>
		  <div
			class="pw-autocomplete-section-body pw-autocomplete-product-section-body"
		  >
			'.$urun.'
		  </div>
		</div>
	  </div>
	</div>
  </div>
  ';
}
?>
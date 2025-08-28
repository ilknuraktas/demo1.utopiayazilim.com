<?
	require('include/lib-db.php');
	require('include/conf.php');
	if($shopphp_demo)
		exit("User-agent: *\nDisallow: /");
?>User-agent: *
Disallow: /update.php
Disallow: /secure/
Disallow: /doc/
Disallow: /cache/
Disallow: /affiliate/
Disallow: /files/
Disallow: /arama
Disallow: /ac
Disallow: /*?flt=
Disallow: /*?act=
Disallow: /satinal_sp__op-adres.html
Disallow: /*?page=
Disallow: /*?searchType=
Disallow: /banner.php
Allow: /*?act=kategoriGoster&markaID=
Allow: /ac/register
Allow: /ac/siparistakip
Allow: /ac/iletisim
Allow: /ac/yeni
Allow: /ac/indirimde
Allow: /ac/cokSatanlar

Sitemap: https://<?php echo $_SERVER['HTTP_HOST'].$siteDizini ?>sitemap.xml
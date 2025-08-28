<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', '0');
$connection_type = 'mysqli';	
$baglanti = my_mysql_connect('localhost','utop4129_demov5','OyWK)%d#-oPh');
my_mysql_select_db('utop4129_demov5',$baglanti);

$siteDili = 'tr';
$serial = '7c448f309c-2208c2891fe3-027';
$shopphp_demo = 0;
$siteDizini='/';
$yonetimDizini = 'secure/';
$yonetimKoruma = 'SCRIPT'; 
// Hata Gösterimi - Yazılım Geliştirme
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
?>
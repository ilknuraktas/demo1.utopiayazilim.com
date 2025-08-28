<?php 
if(isset($_GET['srr']))
{
	error_reporting(E_ALL);
	ini_set('display_errors',1);
}

if (version_compare(phpversion(), '7.4.0', '<')) {
    //header('location:doc/kur.php?hata=PHP_SURUMU');
}

include('include/all.php');
$host = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(!count($_POST) && (@$_SERVER['HTTPS'] =='off' || !@$_SERVER['HTTPS']) &&  siteConfig('httpsAktif') == '2' )
{
	header('location:https://'.$host);
	exit();
}
SEO::setIndexHeader();
Sepet::resetOrder();
include('templates/'.$siteConfig['templateName'].'/index.php');
include('templates/'.$siteConfig['templateName'].'/temp.php');
my_mysql_close($baglanti);
if($totalQryStr)
	echo '<div class="clear">'.$totalQryStr.'</div>';
exit();
?>
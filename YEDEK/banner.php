<?
include('include/all.php');
my_mysql_query("update bannerYonetim set hit = (hit + 1) where ID='".$_GET['ID']."'");
$url = hq("select url$langPrefix from bannerYonetim where ID='".$_GET['ID']."'");
if(!$url)
    $url = hq("select url from bannerYonetim where ID='".$_GET['ID']."'");
exit(header('location:'.$url));
?>
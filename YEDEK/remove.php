<? 
include('include/all.php');
$_GET['m'] = addslashes($_GET['m']);
if (filter_var($_GET['m'], FILTER_VALIDATE_EMAIL))
{
	$ID = hq("select ID from maillist where mail = '".$_GET['m']."'");	
	my_mysql_query("update user set ebulten='0' where email like '".$_GET['m']."'");
	
	if(md5($ID) == $_GET['c'])
	{
		my_mysql_query("delete from maillist where mail='".$_GET['m']."'");	
		exit('E-Posta adresiniz <strong>('.$_GET['m'].')</strong> silindi.');
	}
}
?>
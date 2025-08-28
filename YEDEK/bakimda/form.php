<?php
include('../include/all.php');		

$_POST['email'] = addslashes($_POST['email']);
if( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) )
{
	if(mysql_num_rows(mysql_query("select ID from maillist where mail='".$_POST['email']."'")))
		echo _lang_formError_emailEmail;
	else
	{
		mysql_query("insert into maillist values('','".$_POST['email']."','".$_SERVER['REMOTE_ADDR']."',now())") or exit(mysql_error()); 
		echo _lang_formMailOK;
	}
}
else
{
   echo _lang_formError_emailError.' '.$_POST['email'];	
}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
<META http-equiv="expires" CONTENT="0">
<META http-equiv="cache-control" CONTENT="no-cache">
<META http-equiv="Pragma" CONTENT="no-cache">
<TITLE>
�ye ��yeri Sayfas�
</TITLE>
</HEAD>
<BODY>
<TABLE border="0" align="center" cellpadding="0" cellspacing="0">
  <TBODY>
		<TR>
			<TD width="40" height="39"></TD>
			<TD height="39" width="641" bgcolor="#d4d0c8"><B>�ye ��yeri Sayfas�na D�n�len Parametreler :</B></TD>
		</TR>
		<TR>
			<TD width="40" height="28"></TD>
			<TD height="28" width="641">
			<br>
			<?php
            foreach($HTTP_POST_VARS as $formfield => $value) 
            { 
                echo("<b>".$formfield."</b> : ".$value);
                echo("<br><br>");   
            } 
            ?>
            </TD>
		</TR>
	</TBODY>
</TABLE>
<p align="center"><a href="merchant.html">merchant.html</a></p>
</BODY>
</HTML>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{%title%}</title>
   <style type="text/css" media="screen">
      body {
         background-color: #fff;
      }

      a img {
         border: none;
      }

      table.bg1 {
         background-color: #fff;
		 margin-top:20px;
		 
      }

      table.bg2 {
         background-color: #ffffff;
		 border:10px solid #f7f7f7;
       border-radius: 10px;
      }

      td.permission {
         background-color: #f7f7f7;
         padding: 10px 20px 10px 20px;
      }

      td.permission p {
         font-family: Arial;
         font-size: 11px;
         font-weight: normal;
         color: #333333;
         margin: 0;
         padding: 0;
      }

      td.permission p a {
         font-family: Arial;
         font-size: 11px;
         font-weight: normal;
         color: #333333;
      }

      td.body {
         /* padding: 0 20px 20px 20px; */
         background-color: #ffffff;
      }

      td.sidebar h3 {
         font-family: Arial;
         font-size: 15px;
         font-weight: bold;
         color: #333333;
         margin: 0;
         padding: 0;
      }

      td.sidebar ul {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 6px 0 14px 24px;
         padding: 0;
      }

      td.sidebar ul li a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
      }

      td.sidebar h4 {
         font-family: Arial;
         font-size: 13px;
         font-weight: bold;
         color: #680606;
         margin: 6px 0 0 0;
         padding: 0;
      }

      td.sidebar h4 a {
         font-family: Arial;
         font-size: 13px;
         font-weight: bold;
         color: #680606;
         text-decoration: none;
      }

      td.sidebar p,div,td {
         font-family: Arial;
         font-size: 12px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 10px 0;
         padding: 0;
      }
      div,td {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 10px 0;
         padding: 0;
      }

      td.sidebar p a {
         font-family: Arial;
         font-size: 12px;
         font-weight: normal;
         color: #680606;
         text-decoration: none;
      }

      td.buttons {
        padding: 20px 0 0 0; 
      }

      td.mainbar h2 {
         font-family: Arial;
         font-size: 16px;
         font-weight: bold;
         color: #680606;
         margin: 0;
         padding: 0;
      }

      td.mainbar h2 a {
         font-family: Arial;
         font-size: 16px;
         font-weight: bold;
         color: #680606;
         text-decoration: none;
         margin: 0;
         padding: 0;
      }

      td.mainbar img.hr {
         margin: 0;
         padding: 0 0 10px 0;
      }

      td.mainbar p,td.mainbar td,td.mainbar th {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 14px 0;
         padding: 0;
      }
	  
	  .mainbar td,.mainbar div {
	     font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 14px 0;
         padding: 0;
	  }

	  td.mainbar th { font-weight:bold; }
      td.mainbar p a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
      }

      td.mainbar p.more a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
         text-decoration: none;
      }

      td.mainbar ul {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 14px 24px;
         padding: 0;
      }

      td.mainbar ul li a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
      }

      td.footer {
         padding: 0 20px 0 20px;
         background-repeat: no-repeat;
         background-position: top center;
         background-color: rgba(164, 208, 217, 1);
         height: 61px;
         vertical-align: middle;
		 color: #ffffff;
		 font-weight:bold;
       border-radius: 10px;
       border-top-left-radius: 0;
       border-top-right-radius: 0;

      }

      td.footer p,td.footer a {
         font-family: Arial;
         font-size: 11px;
         font-weight: bold;
         color: #ffffff;
         line-height: 16px;
         margin: 0;
         padding: 0;
      }
	  .emaillogo { display:block; margin:20px;  width:150px; }
     .header img { width:150px; }
   </style>
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bg1">
   <tr>
      <td align="center">
         
         <table width="600" border="0" cellspacing="0" cellpadding="0" class="bg2">
            <tr>
               <td class="header" align="left">&nbsp;
                	{%logo%}  
               </td>
            </tr>
            <tr>
               <td valign="top" class="body">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td valign="top" class="mainbar" style="padding:20px; padding-top:0;" align="left">
                           <div style="clear:both; height:1px; background-color:#ccc"></div>
                           <h2><a href="{%siteAdresiFull%}">{%title%}</a></h2>
						   <br />
                           <div style="clear:both; height:1px; background-color:#ccc"></div>
                           <br />
						   <p>{%body%}</p>
                        </td>
                     </tr>
                  </table>
                  {%banner%}
               </td>
            </tr>
            <tr>
               <td valign="middle" align="left" class="footer" height="61">
                  {%footer%}
               </td>
            </tr>
			<tr>
               <td class="permission" align="center">
                  <p>Bu e-posta'yı {%mailFrom%} - {%siteAdresi%} sitesinden bilgilendirme amaçlı almış bulunuyorsunuz.<br />
 				   E-Posta'yı düzgün göremiyorsanız <a href="{%siteAdresiFull%}/eposta.php?code={%code%}">buraya tıklayın</a>.</p>
               </td>
            </tr>
         </table>
         
      </td>
   </tr>
</table>

</body>
</html>
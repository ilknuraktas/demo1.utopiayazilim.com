<style>
.urunDetay { clear:both; margin-bottom:12px; }
.urunDetay a { color:#333; text-decoration:none; }
.urunDetay .incele { float:right; }
.button {
  background-color: #4CAF50;; 
  border: none;
  color: white;
  padding: 10px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 13px;
  margin-top:15px;
  border-radius: 5px;
  font-weight:bold;
}
div.hr { height:1px; background-color: #ccc; margin-top:10px; margin-bottom:10px; clear:both;}
</style>
<div class="urunDetay">
    <h1><a href="{%siteAdresiFull%}/page.php?act=urunDetay&urunID={%DB_ID%}" target="_blank">{%DB_NAME%}</a></h1>
    <table>
        <tr><td valign="top">
                <a href="{%siteAdresiFull%}/page.php?act=urunDetay&urunID={%DB_ID%}" target="_blank"><img src="{%siteAdresiFull%}include/resize.php?path=images/urunler/{%DB_RESIM%}&width=200" style="margin-right:10px;" /></a>
            </td>
            <td valign="top"> 
             	
                <a href="{%siteAdresiFull%}/page.php?act=urunDetay&urunID={%DB_ID%}" target="_blank">{%DB_ONDETAY%}</a>
                <div class="hr"></div>
                <div class="incele">
                	<a href="{%siteAdresiFull%}page.php?act=urunYorum&siparisID={%DB_RANDSTR%}&urunID={%DB_ID%}" target="_blank"><input type="button" class="button" value="YORUM EKLE" /></a>
                </div>      
            </td>
         </tr>
    </table>
</div>
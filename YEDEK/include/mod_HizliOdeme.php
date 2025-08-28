<?php
/*
Şablon lib.php'e eklenecek.
function myodeme()
{
	include('include/mod_HizliOdeme.php');
	return hizliodeme();	
}

page.php'e eklenece.

			switch($_GET['op']) {
				case "sil":
				case "bosalt":
				case "guncelle":
				case "adres":
				// Page.php'e sadece aşağıdaki satır eklenecek.
				redirect(slink('odeme'));
				
*/
function hotSecim()
{
	$q = my_mysql_query("select * from banka where active = 1 AND paymentModulURL != '' AND odemeLogo != '' order by seq");
	$i=1;	
	while ($d=my_mysql_fetch_array($q)) 
	{
		$out.='<a href="javascript:;" class="imgRadio" onclick="$(\'input[name=data_odemeTipi]\').val(\''.$d['ID'].'\')"><input type="radio" name="data_HizliodemeTipiSecim" class="zorunluradio" value="'.$d['ID'].'" /> <img src="images/banka/'.$d['odemeLogo'].'" alt="" /></a>';
	}
	return $out;
}

function hotSehir()
{
	$cityQuery = my_mysql_query('select * from iller where cID=0 OR cID=1 order by name');
	while ($cityRow = my_mysql_fetch_array($cityQuery)) {
		$out.='<option value="'.$cityRow['plakaID'].'" '.($cityRow['plakaID']==$data[$k[1]]?'selected':'').'>'.$cityRow['name'].'</option>'."\n";
	}
	return $out;
}

function hotSepet()
{
	if($_POST['data_promotionCode'])
	{
		mySiparisAdresSubmit();
	}
	
	$q = my_mysql_query("select * from sepet where randStr like '".$_SESSION['randStr']."'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.=' <tr>
                <td rowspan="2"><img src="include/resize.php?path=images/urunler/'.hq("select resim from urun where ID='".$d['urunID']."'").'&width=300" style="width:95px;" alt="" /></td>
                <td>Özellik</td>
                <td>Adet</td>
                <td>Birim Fiyat</td>
                <td>Toplam</td>
              </tr>
			   <tr>
                <td>'.$d['ozellik1'].'</td>
                <td>'.$d['adet'].'</td>
                <td>'.$d['ytlFiyat'].' TL</td>
                <td>'.($d['ytlFiyat'] * $d['adet']).' TL</td>
              </tr>';
	}
	return $out;
}

function hotPromosyon()
{
	$promotionCode = ($_POST['data_promotionCode'] ? $_POST['data_promotionCode'] : hq("select promotionCode from siparis where randStr = '".$_SESSION['randStr']."'"));
	if($promotionCode)
	{
		$promosyonStr = my_money_format('%i',basketInfo('Promosyon',$_SESSION['randStr']));		
		return '              <tr>
                <td class="p_alignRight">Promosyon ('.$promotionCode.'):</td>
                <td style="width: 30%;">-'.my_money_format('%i',(float)$promosyonStr).' TL</td>
              </tr>';
	}
}

function mySiparisAdresSubmit() {
	global $siteConfig;
	telFix('evtel');
	telFix('istel');

	if (!$_SESSION['userID'] && siteConfig('autoRegister') && !hq("select ID from user where (email like '" . addslashes($_POST['data_email']) . "' OR username like '" . addslashes($_POST['data_email']) . "') AND username != '' AND email != ''")) {
        registerSubmit();
	}
	
	if ($_SESSION['affID'])
		$_POST['data_affID'] = $_SESSION['affID'];
	if (!hq("select ID from siparis where randStr = '".$_SESSION['randStr']."' limit 0,1")) {			 
		$_SESSION['siparisID']=insertToDb('siparis');
		@my_mysql_query("update siparis set randStr = '".$_SESSION['randStr']."',userID='".$_SESSION['userID']."' where ID='".$_SESSION['siparisID']."'");
	}
	else updateDb('siparis');
	$q = my_mysql_query("select * from siparis where ID = '".$_SESSION['siparisID']."' limit 0,1");
	$d = my_mysql_fetch_array($q);		
	$hiddenInfo['act'] = "satinal";
	$hiddenInfo['op'] = "odeme";
	$hiddenInfo['paytype'] = "0";	
	$link = (siteConfig('seoURL') ? $_GET['act'].'_sp__op-'.$_GET['op'].'.html':'page.php?act='.$_GET['act'].'&op='.$_GET['op']);
	$action = (siteConfig('seoURL') ? 'satinal_sp__op-odeme.html':'page.php');
	$out = viewForm(getSiparisForm(),$d,$link,$hiddenInfo,$action);
	$out.= "<script language='javascript'>document.getElementById('paytype').value = selectedPayType;</script>";
	return $out;
}

function hizliodeme()
{
	if ($_POST['data_lastname']) $siparisAdresSubmit = mySiparisAdresSubmit();
	$redirectOdemeTipi = $_POST['data_odemeTipi'];
	if ($redirectOdemeTipi)
	{
		redirect('page.php?act=satinal&op=odeme&paytype='.$redirectOdemeTipi);	
	}
	//echo debugArray($_POST);
	$q = my_mysql_query("select * from user where ID='".$_SESSION['userID']."'");
	$d = my_mysql_fetch_array($d);
	$out ='
  <link rel="stylesheet" type="text/css" href="include/hizliodeme/css/style.css" />





  <div class="payment">
  <div class="p_left">
        <h3>Lütfen Kişisel Bilgilerinizi Eksiksiz Doldurun</h3>
		
				          <form method="post" id="hizliodeme">

          <div class="p_formElem">
            <label>Adınız:</label>
            <input type="text" name="data_name" class="p_inputText zorunlu" value="'.$d['name'].'" />
          </div><!-- /.p_formElem -->
          
          <div class="p_formElem">
            <label>Soyadınız:</label>
            <input type="text" name="data_lastname" class="p_inputText zorunlu" value="'.$d['lastname'].'" />
          </div><!-- /.p_formElem -->

          <div class="p_formElem">
            <label>E-mail Adresiniz:</label>
            <input type="text" name="data_email" class="p_inputText zorunlu" value="'.$d['email'].'" />
          </div><!-- /.p_formElem -->
          
          <div class="p_formElem">
            <label>Telefon Numaranız:</label>
            <input type="text" name="data_ceptel" class="p_inputText zorunlu" value="'.$d['ceptel'].'" />
          </div><!-- /.p_formElem -->
          
          <div class="p_formElem">
            <label>Şehir</label>
            <select class="p_select zorunlu" id="gf_city" name="data_city">
			<option>Lütfen Seçin</option>
              '.hotSehir().'
            </select>
          </div><!-- /.p_formElem -->

          <div class="p_formElem">
            <label>İlçe:</label>
            <select class="p_select zorunlu" id="gf_semt" name="data_semt">

            </select>
          </div><!-- /.p_formElem -->
          
          
          <div class="p_formElem p_wide">
            <label>Adresiniz:</label>
            <textarea class="p_textarea zorunlu" name="data_address">'.$d['address'].'</textarea>
          </div><!-- /.p_formElem -->
        

		  
          <div class="p_formElem p_wide">
            <input type="checkbox" name="test" class="zorunlucheck" value="OK" checked/>
            <a href="page.php?act=sozlesme&sn='.$_SESSION['randStr'].'" target="_blank">Satış Sözleşmesi\'ni okudum, onaylıyorum.
          </div><!-- /.p_formElem -->
		  
		            <div class="p_formElem p_wide">
            <h3>Ödeme Şekliniz</h3>
            <div class="p_radios">
              '.hotSecim().'
            </div>
          </div><!-- /.p_formElem -->
		  <div stlye="clear:both">&nbsp;</div>
          
          <input type="submit" class="p_submit" value="SİPARİŞİ GÖNDER" />
		  <input type="hidden" name="data_odemeTipi" value="" />
        </form>
      </div><!-- /.p_left -->

      <div class="p_right">
        <div class="p_basket">
          <h3>Sepet Toplamı</h3>
          <div class="p_basketInner">
            <table class="p_table">
              '.hotSepet().'
            </table>
            <hr />
            <table class="p_total">
              <tr>
                <td class="p_alignRight">Ara Toplam:</td>
                <td style="width: 30%;">'.basketInfo('toplamKDVDahil',$randStr).' TL</td>
              </tr>
			  '.hotPromosyon().'
              <tr>
                <td class="p_alignRight">Kargo:</td>
                <td style="width: 30%;">'.basketInfo('Kargo',$randStr).' TL</td>
              </tr>
              <tr>
                <td class="p_alignRight">Genel Toplam:</td>
                <td style="width: 30%;">'.basketInfo('ToplamKargoDahil',$randStr).' TL</td>
              </tr>
            </table>
          </div><!-- /.p_basketInner -->
        </div><!-- /.p_basket -->
        <div class="p_discount" style="visibility:hidden;">
          <h4>İNDİRİM KUPONUM VAR</h4>
          <form method="post">
            <input type="text" class="p_inputText" value="'.hq("select promotionCode from siparis where randStr like '".$_SESSION['randStr']."'").'" name="data_promotionCode" />
            <input type="submit"  class="p_submit" value="İNDİRİMİ UYGULA" />
          </form>
        </div><!-- /.p_discount -->

        <div class="p_safe">
          <img src="include/hizliodeme/img/safe1.jpg" alt="" />
        </div><!-- /.p_safe -->
      </div><!-- /.p_right -->
	   </div><!-- /.p_right -->
	   <div style="clear:both;"></div>
	   
	   <script>
	   	$("#hizliodeme").submit(
			function()
			{
				var stop =false;
				$("#hizliodeme .zorunlu").each(
					function()
					{
						if(!stop && !$(this).val())
						{
							alert("Lütfen tüm alanları eksiksiz doldurun.");
							stop = true;	
						}
					}
				);
				if(!stop && !$(".zorunlucheck").is(":checked"))
						{
							alert("Lütfen kurallar bölümünü onaylayın.");
							stop = true;	
						}
						
					if(!stop && !$("input[name=data_odemeTipi]").val())
						{
							alert("Lütfen ödeme tipini seçin.");
							stop = true;	
						}
						
						
				return !stop;	
			}
		);
	   </script>
	   
	     <script type="text/javascript">




      if( parseInt($(".payment").css("width")) < 700) {
        $(".p_left").css("width","100%");
        $(".p_right").css("width","100%");
      }

      $(".imgRadio").click(function(){
        $(".imgRadio input").removeAttr("checked");
        $(this).children("input").attr("checked","checked");
        $(".imgRadio").removeClass("p_selected");
        $(this).addClass("p_selected");
      });
	  $("input[name=data_HizliodemeTipiSecim]").click();
  </script>
	   ';
	return $out;
}
?>
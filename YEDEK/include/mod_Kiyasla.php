<?
session_start();
require_once('conf.php');
require_once('sec.php');
require_once('start.php');
switch($_GET['mAct'])
{
	case "add":
		$modTotal = modTotal();
		if ( $modTotal > 2) exit("err_total");
		for($i=0;$i<=10;$i++) {
			if (!$_COOKIE['urunKarsilastirmaList_'.$i])
				$_COOKIE['urunKarsilastirmaList_'.$i] = $_SESSION["urunKarsilastirmaList_".$i];
			if (!($_COOKIE['urunKarsilastirmaList_'.$i] > 0)) {
				setcookie("urunKarsilastirmaList_".$i, $_GET['urunID']);
				$_SESSION["urunKarsilastirmaList_".$i] = $_GET['urunID'];
				break;
			}
		} 
		$modTotal = modTotal();
		$mOut = '('.$modTotal.')';	
	break;
	case "remove":
		for($i=0;$i<=10;$i++) {
			if (!$_COOKIE['urunKarsilastirmaList_'.$i])
				$_COOKIE['urunKarsilastirmaList_'.$i] = $_SESSION["urunKarsilastirmaList_".$i];
			if ($_COOKIE['urunKarsilastirmaList_'.$i] == $_GET['urunID']) {
				setcookie("urunKarsilastirmaList_".$i, 0);
				$_SESSION["urunKarsilastirmaList_".$i] = 0;
			break;
			}
		} 
		$modTotal = modTotal();
		$mOut = '('.$modTotal.')';	
	break;
}
function modTotal()
{
	$total = 0;
		for($i=0;$i<=10;$i++) {
			if (!$_COOKIE['urunKarsilastirmaList_'.$i])
				$_COOKIE['urunKarsilastirmaList_'.$i] = $_SESSION["urunKarsilastirmaList_".$i];
			if ($_COOKIE['urunKarsilastirmaList_'.$i] > 0) {
				$total++;
			}
		}
		return ((int)$total); 	
}

//require_once($_SERVER['DOCUMENT_ROOT'].'/'.$siteDizini.'/include/lib.php');
	/* urunListShow.php'e eklenecek kod
	<div class="modKiyasla">
		<input type="checkbox" value="{%DB_ID%}" class="modKiyas_{%DB_ID%}"> <a href="#" onclick="javascript:pencereAc('compare.php',800,400); return false;">Kıyasla</a>
	</div>
	 */
if ($_GET['mAct']) 
	exit($mOut);
if (@$_GET['KarsilastirmaListeTemizle']) {
}
?>
<script>
	$('.modKiyasla input').click(
		function() { 
			var act = ''; 
			if($(this).attr('checked')) 
			{ 
				act = 'add';  
			} 
			else 
			{ 
				act = 'remove';
			} 
			var obj = this;
			$.ajax({ 
				url: 'include/mod_Kiyasla.php?mAct='+act+'&urunID='+$(this).val(), 
				cache: false, 
				success: function(data) {
					data = data.replace(/^\s+|\s+$/g,"");
					//data = data.repkace(/total_/i,'');
					//alert(data);
					if (data == 'err_total')
					{
						alert("Azami ürün kıyaslama sayısı 3'tür.");	
						$(obj).attr('checked',false);
						$(obj).removeAttr('checked');
					}
					else
					{
						$('.modKiyasla a').text('Kıyasla');
						if (act == 'add') 
							$(obj).parent().find('a:first').text('Kıyasla '+data)	;
					}
				}	 
			}); 
		
		
		}
	);
	<?
		for($i=0;$i<=10;$i++) {
			if (!$_COOKIE['urunKarsilastirmaList_'.$i])
				$_COOKIE['urunKarsilastirmaList_'.$i] = $_SESSION["urunKarsilastirmaList_".$i];
			if ($_COOKIE['urunKarsilastirmaList_'.$i] > 0) {
				echo "$('.modKiyas_".$_COOKIE['urunKarsilastirmaList_'.$i]."').attr('checked','checked');";
			}
		//	else echo $i.' : '.$_COOKIE['urunKarsilastirmaList_'.$i].' : boş.<br>';
		}
	?>
</script>
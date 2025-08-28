<?
function modShowItem($urunID)
{

	$out = '<!-- Style sheets -->
    <link rel="stylesheet" type="text/css" href="include/3rdparty/ProductDesigner/css/main.css">

    <!-- Google Webfonts -->
    <link href=\'//fonts.googleapis.com/css?family=Gorditas\' rel=\'stylesheet\' type=\'text/css\'>

    <!-- The CSS for the plugin itself - required -->
	<link rel="stylesheet" type="text/css" href="include/3rdparty/ProductDesigner/css/FancyProductDesigner-all.min.css" />
	<!-- Optional - only when you would like to use custom fonts - optional -->
	<link rel="stylesheet" type="text/css" href="include/3rdparty/ProductDesigner/css/jquery.fancyProductDesigner-fonts.css" />

    <!-- Include js files -->

	<script src="include/3rdparty/ProductDesigner/js/jquery-ui.min.js" type="text/javascript"></script>

	<!-- HTML5 canvas library - required -->
	<script src="include/3rdparty/ProductDesigner/js/fabric.min.js" type="text/javascript"></script>
	<!-- The plugin itself - required -->
    <script src="include/3rdparty/ProductDesigner/js/FancyProductDesigner-all.js" type="text/javascript"></script>

    <script type="text/javascript">
	window.addEventListener("load", (event) => { 
	    jQuery(document).ready(function(){

	    	var $yourDesigner = $(\'#clothing-designer\'),
	    		pluginOpts = {
		    		stageWidth: 1200,
		    		editorMode: true,
					hexNames: {"000000":"Black","ffffff":"White","2ECC71":"Emerald","e67e22":"Carrot","d35400":"Pumpkin","f39c12":"Orange","e74c3c":"Alizarin","c0392b":"Pomegranate","2c3e50":"MidnightBlue","7f8c8d":"Asbestos"},
		    		fonts: [\'Arial\', \'Fearless\', \'Helvetica\', \'Times New Roman\', \'Verdana\', \'Geneva\', \'Gorditas\'],
		    		customTextParameters: {
			    		colors: true,
			    		removable: true,
			    		resizable: false,
			    		draggable: true,
			    		rotatable: true,
			    		autoCenter: true,
			    		boundingBox: "Base"
			    	},
		    		customImageParameters: {
						autoCenter: true,
			    		draggable: false,
			    		removable: true,
			    		resizable: false,
			    		rotatable: true,
			    		colors: \'#000000\',			    		
			    		boundingBox: "Base"
			    	},
			    	actions:  {
						\'top\': [\'download\',\'print\', \'snap\', \'preview-lightbox\'],
						\'right\': [\'magnify-glass\', \'zoom\', \'reset-product\', \'qr-code\', \'ruler\'],
						\'bottom\': [\'undo\',\'redo\'],
						\'left\': [\'manage-layers\',\'save\',\'load\']
					}
	    		},
	    		yourDesigner = new FancyProductDesigner($yourDesigner, pluginOpts);

	    	//print button
			$(\'#print-button\').click(function(){
				yourDesigner.print();
				return false;
			});

			//create an image
			$(\'#image-button\').click(function(){
				var image = yourDesigner.createImage();
				return false;
			});

			//checkout button with getProduct()
			$(\'#checkout-button\').click(function(){
				var product = yourDesigner.getProduct();
				console.log(product);
				
				
				if( ($(\'#urunSecim_ozellik1detay\').length) && !$(\'#urunSecim_ozellik1detay\').val()) 
				{ 
					sepetEkleKontrolValue= false; alert(\'Lütfen ürün özellik seçimini yapın.\'); $(\'#urunSecim_ozellik1detay\').focus();
					return false; 
				}
				
				if( ($(\'#urunSecim_ozellik2detay\').length) && !$(\'#urunSecim_ozellik2detay\').val()) 
				{ 
					sepetEkleKontrolValue= false; alert(\'Lütfen ürün özellik seçimini yapın.\'); $(\'#urunSecim_ozellik2detay\').focus();
					return false; 
				}
					
				
				var kayit = yourDesigner.getProduct();
				var kayitSTR = (JSON.stringify(kayit));
				
				var var1 = \'\';
				var var2 = \'\';
				if($(\'#urunSecim_ozellik1detay\').length && $(\'#urunSecim_ozellik1detay\').val())
					var1 = $(\'#urunSecim_ozellik1detay\').val();
				if($(\'#urunSecim_ozellik2detay\').length && $(\'#urunSecim_ozellik2detay\').val())
					var2 = $(\'#urunSecim_ozellik2detay\').val();
				var queryPOST = \'pdAppTshirtPOST=\'+encodeURIComponent(kayitSTR)+\'&amount=\'+$(\'#thsirt-price\').text()+\'&urunID=\'+' . $_GET['urunID'] . ' + \'&var1=\'+var1+\'&var2=\'+var2;	
				$.ajax({
				  url: \'page.php?act=urunDetay\',
				  type: \'POST\',
				  data: queryPOST,
				  success: function(data) 
						   { 
							   if(data == \'OK\')
								window.location.href=\'page.php?act=sepet\';
							   else alert(data);
						   }
				});
				
				return false;
			});

			//event handler when the price is changing
			$yourDesigner.on(\'priceChange\', function(evt, price, currentPrice) {
				$(\'#thsirt-price\').text(currentPrice);
			});

			//save image on webserver
			$(\'#save-image-php\').click(function() {

				yourDesigner.getProductDataURL(function(dataURL) {
					$.post( "include/3rdparty/ProductDesigner/php/save_image.php", { base64_image: dataURL} );
				});

			});

			//send image via mail
			$(\'#send-image-mail-php\').click(function() {

				yourDesigner.getProductDataURL(function(dataURL) {
					$.post( "include/3rdparty/ProductDesigner/php/send_image_via_mail.php", { base64_image: dataURL} );
				});

			});
			' . ($_GET['autoLoadID'] ? pdAutoLoadJS((int)$_GET['randStr'], (int)$_GET['autoLoadID']) : '') . '

	    });
	});
    </script>
    </head>

    <body>
    	<div id="main-container">
          	<div id="clothing-designer" class="fpd-container fpd-topbar fpd-tabs fpd-tabs-side fpd-top-actions-centered fpd-bottom-actions-centered fpd-views-inside-left">
          		' . pdProductList() . '
		  		<div class="fpd-design">
		  			' . pdCategories() . '
		  		</div>
		  	</div>
			<div id="cloting-select">' . generateItemOptions(urun(), 1, '', '') . '' . generateItemOptions(urun(), 2, '', '') . '</div>
		  	<br />

		  	<div class="fpd-clearfix" style="margin-top: 30px;">
			  	<div class="api-buttons fpd-container fpd-left">
				  	<a href="#" id="print-button" class="fpd-btn">Yazdır</a>
				  	<a href="#" id="image-button" class="fpd-btn">Resim Olarak Göster</a>
				  	<a href="#" id="checkout-button" class="fpd-btn">Sepete Ekle</a>
					<a href="#" id="recreation-button" class="fpd-btn">Ürünü Yenile</a>
					<a href="https://api.whatsapp.com/send?phone=9' . str_replace(array(' '), array(''), siteConfig('whatsappNumber')) . '&text=Sipariş vermek istiyorum" targe="_blank" id="recreation-button" class="fpd-btn">Whatsapp İle Gönder</a>
			  	</div>
			  	<div class="fpd-right">
				  	<span class="price badge badge-inverse"><span id="thsirt-price"></span> ' . fiyatBirim('TL') . '</span>
			  	</div>
		  	</div>
    	</div>';
	return $out;
}

if ($_POST['pdAppTshirtPOST']) {
	$data = (stripslashes(html_entity_decode($_POST['pdAppTshirtPOST'])));
	$ozellik1 = ($_POST['var1']);
	$ozellik2 = ($_POST['var2']);

	$urunID = $_POST['urunID'];

	$urunName = 'Özel Baskı Tasarımı';
	$fiyat = $ytlFiyat = fixFiyat($_POST['amount'], $_SESSION['userID'], 0);
	if ((float)$fiyat < (float)fixFiyat(hq("select fiyat from urun where ID='$urunID'"), $_SESSION['userID'], 0))
		exit('ERR');
	$fiyatBirim = 'TL';

	$adet = 1;

	$query = "INSERT INTO `sepet` (`ID`, `urunID`, `urunName`, `relUrunID`, `userID`, `ytlFiyat`, `fiyat`, `fiyatBirim`, `ozellik1`, `ozellik2`, `ozellik3`, `ozellik4`, `ozellik5`, `adet`, `serialNo`, `durum`, `prefix`,`url`, `randStr`, `tarih`) VALUES (NULL, '$urunID', '$urunName', 0, 0, '$ytlFiyat', '$fiyat', '$fiyatBirim', '$ozellik1', '$ozellik2', '$ozellik3', '', '" . addslashes($data) . "', '$adet', '', '0', '__apptshirt','', '" . $_SESSION['randStr'] . "', now())";
	my_mysql_query($query);
	$id = my_mysql_insert_id();
	my_mysql_query("update sepet set url = '" . $siteDizini . "page.php?act=urunDetay&urunID=$urunID&randStr=" . $_SESSION['randStr'] . "&autoLoadID=" . my_mysql_insert_id() . "' where ID='" . $id . "'");
	$sepet = new Sepet($_SESSION['randStr']);
	$sepet->sepetAdetGuncelle($id, $adet);
	exit('OK');
}

/*
<div class="fpd-product" title="Shirt Front" data-thumbnail="include/3rdparty/ProductDesigner/images/yellow_shirt/front/preview.png">
	    			<img src="include/3rdparty/ProductDesigner/images/yellow_shirt/front/base.png" title="Base" data-parameters=\'{"left": 325, "top": 329, "colors": "#d59211", "price": 20}\' />
			  		<img src="include/3rdparty/ProductDesigner/images/yellow_shirt/front/shadows.png" title="Shadow" data-parameters=\'{"left": 325, "top": 329}\' />
			  		<img src="include/3rdparty/ProductDesigner/images/yellow_shirt/front/body.png" title="Hightlights" data-parameters=\'{"left": 322, "top": 137}\' />
			  		<span title="Any Text" data-parameters=\'{"boundingBox": "Base", "left": 326, "top": 232, "zChangeable": true, "removable": true, "draggable": true, "rotatable": true, "resizable": true, "colors": "#000000"}\' >Default Text</span>
			  		<div class="fpd-product" title="Shirt Back" data-thumbnail="include/3rdparty/ProductDesigner/images/yellow_shirt/back/preview.png">
		    			<img src="include/3rdparty/ProductDesigner/images/yellow_shirt/back/base.png" title="Base" data-parameters=\'{"left": 317, "top": 329, "colors": "Base", "price": 20}\' />
		    			<img src="include/3rdparty/ProductDesigner/images/yellow_shirt/back/body.png" title="Hightlights" data-parameters=\'{"left": 333, "top": 119}\' />
				  		<img src="include/3rdparty/ProductDesigner/images/yellow_shirt/back/shadows.png" title="Shadow" data-parameters=\'{"left": 318, "top": 329}\' />
					</div>
				</div>
 */

function pdAutoLoadJS($randStr, $lineID)
{
	if (!$lineID || !$randStr)
		return;
	$data5 = hq("select ozellik5 from sepet where ID='$lineID' AND randStr = '$randStr'");
	$data1 = hq("select ozellik1 from sepet where ID='$lineID' AND randStr = '$randStr'");
	$data2 = hq("select ozellik2 from sepet where ID='$lineID' AND randStr = '$randStr'");
	if ($data1)
		$out .= '$(\'#urunSecim_ozellik1detay\').val(\'' . addslashes($data1) . '\');';
	if ($data2)
		$out .= '$(\'#urunSecim_ozellik2detay\').val(\'' . addslashes($data2) . '\');';
	if ($out)
		$out = '$(document).ready(function() { ' . $out . '});';
	return "yourDesigner.addProduct(JSON.parse(\"" . addslashes($data5) . "\")); $out";
}

function pdDirectoryNameFix($str)
{
	$str = str_replace(array('_', 's-', 'S-', 'u-', 'U-', 'o-', 'O-', 'c-', 'C-', 'I-', 'i-'), array(' ', 'ş', 'Ş', 'ü', 'Ü', 'ö', 'Ö', 'ç', 'Ç', 'İ', 'ı'), $str);
	return ucfirst($str);
}

function pdCategories()
{
	$cacheName = __FUNCTION__;
	$cache = cacheout($cacheName);
	// if ($cache) return $cache;
	$removeArray = array('.', '..');
	if ($objDir = scandir('include/3rdparty/ProductDesigner/images/designs/')) {
		foreach ($objDir as $item) {
			if (is_dir('include/3rdparty/ProductDesigner/images/designs/' . $item) && !in_array($item, $removeArray)) {
				$out .= '<div class="fpd-category" title="' . pdDirectoryNameFix($item) . '">' . pdCategoryList($item) . '</div>';
			}
		}
		closedir($objDir);
	}
	return cachein($cacheName, $out);
}

function pdCategoryList($item)
{
	$dirArray = scandir('include/3rdparty/ProductDesigner/images/designs/' . $item);
	if (is_dir('include/3rdparty/ProductDesigner/images/designs/' . $item . '/')) {
		$fileArray = scandir('include/3rdparty/ProductDesigner/images/designs/' . $item . '/');
		foreach ($fileArray as $f) {
			if ($f == '.' || $f == '..') continue;
			if (('include/3rdparty/ProductDesigner/images/designs/' . $item . '/' . $f)) {
				list($name) = explode('.', $f);
				list($fname, $color) = explode('--', $name);
				$fname = ucfirst(str_replace('-', ' ', $fname));
				$colorJSON = ($color ? '"colors":"#' . $color . '",' : '');
				$out .= '<img src="include/3rdparty/ProductDesigner/images/designs/' . $item . '/' . $f . '" title="' . $fname . '" data-parameters=\'{"zChangeable": true, "left": 0, "top": 200, "colors": "#000", "removable": true, "draggable": true, "rotatable": true, "resizable": false, "price": ' . (float)siteConfig('modPD_motif_price') . ', "boundingBox": "Base", "scale":0.50, "autoCenter": true}\' />' . "\n";
			}
		}
	}
	return $out;
}

function pdProductList()
{
	$query = "select * from urun where ID='" . $_GET['urunID'] . "'";
	$q = my_mysql_query($query);
	while ($d = my_mysql_fetch_array($q)) {
		$out .= '<div class="fpd-product" title="' . $d['name'] . ' Ön--' . $d['ID'] . '" data-thumbnail="include/resize.php?path=images/urunler/' . $d['resim'] . '&width=100">
					<img width="400" src="images/urunler/' . $d['resim'] . '" title="Base" data-parameters=\'{"left": 355, "top": 329, "price": ' . fixFiyat($d['fiyat'], 0, $d['ID']) . '}\' />';
		for ($i = 2; $i <= 5; $i++) {
			if ($d['resim' . $i]) {
				$out .= '<!-- This is another view -->
					<div class="fpd-product" title="' . $d['name'] . ' Yön ' . $i . '--' . $d['ID'] . '" data-thumbnail="include/resize.php?path=images/urunler/' . $d['resim' . $i] . '&width=50">
						<img width="400" src="images/urunler/' . $d['resim' . $i] . '" title="Base" data-parameters=\'{"left": 355, "top": 329}\' />
					</div>';
			}
		}
		$out .= '</div>';
	}

	return $out;
}
?>
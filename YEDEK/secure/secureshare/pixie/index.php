<?php
require_once('../../include/protect-me.php');
if($_SESSION['shopphp_demo'] && $_POST['data'])
{
	exit('Demo sürümde resim kaydetme pasiftir.');
}
if($_POST['data'])
{
	list($url,$file) = explode('?',$_SERVER['REQUEST_URI']);
	$ifp = fopen('../../../'.$file, 'wb' ); 
    $data = explode( ',', $_POST['data'] );
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    fclose( $ifp );
    exit($file.' başarıyla güncellendi.');
}


?><html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="styles.min.css?v9">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
	<style>
		body, html {
			margin: 0;
			width: 100%;
			height: 100%;
		}
	</style>
</head>
<body>

<pixie-editor>
	<div class="global-spinner">
		<style>.global-spinner {display: none; align-items: center; justify-content: center; z-index: 999; background: #fff; position: fixed; top: 0; left: 0; width: 100%; height: 100%;}</style>
		<style>.la-ball-spin-clockwise,.la-ball-spin-clockwise>div{position:relative;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.la-ball-spin-clockwise{display:block;font-size:0;color:#1976d2}.la-ball-spin-clockwise.la-dark{color:#333}.la-ball-spin-clockwise>div{display:inline-block;float:none;background-color:currentColor;border:0 solid currentColor}.la-ball-spin-clockwise{width:32px;height:32px}.la-ball-spin-clockwise>div{position:absolute;top:50%;left:50%;width:8px;height:8px;margin-top:-4px;margin-left:-4px;border-radius:100%;-webkit-animation:ball-spin-clockwise 1s infinite ease-in-out;-moz-animation:ball-spin-clockwise 1s infinite ease-in-out;-o-animation:ball-spin-clockwise 1s infinite ease-in-out;animation:ball-spin-clockwise 1s infinite ease-in-out}.la-ball-spin-clockwise>div:nth-child(1){top:5%;left:50%;-webkit-animation-delay:-.875s;-moz-animation-delay:-.875s;-o-animation-delay:-.875s;animation-delay:-.875s}.la-ball-spin-clockwise>div:nth-child(2){top:18.1801948466%;left:81.8198051534%;-webkit-animation-delay:-.75s;-moz-animation-delay:-.75s;-o-animation-delay:-.75s;animation-delay:-.75s}.la-ball-spin-clockwise>div:nth-child(3){top:50%;left:95%;-webkit-animation-delay:-.625s;-moz-animation-delay:-.625s;-o-animation-delay:-.625s;animation-delay:-.625s}.la-ball-spin-clockwise>div:nth-child(4){top:81.8198051534%;left:81.8198051534%;-webkit-animation-delay:-.5s;-moz-animation-delay:-.5s;-o-animation-delay:-.5s;animation-delay:-.5s}.la-ball-spin-clockwise>div:nth-child(5){top:94.9999999966%;left:50.0000000005%;-webkit-animation-delay:-.375s;-moz-animation-delay:-.375s;-o-animation-delay:-.375s;animation-delay:-.375s}.la-ball-spin-clockwise>div:nth-child(6){top:81.8198046966%;left:18.1801949248%;-webkit-animation-delay:-.25s;-moz-animation-delay:-.25s;-o-animation-delay:-.25s;animation-delay:-.25s}.la-ball-spin-clockwise>div:nth-child(7){top:49.9999750815%;left:5.0000051215%;-webkit-animation-delay:-.125s;-moz-animation-delay:-.125s;-o-animation-delay:-.125s;animation-delay:-.125s}.la-ball-spin-clockwise>div:nth-child(8){top:18.179464974%;left:18.1803700518%;-webkit-animation-delay:0s;-moz-animation-delay:0s;-o-animation-delay:0s;animation-delay:0s}.la-ball-spin-clockwise.la-sm{width:16px;height:16px}.la-ball-spin-clockwise.la-sm>div{width:4px;height:4px;margin-top:-2px;margin-left:-2px}.la-ball-spin-clockwise.la-2x{width:64px;height:64px}.la-ball-spin-clockwise.la-2x>div{width:16px;height:16px;margin-top:-8px;margin-left:-8px}.la-ball-spin-clockwise.la-3x{width:96px;height:96px}.la-ball-spin-clockwise.la-3x>div{width:24px;height:24px;margin-top:-12px;margin-left:-12px}@-webkit-keyframes ball-spin-clockwise{0%,100%{opacity:1;-webkit-transform:scale(1);transform:scale(1)}20%{opacity:1}80%{opacity:0;-webkit-transform:scale(0);transform:scale(0)}}@-moz-keyframes ball-spin-clockwise{0%,100%{opacity:1;-moz-transform:scale(1);transform:scale(1)}20%{opacity:1}80%{opacity:0;-moz-transform:scale(0);transform:scale(0)}}@-o-keyframes ball-spin-clockwise{0%,100%{opacity:1;-o-transform:scale(1);transform:scale(1)}20%{opacity:1}80%{opacity:0;-o-transform:scale(0);transform:scale(0)}}@keyframes ball-spin-clockwise{0%,100%{opacity:1;-webkit-transform:scale(1);-moz-transform:scale(1);-o-transform:scale(1);transform:scale(1)}20%{opacity:1}80%{opacity:0;-webkit-transform:scale(0);-moz-transform:scale(0);-o-transform:scale(0);transform:scale(0)}}</style>
		<div class="la-ball-spin-clockwise la-2x">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
	<script>setTimeout(function() {
		var spinner = document.querySelector('.global-spinner');
		if (spinner) spinner.style.display = 'flex';
	}, 50);</script>
</pixie-editor>
<script src="scripts.min.js?v9"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var pixie = new Pixie({
    	onSave: function(data, name) {
    		if(confirm('Resmin üzerinde kayıt ediliyor ve bu işlem geri alınamaz. Onaylıyor musunuz?'))
    		{
				$.ajax({
			     type: 'POST',
			     url: '<?php echo "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>',
			     data: { data: data , name: name},
			     success : function(response) {
				     alert(response);
				   }
			   });
			}
        },
    	image: '../../../<?php echo $_SERVER['QUERY_STRING'] ?>',
    	ui: {
	        toolbar: {
	            hide: false,
	            hideOpenButton: true,
	            hideSaveButton: false,
	            hideCloseButton: false,
	        },
	    },
    	languages: {
	        active: 'turkish',
	        custom: {
	            turkish: {
	            		"History": "Tarih",
	            		"Filter": "Filtre",
	            		"Resize": "Boyutlandır",
	            		"Crop": "Kes",
	            		"Transform": "Yönü Değiştir",
	            		"Draw": "Çizim",
	            		"Text": "Yazı",
	            		"Shapes": "Şekiller",
						"Objects": "Objeler",
						"Stickers": "Yapıştırma",
						"Frame": "Çerçeve",
						"Corners": "Köşeler",
						"Merge": "Birleştir",
						"Canvas Background": "Çerçeve Arkaplanı",
						"Width": "En",
						"Height": "Boy",
						"Brush Color": "Fırça Rengi",
						"Brush Type": "Fırça Tipi",
						"Brush Size": "Fırça Boyutu",
						"Cancel": "İptal",
						"Close": "Kapat",
						"Apply": "Uygula",
						"Size": "Boyut",
						"Maintain Aspect Ratio": "Orantıyı Koru",
						"Use Percentages": "Yüzde Kullan",
						"Radius": "Radius",
						"Align Text": "Yazıyı İzala",
						"Double click here": "Buraya Çift Tıkla",
						"Format Text": "Yazı Tipi",
						"Color Picker": "Renk Seçici",
						"Add Text": "Yazı Ekle",
						"Font": "Font",
						"Upload": "Yükle",
						"Google Fonts": "Google Fontları",
						"Search...": "Arama...",
						"Shadow": "Gölge",
						"Color": "Renk",
						"Outline": "Dışçizgi",
						"Background": "Arkplan",
						"Texture": "Texture",
						"Gradient": "Gradient",
						"Text Style": "Yazı Stili",
						"Delete": "Sil",
						"Background Color": "Arkaplan Rengi",
						"Outline Width": "Dışçizgi En",
						"Blur": "Blur",
						"Offset X": "Offset X",
						"Offset Y": "Offset Y",
						"Open": "Aç",
						"Save": "Kaydet",
						"Zoom": "Yakınlaştır",
						"Editor": "Editor",
						"Photo resized.": "Resim boyutlandırıldı.",
						"Circle" : "Daire",
						"Rectangle" : "Dörgen",
						"Triangle" : "Üçgen",
						"Ellipse" : "Elips",
						"Arrow #1" : "Ok #1",
						"Arrow #2" : "Ok #2",
						"Arrow #3" : "Ok #3",
						"Line" : "Çizgi",
						"Star" : "Yıldız",
						"Polygon" : "Çokgen",
						"Badge" : "Rozet",
						"Texture" : "Doku",
						"Radius" : "Yarıçap"					
	            }
	         }
	    },
    	onLoad: function() {
    		window.postMessage('pixieLoaded', '*');
    		var canvas = pixie.getTool('canvas');
    		var width = canvas.state.original.width;
    		var height = canvas.state.original.height;
			console.log(width, height);
			var resizeTool = pixie.getTool('resize');
       	    //resizeTool.apply(1000, 1000);
    	},
    });


</script>
</body>
</html>
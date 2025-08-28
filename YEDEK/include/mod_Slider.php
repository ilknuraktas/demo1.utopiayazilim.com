<?php
/*
	Þablon index.php 'de kullanýlabilir.
	$PAGE_OUT .= autoModLoad('Slider');
*/

function modSliderList()
{
	$cacheName= __FUNCTION__.'_'.$_GET['catID'].'_'.$_GET['act'].'_'.$_GET['markaID'];
	$cache = cacheout($cacheName);
	if ($cache || ($_GET['markaID'] && !$_GET['catID']))
		return $cache;
    $out = '';
	if($_GET['catID'])
	{
		$q = my_mysql_query("select * from sliderkategori where catIDs = '".$_GET['catID']."' OR catIDs like '%,".$_GET['catID'].",%' OR catIDs like '%,".$_GET['catID']."' OR catIDs like '".$_GET['catID'].",%' order by seq limit 0,10");
		if(!my_mysql_num_rows($q)) return;
		$i = 0;
		while($d=my_mysql_fetch_array($q))
		{
			$d = translateArr($d);
			$out.="<div>";	
			$out.="<a href='".$d['link']."'><img data-u='image' alt='Kampanya' src='images/kampanya/".$d['resim']."' /></a>\n";
			$out.="</div>";	
		}	
		return cachein($cacheName,$out);		
	}
	$q = my_mysql_query("select * from kampanyaJSBanner order by seq");
	while ($d=my_mysql_fetch_array($q))
	{
		$d = translateArr($d);
		$out.="<div>";	
		$out.="<a href='".$d['link']."'><img data-u='image' alt='Kampanya' src='images/kampanya/".$d['resimJS']."' /></a>\n";
		$out.="</div>";	
	}
	return cachein($cacheName,$out);
}

function mod_Slider()
{
	if(function_exists('modCatSlider'))
		return;
	$modSliderList = modSliderList();
	if(!$modSliderList)
		return;
	return '
    <script src="assets/js/jssor.slider-22.1.9.mini.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            var jssor_1_options = {
              $AutoPlay: true,
              $SlideDuration: 800,
              $SlideEasing: $Jease$.$OutQuint,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*responsive code begin*/
            /*you can remove responsive code if you don\'t want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 1920);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            /*responsive code end*/
        });
    </script>
    <style>
        /* jssor slider bullet navigator skin 05 css */
        /*
        .jssorb05 div           (normal)
        .jssorb05 div:hover     (normal mouseover)
        .jssorb05 .av           (active)
        .jssorb05 .av:hover     (active mouseover)
        .jssorb05 .dn           (mousedown)
        */
        .jssorb05 {
            position: absolute;
        }
		#jssor_1:hover .jssora02l,#jssor_1:hover .jssora02r { display:block; }
        .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
            position: absolute;
            /* size of bullet elment */
            width: 12px;
            height: 12px;
            filter: alpha(opacity=70);
            opacity: .7;
            overflow: hidden;
			border-radius:5px;
            cursor: pointer;
        }
        .jssorb05 div { background-color: gray; }
        .jssorb05 div:hover, .jssorb01 .av:hover { background-color: #d3d3d3; }
        .jssorb05 .av { background-color: #fff; }
        .jssorb05 .dn, .jssorb01 .dn:hover { background-color: #555555; }


        .jssora02l, .jssora02r {
            display: none;
            position: absolute;
            /* size of arrow element */
            width: 55px;
            height: 55px;
            cursor: pointer;
            background: url(\'images/a02.png\') no-repeat;
            overflow: hidden;
        }
        .jssora02l { background-position: -3px -33px; }
        .jssora02r { background-position: -63px -33px; }
        .jssora02l:hover { background-position: -123px -33px; }
        .jssora02r:hover { background-position: -183px -33px; }
        .jssora02l.jssora02ldn { background-position: -3px -33px; }
        .jssora02r.jssora02rdn { background-position: -63px -33px; }
        .jssora02l.jssora02lds { background-position: -3px -33px; opacity: .3; pointer-events: none; }
        .jssora02r.jssora02rds { background-position: -63px -33px; opacity: .3; pointer-events: none; }
    </style>
    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url(\'images/loading.gif\') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;">
            '.$modSliderList.'
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora02l" style="top:0px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora02r" style="top:0px;right:8px;width:55px;height:55px;" data-autocenter="2"></span>
    </div>
    <!-- #endregion Jssor Slider End -->';	
}
?>
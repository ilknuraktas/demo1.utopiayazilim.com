<?php
function McCoverImage($d)
{
    $out = '';
    for ($i = 0; $i <= 2; $i++) {
        $str = ('resim' . $i);
        if (!$d[$str]) continue;
        if (file_exists('./images/urunler/' . $d[$str]))
            $out .= '<img src="include/resize.php?path=images/urunler/' . $d[$str] . '&width=300" class="' . $str . '">';
    }
    return $out;
}

function anindaGonderim($d)
{
    if ($d['anindaGonderim'] == 1)
        $out = '<div class="kargoKutulari"><i class="fas fa-truck"></i><span>Anında Gönderim</span></div>';
    return $out;
}
function kargoBeles($d)
{
    if ($d['ucretsizKargo'] == 1)
        $out = '<div class="kargoKutulari"><i class="fas fa-truck"></i><span>Ücretsiz Kargo</span></div>';
    return $out;
}
function yerliUretims($d)
{
    if ($d['yerli'] == 1)
        $out = '<div class="kargoKutulari"><i class="far fa-handshake"></i><span>Yerli Üretim</span></div>';
    return $out;
}
function yeniUrun($d)
{
    if ($d['yeni'])
        $out = '<div class="kargoKutulari"><i class="fas fa-check"></i><span>Yeni<br/>Ürün</span></div>';
    return $out;
}

function myurunDetay()
{
    $out = generateTableBox(breadCrumb(), showItem($_GET['urunID']), tempConfig('urundetay'));
    $out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler, caprazPromosyonUrunList(), tempConfig('urunliste2'));
    $out .= paketIndirim($_GET['urunID'], 'UrunListLite', 'UrunListLiteShow', tempConfig('urunliste2'));
    return $out;
}


function weberilgiliUrunler()
{
    return ilgiliUrunList('empty', 'UrunListSliderShow');
}
function webercoksatanUrunler()
{
    return ilgiliUrunList('empty', 'UrunListSliderShow');
}


function weberSlider()
{
    $out = '';
    $cacheName = __FUNCTION__;
    $cache = cacheout($cacheName);
    if ($cache)
        return $cache;
    $q = my_mysql_query("select link,resimJS from kampanyaJSBanner order by seq");
    while ($d = mysql_fetch_array($q)) {
        $out .= '
<div class="swiper-slide">';
        $out .= "<a href='" . $d['link'] . "'><img alt='Kampanya' src='images/kampanya/" . $d['resimJS'] . "'/></a>\n";
        $out .= "</div>";
    }
    return cachein($cacheName, $out);
}
function wsVitrinContent()
{
    $out = '';
    $cacheName = __FUNCTION__;
    $cache = cacheout($cacheName);
    if ($cache)
        return $cache;
    $i = 0;
    $q = my_mysql_query("select link,resim from kampanyaBanner order by seq");
    while ($d = my_mysql_fetch_array($q)) {
        $i++;
        $out .= "<div id='tabcontent$i'><a href='" . $d['link'] . "'><img alt='Kampanya' src='images/kampanya/" . $d['resim'] . "' /></a></div>\n";
    }
    return cachein($cacheName, $out);
}

function wsVitrinThumb()
{
    $out = '';
    $cacheName = __FUNCTION__;
    $cache = cacheout($cacheName);
    if ($cache)
        return $cache;
    $i = 0;
    $q = my_mysql_query("select * from kampanyaBanner order by seq");
    while ($d = my_mysql_fetch_array($q)) {
        $d = translateArr($d);
        $i++;
        $out .= '<li><a href="#" onmouseover="easytabs(\'1\', \'' . $i . '\');" onfocus="easytabs(\'1\', \'' . $i . '\');" onclick="return false;"  title="" id="tablink' . $i . '"><img src="images/kampanya/' . ($d['thumb'] ? $d['thumb'] : $d['resim']) . '" alt="" /></a></li>' . "\n";
    }
    return cachein($cacheName, $out);
}

<?php

function paketLink($d)
{
    if (function_exists('myPaketLink')) {
        return myPaketLink($d);
    }
    global $langPrefix;
    $d = translateArr($d);
    $name = $d['name' . $langPrefix];
    $seoName = $d['seo' . $langPrefix];
    if (!$seoName) {
        $seoName = seoFix($name);
        my_mysql_query("update urunpaket set seo$langPrefix = '$seoName' where seo$langPrefix ='' AND ID='" . $d['ID'] . "' limit 1");
    }
    return generateLink(siteConfig('seoURL') ? 'ac/paketler/' . $seoName : 'page.php?act=paketler&ID=' . $d['ID'] . '&name=' . $seoName);
}


function paketTutar($paketID, $bayi = true)
{
    if (siteConfig('fiyatUyelikZorunlu') && !$_SESSION['userID']) {
        return _lang_fiyatIcinUyeGirisiYapin;
    }
    $q = my_mysql_query("select * from urunpaket where ID='$paketID'");
    $d = my_mysql_fetch_array($q);

    $listArray = explode(',', $d['urunIDs']);
    $filter = '';
    foreach ($listArray as $listFilter) {
        if ($listFilter) {
            $filter .= 'ID = \'' . $listFilter . '\' OR ';
        }
    }
    $filter .= ' ID=0 ';
    $query = 'select * from urun where active = 1 AND stok > 0 AND (' . $filter . ')';
    if ($bayi)
        $toplam = ytlFiyat(fixFiyat($d['amount'], $_SESSION['userID'], 0), $d['birim']);
    else
        $toplam = ytlFiyat(($d['amount']), $d['birim']);

    $q2 = my_mysql_query($query);
    $anatoplam = 0;
    $piyasatoplam = 0;
    while ($d2 = my_mysql_fetch_array($q2)) {
        if ($bayi)
            $anatoplam += ytlFiyat(fixFiyat($d2['fiyat'], $_SESSION['userID'], $d2), $d2['fiyatBirim']);
        else
            $anatoplam += ytlFiyat(($d2['fiyat']), $d2['fiyatBirim']);

        $piyasatoplam += ytlFiyat(($d2['piyasafiyat']), $d2['fiyatBirim']);
    }
    unset($d2);
    for ($i = 1; $i <= 10; $i++) {
        if (!$d['urun' . $i]) {
            continue;
        }
        $d2 = my_mysql_fetch_array(my_mysql_query('select * from urun where ID=' . (int) $d['urun' . $i]));
        if ($bayi)
            $anatoplam += ((int) $d['adet' . $i] * ytlFiyat(fixFiyat($d2['fiyat'], $_SESSION['userID'], $d2), $d2['fiyatBirim']));
        else
            $anatoplam += ((int) $d['adet' . $i] * ytlFiyat(($d2['fiyat']), $d2['fiyatBirim']));
    }
    if ($d['percent']) {
        $toplam = ($anatoplam * (1 - $d['percent']));
    }
    $out['anatoplam'] = $anatoplam;
    $out['toplamtl'] = $toplam;
    if (!$out['toplamtl'])
        $out['toplamtl'] = $anatoplam;
    if ($bayi)
        $out['toplam'] = fixFiyat($d['amount'], $_SESSION['userID'], 0);
    else
        $out['toplam'] = ($d['amount']);
    $out['piyasatoplam'] = $piyasatoplam;
    return $out;
}


function paketMaxStok($d)
{
    $maxStok = 10;
    for ($i = 1; $i <= 10; $i++) {
        if (!(int) $d['urun' . $i]) {
            continue;
        }

        $urunStok = hq('select stok from urun where ID=' . (int) $d['urun' . $i]);
        for ($j = 1; $j <= 10; $j++) {
            if (($d['adet' . $i] * $j) <= $urunStok)
                $maxAvailStok = $j;
            else
                break;
        }
        if ($maxStok > $maxAvailStok)
            $maxStok = $maxAvailStok;

        if (hq('select ID from urun where (active = 0 OR stok < ' . (int) $d['adet' . $i] . ') AND ID=' . (int) $d['urun' . $i])) {
            $maxStok = 0;
            continue;
        }
    }
    return $maxStok;
}

function paketUrunList($paketID)
{
    $out = array();
    $q = my_mysql_query("select * from urunpaket where ID='$paketID'");
    $d = my_mysql_fetch_array($q);
    $d = translateArr($d);
    $filter = '';
    $listArray = explode(',', $d['urunIDs']);
    foreach ($listArray as $listFilter) {
        if (!(int) $listFilter) {
            continue;
        }
        $filter .= 'ID = ' . $listFilter . ' OR ';
    }
    for ($i = 1; $i <= 10; $i++) {
        if (!(int) $d['urun' . $i]) {
            continue;
        }
        $filter .= 'ID = ' . (int) $d['urun' . $i] . ' OR ';
    }
    $filter .= ' ID=-1 ';

    $q2 = my_mysql_query('select * from urun where active = 1 AND stok > 0 AND (' . $filter . ')');
    while ($d2 = my_mysql_fetch_array($q2)) {
        $d2 = translateArr($d2);
        for ($i = 1; $i <= 10; $i++) {
            if ($d['urun' . $i] == $d2['ID'])
                $d2['name'] .= ' x ' . (int) $d['adet' . $i] . ' ' . _lang_sepet_adet;
        }
        $out[] = $d2['name'];
    }
    $pf = paketTutar($d['ID']);
    return $d['name'] . ' : ' . implode(', ', $out).' = '.mf($pf['toplamtl']).' '.fiyatBirim('TL');
}

function paketIndirim($paketID, $list, $temp, $block)
{
    if ($_GET['act'] != 'paketGoster') return;
    global $siteConfig;
    $out = '';
    $q = my_mysql_query("select * from urunpaket where ID='$paketID'");
    while ($d = my_mysql_fetch_array($q)) {
        $stokYok = false;
        $filter = '';
        $listArray = explode(',', $d['urunIDs']);
        foreach ($listArray as $listFilter) {
            if (!(int) $listFilter) {
                continue;
            }
            $filter .= 'ID = ' . $listFilter . ' OR ';
            if (!hq('select ID from urun where active = 1 AND ID=' . $listFilter)) {
                $stokYok = true;
            }
        }
        for ($i = 1; $i <= 10; $i++) {
            if (!(int) $d['urun' . $i]) {
                continue;
            }
            $filter .= 'ID = ' . (int) $d['urun' . $i] . ' OR ';
            if (hq('select ID from urun where (active = 0 OR stok < ' . (int) $d['adet' . $i] . ') AND ID=' . (int) $d['urun' . $i])) {
                $stokYok = true;
                continue;
            }
        }
        $filter .= ' ID=-1 ';
        if (hq('select ID from urun where ((active = 0 OR stok < 1) AND (' . $filter . '))')) {
            $stokYok = true;
        }
        $IcSayfaUrunSayisi = siteConfig('icSayfaUrun');
        $siteConfig['icSayfaUrun'] = 999;
        $query = 'select * from urun where active = 1 AND stok > 0 AND (' . $filter . ')';
        $box = urunList($query, $list, $temp);
        for ($i = 1; $i <= 10; $i++) {
            if (!$d['urun' . $i] || $d['urun' . $i] < 1) {
                continue;
            }
            $box = str_replace(hq('select name from urun where ID=' . (int) $d['urun' . $i]), hq('select name from urun where ID=' . (int) $d['urun' . $i]) . ' x ' . (int) $d['adet' . $i] . ' ' . _lang_sepet_adet, $box);
        }
        $paketTutar = paketTutar($d['ID']);
        if (siteConfig('fiyatUyelikZorunlu') && !$_SESSION['userID']) {
            $box .= '<div class="paketFiyat">' . _lang_fiyatIcinUyeGirisiYapin . '</div><div style="clear:both"></div>';
        } else {
            if ($stokYok) {
                $box .= '<div class="paketFiyat">' . _lang_stoktaYok . '</div><div style="clear:both"></div>';
            } else {
                $box .= '<div class="paketFiyat"><div class="paketCont">' . _lang_urunList_toplam . ' : <span class="paketEski">' . my_money_format('', $paketTutar['anatoplam']) . ' ' . fiyatBirim('TL') . '</span><span class="paketYeni">' . my_money_format('', $paketTutar['toplamtl']) . ' ' . fiyatBirim('TL') . '</span>
                <div class="clear-space">&nbsp;</div>
                <a href="page.php?act=sepet&amp;op=paketEkle&amp;paketID=' . $d['ID'] . '"><input type="button" class="sf-button sf-button-large sf-neutral-button float-right" value="' . _lang_sepeteEkle . '" /></a> </div><div style="clear:both"></div></div>';
            }
        }
        $siteConfig['icSayfaUrun'] = $IcSayfaUrunSayisi;
        $out .= generateTableBox($d['name'], $d['detay'] . '<hr />' . $box, $block) . '';
    }
    return $out;
}

function paketList($temp = '../../system/default/UrunListView')
{
    global $siteDizini;
    $out = '';

    $q = my_mysql_query("select * from urunpaket order by seq,name");
    while ($d = my_mysql_fetch_array($q)) {
        $d = translateArr($d);

        $contents = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '' . $siteDizini . 'templates/' . siteConfig('templateName') . '/systemDefault/' . $temp . '.php');
        $pf = paketTutar($d['ID']);
        $d['fiyat'] = $pf['toplamtl'];
        $d['piyasafiyat'] =  $pf['piyasatoplam'];
        $d['fiyatBirim'] = 'TL';
        $d['stok'] = paketMaxStok($d);
        $d['name'] = $d['name'];
        if (!$d['fiyat'])
            continue;
        $contents = str_replace(
            array('{%URUN_DETAY_LINK%}', '{%URUN_FIYAT%}', '{%URUN_PIYASA_FIYAT%}', '{%func-data_indirimOranView%}'),
            array(paketLink($d), urunFiyat($d, 'fiyat'), urunFiyat($d, 'piyasafiyat'), indirimOranView($d)),
            $contents
        );
        $contents = urunTemplateReplace($d, $contents);
        $contents = str_replace(
            array('images/urunler/'),
            array('images/paketler/'),
            $contents
        );
        $out .= $contents;
    }
    return $out;
}

<?php

include("fonksiyon.php");

function insertBannerxx($code) {
    $cacheName= __FUNCTION__.$code; 
    $cache = cacheout($cacheName); 
    if (isset($cache)) 
        return $cache; 
    
    $bannerQry = my_mysql_query('select * from bannerYonetim,bannerlar where bannerYonetim.bannerID=bannerlar.ID AND aktif=\'1\' AND (maxHit = \'0\' OR maxHit > hit) AND (maxGosterim = \'0\' OR maxGosterim > gosterim) AND (bannerYer = \''.$code.'\' OR bannerOto = \''.$code.'\')') or die(my_mysql_error()); 
    while ($banner = my_mysql_fetch_array($bannerQry)) { 
        $banner = translateArr($banner); 
    my_mysql_query('update bannerlar set gosterim = gosterim + \'1\' where ID = \''.$banner['bannerID'].'\' '); 
    
    if($banner['cats'] && !$_GET['act'] != 'kategoriGoster') 
        return; 
    else if($banner['cats']) 
    { 
        $cArr = explode(',',$banner['cats']); 
        if(!in_array($_GET['catID'],$cArr)) 
            cachein($cacheName,$out); 
    } 
    
    $out.='<div style="'.$banner['divStyle'].'" class="spbanner">'; 
    if ($banner['bannerPic']) $out.= '<a href="banner.php?ID='.$banner['bannerID'].'&url='.$banner['url'].'"><img border="0" alt="banner" src="images/banner/'.$banner['bannerPic'].'"></a>'."\n"; 
    $out.=$banner['bannerFlashSource']; 
    $out.='</div>'; 
    } 
    return cachein($cacheName,$out); 
}

function insertBannerx($code) {
    $cacheName= __FUNCTION__.$code; 
    $cache = cacheout($cacheName); 
    if (isset($cache))
        return $cache;
    $bannerQry = my_mysql_query('select * from bannerlar where name = \''.$code.'\'') or die(my_mysql_error()); 
    while ($banner = my_mysql_fetch_array($bannerQry)) { 

    if ($banner['bannerPic']) $out.= '<a href="'.$banner['url'].'"><img alt="'.$banner['name'].'" class="lozad img-responsive" src="templates/'.$_SESSION["templateName"].'/images/placeholder.jpg" data-src="images/banner/'.$banner['bannerPic'].'"></a>'."\n";
    }
    return cachein($cacheName,$out); 
}

?>
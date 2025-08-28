<?
$dbase = "temp_aqua";
$tempInfo.=adminInfo('Bu şablona <a href="s.php?f=bannerYonetim.php">"Banner Yönetiminden"</a> kolayca banner ekleyebilirsiniz. Ekleyebileceğiniz banner kodları; 
<br /><br />
<strong>slider-alt</strong><br />
');

$icerik = array(
    array(
        isim => 'Footer Slogan',
        disableFilter => true,
        unlist => true,
        multilang => true,
        maxlength => 320,
        db => 'footerSlogan',
        stil => 'normaltext',
        intab => 'seo',
        gerekli => '0'
    ),
    array(
        isim => 'Footer Yazısı',
        db => 'footerSEO',
        unlist => true,
        stil => 'textarea',
        multilang => true,
        rows => '4',
        cols => '64'
    ),
);
				
?>
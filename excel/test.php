<?php
define('MY_DBHOST', 'localhost:3306');
define('MY_DBUSER', 'ticaraha_pazaryeri');
define('MY_DBPWD', 'pazaryeri2020!!');
define('MY_DBNAME', 'ticaraha_pazaryeri');

function sef_url ( $url ) {
    $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
    $turkceto = array("G","U","S","I","O","C","g","u","s","i","o","c");
    $url = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$url);
    // Türkçe harfleri ingilizceye çevir
    $url = preg_replace($turkcefrom,$turkceto,$url);
    // Birden fazla olan boşlukları tek boşluk yap
    $url = preg_replace("/ +/"," ",$url);
    // Boşukları - işaretine çevir
    $url = preg_replace("/ /","-",$url);
    // Tüm beyaz karekterleri sil
    $url = preg_replace("/\s/","",$url);
    // Karekterleri küçült
    $url = strtolower($url);
    // Başta ve sonda - işareti kaldıysa yoket
    $url = preg_replace("/^-/","",$url);
    $url = preg_replace("/-$/","",$url);
    return $url;
}

try {
    $db = new PDO("mysql:host=" . MY_DBHOST . ";dbname=" . MY_DBNAME . ";charset=utf8;", MY_DBUSER, MY_DBPWD);
} catch (PDOException $e) {
    print $e->getMessage();
}
$yuklemeYeri = $_FILES["upload_file"]["name"];
$sonuc = move_uploaded_file($_FILES["upload_file"]["tmp_name"], $yuklemeYeri);
include 'Classes/PHPExcel.php'; // Kütüphanenin Yolu Belirtiyoruz.
$ExcelDosyasi = $_FILES["upload_file"]["name"]; // Okutacağımız Excel Dosyasını Seçiyoruz. (Desteklenen Formatlar: xls, xlsx)
$ExcelOku = PHPExcel_IOFactory::load($ExcelDosyasi);
$ExcelVeriler = $ExcelOku->getActiveSheet()->toArray(null, true, true, true); // Aktif Sütunları Seçiyoruz.
$i = 1;

function file_download($link, $name = null)
{

    $link_info = pathinfo($link);
    $uzanti = strtolower($link_info['extension']);
    $file = ($name) ? $name . '.' . $uzanti : $link_info['basename'];
    $yol = "../uploads/images/" . $file;

    $curl = curl_init($link);
    $fopen = fopen($yol, 'w');

    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($curl, CURLOPT_FILE, $fopen);

    curl_exec($curl);
    curl_close($curl);
    fclose($fopen);
    return $file;

}

foreach ($ExcelVeriler as $ExcelAl) {

    if ($i != 1) {
        $products = $db->prepare("SELECT * FROM products order by id DESC ");
        $products->execute();
        $produc = $products->fetch(PDO::FETCH_ASSOC);
        $Kayit = $db->prepare("INSERT INTO `products` (`title`, `barcode`, `GTIN_code`, `sku`, `brand`, `category_id`, `price`, `currency`, `discount_rate`, `vat_rate`, `description`, `stock`,`shipping_time`,`shipping_cost_type`,`shipping_cost`,`shipping_cost_additional`,`is_draft`,`is_free_product`,`user_id`,`slug`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
        $Kayit->execute(array($ExcelAl["A"], $ExcelAl["B"], $ExcelAl["C"], $ExcelAl["D"], $ExcelAl["E"], $ExcelAl["F"], $ExcelAl["G"], $ExcelAl["H"], $ExcelAl["I"], $ExcelAl["J"], $ExcelAl["K"], $ExcelAl["P"], $ExcelAl["Q"], $ExcelAl["R"], $ExcelAl["S"], $ExcelAl["T"], $ExcelAl["U"], $ExcelAl["V"],$_POST['id'],sef_url($ExcelAl['A']."-".++$produc['id'])));


        $link = $ExcelAl["L"]; // İndirmek istediğimiz dosyanın linki
        $rasgele_sayi = time() . rand(100000, 900000); // Rastgele sayi olusturup, degiskene atiyoruz.
        $name = file_download($link, $rasgele_sayi);
        if ($ExcelAl["L"] != null):
            $Kayit = $db->prepare("INSERT INTO `images` (`id`, `product_id`, `image_default`, `image_big`, `image_small`, `is_main`, `storage`) VALUES (NULL, ?, ?, ?, ?, '1', 'local');");
            $Kayit->execute(array($produc['id'], $name, $name, $name));
        endif;
        if ($ExcelAl["M"] != null):
            $link = $ExcelAl["M"]; // İndirmek istediğimiz dosyanın linki
            $rasgele_sayi = time() . rand(100000, 900000); // Rastgele sayi olusturup, degiskene atiyoruz.
            $name = file_download($link, $rasgele_sayi);

            $Kayit = $db->prepare("INSERT INTO `images` (`id`, `product_id`, `image_default`, `image_big`, `image_small`, `is_main`, `storage`) VALUES (NULL, ?, ?, ?, ?, '0', 'local');");
            $Kayit->execute(array($produc['id'], $name, $name, $name));

        endif;
        if ($ExcelAl["N"] != null):
            $link = $ExcelAl["N"]; // İndirmek istediğimiz dosyanın linki
            $rasgele_sayi = time() . rand(100000, 900000); // Rastgele sayi olusturup, degiskene atiyoruz.
            $name = file_download($link, $rasgele_sayi);

            $Kayit = $db->prepare("INSERT INTO `images` (`id`, `product_id`, `image_default`, `image_big`, `image_small`, `is_main`, `storage`) VALUES (NULL, ?, ?, ?, ?, '0', 'local');");
            $Kayit->execute(array($produc['id'], $name, $name, $name));

        endif;
        if ($ExcelAl["O"] != null):
            $link = $ExcelAl["O"]; // İndirmek istediğimiz dosyanın linki
            $rasgele_sayi = time() . rand(100000, 900000); // Rastgele sayi olusturup, degiskene atiyoruz.
            $name = file_download($link, $rasgele_sayi);

            $Kayit = $db->prepare("INSERT INTO `images` (`id`, `product_id`, `image_default`, `image_big`, `image_small`, `is_main`, `storage`) VALUES (NULL, ?, ?, ?, ?, '0', 'local');");
            $Kayit->execute(array($produc['id'], $name, $name, $name));

        endif;


    }
    $i++;


}


echo 'Yönlendirme için Bekleyiniz...';
$geldigi_sayfa = $_SERVER['HTTP_REFERER'];
header("Refresh: 2; url=".$geldigi_sayfa."?status=update");

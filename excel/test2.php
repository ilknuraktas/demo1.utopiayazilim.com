<?php
define('MY_DBHOST', 'localhost:3306');
define('MY_DBUSER', 'ticaraha_pazaryeri');
define('MY_DBPWD', 'pazaryeri2020!!');
define('MY_DBNAME', 'ticaraha_pazaryeri');
function dosyaDownload($dosya)
{
    if ((isset($dosya))&&(file_exists($dosya))) {
        header("Content-length: ".filesize($dosya));
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $dosya . '"');
        readfile("$dosya");
    } else {
        echo "Dosya Seçilmedi";
    }
}
try {
    $db = new PDO("mysql:host=".MY_DBHOST.";dbname=".MY_DBNAME.";charset=utf8;", MY_DBUSER, MY_DBPWD);
} catch (PDOException $e) {
    print $e->getMessage();
}
$deger = $db->prepare("SELECT * FROM products");
$deger->execute();
include 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);

$rowCount = 0;

foreach ($deger as $d){
    $rowCount++;
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $d['slug']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $d['title']);
}
$time=time();
$name='w'.$time.'.xlsx';
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save($name);
dosyaDownload($name);
?>
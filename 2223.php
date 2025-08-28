<?php
header('Content-Type: text/html; charset=utf-8');
ini_set("soap.wsdl_cache_enabled", "0");

$SOAP = new SoapClient("http://panel.vatansms.com/webservis/service.php?wsdl", array(
    "trace"      => 1,
    "exceptions" => 0));

$MUSTERINO='23159'; //5 haneli müşteri numarası
$KULLANICIADI='5359356777';
$SIFRE='10203040eaa';
$ORGINATOR="DSADS";
$TUR='Turkce';  // Normal yada Turkce
$ZAMAN='';          // İleri tarih için kullanabilirsiniz 2014-04-07 10:00:00
$ZAMANASIMI=''; // Sms ömrünü belirtir 2014-04-07 15:00:00

$mesaj='Deneme Mesajıdır';
$numaralar='5554443322,5553332244';

$SONUC = $SOAP->TekSmsiBirdenCokNumarayaGonder($MUSTERINO,$KULLANICIADI,$SIFRE,$ORGINATOR,$numaralar,$mesaj,$ZAMAN,$ZAMANASIMI,$TUR);
echo $SONUC;
?>

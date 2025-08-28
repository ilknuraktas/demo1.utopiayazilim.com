<?php
include('../../all.php');
    $modID = hq("select ID from banka where active = 1 AND paymentModulURL = 'include/payment_YapiKredi3D.php' order by ID desc limit 0,1");
    //Configuration parameters
    define('MID', dbInfo('banka','clientID',$modID));
    define('TID', dbInfo('banka','modData1',$modID));
    define('POSNETID', dbInfo('banka','modData2',$modID));
    define('ENCKEY', dbInfo('banka','modData3',$modID));
     define('USE_OOS_PAGE', 0);

    //Posnet Sistemi ile ilgili parametreler
    if (dbInfo('banka','postURL',$modID) == 'TEST')

    {

        define('OOS_TDS_SERVICE_URL', 'https://setmpos.ykb.com/3DSWebService/YKBPaymentService');

        define('XML_SERVICE_URL', 'https://setmpos.ykb.com/PosnetWebService/XML');

    }

    else

    {

        define('OOS_TDS_SERVICE_URL', 'https://www.posnet.ykb.com/3DSWebService/YKBPaymentService');

        define('XML_SERVICE_URL', 'https://www.posnet.ykb.com/PosnetWebService/XML');

    }

 
    //�ye ��yeri sayfas� ba�lang�� web adresi (hata durumunda bu sayfaya d�n�l�r.)
    define('MERCHANT_INIT_URL', 'http://'.$_SERVER['HTTP_HOST']);
    //�ye ��yeri d�n�� sayfas�n�n web adresi
    define('MERCHANT_RETURN_URL', 'https://'.$_SERVER['HTTP_HOST'].'/'.$siteDizini.''.'page.php?3dPosBack='.$modID);
    
    //�ifreleme i�in PHP MCrypt mod�l�n� kullan
    define('USEMCRYPTLIBRARY', false);
    define('OPEN_NEW_WINDOW', '0');
    
    //3D-Secure kontrolleri
    define('TD_SECURE_CHECK', false);
    define('TD_SECURE_CHECK_MASK', '1:2:4:9');
?>
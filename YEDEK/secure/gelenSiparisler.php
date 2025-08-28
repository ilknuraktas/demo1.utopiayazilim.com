<?php
//include('../include/mod_Siparis.php');
if ($_GET['setOrders']) {
    $odemeDurum = hq("select title from odemeDurum where ID='" . (int)$_GET['orderStatusID'] . "'");
    foreach ($_GET['sipIDs'] as $orderID) {
        if (!$shopphp_demo) {
            my_mysql_query("update siparis set kargoFirma = kargoFirmaID where (kargoFirma = '' OR kargoFirma = 0) AND ID='$orderID'");

            changeOrderStatus($orderID, (int)$_GET['orderStatusID']);
            $sno = hq("select randStr from siparis where ID='$orderID'");
            my_mysql_query("update siparis set durum = '" . (int)$_GET['orderStatusID'] . "' where ID='$orderID'");
            my_mysql_query("update sepet set durum = '" . (int)$_GET['orderStatusID'] . "' where randStr='$sno'");
            $tempInfo .= adminInfov5('<strong>' . $sno . '</strong> numaralı siparişin durumu <strong>' . $odemeDurum . '</strong> ile güncellendi.');
        } else
            $tempInfo .= adminInfov5('Demo kullanım nedeniyle <strong>' . $sno . '</strong> numaralı siparişin durumu <strong>' . $odemeDurum . '</strong> ile güncellenmedi.');
    }
    // $tempInfo.= adminInfov5('Lütfen bekleyin ..');
    // $tempInfo.= '<script>window.location.href = \'s.php?f='.$_GET['f'].'\'; </script>';

}

function siparisFix($randStr)
{
    $carr = array('name', 'lastname', 'address', 'city', 'semt', 'mah', 'tckNo', 'vergiNo', 'vergiDaire', 'ceptel');
    $q = my_mysql_query("select * from siparis where userID>0 AND randStr = '$randStr'");
    while ($d = my_mysql_fetch_array($q)) {

        foreach ($carr as $c) {
            $v = hq("select $c from user where ID='" . $d['userID'] . "'");
            if (!$d[$c] && $v) {
                my_mysql_query("update siparis set $c = '" . addslashes($v) . "' where ID='" . $d['ID'] . "'", 1);
            }
        }

        if (!hq("select ID from sepet where randStr = '$randStr'")) {
            list($tarih) = explode(' ', $d['tarih']);
            my_mysql_query("update sepet set randStr = '$randStr', durum='" . $d['durum'] . "' where userID='" . $d['userID'] . "' AND tarih like '$tarih%'");
        }
    }

    $q = my_mysql_query("select * from siparis where randStr = '$randStr'");
    $d = my_mysql_fetch_array($q);

    if ($d['address2'] && !$d['address']) {
        my_mysql_query("update siparis set address=adress2, semt=semt2, city=city2,mah=mah2 where ID='" . $d['ID'] . "'");
    }
}

if ($_GET['f'] == 'gelenSiparisler.php')
    $title = 'Gelen Siparişler';
$SerialZorunlu = false;
$dbase = "siparis";
if (!$title) $title = 'Sipariş Bilgileri';
if (!$listTitle) $listTitle = 'Ödeme Onaylı Siparişler';
if (!$where) $where = "(siparis.durum > 1 AND siparis.durum < 50) OR siparis.durum = 94";
if ($_GET['siparisID']) $_GET['ID'] = $_POST['ID'] = hq("select ID from siparis where randStr = '" . $_GET['siparisID'] . "'");

if ($_POST['durum'] && file_exists('../include/mod_Amazon.php')) {
    require_once('../include/mod_Amazon.php');
}
$ozellikler = array(
    ekle => (bool)$ozellikler['ekle'],
    baseid => 'ID',
    orderby => 'tarih',
    ordersort => 'desc',
    excel => 1,
    excelLoad => 1,
    setorder => 1,
    multiprint => 1,
);

$icerik = array(
    array(
        isim => 'Yönetici Notu',
        db => 'notYonetici',
        unlist => true,
        intab => 'genel',
        stil => 'textarea',
        rows => '3',
        cols => '64',
        gerekli => '1'
    ),
    array(
        isim => 'Durum',
        db => 'durum',
        unlist => $unlist,
        stil => 'dbpulldown',
        intab => 'genel,kargo',
        dbpulldown_data => array(
            db => 'odemeDurum',
            base => 'ID',
            name => 'title',
            order => 'ID',
        ),
        gerekli => '1'
    ),

    array(
        isim => 'Bir Fatura Kargo ID',
        db => 'bkargoID',
        unlist => true,
        intab => 'kargo',
        stil => 'simplepulldown',
        simpleValues => '2|Kapıda Ödeme,3|Mağaza Öder,4|Alıcı Öder',
        autoSelected => '1',
        gerekli => '0'
    ),
    array(
        isim => 'Entegra Bilişim Ödeme Şekli',
        db => 'eodemeID',
        unlist => true,
        intab => 'kargo',
        stil => 'simplepulldown',
        simpleValues => '1|Nakit,2|Kredi Kartı,3|Havale,4|N11,5|GG,6|SP,7|HepsiBurada,8|Kapıda Nakit,9|Kapıda Kredi Kartı,10|Mobil,11|Paypal,12|Payu Taksitli,13|IyziPay,14|Eptt,15|Trendyol,16|Amazon,17|N11Pro,18|AliExpress,19|AmazonEu,20|Morhipo',
        autoSelected => '1',
        gerekli => '0'
    ),
    array(
        isim => 'Entegra Bilişim Kargo ID',
        db => 'ekargoID',
        unlist => true,
        intab => 'kargo',
        stil => 'simplepulldown',
        simpleValues => '1|Alıcı Öder,2|Satıcı Öder,3|Satıcı Öder Kapıda Nakit,4|Satıcı Öder Kapıda Kredikartı,5|GG Öder,6|N11 Öder,7|HB Öder,8|Alıcı Öder Kapıda Kredikartı,9|Alıcı Öder Kapıda Nakit',
        autoSelected => '1',
        gerekli => '0'
    ),

    array(
        isim => 'Paraşüt ID',
        db => 'parasutID',
        unlist => true,
        stil => 'normaltext',
        width => 100,
        intab => 'diger'
    ),

    array(
        intab => 'genel',
        isim => 'Sipariş No',
        db => 'randStr',
        readonly => true,
        width => 200,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'diger',
        isim => 'Fatura No',
        db => 'faturaNo',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),

    array(
        intab => 'genel,adres',
        isim => 'Kullanıcı',
        db => 'userID',
        width => 70,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'user',
            base => 'ID',
            name => 'username',
        ),
        detailLink => 's.php?f=users.php&y=d&ID={%%}',
        detailText => 'Kullanıcı Detayları',
        nullValue => 'Kayıtlı Kullanıcı Değil',
        gerekli => '1'
    ),

    array(
        intab => 'genel,adres',
        isim => 'Adı',
        db => 'name',
        width => 76,
        stil => 'normaltext',
        gerekli => '1'
    ),

    array(
        intab => 'genel,adres',
        isim => 'Soyadı',
        db => 'lastname',
        width => 76,
        stil => 'normaltext',
        gerekli => '1'
    ),

    array(
        intab => 'genel,adres',
        isim => 'E-Posta',
        db => 'email',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'Kayıtlı Teslimat Adresi Seçimi',
        db => 'adresID',
        unlist => true,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'useraddress',
            base => 'ID',
            name => 'baslik',
        ),
        detailLink => 's.php?f=userAddress.php&y=d&ID={%%}',
        detailText => 'Adres Detayları',
        nullValue => 'Adres Seçilmedi',
        gerekli => '1'
    ),


    array(
        intab => 'adres',
        isim => 'Ev Telefonu',
        db => 'evtel',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'İş Telefonu',
        db => 'istel',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'genel,adres',
        isim => 'Cep Telefonu',
        db => 'ceptel',
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'TC Kimlik No',
        db => 'tckNo',
        unlist => true,
        width => 69,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'Adres',
        db => 'address',
        stil => 'textarea',
        unlist => true,
        rows => '3',
        cols => '64',
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'Semt',
        db => 'semt',
        unlist=>true,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'ilceler',
            base => 'ID',
            name => 'name',
            where=>' parentID='.(int)hq("select city from siparis where ID='".$_GET['ID']."'"),
        ),
        gerekli => '1'
    ),
    
    array(
        intab => 'adres',
        isim => 'Mahalle',
        db => 'mah',
        stil => 'dbpulldown',
        unlist => true,
        dbpulldown_data => array(
            db => 'mahalleler',
            base => 'ID',
            name => 'name',
            where=>' parentID='.(int)hq("select semt from siparis where ID='".$_GET['ID']."'"),
        ),
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'Şehir',
        db => 'city',
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'iller',
            base => 'plakaID',
            name => 'name',
            where=>' cID='.((int)hq("select country from siparis where ID='".$_GET['ID']."'")?(int)hq("select country from siparis where ID='".$_GET['ID']."'"):1),
        ),
        gerekli => '1'
    ),


    array(
        intab => 'adres',
        isim => 'Ülke',
        db => 'country',
        width => 282,
        unlist => true,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'ulkeler',
            base => 'ID',
            name => 'name',
        ),
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'Kayıtlı Fatura Adresi Seçimi',
        db => 'faturaID',
        unlist => true,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'useraddress',
            base => 'ID',
            name => 'baslik',
        ),
        detailLink => 's.php?f=userAddress.php&y=d&ID={%%}',
        detailText => 'Adres Detayları',
        nullValue => 'Adres Seçilmedi',
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'Firma Ünvanı',
        db => 'firmaUnvani',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'Vergi No',
        db => 'vergiNo',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'adres',
        isim => 'Vergi Dairesi',
        db => 'vergiDaire',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'E-Fatura Mükellefi',
        db => 'efatura',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'Fatura Adresi',
        db => 'address2',
        unlist => true,
        stil => 'textarea',
        rows => '3',
        cols => '64',
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'Semt',
        unlist => true,
        db => 'semt2',
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'ilceler',
            base => 'ID',
            name => 'name',
            where=>' parentID='.(int)hq("select city2 from siparis where ID='".$_GET['ID']."'"),
        ),
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'Mahalle',
        db => 'mah2',
        unlist => true,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'mahalleler',
            base => 'ID',
            name => 'name',
            where=>' parentID='.(int)hq("select semt2 from siparis where ID='".$_GET['ID']."'"),
        ),
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'Şehir',
        unlist => true,
        db => 'city2',
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'iller',
            base => 'plakaID',
            name => 'name',
            where=>' cID='.((int)hq("select country2 from siparis where ID='".$_GET['ID']."'")?(int)hq("select country2 from siparis where ID='".$_GET['ID']."'"):1),
        ),
        gerekli => '1'
    ),

    array(
        intab => 'adres',
        isim => 'Ülke',
        unlist => true,
        db => 'country2',
        width => 282,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'ulkeler',
            base => 'ID',
            name => 'name',
        ),
        gerekli => '1'
    ),
    array(
        intab => 'kargo',
        isim => 'Seçilen Teslimat Bilgisi',
        db => 'teslimatID',
        unlist => true,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'teslimat',
            base => 'ID',
            name => 'name',
        ),
        gerekli => '1'
    ),
    array(
        intab => 'kargo',
        isim => 'Hediye Paketi Talebi',
        db => 'hediye',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'genel',
        isim => 'Sipariş Notu',
        db => 'notAlici',
        unlist => true,
        stil => 'textarea',
        rows => '3',
        cols => '64',
        gerekli => '1'
    ),
    array(
        intab => 'odeme',
        isim => 'Ödeme Detay',
        unlist => true,
        db => 'odemeTipi',
        stil => 'normaltext',
        gerekli => '1'
    ),

    array(
        intab => 'odeme',
        isim => 'Tutar',
        db => 'toplamTutarTL',
        width => 100,
        stil => 'normaltext',
        readonly => true,
        gerekli => '1'
    ),




    array(
        intab => 'odeme',
        isim => 'Ödeme Tipi',
        db => 'odemeID',
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'banka',
            base => 'ID',
            name => 'bankaAdi',
        ),
        gerekli => '1'
    ),
    array(
        intab => 'odeme',
        isim => 'Puan (Yeni) Toplanan',
        db => 'puanToplanan',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'odeme',
        isim => 'Puan Harcanan',
        db => 'puanHarcanan',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'odeme',
        isim => 'Puan Harcanan TL',
        db => 'puanHarcananTL',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),

    array(
        intab => 'genel',
        isim => 'Sipariş Tarihi',
        setTime => true,
        db => 'tarih',
        stil => 'date',
        gerekli => '1'
    ),
    array(
        intab => 'kargo',
        isim => 'Kargo Teslim Tarihi',
        db => 'kargoTarih',
        stil => 'date',
        unlist => true,
        gerekli => '0'
    ),
    array(
        intab => 'kargo',
        isim => 'Seçilen Kargo Firması',
        db => 'kargoFirmaID',
        unlist => true,
        stil => 'dbpulldown',
        dbpulldown_data => array(
            db => 'kargofirma',
            base => 'ID',
            name => 'name',
            order => 'ID'
        ),
        gerekli => '1'
    ),
    array(
        intab => 'kargo',
        isim => 'Gönderilen Kargo Firması',
        db => 'kargoFirma',
        width => 94,
        info => 'Kargo API entegrasyonundan mutlaka seçilmelidir.',
        stil => 'dbpulldown',
        unlist => true,
        dbpulldown_data => array(
            db => 'kargofirma',
            base => 'ID',
            name => 'name',
            order => 'ID'
        ),
        gerekli => '1'
    ),

    array(
        intab => 'kargo',
        isim => 'Kargo Takip No',
        info => 'Kargo API entegrasyonunda doldurulmasına gerek yoktur.',
        db => 'kargoSeriNo',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'kargo',
        isim => 'Kargo Takip URL Adresi',
        info => 'Kargo API entegrasyonunda doldurulmasına gerek yoktur.',
        db => 'kargoURL',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'kargo',
        isim => 'Son Kargo Durumu',
        info => 'Kargo API entegrasyonunda doldurulmasına gerek yoktur. Yönetici bilgi amaçlıdır.',
        db => 'kargoDurum',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'odeme',
        isim => 'Sipariş Puan',
        db => 'puan',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    /*
    array(
        intab => 'genel,diger',
        isim => 'Sipariş Yorum',
        db => 'yorum',
        unlist => true,
        stil => 'textarea',
        rows => '3',
        cols => '64',
        gerekli => '1'
    ),
    */
    array(
        isim => 'Faturası Kesildi',
        db => 'fatura',
        intab => 'genel',
        width=>45,
        stil => 'checkbox',
        gerekli => '0'
    ),
    array(
        intab => 'diger',
        isim => 'Sipariş IP Adresi',
        db => 'IP',
        unlist => true,
        stil => 'normaltext',
        gerekli => '1'
    ),
    array(
        intab => 'diger',
        isim => 'Sipariş Referrer',
        db => 'data5',
        stil => 'normaltext',
        unlist => true,
        gerekli => '0'
    ),
    array(
		isim => 'Debug Payment Log',
		offline => true,
		unlist => true,
		stil => 'customtext',
		intab => 'diger',
		text => showPaymentDebug($_GET['ID'],'payment'),
	),
    array(
		isim => 'Debug Notify Log',
		offline => true,
		unlist => true,
		stil => 'customtext',
		intab => 'diger',
		text => showPaymentDebug($_GET['ID'],'notify'),
	),
);

if ($_GET['f'] == 'tamamlanamamisSiparisler.php' || $_GET['f'] == 'tumSiparisler.php') {

    $korumaIcerik = array(
        array(
            intab => 'diger',
            isim => 'Koruma Aktif',
            db => 'koruma',
            stil => 'checkbox',
            width => 53,
            gerekli => '0'
        )

    );
    $icerik = array_merge($icerik, $korumaIcerik);
}

if (!$_GET['ID'] && $_GET['y'] != 'e') {
    $preBlock .=  '<div id="siparis-arama-container">' . v5Admin::fullBlock('
                    <span class="cursor-pointer" onclick="$(\'#siparis-arama-ac\').click()">Sipariş Arama</span>
                    <div class="form-check form-switch mb-2 float-right">
                        <input class="form-check-input" type="checkbox" id="siparis-arama-ac" '.($_SESSION['cf_siparis-arama-ac']?'checked="checked"':'').'>
                   </div>', v4Admin::siparisAramaForm(), ($_SESSION['cf_siparis-arama-ac']?'':'mfp-hide ').'siparis-arama') . '</div>';
    if ($_POST['siparis-arama-post'])
        $preBlock .=  '<script type="text/javascript">$(\'#siparis-arama-ac\').click();</script>';
}

if ($_POST['ID'] && $_POST['y'] == 'du') {
    if (!$_POST['kargoURL']) {
        $_POST['kargoURL'] = hq("select kargoURL from siparis where ID='" . $_POST['ID'] . "'");
    }
    if (!$_POST['kargoSeriNo']) {
        $_POST['kargoSeriNo'] = hq("select kargoSeriNo from siparis where ID='" . $_POST['ID'] . "'");
    }
    if (!$_POST['kargoDurum']) {
        $_POST['kargoDurum'] = hq("select kargoDurum from siparis where ID='" . $_POST['ID'] . "'");
    }
}

$siparisID = hq("select randStr from siparis where ID='" . $_GET['ID'] . "'");
if ($_GET['y'] == 'd' && $siparisID) {
    
    siparisFix($siparisID);
    $durum = hq("select durum from siparis where ID='" . $_GET['ID'] . "'");
    $tarih = hq("select tarih from siparis where ID='" . $_GET['ID'] . "'");
    $userID = hq("select userID from siparis where ID='" . $_GET['ID'] . "'");
    $affID = hq("select affID from siparis where ID='" . $_GET['ID'] . "'");
    if ($affID)
        $sepetDetay .= '<h3>Referrer : ' . hq("select concat(name,' ',lastname,' (',email,')') from siparis where ID='" . $affID . "'") . '</h3>';
    $sepetDetay .= '<div class="adminBasket">' . showBasket(false, $siparisID, true) . '<div style="clear:both;"></div></div>';
    $kargoDurum = apiKargoDurum($siparisID, 'durum');
    $takipURL = hq("select kargoURL from siparis where ID='" . $_GET['ID'] . "'");
    if ($kargoDurum) {
        $sepetDetay .= '<h3><strong>Kargo Durum :</strong> </h3><h5>' . $kargoDurum . '</h5><hr/>' . apiKargoDurum($siparisID, 'hareket') . '<hr />';
    }
    if ($takipURL) {
        $sepetDetay .= '<h5><strong>Takip URL :</strong> <a target="_blank" href="' . $takipURL . '">' . $takipURL . '</a></h5><hr />';
    }
    $x = my_mysql_query("select * from bankaHavaleBildirim where siparisNo = '$siparisID' group by bankaID");
    if (my_mysql_num_rows($x)) {
        $sepetDetay .=  '<br><div style="margin-left:-2px;">';
        while ($d = my_mysql_fetch_array($x)) {
            $bInfoQry = my_mysql_query("select * from bankaHavale where ID='" . $d['bankaID'] . "'");
            $bInfo = my_mysql_fetch_array($bInfoQry);
            $tempInfo .= adminInfov5('Bu siparis icin <b>' . $bInfo['bankaAdi'] . ' - (' . $bInfo['bankaSubeKodu'] . ') ' . $bInfo['bankaHesapNo'] . ' - ' . $bInfo['bankaKullaniciAdi'] . '</b> hesabina havale bildiriminde bulunulmustur.');
        }
        $sepetDetay .=  '</div>';
    }

    $firmaID = hq("select kargoFirma from siparis where ID = '" . $_GET['ID'] . "'");
    if (siteConfig('kargo_arasUsername') && $durum > 50 && $durum < 90 && (int)$firmaID == (int)siteConfig('kargo_arasID')) {
        $arasKargoBarkod = arasKargoBarkod($siparisID);
        if (!$_GET['barcode'])
            $sepetDetay .= $arasKargoBarkod;
        else
            exit($arasKargoBarkod);
    }
    if ($durum == '2')
        $tempInfo .= adminWarnv5('Gelen ödemeler, ilgili pos firmasının ödemeler panelinden teyit edilmelidir.');
    if ($userID) {
        $tempInfo .= adminInfov5('<strong>' . hq("select concat(name,' ',lastname,' (',username,')') from user where ID='$userID'") . '</strong> bugüne kadar toplam <strong>' . (int)hq("select sum(adet) from sepet where userID='" . $userID . "' AND durum > 0 AND durum < 90") . '</strong> ürün satın aldı.<br /> Sepet bazında görüntülemek için <a target="_blank" href="s.php?f=sepet.php&userID=' . $userID . '"><strong>tıklayın</strong></a>.<br />Ürün bazında görüntülemek için <a target="_blank" href="s.php?f=sepetToplam.php&userID=' . $userID . '"><strong>tıklayın</strong></a>.','user');
        $tempInfo .= adminInfov5('Bu kullanıcın bugüne kadar <strong>' . my_money_format('', hq("select sum(toplamTutarTL) from siparis where userID='" . $userID . "' AND durum > 0 AND durum < 90")) . ' TL</strong> tutarında toplam <strong>' . (int)hq("select count(*) from siparis where userID='" . $userID . "' AND durum > 0 AND durum < 90") . '</strong> siparişi var.<br /> Siparişlerini görüntülemek için <a target="_blank" href="s.php?f=tumSiparisler.php&userID=' . $userID . '"><strong>tıklayın</strong></a>.','user');
        $yoneticiNotu = hq("select notYonetici from user where ID='$userID'");
        if ($yoneticiNotu)
            $tempInfo .= adminInfov5('<strong>Kullanıcı için Yönetici Notu :</strong> ' . $yoneticiNotu,'-');
    }
    //$sepetDetay.='<div style="clear:both;">&nbsp;</div><img src="../include/3rdparty/barcode.php?randStr='.$siparisID.'">';
    $sepetDetay .= '<div style="float:right">';
    $sepetDetay .= v5Admin::simpleButtonWithImage('s.php?f=sepet.php&randStr=' . $siparisID . '&durum=' . $durum, "", 'cart', 'Sepeti Düzenle', 'primary');


    $tel = str_replace(array(' ', '-', '+', '(', ')'), '', hq("select ceptel from siparis where ID='" . $_GET['ID'] . "'"));
    if ($tel) {
        $telPrefix = '9' . (substr($tel, 0, 1) == '0' ? '' : '0');
        $sepetDetay .= v5Admin::simpleButtonWithImage('#', "window.open('https://api.whatsapp.com/send?phone=" . $telPrefix . $tel . "')", 'mobile', 'WhatsApp Mesaj', 'success');
    }
    $sepetDetay .= v5Admin::simpleButtonWithImage('#', "window.open('kargo.php?sipNo=" . $siparisID . "','_blank','width=600,height=600,scrollbars=1')", 'barcode', 'Kargo Barkod', 'danger');
    $sepetDetay .= v5Admin::simpleButtonWithImage('#', "window.open('yazdir.php?sipNo=" . $siparisID . "','_blank','width=1024,height=768,scrollbars=1')", 'printer', 'Sipariş Detayları', 'danger');
    if (file_exists('fatura.php'))
        $sepetDetay .= v5Admin::simpleButtonWithImage('#', "window.open('fatura.php?sipNo=" . $siparisID . "&yazdir=1','_blank','width=900,height=600,scrollbars=1')", 'receipt', 'Fatura', 'danger');
    if (file_exists('fatura.php'))
        $sepetDetay .= v5Admin::simpleButtonWithImage('#', "window.open('fatura.php?sipNo=" . $siparisID . "&yazdir=1&type=irsaliye','_blank','width=900,height=600,scrollbars=1')", 'receipt', 'İrsaliye', 'danger');
    $sepetDetay .= v5Admin::simpleButtonWithImage('#', "window.open('sozlesme.php?sipNo=" . $siparisID . "&yazdir=1','_blank','width=900,height=600,scrollbars=1')", 'align-justify', 'Sipariş Sözleşmesi', 'secondary');
    $sepetDetay .= '</div>';


    /* Trenyol Kargo İçin : BAŞLA */
    if (hq("select ID from siparis where randStr like 'TY-%' AND ID='" . $_GET['ID'] . "'")) {
        $sepetDetay .= '<div style="float:left; clear:both;">';
        $sepetDetay .= v5Admin::simpleButtonWithImage('s.php?f=' . $_GET['f'] . '&y=d&ID=' . $_GET['ID'] . '&trendyol=1', "", 'btn-warning', '<i class="fa fa-truck"></i> Trendyol Kargo Gönder', 'warning');
        $sepetDetay . '</div>';
    }

    if ($_GET['trendyol']) {
        $pID = hq("select data1 from siparis where ID='" . $_GET['ID'] . "'");
        $kargoSeriNo = hq("select kargoSeriNo from siparis where ID='" . $_GET['ID'] . "'");
        if ($pID && $kargoSeriNo) {
            include_once '../include/mod_Trendyol.php';
            $ty = new Trendyol();
            $return = $ty->updateTrackingNumber($pID, $kargoSeriNo);
            $tempInfo .= adminInfov5('Trendyol Kargo Debug : ' . debugArray($return));
        } else {
            if (!$kargoSeriNo) {
                $tempInfo .= adminErrorv3('Lütfen önce kargo takip numaranızı kaydedin.');
            }
        }
    }

    /* Trenyol Kargo İçin : BİTİR */
    $preBlock .= v5Admin::simpleBlock('', $tempInfo);
    $preBlock .= v5Admin::simpleBlock($siparisID . ' Sipariş Numaralı Sepet Detayları', $sepetDetay);
    // $tempInfo.= $sepetDetay.'<div class="clear"></div>';
    $tempInfo = '';
    $uploadedFiles = scandir('../images/upload/');
    foreach ($uploadedFiles as $x) {
        if (substr($x, 0, 10) == $siparisID . '-') {
            list($r, $u, $s) = explode('-', $x);
            list($s) = explode('__', $s);
            $s = ucfirst(str_replace('_', ' ', $s));
            $uploadedFile .= '<div class="st-form-line">Ürün ID (' . hq("select name from urun where ID='$u'") . ') : <a href="../' . urunLink((int)$u) . '">' . $u . '</a> - <strong>' . $s . '</strong> : <a href="../images/upload/' . $x . '" target="_blank">' . $x . '</a></div>';
        }
    }
    list($t, $s) = explode(' ', $tarih);
    list($y, $a, $g) = explode('-', $t);
    $uploadedFilesDate = @scandir('../images/upload/' . $y . '/' . $a . '/' . $g . '/');
    foreach ($uploadedFilesDate as $x) {
        if (substr($x, 0, 10) == $siparisID . '-') {
            list($r, $u, $s) = explode('-', $x);
            list($s) = explode('__', $s);
            $s = ucfirst(str_replace('_', ' ', $s));
            if (hq("select ID from sepet where randStr = '$siparisID' AND urunID='$u' AND durum > 0 AND adet > 0"))
                $uploadedFile .= '<div class="st-form-line">Ürün ID (' . hq("select name from urun where ID='$u'") . ') : <a href="../' . urunLink((int)$u) . '">' . $u . '</a> - <strong>' . $s . '</strong> : <a href="../images/upload/' . $x . '" target="_blank">' . $x . '</a></div>';
        }
    }
    if ($uploadedFile) {
        $tempInfo .= v5Admin::simpleBlock($siparisID . ' Sipariş Numaralı için Dosya Yükleme Detayları', $uploadedFile);
    }
    $tempInfo .= $postITResponse;
    if (!$_SESSION['cache_kargo_hareket_' . $siparisID]) {
        $_SESSION['cache_kargo_hareket_' . $siparisID] = apiKargoDurum($siparisID, 'hareket');
        $_SESSION['cache_kargo_durum_' . $siparisID] = apiKargoDurum($siparisID, 'durum');
    }
    if ($_SESSION['cache_kargo_' . $siparisID])
        $tempInfo .= v5Admin::simpleBlock($siparisID . ' Sipariş Numaralı Kargo Hareketleri - ' . $_SESSION['cache_kargo_durum_' . $siparisID], $_SESSION['cache_kargo_hareket_' . $siparisID]);
}

if ($_POST['kargoSeriNo'] && !$_POST['kargoURL']) {
    $prefixURL = hq("select prefixURL from kargofirma where ID='" . $_POST['kargoFirma'] . "'");
    if ($prefixURL)
        $_POST['kargoURL'] = $prefixURL . $_POST['kargoSeriNo'];
}

if (($oncekiDurum == 1 || $oncekiDurum == 2) && ($status != 1 && $status != 2 && $status < 90)) {
    if (my_mysql_num_rows(my_mysql_query("select * from sepet where randStr = '" . $randStr . "' AND serialNo = ''"))) {
        if ($SerialZorunlu) {
            $status = $oncekiDurum;
            $tempInfo .= adminInfov5('Lütfen önce gönderdiğiniz <strong>ürünlerin serial numaralarını</strong> ekleyin. <a href="s.php?f=serial&sipNo=' . $randStr . '">Serial Girişi için tıklayın</a>.');
        }
    }
}

if ($_GET['y'] == 'd' || $_GET['y'] == 'e') {

    $adminTabs[0] = array('genel', 'fa-shopping-cart', 'Genel Bilgiler');
    $adminTabs[1] = array('adres', 'fa-user', 'Adres / İletişim Bilgileri');
    $adminTabs[2] = array('odeme', 'fa-credit-card', 'Ödeme');
    $adminTabs[3] = array('kargo', 'fa-truck', 'Kargo');
    $adminTabs[100] = array('diger', 'fa-puzzle-piece', 'Diğer');
    ksort($adminTabs);
    $tempInfo .= v5Admin::generateTabMenu($adminTabs, $icerik, $dbase);
}

if ($_GET['ID']) {
    if (!$_SESSION['admin_isAdmin'] && !hq("select ID from userGroups where sipUserID = '" . $_SESSION['admin_UserID'] . "' AND ID='" . userGroupID(hq("select userID from siparis where ID='" . $_GET['ID'] . "'")) . "'"))
        $stop = 1;
}
if ($stop)
    echo adminInfov5('Bu siparişi görüntüleme yetkiniz bulunmamaktadır.');

if (!$_GET['y']) {
    $tempInfo .= '<div class="float-left">'.v5Admin::simpleButtonWithImage('siparis.php', '', 'download', 'Listenin Excel Raporunu İndir', 'primary') . '</div><div class="clear">&nbsp;</div>';
}
if (!$stop) {
    if ($_POST['durum'] && $_POST['ID'])
        adminLog($_POST, array('durum'), $dbase, $_POST['ID']);
    changeOrderStatus($_POST['ID'], $_POST['durum']);
    $listTitle = $title = '';
    admin($dbase, $where, $icerik, $ozellikler);
}

$orderDialogBodyOptions = '';
$q = my_mysql_query("select * from odemeDurum order by ID asc");
while ($d = my_mysql_fetch_array($q)) {
    $orderDialogBodyOptions.="<option value='" . $d['ID'] . "'>" . $d['title'] . '</option>' . "\n";
}

echo v5Admin::simpleModal('order-dialog-form','Sipariş Durumları','Toplu olarak güncellenecek <strong id="siparisSecimAdet"></strong> adet siparişin durum bilgisini seçin.<br /><br />
<select id="setAllDurum" class="form-select">
    <option>Sipariş Durumları</option>
    '.$orderDialogBodyOptions.'
</select>','<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button><button onclick="setAllOrderStatus();" type="button" class="btn btn-primary">Kaydet</button>')
?>
<script>
    window.addEventListener("load", (event) => { 
        var setOrderPrefixURL = 's.php?f=<?= $_GET['f'] ?>&setOrders=true&';
        $('select[name=kargoFirma]').change(
            function() {
                setKargoApiForm('<?= $_GET['ID'] ?>', this);
            }
        );
        <?= ($_GET['ID'] ? 'setKargoApiForm(\'' . $_GET['ID'] . '\',$(\'select[name=kargoFirma]\'));' : '') ?>
    });

</script>
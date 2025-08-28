<?php include('include/all.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php echo generateTemplateHead(); ?>
</head>

<body style="margin:3px;" class="popupbody">
    <style type="text/css">
        body {
            font-family: "Open Sans", sans-serif;
        }
    </style>
    <?php
    switch ($_GET['act']) {
        case "taksitlerim":
            $out = '<link rel="stylesheet" href="css/popup.cc.css" />';
            $q = my_mysql_query("select * from banka where ID='" . $_GET['bankaID'] . "'");
            $d = my_mysql_fetch_array($q);
            $v = my_mysql_query("select * from bankaVade where bankaID='" . $_GET['bankaID'] . "' order by ay");
            $d['taksitSayisi'] = (my_mysql_num_rows($v) + 1);

            $qu = my_mysql_query("select * from urun where ID='" . $_GET['urunID'] . "'");
            $du = my_mysql_fetch_array($qu);
            $du['fiyat'] = fixFiyat($du['fiyat'], 0, $du['ID']);
            $du['fiyat'] = YTLfiyat($du['fiyat'], $du['fiyatBirim']);
            // $pesinFiyatinaTaksitOrani = dbinfo('urun','pesinTaksitOrani',$_GET['urunID']);
            $out .= '<div class="' . $d['taksitGosterimCSS'] . 'taksitDiv">';
            $out .= '<table cellspacing=1 cellpadding=0 width=100%>';
            $out .= '<tr>';
            $out .= '<td colspan="3" valign=top class="taksitTopHeader">' . $d['taksitGosterimBaslik'] . '</td></tr>';
            $out .= '<tr><td class="taksitHeaderEmpty"></td><td class="taksitHeader">taksit tutarı</td><td class="taksitHeader">toplam</td></tr>';
            //$out.='<tr height=2><td></td></tr>';
            while ($vade = my_mysql_fetch_array($v)) {
                if (!$vade['ay']) continue;
                $i = $vade['ay'];
                $toplamFaiz = $pesinFiyatinaTaksitOrani >= $vade['vade'] ? 0 : $vade['vade'];
                $toplamOdenecek = (($toplamFaiz + 1) * $du['fiyat']);
                $taksit = ($i == 1 ? '' : ($toplamOdenecek / $i));
                $pesinFiyatina = ($toplamOdenecek == $du['fiyat'] ? true : false);
                $trClass = ($pesinFiyatina ? 'class="pesin"' : '');

                $out .= "<tr $trClass><td class='td1'>" . ($i == 1 ? 'Peşin' : $i) . "</td>";
                $out .= "<td class='td2'>" . ($taksit ? my_money_format('%i', $taksit) . ' TL' : '-') . "</td>";
                $out .= "<td class='td3'>" . my_money_format('%i', $toplamOdenecek) . " TL</td>";
                $out .= '</tr>';
                if ($i != $d['taksitSayisi']) $out2 .= '<tr height=2><td></td></tr>';
            }


            for ($i = 1; $i <= $d['taksitSayisi']; $i++) {
                // $toplamFaiz = ($i * $d['taksitOrani']);

            }
            $out .= '</table>';
            $out .= '</div>';
            $out .= "<div class='close'><table onClick='window.close()' style='cursor:pointer;'><tr><td>" . textBox('#dddddd', 'white', 9, 'x') . "</td><td style='color:#dddddd;'><b>kapat</b></td></tr></table></div>";
            break;
        case 'arkadasimaGonder':
            if (!$_SESSION['MailSended']) $_SESSION['MailSended'] = 1;
            if (!$_POST['data_name']) {
                $form[] = array("Adınız", "name", "TEXTBOX", 1);
                $form[] = array("E-Posta Adresiniz", "mail", "TEXTBOX", 1);
                $form[] = array("Arkadaşınızın Adı", "fname", "TEXTBOX", 1);
                $form[] = array("Arkadaşınızın<br>E-Posta Adresi", "fmail", "TEXTBOX", 1);
                $form[] = array("Mesajınız", "message", "TEXTAREA", 1);
                $out .= '<img src="images/spacer.gif" height=5 width=1><br>';
                $out .= generateTableBox('Ürünü Tavsiye Edin', '<div style="color:#555;">' . generateForm($form, '', '', '') . '</div>', tempConfig('popup'));
            } else {
                if ($_SESSION['MailSended'] <= 15) {
                    $mail = getMailTemplate(5);
                    $replace['ARKADAS_ADI'] = $_POST['data_name'];
                    $replace['ALICI_ADI'] = $_POST['data_fname'];
                    $replace['ALICI_EPOSTA'] = $_POST['data_fmail'];
                    $replace['GONDEREN_ADI'] = $_POST['data_name'];
                    $replace['GONDEREN_EPOSTA'] = $_POST['data_mail'];
                    $replace['MESAJ'] = $_POST['data_message'];
                    $link = 'http://' . $_SERVER['HTTP_HOST'] . '/' . str_replace('popup.php', 'page.php', $_SERVER['PHP_SELF']);
                    $link .= '?act=urunDetay&urunID=' . $_GET['urunID'];
                    $replace['URUN_LINK'] = $link;
                    $replace['URUN_ADI'] = dbInfo('urun', 'name', $_GET['urunID']);
                    $replace['KATEGORI_ADI'] = dbInfo('kategori', 'name', dbInfo('urun', 'catID', $_GET['urunID']));
                    $mail['body'] = getEmailEncode() . mergeText($mail['body'], $replace);
                    $mail['title'] = mergeText($mail['title'], $replace);
                    my_mail($_POST['data_fmail'], $mail['title'], $mail['body'], getHeaders($mail['mail']));
                    $out = '<div class="success"><center><br><br>E-Posta gönderildi. Ürünümüzü tavsiye ettiğiniz için teşekkür ederiz.. </center><br><br></div>';
                    $_SESSION['MailSended']++;
                } else {
                    $out = '<div class="success"><center><br><br>Güvenlik nedeniyle 5 defadan fazla ürün tavsiyesine izin verilmemektedir. </center><br><br></div>';
                }
            }
            $out .= "<div class='close'><table onClick='window.close()' style='cursor:pointer;'><tr><td>" . textBox('#dddddd', 'white', 9, 'x') . "</td><td style='color:#dddddd;'><b>kapat</b></td></tr></table></div>";
            break;
        case 'urunDetay':
            $out = '<link rel="stylesheet" href="css/hizlidetay.css" />';
            $out .= showItem($_GET['urunID'], '../../system/default/UrunGosterHizli');
            break;
    }
    echo $out;
    ?>
</body>

</html> 
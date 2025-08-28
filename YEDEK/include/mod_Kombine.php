<?php
function kombineView()
{
    global $langPrefix;
    $css = '<style>
    .combine-row {display: flex;flex-wrap: wrap;}
    .kombinsec { width:17px;  height:17px; }
    .stokta-yok { opacity:0.5;  pointer-events: none; }
    .col-left {flex: 0 0;}

    td.pr-15 { padding-right:15px; }

    .col-left .product-images {
        position: sticky;
        top: 0px;
        min-width:300px;
    }

    .col-right {
        flex: 1;
        padding-left: 5%;
    }


    .group-product-list #kombine-table {
        width: 100%;
        margin-bottom: 15px;
        border-top: 1px dotted #e5e5e5;
    }
    .group-product-list #kombine-table > tbody > tr > td {
        font-weight: 500;
        padding: 10px 10px 10px 0;
        border-width: 0 0 1px 0;
        border-style: dotted;
        border-color: #e5e5e5;
        background-color: transparent;
    }
    .group-product-list #kombine-table tbody tr td.quantity {
        font-size: 13px;
        color: #333;
    }

    .kombinlist .thumb {
        position: relative;
    }
    .kombinlist #kombine-table tbody tr td.thumb {
        width: 90px;
    }
    .kombinlist #kombine-table tbody tr td.thumb img {
        width: 100%;
    }

    .kombinlist .urunegit {
        position: absolute;
        bottom: 5px;
        left: 0;
        right: 0;
        font-size: 10px;
        background-color: rgb(255 255 255/79%);
        z-index: 5;
        padding: 5px 10px 5px 0px;
        text-align: center;
        color: #333;
    }
    .group-product-list #kombine-table tbody tr td.title {
        font-size: 16px;
        font-weight: 500;
    }
    .group-product-list #kombine-table tbody tr td.price {
        padding-right: 0;
    }
    .group-product-list #kombine-table tbody tr td.price .pro-price {
        display: block;
        text-align: right;
    }
    .group-product-list #kombine-table tbody tr td.price .pro-price span {
        font-size: 16px;
        font-weight: 700;
        color: #333;
    }
    .group-product-list #kombine-table tbody tr td.price .pro-price span.old {
        font-size: 13px;
        margin-right: 5px;
        text-decoration: line-through;
        opacity: .5;
        display:block;
    }

    .clearfix {
        clear: both;
    }

    .yazibilgi {
        border-top: 1px solid #eaeaea;
        border-bottom: 1px solid #eaeaea;
        font-size: 17px;
        padding: 10px 0px;
        display: inline-block;
        width: 100%;
        clear: both;
    }
    .yazibilgi .kombinislem {
        float: right;
    }

    .yazibilgi .kombinislem1 {
        float: left;
    }

    .product-buttons .btn {
        border-color: #333 !important;
        background-color: #333 !important;
        color: #fff !important;

        margin-bottom: 10px;
        padding: 15px 40px;
        text-align: center;
        white-space: nowrap;
        display: block;
    }

    @media only screen and (max-width: 968px) {

        .col-right ,.col-left{
            flex: 1 1 100%;
            padding-left: 0px;
        }
        .group-product-list #kombine-table tbody tr td.price {
            padding-right: 0;
            float: left;
        }
        .group-product-list #kombine-table tbody tr td.title {
            font-size: 16px;
            font-weight: 500;
            display: block;
            float: left;
        }
        .group-product-list #kombine-table tbody tr td.price .pro-price {
            display: block;
            text-align: left;
        }
        .col-left .product-images img {
            width: 100%;
        }
        .yazibilgi .kombinislem b {
            padding-left: 3.5px;
        }

        .yazibilgi .kombinislem {
            float: left;
            display: flex;
            align-items: center;
            font-size: 18px;
        }
    }

    </style>';
    $js = '<script>
                function kombineGuncelle()
                {
                    var Secilenler = 0;
                    var sec = 0;
                    $(\'.kombinlist .kombinsec:checked\').each(function () {
                        var fiyat = $(this).attr("fiyat");
                        var fiyatv = 0;
                        if($(this).parent().parent().find("select.urunSecim:last option:selected").length)
                            fiyatv = parseFloat($(this).parent().parent().find("select.urunSecim:last option:selected").attr("fiyat"));
 
                        if(fiyatv)
                            fiyat=fiyatv;
                        Secilenler = (Number(Secilenler + Number(fiyat)));
                        sec = sec + 1;
                    });
                    $(".kombinislem1").html("Bu Kombinden <b>" + sec + "</b> adet ürün seçtiniz");
                    $(".kombinislem").html("Seçimleriniz toplamı: <br/><b>" + parseFloat(Secilenler).toFixed(2) + " TL</b>");
                }
                $(".kombinsec").click(kombineGuncelle);
                $("select.urunSecim").change(kombineGuncelle);

                $(".urunSecim").addClass("sf-form-select").css("margin-right","15px");

                function topluSepeteEkle()
                {
                    $(".kombinsec:checked").each(
                        function()
                        {
                            var urunID = $(this).attr("id").replace("sec","");
                            var secimURL = "";
                            for (i = 1; i <= 50; i++) {
                                if($("select[name=kombine_"+urunID+"_ozellik"+i+"detay]").length && !$("select[name=kombine_"+urunID+"_ozellik"+i+"detay]").val())
                                {
                                    myalert(lang_urunVarSecim, "warning");
                                    return;
                                }
                                if ($("select[name=kombine_"+urunID+"_ozellik"+i+"detay]").length)
                                  secimURL +=
                                  "&ozellik" +
                                  i +
                                  "detay=" +
                                  encodeURIComponent($("select[name=kombine_"+urunID+"_ozellik"+i+"detay]").val());
                              }

                              var url =
                            "include/ajaxLib.php?ajax=1&act=sepetEkle&urunID=" +
                            encodeURIComponent(urunID) +
                            "&adet=1&" +
                            secimURL;
                            $.get(url, function (data) {
                                sepetHTMLGuncelle("");
                            });
                            
                        }
                    );
                    if(!$(".drawer--is-visible").length)
                        document.querySelector(".imgSepetGoster,#imgSepetGoster").click();
                }
                </script>';
    $qk = my_mysql_query("select * from kombine where ID='".(int)$_GET['ID']."'");
    $dk = my_mysql_fetch_array($qk);

    $urunIDs = explode(',',$dk['urunIDs']);
    $pout = '';
    foreach($urunIDs as $urunID)
    {
        $q = my_mysql_query("select * from urun where ID='".(int)$urunID."'");
        $d = my_mysql_fetch_array($q);
        if(!$d['active'])
            continue;

        $fiyat = mf(ytlFiyat(fixFiyat($d['fiyat'], $_SESSION['userID'], $d), $d['fiyatBirim']));

        $pvar = '<table><tr>';
			
			for ($i = 1; $i <= 10; $i++) {
				if ($d['varID' . $i]) {
					$pvar .= '<td class="UrunSecenekleriHeader pr-15">' . hq("select ozellik$langPrefix from var where ID='" . $d['varID' . $i] . "'") . '<br />' . generateItemOptions($d, $i, '', 'kombine_'.$d['ID'].'_') . '</td>';
				}
			}
			
			$pvar.='</tr></table>';

        $pout.='<tr class="'.($d['stok']?'':'stokta-yok').'">
                    <td class="choose"><input type="checkbox" class="form-control kombinsec"  name="veriid[]" id="sec'.$d['ID'].'" fiyat="'.$fiyat.'" value="1471"></td>
                    <td class="quantity"></td>
                    <td class="thumb">
                        <img src="include/resize.php?path=images/urunler/'.$d['resim'].'&width=200" alt="'.str_replace('"','-',$d['name']).'">
                        <a href="'.urunLink($d).'" class="urunegit">'.lc('_lang_uruneGit','Ürüne Git').'</a>
                    </td>
                    <td class="title">
                        '.$d['name'].'
                        '.($d['stok']?'<br />'.$pvar:'<br /><h5>'._lang_stokYokUyari.'</h5>').'
                    </td>
                    <td class="price">
                        <span class="pro-price">
                            '.($d['piyasafiyat']?'<span class="old">'.ytlFiyat($d['piyasafiyat'], $d['fiyatBirim']).' '.fiyatBirim('TL').'</span>':'').'
                            <span class="new fiyatss1471" itemprop="price"> '.$fiyat.' '.fiyatBirim('TL').'</span> </span>
                    </td>
                </tr>';
    }
    $out = '
    <div class="combine-row">
        <div class="col-left">
            <div class="product-images">
                <img src="include/resize.php?path=images/kombine/'.$dk['resim'].'" alt="">
            </div>
        </div>
        <div class="col-right">
            <div class="product-summery">
                <form action="" method="post" name="urunsepeteat" id="urunsepetform" class1="product-form">
                    <div class="group-product-list kombinlist">
                        <table id="kombine-table">
                            <tbody>
                                '.$pout.'
                            </tbody>
                        </table>

                        <div class="clearfix yazibilgi mb10">
                            <div class="kombinislem1">Bu Kombinden <b>0</b> adet ürün seçtiniz</div>
                            <div class="kombinislem">Seçimleriniz toplamı: <br><b>0  TL</b></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="product-buttons">
                            <a href="#" id="addToCartButton" onclick="topluSepeteEkle()" class="btn btn-dark btn-outline-hover-dark kombinsepeteat add-to-cart" rel="13"><i class="fa fa-shopping-cart"></i> Sepete Ekle</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>';
    return $css.$out.$js;
}

function kombineLink($d)
{
    if (function_exists('myKombineLink')) {
        return myKombineLink($d);
    }
    global $langPrefix;
    $d = translateArr($d);
    $name = $d['tanim' . $langPrefix];
    $seoName = $d['seo' . $langPrefix];
    if(!$seoName)
    {
        $seoName = seoFix($name);
        my_mysql_query("update kombine set seo$langPrefix = '$seoName' where seo$langPrefix ='' AND ID='".$d['ID']."' limit 1");
    }
    return generateLink(siteConfig('seoURL') ? 'ac/kombine/' . $seoName : 'page.php?act=kombine&ID=' . $d['ID'] . '&name=' . $seoName);
}


function kombineTitle()
{
    return hq("select tanim from kombine where ID='".$_GET['ID']."'");
}

function kombineList($temp = '../../system/default/UrunListView')
{
    global $siteDizini;
    $out = '';

    $q = my_mysql_query("select * from kombine order by seq,tanim");
    while ($d = my_mysql_fetch_array($q)) {
        $d = translateArr($d);

        $contents = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '' . $siteDizini . 'templates/' . siteConfig('templateName') . '/systemDefault/' . $temp . '.php');
            $d['fiyat'] = kombineTutar($d,'fiyat');
            $d['piyasafiyat'] = kombineTutar($d,'piyasafiyat');
            $d['fiyatBirim'] = 'TL';
            $d['name'] = $d['tanim'];
        if(!$d['fiyat'])
            continue;
        $contents = str_replace(
                array('{%URUN_DETAY_LINK%}','{%URUN_FIYAT%}','{%URUN_PIYASA_FIYAT%}','{%func-data_indirimOranView%}'),
                array(kombineLink($d),urunFiyat($d,'fiyat'),urunFiyat($d,'piyasafiyat'),indirimOranView($d)),
                $contents);  
        $contents = urunTemplateReplace($d, $contents);
        $contents = str_replace(
                array('images/urunler/'),
                array('images/kombine/'),
                $contents);
        $out .= $contents;
    }
    return $out;
}

function kombineTutar($d,$field)
{
    if (siteConfig('fiyatUyelikZorunlu') && !$_SESSION['userID']) {
        return _lang_fiyatIcinUyeGirisiYapin;
    }
    $out = 0;
    $listArray = explode(',', $d['urunIDs']);
    $filter = '';
    foreach ($listArray as $listFilter) {
        if ($listFilter) {
            $filter .= 'ID = \'' . $listFilter . '\' OR ';
        }
    }
    $filter .= ' ID=0 ';
    $query = 'select * from urun where active = 1 AND (' . $filter . ')';

    $q2 = my_mysql_query($query);
    while ($d2 = my_mysql_fetch_array($q2)) {
        if($field == 'fiyat')
            $out += ytlFiyat(fixFiyat($d2['fiyat'], $_SESSION['userID'], $d2), $d2['fiyatBirim']);
        else
            $out += ytlFiyat($d2[$field], $d2['fiyatBirim']);
    }
   
    return $out;
}
?>
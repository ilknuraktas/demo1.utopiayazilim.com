var xmldilim = 10;



function setCookie(name, value, days) {

    var expires = "";

    if (days) {

        var date = new Date();

        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);

        expires = "; expires=" + date.toUTCString();

    }

    document.cookie = name + "=" + (value || "") + expires + "; path=/";

}



function getCookie(name) {

    var nameEQ = name + "=";

    var ca = document.cookie.split(";");

    for (var i = 0; i < ca.length; i++) {

        var c = ca[i];

        while (c.charAt(0) == " ") c = c.substring(1, c.length);

        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);

    }

    return null;

}



function eraseCookie(name) {

    document.cookie = name + "=; Max-Age=-99999999;";

}



function randomString(string_length) {

    var chars = "0123456789";

    // var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";

    var randomstring = "";

    for (var i = 0; i < string_length; i++) {

        var rnum = Math.floor(Math.random() * chars.length);

        randomstring += chars.substring(rnum, rnum + 1);

    }

    return randomstring;

}



function removeFile(dbase, field, dbID, filePath, spanID, obj) {



    Swal.fire({

        text: "Dosya hem veritabanından hemde diskden silinecek. Emin misiniz?",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Evet',

        cancelButtonText: 'Hayır',

        customClass: {

            confirmButton: 'btn btn-primary me-3',

            cancelButton: 'btn btn-label-secondary'

        },

        buttonsStyling: false

    }).then(function(result) {

        if (result.value) {

            $.get(

                "./removeFile.php?dbName=" +

                dbase +

                "&dbField=" +

                field +

                "&dbID=" +

                dbID +

                "&filePath=" +

                filePath,

                function(data) {

                    notify('', 'Dosya Silindi!', 'success')

                    $(obj)

                        .parent()

                        .find(".fileupload-preview,button")

                        .css({

                            'opacity': '0.5',

                            'pointer-events': 'none'

                        });

                }

            );

            return false;

        }

    });

    return false;

}



var orderIDs = '';



function setSPOrder(ids) {

    if (!ids) {

        notify('', 'Lütfen önce siparişleri seçin.', 'error');

        return;

    }

    orderIDs = ids;

    $('#order-dialog-form').modal('show');

    $('#siparisSecimAdet').html(ids.split('&').length - 1);

    /*

    $.magnificPopup.open({

        items: {

            src: '#order-dialog-form',

        },

      preloader: false,

      modal: false,

        type: 'inline'

    });

    */

    //alert(ids);

}



function setAllOrderStatus() {

    //$.magnificPopup.close();

    window.location.href = setOrderPrefixURL + 'orderStatusID=' + $('#setAllDurum').val() + orderIDs;

}



function resizeFile(dbase, field, dbID, filePath, spanID, obj) {



    Swal.fire({

        text: "İlgili resim azami 1000px en olarak yeniden boyutlandırılıp, var olan resim güncellenecektir. Onaylıyor musunuz?",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Evet',

        cancelButtonText: 'Hayır',

        customClass: {

            confirmButton: 'btn btn-primary me-3',

            cancelButton: 'btn btn-label-secondary'

        },

        buttonsStyling: false

    }).then(function(result) {

        if (result.value) {

            $.get(

                "./resizeFile.php?dbName=" +

                dbase +

                "&dbField=" +

                field +

                "&dbID=" +

                dbID +

                "&filePath=" +

                filePath,

                function(data) {

                    notify('', 'Dosya yeniden boyutlandırıldı.', 'success')

                }

            );

            return false;

        }

    });

    return false;

}



function removeDB(dbase, field, dbID, filePath, spanID, obj) {



    Swal.fire({

        text: "Dosya sadece veritabanından silinecek. Emin misiniz?",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Evet',

        cancelButtonText: 'Hayır',

        customClass: {

            confirmButton: 'btn btn-primary me-3',

            cancelButton: 'btn btn-label-secondary'

        },

        buttonsStyling: false

    }).then(function(result) {

        if (result.value) {

            $.get(

                "./removeFile.php?dbName=" +

                dbase +

                "&dbField=" +

                field +

                "&dbID=" +

                dbID,

                function(data) {

                    notify('', 'İlgili Giriş Boşaltıldı!', 'success');

                    $(obj)

                        .parent()

                        .find(".fileupload-preview,button")

                        .css({

                            'opacity': '0.5',

                            'pointer-events': 'none'

                        });

                }

            );

            return false;

        }

    });

    return false;

}



function randomChars(string_length) {

    // var chars = "0123456789";

    var chars = "0123456789abcdefghiklmnopqrstuvwxyz";

    var randomstring = "";

    for (var i = 0; i < string_length; i++) {

        var rnum = Math.floor(Math.random() * chars.length);

        randomstring += chars.substring(rnum, rnum + 1);

    }

    return randomstring;

}



function setKargoApiForm(id, obj) {

    $(".getAdminKargoApiForm")

        .closest(".form-group")

        .remove();

    if ($(obj).val())

        $.get(

            "ajax.php?act=getAdminKargoApiForm&siparisID=" +

            id +

            "&kargoID=" +

            encodeURIComponent($(obj).val()) +

            "&r=" +

            Math.floor(Math.random() * 99999),

            function(data) {

                $("select[name=kargoFirma]")

                    .closest(".form-group")

                    .after(data);

                if ($('#siparis-kargo button.active').length) $('.getAdminKargoApiForm').parent().parent().parent().show();

                $("[data-toggle=tooltip],[rel=tooltip]").tooltip({

                    container: "body"

                });

            }

        );

}



function kargoApiKayit(siparisID, fields) {

    $.get(

        "ajax.php?act=kargoApiKayit&siparisID=" +

        siparisID +

        "&fields=" +

        encodeURIComponent(fields) +

        "&rand=" +

        randomString(5),

        function(data) {

            $.get(

                "ajax.php?act=kargoApiGonder&siparisID=" +

                siparisID +

                "&rand=" +

                randomString(5),

                function(data) {

                    $("#kargo-sonuc").html(data);

                }

            );

        }

    );

}



function sepetUrunChange(obj, adet) {

    var durum = $(obj).val();

    if (durum == "50" && !adet) {

        Swal.fire({

            text: 'Temin edilemeyen ürün adetini girin',

            input: 'text',

            inputAttributes: {

                autocapitalize: 'off'

            },

            inputPlaceholder: "Eksik Ürün Adeti",

            showCancelButton: true,

            confirmButtonText: 'Gönder',

            cancelButtonText: 'İptal',

            customClass: {

                confirmButton: 'btn btn-primary me-3',

                cancelButton: 'btn btn-label-secondary'

            }

        }).then(({

            value

        }) => {

            if (value && !isNaN(value))

                sepetUrunChange(obj, value);

        });

        return;

    }

    $.ajax({

        url: "ajax.php?act=sepetDurum&lineID=" +

            $(obj).attr("lineID") +

            "&durum=" +

            durum +

            "&adet=" +

            adet +

            "&rand=" +

            randomString(5),

        success: function(data) {

            notify('', "Sepete ait ürün durumu güncellendi.", 'success');

            if (durum == 50) setTimeout(function() {

                window.location.reload();

            }, 1500);

        }

    });

}



function pazarKategori(catID, pID) {

    var go = '';

    if (pID == 1) go = 'ty';

    if (pID == 1) go = 'hb';

    if (pID == 1) go = 'n11';

    if (pID == 1) go = 'gg';

    window.open('s.php?f=kategori.php&y=d&ID=' + catID + '&' + go + '_upload=1');

}



function pazaryeriGuncelle(yer, ID) {

    $('#pop-ID-' + yer + ID).popover('hide');

    var urlx = '../cron-' + yer.toLowerCase() + '.php?ajax=1&urunID=' + ID + '&r=' + randomString(5);

    $.ajax({

        url: urlx,

        success: function(data) {

            data = data.replace('<h1>', '<strong>');

            data = data.replace('</h1>', '</strong>');

            if (data)

                alert2('', data, 'success');

            else

                alert2('', 'Ürün gönderilemedi. Lütfen ürün veya kategori sayfasıdnan göndermeyi deneyin.', 'error');

        }

    });

}



function gridListFinished() {



    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

    const popoverList = popoverTriggerList.map(function(popoverTriggerEl) {

        // added { html: true, sanitize: false } option to render button in content area of popover

        return new bootstrap.Popover(popoverTriggerEl, {

            html: true,

            sanitize: false

        });

    });



    $('.pazaryeri-pop').on('shown.bs.popover', function() {

        var popID = '#pop-row-' + $(this).attr('data-yer') + $(this).attr('data-ID');

        $.ajax({

            url: "ajax.php?act=pazarinfo&p=" + $(this).attr('data-yer') + "&urunID=" + $(this).attr('data-ID') + "&rand=" +

                randomString(5),

            success: function(data) {

                $(popID).html(data);

            }

        });

    })



    $("span.kargo-yazdir").click(function() {

        window.open(

            "kargo.php?sipNo=" + $(this).attr("data"),

            "_blank",

            "width=600,height=600,scrollbars=1"

        );

        return false;

    });

    $("span.fatura-yazdir").click(function() {

        window.open(

            "fatura.php?sipNo=" + $(this).attr("data") + "&yazdir=1",

            "_blank",

            "width=900,height=600,scrollbars=1"

        );

        return false;

    });

    $("span.irsaliye-yazdir").click(function() {

        window.open(

            "fatura.php?sipNo=" + $(this).attr("data") + "&yazdir=1&type=irsaliye",

            "_blank",

            "width=900,height=600,scrollbars=1"

        );

        return false;

    });

    $("span.detay-yazdir").click(function() {

        window.open(

            "yazdir.php?sipNo=" + $(this).attr("data"),

            "_blank",

            "width=1024,height=768,scrollbars=1"

        );

        return false;

    });

    $("span.whatsapp-mesaj").click(function() {

        window.open(

            "https://api.whatsapp.com/send?phone=" + $(this).attr("data"),

            "_blank",

            "width=600,height=600,scrollbars=1"

        );

        return false;

    });

    $("span.sepet-detay").click(function() {

        if (!$(".dynSepet").length)

            showBasketInfo(

                $(this)

                .parent()

                .find(".frow_randStr")

                .text(),

                1

            );

        else $(".dynSepet").remove();

        return false;

    });

    autoImgPopup();

}



function autoImgPopup() {

    return;

    $(".image-popup-no-margins").magnificPopup({

        type: "image",

        closeOnContentClick: true,

        closeBtnInside: false,

        fixedContentPos: true,

        mainClass: "mfp-no-margins mfp-with-zoom", // class to remove default margin from left and right side

        image: {

            verticalFit: true

        },

        zoom: {

            enabled: true,

            duration: 300 // don't foget to change the duration also in CSS

        }

    });

}



function debugCat() {

    if ($("#dosya").val() == "") {

        alert("Lütfen entegrasyon yapacağınız firmayı seçin.");

        return false;

    }

    window.open("s.php?f=XML/xml.php&debug-cat=1&dosya=" + $("#dosya").val());

}



function debugFiyat() {

    if ($("#dosya").val() == "") {

        alert("Lütfen entegrasyon yapacağınız firmayı seçin.");

        return false;

    }

    window.open(

        "s.php?f=XML/xml.php&debug-fiyat=1&kar=" +

        $("#kar").val() +

        "&dosya=" +

        $("#dosya").val()

    );

}



function debugXML() {

    if ($("#dosya").val() == "") {

        alert("Lütfen entegrasyon yapacağınız firmayı seçin.");

        return false;

    }

    if (

        !$("select[name=parentID]").val() ||

        $("select[name=parentID]").val() == 0

    ) {

        if (

            !confirm(

                "Üst kategori seçilmedi. Debug etmek istediğinizden emin misiniz?"

            )

        )

            return false;

    }

    window.open(

        "s.php?f=XML/xml.php&debug-xml=1&dosya=" +

        $("#dosya").val() +

        "&parentID=" +

        $("select[name=parentID]").val()

    );

}







function xmlCatCacheUpdate() {

    //window.open('ajax.php?act=xmlCatCache&dosya='+$('#dosya').val()+'&rand=' + randomString(5));

    $.ajax({

        url: "ajax.php?act=xmlSetXMLDilim&dosya=" +

            encodeURIComponent($("#dosya").val()) +

            "&rand=" +

            randomString(5),

        success: function(data) {

            xmldilim = parseInt(data);

            if (!xmldilim) xmldilim = 10;

        }

    });

    $.ajax({

        url: "ajax.php?act=xmlCatCache&dosya=" +

            encodeURIComponent($("#dosya").val()) +

            "&rand=" +

            randomString(5),

        success: function(data) {

            if (!data) return xmlCatCacheUpdate();

            $(".xmlcatcache").html(data);



            /*

            $(".modal-basic").magnificPopup({

              type: "inline",

              preloader: false,

              modal: true

            });

            */



            $("#treeCheckbox").jstree({

                core: {

                    themes: {

                        responsive: false

                    }

                },

                types: {

                    default: {

                        icon: "fa fa-folder"

                    },

                    file: {

                        icon: "fa fa-file"

                    }

                },

                plugins: ["types", "checkbox"]

            });



            $("a.jstree-anchor").removeAttr("href");



            $(".xmlcatcache div.autoload").click(function() {

                if ($(this).hasClass("autoload")) {

                    var obj = this;

                    $(obj)

                        .parent()

                        .load(

                            "ajax.php?act=xmlSelectCat&catID=" +

                            $(obj)

                            .attr("id")

                            .replace("s_", "")

                        );

                    $(this).removeClass("autoload");

                }

                return false;

            });

        }

    });

}



function xmlUpdate(updateURL, dilim) {

    if (dilim == 0) {

        $("html, body").animate({

            scrollTop: 0

        }, "slow");

        $(".loadingbox").show();

        $(".loader").show();

        $(".form-group:first label").html("Yükleniyor...");

        $(".xmlstats")

            .html("")

            .hide();

        $("#xml-progress-bar")

            .width("1%")

            .attr("aria-valuenow", "5")

            .html("1%");

        // XMLWindow = window.open('xmlViewLog.php?rand=' + randomString(5),'XML','width=800,height=600,scrollbars=1');

        // window.open (updateURL + '&dilim=' + dilim + '&rand=' + randomString(5));

    }

    if (dilim != 0) $("#xmlPer").css("backgroundColor", "green");

    $.ajax({

        url: updateURL + "&dilim=" + dilim + "&rand=" + randomString(5),

        error: function(data, textStatus, errorThrown) {

            // alert(textStatus + ' | ' + errorThrown + ' | ' + data + ' | Lütfen sunucu yöneticinizden timeout süresini arttırmasını talep edin.');

            alert(

                "Entegrasyon " +

                (dilim + 1) +

                ". kısmı tamamlanamadı. Lütfen sunucu yöneticinizden timeout süre değerlerini arttırmasını talep edin ve entegrasyonu tekrar çalıştırın. Hata : " +

                textStatus +

                " | " +

                errorThrown +

                " | " +

                data

            );

        },

        timeout: 3600000,

        success: function(data) {

            if (data.search("XMLUpdateOK") < 0) {

                var hata = "";

                if (data.search("HATA:") > 0) {

                    hata = data;

                }

                $(".loadingbox").hide();

                notify("", "Lütfen XML ayarlarınızı kontrol edin." + hata, "error");

                // $('.form-group:first label').html('Hata Oluştu... Lütfen XML ayarlarınızı kontrol edin.');

                //return false;

            }

            var oran = (dilim + 1) * (100 / xmldilim);

            $("#xml-progress-bar")

                .width(oran + "%")

                .attr("aria-valuenow", oran)

                .html(oran + "%");



            if (dilim < xmldilim - 1) xmlUpdate(updateURL, dilim + 1);

            else {

                $(".loadingbox").hide();

                $(".form-group:first label").html("Tamamlandı...");

                $.ajax({

                    url: "ajax.php?act=xmlStats&rand=" + randomString(5),

                    success: function(data) {

                        notify("", "XML Güncelleme Tamamlandı.", "success");

                        $(".xmlstats")

                            .html(data)

                            .slideDown();

                    }

                });

            }

            // XMLWindow.location.replace('xmlViewLog.php?rand=' + randomString(5));

            /*

    $.ajax({

      url:'xmlViewLog.php?rand=' + randomString(5),

      success: function(data) { if (data) $('#ViewLogFile').val(data); }

    });

    */

        }

    });

}



function xmlCheckFields(data, updateURL) {



    if ($("#dosya").val() == "") {

        notify("", "Lütfen entegrasyon yapacağınız firmayı seçin.", "error");

        return false;

    }



    var cont = false;

    var checkFileds = data.split(",");

    for (var i = 0; i <= checkFileds.length; i++) {

        if ($("#" + checkFileds[i]).is(":checked")) cont = true;

    }

    if (!cont) {

        alert("Lütfen en az bir seçeneği işaretleyin.");

        return false;

    }



    var pars = "val=" + $(".xmlcatcache select").val();

    //xmlCatSave();

    xmlUpdate(updateURL, 0);

    return false;

}



function xmlCatCache(URL) {

    $(".xmlcatcache").html("");

    if ($("#dosya").val() == "") {

        notify("", "Lütfen entegrasyon yapacağınız firmayı seçin.", "error");

        return false;

    }



    $(".loadingbox").show();

    $(".form-group:first label").html("Kategoriler Çekiliyor...");

    $(".xmlcatcache select").html("");

    $(".xmlstats")

        .html("")

        .hide();



    $("#xml-progress-bar")

        .width("5%")

        .attr("aria-valuenow", "5")

        .html("5%");



    URL +=

        "&dosya=" +

        $("#dosya").val() +

        "&indexKatalog=1&xmlUpdate=1&xmlCatCache=1&dilim=0&rand=" +

        randomString(5);

    $.ajax({

        url: URL,

        success: function(data) {

            $.ajax({

                url: "ajax.php?act=xmlCatCache&dosya=" +

                    encodeURIComponent($("#dosya").val()) +

                    "&rand=" +

                    randomString(5),

                success: function(data) {

                    $(".loadingbox").hide();

                    $(".form-group:first label").html("Tamamlandı...");

                    $("#xml-progress-bar")

                        .css("width", "100%")

                        .attr("aria-valuenow", "100")

                        .html("100%");

                }

            });

        }

    });

    return false;

}



function setXMLDefault() {

    myprompt('XML Kategorileri varsayılan ilk haline döndürülecek. Emin misiniz?', sxmlDefault);

}





function myprompt(stitle, sfunction) {

    Swal.fire({

        text: stitle,

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Evet',

        cancelButtonText: 'Hayır',

        customClass: {

            confirmButton: 'btn btn-primary me-3',

            cancelButton: 'btn btn-label-secondary'

        },

        buttonsStyling: false

    }).then(function(result) {

        if (result.value) {

            sfunction();

            return false;

        }

    });

}





function sxmlDefault() {

    $.ajax({

        url: "ajax.php?act=xmlSetDefault&dosya=" +

            encodeURIComponent($("#dosya").val()) +

            "&rand=" +

            randomString(5),

        type: "GET",

        success: function(dataunused) {

            xmlCatCacheUpdate();

            notify("", "XML Kategori seçimi sıfırlandı..", "success");

        }

    });

}



function sxmlRemove() {

    $.ajax({

        url: "ajax.php?act=xmlRemove&dosya=" +

            encodeURIComponent($("#dosya").val()) +

            "&rand=" +

            randomString(5),

        type: "GET",

        success: function(dataunused) {

            xmlCatCacheUpdate();

            notify("", "İlgili ürün ve kategoriler silindi...", "success");

        }

    });

}



function xmlRemove() {

    myprompt('Bu firmaya ait tüm ürün, ürün resimleri ve kategoriler silinecek. Bu işlemin geri dönüşü yoktur. Emin olmadığınız durumlarda, önce yedek almanız tavsiye edilir. Silmeyi onaylıyor musunuz?', sxmlRemove);

    return false;

}



function xmlCatSave() {

    if ($("#dosya").val() == "") {

        notify("", "Lütfen entegrasyon yapacağınız firmayı seçin.", "error");

        return false;

    }



    var cont = false;

    var vals = "";

    var sels = "";



    $("a.jstree-clicked").each(function() {

        if (

            $(this)

            .parent()

            .attr("value")

        )

            vals +=

            $(this)

            .parent()

            .attr("value") + ",";

    });



    $("select.catCacheSelect").each(function() {

        if ($(this).val()) sels += "&" + $(this).attr("id") + "=" + $(this).val();

    });



    var pars = "val=" + vals + sels;

    if (vals) {

        $.ajax({

            url: "ajax.php?act=xmlCatCacheSet&dosya=" +

                encodeURIComponent($("#dosya").val()) +

                "&rand=" +

                randomString(5),

            type: "POST",

            data: pars,

            success: function(dataunused) {

                //alert(pars);

                notify("", "Seçtiğiniz kategoriler kaydedildi.", "success");

            }

        });

    }

    return false;

}



function updateUrunVarStokList(urunID) {

    if (!$(".updateVarCheckBox").length) return true;

    if (!$(".updateVarCheckBox:checked").length) {

        notify("", "Lütfen önce varyasyon seçimini yapın.", "error");

        return false;

    }

    var uri = '';

    var seturi = '';

    var i;

    for (i = 1; i <= 10; i++) {

        seturi = '';

        $("#varTable" + i + " .updateVarCheckBox:checked").each(function() {

            seturi += encodeURIComponent($(this).val()) + ',';

        });

        uri += '&var' + i + '=' + seturi;

    }



    $.ajax({

        url: "ajax.php?act=updateUrunVarStokList&urunID=" +

            urunID +

            uri +

            "&rand=" +

            randomString(5),

        type: "GET",

        success: function(data) {

            $("#varStokTable").html(data);

            $("#varStokTable input").keypress(function(event) {

                if (event.keyCode == 13) {

                    event.preventDefault();

                }

            });

            besitle();

            return;

        }

    });

    return false;

}



function updateVarTable(val, urunID, seq) {

    $("#varStokTable,#varTable" + seq).html("");

    $.ajax({

        url: "ajax.php?act=updateVarTable&val=" +

            encodeURIComponent(val) +

            "&urunID=" +

            urunID +

            "&seq=" +

            seq +

            "&rand=" +

            randomString(5),

        type: "GET",

        success: function(data) {

            $("#varTable" + seq).html(data);

            popuplateUrunVarCheckbox();

            updateVarCheckbox();

            $("a.fancybox").fancybox();

            return;

            new PNotify({

                title: "",

                text: "Ürün varyasyonları çağırıldı",

                type: "success"

            });

        }

    });

    return false;

}



function updateVarCheckbox() {

    $(".update-checkbox").click(function() {

        $(this)

            .parent()

            .parent()

            .parent()

            .parent()

            .parent()

            .find("input:checkbox")

            .prop("checked", this.checked);

        popuplateUrunVarCheckbox();

    });



}



function popuplateUrunVarCheckbox() {

    $(".updateVarCheckBox").each(function() {

        $(this)

            .parent()

            .parent()

            .find(".fiyat-fark")

            .prop("disabled", this.checked ? "" : "disabled");

    });

}



function besitle() {

    $('.b-esitle').click(

        function() {



            $('.stok-giris').val($('.stok-giris:first').val());

            //$('.dstok-giris').val($('.dstok-giris:first').val());

            //$('.fiyat-giris').val($('.fiyat-giris:first').val());





            return false;

        }

    );

}



function rabarcode() {

    $('.varstok-barcode').each(function() {

        if (!$(this).val())

            $(this).val(Math.floor(10000000000000 + Math.random() * 99999999999999));

    });

    return false;

}



function dovizGuncelle() {

    $.ajax({

        url: "../update.php?doviz=1",

        type: "POST",

        success: function(data) {

            if (data != 'DISABLED')

                notify('Döviz kuru güncellendi.', data, 'success');

            else if (data == 'DISABLED')

                notify('', 'Otomatik Döviz Güncelleme Kapalı.', 'error');

            else

                notify('', 'Bir Sorun Oluştu.', 'error');



        }

    });

}



function cleanCache() {

    $.ajax({

        url: "s.php?f=siteAyarlari.php&cleanCache=1",

        success: function(data) {

            notify('Veritabanı Cache Temizlendi.', '', 'success');

        }

    });

}



function cleanImageCache() {

    $.ajax({

        url: "s.php?f=siteAyarlari.php&cleanImgCache=1",

        type: "POST",

        success: function(data) {

            notify('Resim Cache Temizlendi.', '', 'success');

        }

    });

}



function matchCustom(params, data) {

    // If there are no search terms, return all of the data

    if ($.trim(params.term) === '') {

        return data;

    }



    // Do not display the item if there is no 'text' property

    if (typeof data.text === 'undefined') {

        return null;

    }



    // `params.term` should be the term that is used for searching

    // `data.text` is the text that is displayed for the data object

    if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {

        var modifiedData = $.extend({}, data, true);



        // You can return modified objects from here

        // This includes matching the `children` how you want in nested data sets

        return modifiedData;

    }



    // Return `null` if the term should not be displayed

    return null;

}



(function(global, factory) {

    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :

        typeof define === 'function' && define.amd ? define(['exports'], factory) :

        (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.tr = {}));

}(this, (function(exports) {

    'use strict';



    var fp = typeof window !== "undefined" && window.flatpickr !== undefined ?

        window.flatpickr :

        {

            l10ns: {},

        };

    var Turkish = {

        weekdays: {

            shorthand: ["Paz", "Pzt", "Sal", "Çar", "Per", "Cum", "Cmt"],

            longhand: [

                "Pazar",

                "Pazartesi",

                "Salı",

                "Çarşamba",

                "Perşembe",

                "Cuma",

                "Cumartesi",

            ],

        },

        months: {

            shorthand: [

                "Oca",

                "Şub",

                "Mar",

                "Nis",

                "May",

                "Haz",

                "Tem",

                "Ağu",

                "Eyl",

                "Eki",

                "Kas",

                "Ara",

            ],

            longhand: [

                "Ocak",

                "Şubat",

                "Mart",

                "Nisan",

                "Mayıs",

                "Haziran",

                "Temmuz",

                "Ağustos",

                "Eylül",

                "Ekim",

                "Kasım",

                "Aralık",

            ],

        },

        firstDayOfWeek: 1,

        ordinal: function() {

            return ".";

        },

        rangeSeparator: " - ",

        weekAbbreviation: "Hf",

        scrollTitle: "Artırmak için kaydırın",

        toggleTitle: "Aç/Kapa",

        amPM: ["ÖÖ", "ÖS"],

        time_24hr: true,

    };

    fp.l10ns.tr = Turkish;

    var tr = fp.l10ns;



    exports.Turkish = Turkish;

    exports.default = tr;



    Object.defineProperty(exports, '__esModule', {

        value: true

    });



})));





$(document).ready(function() {



    const bsValidationForms = document.querySelectorAll('.needs-validation');



    // Loop over them and prevent submission

    Array.prototype.slice.call(bsValidationForms).forEach(function(form) {

        form.addEventListener(

            'submit',

            function(event) {

                if (!form.checkValidity()) {

                    event.preventDefault();

                    event.stopPropagation();

                    notify('', 'Lütfen zorunlu alanları doldurun.', 'error')

                } else {



                }



                form.classList.add('was-validated');

            },

            false

        );

    });





    $('#main-form input[type="text"]').keypress(function(e) {

        if (e.which == 13) {

            $('form#main-form button[type="submit"]').click();

            return false;

        }

    });



    $('.modal-dialog input[type="text"]').keypress(function(e) {



        if (e.which == 13) {

            $(this).parent().parent().find('button.btn-primary').click();

            return false;

        }

    });







    $('.date-picker').flatpickr({

        altInput: true,

        dateFormat: 'd.m.Y',

        altFormat: "j F Y",

        //allowInput: true,

        "locale": "tr"

    });



    $('.date-picker-time').flatpickr({

        altInput: true,

        dateFormat: 'd.m.Y',

        altFormat: "j F Y, l H:i",

        enableTime: true,

        dateFormat: 'd.m.Y H:i',

        //allowInput: true,

        "locale": "tr"

    });



    $('.select2').select2({

        matcher: matchCustom

    });



    $('select[MULTIPLE]').select2({

        matcher: matchCustom,

        closeOnSelect: false,

        multiple: true

    });



    $('input[maxlength],textarea[maxlength]').each(function() {

        if ($(this).attr('type') && $(this).attr('type') != 'text')

            return;

        $(this).maxlength({

            warningClass: 'label label-secondary bg-white text-secondary',

            limitReachedClass: 'label label-danger',

            separator: '. Azami girilebilecek karakter : ',

            preText: '&nbsp;Girilen karakter : ',

            postText: '.&nbsp;',

            validate: true,

            threshold: +this.getAttribute('maxlength')

        });

    });





    if (document.getElementById('son-siparisler')) {

        new PerfectScrollbar(document.getElementById('son-siparisler'), {

            wheelPropagation: false

        });

    }

    if (document.getElementById('bilgilendirmeler')) {

        new PerfectScrollbar(document.getElementById('bilgilendirmeler'), {

            wheelPropagation: false

        });

    }

    if (document.getElementById('anlikGezilenler')) {

        new PerfectScrollbar(document.getElementById('anlikGezilenler'), {

            wheelPropagation: false

        });

    }



    $(".panel-title").click(function() {

        $(this)

            .parent()

            .find(".panel-action-toggle:first")

            .click();

    });

    //$("#main-form").validate();

    $(".urunVarSelect").change(function() {

        updateVarTable($(this).val(), $(this).attr("urunID"), $(this).attr("seq"));

    });

    $(".urunVarSelect").each(function() {

        updateVarTable($(this).val(), $(this).attr("urunID"), $(this).attr("seq"));

    });

});







function cprompt(t) {

    return Swal.fire({

        title: t,

        input: 'text',

        inputAttributes: {

            autocapitalize: 'off'

        },

        showCancelButton: true,

        confirmButtonText: 'Gönder',

        cancelButtonText: 'İptal',

        customClass: {

            confirmButton: 'btn btn-primary me-3',

            cancelButton: 'btn btn-label-secondary'

        },

        backdrop: true,

    }, function(inputValue) {

        return inputValue;

    });

}



function alert2(titlex, body, type) {

    Swal.fire({

        title: titlex,

        html: body,

        icon: type,

        timerProgressBar: true,

        //  timer: 3000,

        customClass: {

            confirmButton: 'btn btn-primary'

        },

        buttonsStyling: false

    });

}



function notify(title, body, type) {

    Swal.fire({

        //  position: 'top-end',

        toast: true,

        icon: type,

        title: title,

        html: body,

        showConfirmButton: false,

        timer: 2000

    })

}

var vtChartAnlikZiyaretci;



function chartAnlikZiyaretci() {

    v3Ajax("chartAnlik", "anlikSayac", "");

    v3Ajax("tableGezilen", "anlikGezilenler", "");

    clearTimeout(vtChartAnlikZiyaretci);

    vtChartAnlikZiyaretci = setTimeout(function() {

        chartAnlikZiyaretci();

    }, 30000);

}



function v3Ajax(act, id, pars) {

    $.ajax({

        url: "ajax.php?act=" + act + "&rand=" + randomString(5),

        type: "POST",

        data: pars,

        success: function(data) {

            data = data.replace(/^\s+|\s+$/g, "");

            $("#" + id).html(data);



            if (act == "tableGezilen") {

                $(".showBasketInfo").click(

                    function() {

                        if (!$('.dynSepet').length)

                            showBasketInfo($(this).attr("randStr"), 1);

                        else

                            $(".dynSepet").remove();

                    }

                );

            }

        }

    });

}



function showBasketInfo(randStr, opt) {

    if (opt && randStr) {

        $(".dynSepet").remove();

        var url =

            "ajax.php?act=chat-showBasket&randStr=" +

            randStr +

            "&rand=" +

            randomString(5);

        $.get(url, function(data) {



            Swal.fire({

                html: data + '<style>.basket-right { display:none; } .basket-left { width:100% !important; }</style>',

                confirmButtonText: 'Kapat',

            })

            return;







            $('<div id="dynSepet" class="dynSepet">' + data + "</div>").appendTo(

                "body"

            );

            $(".dynSepet")

                .css({

                    top: (mouseY - ($("#dynSepet").height() * 0.75)) + "px",

                    left: (mouseX - ($("#dynSepet").width() * 0.75)) + "px"

                })

                .hover(null, function() {

                    // $(this).remove();

                });

        });

    }

    //	else

    //		$('.dynSepet').remove();

}



function chartOdemeChange(obj) {

    $("#chartOdemeInfo").html(

        "<b>" +

        $(obj)

        .find("option:selected")

        .attr("adet") +

        "</b> adet (<b>" +

        $(obj)

        .find("option:selected")

        .attr("ciro") +

        " TL</b>)"

    );

}



function frowCheckboxClick(obj) {

    if (

        $(obj)

        .find(".frow_opt")

        .html() != ""

    )

        return;

    var table = $(obj)

        .parent()

        .parent()

        .parent()

        .find(".frow_ID")

        .attr("frowDB");

    var field = $(obj)

        .find(".frow_val")

        .attr("field");

    var id = $(obj)

        .parent()

        .parent()

        .parent()

        .find(".frow_ID")

        .attr("frowID");

    var value = $(obj)

        .find(".frow_val")

        .html();

    if (value.search("checked") > 0) {

        var url =

            "ajax.php?act=xupdateDBField&table=" +

            encodeURIComponent(table) +

            "&field=" +

            encodeURIComponent(field) +

            "&value=0&ID=" +

            id +

            "&r=" +

            Math.floor(Math.random() * 99999);



        $.ajax({

            url: url,

            success: function(data) {

                return;

                $(obj)

                    .find(".frow_val")

                    .html(value.replace(/checked='checked'/i, "").replace(/checked="checked"/i, ""));

            }

        });

    } else {

        var url =

            "ajax.php?act=xupdateDBField&table=" +

            encodeURIComponent(table) +

            "&field=" +

            encodeURIComponent(field) +

            "&value=1&ID=" +

            id +

            "&r=" +

            Math.floor(Math.random() * 99999);

        $.ajax({

            url: url,

            success: function(data) {

                return;

                $(obj)

                    .find(".frow_val")

                    .html(value.replace(/<input/i, "<input checked='checked'"));

            }

        });

    }

}



function frowTextClick(obj, width) {

    if (

        $(obj)

        .find(".frow_opt")

        .html() != ""

    )

        return;

    var table = $(obj)

        .parent()

        .parent()

        .parent()

        .find(".frow_ID")

        .attr("frowDB");

    var field = $(obj)

        .find(".frow_val")

        .attr("field");

    if (field == 'showCatIDs') return;

    if (field == 'idPath') return;

    if (field == 'hit') return;

    if (field == 'gosterim') return;





    var id = $(obj)

        .parent()

        .parent()

        .parent()

        .find(".frow_ID")

        .attr("frowID");

    $(".frow_opt").html("");

    $(".frow_val").show();

    $(obj)

        .find(".frow_val")

        .hide();

    if (!parseInt(width)) width = 120;

    $('<input type="text" class="frow_input form-control" />')

        // .css("width", width - 2 + "px")

        .css("width", "100%")

        .val(

            $(obj)

            .find(".frow_val")

            .text()

        )

        .appendTo($(obj).find(".frow_opt"))

        .select()

        .focusout(function() {

            frowTextUpdated(obj, table, field, id);

        })

        .keyup(function(e) {

            if (e.keyCode == 13) {

                frowTextUpdated(obj, table, field, id);

                $(obj)

                    .find(".frow_opt")

                    .html("");

                $(obj)

                    .find(".frow_val")

                    .show();

            }

        });

}



function frowTextUpdated(obj, table, field, id) {

    var value = $(obj)

        .find("input")

        .val();

    if (

        value ==

        $(obj)

        .find(".frow_val")

        .text()

    )

        return;

    $(obj)

        .find(".frow_val")

        .html("");

    var url =

        "ajax.php?act=xupdateDBField&table=" +

        encodeURIComponent(table) +

        "&field=" +

        encodeURIComponent(field) +

        "&value=" +

        encodeURIComponent(value) +

        "&ID=" +

        id +

        "&r=" +

        Math.floor(Math.random() * 99999);

    $.ajax({

        url: url,

        success: function(data) {

            $(obj)

                .find(".frow_val")

                .html(value);

        }

    });

}



function frowDbpulldownClick(obj, name, db, base) {

    if (

        $(obj)

        .find(".frow_opt")

        .html() != ""

    )

        return;

    var table = $(obj)

        .parent()

        .parent()

        .parent()

        .find(".frow_ID")

        .attr("frowDB");

    var field = $(obj)

        .find(".frow_val")

        .attr("field");

    var id = $(obj)

        .parent()

        .parent()

        .parent()

        .find(".frow_ID")

        .attr("frowID");

    $(".frow_opt").html("");

    $(".frow_val").show();

    $(obj)

        .find(".frow_val")

        .hide();



    var url =

        "ajax.php?act=generateOptionsList&table=" +

        encodeURIComponent(db) +

        "&name=" +

        encodeURIComponent(name) +

        "&base=" +

        encodeURIComponent(base) +

        "&selected=" +

        encodeURIComponent(

            $(obj)

            .find(".frow_val")

            .text()

        ) +

        "&r=" +

        Math.floor(Math.random() * 99999);

    $.ajax({

        url: url,

        success: function(data) {

            $('<select class="frow_select form-select" style="width:auto;"></select>')

                .addClass("")

                .html(data)

                .appendTo($(obj).find(".frow_opt"))

                .change(function() {

                    var value = $(this)

                        .find("option:selected")

                        .attr("value");

                    var text = $(this)

                        .find("option:selected")

                        .text();

                    if (

                        text ==

                        $(obj)

                        .find(".frow_val")

                        .text()

                    )

                        return;

                    var url =

                        "ajax.php?act=xupdateDBField&table=" +

                        encodeURIComponent(table) +

                        "&field=" +

                        encodeURIComponent(field) +

                        "&value=" +

                        encodeURIComponent(value) +

                        "&ID=" +

                        id +

                        "&r=" +

                        Math.floor(Math.random() * 99999);

                    $.ajax({

                        url: url,

                        success: function(data) {

                            $(obj)

                                .find(".frow_opt")

                                .html("");

                            $(obj)

                                .find(".frow_val")

                                .html(text)

                                .show();

                        }

                    });

                });

        }

    });

}

var mouseX, mouseY;

$(document)

    .mousemove(function(e) {

        mouseX = e.pageX;

        mouseY = e.pageY;

    })

    .mouseover();



$("document").ready(function() {

    $('<button title="Tümünü Kaldır" type="button" class="btn rounded-pill btn-icon btn-danger hepsini-kaldir"><span class="tf-icons bx bx-checkbox"></span></button>').prependTo($('select[MULTIPLE].select2-hidden-accessible').parent()).click(function() {

        $(this).parent().parent().find('.form-select').select2('destroy').find('option').prop('selected', '').end().select2({

            matcher: matchCustom,

            closeOnSelect: false,

            multiple: true

        });

    }).hide();



    $('<button title="Tümünü Seç" type="button" class="btn rounded-pill btn-icon btn-secondary hepsini-sec"><span class="tf-icons bx bx-checkbox-square"></span></button>').prependTo($('select[MULTIPLE].select2-hidden-accessible').parent()).click(function() {

        $(this).parent().parent().find('.form-select').select2('destroy').find('option').prop('selected', 'selected').end().select2({

            matcher: matchCustom,

            closeOnSelect: false,

            multiple: true

        });

    }).hide();



    $('select.select2-hidden-accessible[multiple]').parent().hover(function() {

        $(this).find('button').show();

    }, function() {

        $(this).find('button').hide();

    });



    $('body').click(function() {

        $('.dynSepet').remove();

    });

    $("a.fancybox").fancybox();

    chartAnlikZiyaretci();

    $("input.set-ajax").each(function() {

        var multi = $(this).attr("multi") != "0";

        var vuID = $(this).attr("urunID");

        var vfID = $(this).attr("name");



        $(this).select2({

            multiple: multi,

            //closeOnSelect: false,

            ajax: {

                url: "ajax.php?act=filterSearch",

                dataType: "json",

                delay: 250,



                data: function(params) {

                    return {

                        qsrc: params,

                        uID: vuID,

                        fID: vfID // search term

                    };

                },

                results: function(data) {

                    // parse the results into the format expected by Select2.

                    // since we are using custom formatting functions we do not need to

                    // alter the remote JSON data

                    return {

                        results: data

                    };

                },

                cache: true

            },

            minimumInputLength: 2

        });

    });



    $('select[name="rp"]').change(

        function() {

            setSessionConfig('data-grid-limit', $(this).val());

        }

    );



    $('#urun-arama-ac').click(

        function()

        {

            $('.urun-arama').toggle();

            setSessionConfig('urun-arama-ac', $('#urun-arama-ac').is(':checked'));

        }

    );



    $('#siparis-arama-ac').click(

        function()

        {

            $('.siparis-arama').toggle();

            setSessionConfig('siparis-arama-ac', $('#siparis-arama-ac').is(':checked'));

        }

    );



    



    $("#anlikSayacContainer button").click(function() {

        $("#anlikSayacContainer button").removeClass('active');

        $(this).addClass('active');

        setSessionConfig("anlikGezilenler_uye", $(this).attr("data-val"));

        setTimeout(function() {

            chartAnlikZiyaretci();

        }, 1000);

    });

    $("#anlikSayacContainer button:first").click();

    $(".selectForSession").change(function() {

        var url =

            "ajax.php?act=setSession&key=" +

            $(this).attr("id") +

            "&val=" +

            encodeURIComponent($(this).val()) +

            "&r=" +

            Math.floor(Math.random() * 99999);

        $.ajax({

            url: url,

            success: function(data) {

                // alert(data);

                return;

            }

        });

    });

});



function setSessionConfig(name, val) {

    $.get(

        "ajax.php?act=setSession&key=" +

        encodeURIComponent(name) +

        "&val=" +

        encodeURIComponent(val) +

        "&r=" +

        Math.floor(Math.random() * 99999),

        function(data) {

            console.log(data);

        }

    );

}



function formatItem(row) {

    return row[1];

}



function formatResult(row) {

    return row[0];

    //return row[0].replace(/(<.+?>)/gi, '');

}



CKEDITOR.config.filebrowserBrowseUrl =

    "../secure/secureshare/CKEditor/filemanager/index.html";

CKEDITOR.config.extraPlugins =

    "videodetector,font,panelbutton,colorbutton,justify";

CKEDITOR.config.skin = "bootstrapck";

CKEDITOR.config.allowedContent = true;



! function() {

    if (jQuery && jQuery.fn && jQuery.fn.select2 && jQuery.fn.select2.amd) var n = jQuery.fn.select2.amd;

    n.define("select2/i18n/tr", [], function() {

        return {

            errorLoading: function() {

                return "Sonuç yüklenemedi"

            },

            inputTooLong: function(n) {

                return n.input.length - n.maximum + " karakter daha girmelisiniz"

            },

            inputTooShort: function(n) {

                return "En az " + (n.minimum - n.input.length) + " karakter daha girmelisiniz"

            },

            loadingMore: function() {

                return "Daha fazla…"

            },

            maximumSelected: function(n) {

                return "Sadece " + n.maximum + " seçim yapabilirsiniz"

            },

            noResults: function() {

                return "Sonuç bulunamadı"

            },

            searching: function() {

                return "Aranıyor…"

            },

            removeAllItems: function() {

                return "Tüm öğeleri kaldır"

            }

        }

    }), n.define, n.require

}();
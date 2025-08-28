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
  if (
    confirm("Dosya hem veritabanından hemde diskden silinecek. Emin misiniz?")
  ) {
    document.getElementById("ajaxEmu").src =
      "./removeFile.php?dbName=" +
      dbase +
      "&dbField=" +
      field +
      "&dbID=" +
      dbID +
      "&filePath=" +
      filePath;
    setTimeout(function() {
      alert("Dosya Silindi!");
    }, 500);
    $(obj)
      .parent()
      .find(".fileupload-preview")
      .hide();
    $(obj).hide();
  }
  return false;
}

var orderIDs = '';
function setSPOrder(ids)
{
  if(!ids)
  {
    alert('Lütfen önce siparişleri seçin.');
    return;
  }
  orderIDs = ids;
  $.magnificPopup.open({
      items: {
          src: '#order-dialog-form',
      },
    preloader: false,
    modal: false,
      type: 'inline'
  });
  //alert(ids);
}

function setAllOrderStatus()
{
  $.magnificPopup.close();
  window.location.href = setOrderPrefixURL + 'orderStatusID='+ $('#setAllDurum').val() + orderIDs;
}

function resizeFile(dbase, field, dbID, filePath, spanID, obj) {
  if (
    confirm(
      "İlgili resim azami 1000px en olarak yeniden boyutlandırılıp, var olan resim güncellenecektir. Onaylıyor musunuz?"
    )
  ) {
    document.getElementById("ajaxEmu").src =
      "./resizeFile.php?dbName=" +
      dbase +
      "&dbField=" +
      field +
      "&dbID=" +
      dbID +
      "&filePath=" +
      filePath;

    setTimeout(function() {
      alert("Dosya yeniden boyutlandırıldı.");
    }, 500);
  }
  return false;
}

function removeDB(dbase, field, dbID, filePath, spanID, obj) {
  if (confirm("Dosya sadece veritabanından silinecek. Emin misiniz?")) {
    document.getElementById("ajaxEmu").src =
      "./removeFile.php?dbName=" +
      dbase +
      "&dbField=" +
      field +
      "&dbID=" +
      dbID;
    setTimeout(function() {
      alert("Field Silindi!");
    }, 500);
    $(obj)
      .parent()
      .find(".fileupload-preview")
      .hide();
    $(obj).hide();
  }
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
          $('.getAdminKargoApiForm').parent().parent().show();
        $("[data-toggle=tooltip],[rel=tooltip]").tooltip({ container: "body" });
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
function sepetUrunChange(obj) {
  var durum = $(obj).val();
  var adet = 0;
  if (durum == "50") {
    adet = prompt("Temin edilemeyen ürün adetini girin", "1");
  }
  $.ajax({
    url:
      "ajax.php?act=sepetDurum&lineID=" +
      $(obj).attr("lineID") +
      "&durum=" +
      durum +
      "&adet=" +
      adet +
      "&rand=" +
      randomString(5),
    success: function(data) {
      alert("Sepete ait ürün durumu güncellendi.");
    }
  });
}
function gridListFinished() {
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
    url:
      "ajax.php?act=xmlSetXMLDilim&dosya=" +
      encodeURIComponent($("#dosya").val()) +
      "&rand=" +
      randomString(5),
    success: function(data) {
      xmldilim = parseInt(data);
      if (!xmldilim) xmldilim = 10;
    }
  });
  $.ajax({
    url:
      "ajax.php?act=xmlCatCache&dosya=" +
      encodeURIComponent($("#dosya").val()) +
      "&rand=" +
      randomString(5),
    success: function(data) {
      if (!data) return xmlCatCacheUpdate();
      $(".xmlcatcache").html(data);

      $(".modal-basic").magnificPopup({
        type: "inline",
        preloader: false,
        modal: true
      });

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
    $("html, body").animate({ scrollTop: 0 }, "slow");
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
        notify("Hata", "Lütfen XML ayarlarınızı kontrol edin." + hata, "error");
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
            notify("Bilgi", "XML Güncelleme Tamamlandı.", "success");
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
    notify("Hata", "Lütfen entegrasyon yapacağınız firmayı seçin.", "error");
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
    .html("5");

  URL +=
    "&dosya=" +
    $("#dosya").val() +
    "&indexKatalog=1&xmlUpdate=1&xmlCatCache=1&dilim=0&rand=" +
    randomString(5);
  $.ajax({
    url: URL,
    success: function(data) {
      $.ajax({
        url:
          "ajax.php?act=xmlCatCache&dosya=" +
          encodeURIComponent($("#dosya").val()) +
          "&rand=" +
          randomString(5),
        success: function(data) {
          $(".loadingbox").hide();
          $(".form-group:first label").html("Tamamlandı...");
          $("#xml-progress-bar")
            .css("width", "100%")
            .attr("aria-valuenow", "100")
            .html("100");
        }
      });
    }
  });
  return false;
}
function setXMLDefault() {
  if (
    confirm(
      "XML Kategorileri varsayılan ilk haline döndürülecek. Emin misiniz?"
    )
  ) {
    $.ajax({
      url:
        "ajax.php?act=xmlSetDefault&dosya=" +
        encodeURIComponent($("#dosya").val()) +
        "&rand=" +
        randomString(5),
      type: "GET",
      success: function(dataunused) {
        xmlCatCacheUpdate();
        notify("Bilgi", "XML Kategori seçimi sıfırlandı..", "success");
      }
    });
    return false;
  }
}
function xmlRemove() {
  if (
    confirm(
      "Bu firmaya ait tüm ürün, ürün resimleri ve kategoriler silinecek. Bu işlemin geri dönüşü yoktur. Emin olmadığınız durumlarda, önce yedek almanız tavsiye edilir. Silmeyi onaylıyor musunuz?"
    )
  ) {
    //window.open('ajax.php?act=xmlRemove&dosya='+$('#dosya').val()+'&rand=' + randomString(5));
    $.ajax({
      url:
        "ajax.php?act=xmlRemove&dosya=" +
        encodeURIComponent($("#dosya").val()) +
        "&rand=" +
        randomString(5),
      type: "GET",
      success: function(dataunused) {
        xmlCatCacheUpdate();
        notify("Bilgi", "İlgili ürün ve kategoriler silindi...", "success");
      }
    });
    return false;
  }
}
function xmlCatSave() {
  if ($("#dosya").val() == "") {
    notify("Hata", "Lütfen entegrasyon yapacağınız firmayı seçin.", "error");
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
      url:
        "ajax.php?act=xmlCatCacheSet&dosya=" +
        encodeURIComponent($("#dosya").val()) +
        "&rand=" +
        randomString(5),
      type: "POST",
      data: pars,
      success: function(dataunused) {
        //alert(pars);
        notify("Bilgi", "Seçtiğiniz kategoriler kaydedildi.", "success");
      }
    });
  }
  return false;
}
function updateUrunVarStokList(urunID) {
  if (!$(".updateVarCheckBox").length) return true;
  if (!$(".updateVarCheckBox:checked").length) {
    notify("Hata", "Lütfen önce varyasyon seçimini yapın.", "error");
    return false;
  }
  var uri = '';
  var seturi = '';
  var i;
  for (i = 1; i <= 10; i++) {
    seturi = '';
    $("#varTable"+i+" .updateVarCheckBox:checked").each(function() {
      seturi += encodeURIComponent($(this).val()) + ',';      
    });
    uri += '&var'+i+'='+seturi;
  }

  $.ajax({
    url:
      "ajax.php?act=updateUrunVarStokList&urunID=" +
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
      new PNotify({
        title: "Bilgi",
        text: "Ürün stok bilgileri çağırıldı",
        type: "success"
      });
    }
  });
  return false;
}
function updateVarTable(val, urunID, seq) {
  $("#varStokTable,#varTable" + seq).html("");
  $.ajax({
    url:
      "ajax.php?act=updateVarTable&val=" +
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
      autoImgPopup();
      return;
      new PNotify({
        title: "Bilgi",
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
      .find("input:checkbox")
      .prop("checked", this.checked);
    popuplateUrunVarCheckbox();
  });
  $(".updateVarCheckBox").change(function() {
    $(this)
      .parent()
      .parent()
      .find("input")
      .prop("disabled", this.checked ? "" : "disabled");
    $(this).prop("disabled", "");
  });
  $(".updateVarCheckBox").each(function() {
    $(this)
      .parent()
      .parent()
      .find("input")
      .prop("disabled", this.checked ? "" : "disabled");
    $(this).prop("disabled", "");
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

function besitle()
{
  $('.b-esitle').click(
    function()
    {
      
      $('.stok-giris').val($('.stok-giris:first').val());
      //$('.dstok-giris').val($('.dstok-giris:first').val());
      //$('.fiyat-giris').val($('.fiyat-giris:first').val());


      return false;
    }
  );
}

function rabarcode()
{
  $('.ra-barcode').click(
    function()
    {
      $('.varstok-barcode').each(function()
      {
        if(!$(this).val())
          $(this).val( Math.floor(10000000000000 + Math.random() * 99999999999999));
      });
      return false;
    }
  );
}

$(document).ready(function() {
  $(".panel-title").click(function() {
    $(this)
      .parent()
      .find(".panel-action-toggle:first")
      .click();
  });
  $("#main-form").validate();
  $(".urunVarSelect").change(function() {
    updateVarTable($(this).val(), $(this).attr("urunID"), $(this).attr("seq"));
  });
  $(".urunVarSelect").each(function() {
    updateVarTable($(this).val(), $(this).attr("urunID"), $(this).attr("seq"));
  });
  $("#cacheTemizle").click(function() {
    $.ajax({
      url: "s.php?f=siteAyarlari.php&cleanCache=1",
      type: "POST",
      success: function(data) {
        new PNotify({
          title: "Bilgi",
          text: "Veritabanı Cache Temizlendi.",
          type: "success"
        });
      }
    });
    return false;
  });
  $("#resimTemizle").click(function() {
    $.ajax({
      url: "s.php?f=siteAyarlari.php&cleanImgCache=1",
      type: "POST",
      success: function(data) {
        new PNotify({
          title: "Bilgi",
          text: "Resim Cache Temizlendi.",
          type: "success"
        });
      }
    });
    return false;
  });
  $(".modal-with-form").magnificPopup({
    type: "inline",
    preloader: false,
    modal: true
  });
  $(document).on("click", ".modal-dismiss", function(e) {
    e.preventDefault();
    $.magnificPopup.close();
  });

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
});
function notify(title, body, type) {
  new PNotify({
    title: title,
    text: body,
    type: type
  });
}
var vtChartAnlikZiyaretci;
function chartAnlikZiyaretci() {
  v3Ajax("chartAnlik", "anlikSayac", "");
  v3Ajax("tableGezilen", "anlikGezilenler", "");
  clearTimeout(vtChartAnlikZiyaretci);
  vtChartAnlikZiyaretci = setTimeout(function() {
    chartAnlikZiyaretci();
  }, 5000);
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
        $(".showBasketInfo,#dynSepet").hover(
          function() {
            showBasketInfo($(this).attr("randStr"), 1);
          },
          function() {
            showBasketInfo($(this).attr("randStr"), 0);
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
      $('<div id="dynSepet" class="dynSepet">' + data + "</div>").appendTo(
        "body"
      );
      $(".dynSepet")
        .css({
          top: mouseY - $("#dynSepet").height() + "px",
          left: mouseX + "px"
        })
        .hover(null, function() {
          $(this).remove();
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
  if (value.search("accept") > 0) {
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
        $(obj)
          .find(".frow_val")
          .html(value.replace(/accept/i, "close"));
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
        $(obj)
          .find(".frow_val")
          .html(value.replace(/close/i, "accept"));
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
  $('<input type="text" class="frow_input" />')
    .css("width", width - 2 + "px")
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
      $('<select class="frow_select"></select>')
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

  $("#meterSalesSel a").click(function() {
    $("#meterSalesSel a").removeClass("active");
    $(this).addClass("active");
    setSessionConfig("anlikGezilenler_uye", $(this).attr("data-val"));
    chartAnlikZiyaretci();
  });

  $("#textfield").autocomplete(
    "ajax.php?act=arama" + "&rand=" + randomString(5),
    {
      minChars: 2,
      width: 300,
      multiple: false,
      matchContains: true,
      formatItem: formatItem,
      formatResult: formatResult,
      selectFirst: false
    }
  );
  $("#textfield").keydown(function() {
    if (
      $(this)
        .val()
        .search(".php") > 1
    ) {
      var val = $(this).val();
      $(this)
        .val("yönlendiriliyor..")
        .css("color", "#ccc");
      window.location.href = "s.php?f=" + val;
    }
  });
  $("#ziyaretciSelect").change(function() {
    chartLoaderStart();
    var url =
      "ajax.php?act=chartZiyaretci&type=" +
      encodeURIComponent($(this).val()) +
      "&r=" +
      Math.floor(Math.random() * 99999);
    $.ajax({
      url: url,
      success: function(data) {
        setTimeout(function() {
          chartLoaderStop();
        }, 1000);
        $(".chart").html(data);
        v3Chart();
      }
    });
  });
  $("#ziyaretSelect").change(function() {
    var url =
      "ajax.php?act=chartZiyaret&type=" +
      encodeURIComponent($(this).val()) +
      "&r=" +
      Math.floor(Math.random() * 99999);
    $.ajax({
      url: url,
      success: function(data) {
        $("#enCokGezilenUrunler").html(data);
      }
    });
  });
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
    function(data) {}
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
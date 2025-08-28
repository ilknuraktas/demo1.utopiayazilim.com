var singlePaymentClicked = false;
$(document).ready(function () {
  $(".pay-items div.card-headers").click(function () {
    if (
      $(this).parent().find(".baska-kart").is(":visible") ||
      !$(".siparis-onayla-button").is(":visible")
    )
      return;
    if (
      $("#gf_acceptRulesCB_satinalKural").length &&
      !$("#gf_acceptRulesCB_satinalKural").is(":checked")
    ) {
      myalert(lang_onaySiparis, "warning");
      return;
    }
    $(".pay-items.tabs-items.active .mobile-payment").html(
      $(".pay-items.tabs-items.active .mobile-payment").attr("desc")
    );
    $(".pay-auto-cc").html("").hide();
    $(".pay-items.tabs-items.active .card-bodys .credit-card").css(
      "opacity",
      1
    );
    $(".pay-items,.cc-choice-container").removeClass("active");
    $(this).parent().addClass("active");
    $(".card-bodys").removeClass("d-block").addClass("d-none");
    $(this)
      .parent()
      .find(".card-bodys")
      .addClass("d-block")
      .removeClass("d-none")
      .show();

    if ($(this).parent().find(".pay-auto-load").length) {

      $(".pay-items.tabs-items.active .pay-auto-load")
        .html(ajaxLoaderDiv())
        .show();
      var payID = $(this).parent().find(".pay-auto-load").attr("data-loadID");
      setPayType(payID);

      $.get(
        "page.php?act=satinal&op=odeme&paytype=" +
          payID +
          "&viewPopup=1&isAjax=1",
        function (data) {
          if(singlePaymentClicked)
            window.location.href = 'page.php?act=satinal&op=odeme&paytype=' + payID;

          $(".pay-items.tabs-items.active .pay-auto-load").html(
            $(data).find("#shopphp-payment-body-step3").html()
          );
        }
      );
    }
  });

  $(".cc-choice-container").click(function () {
    $(".cc-choice-container").removeClass("active");
    $(this).addClass("active");
  });

  $(".credit-card").click(function () {
    $(".pay-items.tabs-items.active .card-bodys .credit-card").css(
      "opacity",
      0.2
    );
    $(this).css("opacity", 1);

    $(".pay-items.tabs-items.active .pay-auto-cc").html(ajaxLoaderDiv()).show();
    var payID = $(this).attr("data-bankID");
    setPayType(payID);


    $.get(
      "page.php?act=satinal&op=odeme&paytype=" +
        payID +
        "&viewPopup=1&isAjax=1",
      function (data) {
        $(".pay-items.tabs-items.active .pay-auto-cc").html(
          $(data).find("#shopphp-payment-body-step3").html()
        );
      }
    );
  });

  window.addEventListener("load", (event) => {
    $(".notAliciUpdate").bind("input propertychange", function () {
      siparisBilgiGuncelle(0, 0);
    });
  });

  function siparisKargoSecimListeGuncelle() {
    if (!$("#sepet-kargo-secim").length)
      $.get("include/ajaxLib.php?act=kargoArray", function (data) {
        if (data)
          $(
            '<li class="sf-form-item-fullwidth"><div><label class="sf-text-label">Kargo</label><div id="sepet-kargo-secim">' +
              data +
              '</div><span title="" class="gf_info" id="gf_info_kargoFirmaID"></span></div></li>'
          ).appendTo($("#basket-right-container .basket-right"));
        sepetHTMLGuncelle("");
      });
    else
      $.get("include/ajaxLib.php?act=kargoArray", function (data) {
        $("#sepet-kargo-secim select").html(data);
      });

    $("#gf_info_kargoFirmaID").html("");

    $(".kargo-secim").html("<tr><td>" + lang_lutfenBekleyin + "</td></tr>");
    $(".kargo-secim").load(
      "include/mod_SiparisAdresSecim.php?siparisKargoListe=true",
      function () {
        $(".kargo-secim.disabled").removeClass("disabled").addClass("enabled");
        $(".kargo-secim.enabled input").click(function () {
          $("#kargoFirmaID").val($(this).attr("kargoFirmaID"));
          $(".kargo-secim tr").removeClass("active");
          $(this).parent().parent().addClass("active");
          siparisBilgiGuncelle(true, false);
          $(this).addClass("active");
        });
        $(".kargo-secim.enabled input:first").click();
      }
    );
  }

  function siparisBilgiGuncelle(update, kargo) {
    $.ajax({
      url:
        "include/ajaxLib.php?act=setSiparisAdresID&adresID=" +
        $("#adresID").val() +
        "&kargoFirmaID=" +
        $("#kargoFirmaID").val() +
        "&faturaID=" +
        $("#faturaID").val() +
        "&teslimatID=" +
        $("#teslimatID").val() +
        "&data_notAlici=" +
        $("#data_notAlici").val(),
      success: function (data) {
        if (update) sepetHTMLGuncelle("");
        if (kargo) siparisKargoSecimListeGuncelle();
      },
    });
  }

  window.addEventListener("load", (event) => {
    $("input[name=ceptel]").mask("(Z00) 000-0000", {
      translation: {
        Z: {
          pattern: /[1-9]/,
          optional: false,
        },
      },
    });

    $("#teslimat-adres .adress-list:first .adres-items").click(function () {
      $("#teslimat-adres .adress-list:first .adres-items").removeClass(
        "active"
      );
      $(this).addClass("active");
      $("#adresID").val($(this).attr("adresID"));
      siparisBilgiGuncelle(false, true);
    });

    $("#fatura-adres-load").click(function () {
      if (!$(this).is(":checked")) {
        if ($("#fatura-adres").html() == "") {
          $("#fatura-adres").html(
            $(".adress-list:first")
              .html()
              .replace(/name="adresID"/g, 'name="faturaID"')
              .replace(/adres-item-/g, "fatura-item-")
          );
          $("#fatura-adres .adres-items").removeClass("active");
          $("#fatura-adres .adres-items").click(function () {
            $("#fatura-adres .adres-items").removeClass("active");
            $(this).addClass("active");
            $("#faturaID").val($(this).attr("adresID"));
            siparisBilgiGuncelle(false, false);
          });
        }
      } else {
        $("#faturaID").val("");
        $("#fatura-adres").html("");
        siparisBilgiGuncelle(false, false);
      }
    });

    $(".teslimat-secim input").click(function () {
      $("#teslimatID").val($(this).attr("teslimatID"));
      $(".teslimat-secim tr").removeClass("active");
      $(this).parent().parent().addClass("active");
      $(this).addClass("active");
      siparisBilgiGuncelle(true, false);
    });
    $(".teslimat-secim input:first").click();
    if ($(".addres-item").length == 1) $(".addres-item:first").click();
  });
});

function ccFormKaldir() {
  $(".pay-items.tabs-items.active .card-bodys").show();
  $(".pay-items.tabs-items.active .pay-auto-cc").html("").hide();
}

function siparisiOnayla() {
  if (
    $("#gf_acceptRulesCB_satinalKural").length &&
    !$("#gf_acceptRulesCB_satinalKural").is(":checked")
  ) {
    myalert(lang_onaySiparis, "warning");
    return;
  }
  if (!$(".pay-items.tabs-items.active").length) {
    myalert(lang_onayOdemeTipi, "warning");
    return;
  }

  if ($(".pay-items.active .sp-payment form").length) {
    var stop = false;
    if ($("#card-name").length && !$("#card-name").val()) {
      stop = true;
    }
    if ($("#card-number").length && !$("#card-number").val()) {
      stop = true;
    }
    if ($("#card-cvv").length && !$("#card-cvv").val()) {
      stop = true;
    }
    if (stop) {
      myalert(lang_kartBilgileriDoldurun, "warning");
      return;
    } else {
      if ($("#card-number").length)
        $("#card-number").val($("#card-number").val().replace(/\s/g, ""));
      $(".sp-payment form").submit();
      $("div.payment").css({ opacity: 0.2, "pointer-events": "none" });
    }
  }

  if ($(".pay-items.tabs-items.active .pay-auto-finish").length) {
    $(".siparis-onayla-button").hide();
    if ($(".pay-items.tabs-items.active .mobile-payment").length) {
      $(".pay-items.tabs-items.active .mobile-payment").attr(
        "desc",
        $(".pay-items.tabs-items.active .mobile-payment").text()
      );
      $(".pay-items.tabs-items.active .mobile-payment").html(ajaxLoaderDiv());
    } else
      $(".pay-items.tabs-items.active .pay-auto-finish")
        .html(ajaxLoaderDiv())
        .show();
    var payID = $(".pay-items.tabs-items.active .pay-auto-finish").attr(
      "data-loadID"
    );
    $.get(
      "page.php?act=satinal&op=odeme&paytype=" +
        payID +
        "&viewPopup=1&isAjax=1",
      function (data) {
        if ($(".pay-items.tabs-items.active .mobile-payment").length)
          $(".pay-items.tabs-items.active .mobile-payment").html(
            $(data).find("#shopphp-payment-body-step3").html()
          );
        else
          $(".pay-items.tabs-items.active .pay-auto-finish").html(
            $(data).find("#shopphp-payment-body-step3").html()
          );
      }
    );
    return;
  }
}

function ccTaksitGosterim() {
  if ($("#taksit-select select option").length < 2) return;
  $('<table class="table border rounded no-collapse"></table>').appendTo(
    "#taksit-view"
  );
  $(
    '<thead><tr><th class="border-right font-bold line-30">Taksit Seçenekleri</th><th class="font-bold line-30">Toplam</th></tr>'
  ).appendTo("#taksit-view table");
  $("<tbody></tbody>").appendTo("#taksit-view table");
  var ay,
    value,
    classAdd,
    setValue = "";
  $("#taksit-select select option").each(function () {
    value = $(this).html();
    if (value.includes(":")) {
      classAdd = "";
      ay = $(this).attr("value");
      const vArray = value.split(" = ");
      const fArray = vArray[0].split(" : ");
      var f = fArray[1];
      const tArray = f.toLocaleLowerCase().split(" x ");

      f =
        tArray[1] +
        " Taksit (" +
        tArray[0].replace("(", "").replace(")", "").toLocaleUpperCase() +
        ")";
      if (!vArray[1]) {
        f = "Peşin";
      }
      if (
        ay > 1 &&
        parseFloat(
          modMainPrice.replace(" ", "").replace("TL", "").replace(",", "")
        ) ==
          parseFloat(
            vArray[1].replace(" ", "").replace("TL", "").replace(",", "")
          )
      )
        classAdd = "pesin";

      $(
        '<tr class="taksit-items ' +
          classAdd +
          '" data-value="' +
          ay +
          '"><td class="d-flex border-right align-items-center" scope="row"><div class="radius-table mr-2"></div>' +
          f +
          "</td><td>" +
          (vArray[1] ? vArray[1] : "") +
          "</td></tr>"
      )
        .appendTo("#taksit-view table tbody")
        .click(function () {
          $(".taksit-items").removeClass("active");
          $(this).addClass("active");
          $("#taksit-select select").val($(this).attr("data-value"));
          setValue = $(this).text().replace("Peşin", "").replace(")", ") - ");
          if (!setValue) setValue = modMainPrice;
          $("li.tutar.tutar-son .sepet3").html(setValue);
        });
    }
  });
  if (!$("#taksit-select select option").length)
    $(
      '<tr class="taksit-items active" data-value="' +
        ay +
        '"><td class="d-flex border-right align-items-center" scope="row"><div class="radius-table mr-2"></div>Peşin : ' +
        $(".credit-card.active").find("span.s1").html() +
        "</td><td></td></tr>"
    ).appendTo("#taksit-view table tbody");
  $(".taksit-items:first").click();
}

function setPayType(ID) {
  $.get("include/mod_SiparisAdresSecim.php?setPayType=" + ID, function (data) {
    if (data == "OK") sepetHTMLGuncelle("");
    else console.log("SetPayType Hata : " + data);
  });
}

function ccformats(ele, e) {
  if (ele.value.length < 19) {
    ele.value = ele.value.replace(/\W/gi, "").replace(/(.{4})/g, "$1 ");
    return true;
  } else {
    return false;
  }
}

function numberValidation(e) {
  e.target.value = e.target.value.replace(/[^\d ]/g, "");
  return false;
}

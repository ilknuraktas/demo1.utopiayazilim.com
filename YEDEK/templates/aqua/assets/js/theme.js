'use strict';

$('#shopphp-payment-body-step1 input.sf-button').val('SİPARİŞİ ONAYLA / ÖDEME YAP');
$('.rulesButtons .sf-button').val('SİPARİŞİ ONAYLA VE DEVAM ET');
$('.payment .paymentTab .tabLinks ul li a.pt5').text('Diğer');
$("#gf_kargoFirmaID option:eq(1)").attr('selected','selected');
if(!$("#orderBy").val()) $("#orderBy option:eq(1)").attr('selected','selected');
$(".rulesBox input").attr('checked','checked');
$("input#odeme-onay").attr('checked','checked');

$('.dropmenu .fa').click(function() { $(this).parent().find('ul').toggle(); });

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function replaceTurkishChars(str){
	var charMap = {
      Ç: 'C',
      Ö: 'O',
      Ş: 'S',
      İ: 'I',
      I: 'i',
      Ü: 'U',
      Ğ: 'G',
      ç: 'c',
      ö: 'o',
      ş: 's',
      ı: 'i',
      ü: 'u',
      ğ: 'g'
    };
    var str_array = str.split('');
    for (var i = 0, len = str_array.length; i < len; i++) {
      str_array[i] = charMap[str_array[i]] || str_array[i];
    }
    str = str_array.join('');
    var clearStr = str.replace(/[çöşüğı]/gi,"");
	
	return clearStr;
}
$("#gf_email").on("change",function(){
	var email = $.trim($(this).val());
	email = email.replace(/ /g,'');
	email = replaceTurkishChars(email);
	email = email.toLowerCase();
	
	$(this).val(email);
	
	if(isEmail(email)==false){
		$(this).parents('form').find('input[type="button"]').prop('disabled',true);
		alerter.show('Lütfen mail adresinizi kontrol edin!');
	}else {
		$(this).parents('form').find('input[type="button"]').prop('disabled',false);
		console.log("email doğru girildi");
	}
});

$(function() { var message = "Nereye gittin? :("; var original; $(window).focus(function() { if (original) { document.title = original; } }).blur(function() { var title = $('title').text(); if (title != message) { original = title; } document.title = message; }); });


if ($(window).width() < 960) {
	$('nav#menu').mmenu({
		extensions				: [ 'effect-slide-menu', 'shadow-page', 'shadow-panels' ],
		keyboardNavigation 		: false,
		screenReader 			: true,
		counters				: false,
		navbar 	: {
			title	: 'KATEGORİLER'
		},
		navbars	: [
			{
				position	: 'top',
				content		: [
					'prev',
					'title',
					'close'
				]
			}
		],
		"extensions": [
            "pagedim-black",
            "shadow-panels",
			"effect-menu-slide",
			"theme-white",
			"effect-listitems-fade"
         ]
	});
}

// Multi Level Drowpdown Menu Start
$(function() {
    $(".dropdown-menu > li > a.dropdown-toggle").on("click", function(e) {
        var current = $(this).next();
        var grandparent = $(this).parent().parent();
        if ($(this).hasClass('left-caret') || $(this).hasClass('right-caret'))
            $(this).toggleClass('right-caret left-caret');
        grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
        grandparent.find(".sub-menu:visible").not(current).hide();
        current.toggle();
        e.stopPropagation();
    });
    $(".dropdown-menu > li > a:not(.dropdown-toggle)").on("click", function() {
        var root = $(this).closest('.dropdown');
        root.find('.left-caret').toggleClass('right-caret left-caret');
        root.find('.sub-menu:visible').hide();
    });
});

// Mega Drowpdown Menu Start
jQuery(document).ready(function() {
    if (window.matchMedia('(min-width: 768px)').matches) {
        $(".dropdown").hover(
            function() {
                $('.dropdown-menu', this).stop(true, true).slideDown(10);
            },
            function() {
                $('.dropdown-menu', this).stop(true, true).slideUp(10);
            }
        );
    }

    if (window.matchMedia('(max-width: 767px)').matches) {
        $(".mega-dropdown").hover(
            function() {
                $('.dropdown-menu', this).stop(true, true).slideDown("fast");
            },
            function() {
                $('.dropdown-menu', this).stop(true, true).slideUp("fast");
            }
        );
    }

});

/*
$("#green-scroll").mCustomScrollbar({
	theme:"rounded-dots-dark"
});


if((".urunkat .katDesc").length > 0) {
	$(".urunkat .katDesc").mCustomScrollbar({
		theme:"rounded-dots-dark"
	});
}


$(".filtre_wrap").mCustomScrollbar({
	theme:"rounded-dots-dark"
});
*/
	
jQuery(document).ready(function() {

    $(window).bind("load", function() {
        $('#preloader').delay(1000).fadeOut(200);

    });

    var interval = null;

    interval = setInterval(function() {
        if ($("body:has(#preloader)")) {
            var babyclass = document.getElementsByClassName("baby");
            if (babyclass.length) {
                babyclass[0].classList.toggle('down');
            }
        }
    }, 500);

	 $('#katfilter').find('.filterdown').click(function (e) {
        e.preventDefault();
        $(this).next().slideToggle('fast');
        $(this).find('.fa').toggleClass('fa-caret-down fa-caret-up');
        $(".widget_content").not($(this).next()).slideUp('fast');
    });
	
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.to-top').fadeIn();
        } else {
            $('.to-top').fadeOut();
        }
    });

    $('.to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    jQuery(".mainsliderx").owlCarousel({
        autoPlay: true, //Set AutoPlay to 3 seconds
        items: 1,
        itemsDesktop: [1199, 1],
        itemsTablet: [1024, 1],
        itemsTabletSmall: [768, 1],
        itemsMobile: [480, 1],
        pagination: false,
        navigation: true,
        navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
    });

    jQuery(".product-slider").owlCarousel({
        autoPlay: true, //Set AutoPlay to 3 seconds
        pagination: true,
        navigation: false,
        navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
        items: 4,
        itemsDesktop: [1199, 4],
        itemsTablet: [1024, 3],
        itemsTabletSmall: [767, 2],
        itemsMobile: [480, 1]				
    });

    jQuery(".mobileSliderwrap").owlCarousel({
        autoPlay: true,
		pagination: true,
		autoHeight: true,
        items: 1,
        itemsDesktop: [1199, 1],
        itemsTablet: [1024, 1],
        itemsTabletSmall: [767, 1],
        itemsMobile: [480, 1]
    });
	
    jQuery("#brands-carousel-slider").owlCarousel({
        autoPlay: true,
        items: 7,
        itemsDesktop: [1199, 7],
        itemsDesktopSmall: [1024, 6],
        itemsTablet: [991, 4],
        itemsTabletSmall: [767, 3],
        itemsMobile: [480, 3]
    });
    jQuery(".brands-slider .next").click(function() {
        jQuery("#brands-carousel-slider").trigger('owl.next');
    });
    jQuery(".brands-slider .prev").click(function() {
        jQuery("#brands-carousel-slider").trigger('owl.prev');
    });

});
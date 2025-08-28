// Anasayfa Slider //
var swiper = new Swiper('.sliderAlani', {
spaceBetween: 0,
centeredSlides: true,
autoplay: {
delay: 5000,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
navigation: {
nextEl: '.aNext',
prevEl: '.aPrev',
},
});
// Anasayfa Slider //

// Anasayfa Çok Satanlar //
var swiper = new Swiper('.cokSatanlar', {
spaceBetween: 0,
slidesPerView: 2,
autoplay: {
delay: 5000,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
navigation: {
nextEl: '.cNext',
prevEl: '.cPrev',
},
});
// Anasayfa Çok Satanlar //

// Anasayfa İndirimli Ürünler //
var swiper = new Swiper('.indirimliUrunler', {
spaceBetween: 0,
slidesPerView: 2,
autoplay: {
delay: 5000,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
navigation: {
nextEl: '.iNext',
prevEl: '.iPrev',
},
});
// Anasayfa İndirimli Ürünler //

// Anasayfa Seçilen Ürünler //
var swiper = new Swiper('.secilenUrunler', {
spaceBetween: 0,
slidesPerView: 2,
autoplay: {
delay: 5000,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
navigation: {
nextEl: '.sNext',
prevEl: '.sPrev',
},
breakpoints: {
640: {
slidesPerView: 2,
spaceBetween: 20,
},
768: {
slidesPerView: 3,
spaceBetween: 20,
},
1024: {
slidesPerView: 5,
spaceBetween: 20,
},
}
});
// Anasayfa Seçilen Ürünler //

// Sol Çok Satan Ürünler //
var swiper = new Swiper('.solUrunler', {
spaceBetween: 0,
slidesPerView: 1,
autoplay: {
delay: 5000,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
navigation: {
nextEl: '.solNext',
prevEl: '.solPrev',
},
});
// Sol Çok Satan Ürünler //

// Ürün Detay İlgili Ürünler //
var swiper = new Swiper('.urundtyIlgili', {
spaceBetween: 0,
slidesPerView: 2,
autoplay: {
delay: 5000,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
navigation: {
nextEl: '.konuNext',
prevEl: '.konuPrev',
},
breakpoints: {
640: {
slidesPerView: 2,
spaceBetween: 20,
},
768: {
slidesPerView: 3,
spaceBetween: 20,
},
1024: {
slidesPerView: 5,
spaceBetween: 20,
},
}
});
// Ürün Detay İlgili Ürünler //

// Ürün Detay Tab Alanı //
$(function() {
var $tabButtonItem = $('#tab-button li'),
$urunDetayTabelect = $('#tab-select'),
$tabContents = $('.urnDtyTab'),
activeClass = 'is-active';

$tabButtonItem.first().addClass(activeClass);
$tabContents.not(':first').hide();

$tabButtonItem.find('a').on('click', function(e) {
var target = $(this).attr('href');

$tabButtonItem.removeClass(activeClass);
$(this).parent().addClass(activeClass);
$urunDetayTabelect.val(target);
$tabContents.hide();
$(target).show();
e.preventDefault();
});

$urunDetayTabelect.on('change', function() {
var target = $(this).val(),
targetSelectNum = $(this).prop('selectedIndex');

$tabButtonItem.removeClass(activeClass);
$tabButtonItem.eq(targetSelectNum).addClass(activeClass);
$tabContents.hide();
$(target).show();
});
});
// Ürün Detay Tab Alanı //

// Ürün Detay Çok Satanlar //
var swiper = new Swiper('.urundtycokSatanlar', {
spaceBetween: 0,
slidesPerView: 4,
autoplay: {
delay: 5000,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
});
// Ürün Detay Çok Satanlar //

// Ürün Detay Sepete Kaç Adet Ürün Eklenecek //
$('.le-quantity a').click(function(e){
e.preventDefault();
var currentQty= $(this).parent().parent().find('input').val();
if( $(this).hasClass('minus') && currentQty>0){
$(this).parent().parent().find('input').val(parseInt(currentQty, 10) - 1);
}else{
if( $(this).hasClass('plus')){
$(this).parent().parent().find('input').val(parseInt(currentQty, 10) + 1);
}
}
});
// Ürün Detay Sepete Kaç Adet Ürün Eklenecek //

function myFunction() {
document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function(event) {
if (!event.target.matches('.upGoster')) {

var dropdowns = document.getElementsByClassName("dropdown-content");
var i;
for (i = 0; i < dropdowns.length; i++) {
var openDropdown = dropdowns[i];
if (openDropdown.classList.contains('show')) {
openDropdown.classList.remove('show');
}
}
}
};


// Animate css efekt //

wow = new WOW(
{
animateClass: 'animated',
offset:       100,
callback:     function(box) {
console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
}
}
);
wow.init();

// Animate css efekt //

// Mobil menü Başlar //
(function($) {
var $main_nav = $('#main-nav');
var $toggle = $('.toggle');

var defaultData = {
maxWidth: false,
customToggle: $toggle,
navTitle: 'KATEGORİLER',
levelTitles: true,
pushContent: '#container',
insertClose: 2
};

// add new items to original nav
$main_nav.find('li.add').children('a').on('click', function() {
var $this = $(this);
var $li = $this.parent();
var items = eval('(' + $this.attr('data-add') + ')');
$li.before('<li class="new"><a>'+items[0]+'</a></li>');
items.shift();
if (!items.length) {
$li.remove();
}

else {
$this.attr('data-add', JSON.stringify(items));
}

Nav.update(true);
});
// call our plugin
var Nav = $main_nav.hcOffcanvasNav(defaultData);

// demo settings update
const update = (settings) => {
if (Nav.isOpen()) {
Nav.on('close.once', function() {
Nav.update(settings);
Nav.open();
});

Nav.close();
}
else {
Nav.update(settings);
}
};

$('.actions').find('a').on('click', function(e) {
e.preventDefault();

var $this = $(this).addClass('active');
var $siblings = $this.parent().siblings().children('a').removeClass('active');
var settings = eval('(' + $this.data('demo') + ')');

update(settings);
});

$('.actions').find('input').on('change', function() {
var $this = $(this);
var settings = eval('(' + $this.data('demo') + ')');

if ($this.is(':checked')) {
update(settings);
}
else {
var removeData = {};
$.each(settings, function(index, value) {
removeData[index] = false;
});
update(removeData);
}
});
})(jQuery);
// Mobil menü Biter //

<?php


$PAGE_OUT = '

<div class="sliderAlani">
<div class="swiper-wrapper">

'.weberSlider().'

</div>
<div class="swiper-pagination"></div>
<div class="aNext"><i class="fas fa-chevron-right"></i></div>
<div class="aPrev"><i class="fas fa-chevron-left"></i></div>
</div>
<div class="temizle"></div>

<div style="display: block;">
<div class="anasayfaUcluBlok mobildeGizle">
<div class="ucluBlokic">
<i class="fas fa-truck"></i>
<strong>ÜCRETSİZ KARGO</strong>
<p>50 TL ve üzeri alışverişlerinizde ücretsiz kargo imkanı.</p>
</div>
<div class="ucluBlokic">
<i class="far fa-credit-card"></i>
<strong>GÜVENLİ ALIŞVERİŞ</strong>
<p>Sitemiz, 256 Bit SSL Güvenlik Sertifikası İle Tamamen Güvenle Korunmaktadır.</p>
</div>
<div class="ucluBlokic">
<i class="fas fa-sync-alt"></i>
<strong>KOŞULSUZ İADE İMKANI</strong>
<p>Satın aldığınız ürünleri 15 gün içerisinde koşulsuz iade alıyor veya değiştiriyoruz.</p>
</div>
</div>
</div>
<div class="temizle"></div>

<div class="anasayfaYeniGelenler">
<div class="anasBaslik">
<h2>YENİ GELEN ÜRÜNLER</h2>
</div>
<div class="icerikListele">

'.urunList('select * from urun where yeni=1 order by seq desc, ID desc limit 0,8','empty','UrunListShow').'

</div>
</div>
<div class="temizle"></div>

<div style="display: block;">
<div class="anasayfaResimli">
'.insertBannerv5('index-1').'
'.insertBannerv5('index-2').'
'.insertBannerv5('index-3').'
</div>
</div>
<div class="temizle"></div>

<div style="display: block;">

<div class="anasayfaikiBlok">
<div class="anasBaslik">
<h2>ÇOK SATAN ÜRÜNLER</h2>
</div>
<div class="cokSatanlar">
<div class="swiper-wrapper">

'.urunList('select * from urun where active=1 order by sold desc limit 0,8','empty','UrunListShow2').'

</div>
<div class="swiper-pagination"></div>
<div class="cNext"><i class="fas fa-chevron-right"></i></div>
<div class="cPrev"><i class="fas fa-chevron-left"></i></div>
</div>
</div>

<div class="anasayfaikiBlok">
<div class="anasBaslik">
<h2>İNDİRİMDEKİ ÜRÜNLER</h2>
</div>
<div class="indirimliUrunler">
<div class="swiper-wrapper">

'.urunList('select * from urun where indirimde = 1 order by seq desc,ID desc limit 0,8','empty','UrunListShow2').'

</div>
<div class="swiper-pagination"></div>
<div class="iNext"><i class="fas fa-chevron-right"></i></div>
<div class="iPrev"><i class="fas fa-chevron-left"></i></div>
</div>
</div>

</div>
<div class="temizle"></div>

<div style="margin-top: 30px;">
<a>
'.insertBannerv5('index-buyuk').'
</a>
</div>
<div class="temizle"></div>

<div class="anasayfaTekliBlok">
<div class="anasBaslik">
<h2>SİZİN İÇİN SEÇTİKLERİMİZ</h2>
</div>
<div class="secilenUrunler">
<div class="swiper-wrapper">

'.urunList('select * from urun where anasayfa = 1 order by seq desc,ID desc limit 0,15','empty','UrunListShow2').'

</div>
<div class="swiper-pagination"></div>
<div class="sNext"><i class="fas fa-chevron-right"></i></div>
<div class="sPrev"><i class="fas fa-chevron-left"></i></div>
</div>
</div>

'; ?>

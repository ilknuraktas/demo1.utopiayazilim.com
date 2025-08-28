<div class="urunDetay">
<div class="detail-block">

<div class="urunDetaySol">
<div id="urun-image-container">
<a href="images/urunler/{%DB_RESIM%}" class="lightbox">
<img class="detay-resim" src="images/urunler/{%DB_RESIM%}" />
</a>
</div>
<div class="clear-space"></div>
{%URUN_RESIM_LIST%}
<div class="clearfix"></div>
</div>

<div class="urunDetaySag">
<h2>{%DB_NAME%}</h2>
<div style="display: block;">
<strong>Marka:</strong>
<font>{%MARKA_ADI%}</font>
</div>
<div class="temizle"></div>
<div class="fiyatBilgisi">
<strong>{%PIYASA_INDIRIM_ORANI%}</strong>
<p class="pfiyati">{%URUN_PIYASA_FIYAT%}</p>
<p class="sfiyati">{%URUN_FIYAT%}</p>
</div>
<div class="temizle"></div>

{%URUN_SECIM_LISTE%} {%UCRETSIZ_SECIM_FORM%} {%ILGILI_SECIM_FORM%}

<div class="temizle"></div>

{%KARGO_SAYAC%}

<div class="temizle"></div>

<div class="scrollbar" id="style-4">
<div class="force-overflow">
{%DB_ONDETAY%}
</div>
</div>

<div class="temizle"></div>

<div style="display: block;">
{%func-data_anindaGonderim%}
{%func-data_kargoBeles%}
{%func-data_yerliUretims%}
</div>

<div class="temizle"></div>

<div class="kullaniciSenecekleri">
{%URUN_KULLANICI_SECENEKLERI%}
</div>

<div style="margin-top: 15px;" class="temizle"></div>

<div class="le-quantity">
<form>
<a class="minus" href="#reduce"></a>
<input name="quantity" readonly type="text" value="1" class="urunSepeteEkleAdet" />
<a class="plus" href="#add"></a>
</form>
</div>

<div class="detaySepet" onclick="{%SEPETE_EKLE_LINK%}"><i class="fas fa-shopping-cart"></i> Sepete Ekle</div>
<div class="detayHemenAl" onclick="{%HEMEN_AL_LINK%}"><i class="fas fa-check"></i> Hemen Al</div>

</div>
</div>

</div>

<div class="temizle"></div>

<div class="urunDetayTab">
<div class="tab-button-outer">
<ul id="tab-button">
<li><a href="#tab01">ÜRÜN DETAYI</a></li>
<li><a href="#tab02">TAKSİT SEÇENEKLERİ</a></li>
<li><a href="#tab03">ÜRÜN YORUMLARI</a></li>
</ul>
</div>
<div class="tab-select-outer">
  <strong>SEÇENEKLER :</strong>
<select id="tab-select">
<option value="#tab01">ÜRÜN DETAYI</option>
<option value="#tab02">TAKSİT SEÇENEKLERİ</option>
<option value="#tab03">ÜRÜN YORUMLARI</option>
</select>
</div>

<div id="tab01" class="urnDtyTab">
<div class="tabtable">
{%DB_DETAY%}
</div>
</div>
<div id="tab02" class="urnDtyTab">
{%TAB_TAKSIT%}
</div>
<div id="tab03" class="urnDtyTab">
{%TAB_YORUM%}
</div>
</div>

<div class="temizle"></div>

<div class="anasayfaTekliBlok">
<div class="anasBaslik">
<h2>İLGİNİZİ ÇEKEBİLİR</h2>
</div>
<div class="urundtyIlgili">
<div class="swiper-wrapper">
{%func-data_weberilgiliUrunler%}
</div>
<div class="swiper-pagination"></div>
<div class="konuNext"><i class="fas fa-chevron-right"></i></div>
<div class="konuPrev"><i class="fas fa-chevron-left"></i></div>
</div>
</div>

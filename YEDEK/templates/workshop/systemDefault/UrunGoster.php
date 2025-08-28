<div class="detail-block"> {%ICON_TEXT%} 
  <!-- detail photos -->
  <div class="detail-photos">
    <div id="urun-image-container"> <a href="images/urunler/{%DB_RESIM%}" class="lightbox"><img class="detay-resim" src="images/urunler/{%DB_RESIM%}" /></a> </div>
    <div class="clear-space">&nbsp;</div>
    {%URUN_RESIM_LIST%}
    <div class="clearfix"></div>
  </div>
  <!-- //detail photos --> 
  <!-- detail info -->
  <div class="detail-info">
    <div class="detail-name">{%DB_NAME%}</div>
    <div class="detail-info-left">
      <div class="detail-price">
        <div class="detail-normal-price"> <span class="row1">Piyasa Fiyatı</span> <span class="row2">:</span> <span class="row3">{%URUN_PIYASA_FIYAT%}</span> </div>
        <div class="detail-sale-price"> <span class="row1">Site Fiyatı</span> <span class="row2">:</span> <span class="row3">{%URUN_FIYAT%}</span> </div>
      </div>
      <div class="stock-amount">Bu ürünü indirimli alabileceğiniz {%DB_STOK%} stok kalmıştır.</div>
      <div class="other-price">
        <div class="cc-price"> <span class="row1">Kredi Kartı ile Tek Çekim</span> <span class="row2">:</span> <span class="row3">{%URUN_TEKCEKIM_FIYAT_YTL%} TL</span> </div>
        <div class="eft-price"> <span class="row1">Havale ile İndirimli</span> <span class="row2">:</span> <span class="row3">{%URUN_HAVALE_FIYAT_YTL%} TL</span> </div>
      </div>
      <div class="clear-space"></div>
      <div class="product-variant"> {%URUN_SECIM_LISTE%}
        {%UCRETSIZ_SECIM_FORM%} {%ILGILI_SECIM_FORM%} </div>
      <div class="detail-btn">
        <div class="sepete_at" onclick="{%SEPETE_EKLE_LINK%}">Sepete ekle</div>
        <div class="hemenal" onclick="{%HEMEN_AL_LINK%}">Hemen Satın Al</div>
      </div>
    </div>
    <div class="clear-space">&nbsp;</div>
    {%KARGO_SAYAC%}
    <div class="clear-space"></div>
    <div class="read-comments"> <a href="" onclick="$('.yorum-li').click(); return false;">Yorumları oku <b>({%YORUM_SAYISI%})</b></a>
      <ul>
        <li>{%URUN_PUAN%}</li>
      </ul>
    </div>
    <div class="detail-process-links"> {%URUN_KULLANICI_SECENEKLERI%} </div>
    <div class="clear-space">&nbsp;</div>
  </div>
  <!-- //detail info -->
  <div class="clear-space">&nbsp;</div>
  <div class="home-products">
    <ul id="tab-titles">
      <li class="">Açıklama</li>
      <li class="">Ödeme Bilgileri</li>
      <li class="">Video</li>
      <li class="yorum-li">Ürün Yorumları</li>
      <li class="">SSS</li>
    </ul>
    <div class="clear-space"></div>
    <div class="home-products-wrap"> 
      <!-- tab content -->
      <div class="tab-content"> {%DB_DETAY%}
        <div class="clear-space"></div>
      </div>
      <!-- //tab content --> 
      <!-- tab content -->
      <div class="tab-content"> 
        <!-- product --> 
        {%TAB_TAKSIT%}
        <div class="clear-space"></div>
      </div>
      <!-- //tab content --> 
      <!-- tab content -->
      <div class="tab-content"> 
        <!-- product --> 
        {%DB_VIDEO%}
        <div class="clear-space"></div>
      </div>
      <!-- //tab content --> 
      <!-- tab content -->
      <div class="tab-content"> {%TAB_YORUM%}
        <div class="clear-space"></div>
      </div>
      <!-- //tab content --> 
      <!-- tab content -->
      <div class="tab-content"> {%TAB_SORU%}
        <div class="clear-space"></div>
      </div>
      <!-- //tab content --> 
    </div>
  </div>
</div>

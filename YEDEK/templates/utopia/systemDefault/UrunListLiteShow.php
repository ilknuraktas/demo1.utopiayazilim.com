<div class="product">
    <figure class="product-media">
        <span class="product-label label-sale">{%PIYASA_INDIRIM_ORANI%} İndirim</span>
        <span class="product-label label-new">Yeni</span>
        <a href="{%URUN_DETAY_LINK%}">
            <img src="include/resize.php?path=images/urunler/{%DB_RESIM1%}&width=SRC" alt="{%URUN_ADI%}" class="product-image">
            <img src="include/resize.php?path=images/urunler/{%DB_RESIM2%}&width=SRC" alt="{%URUN_ADI%}" class="product-image-hover">
        </a>

        <div class="product-action-vertical">
            <a href="#" class="btn-product-icon btn-wishlist btn-expandable" onclick="{%Func-data_mc_alarmControl%}"><span>Favorilerim</span></a>
        </div>
        <!-- End .product-action -->
        <div class="product-action action-icon-top">
            <a href="#" class="btn-product btn-cart" onclick="{%SEPETE_EKLE_AJAX%}"><span>Sepete Ekle</span></a>
            <a href="#" class="btn-product btn-quickview" title="Hızlı Göster" onclick="{%SEPETE_EKLE_IFRAME%}"><span>Hızlı Göster</span></a>
        </div>
        <!-- End .product-action -->
    </figure>
    <!-- End .product-media -->
    <div class="product-body">
        <h3 class="product-title"><a href="{%URUN_DETAY_LINK%}">{%URUN_ADI%}</a></h3>
        <!-- End .product-title -->
        <div class="product-price">
            <span class="new-price">{%URUN_FIYAT%}</span>
            <span class="old-price">{%URUN_PIYASA_FIYAT%}</span>
        </div>

        <div class="ratings-container">
            <div class="ratings">
                <div class="ratings-val" style="{%Func-data_mc_UrunYorum%}"></div>
                <!-- End .ratings-val -->
            </div>
            <!-- End .ratings -->
            <span class="ratings-text">( {%YORUM_SAYISI%} YORUM )</span>
        </div>
        <!-- End .rating-container -->
    </div>
    <!-- End .product-body -->
</div>
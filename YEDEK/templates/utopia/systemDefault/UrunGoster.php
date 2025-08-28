<div class="page-content">
    <div class="container">
        <div class="product-details-top mb-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-gallery product-gallery-vertical">
                        <div class="row">
                            <figure class="product-main-image">
                                <img id="product-zoom" src="{%IMG_SRC%}" data-zoom-image="images/urunler/{%DB_RESIM%}" alt="product image">
                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                    <i class="icon-arrows"></i>
                                </a>
                            </figure>
                            <!-- End .product-main-image -->
                            <div id="product-zoom-gallery" class="product-image-gallery">
                                {%Func-data_mc_ImageV3%}
                            </div><!-- End .product-image-gallery -->
                        </div><!-- End .row -->
                    </div><!-- End .product-gallery -->
                </div><!-- End .col-md-6 -->

                <div class="col-md-6">
                    <div class="product-details product-details-centered">
                        <h1 class="product-title">{%URUN_ADI%}</h1>
                        <!-- End .product-title -->

                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="{%Func-data_mc_UrunYorum%}"></div><!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                            <a class="ratings-text" href="#product-review-link" id="review-link">( {%YORUM_SAYISI%} Yorumlar )</a>
                        </div><!-- End .rating-container -->

                        <div class="product-price">
                            <span class="new-price">{%URUN_FIYAT%}</span>
                            <span class="old-price">{%URUN_PIYASA_FIYAT%}</span>
                        </div>

                        <div class="product-content">
                            <p>{%DB_onDetay%}</p>
                        </div><!-- End .product-content -->

                        <div class="product-details-action">
                            <div class="details-action-col">
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" class="form-control urunSepeteEkleAdet_{%DB_ID%}" value="1" min="1" max="{%DB_STOK%}" step="1" data-decimals="0" required>
                                </div><!-- End .product-details-quantity -->
                                <a href="#" class="btn-product btn-cart" onclick="{%SEPETE_EKLE_AJAX%}"><span>Sepete Ekle</span></a>
                            </div><!-- End .details-action-col -->

                            <div class="details-action-wrapper">
                                <a href="#" class="btn-product btn-wishlist" title="Favorilere Ekle" onclick="{%Func-data_mc_alarmControl%}"><span>Favorilere Ekle</span></a>
                                <a href="#" class="btn-product btn-compare" title="Karşılaştır" onclick="karsilastirmaEkle('{%DB_ID%}');"><span>Karşılaştır</span></a>
                            </div><!-- End .details-action-wrapper -->
                        </div><!-- End .product-details-action -->


                    </div><!-- End .product-details -->
                </div><!-- End .col-md-6 -->
            </div><!-- End .row -->
        </div>
        <!-- End .product-details-top -->

        <div class="product-details-tab">
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                       role="tab"
                       aria-controls="product-desc-tab" aria-selected="true">Ürün Özellikleri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab"
                       aria-controls="product-info-tab" aria-selected="false">Ödeme Bilgisi</a>
                </li>
             
                <li class="nav-item">
                    <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab"
                       aria-controls="product-review-tab" aria-selected="false">Yorumlar ({%YORUM_SAYISI%})</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                     aria-labelledby="product-desc-link">
                    <div class="product-desc-content">
                        {%TAB_DETAY%}
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">
                        {%TAB_TAKSIT%}
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                     aria-labelledby="product-shipping-link">
                    <div class="product-desc-content">
                        {%TAB_DETAY%}
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                     aria-labelledby="product-review-link">
                    <div class="reviews">
                        {%TAB_YORUM%}
                    </div><!-- End .reviews -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div>
        <!-- End .product-details-tab -->
    </div>
</div>

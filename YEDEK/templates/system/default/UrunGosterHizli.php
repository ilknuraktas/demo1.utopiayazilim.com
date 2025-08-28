<div class="ajaxwrapper">
    <form id="ajaxBasketForm" action="page.php" method="get">
        <div class="ajaxsol">
            <p class="basket_title">
                <i class="fa fa-check" aria-hidden="true"></i> Ürünü sepetinize eklemek
                üzeresiniz..
            </p>

            <div class="pic">
                <center><img src="{%IMG_600%}" /></center>
            </div>

            <div class="clear-space">&nbsp;</div>
            <div class="hizli-urun-detay">{%DB_onDetay%}</div>
            <div class="clear-space">&nbsp;</div>

        </div>

        <div class="ajax_sag">

            <div class="pricearea">
                <div class="urun_goster ajaxVarFiyat">
                    <p class="name_main">
                        {%DB_name%}
                    </p>
                    <div class="myfiyat">
                        <div class="satis_fiyati">
                            <div class="label">KDV Dahil</div>
                            <div class="fiyat">
                                <span class="fiyat_deger">{%URUN_FIYAT%}</span>
                            </div>
                        </div>
                        <div class="havale_fiyati">
                            <div class="label">Havale Fiyatı</div>
                            <div class="fiyat">
                                <span class="fiyat_deger">{%URUN_HAVALE_FIYAT_YTL%}</span> <span class="fiyat_kur">TL</span>
                            </div>
                        </div>
                        <div class="clear-space">&nbsp;</div>

                        <div class="satis_fiyati">
                            <div class="label">Stok Kodu</div>
                            <div class="fiyat">
                                <span class="fiyat_deger">{%DB_ID%} {%DB_tedarikciCode%}</span>
                            </div>
                        </div>
                        <div class="havale_fiyati">
                            <div class="label">Marka</div>
                            <div class="fiyat">
                                <span class="fiyat_deger"><a href="{%MARKA_LINK%}" target="_parent">{%MARKA_ADI%}</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                {%URUN_SECIM_FORM%}
                <div class="clear-space">&nbsp;</div>
                <div>
                    {%ADET_FORM%}
                    Ad.
                </div>
                <div class="basketarea">
                    <button type="submit" class="add_basket_ajax" onclick="{%SEPETE_EKLE_LINK%}">Sepete Ekle</button>
                </div>
            </div>
            <button type="submit" class="alisveris_devam ajaxBasketClose" onclick="parent.jQuery.fancybox.close();">
                Alışverişe Devam Et
            </button>

        </div>
</div> 
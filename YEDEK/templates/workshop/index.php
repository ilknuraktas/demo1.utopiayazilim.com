<?php

$PAGE_OUT = '<div class="main-slider">			
				'.wsVitrinContent().'
				<!-- thumbnails -->
				<div class="thumbnails">
					<ul>
						'.wsVitrinThumb().'
					</ul>
				</div>
				<!-- //thumbnails -->
			</div>
			<!-- //main slider -->
			<!-- small slider -->
			<div class="small-slider">
				<img src="templates/workshop/img/campbant.png" alt="" class="camp-bant" />
				<ul class="campaign-slider">
					<!-- product -->
					'.urunList('select * from urun where indirimde = 1 order by seq desc, ID desc limit 0,10','empty','UrunListSliderShow').'
					<!-- //product -->
				</ul>
			</div>
			<!-- //small slider -->
			<div class="clear-space"></div>
			<!-- info bar -->
			<div class="info-bar">Sitemizden Tüm Ürünleri Kredi Kartına <b>9 Taksitle Satın Alın</b></div>
			<!-- //info bar -->
			<!-- home slider -->
			<div class="home-slider">
				<div class="slider-title"><img src="templates/workshop/img/slidertitle.png" alt="" /></div>
				<ul class="home-product-slider">
					<!-- product -->
					'.urunList('select * from urun where anasayfa=1 order by seq desc, ID desc limit 0,12','empty','UrunListSliderShow').'
				</ul>
				<div class="clear-space"></div>
			</div>
			<!-- //home slider -->
			<!-- home banner -->
			<div class="home-banner"><img src="templates/workshop/img/banner2.png" alt="" /></div>
			<!-- //home banner -->
			<!-- home products -->
			<div class="home-products">
				<ul id="tab-titles">
					<li>Yeni Gelenler</li>
					<li onclick="tabLoad(\'.tab-content:eq(1)\',\'anindaGonderim\',\'UrunList\',\'UrunListShow\');">Hızlı Kargo</li>
					<li onclick="tabLoad(\'.tab-content:eq(2)\',\'_stok\',\'UrunList\',\'UrunListShow\');">Sınırlı Stok</li>
					<li onclick="tabLoad(\'.tab-content:eq(3)\',\'indirimde\',\'UrunList\',\'UrunListShow\');">İndirimde</li>
				</ul>
				<div class="clear-space"></div>
				<div class="home-products-wrap">
					<!-- tab content -->
					<div class="tab-content">
						'.urunList('select * from urun where yeni=1 order by seq desc, ID desc').'
						<div class="clear-space"></div>
					</div>
					<!-- //tab content -->
					<!-- tab content -->
					<div class="tab-content">
					</div>
					<!-- //tab content -->
					<!-- tab content -->
					<div class="tab-content">
					</div>
					<!-- //tab content -->
					<!-- tab content -->
					<div class="tab-content">
					</div>
					<!-- //tab content -->
				</div>
			</div>
			<!-- //home products -->';
?>
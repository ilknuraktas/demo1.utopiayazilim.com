<article class="urunDetay">
	<section id="product-fullwidth" class="space-bottom-35 m-padding-bottom-0">
		<div class="single-product-wrap">
			<div class="list-category-details">
				<div class="row">
					<div class="col-md-7 col-sm-12">
						<div class="row">

							<div class="mobileSlider hidden-lg hidden-md">

								{%func-data_yeniUrun%}
								{%func-data_kargobeles%}
								{%func-data_tukendim%}

								<div class="mobileSliderwrap">
									{%func-data_mobileProductSlider%}
								</div>

								<div class="clearfix"></div>
							</div>

							<section id="main-slider" class="carousel slide main-slider hidden-xs hidden-sm">
								<div class="slider-pagination col-md-2 col-sm-3 col-xs-3">
									{%URUN_RESIM_LIST%}
								</div>

								<div class="col-md-10 col-sm-9 col-xs-9">
									<div class="carousel-inner product-fullwidth light-bg slider">

										{%func-data_yeniUrun%}
										{%func-data_kargobeles%}
										{%func-data_tukendim%}

										<a class="lightbox" title="{%URUN_BASLIK%}" href="images/urunler/{%DB_RESIM%}"><img class="img" src="{%IMG_600%}"></a>

									</div>
								</div>
							</section>

						</div>
					</div>

					<div class="col-md-5 col-sm-12">
						<div class="product-content">
							{%func-data_indirimOran%}
							<div class="rating">
								<span class="star active"></span>
								<span class="star active"></span>
								<span class="star active"></span>
								<span class="star active"></span>
								<span class="star active"></span>
							</div>
							<div class="product-name">
								<h1 class="urunDetay_h1">{%DB_NAME%}</h1>
							</div>

							<div class="product-availability">
								<ul class="stock-detail">
									<li>Ürün Kodu :<strong class="green-color">{%func-data_urunKod%}</strong></li>
									<li>Marka :<strong class="green-color"><a href="page.php?act=kategoriGoster&markaID={%func-data_markaID%}">{%MARKA_ADI%}</a></strong></li>
								</ul>
								<hr class="fullwidth-divider">
							</div>

							<div class="product-price">
								<h4 class="grey-btn-small old-price" data-oldprice="{%DB_PIYASAFIYAT%}">{%URUN_PIYASA_FIYAT%}</h4>
								<h4 class="blue-btn-small">{%URUN_FIYAT_KDV_DAHIL_YTL%} TL</h4>
							</div>
							<div class="clearfix"></div>
							<div class="product-variant">
								{%URUN_SECIM_LISTE%}
							</div>
							<div class="clearfix"></div>

							<div class="product-cart">
								<div class="form-group selectpicker-wrapper adetSecim">
									<label>Adet</label>{%ADET_FORM%}
								</div>

								<div class="add-to-cart">
									<a class="blue-btn btn btn-lg" href="#" onclick="{%SEPETE_EKLE_LINK%}"> <i class="fa fa-shopping-cart white-color"></i> SEPETE EKLE</a>
									<a class="green-btn btn btn-lg" href="#" onclick="{%HEMEN_AL_LINK%}"> <i class="fa fa-shopping-cart white-color"></i> HEMEN AL</a>
									<a class="btn default-btn favoribtn" href="#" onclick="{%ALARM_LISTEM_CLICK%}"> <i class="fa fa-heart"></i> </a>
								</div>

								<div class="clearfix"></div>

							</div>
							<div class="clearfix"></div>

							<div class="memnuniyet">
								<img src="templates/aqua/images/memnuniye_ikon.png" alt="memnuniyet garantisi" />
							</div>
							<div class="clearfix"></div>

							<br />
							<div class="addthis_widget_container">
								<!-- AddThis Button BEGIN -->
								<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
									<a class="addthis_button_preferred_1"></a>
									<a class="addthis_button_preferred_2"></a>
									<a class="addthis_button_preferred_3"></a>
									<a class="addthis_button_preferred_4"></a>
									<a class="addthis_button_compact"></a>
									<a class="addthis_counter addthis_bubble_style"></a>
								</div>
								<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fac1abe0d0e6aeb"></script>
								<!-- AddThis Button END -->
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="description-item">
		<div class="row">
			<div class="col-md-12 col-sm-12">

				<section id="single-product-tabination" class="space-bottom-25">
					<div class="light-bg product-tabination default-box-shadow">
						<div class="tabination">
							<div class="product-tabs" role="tabpanel">

								<ul role="tablist" class="nav nav-tabs navtab-horizontal">

									<li role="presentation" class="active">
										<a class="golden-background" data-toggle="tab" role="tab" href="#aciklama" aria-expanded="true">AÇIKLAMA</a>
									</li>

									<li role="presentation" class="">
										<a data-toggle="tab" class="pink-background" role="tab" href="#odeme" aria-expanded="false">ÖDEME BİLGİLERİ</a>
									</li>

									<li role="presentation" class="">
										<a data-toggle="tab" class="blue-background" role="tab" href="#yorum" aria-expanded="false">YORUMLAR</a>
									</li>

									<li role="presentation" class="">
										<a data-toggle="tab" class="green-background" role="tab" href="#iade" aria-expanded="false">İADE KOŞULLARI</a>
									</li>

									<li role="presentation" class="">
										<a data-toggle="tab" class="golden-background" role="tab" href="#sss" aria-expanded="false">SIKÇA SORULAN SORULAR</a>
									</li>

								</ul>

								<div class="tab-content">

									<div id="aciklama" class="tab-pane fade active in" role="tabpanel">
										<div class="col-md-12 product-wrap">
											<div class="product-disc space-25">
												{%DB_DETAY%}

												<div class="clearfix"></div>

												<div class="productDetail_Banks">
													<img src="templates/aqua/images/orta-banner.png" class="hidden-xs" alt="orta banner">
													<img src="templates/aqua/images/mobil_bankalar.png" class="hidden-lg hidden-md hidden-sm" alt="orta banner">
												</div>

												<div class="clearfix"></div>

												<div class="etikets">
													<br />
													<h6>ETİKETLER : {%ETIKET%} </h6>
												</div>

											</div>
										</div>
									</div>

									<div id="odeme" class="tab-pane fade" role="tabpanel">
										<div class="col-md-12 product-wrap">
											<div class="product-disc space-25">
												{%TAB_TAKSIT%}
											</div>
										</div>
									</div>

									<div id="yorum" class="tab-pane fade" role="tabpanel">
										<div class="col-md-12 product-wrap">
											<div class="product-disc space-25">
												{%TAB_YORUM%}
											</div>
										</div>
									</div>

									<div id="iade" class="tab-pane fade" role="tabpanel">
										<div class="col-md-12 product-wrap">
											<div class="product-disc space-25">
												<p>Satın almış olduğunuz ürünleri 14 gün içerisinde koşulsuz iade edebilirsiniz. İade edeceğiniz ürünlerin ambalajları bozulmamış ve faturasının olması gerekmektedir.</p>
												<p>Kusurlu ürünlerde kargo bedeli tarafımıza aittir, aksi durumda kargo ücreti alıcıya aittir. Geri gönderimlerde sadece Aras kargoyu kullanınız aksi durumda gelen kargolar iade departmanımız tarafından kabul edilmeyecektir.</p>
												<p>İadesi kabul edilen ürün/ürünlerde para iadesi aynı günde işlem yapılan kart hesabına yapılmaktadır, (geri iadeler bankanızın onay süresine göre farklılık gösterebilir)</p>
											</div>
										</div>
									</div>

									<div id="sss" class="tab-pane fade sss_panel" role="tabpanel">
										<div class="col-md-12 product-wrap">
											<div class="product-disc space-25">
												{%func-data_sss%}
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</section>

			</div>
		</div>
	</section>
</article>
<div class="clearfix"></div>
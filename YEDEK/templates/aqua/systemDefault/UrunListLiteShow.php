<div class="col-md-4 col-xs-6 clear-box productItem space-bottom-20">
<div class="item">
<div class="product-details">
<div class="product-media">      
    <a href="{%URUN_DETAY_LINK%}" title="{%DB_NAME%}">                                                  
	<img src="templates/aqua/resizer.php?src=images/urunler/{%DB_RESIM%}&h=250&w=313&zc=2" alt="{%DB_NAME%}">
	{%func-data_yeniUrun%}
	{%func-data_kargobeles%}
	{%func-data_anindaGonderim%}
	{%func-data_tukendim%}
	{%func-data_indirimOran%}
	</a>
	<div class="product-overlay">
		<a class="addcart blue-background fa fa-shopping-cart" href="{%URUN_DETAY_LINK%}"></a>
		<a class="likeitem green-background fa fa-heart" onclick="{%ALARM_LISTEM_CLICK%}" href=""></a>
	</div>
</div>
<div class="product-content">
	<div class="product-name">
		<h3><a href="{%URUN_DETAY_LINK%}" title="{%DB_NAME%}">{%DB_NAME%}</a></h3>
	</div>
	<div class="product-price">
		{%func-data_piyasafiyatx%}
		<h4 class="pink-btn-small">{%URUN_FIYAT%}</h4>
	</div>
</div>
</div>
</div>
</div>
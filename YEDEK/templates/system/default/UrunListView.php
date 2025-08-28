
<div class="list-view-product-container">
	<div class="list-view-left-block">

		<div class="clearfix"></div>
		<a href="{%URUN_DETAY_LINK%}" class="imgLink">
			<img alt="{%DB_NAME%}" src="{%IMG_400%}">
		</a>
	</div>
	<div class="list-view-right-block">
		<h5 class="list-view-product-name"><a href="{%URUN_DETAY_LINK%}" title="{%DB_NAME%}">{%DB_NAME%}</a></h5>
		<div class="list-view-content_price">
		{%func-data_indirimOranView%}
			<span class="list-view-price list-view-old-price" data-oldprice='{%DB_PIYASAFIYAT%}'>{%URUN_PIYASA_FIYAT%}</span><br />
			<span class="list-view-price list-view-product-price">{%URUN_FIYAT%}</span> 
		</div>
	</div>
</div>
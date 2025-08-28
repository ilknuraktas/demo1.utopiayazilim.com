function tempStart() {
	$(".tab-content").eq(0).show();
	$("#tab-titles li").eq(0).addClass("active-tab");
	$("#tab-titles li").click(function(){
	
	var number = $(this).index();
	$("#tab-titles li").removeClass("active-tab");
	$(".tab-content").hide().eq(number).fadeIn("slow");
	$("#tab-titles li").eq(number).addClass("active-tab");
	});
	

	if($('.page-inner-content .home-product-slider').length)
	{	
		$('.page-inner-content .home-product-slider').bxSlider({
			slideWidth: 190,
			minSlides: 5,
			maxSlides: 5,
			slideMargin: 0
		});
	}
	
	else
	{
		$('.home-product-slider').bxSlider({
			slideWidth: 190,
			minSlides: 4,
			maxSlides: 5,
			slideMargin: 0
		});
	}
	  
	$('.campaign-slider').bxSlider({
		slideWidth: 200,
		minSlides: 1,
		maxSlides: 5,
		slideMargin: 0
	});
	$('.sidebar-box.page-content  .page-inner-content .product:odd').css('borderRight','none');
}
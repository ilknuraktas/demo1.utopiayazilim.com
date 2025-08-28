function tempStart() {
$('.old-price').each(function () {
		if(($(this).attr('data-oldprice') == "0") || ($(this).attr('data-oldprice') == "")) {
			$(this).remove();
		}	
	});
	
}
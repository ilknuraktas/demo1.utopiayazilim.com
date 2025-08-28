function tempStart() {
	$(".tab-content").eq(0).show();
	$("#tab-titles li").eq(0).addClass("active-tab");
	$("#tab-titles li").click(function(){

	var number = $(this).index();
	$("#tab-titles li").removeClass("active-tab");
	$(".tab-content").hide().eq(number).fadeIn("slow");
	$("#tab-titles li").eq(number).addClass("active-tab");
	});
	};

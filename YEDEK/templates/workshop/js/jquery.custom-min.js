
	$(document).ready(function(){

	///// Ajax Arama Yap ////

	$("#search-box").keyup(function(){

		

		if($(this).val().length >= 3){


		if($(this).val() != "" ){

			

		$.ajax({

		type: "POST",

		url: "templates/workshop/search/search-ajax.php",

		data:'keyword='+$(this).val(),

		beforeSend: function(){


		},

		success: function(data){

			if(data){

				

			$(".ac_resultsa").show();


			if(data=="<ul></ul>"){

							$(".ac_resultsa").html("<li class='incorrect'><b><i class='fa fa-pause-circle-o'></i> Herhangi Bir Sonuç Bulunamadı.</b></li>");



				

			}

			else{

				

			$(".ac_resultsa").html(data);



			}

			

			}

			else{

				$(".ac_resultsa").hide();

				$(".ac_resultsa").html("");

			}



		}

		});

		

			

		}

		

		else{

			

				$(".ac_resultsa").hide();

				$(".ac_resultsa").html("");

				

		}



		

		}

		else{

		$(".ac_resultsa").hide();

		$(".ac_resultsa").html("");

		}

		

		

	});



});
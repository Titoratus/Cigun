$(document).ready(function(){
	$('.owl-carousel').owlCarousel({
	    loop:true,
	    margin:20,
	    nav:false,
	    responsive:{
	        0:{
	            items:1
	        },
	        1000:{
	            items: 2
	        }
	    }
	});

	// popup в "Ступенях"
	$(".open-popup-link").magnificPopup({ mainClass: 'mfp-fade' });

	$(document).on("click", ".class_sign", function() {

		var class_name = $(this).parent().children("h4").text();
				where = $(this).parent().children(".class_where").html();
				when = $(this).parent().children(".class_when").html();

		$("#class_sign_up").find("h3").html("Запись на "+class_name);
		$("#class_sign_up").find(".class_where").html(where);
		$("#class_sign_up").find(".class_when").html(when);

		$('.popup-with-form').magnificPopup({
			type: 'inline',
			preloader: false,
			focus: '#name',
			mainClass: 'mfp-fade'
		}).magnificPopup('open');

	});

});
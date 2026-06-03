$(window).scroll(function(){
    if ($(window).scrollTop() >= 200) {
        $('header').addClass('fixed-header');
        $('nav div').addClass('visible-title');
    }
    else {
        $('header').removeClass('fixed-header');
        $('nav div').removeClass('visible-title');
    }
});
$(document).ready(function(){
  $(".arrow").click(function(){
    $("#categorie-Toggle").slideToggle();
  });
});
jQuery(document).ready(function(){
	jQuery(document).on("click",".arrow",function(){
	if (jQuery(this).hasClass("active")){
	     jQuery(this).removeClass("active");
	}
	else{
	 jQuery(this).addClass("active");
	}
	})
});
function myFunction(x) {
  x.classList.toggle("change");
}
$('.owl-carousel').owlCarousel({
	    loop:true,
	    margin:10,
	    autoplay:true,
	    autoplayTimeout:6000,
    	autoplayHoverPause:true,    	
	    nav:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:1
	        },
	        1000:{
	            items:1
	        }
	    }
});
$('.testimony-slide').owlCarousel({
	    loop:true,
	    margin:10,
	    nav:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:1
	        },
	        1000:{
	            items:1
	        }
	    }
});




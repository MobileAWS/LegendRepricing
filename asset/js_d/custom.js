// JavaScript Document
/*
    $(window).load(function(){	

      $('.flexslider').flexslider({

        animation: "slide",

        start: function(slider){

          $('body').removeClass('loading');

        }

      });

    });		
$http({
    method: 'GET',
    url: 'api/Entries/'
}).success(function (data, status, header, config) {
    successcb(data);
}).
error(function (data, status, header, config) {
    $log.warn(data, status, header, config);
});*/



/*		jQuery(function() {

		jQuery('a[href*=#]:not([href=#])').click(function() {

			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

				var target = jQuery(this.hash);

				target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');

				if (target.length) {

					jQuery('html,body').animate({

						scrollTop: target.offset().top

					}, 1000);

					return false;

				}

			}

		});

	});	

*/

$(window).ready(function(){
		$(".scroll").click(function(event) {
			$('html,body').animate({ scrollTop: $(this.hash).offset().top }, 500);
		});
	});
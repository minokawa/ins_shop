

jQuery(document).ready(function($){
    $('#brand > a').attr("href", "https://www.inspireeducation.net.au");

    /*
        Contact US Link at the header click function
     */
    $('#marketoinspireform').click(function(){
        if( typeof templateUrl === "undefined" ){
            var templateUrl = "https://www.inspireeducation.net.au";
        }
        window.location.replace( templateUrl + '/contact-us' );
    });

		if($('.variations_form').length > 0){

			$('.variations input[type=radio]').on('change',function(){
					var var_id = $('.variations input[type=radio]:checked').data('key');
					$('.variations_form').find( 'input[name=variation_id]' ).val( var_id ).change();
					$('.variations_form').trigger( 'found_variation', [ $('.variations_form').data( 'product_variations' )[var_id] ] );
			});
		}

		if ($('#ccf_main_lang').val() == 'Not Stated'){
			$('#english-level').fadeIn("200", "linear");
		}
		var splide = new Splide( '.cross-sell-wrapper',{"type":"loop","perPage":3} );
		splide.mount();
});



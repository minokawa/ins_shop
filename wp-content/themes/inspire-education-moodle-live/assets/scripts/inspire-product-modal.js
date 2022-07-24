(function(){

  $('#category-tabs-shop a').click(function ( event ) {
    numItems = null;
    $('#course-count').empty();
    var userid = $(this).attr('class');
    $('#product-courses .' + userid).addClass("boomer").delay(10).fadeIn(400);
    var numItems = $('.boomer').length;
    $('#course-count').append(numItems);

    event.preventDefault();
  });

  $('#cart-modal-shop').on('hidden.bs.modal', function() {
    $('#product-courses li.boomer').removeClass('boomer').removeAttr("style");
  })

	var product_entry_template = document.getElementById("product-entry-template").innerHTML;
	function do_moodle_event_checks(products_to_check){


		jQuery.ajax({
			url: inspire_product_modal_data.rest.endpoints.event_check,
			method: "POST",
			dataType: "json",
			timeout: inspire_product_modal_data.rest.timeout,
			data: { 'wp_nonce_product_modal': inspire_product_modal_data.rest.nonce, 'product_ids' :  products_to_check}
		}).done(function (result) {

			products_to_check.forEach(pid => {
				event_details = result[pid];
				if(event_details === undefined){
					jQuery("ul#product-courses").find(`[data-pid='${pid}']`).remove()
				}else{
					jQuery("ul#product-courses").find(`[data-pid='${pid}'] .event-details`).html(event_details)
				}
			});
		});
	}



	jQuery.ajax({
		url: inspire_product_modal_data.rest.endpoints.products,
		method: "GET",
		dataType: "json",
		timeout: 999999,
		data: { 'wp_nonce_product_modal': inspire_product_modal_data.rest.nonce }
	}).done(function (result) {

    $('#cart-modal-shop').delay(10).modal('hide');
    $('.products-modal').find('.loading_products').hide();
    $('.products-modal').find('.modal_title').show();

    var template = Handlebars.compile(product_entry_template);
		for (let [key, value] of Object.entries(result.products)) {
			var html = template(value);
			$('#product-courses').append(html);
		}

		if (result.event_check.length !== 0) {
			do_moodle_event_checks(result.event_check);
		}

	});

	Handlebars.registerHelper('encodeMyString',function(inputData){
		return new Handlebars.SafeString(inputData);
	});

})();



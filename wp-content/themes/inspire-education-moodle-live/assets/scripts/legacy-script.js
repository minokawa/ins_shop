
//Genaral scripts
(function () {
  //Dropdown Menu
  var getURLParams = function() {
    var temp = {};
    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function() {
        var decode = function(s) {
            return decodeURIComponent(s.split("+").join(" "));
        };
        temp[decode(arguments[1])] = decode(arguments[2]);
    });
    return temp;
  };
  function over_callback() {
    $(this).find(".sub, .sub-menu").stop().fadeTo("fast", 1).show();
    (function (a) {
        jQuery.fn.calcSubWidth = function () {
            rowWidth = 0;
            a(this).find("ul").each(function () {
                rowWidth += a(this).width()
            })
        }
    })(jQuery);
    if ($(this).find(".row").length > 0) {
        var a = 0;
        $(this).find(".row").each(function () {
            $(this).calcSubWidth();
            if (rowWidth > a) {
                a = rowWidth
            }
        });
        $(this).find(".sub, .sub-menu").css({
            width: a
        });
        $(this).find(".row:last").css({
            margin: "0"
        })
    } else {
        $(this).calcSubWidth();
        $(this).find(".sub, .sub-menu").css({
            width: rowWidth
        })
    }
  }
  function out_callback() {
    $(this).find(".sub, .sub-menu").stop().fadeTo("fast", 0, function () {
        $(this).hide()
    })
  }
  $("#nav li .sub, #nav li .sub-menu").css({ opacity: "0" });
  $("#nav li").hoverIntent({ sensitivity: 1,	interval: 1, over: over_callback, timeout: 100, out: out_callback});
  var is_utm_page =$('#course-form-modal, .page-template-page-course-sub-button-left-new-php, .page-template-page-course-sub-button-left-new-autoform-php, .page-template-page-course-sub-button-left-new-autoform-short-php, .page-template-page-thankyou-php, .courses_page').length;

  if( is_utm_page > 0 ){
    document.getElementById("utm_source__c").value =  getURLParams()["utm_source"];
    document.getElementById("utm_medium__c").value = getURLParams()["utm_medium"];
    document.getElementById("utm_campaign__c").value = getURLParams()["utm_campaign"];
    document.getElementById("utm_content__c").value = getURLParams()["utm_content"];
    document.getElementById("utm_term__c").value = getURLParams()["utm_term"];
  }

  //Google Click Identifier
  function getParam(p) {
		var match = RegExp('[?&]' + p + '=([^&]*)').exec(window.location.search);
		return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
  }

  function getExpiryRecord(value) {
		var expiryPeriod = 90 * 24 * 60 * 60 * 1000;
		var expiryDate = new Date().getTime() + expiryPeriod;
		return {
			value: value,
			expiryDate: expiryDate
		};
	}

	function addGclid() {
		var gclidParam = getParam('gclid');
		var gclidFormFields = ['GCLID__c'];
		var gclidRecord = null;
		var currGclidFormField;
		var gclsrcParam = getParam('gclsrc');
		var isGclsrcValid = !gclsrcParam || gclsrcParam.indexOf('aw') !== -1;
		gclidFormFields.forEach(function (field) {
			if (document.getElementById(field)) {
				currGclidFormField = document.getElementById(field);
			}
		});
		if (gclidParam && isGclsrcValid) {
			gclidRecord = getExpiryRecord(gclidParam);
			localStorage.setItem('gclid', JSON.stringify(gclidRecord));
		}
		var gclid = gclidRecord || JSON.parse(localStorage.getItem('gclid'));
		var isGclidValid = gclid && new Date().getTime() < gclid.expiryDate;
		if (currGclidFormField && isGclidValid) {
			currGclidFormField.value = gclid.value;
		}
	}
	window.addEventListener('load', addGclid);

})();

//Shop Page
(function () {
  $('input[value="One Upfront Payment"]').siblings( ".price" ).css( "color", "#ff0000" );
  var hash = window.location.hash.replace("#", "");
  Cookies.set("referral", hash, { expires: 7, path: '/' });
})();

//Checkout Page
(function () {
  var curr_page = $(document.body);
  if( !curr_page.hasClass('checkout')){ return; }

  var checkout_page = curr_page;
  var clickable_steps = checkout_page.find('#checkout-steps');
  checkout_page.find('#checkout').garlic();
  checkout_page.find('select').select2().on('change', function() { $(this).trigger('blur');} );
  checkout_page.on( 'applied_coupon_in_checkout removed_coupon_in_checkout', function(event, coupon){
    checkout_page.trigger( 'update_checkout' );
    location.reload();
  });

  clickable_steps.find('li.step.link a').on('click', function(event){
    var target_fieldset = $(this).data('fieldset');
    var active_fieldset = $('fieldset.active')
    var target_panel = $('#step' + target_fieldset);

    new Promise((resolve, reject) => {
      //checkout_page.trigger( 'update_checkout' );
      resolve();
    }).then(()=>{

      //Panels
      active_fieldset.removeClass(' in active');
      target_panel.addClass('in active');

      //Clickable Steps
      clickable_steps.find('li').addClass('in active');
      clickable_steps.find('a').removeClass('selected');
      clickable_steps.find('a[data-fieldset="' + target_fieldset + '"]').addClass('selected');
      clickable_steps.find('li[data-fieldset="' + target_fieldset + '"] ~ li').removeClass('active in');
      Cookies.set("checkout_step", 'step'+target_fieldset , { expires: 7, path: '/' });
    }).then(()=>{

			if(target_fieldset != 5){
				$( document.body ).trigger( 'update_checkout' );
			}

      $('html, body').stop().animate({
          'scrollTop': jQuery('.woocommerce-info').offset().top
      }, 200, 'swing');
    });

    if(checkout_page.hasClass('checkout')){ event.preventDefault(); }
  });

  checkout_page.find('.next').on('click', function () {
    next = $(this).data('next-block');
    clickable_steps.find('li.step.link a[data-fieldset="' + next + '"]').trigger('click')
  });

  checkout_page.find('.previous').on('click', function () {
    next = $(this).data('prev-block');
    clickable_steps.find('li.step.link a[data-fieldset="' + next + '"]').trigger('click')
  });

  checkout_page.find('#next-personal').click(function(){

    var newstate = $("#billing_state").val();
    if(newstate==''||newstate==null||newstate=='undefined'){ return false; }
    var product_id = Cookies.get('product');
    var leadInfo = {
      FirstName         : $('#billing_first_name').val(),
      LastName          : $('#billing_last_name').val(),
      State 	          : $('#billing_state').val(),
      Phone 	          : $('#billing_mobile_phone').val(),
      Email 	          : $('#billing_email').val(),
      Shop_Course_Name__c : product_look_up[product_id],
      LeadSource          : 'Web Lead - Shop'
    };
    if (typeof Munchkin != "undefined") {
      var hashCode = CryptoJS.SHA1(Cookies.get("apiKey") + $('#billing_email').val());
      Munchkin.munchkinFunction(
        'associateLead',
        leadInfo,
        hashCode
      );
    }
    Cookies.set("apiKey", null, { path: '/' });
  });



	if(	$('input#shiptobilling-checkbox').is(":checked") == 1){
		$('.shipping_address').fadeToggle("400", "linear").css("display","flex");
	}

  $('input#shiptobilling-checkbox').change(function() {
    $('.shipping_address').fadeToggle("400", "linear").css("display","flex");
    return false;
  });

	if(	$('input#secondry-address-checkbox').is(":checked") == 1){
		$('.secondary_address').fadeToggle("400", "linear").css("display","flex");
	}

  $('input#secondry-address-checkbox').change(function() {
    $('.secondary_address').fadeToggle("400", "linear").css("display","flex");
    return false;
  });




	if(	$('input#ccf_usi_checkbox').is(":checked") == 1){
		$('.usi_num').fadeToggle("400", "linear").css("display","flex");
	}

  $('input#ccf_usi_checkbox').change(function() {
    $('.usi_num').fadeToggle("400", "linear").css("display","flex");
    return false;
  });

  $('#ccf_delivery_full:input').click(function () {
    $('#blended_location_timetable').slideUp();
    $('#blended_location_timetable input:checked').removeAttr('checked');
    $('#blended_location_timetable select').prop('selectedIndex',0);
    $('#full_location_timetable, #full_location_timetable_2').slideDown();
    return false;
  });

  $('#ccf_distance_start_asap').change(function() {
    $('#ccf_distance_start_date').val('').text('');
    if ($('#ccf_distance_start_asap:checked').val() == 'Yes') {
    $('#ccf_distance_start_date').prop( 'disabled', true );
    } else {
        $('#ccf_distance_start_date').prop( 'disabled', false );
    }
    return false;
  });

  var referralID = Cookies.get("referral");
  $("#referral-id").prop("value", referralID);
  Cookies.remove('referral', { path: '/' })


      // Show/Hide relevant fields for blended & full deliveries
    if($('#ccf_delivery_blend:checked').val() == 'Blended') {
        $('#blended_location_timetable').slideDown();
        $('.location_timetables').fadeIn(100);

        var id = $('#blended_location_timetable input:checked').attr('id');
        if ($('.location_timetables_inner.'+id+'-timetable').is(":hidden"))  {
            $('.location_timetables_inner').fadeOut("200", "linear");
            $('.location_timetables_inner.'+id+'-timetable, .location_timetables_inner.'+id+'_2-timetable').delay(300).fadeIn("200", "linear");
        } else {
            $('.location_timetables_inner.'+id+'-timetable, .location_timetables_inner.'+id+'_2-timetable').fadeIn("200", "linear");
        }
    }
    if ($('#ccf_delivery_full:checked').val() == 'Full') {
        $('#full_location_timetable, #full_location_timetable_2').slideDown();
        $('.location_timetables, .location_timetables_2').fadeIn(100);
        var id = $('#full_location_timetable input:checked').attr('id');
        var idtwo = $('#full_location_timetable_2 input:checked').attr('id');

        if ($('.location_timetables_inner.'+id+'-timetable, .location_timetables_inner_2.'+idtwo+'-timetable').is(":hidden"))  {
            $('.location_timetables_inner, .location_timetables_inner_2').fadeOut("200", "linear");
            $('.location_timetables_inner.'+id+'-timetable, .location_timetables_inner_2.'+idtwo+'-timetable').delay(300).fadeIn("200", "linear");
        } else {
            $('.location_timetables_inner.'+id+'-timetable, .location_timetables_inner_2.'+idtwo+'-timetable').fadeIn("200", "linear");
        }
    }
    // Show timetables for blended & full delivery options
    $('#blended_location_timetable input, #full_location_timetable input').change(function() {
      $('.location_timetables').fadeIn(100);
      var id = $(this).attr('id');
      if ($('.location_timetables_inner.'+id+'-timetable').is(":hidden"))  {
        $('.location_timetables_inner').fadeOut("200", "linear");
        $('.location_timetables_inner select').find('option:eq(0)').prop('selected', true);
        $('.location_timetables_inner.'+id+'-timetable, .location_timetables_inner.'+id+'_2-timetable').delay(300).fadeIn("200", "linear");
      } else {
        $('.location_timetables_inner.'+id+'-timetable, .location_timetables_inner.'+id+'_2-timetable').fadeIn("200", "linear");
      }
      return false;
    });
    // Show timetable for second full delivery option
    $('#full_location_timetable_2 input').change(function() {
      $('.location_timetables_2').fadeIn(100);
      var id = $(this).attr('id');
      if ($('.location_timetables_inner_2.'+id+'-timetable').is(":hidden"))  {
        $('.location_timetables_inner_2').fadeOut("200", "linear");
        $('.location_timetables_inner_2.'+id+'-timetable').delay(300).fadeIn("200", "linear");
      } else {
        $('.location_timetables_inner_2.'+id+'-timetable').fadeIn("200", "linear");
      }
      return false;
    });

    // Show / hide english level
    $('#ccf_main_lang').change(function(){
      if ($('#ccf_main_lang').val() == 'Not Stated'){
        $('#english-level').fadeIn("200", "linear");
      } else {
        $('#english-level').fadeOut("200", "linear");
      }
      return false;
    });

    // Show / hide disabillity
    $('input:radio[name="ccf_disability_toggle"]').change(function(){
      if ($(this).is(':checked') && $(this).val() == 'Yes') {
        $('#disability-type').fadeIn("200", "linear");
      } else {
        $('#disability-type').fadeOut("200", "linear");
        $('#disability-type input:checked').removeAttr('checked');
      }
    });
    if ($('#ccf_disability_toggleYes:checked').val() == 'Yes') {
      $('#disability-type').fadeIn("200", "linear");
    }

    // Show / hide Education
    $('input:radio[name="ccf_prior_edu"]').change(function(){
        if ($(this).is(':checked') && $(this).val() == 'Yes') {
            $('#prior_education_options').fadeIn("200", "linear");
        } else {
            $('#prior_education_options').fadeOut("200", "linear");
            $('#prior_education_options input:checked').removeAttr('checked');
        }
    });

    if ($('#ccf_prior_eduYes:checked').val() == 'Yes') {
    $('#prior_education_options').fadeIn("200", "linear");
    }

    // Show / hide aus resident
    $('input:radio[name="ccf_ausres"]').change(function(){
        if ($(this).is(':checked') && $(this).val() == 'No') {
            $('#visa_disclaimer').fadeIn("200", "linear");
        } else {
            $('#visa_disclaimer').fadeOut("200", "linear");
        }
    });

    if ($('#ccf_ausresNo:checked').val() == 'No') {
    $('#visa_disclaimer').fadeIn("200", "linear");
    }

    // Make sure 'Place Order' button is enabled on initial load
    $('#place_order').prop('disabled', false);
})();


jQuery(document).ready(function($) {

	function eventlocationname(eventids,courseid) {
	 // var courseid = document.getElementById('moodlecourseid').value;
		var custom_id = document.getElementById('custom_id');
		var spacialevent = '';
		if(custom_id){
			spacialevent = 'spacial';
		}

		var ids1 = 'ccf_event_id_'+eventids;
		var eventid = eventids;
		var ids2 = 'ccf_delivery_location_'+eventids+'_'+courseid;
		var locationid = jQuery( "#"+ids2+" option:selected" ).val();

		jQuery.ajax({
			method: "GET",
			url: home_url +  "/ajax_moodle.php",
			data: { course_id: courseid, eventid_id: eventid,location_id:locationid,action:'eventlocation',eventtype:spacialevent,display:'name' }
		}).done(function( msg ) {
			var valueto = 'ccf_delivery_location_timetable_full_'+eventids+'_'+courseid;
			document.getElementById(valueto).innerHTML = msg;
		});
	}

	function eventclass(eventids) {
		var courseid = document.getElementById('moodlecourseid').value;
		var ids = 'ccf_event_id_'+eventids;
		var eventid = jQuery( "#"+ids+" option:selected" ).val();

		jQuery.ajax({
			method: "GET",
			url: home_url +  "/ajax_moodle.php",
			data: { course_id: courseid, eventid_id: eventid,action:'eventclass' }
		})
		.done(function( msg ) {
			var valueto = 'ccf_delivery_location_'+eventids;
			document.getElementById(valueto).innerHTML = msg;
		});

	}



	function eventupdatetime(event) {
		var eventid = event.value;
		jQuery.ajax({
			method: "GET",
			url: home_url +  "/ajax_moodle.php",
			data: { evid: eventid ,eventtyme:'time' }
		}).done(function( msg ) {
			//alert(msg);
			//var valueto = 'ccf_delivery_location_timetable_full_'+eventids;
			document.getElementById('time_event').value = msg;
		});
	}


	$('.ccf_delivery_location_select').on('blur', function(){

		eventids = $(this).data('evestr');
		courseid = $(this).data('mcourid');

		var custom_id = document.getElementById('custom_id');
		var spacialevent = '';

		if(custom_id){ spacialevent = 'spacial'; }

		var ids1 = 'ccf_event_id_'+eventids;
		var eventid = eventids;
		var ids2 = 'ccf_delivery_location_'+eventids+'_'+courseid;

		var locationid = jQuery( "#"+ids2+" option:selected" ).val();
		var dateId = 'ccf_delivery_location_timetable_full_'+eventids+'_'+courseid;

		document.getElementById(dateId).innerHTML = "<option>Updating timetables...</option>";

		jQuery.ajax({
			method: "GET",
			url: home_url +  "/ajax_moodle.php",
			data: { course_id: courseid, eventid_id: eventid,location_id:locationid,action:'eventlocation',eventtype:spacialevent }
		}).done(function( msg ) {
			var valueto = 'ccf_delivery_location_timetable_full_'+eventids+'_'+courseid;
			document.getElementById(valueto).innerHTML = msg;
		});

		$('#'+dateId).on('change', function() {
			var locationstring = $('#'+ids2+' option:selected').text();
			var datestring = $('#'+dateId+' option:selected').text();

			$('#course_location_'+eventids).val(locationstring);
			$('#course_date_'+eventids).val(datestring);
		});

	})

	$('.ccf_delivery_location_timetable_select').on('blur', function(){
		var evestr = $(this).data('evestr');
		var mcourid = $(this).data('mcourid');
		var ids = 'ccf_delivery_location_timetable_full_'+  evestr + '_' + mcourid;
		var eventid = jQuery( "#"+ids).val();
		jQuery('#ccf_event_id_'+ evestr + '_' + mcourid).val(eventid);
	});






	$('#full_location_timetable').slideUp();
	$('#full_location_timetable_new').slideUp();
	// for tree val 1
	if ($('.ccf_input_deliv:checked')) {

	$('#full_location_timetable').slideDown();

	} else  {
		$('#full_location_timetable').slideUp();
	}

	$('.ccf_input_deliv:input').change(function() {
		if ($('.ccf_input_deliv:checked')) {
			$('#full_location_timetable').slideDown();
		} else  {
			$('#full_location_timetable').slideUp();
			$('#full_location_timetable_new').slideUp();
		}
	});

	// for tree val 2
	//$( "#myselect option:selected" ).text();
	$('#ccf_delivery_location:input').change(function() {
		var locationid = $( "#ccf_delivery_location option:selected" ).val();

		if(locationid > 0) {
			var courseid = document.getElementById('moodlecourseid').value;
			$.ajax({
				method: "GET",
				url: home_url +  "/ajax_moodle.php",
				data: { course_id: courseid, location_id: locationid }
		})
		.done(function( msg ) {
			document.getElementById('ccf_delivery_location_timetable_full_1').innerHTML = msg;
		});

		// ajax wil run here
		$('#full_location_timetable_new').slideDown();

		} else {
			$('#full_location_timetable_new').slideUp();
		}
	});

	setTimeout( function(){
		var locationid = $( "#ccf_delivery_location option:selected" ).val();

		if(locationid > 0) {
			var courseid = document.getElementById('moodlecourseid').value;
			$('#full_location_timetable_new').slideDown();

			$.ajax({
				method: "GET",
				url: home_url + "/ajax_moodle.php",
				data: { course_id: courseid, location_id: locationid,action:'normal' }
			}).done(function( msg ) {
				var details = msg.split("__jaz__");
				var ndet = details[1].split("?>");
				document.getElementById('ccf_delivery_location_timetable_full_1').innerHTML = details[0]+ndet[1];
			});

		} else {
			$('#full_location_timetable_new').slideUp();
		}
	}, 5000);
});

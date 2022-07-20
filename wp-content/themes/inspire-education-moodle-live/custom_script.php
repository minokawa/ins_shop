<?php
// Prev devs cant figure out why they cant enque scripts so they just included this using PHP.
// Im not going to remove this, let this be a monument to their incompetence.
?>
<script>
jQuery(function($) {
 jQuery('.hide_block123').hide();
 jQuery('.hello').hide();
 jQuery('.checkbox').hide();
 jQuery('#ccf_country_birth_field').hide();
 jQuery('#ccf_date_birth_field').hide();
 jQuery('.form-title').hide();
jQuery('#myerrormsg').hide();
    jQuery('#smuid').on('click', function() {
	var keyvalue = $('#custom_id').val();
	var sku_iid = $('#sku_iid').val();
	jQuery('#myerrormsg').hide();
   // alert(sku_iid);

	$.ajax({
        url: 'https://inspireeducation.net.au/wp-content/themes/inspire-education-moodle-live/pop-up-data.php',
        data: {
            'action':'example_ajax_request',
			'id':keyvalue,
			'sku_id':sku_iid
                    },
        success:function(data) {//alert(data);
			var obj = JSON.parse(data);

		   if(obj["notenlorr"]!= '0'){
			jQuery('#myerrormsg').show();
			jQuery('.hello').hide();
			 jQuery('.checkbox').hide();
			 jQuery('#ccf_country_birth_field').hide();
			 jQuery('#ccf_date_birth_field').hide();
			 jQuery('.form-title').hide();

		   }else{
		   if(obj["firstname"]!= 'null' && obj["lastname"] != 'null'){
            console.log(obj);
		   jQuery('#myerrormsg').hide();
		    jQuery('.hide_block123').hide();
			jQuery('.hello').show();
			jQuery('.checkbox').show();
			jQuery('#ccf_country_birth_field').show();
			jQuery('#ccf_date_birth_field').show();
			jQuery('.form-title').show();
			document.getElementById('billing_first_name').value = obj["firstname"];
			document.getElementById('billing_middle_name').value = obj["middlename"];
			document.getElementById('billing_last_name').value = obj["lastname"];
			document.getElementById('billing_pname').value = obj["bldgprop"];
			document.getElementById('billing_platno').value = obj["unit_flat"];
			document.getElementById('billing_lotno').value = obj["street_lot"];
			document.getElementById('billing_sname').value = obj["street_name"];
			document.getElementById('billing_city').value = obj["city"];
			document.getElementById('billing_state').value = obj["state"];
			document.getElementById('billing_postcode').value = obj["postcode"];
			document.getElementById('billing_email').value = obj["email"];
			document.getElementById('billing_email_confirm').value = obj["email"];
			document.getElementById('billing_home_phone').value = obj["hphone"];
			document.getElementById('billing_work_phone').value = obj["wphone"];
			document.getElementById('billing_mobile_phone').value = obj["hmphone"];
			document.getElementById('billing_work_mobile').value = obj["wmphone"];
			document.getElementById('ccf_date_birth').value = obj["dob"];
			document.getElementById('ccf_comp_name').value = obj["emp_compname"];
			document.getElementById('ccf_comp_abn').value = obj["emp_compabn"];
			document.getElementById('ccf_comp_add_1').value = obj["emp_compaddress"];
			document.getElementById('ccf_comp_add_sub').value = obj["emp_compcity"];
			document.getElementById('ccf_comp_add_state').value = obj["emp_compstate"];
			document.getElementById('ccf_comp_add_post').value = obj["emp_comppost"];
			document.getElementById('ccf_comp_cont_email').value = obj["emp_compmail"];
			document.getElementById('ccf_comp_cont_phone').value = obj["emp_compphone"];
			document.getElementById('ccf_comp_cont_fax').value = obj["emp_compfax"];

			document.getElementById('ccf_comp_cont_fullname').value = obj["emp_compfullcntact"];
			document.getElementById('ccf_cont_email').value = obj["emp_compcntactemail"];
			document.getElementById('ccf_cont_phone_number').value = obj["emp_compcntactphone"];
			document.getElementById('ccf_cont_mobile_number').value = obj["emp_compmobilephone"];

		   document.getElementById('ccf_add_two_pname').value = obj["postbldgprop"];
			document.getElementById('ccf_add_two_unumber').value = obj["post_unitflat"];
			document.getElementById('ccf_add_two_lnumber').value = obj["post_street_lot"];
			document.getElementById('ccf_add_two_sname').value = obj["post_street_name"];
			document.getElementById('ccf_add_two_sub').value = obj["post_suburb"];
			document.getElementById('ccf_add_two_state').value = obj["post_state"];
			document.getElementById('ccf_add_two_post').value = obj["post_postcode"];
			document.getElementById('ccf_add_two_pdbox').value = obj["post_postal_delivery"];

		   if(obj["gender"]=='Male'){
		   document.getElementById('ccf_genderMale').checked  = true;
		   }else if(obj["gender"]=='Female'){
		   document.getElementById('ccf_genderFemale').checked  = true;
		   }else{

		   }
		   }
		   }
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });



    });
});

</script>

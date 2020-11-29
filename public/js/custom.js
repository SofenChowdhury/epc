$(function(){
    $(".datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        yearRange: '1950:2080',
        changeMonth: true,
        changeYear: true
    });
});

$('.input-effect input').each(function() {
	if ($(this).val().length > 0) {
		$(this).addClass('read-only-input');
	} else {
		$(this).removeClass('read-only-input');
	}

	$(this).on('keyup', function() {
		if ($(this).val().length > 0) {
			$(this).siblings('.invalid-feedback').fadeOut('slow');
		} else {
			$(this).siblings('.invalid-feedback').fadeIn('slow');
			$(this).removeClass('is-invalid');
		}
	});
});

$(document).ready(function(){
	// **Side bar changes 
  	// get browser url,split and get last / url
	var get_url = $(location).attr("href").split('/').pop();


	//If there is home route which is / or "" then it will not process
	if(get_url != "") {
		// Get parent class of that last url, split, and get main class
		var get_parent_classes = $('.'+get_url).parent().parent().attr('class');
		//check for create,edit,update there is no parent class
		if(get_parent_classes != undefined) {
			var get_parent_classes = get_parent_classes.split(" ");
			var get_parent_class = '';
			for(var i = 0;i < get_parent_classes.length;i++) {
				if( get_parent_classes[i] != 'pcoded-hasmenu' || get_parent_classes[i] != 'pcoded-trigger' || get_parent_classes[i] != 'active' ) {
					get_parent_class = get_parent_classes[i];
				}
			}
			// this lines are for active those classes
			$('.pcoded-hasmenu').removeClass("active");
			$('.pcoded-hasmenu').removeClass("pcoded-trigger");
		    $('.'+get_parent_class).addClass("active");
		    $('.'+get_parent_class).addClass("pcoded-trigger");
		    $('.'+get_url).addClass("active");
		}
	}
});

//This lines for toggle credit and debit amount in add-new-coa module
$('body, html').on('change','input[name=debit_credit_amount]',function(){
	var value = $( 'input[name=debit_credit_amount]:checked' ).val();
	if( value == 'debit' ) {
		$('.debit_div').show();
		$('.credit_div').hide();
	} else if( value == 'credit' ) {
		$('.debit_div').hide();
		$('.credit_div').show();
	}
});

// Showing accounts category oly for Control type account

// $('input[name=coa_control]').change(function(){
// 	var value = $( 'input[name=coa_control]:checked' ).val();
// 	if( value === '1') {
// 		$('.coa_category').show();
// 	} else if( value === '0') {
// 		$('.coa_category').hide();
// 	}
// });
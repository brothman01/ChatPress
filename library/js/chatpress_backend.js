jQuery( document ).ready( function($) {

		$( 'body' ).on( 'click', '.chatpress_shortcode_dialog_refresh_button', function() {

		 var index = $( this ).data( 'index' );

		 var shortcode_size = $( '.chatpress_shortcode_dialog_size_picker option:selected' ).text()

		 var shortcode_sticktobottom = true;

		 if ( $( '.chatpress_shortcode_generator_sticktobottom_checkbox' ).is(":checked") ) {

			shortcode_sticktobottom = true;

		} else {

			shortcode_sticktobottom = false;

		}

		var shortcode_private = true;

		 if ( $( '.chatpress_shortcode_generator_private_checkbox' ).is(":checked") ) {

			shortcode_private = true;

		} else {

			shortcode_private = false;

		}




		 var shortcode = '[chatpress_channel id=\"' + index + '\" ';
		 shortcode += 'size=\"' + shortcode_size + '\" ' + 'stick_to_bottom=\"' + shortcode_sticktobottom + '\" ';
		 shortcode += 'private=\"' + shortcode_private + '\"]';

		$( '.chatpress_shortcode_generator_dialog_shortcode_field').val( shortcode );

	});

	// erase all button is clicked
	$('#erase-old').on( 'click', function() {
		jQuery.ajax({
			type : "post",
			dataType : "json",
			url : cp_script.ajaxurl,
			data : { action: "chatpress_erase_all_messages" },
			success: function(response) {
					console.log(response);
			}
		 });

		
	  
    });

});

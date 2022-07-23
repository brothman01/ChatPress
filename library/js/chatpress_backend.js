jQuery( document ).ready( function($) {

	$( 'body' ).on( 'click', '.chatpress_shortcode_button', function() {

		var index = $( this ).data( 'index' );

		var dialog = '<div class="chatpress_shortcode_generator_dialog">';

			dialog += '<h1 class="chatpress_shortcode_generator_title">Shortcode Generator: Chatpress Channel</h1>';

			dialog += '<div class="chatpress_shortcode_generator_dialog_closer">X</div>'

				dialog += '<div class="chatpress_shortcode_generator_dialog_middle_section">';

					dialog += '<div class="chatpress_shortcode_generator_dialog_middle_top_section">';

						dialog += 'Shortcode: ';

						dialog += '<input type="text" class="chatpress_shortcode_generator_dialog_shortcode_field" placeholder="shortcode">';

					dialog += '</div>';

					dialog += '<div class="chatpress_shortcode_generator_field_container">';

						dialog += 'Size: ';

						dialog += '<select class="chatpress_shortcode_dialog_size_picker">';
							dialog += '<option>100% of Container</option>';
							dialog += '<option>50% of Container</option>';
							dialog += '<option>Small</option>';
						dialog += '</select>';

					dialog += '</div>';

					dialog += '<div class="chatpress_shortcode_generator_field_container">';

						dialog += 'Stick to Bottom?: ';

						dialog += '<input class="chatpress_shortcode_generator_sticktobottom_checkbox" type="checkbox">'

					dialog += '</div>';

					dialog += '<div class="chatpress_shortcode_generator_field_container">';

						dialog += 'Private?: ';

						dialog += '<input class="chatpress_shortcode_generator_private_checkbox" type="checkbox">';

					dialog += '</div>';

					dialog += '<div class="chatpress_shortcode_generator_field_container">';


					dialog += '</div>';

				dialog += '</div>';

				dialog += '<div class="chatpress_shortcode_generator_dialog_bottom_section">';

		        	dialog += '<input type="button" accesskey="p" tabindex="5" value="Refresh" class="button-primary chatpress_shortcode_dialog_refresh_button" data-index="' + index + '" style="margin-right: 15px;" id="custom" name="publish">';

		        	dialog += '<input type="button" accesskey="p" tabindex="5" value="Close" class="button-primary chatpress_shortcode_dialog_close_button" id="custom" name="publish">';

				dialog += '</div>';

			dialog += '</div>';

		if ( !$( '.chatpress_shortcode_generator_dialog' ).length ) {

			$( 'body' ).prepend( dialog );

		}

	});


	$( 'body' ).on( 'click', '.chatpress_shortcode_dialog_close_button', function() {

		$( '.chatpress_shortcode_generator_dialog' ).remove();

	});

	$( 'body' ).on( 'click', '.chatpress_shortcode_generator_dialog_closer', function() {

		$( '.chatpress_shortcode_generator_dialog' ).remove();

	});

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
        console.log('clicked');
    });

});

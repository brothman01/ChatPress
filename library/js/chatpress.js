jQuery( document ).ready( function() {

	jQuery('.cp_quoted_comment_div').hide();
	
	// the button to add a new button is clicked
	jQuery( 'body' ).on( 'click', '.chatpress_button_input', function() {
	
		var index             = jQuery( this ).data( 'index' ),
				button        = jQuery( this ),
				message_input = tinymce.editors['editor_' + index].getContent(),
				author_input  = jQuery( '.chatpress_author_input' ),
				style_input   = jQuery( '.chatpress_style_input' );
				message       = message_input, // parse this input
				author        = jQuery( author_input ).val(),
				style         = jQuery( style_input ).val();
	
		var data = {
			index: index,
			author: author,
			message: message,
			style: style,
		};
	
		tinymce.editors['editor_' + index].setContent('');
	
		// jQuery( message_input ).val('');
	
		jQuery( author_input ).val('');
	
		jQuery( style_input ).val('');
	
			jQuery.ajax({
			type: 'POST',   // Adding Post method
			url: cp_script.ajaxurl, // Including ajax file
			data: {
			"action": "chatpress_post_message",
			"data"   : data
			},
			success: function( response ) { // Show returned data using the function.
				// alert( data.message );
	
				var channel    = jQuery( '.chatpress_channel_message_container' ),
					this_index = jQuery( channel ).data( 'index' );
	
				jQuery( '.chatpress_message_div' ).remove();
	
				channel.prepend( response.data.message );
	
			}
	
			});
	
	
	});

	// auto-refresh every 3 seconds
	setInterval(function(){ 
		jQuery(".chatpress_button_refresh").click();
		console.log('auto-refreshing');
	},3000);
	

	 // the refresh button is clicked
	jQuery( 'body' ).on( 'click', '.chatpress_button_refresh', function( e ) {
	
		e.preventDefault();
	
		var index         = jQuery( this ).data( 'index' ),
			button        = jQuery( this ),
			message_input = jQuery( '.chatpress_content_input' ),
			author_input  = jQuery( '.chatpress_author_input' ),
			style_input   = jQuery( '.chatpress_style_input' ),
			message       = jQuery( message_input ).val(),
			author        = jQuery( author_input ).val(),
			style         = jQuery( style_input ).val();
	
		var data = {
			index: index,
			author: author,
			message: message,
			style: style,
		};
	
	
			jQuery.ajax({
			type: 'POST',   // Adding Post method
			url: cp_script.ajaxurl, // Including ajax file
			data: {
			"action": "chatpress_refresh_message",
			"data"   : data
			},
			success: function( response ) { // Show returned data using the function.
				// alert( data.message );
	
				var channel    = jQuery( '.chatpress_channel_message_container' ),
					this_index = jQuery( channel ).data( 'index' );
	
						jQuery( '.chatpress_message_div' ).remove();
	
						channel.html( response.data.query_results );

				
	
			}
	
			});
	
	
	});
	
	// the delete button is clicked for a message
	jQuery( 'body' ).on( 'click', '.message_delete_link', function( e ) {
		e.preventDefault();
	
		var message_container = jQuery( this ).parent().parent();
	
		var id = jQuery( this ).data( 'index' );
	
		var data = {
			index:id,
		};
	
		message_container.remove();
	
			jQuery.ajax({
			type: 'POST',   // Adding Post method
			url: cp_script.ajaxurl, // Including ajax file
			data: {
				"action": "chatpress_delete_message",
				"data"   : data,
			},
			success: function( response ) { // Show returned data using the function.
	
				//alert( response.data.query_results );
	
			}
	
			});
	
	
	});
	
	
	jQuery( 'body' ).on( 'click', '.message_number_link', function( e ) {
	
	e.preventDefault();
	
	var message_number = jQuery( this ).data( 'message_number' ),
			index          = jQuery( this ).data( 'index' ),
			content        = tinymce.editors['editor_' + index].getContent();
	
	tinymce.editors['editor_' + index].setContent( content + '{{' + message_number + '' );
	
	});
	
	jQuery( '.chatpress_channel_message_container_title' ).hover( function() {
	
	jQuery('.chatpress_title_hover_div').show();
	
	});
	
	jQuery( '.chatpress_channel_message_container_title' ).mouseout( function() {
	
	jQuery('.chatpress_title_hover_div').hide();
	
	});
	
	jQuery( 'body' ).on( 'click', '.cp_quoted_comment_link', function( e ) {
	
	var message_number = jQuery( this ).data( 'message_id' );
	
	e.preventDefault();
	
		//var grandparent = this.parent();
	
	var div_string = '.cp_quoted_comment_div[data-message_id="' + message_number + '"]';
	
	var the_div = jQuery( this ).parent().parent().find( div_string );
	
	
	if ( jQuery( the_div ).css('display') === 'none') {
	
		jQuery( the_div ).show();
	
	} else {
	
		jQuery( the_div ).hide();
	
	}
	
	});
	
	
	});
	
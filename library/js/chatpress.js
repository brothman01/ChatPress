jQuery( document ).ready( function($) {

	$('.cp_quoted_comment_div').hide();
	
	// the button to add a new button is clicked
	$( 'body' ).on( 'click', '.chatpress_button_input', function() {
	
		var index             = $( this ).data( 'index' ),
				button        = $( this ),
				message_input = tinymce.editors['editor_' + index].getContent(),
				author_input  = $( '.chatpress_author_input' ),
				style_input   = $( '.chatpress_style_input' );
				message       = message_input, // parse this input
				author        = $( author_input ).val(),
				style         = $( style_input ).val();
	
		var data = {
			index: index,
			author: author,
			message: message,
			style: style,
		};
	
		tinymce.editors['editor_' + index].setContent('');
	
		// $( message_input ).val('');
	
		$( author_input ).val('');
	
		$( style_input ).val('');
	
			jQuery.ajax({
			type: 'POST',   // Adding Post method
			url: cp_script.ajaxurl, // Including ajax file
			data: {
			"action": "chatpress_post_message",
			"data"   : data
			},
			success: function( response ) { // Show returned data using the function.
				// alert( data.message );
	
				var channel    = $( '.chatpress_channel_message_container' ),
					this_index = $( channel ).data( 'index' );
	
				$( '.chatpress_message_div' ).remove();
	
				channel.prepend( response.data.message );
	
			}
	
			});
	
	
	});

	// auto-refresh every 3 seconds
	setInterval(function(){ 
		$(".chatpress_button_refresh").click();
		$( ".cp_date" ).each(function() {
		});
		console.log('auto-refreshing');
	},3000);
	

	 // the refresh button is clicked
	$( 'body' ).on( 'click', '.chatpress_button_refresh', function( e ) {
	
		e.preventDefault();
	
		var index         = $( this ).data( 'index' ),
			button        = $( this ),
			message_input = $( '.chatpress_content_input' ),
			author_input  = $( '.chatpress_author_input' ),
			style_input   = $( '.chatpress_style_input' ),
			message       = $( message_input ).val(),
			author        = $( author_input ).val(),
			style         = $( style_input ).val();
	
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
	
				var channel    = $( '.chatpress_channel_message_container' ),
					this_index = $( channel ).data( 'index' );
	
						$( '.chatpress_message_div' ).remove();
	
						channel.html( response.data.query_results );
			}
	
			});
	
	
	});
	
	// the delete button is clicked for a message
	$( 'body' ).on( 'click', '.message_delete_link', function( e ) {
		e.preventDefault();
	
		var message_container = $( this ).parent().parent();
	
		var id = $( this ).data( 'index' );
	
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
	
	
	$( 'body' ).on( 'click', '.message_number_link', function( e ) {
	
	e.preventDefault();
	
	var message_number = $( this ).data( 'message_number' ),
			index          = $( this ).data( 'index' ),
			content        = tinymce.editors['editor_' + index].getContent();
	
	tinymce.editors['editor_' + index].setContent( content + '{{' + message_number + '' );
	
	});
	
	$( '.chatpress_channel_message_container_title' ).hover( function() {
	
	$('.chatpress_title_hover_div').show();
	
	});
	
	$( '.chatpress_channel_message_container_title' ).mouseout( function() {
	
	$('.chatpress_title_hover_div').hide();
	
	});
	
	$( 'body' ).on( 'click', '.cp_quoted_comment_link', function( e ) {
	
	var message_number = $( this ).data( 'message_id' );
	
	e.preventDefault();
	
		//var grandparent = this.parent();
	
	var div_string = '.cp_quoted_comment_div[data-message_id="' + message_number + '"]';
	
	var the_div = $( this ).parent().parent().find( div_string );
	
	
	if ( $( the_div ).css('display') === 'none') {
	
		$( the_div ).show();
	
	} else {
	
		$( the_div ).hide();
	
	}
	
	});
	
	
	});
	
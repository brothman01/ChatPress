<?php
 /**
 * Add the menu page
 */
function cp_options_page() {
    add_menu_page(
        'ChatPress',
        'ChatPress',
        'manage_options',
        'cp',
        'cp_options_page_html'
    );
}

add_action( 'admin_menu', 'cp_options_page' );


/**
 * Register the setting, initialize and add the section + fields to the section
 */
function cp_settings_init() {
    // Register a new setting for "cp" page.
    register_setting( 'cp', 'cp_options' );
 
    // Register a new section in the "cp" page.
    add_settings_section(
        'cp_settings_section',
        __( 'General', 'cp' ), NULL,
        'cp'
    );
 

	    // Register a new field in the "cp_settings_section" section, on the "cp" page.
		add_settings_field(
			'cp_field_phone', // As of WP 4.6 this value is used only internally.
									// Use $args' label_for to populate the id inside the callback.
				__( 'Phone Number', 'cp' ),
			'cp_phone_cb',
			'cp',
			'cp_settings_section',
			array(
				'label_for'   => 'cp_field_phone',
				'class'       => 'cp_row',
			)
		);

        // Register a new field in the "cp_settings_section" section, on the "cp" page.
		add_settings_field(
			'cp_field_email', // As of WP 4.6 this value is used only internally.
									// Use $args' label_for to populate the id inside the callback.
				__( 'Email', 'cp' ),
			'cp_email_cb',
			'cp',
			'cp_settings_section',
			array(
				'label_for'   => 'cp_field_email',
				'class'       => 'cp_row',
			)
		);
}
 
add_action( 'admin_init', 'cp_settings_init' );
 
 

/**
 * Phone field callback function.
 */
function cp_phone_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'cp_options' );
    ?>
	<!-- output the html for the field being added -->
    <input
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            type="number"
            name="cp_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo $options['cp_field_phone'] ?>">
	</input
    <?php
}

/**
 * Email field callback function.
 */
function cp_email_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'cp_options' );
    ?>
	<!-- output the html for the field being added -->
    <input
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            type="email"
            name="cp_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo $options['cp_field_email'] ?>">
	</input
    <?php
}
 
  
/**
 * Menu Page callback function
 */
function cp_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
  
    // show error/update messages
    settings_errors( 'cp_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "cp"
            settings_fields( 'cp' );

            // output setting sections and their fields.  sections are registered for "cp", each field is registered to a section
            do_settings_sections( 'cp' );

            ?><input class="wp-core-ui button" id="erase-old" type="button" value="Erase all old messages" /><?php

            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}
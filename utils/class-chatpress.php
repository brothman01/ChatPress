<?php
/*
Plugin Name:	ChatPress
Plugin URI:	https://wordpress.org/plugins/chatpress
Description:	This plugin creates a chatboard that updates with AJAX to embed on pages that keeps the identity of each poster anonymous.
Version:	2.0.0
Author:		Ben Rothman
Author URI:	http://www.BenRothman.org
Text Domain:	chatpress
License:	GPL-2.0+
*/

include 'settings.php';

class ChatPress {

	
	public static $options;

	/**
	 * ChatPress class constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {

		add_shortcode( 'chatpress_channel' , [ $this, 'cp_shortcode_cb' ] );

		$this->cp_init();

	}

	/**
	 * Runs additional actions to be performed at startup.
	 *
	 * @since 0.1
	 */
	public function cp_init() {

		if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {

			require_once dirname( __FILE__ ) . '/cmb2/init.php';

		} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {

			require_once dirname( __FILE__ ) . '/CMB2/init.php';

		}

		add_action( 'cmb2_admin_init', [ $this, 'cp_register_chatpress_channel_metabox' ] );

		add_action( 'cmb2_admin_init', [ $this, 'cp_register_chatpress_message_metabox' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'cp_enqueue_styles' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'cp_enqueue_scripts' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'cp_enqueue_admin_scripts' ] );

		add_action( 'wp_ajax_chatpress_post_message', [ $this, 'chatpress_post_message' ] );

		add_action( 'wp_ajax_chatpress_erase_all_messages', [ $this, 'chatpress_erase_all_messages' ] );

		add_action( 'wp_ajax_chatpress_refresh_message', [ $this, 'chatpress_refresh_message' ] );

		add_action( 'wp_ajax_chatpress_delete_message', [ $this, 'chatpress_delete_message' ] );

	}

	/**
	 * Add CMB2 fields to ChatPress Channel post-type.
	 *
	 * @since 0.1
	 */
	public function cp_register_chatpress_channel_metabox() {
		$prefix = 'chatpress_channel_';

		$cmb_demo = new_cmb2_box( [
			'id'            => $prefix . 'metabox',
			'title'         => esc_html__( 'ChatPress', 'cmb2' ),
			'object_types'  => [ 'chatpress_channel' ], // Post type.
		] );

			$cmb_demo->add_field( [
				'name'       => esc_html__( 'Moderator', 'cmb2' ),
				'desc'       => esc_html__( ' ', 'cmb2' ),
				'id'         => $prefix . 'moderator',
				'type'       => 'text',
				'show_on_cb' => 'yourprefix_hide_if_no_cats',
			] );

		$cmb_demo->add_field( [
			'name' => esc_html__( 'Topic', 'cmb2' ),
			'desc' => esc_html__( ' ', 'cmb2' ),
			'id'   => $prefix . 'topic',
			'type' => 'text_small',
		] );

		$cmb_demo->add_field( [
			'name' => esc_html__( 'Rules', 'cmb2' ),
			'desc' => esc_html__( ' ', 'cmb2' ),
			'id'   => $prefix . 'rules',
			'type' => 'textarea',
		] );

		$cmb_demo->add_field( array(
			'name'    => esc_html__( 'Background Color', 'cmb2' ),
			'desc'    => esc_html__( '', 'cmb2' ),
			'id'      => $prefix . 'color',
			'type'    => 'colorpicker',
			'default' => '#ffffff',
		) );

		$cmb_demo->add_field( array(
			'name' => esc_html__( 'Image', 'cmb2' ),
			'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
			'id'   => $prefix . 'image',
			'type' => 'file',
		) );

	}

	/**
	 * Shortcode callback function for when users use the channel shortcode.
	 *
	 * @param Array $atts - array of each of the parameters and their value specified in the shortcode.
	 *
	 * @since 0.1
	 */
	public function cp_shortcode_cb( $atts ) {

		$atts = shortcode_atts( [
			'id'              => false,
			'size'            => false,
			'stick_to_bottom' => false,
			'allowimages'     => false,
		], $atts );

		$channel_query = new WP_Query( [
			'post_type' => 'chatpress_channel',
			'p' => $atts['id'],

		] );

if ( $channel_query->have_posts() ) {

	while ( $channel_query->have_posts() ) {

		$channel_query->the_post();

		$channel_id = get_the_ID();

		$channel = new Channel( $channel_id );

		// if ( '' !== get_post_meta( $atts['id'], 'chatpress_channel_image', true ) ) {

		// 	$background = 'background: url(' . get_post_meta( $atts['id'], 'chatpress_channel_image', true ) . ');';

		// }
		?>

		<div class="chatpress_channel_wrapper" style="" data-index="<?php echo esc_html( $channel_id ); ?>">


		<div style="float: right;">

			<a href="#" class="chatpress_button_refresh" style="float: right;" data-index="<?php echo esc_html( $channel_id ); ?>"> <i class="fa fa-refresh" aria-hidden="true"></i> Refresh</a>

		</div>

			<p class="chatpress_channel_message_container_title"> <?php echo get_the_title(); ?> </p>

			<div class="chatpress_title_hover_div">
				Moderator: <?php echo $channel->moderator;?><br />
				Topic: <?php echo esc_html( get_post_meta( get_the_ID(), 'chatpress_channel_topic', true ) ); ?>
			</div>

		<p class="chatpress_channel_message_container_description"> <?php echo get_the_content(); ?> </p>

			<div class="chatpress_channel_content_container">

			<div class="chatpress_channel_message_container" data-index="<?php echo esc_html( $channel_id ); ?>">
					<?php
						wp_reset_postdata();

						echo $this->cp_populate( $atts['id'] );

						?>

						</div>

						<div class="chatpress_channel_input_container">

							<?php if ( '100% of container' === $atts['size'] ) { ?>

								<input type="text" class="chatpress_text_input chatpress_content_input" placeholder="Message" style="width: 50%; float: left;" data-index="<?php echo esc_html( $channel_id ); ?>"></input>

								<input type="text" class="chatpress_text_input chatpress_style_input" placeholder="Style" style="width: 49%;  margin-right: 1%; float: left;" data-index="<?php echo esc_html( $channel_id ); ?>"></input>

								<input type="button" class="chatpress_button_input" value="Send" style="width: 20%; float: left;" data-index="<?php echo esc_html( $channel_id ); ?>"></input>

							<?php

} else {

if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {

wp_editor( '', 'editor_' . esc_html( $channel_id ) );

?>

<input type="button" class="chatpress_button_input" value="Send" style="width: 100%; float: left; margin-top: 1%; padding-top: 20px; padding-bottom: 20px !important;" data-index="<?php echo esc_html( $channel_id ); ?>"></input>


<?php
}
}

if ( ! current_user_can( 'editor' ) && ! current_user_can( 'administrator' ) ) {

?>

<div style="width: 100%; background: black; color: white; margin-top: 2%; padding: 3% 0px 3% 0px; text-align: center;">Please Login to Comment</div>

<?php
}

?>

</div>

</div>

					</div>

			</div>

	<?php

	} // End while().
}// End if().

		return ' ';

	}



	/**
	 * Add CMB2 fields to ChatPress Message post-type.
	 *
	 * @since 0.1
	 */
	public function cp_register_chatpress_message_metabox() {
		$prefix = 'chatpress_message_';

		$cmb_message = new_cmb2_box( [
			'id'            => $prefix . 'metabox',
			'title'         => esc_html__( 'ChatPress Info', 'cmb2' ),
			'object_types'  => [ 'chatpress_message' ], // Post type.
		] );

	}

	/**
	 *  Populate the channel content container with posts that belong in that channel.
	 *
	 * @param int $channel_number - number of the current channel.
	 *
	 * @since 0.1
	 */
	public function cp_populate( $channel_number ) {

		$messages = '';

		// Create the query + query the database
		$message_query = new WP_Query( [
			'post_type'      => 'chatpress_message',
			'title'          => $channel_number,
			'posts_per_page' => -1,
			'order_by'       => 'DESC',
		] );

		if ( $message_query->have_posts() ) {

			while ( $message_query->have_posts() ) {



					$message_query->the_post();

					$messages .= '<div class="chatpress_message_div" data-index="' . get_the_title() . '">';

					$messages .= '<p style="float: left; width: 100%;" class="cp_date">&nbsp;' . strftime("%m/%d/%Y %H:%M:%S %Z", strtotime( get_post_time( 'm/d/y h:m:s' ) ) ) . '</p>';

				if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {

						$messages .= '<div class="chatpress_message_admin_panel">';

						$messages .= '<a class="message_delete_link" href="#" data-index="' . get_the_ID() . '">Delete</a>';

						$messages .= '</div>';

				}

					$messages .= get_the_content();

					$messages .= '</div>';
			}
		}

			wp_reset_postdata();

			return $messages;

	}

	/**
	 * Erase all ChatPress Messages + refresh channel
	 *
	 * @since 0.1
	 */
	public function chatpress_erase_all_messages() {

		$query = new WP_Query(array(
			'post_type' => 'chatpress_message',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		));
		
		
		while ($query->have_posts()) {
			$query->the_post();
			$post_id = get_the_ID();
			wp_delete_post( $post_id, true );

		}
		

		wp_send_json_success( [
			'message' => 'foobar',
		] );

	}

	/**
	 * Create a 'ChatPress_Message' post + refresh posts in channel
	 *
	 * @since 0.1
	 */
	public function chatpress_post_message() {


		$message = wp_unslash( wp_kses_post( $_POST['data']['message'] ) );

		$message = $this->cp_parse( $message );

		$index = wp_unslash( sanitize_text_field( $_POST['data']['index'] ) );

		// $author = wp_unslash( sanitize_text_field( $_POST['data']['author'] ) );

		$style = wp_unslash( sanitize_text_field( $_POST['data']['style'] ) );


		// Create post object with standardized time
		date_default_timezone_set( wp_timezone_string() );

		$my_post = [
			'post_title'    => $index,
			'post_type'     => 'chatpress_message',
			'post_content'  => $message,
			'post_status'   => 'publish',
			'post_author'   => 1,
		];

		// Insert the post into the database if the post is not empty
		if ( $message != NULL && $message != '' ) {
			$my_new_post = wp_insert_post( $my_post );

			add_post_meta( $my_new_post, 'author', $author );

			add_post_meta( $my_new_post, 'style', $style );

			add_post_meta( $my_new_post, 'icon', $image );

			$post_container = $this->cp_populate( $index );
		}

		wp_send_json_success( [
			'message' => $post_container,
		] );

	}

	/**
	 *  PHP function called by AJAX hook to refresh/repopulate a channel
	 *
	 * @since 0.1
	 */
	public function chatpress_refresh_message() {

		$index = wp_unslash( sanitize_text_field( $_POST['data']['index'] ) );

		$new_query = $this->cp_populate( $index );

		wp_send_json_success( [

			'query_results' => $new_query,

		] );

	}

	/**
	 *  PHP function called by AJAX hook to delete a message
	 *
	 * @since 0.1
	 */
	public function chatpress_delete_message() {

		$index = wp_unslash( sanitize_text_field( $_POST['data']['index'] ) );

		wp_delete_post( $index, false );

		wp_send_json_success( [

			'query_results' => $index,

		] );

	}

	/**
	 * Parse the input string. (add goodies later)
	 *
	 * @param string $input - string to parse.
	 *
	 * @since 0.1
	 */
	public function cp_parse( $input ) {
		return $input;
	}

	 /**
	  * Create cron schedule for garbage collection
	  *
	  * @param Object $schedules - string to search through.
	  *
	  * @since 0.1
	  */
	public function custom_cron_schedules( $schedules ) {

		if ( ! isset( $schedules['weekly'] ) ) {

			$schedules['weekly'] = array(
				'interval' => 604800,
				'display'  => __( 'Once Per Week' ),
			);

		}

		if ( ! isset( $schedules['monthly'] ) ) {

			$schedules['monthly'] = array(
				'interval' => 2628000,
				'display'  => __( 'Once Per Month' ),
			);

		}

		return $schedules;

	}



	/**
	 * Define 'starts_with' function.
	 *
	 * @param string $haystack - string to search through.
	 *
	 * @param string $needle - string to search for.
	 *
	 * @since 0.1
	 */
	public function starts_with( $haystack, $needle ) {

		$length = strlen( $needle );

		return ( substr( $haystack, 0, $length ) === $needle );

	}

	/**
	 *  Normal Stylsheets enqueued + FontAwesome enqueued
	 *
	 * @since 0.1
	 */
	public function cp_enqueue_styles() {

		wp_enqueue_style( 'cp_stylesheet', plugin_dir_url( __FILE__ ) . '/library/css/style.css', [], false, 'all' );

		wp_enqueue_style( 'cp_fontawesome', plugin_dir_url( __FILE__ ) . '/library/fonts/font-awesome-4.7.0/css/font-awesome.min.css', [], false, 'all' );

	}

	/**
	 * Admin scripts enqueued
	 *
	 * @since 0.1
	 */
	public function cp_enqueue_admin_scripts() {

		wp_register_script( 'cp_backend', plugin_dir_url( __FILE__ ) . '/library/js/chatpress_backend.js', [ 'jquery' ], 'all', true );

		wp_localize_script( 'cp_backend', 'cp_script', [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		] );

		wp_enqueue_script( 'cp_backend' );

		wp_enqueue_style( 'cp_admin_stylesheet', plugin_dir_url( __FILE__ ) . '/library/css/admin_style.css', [], false, 'all' );

	}

	/**
	 * Normal scripts enqueued
	 *
	 * @since 0.1
	 */
	public function cp_enqueue_scripts() {

		wp_register_script( 'cp_script', plugin_dir_url( __FILE__ ) . '/library/js/chatpress.js', [ 'jquery' ], 'all', true );

		wp_localize_script( 'cp_script', 'cp_script', [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		] );

		wp_enqueue_script( 'cp_script' );

		wp_register_script( 'cp_frontend', plugin_dir_url( __FILE__ ) . '/library/js/chatpress_frontend.js', [ 'jquery' ], 'all', true );

		wp_enqueue_script( 'cp_frontend' );

	}

}

$instance = new ChatPress();

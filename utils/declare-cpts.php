<?php
add_action( 'init', 'chatpress_channel_function', 0 );
/**
	 * Register ChatPress Channel CPT
	 *
	 * @since 0.1
	 */
	function chatpress_channel_function() {

		$labels = [
			'name'                  => _x( 'ChatPress', 'Post Type General Name', 'chatpress' ),
			'singular_name'         => _x( 'ChatPress', 'Post Type Singular Name', 'chatpress' ),
			'menu_name'             => __( 'ChatPress', 'chatpress' ),
			'name_admin_bar'        => __( 'ChatPress', 'chatpress' ),
			'archives'              => __( 'ChatPress Archives', 'chatpress' ),
			'attributes'            => __( 'ChatPress Attributes', 'chatpress' ),
			'parent_item_colon'     => __( 'Parent Channel:', 'chatpress' ),
			'all_items'             => __( 'All Channels', 'chatpress' ),
			'add_new_item'          => __( 'Add New ChatPress', 'chatpress' ),
			'add_new'               => __( 'Add New', 'chatpress' ),
			'new_item'              => __( 'New Item', 'chatpress' ),
			'edit_item'             => __( 'Edit Item', 'chatpress' ),
			'update_item'           => __( 'Update Item', 'chatpress' ),
			'view_item'             => __( 'View Item', 'chatpress' ),
			'view_items'            => __( 'View Items', 'chatpress' ),
			'search_items'          => __( 'Search Item', 'chatpress' ),
			'not_found'             => __( 'Not found', 'chatpress' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'chatpress' ),
			'featured_image'        => __( 'Featured Image', 'chatpress' ),
			'set_featured_image'    => __( 'Set featured image', 'chatpress' ),
			'remove_featured_image' => __( 'Remove featured image', 'chatpress' ),
			'use_featured_image'    => __( 'Use as featured image', 'chatpress' ),
			'insert_into_item'      => __( 'Insert into item', 'chatpress' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'chatpress' ),
			'items_list'            => __( 'Items list', 'chatpress' ),
			'items_list_navigation' => __( 'Items list navigation', 'chatpress' ),
			'filter_items_list'     => __( 'Filter items list', 'chatpress' ),
		];
		$args = [
			'label'                 => __( 'ChatPress', 'chatpress' ),
			'description'           => __( 'Post Type Description', 'chatpress' ),
			'labels'                => $labels,
			'supports'              => [],
			'taxonomies'            => [ 'category', 'post_tag' ],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'menu_icon'           => 'dashicons-media-document',
		];
		register_post_type( 'chatpress_channel', $args );

	}

    add_action( 'init', 'chatpress_message_function', 0 );
	/**
	 * Register ChatPress Message CPT
	 *
	 * @since 0.1
	 */
	function chatpress_message_function() {

		$labels = [
			'name'                  => _x( 'Message', 'Post Type General Name', 'chatpress' ),
			'singular_name'         => _x( 'Message', 'Post Type Singular Name', 'chatpress' ),
			'menu_name'             => __( 'Message', 'chatpress' ),
			'name_admin_bar'        => __( 'Message', 'chatpress' ),
			'archives'              => __( 'Message Archives', 'chatpress' ),
			'attributes'            => __( 'Message Attributes', 'chatpress' ),
			'parent_item_colon'     => __( 'Parent Message:', 'chatpress' ),
			'all_items'             => __( 'All Messages', 'chatpress' ),
			'add_new_item'          => __( 'Add New Message', 'chatpress' ),
			'add_new'               => __( 'Add New', 'chatpress' ),
			'new_item'              => __( 'New Message', 'chatpress' ),
			'edit_item'             => __( 'Edit Messagge', 'chatpress' ),
			'update_item'           => __( 'Update Message', 'chatpress' ),
			'view_item'             => __( 'View Item', 'chatpress' ),
			'view_items'            => __( 'View Items', 'chatpress' ),
			'search_items'          => __( 'Search Item', 'chatpress' ),
			'not_found'             => __( 'Not found', 'chatpress' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'chatpress' ),
			'featured_image'        => __( 'Featured Image', 'chatpress' ),
			'set_featured_image'    => __( 'Set featured image', 'chatpress' ),
			'remove_featured_image' => __( 'Remove featured image', 'chatpress' ),
			'use_featured_image'    => __( 'Use as featured image', 'chatpress' ),
			'insert_into_item'      => __( 'Insert into item', 'chatpress' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'chatpress' ),
			'items_list'            => __( 'Items list', 'chatpress' ),
			'items_list_navigation' => __( 'Items list navigation', 'chatpress' ),
			'filter_items_list'     => __( 'Filter items list', 'chatpress' ),
		];
		$args = [
			'label'                 => __( 'ChatPress', 'chatpress' ),
			'description'           => __( 'Post Type Description', 'chatpress' ),
			'labels'                => $labels,
			'supports'              => [],
			'taxonomies'            => [ 'category', 'post_tag' ],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'menu_icon'           => 'dashicons-media-document',
		];
		register_post_type( 'chatpress_message', $args );

	}

    cp_add_shortcode_column();

    /**
	 * Adds an additional column to the CPT list view showing the shortcode
	 * for each chatpress_channel.
	 *
	 * @since 1.9.0
	 */
	function cp_add_shortcode_column() {
		add_filter('manage_chatpress_channel_posts_columns', function($columns) {
			return array_merge($columns, ['verified' => __('Verified', 'textdomain')]);
		});
		 
		add_action('manage_chatpress_channel_posts_custom_column', function($column_key, $post_id) {
				_e('[chatpress_channel id="'. $post_id .'"]', 'textdomain');
		}, 10, 2);
	}
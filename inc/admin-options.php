<?php

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function cw_register_main_options_metabox() {

	/**
	 * Registers main options page menu item and form.
	 */
	$main_options = new_cmb2_box( array(
		'id'           => 'cw_main_options_page',
		'title'        => esc_html__( 'CW Options', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'cw_main_options', // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'cw_options_page_message_callback',
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	$main_options->add_field( array(
		'name'    => esc_html__( 'Background image', 'cmb2' ),
		'desc'    => esc_html__( 'Background image for the front page', 'cmb2' ),
		'id'      => 'bg_img',
		'type'    => 'file',
	) );

	$main_options->add_field( array(
		'name'    => esc_html__( 'Home Background Color', 'cmb2' ),
		'desc'    => esc_html__( 'You can match it with the background image, or not.', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

	$main_options->add_field( array(
		'name'    => esc_html__( 'Home Text color', 'cmb2' ),
		'desc'    => esc_html__( 'Choose a contrasting color for readability', 'cmb2' ),
		'id'      => 'txt_color',
		'type'   => 'colorpicker',
		'default' => '#ffffff',
	) );


	/**
	 * Registers secondary options page, and set main item as parent.
	 */
	$secondary_options = new_cmb2_box( array(
		'id'           => 'cw_secondary_options_page',
		'title'        => esc_html__( 'Secondary Options', 'cmb2' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'cw_secondary_options',
		'parent_slug'  => 'cw_main_options',
	) );

	$secondary_options->add_field( array(
		'name'    => esc_html__( 'Test Radio', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'radio',
		'type'    => 'radio',
		'options' => array(
			'option1' => esc_html__( 'Option One', 'cmb2' ),
			'option2' => esc_html__( 'Option Two', 'cmb2' ),
			'option3' => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );

	/**
	 * Registers tertiary options page, and set main item as parent.
	 */
	$tertiary_options = new_cmb2_box( array(
		'id'           => 'cw_tertiary_options_page',
		'title'        => esc_html__( 'Tertiary Options', 'cmb2' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'cw_tertiary_options',
		'parent_slug'  => 'cw_main_options',
	) );

	$tertiary_options->add_field( array(
		'name' => esc_html__( 'Test Text Area for Code', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea_code',
		'type' => 'textarea_code',
	) );

}
add_action( 'cmb2_admin_init', 'cw_register_main_options_metabox' );


add_filter('manage_reviews_posts_columns', 'cw_reviews_columns');

function cw_reviews_columns($columns) {
	
	$columns = array(
		'cb'			=> $columns['cb'],
		'title'			=> __('Title'),
		'contributor' 	=> __('Author / Creator / Contributor'),
		'categories'	=> __('Categories'),
		'date'			=> __('Date'),
	);
	

	return $columns;
}

add_filter('manage_comics_posts_columns', 'cw_comics_columns');

function cw_comics_columns($columns) {
	
	$columns = array(
		'cb'			=> $columns['cb'],
		'title'			=> __('Title'),
		'contributor' 	=> __('Author / Creator / Contributor'),
		'categories'	=> __('Categories'),
		'date'			=> __('Date'),
	);
	

	return $columns;
}

add_action('manage_reviews_posts_custom_column', 'cw_contributor_column', 10, 2);
add_action('manage_comics_posts_custom_column', 'cw_contributor_column', 10, 2);


function cw_contributor_column( $column, $post_id ) {
	if($column === 'contributor') {
		echo cw_posted_by( $post_id, '' );	
	}
}


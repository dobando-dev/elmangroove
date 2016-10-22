<?php
add_action( 'init', 'zermatt_create_service' );

function zermatt_create_service() {
	$labels = array(
		'name'               => esc_html_x( 'Services', 'post type general name', 'zermatt' ),
		'singular_name'      => esc_html_x( 'Service', 'post type singular name', 'zermatt' ),
		'menu_name'          => esc_html_x( 'Services', 'admin menu', 'zermatt' ),
		'name_admin_bar'     => esc_html_x( 'Service', 'add new on admin bar', 'zermatt' ),
		'add_new'            => esc_html__( 'Add New', 'zermatt' ),
		'add_new_item'       => esc_html__( 'Add New Service', 'zermatt' ),
		'edit_item'          => esc_html__( 'Edit Service', 'zermatt' ),
		'new_item'           => esc_html__( 'New Service', 'zermatt' ),
		'view_item'          => esc_html__( 'View Service', 'zermatt' ),
		'search_items'       => esc_html__( 'Search Services', 'zermatt' ),
		'not_found'          => esc_html__( 'No Services found', 'zermatt' ),
		'not_found_in_trash' => esc_html__( 'No Services found in the trash', 'zermatt' ),
		'parent_item_colon'  => esc_html__( 'Parent Service:', 'zermatt' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => esc_html_x( 'Service', 'post type singular name', 'zermatt' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => esc_html_x( 'service', 'post type slug', 'zermatt' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-star-filled'
	);

	register_post_type( 'zermatt_service', $args );

	$labels = array(
		'name'              => esc_html_x( 'Service Categories', 'taxonomy general name', 'zermatt' ),
		'singular_name'     => esc_html_x( 'Service Category', 'taxonomy singular name', 'zermatt' ),
		'search_items'      => esc_html__( 'Search Service Categories', 'zermatt' ),
		'all_items'         => esc_html__( 'All Service Categories', 'zermatt' ),
		'parent_item'       => esc_html__( 'Parent Service Category', 'zermatt' ),
		'parent_item_colon' => esc_html__( 'Parent Service Category:', 'zermatt' ),
		'edit_item'         => esc_html__( 'Edit Service Category', 'zermatt' ),
		'update_item'       => esc_html__( 'Update Service Category', 'zermatt' ),
		'add_new_item'      => esc_html__( 'Add New Service Category', 'zermatt' ),
		'new_item_name'     => esc_html__( 'New Service Category Name', 'zermatt' ),
		'menu_name'         => esc_html__( 'Categories', 'zermatt' ),
		'view_item'         => esc_html__( 'View Service Category', 'zermatt' ),
		'popular_items'     => esc_html__( 'Popular Service Categories', 'zermatt' ),
	);
	register_taxonomy( 'zermatt_service_category', array( 'zermatt_service' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => esc_html_x( 'service-category', 'taxonomy slug', 'zermatt' ) ),
	) );

}

add_action( 'load-post.php', 'zermatt_service_meta_boxes_setup' );
add_action( 'load-post-new.php', 'zermatt_service_meta_boxes_setup' );
function zermatt_service_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'zermatt_service_add_meta_boxes' );
	add_action( 'save_post', 'zermatt_service_save_meta', 10, 2 );
}

function zermatt_service_add_meta_boxes() {
	add_meta_box( 'zermatt-page-header', esc_html__( 'Page Header', 'zermatt' ), 'zermatt_page_header_meta_box', 'zermatt_service', 'normal', 'high' );
}

function zermatt_service_save_meta( $post_id, $post ) {

	if ( ! zermatt_can_save_meta( 'zermatt_service' ) ) {
		return;
	}

	update_post_meta( $post_id, 'subtitle', sanitize_text_field( $_POST['subtitle'] ) );
	update_post_meta( $post_id, 'header_image_id', zermatt_sanitize_intval_or_empty( $_POST['header_image_id'] ) );
}

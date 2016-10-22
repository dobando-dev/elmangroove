<?php
add_action( 'init', 'zermatt_create_attraction' );

function zermatt_create_attraction() {
	$labels = array(
		'name'               => esc_html_x( 'Attractions', 'post type general name', 'zermatt' ),
		'singular_name'      => esc_html_x( 'Attraction', 'post type singular name', 'zermatt' ),
		'menu_name'          => esc_html_x( 'Attractions', 'admin menu', 'zermatt' ),
		'name_admin_bar'     => esc_html_x( 'Attraction', 'add new on admin bar', 'zermatt' ),
		'add_new'            => esc_html__( 'Add New', 'zermatt' ),
		'add_new_item'       => esc_html__( 'Add New Attraction', 'zermatt' ),
		'edit_item'          => esc_html__( 'Edit Attraction', 'zermatt' ),
		'new_item'           => esc_html__( 'New Attraction', 'zermatt' ),
		'view_item'          => esc_html__( 'View Attraction', 'zermatt' ),
		'search_items'       => esc_html__( 'Search Attractions', 'zermatt' ),
		'not_found'          => esc_html__( 'No Attractions found', 'zermatt' ),
		'not_found_in_trash' => esc_html__( 'No Attractions found in the trash', 'zermatt' ),
		'parent_item_colon'  => esc_html__( 'Parent Attraction:', 'zermatt' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => esc_html_x( 'Attraction', 'post type singular name', 'zermatt' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => esc_html_x( 'attraction', 'post type slug', 'zermatt' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-visibility'
	);

	register_post_type( 'zermatt_attraction', $args );

	$labels = array(
		'name'              => esc_html_x( 'Attraction Categories', 'taxonomy general name', 'zermatt' ),
		'singular_name'     => esc_html_x( 'Attraction Category', 'taxonomy singular name', 'zermatt' ),
		'search_items'      => esc_html__( 'Search Attraction Categories', 'zermatt' ),
		'all_items'         => esc_html__( 'All Attraction Categories', 'zermatt' ),
		'parent_item'       => esc_html__( 'Parent Attraction Category', 'zermatt' ),
		'parent_item_colon' => esc_html__( 'Parent Attraction Category:', 'zermatt' ),
		'edit_item'         => esc_html__( 'Edit Attraction Category', 'zermatt' ),
		'update_item'       => esc_html__( 'Update Attraction Category', 'zermatt' ),
		'add_new_item'      => esc_html__( 'Add New Attraction Category', 'zermatt' ),
		'new_item_name'     => esc_html__( 'New Attraction Category Name', 'zermatt' ),
		'menu_name'         => esc_html__( 'Categories', 'zermatt' ),
		'view_item'         => esc_html__( 'View Attraction Category', 'zermatt' ),
		'popular_items'     => esc_html__( 'Popular Attraction Categories', 'zermatt' ),
	);
	register_taxonomy( 'zermatt_attraction_category', array( 'zermatt_attraction' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => esc_html_x( 'attraction-category', 'taxonomy slug', 'zermatt' ) ),
	) );

}

add_action( 'load-post.php', 'zermatt_attraction_meta_boxes_setup' );
add_action( 'load-post-new.php', 'zermatt_attraction_meta_boxes_setup' );
function zermatt_attraction_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'zermatt_attraction_add_meta_boxes' );
	add_action( 'save_post', 'zermatt_attraction_save_meta', 10, 2 );
}

function zermatt_attraction_add_meta_boxes() {
	add_meta_box( 'zermatt-attraction-box', esc_html__( 'Attraction Settings', 'zermatt' ), 'zermatt_attraction_meta_box', 'zermatt_attraction', 'normal', 'high' );
	add_meta_box( 'zermatt-page-header', esc_html__( 'Page Header', 'zermatt' ), 'zermatt_page_header_meta_box', 'zermatt_attraction', 'normal', 'high' );
}

function zermatt_attraction_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'zermatt_attraction' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			zermatt_metabox_guide( __( "You can create a gallery by pressing the <em>Add Images</em> button below. You should also set a featured image that will be used as the cover image.", 'zermatt' ) );
			zermatt_metabox_gallery();
		zermatt_metabox_close_tab();
	?></div><?php

}

function zermatt_attraction_save_meta( $post_id, $post ) {

	if ( ! zermatt_can_save_meta( 'zermatt_attraction' ) ) {
		return;
	}

	zermatt_metabox_gallery_save( $_POST );

	update_post_meta( $post_id, 'subtitle', sanitize_text_field( $_POST['subtitle'] ) );
	update_post_meta( $post_id, 'header_image_id', zermatt_sanitize_intval_or_empty( $_POST['header_image_id'] ) );
}

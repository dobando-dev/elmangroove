<?php
add_action( 'init', 'zermatt_create_gallery' );

function zermatt_create_gallery() {
	$labels = array(
		'name'               => esc_html_x( 'Galleries', 'post type general name', 'zermatt' ),
		'singular_name'      => esc_html_x( 'Gallery', 'post type singular name', 'zermatt' ),
		'menu_name'          => esc_html_x( 'Galleries', 'admin menu', 'zermatt' ),
		'name_admin_bar'     => esc_html_x( 'Gallery', 'add new on admin bar', 'zermatt' ),
		'add_new'            => esc_html__( 'Add New', 'zermatt' ),
		'add_new_item'       => esc_html__( 'Add New Gallery', 'zermatt' ),
		'edit_item'          => esc_html__( 'Edit Gallery', 'zermatt' ),
		'new_item'           => esc_html__( 'New Gallery', 'zermatt' ),
		'view_item'          => esc_html__( 'View Gallery', 'zermatt' ),
		'search_items'       => esc_html__( 'Search Galleries', 'zermatt' ),
		'not_found'          => esc_html__( 'No Galleries found', 'zermatt' ),
		'not_found_in_trash' => esc_html__( 'No Galleries found in the trash', 'zermatt' ),
		'parent_item_colon'  => esc_html__( 'Parent Gallery:', 'zermatt' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => esc_html_x( 'Gallery', 'post type singular name', 'zermatt' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => esc_html_x( 'gallery', 'post type slug', 'zermatt' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-format-gallery'
	);

	register_post_type( 'zermatt_gallery' , $args );

	$labels = array(
		'name'              => esc_html_x( 'Gallery Categories', 'taxonomy general name', 'zermatt' ),
		'singular_name'     => esc_html_x( 'Gallery Category', 'taxonomy singular name', 'zermatt' ),
		'search_items'      => esc_html__( 'Search Gallery Categories', 'zermatt' ),
		'all_items'         => esc_html__( 'All Gallery Categories', 'zermatt' ),
		'parent_item'       => esc_html__( 'Parent Gallery Category', 'zermatt' ),
		'parent_item_colon' => esc_html__( 'Parent Gallery Category:', 'zermatt' ),
		'edit_item'         => esc_html__( 'Edit Gallery Category', 'zermatt' ),
		'update_item'       => esc_html__( 'Update Gallery Category', 'zermatt' ),
		'add_new_item'      => esc_html__( 'Add New Gallery Category', 'zermatt' ),
		'new_item_name'     => esc_html__( 'New Gallery Category Name', 'zermatt' ),
		'menu_name'         => esc_html__( 'Categories', 'zermatt' ),
		'view_item'         => esc_html__( 'View Gallery Category', 'zermatt' ),
		'popular_items'     => esc_html__( 'Popular Gallery Categories', 'zermatt' ),
	);
	register_taxonomy( 'zermatt_gallery_category', array( 'zermatt_gallery' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => esc_html_x( 'gallery-category', 'taxonomy slug', 'zermatt' ) ),
	) );

}

add_action( 'load-post.php', 'zermatt_gallery_meta_boxes_setup' );
add_action( 'load-post-new.php', 'zermatt_gallery_meta_boxes_setup' );
function zermatt_gallery_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'zermatt_gallery_add_meta_boxes' );
	add_action( 'save_post', 'zermatt_gallery_save_meta', 10, 2 );
}

function zermatt_gallery_add_meta_boxes() {
	add_meta_box( 'zermatt-gallery-box', esc_html__( 'Gallery Settings', 'zermatt' ), 'zermatt_gallery_score_meta_box', 'zermatt_gallery', 'normal', 'high' );
	add_meta_box( 'zermatt-page-header', esc_html__( 'Page Header', 'zermatt' ), 'zermatt_page_header_meta_box', 'zermatt_gallery', 'normal', 'high' );
}

function zermatt_gallery_score_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'zermatt_gallery' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( false );
			zermatt_metabox_guide( __( "You can create a featured gallery by pressing the <em>Add Images</em> button below. You should also set a featured image that will be used as this Gallery's cover.", 'zermatt' ) );
			zermatt_metabox_gallery();
		zermatt_metabox_close_tab();
	?></div><?php

}

function zermatt_gallery_save_meta( $post_id, $post ) {

	if ( ! zermatt_can_save_meta( 'zermatt_gallery' ) ) {
		return;
	}

	zermatt_metabox_gallery_save( $_POST );

	update_post_meta( $post_id, 'subtitle', sanitize_text_field( $_POST['subtitle'] ) );
	update_post_meta( $post_id, 'header_image_id', zermatt_sanitize_intval_or_empty( $_POST['header_image_id'] ) );
}

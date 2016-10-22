<?php
add_action( 'init', 'zermatt_create_testimonial' );

function zermatt_create_testimonial() {
	$labels = array(
		'name'               => esc_html_x( 'Testimonials', 'post type general name', 'zermatt' ),
		'singular_name'      => esc_html_x( 'Testimonial', 'post type singular name', 'zermatt' ),
		'menu_name'          => esc_html_x( 'Testimonials', 'admin menu', 'zermatt' ),
		'name_admin_bar'     => esc_html_x( 'Testimonial', 'add new on admin bar', 'zermatt' ),
		'add_new'            => esc_html__( 'Add New', 'zermatt' ),
		'add_new_item'       => esc_html__( 'Add New Testimonial', 'zermatt' ),
		'edit_item'          => esc_html__( 'Edit Testimonial', 'zermatt' ),
		'new_item'           => esc_html__( 'New Testimonial', 'zermatt' ),
		'view_item'          => esc_html__( 'View Testimonial', 'zermatt' ),
		'search_items'       => esc_html__( 'Search Testimonials', 'zermatt' ),
		'not_found'          => esc_html__( 'No Testimonials found', 'zermatt' ),
		'not_found_in_trash' => esc_html__( 'No Testimonials found in the trash', 'zermatt' ),
		'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'zermatt' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => esc_html_x( 'Testimonial', 'post type singular name', 'zermatt' ),
		'public'          => false,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => esc_html_x( 'testimonial', 'post type slug', 'zermatt' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor' ),
		'menu_icon'       => 'dashicons-format-quote'
	);

	register_post_type( 'zermatt_testimonial', $args );
}

add_action( 'load-post.php', 'zermatt_testimonial_meta_boxes_setup' );
add_action( 'load-post-new.php', 'zermatt_testimonial_meta_boxes_setup' );
function zermatt_testimonial_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'zermatt_testimonial_add_meta_boxes' );
	add_action( 'save_post', 'zermatt_testimonial_save_meta', 10, 2 );
}

function zermatt_testimonial_add_meta_boxes() {
	add_meta_box( 'zermatt-testimonial-box', esc_html__( 'Testimonial Settings', 'zermatt' ), 'zermatt_testimonial_score_meta_box', 'zermatt_testimonial', 'normal', 'high' );
}

function zermatt_testimonial_score_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'zermatt_testimonial' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			zermatt_metabox_guide( esc_html__( 'Use the main title, to denote who made the testimonial.', 'zermatt' ) );
		zermatt_metabox_close_tab();
	?></div><?php

}

function zermatt_testimonial_save_meta( $post_id, $post ) {

	if ( ! zermatt_can_save_meta( 'zermatt_testimonial' ) ) {
		return;
	}

}

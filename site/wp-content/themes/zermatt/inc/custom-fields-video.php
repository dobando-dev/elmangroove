<?php
add_action( 'init', 'zermatt_create_video' );

function zermatt_create_video() {
	$labels = array(
		'name'               => esc_html_x( 'Videos', 'post type general name', 'zermatt' ),
		'singular_name'      => esc_html_x( 'Video', 'post type singular name', 'zermatt' ),
		'menu_name'          => esc_html_x( 'Videos', 'admin menu', 'zermatt' ),
		'name_admin_bar'     => esc_html_x( 'Video', 'add new on admin bar', 'zermatt' ),
		'add_new'            => esc_html__( 'Add New', 'zermatt' ),
		'add_new_item'       => esc_html__( 'Add New Video', 'zermatt' ),
		'edit_item'          => esc_html__( 'Edit Video', 'zermatt' ),
		'new_item'           => esc_html__( 'New Video', 'zermatt' ),
		'view_item'          => esc_html__( 'View Video', 'zermatt' ),
		'search_items'       => esc_html__( 'Search Videos', 'zermatt' ),
		'not_found'          => esc_html__( 'No Videos found', 'zermatt' ),
		'not_found_in_trash' => esc_html__( 'No Videos found in the trash', 'zermatt' ),
		'parent_item_colon'  => esc_html__( 'Parent Video:', 'zermatt' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => esc_html_x( 'Video', 'post type singular name', 'zermatt' ),
		'public'          => false,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => esc_html_x( 'video', 'post type slug', 'zermatt' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title' ),
		'menu_icon'       => 'dashicons-format-video'
	);

	register_post_type( 'zermatt_video', $args );

	$labels = array(
		'name'              => esc_html_x( 'Video Categories', 'taxonomy general name', 'zermatt' ),
		'singular_name'     => esc_html_x( 'Video Category', 'taxonomy singular name', 'zermatt' ),
		'search_items'      => esc_html__( 'Search Video Categories', 'zermatt' ),
		'all_items'         => esc_html__( 'All Video Categories', 'zermatt' ),
		'parent_item'       => esc_html__( 'Parent Video Category', 'zermatt' ),
		'parent_item_colon' => esc_html__( 'Parent Video Category:', 'zermatt' ),
		'edit_item'         => esc_html__( 'Edit Video Category', 'zermatt' ),
		'update_item'       => esc_html__( 'Update Video Category', 'zermatt' ),
		'add_new_item'      => esc_html__( 'Add New Video Category', 'zermatt' ),
		'new_item_name'     => esc_html__( 'New Video Category Name', 'zermatt' ),
		'menu_name'         => esc_html__( 'Categories', 'zermatt' ),
		'view_item'         => esc_html__( 'View Video Category', 'zermatt' ),
		'popular_items'     => esc_html__( 'Popular Video Categories', 'zermatt' ),
	);
	register_taxonomy( 'zermatt_video_category', array( 'zermatt_video' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => esc_html_x( 'video-category', 'taxonomy slug', 'zermatt' ) ),
	) );

}

add_action( 'load-post.php', 'zermatt_video_meta_boxes_setup' );
add_action( 'load-post-new.php', 'zermatt_video_meta_boxes_setup' );
function zermatt_video_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'zermatt_video_add_meta_boxes' );
	add_action( 'save_post', 'zermatt_video_save_meta', 10, 2 );
}

function zermatt_video_add_meta_boxes() {
	add_meta_box( 'zermatt-video-box', esc_html__( 'Video Settings', 'zermatt' ), 'zermatt_video_score_meta_box', 'zermatt_video', 'normal', 'high' );
}

function zermatt_video_score_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'zermatt_video' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			zermatt_metabox_guide( array(
				sprintf( __( 'In the following box, you can simply enter the URL of a supported website\'s video. It needs to start with <code>http://</code> or <code>https://</code> (E.g. <code>%1$s</code>). A list of supported websites can be <a href="%2$s">found here</a>.', 'zermatt' ), 'https://www.youtube.com/watch?v=4Z9WVZddH9w', 'https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
				__( 'If you enter the URL of a YouTube or a Vimeo video, a thumbnail will automatically be added for you.', 'zermatt' ),
			) );
			zermatt_metabox_input( 'zermatt_video_url', esc_html__( 'Video URL:', 'zermatt' ), array( 'esc_func' => 'esc_url' ) );
		zermatt_metabox_close_tab();
	?></div><?php

}

function zermatt_video_save_meta( $post_id, $post ) {

	if ( ! zermatt_can_save_meta( 'zermatt_video' ) ) {
		return;
	}

	update_post_meta( $post_id, 'zermatt_video_url', esc_url_raw( $_POST['zermatt_video_url'] ) );
}

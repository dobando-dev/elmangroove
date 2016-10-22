<?php
add_action( 'init', 'zermatt_create_slide' );

function zermatt_create_slide() {
	$labels = array(
		'name'               => esc_html_x( 'Slideshow', 'post type general name', 'zermatt' ),
		'singular_name'      => esc_html_x( 'Slide', 'post type singular name', 'zermatt' ),
		'menu_name'          => esc_html_x( 'Slideshow', 'admin menu', 'zermatt' ),
		'name_admin_bar'     => esc_html_x( 'Slideshow', 'add new on admin bar', 'zermatt' ),
		'add_new'            => esc_html__( 'Add New', 'zermatt' ),
		'add_new_item'       => esc_html__( 'Add New Slide', 'zermatt' ),
		'edit_item'          => esc_html__( 'Edit Slide', 'zermatt' ),
		'new_item'           => esc_html__( 'New Slide', 'zermatt' ),
		'view_item'          => esc_html__( 'View Slide', 'zermatt' ),
		'search_items'       => esc_html__( 'Search Slides', 'zermatt' ),
		'not_found'          => esc_html__( 'No Slides found', 'zermatt' ),
		'not_found_in_trash' => esc_html__( 'No Slides found in the trash', 'zermatt' ),
		'parent_item_colon'  => esc_html__( 'Parent Slide:', 'zermatt' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => esc_html_x( 'Slide', 'post type singular name', 'zermatt' ),
		'public'          => false,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => esc_html_x( 'slide', 'post type slug', 'zermatt' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'thumbnail' ),
		'menu_icon'       => 'dashicons-image-flip-horizontal'
	);

	register_post_type( 'zermatt_slide', $args );

	$labels = array(
		'name'              => esc_html_x( 'Slideshow Categories', 'taxonomy general name', 'zermatt' ),
		'singular_name'     => esc_html_x( 'Slideshow Category', 'taxonomy singular name', 'zermatt' ),
		'search_items'      => esc_html__( 'Search Slideshow Categories', 'zermatt' ),
		'all_items'         => esc_html__( 'All Slideshow Categories', 'zermatt' ),
		'parent_item'       => esc_html__( 'Parent Slideshow Category', 'zermatt' ),
		'parent_item_colon' => esc_html__( 'Parent Slideshow Category:', 'zermatt' ),
		'edit_item'         => esc_html__( 'Edit Slideshow Category', 'zermatt' ),
		'update_item'       => esc_html__( 'Update Slideshow Category', 'zermatt' ),
		'add_new_item'      => esc_html__( 'Add New Slideshow Category', 'zermatt' ),
		'new_item_name'     => esc_html__( 'New Slideshow Category Name', 'zermatt' ),
		'menu_name'         => esc_html__( 'Categories', 'zermatt' ),
		'view_item'         => esc_html__( 'View Slideshow Category', 'zermatt' ),
		'popular_items'     => esc_html__( 'Popular Slideshow Categories', 'zermatt' ),
	);
	register_taxonomy( 'zermatt_slide_category', array( 'zermatt_slide' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => esc_html_x( 'video-category', 'taxonomy slug', 'zermatt' ) ),
	) );

}

add_action( 'load-post.php', 'zermatt_slide_meta_boxes_setup' );
add_action( 'load-post-new.php', 'zermatt_slide_meta_boxes_setup' );
function zermatt_slide_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'zermatt_slide_add_meta_boxes' );
	add_action( 'save_post', 'zermatt_slide_save_meta', 10, 2 );
}

function zermatt_slide_add_meta_boxes() {
	add_meta_box( 'zermatt-slide-box', esc_html__( 'Slide Settings', 'zermatt' ), 'zermatt_slide_score_meta_box', 'zermatt_slide', 'normal', 'high' );
}

function zermatt_slide_score_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'zermatt_slide' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( 'Slide Text' );
			zermatt_metabox_checkbox( 'zermatt_slide_text_off', 1, esc_html__( 'Disable slide text for this slide.', 'zermatt' ) );
			zermatt_metabox_input( 'zermatt_slide_subtitle', esc_html__( 'Subtitle (appears below the title)', 'zermatt' ) );
			zermatt_metabox_input( 'zermatt_slide_button_text', esc_html__( 'Button text:', 'zermatt' ), array( 'default' => esc_html_x( 'Learn more', 'slide button', 'zermatt' ) ) );
			zermatt_metabox_input( 'zermatt_slide_button_url', esc_html__( 'Button URL. When someone clicks on this button, this is the link that they will be visiting. If you leave it empty, linking for this slide will be disabled.', 'zermatt' ), array( 'esc_func' => 'esc_url' ) );
		zermatt_metabox_close_tab();

		zermatt_metabox_open_tab( __( 'Video Details', 'zermatt' ) );
			zermatt_metabox_guide( array(
				__( 'You can optionally provide a video for this slide. Videos take up the full width and height of the slide. Make sure you also add a <strong>Featured Image</strong> to this slide for when the video is loading. Please note that videos of any kind will not be displayed in mobile devices and the featured image wil be shown instead.', 'zermatt' ),
				__( 'You can add a self-hosted video by typing its URL or selecting by pressing the <em>Select Video</em> button. The file needs to be in <em>.mp4</em> format.', 'zermatt' ),
				sprintf( __( 'You can simply enter the URL of a supported website\'s video. It needs to start with <code>http://</code> or <code>https://</code> (E.g. <code>%1$s</code>). A list of supported websites can be <a href="%2$s">found here</a>.', 'zermatt' ), 'https://www.youtube.com/watch?v=4Z9WVZddH9w', 'https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
				__( 'Finally, you can simply enter the <strong>embed code</strong> given by a website. It needs to contain an <code>&lt;iframe></code> tag.', 'zermatt' ),
			), array( 'type' => 'ul' ) );

			?><p><?php
				zermatt_metabox_input( 'zermatt_slide_video_url', esc_html__( 'Video URL or embed code:', 'zermatt' ), array(
					'before'      => '',
					'after'       => '',
					'input_class' => 'widefat ci-uploaded-url',
					'esc_func'    => 'esc_url',
				) );
				?><a href="#" class="ci-media-button button"><?php esc_html_e( 'Select Video', 'zermatt' ); ?></a><?php
			?></p><?php
		zermatt_metabox_close_tab();
	?></div><?php

}

function zermatt_slide_save_meta( $post_id, $post ) {

	if ( ! zermatt_can_save_meta( 'zermatt_slide' ) ) {
		return;
	}

	update_post_meta( $post_id, 'zermatt_slide_text_off', zermatt_sanitize_checkbox_ref( $_POST['zermatt_slide_text_off'] ) );
	update_post_meta( $post_id, 'zermatt_slide_button_text', sanitize_text_field( $_POST['zermatt_slide_button_text'] ) );
	update_post_meta( $post_id, 'zermatt_slide_button_url', esc_url_raw( $_POST['zermatt_slide_button_url'] ) );
	update_post_meta( $post_id, 'zermatt_slide_subtitle', sanitize_text_field( $_POST['zermatt_slide_subtitle'] ) );

	$embed = zermatt_sanitize_video_url_embed_code( $_POST['zermatt_slide_video_url'] );
	update_post_meta( $post_id, 'zermatt_slide_video_url', $embed['content'] );
}

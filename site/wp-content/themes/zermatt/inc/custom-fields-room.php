<?php
add_action( 'init', 'zermatt_create_room' );

function zermatt_create_room() {
	$labels = array(
		'name'               => esc_html_x( 'Rooms', 'post type general name', 'zermatt' ),
		'singular_name'      => esc_html_x( 'Room', 'post type singular name', 'zermatt' ),
		'menu_name'          => esc_html_x( 'Rooms', 'admin menu', 'zermatt' ),
		'name_admin_bar'     => esc_html_x( 'Room', 'add new on admin bar', 'zermatt' ),
		'add_new'            => esc_html__( 'Add New', 'zermatt' ),
		'add_new_item'       => esc_html__( 'Add New Room', 'zermatt' ),
		'edit_item'          => esc_html__( 'Edit Room', 'zermatt' ),
		'new_item'           => esc_html__( 'New Room', 'zermatt' ),
		'view_item'          => esc_html__( 'View Room', 'zermatt' ),
		'search_items'       => esc_html__( 'Search Rooms', 'zermatt' ),
		'not_found'          => esc_html__( 'No Rooms found', 'zermatt' ),
		'not_found_in_trash' => esc_html__( 'No Rooms found in the trash', 'zermatt' ),
		'parent_item_colon'  => esc_html__( 'Parent Room:', 'zermatt' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => esc_html_x( 'Room', 'post type singular name', 'zermatt' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => esc_html_x( 'room', 'post type slug', 'zermatt' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-admin-home'
	);

	register_post_type( 'zermatt_room', $args );

	$labels = array(
		'name'              => esc_html_x( 'Room Categories', 'taxonomy general name', 'zermatt' ),
		'singular_name'     => esc_html_x( 'Room Category', 'taxonomy singular name', 'zermatt' ),
		'search_items'      => esc_html__( 'Search Room Categories', 'zermatt' ),
		'all_items'         => esc_html__( 'All Room Categories', 'zermatt' ),
		'parent_item'       => esc_html__( 'Parent Room Category', 'zermatt' ),
		'parent_item_colon' => esc_html__( 'Parent Room Category:', 'zermatt' ),
		'edit_item'         => esc_html__( 'Edit Room Category', 'zermatt' ),
		'update_item'       => esc_html__( 'Update Room Category', 'zermatt' ),
		'add_new_item'      => esc_html__( 'Add New Room Category', 'zermatt' ),
		'new_item_name'     => esc_html__( 'New Room Category Name', 'zermatt' ),
		'menu_name'         => esc_html__( 'Categories', 'zermatt' ),
		'view_item'         => esc_html__( 'View Room Category', 'zermatt' ),
		'popular_items'     => esc_html__( 'Popular Room Categories', 'zermatt' ),
	);
	register_taxonomy( 'zermatt_room_category', array( 'zermatt_room' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => esc_html_x( 'room-category', 'taxonomy slug', 'zermatt' ) ),
	) );

}

add_action( 'load-post.php', 'zermatt_room_meta_boxes_setup' );
add_action( 'load-post-new.php', 'zermatt_room_meta_boxes_setup' );
function zermatt_room_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'zermatt_room_add_meta_boxes' );
	add_action( 'save_post', 'zermatt_room_save_meta', 10, 2 );
}

function zermatt_room_add_meta_boxes() {
	add_meta_box( 'zermatt-room-box', esc_html__( 'Room Settings', 'zermatt' ), 'zermatt_room_meta_box', 'zermatt_room', 'normal', 'high' );
	add_meta_box( 'zermatt-page-header', esc_html__( 'Page Header', 'zermatt' ), 'zermatt_page_header_meta_box', 'zermatt_room', 'normal', 'high' );
}

function zermatt_room_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'zermatt_room' );

	?>
	<div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( esc_html__( 'Amenities', 'zermatt' ) );
			zermatt_metabox_guide( __( 'Provide the amenities of the room. Select <em>Add Field</em> as many times as you want to create a list of amenities. You can delete one by clicking on its <em>Remove Me</em> button to it. You may also click and drag the fields to re-arrange them.', 'zermatt' ) );
			zermatt_metabox_input( 'amenities_title', __( "Amenities' title", 'zermatt' ), array( 'default' => esc_html__( 'Amenities', 'zermatt' ) ) );
			?>
			<fieldset class="amenities ci-repeating-fields">
				<div class="inner">
					<?php
						$fields = get_post_meta($object->ID, 'amenities', true);
						if ( ! empty( $fields ) ) {
							foreach ( $fields as $field ) {
								?>
								<div class="post-field">
									<label><?php _e( 'Amenity:', 'zermatt' ); ?> <input type="text" name="ci_repeatable_room_amenities_title[]" value="<?php echo esc_attr( $field['title'] ); ?>" class="widefat" /></label>
									<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php _e( 'Remove me', 'zermatt' ); ?></a></p>
								</div>
								<?php
							}
						}
					?>
					<div class="post-field field-prototype" style="display: none;">
						<label><?php _e( 'Amenity:', 'zermatt' ); ?> <input type="text" name="ci_repeatable_room_amenities_title[]" value="" class="widefat" /></label>
						<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php _e( 'Remove me', 'zermatt' ); ?></a></p>
					</div>
				</div>
				<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php _e( 'Add Field', 'zermatt' ); ?></a>
			</fieldset><?php
		zermatt_metabox_close_tab();

		zermatt_metabox_open_tab( esc_html__( 'Gallery', 'zermatt' ) );
			zermatt_metabox_guide( esc_html__( "You can create a gallery by pressing the Add Images button below. You should also set a featured image that will be used as the cover image.", 'zermatt' ) );
			zermatt_metabox_gallery();
		zermatt_metabox_close_tab();

		zermatt_metabox_open_tab( esc_html__( 'Pricing', 'zermatt' ) );
			zermatt_metabox_guide( esc_html__( 'Enter the price per night for the room. Include any currency symbols where appropriate.', 'zermatt' ) );
			zermatt_metabox_input( 'price', esc_html__( 'Room price.', 'zermatt' ) );
			zermatt_metabox_checkbox( 'on_offer', 1, esc_html__( 'Room is on offer.', 'zermatt' ) );
		zermatt_metabox_close_tab();

		zermatt_metabox_open_tab( esc_html__( 'Layout', 'zermatt' ) );
			zermatt_metabox_checkbox( 'show_sidebar', 1, esc_html__( 'Show the sidebar on this room.', 'zermatt' ), array( 'default' => 1 ) );
		zermatt_metabox_close_tab();
	?></div><?php

}

function zermatt_room_save_meta( $post_id, $post ) {

	if ( ! zermatt_can_save_meta( 'zermatt_room' ) ) {
		return;
	}

	update_post_meta( $post_id, 'amenities', ci_sanitize_room_amenities( $_POST ) );
	update_post_meta( $post_id, 'amenities_title', sanitize_text_field( $_POST['amenities_title'] ) );

	update_post_meta( $post_id, 'price', sanitize_text_field( $_POST['price'] ) );
	update_post_meta( $post_id, 'on_offer', zermatt_sanitize_checkbox_ref( $_POST['on_offer'] ) );

	update_post_meta( $post_id, 'show_sidebar', zermatt_sanitize_checkbox_ref( $_POST['show_sidebar'] ) );

	update_post_meta( $post_id, 'subtitle', sanitize_text_field( $_POST['subtitle'] ) );
	update_post_meta( $post_id, 'header_image_id', zermatt_sanitize_intval_or_empty( $_POST['header_image_id'] ) );

	zermatt_metabox_gallery_save( $_POST );
}

function ci_sanitize_room_amenities( $POST_array ) {
	if ( empty( $POST_array ) || !is_array( $POST_array ) ) {
		return false;
	}

	$titles = $POST_array['ci_repeatable_room_amenities_title'];

	$count = count( $titles );

	$new_fields = array();

	$records_count = 0;
	for ( $i = 0; $i < $count; $i++ ) {
		if ( empty( $titles[ $i ] ) ) {
			continue;
		}

		$new_fields[ $records_count ]['title'] = sanitize_text_field( $titles[ $i ] );
		$records_count++;
	}
	return $new_fields;
}
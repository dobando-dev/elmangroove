<?php
add_action( 'admin_init', 'zermatt_cpt_page_add_metaboxes' );
add_action( 'save_post', 'zermatt_cpt_page_update_meta' );

function zermatt_cpt_page_add_metaboxes() {
	add_meta_box( 'zermatt-tpl-frontpage', esc_html__( 'Front Page Details', 'zermatt' ), 'zermatt_add_cpt_page_frontpage_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'zermatt-tpl-room-listing', esc_html__( 'Room Listing Options', 'zermatt' ), 'ci_add_cpt_page_room_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'zermatt-tpl-gallery-listing', esc_html__( 'Gallery Listing Options', 'zermatt' ), 'ci_add_cpt_page_gallery_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'zermatt-tpl-video-listing', esc_html__( 'Video Listing Options', 'zermatt' ), 'ci_add_cpt_page_video_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'zermatt-tpl-attraction-listing', esc_html__( 'Attraction Listing Options', 'zermatt' ), 'ci_add_cpt_page_attraction_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'zermatt-tpl-service-listing', esc_html__( 'Service Listing Options', 'zermatt' ), 'ci_add_cpt_page_service_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'zermatt-tpl-contact', esc_html__( 'Contact Page Details', 'zermatt' ), 'ci_add_cpt_page_contact_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'zermatt-tpl-page-gallery', esc_html__( 'Page with Gallery Options', 'zermatt' ), 'ci_add_cpt_page_gallery_meta_box', 'page', 'normal', 'high' );

	add_meta_box( 'zermatt-page-header', esc_html__( 'Page Header', 'zermatt' ), 'zermatt_page_header_meta_box', 'page', 'normal', 'high' );
}

function zermatt_cpt_page_update_meta( $post_id ) {

	if ( ! zermatt_can_save_meta( 'page' ) ) {
		return;
	}

	update_post_meta( $post_id, 'front_slider_base_category', intval( $_POST['front_slider_base_category'] ) );
	update_post_meta( $post_id, 'front_layout', in_array( $_POST['front_layout'], array( '', 'fullscreen' ) ) ? $_POST['front_layout'] : '' );

	update_post_meta( $post_id, 'room_listing_base_category', intval( $_POST['room_listing_base_category'] ) );
	update_post_meta( $post_id, 'room_listing_columns', intval( $_POST['room_listing_columns'] ) );
	update_post_meta( $post_id, 'room_listing_first_fullwidth', zermatt_sanitize_checkbox_ref( $_POST['room_listing_first_fullwidth'] ) );
	update_post_meta( $post_id, 'room_listing_filter', in_array( $_POST['room_listing_filter'], array( 'only_offers', 'no_offers' ) ) ? $_POST['room_listing_filter'] : '' );
	update_post_meta( $post_id, 'room_listing_posts_per_page', intval( $_POST['room_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'gallery_listing_base_category', intval( $_POST['gallery_listing_base_category'] ) );
	update_post_meta( $post_id, 'gallery_listing_columns', intval( $_POST['gallery_listing_columns'] ) );
	update_post_meta( $post_id, 'gallery_listing_first_fullwidth', zermatt_sanitize_checkbox_ref( $_POST['gallery_listing_first_fullwidth'] ) );
	update_post_meta( $post_id, 'gallery_listing_posts_per_page', intval( $_POST['gallery_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'video_listing_base_category', intval( $_POST['video_listing_base_category'] ) );
	update_post_meta( $post_id, 'video_listing_columns', intval( $_POST['video_listing_columns'] ) );
	update_post_meta( $post_id, 'video_listing_posts_per_page', intval( $_POST['video_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'attraction_listing_base_category', intval( $_POST['attraction_listing_base_category'] ) );
	update_post_meta( $post_id, 'attraction_listing_columns', intval( $_POST['attraction_listing_columns'] ) );
	update_post_meta( $post_id, 'attraction_listing_first_fullwidth', zermatt_sanitize_checkbox_ref( $_POST['attraction_listing_first_fullwidth'] ) );
	update_post_meta( $post_id, 'attraction_listing_posts_per_page', intval( $_POST['attraction_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'service_listing_base_category', intval( $_POST['service_listing_base_category'] ) );
	update_post_meta( $post_id, 'service_listing_columns', intval( $_POST['service_listing_columns'] ) );
	update_post_meta( $post_id, 'service_listing_first_fullwidth', zermatt_sanitize_checkbox_ref( $_POST['service_listing_first_fullwidth'] ) );
	update_post_meta( $post_id, 'service_listing_posts_per_page', intval( $_POST['service_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'contact_address', sanitize_text_field( $_POST['contact_address'] ) );
	update_post_meta( $post_id, 'contact_region', sanitize_text_field( $_POST['contact_region'] ) );
	update_post_meta( $post_id, 'contact_locality', sanitize_text_field( $_POST['contact_locality'] ) );
	update_post_meta( $post_id, 'contact_postcode', sanitize_text_field( $_POST['contact_postcode'] ) );
	update_post_meta( $post_id, 'contact_country', sanitize_text_field( $_POST['contact_country'] ) );
	update_post_meta( $post_id, 'contact_telephone', sanitize_text_field( $_POST['contact_telephone'] ) );
	update_post_meta( $post_id, 'contact_fax', sanitize_text_field( $_POST['contact_fax'] ) );
	update_post_meta( $post_id, 'contact_map_lon', sanitize_text_field( $_POST['contact_map_lon'] ) );
	update_post_meta( $post_id, 'contact_map_lat', sanitize_text_field( $_POST['contact_map_lat'] ) );
	update_post_meta( $post_id, 'contact_map_zoom', intval( $_POST['contact_map_zoom'] ) );
	update_post_meta( $post_id, 'contact_map_tooltip', wp_kses( $_POST['contact_map_tooltip'], zermatt_get_allowed_tags() ) );

	zermatt_metabox_gallery_save( $_POST );

	update_post_meta( $post_id, 'subtitle', sanitize_text_field( $_POST['subtitle'] ) );
	update_post_meta( $post_id, 'header_image_id', zermatt_sanitize_intval_or_empty( $_POST['header_image_id'] ) );

}

function zermatt_add_cpt_page_frontpage_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );

			$options = array(
				''           => esc_html_x( 'Normal', 'frontpage layout', 'zermatt' ),
				'fullscreen' => esc_html_x( 'Full screen', 'frontpage layout', 'zermatt' ),
			);
			zermatt_metabox_dropdown( 'front_layout', $options, esc_html__( 'Layout:', 'zermatt' ) );

			$category = get_post_meta( $object->ID, 'front_slider_base_category', true );
			zermatt_metabox_guide( esc_html__( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'zermatt' ) );
			?><p><label for="front_slider_base_category"><?php _e( 'Base slides category:', 'zermatt' ); ?></label><?php
			wp_dropdown_categories( array(
				'taxonomy'          => 'zermatt_slide_category',
				'selected'          => $category,
				'id'                => 'front_slider_base_category',
				'name'              => 'front_slider_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'hierarchical'      => 1,
				'show_count'        => 1,
			) );
			?><p><?php

		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-frontpage', 'template-frontpage.php', 'tpl_frontpage' );
}

function ci_add_cpt_page_room_listing_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			$category = get_post_meta( $object->ID, 'room_listing_base_category', true );

			zermatt_metabox_guide( esc_html__( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'zermatt' ) );
			?><p><label for="room_listing_base_category"><?php esc_html_e( 'Base category:', 'zermatt' ); ?></label><?php
			wp_dropdown_categories( array(
				'selected'          => $category,
				'name'              => 'room_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'zermatt_room_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 3; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'zermatt' ), $i );
			}
			zermatt_metabox_dropdown( 'room_listing_columns', $options, esc_html__( 'Number of columns to display the items in:', 'zermatt' ), array( 'default' => 2 ) );

			zermatt_metabox_checkbox( 'room_listing_first_fullwidth', 1, esc_html__( 'First item appears full width.', 'zermatt' ), array( 'default' => 1 ) );

			$options = array(
				''            => esc_html__( 'All rooms', 'zermatt' ),
				'only_offers' => esc_html__( 'Only rooms on offer', 'zermatt' ),
				'no_offers'   => esc_html__( 'Only rooms not on offer', 'zermatt' ),
			);
			zermatt_metabox_dropdown( 'room_listing_filter', $options, esc_html__( 'Room filter:', 'zermatt' ) );

			zermatt_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <code>-1</code> will show <strong>all items</strong>, while setting it to <code>0</code> or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'zermatt' ), get_option( 'posts_per_page' ) ) );
			zermatt_metabox_input( 'room_listing_posts_per_page', esc_html__( 'Items per page:', 'zermatt' ) );
		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-room-listing', 'template-listing-room.php', 'tpl_room_listing' );
}

function ci_add_cpt_page_gallery_listing_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			$category = get_post_meta( $object->ID, 'gallery_listing_base_category', true );

			zermatt_metabox_guide( esc_html__( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'zermatt' ) );
			?><p><label for="gallery_listing_base_category"><?php esc_html_e( 'Base category:', 'zermatt' ); ?></label><?php
			wp_dropdown_categories( array(
				'selected'          => $category,
				'name'              => 'gallery_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'zermatt_gallery_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 3; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'zermatt' ), $i );
			}
			zermatt_metabox_dropdown( 'gallery_listing_columns', $options, esc_html__( 'Number of columns to display the items in:', 'zermatt' ), array( 'default' => 2 ) );

			zermatt_metabox_checkbox( 'gallery_listing_first_fullwidth', 1, esc_html__( 'First item appears full width.', 'zermatt' ), array( 'default' => 1 ) );

			zermatt_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <code>-1</code> will show <strong>all items</strong>, while setting it to <code>0</code> or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'zermatt' ), get_option( 'posts_per_page' ) ) );
			zermatt_metabox_input( 'gallery_listing_posts_per_page', esc_html__( 'Items per page:', 'zermatt' ) );
		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-gallery-listing', 'template-listing-gallery.php', 'tpl_gallery_listing' );
}

function ci_add_cpt_page_video_listing_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			$category = get_post_meta( $object->ID, 'video_listing_base_category', true );

			zermatt_metabox_guide( esc_html__( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'zermatt' ) );
			?><p><label for="video_listing_base_category"><?php esc_html_e( 'Base category:', 'zermatt' ); ?></label><?php
			wp_dropdown_categories( array(
				'selected'          => $category,
				'name'              => 'video_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'zermatt_video_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 3; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'zermatt' ), $i );
			}
			zermatt_metabox_dropdown( 'video_listing_columns', $options, esc_html__( 'Number of columns to display the items in:', 'zermatt' ), array( 'default' => 2 ) );

			zermatt_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <code>-1</code> will show <strong>all items</strong>, while setting it to <code>0</code> or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'zermatt' ), get_option( 'posts_per_page' ) ) );
			zermatt_metabox_input( 'video_listing_posts_per_page', esc_html__( 'Items per page:', 'zermatt' ) );
		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-video-listing', 'template-listing-video.php', 'tpl_video_listing' );
}

function ci_add_cpt_page_attraction_listing_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			$category = get_post_meta( $object->ID, 'attraction_listing_base_category', true );

			zermatt_metabox_guide( esc_html__( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'zermatt' ) );
			?><p><label for="attraction_listing_base_category"><?php esc_html_e( 'Base category:', 'zermatt' ); ?></label><?php
			wp_dropdown_categories( array(
				'selected'          => $category,
				'name'              => 'attraction_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'zermatt_attraction_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 3; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'zermatt' ), $i );
			}
			zermatt_metabox_dropdown( 'attraction_listing_columns', $options, esc_html__( 'Number of columns to display the items in:', 'zermatt' ), array( 'default' => 2 ) );

			zermatt_metabox_checkbox( 'attraction_listing_first_fullwidth', 1, esc_html__( 'First item appears full width.', 'zermatt' ), array( 'default' => 1 ) );

			zermatt_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <code>-1</code> will show <strong>all items</strong>, while setting it to <code>0</code> or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'zermatt' ), get_option( 'posts_per_page' ) ) );
			zermatt_metabox_input( 'attraction_listing_posts_per_page', esc_html__( 'Items per page:', 'zermatt' ) );
		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-attraction-listing', 'template-listing-attraction.php', 'tpl_attraction_listing' );
}

function ci_add_cpt_page_service_listing_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			$category = get_post_meta( $object->ID, 'service_listing_base_category', true );

			zermatt_metabox_guide( esc_html__( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'zermatt' ) );
			?><p><label for="service_listing_base_category"><?php esc_html_e( 'Base category:', 'zermatt' ); ?></label><?php
			wp_dropdown_categories( array(
				'selected'          => $category,
				'name'              => 'service_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'zermatt_service_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 3; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'zermatt' ), $i );
			}
			zermatt_metabox_dropdown( 'service_listing_columns', $options, esc_html__( 'Number of columns to display the items in:', 'zermatt' ), array( 'default' => 2 ) );

			zermatt_metabox_checkbox( 'service_listing_first_fullwidth', 1, esc_html__( 'First item appears full width.', 'zermatt' ), array( 'default' => 1 ) );

			zermatt_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <code>-1</code> will show <strong>all items</strong>, while setting it to <code>0</code> or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'zermatt' ), get_option( 'posts_per_page' ) ) );
			zermatt_metabox_input( 'service_listing_posts_per_page', esc_html__( 'Items per page:', 'zermatt' ) );
		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-service-listing', 'template-listing-service.php', 'tpl_service_listing' );
}

function ci_add_cpt_page_contact_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( esc_html__( 'Information', 'zermatt' ) );
			zermatt_metabox_guide( esc_html__( 'Provide your physical contact details.', 'zermatt' ) );
			zermatt_metabox_input( 'contact_address', esc_html__( 'Address:', 'zermatt' ) );
			zermatt_metabox_input( 'contact_region', esc_html__( 'Region:', 'zermatt' ) );
			zermatt_metabox_input( 'contact_locality', esc_html__( 'City / Town:', 'zermatt' ) );
			zermatt_metabox_input( 'contact_postcode', esc_html__( 'Post Code:', 'zermatt' ) );
			zermatt_metabox_input( 'contact_country', esc_html__( 'Country:', 'zermatt' ) );
			zermatt_metabox_input( 'contact_telephone', esc_html__( 'Telephone Number:', 'zermatt' ) );
			zermatt_metabox_input( 'contact_fax', esc_html__( 'Fax Number:', 'zermatt' ) );
		zermatt_metabox_close_tab();

		zermatt_metabox_open_tab( esc_html__( 'Map', 'zermatt' ) );
			zermatt_metabox_guide( __( 'Enter a place or address and press <em>Search place/address</em>. Alternatively, you can drag the marker to the desired position, or double click on the map to set a new location.', 'zermatt' ) );
			?>
			<fieldset class="gllpLatlonPicker">
				<input type="text" class="gllpSearchField">
				<input type="button" class="button gllpSearchButton" value="<?php esc_attr_e( 'Search place/address', 'zermatt' ); ?>">
				<div class="gllpMap"><?php esc_html_e( 'Google Maps', 'zermatt' ); ?></div>
				<?php
					zermatt_metabox_input( 'contact_map_zoom', '', array(
						'input_type'  => 'hidden',
						'input_class' => 'gllpZoom',
						'default'     => '8'
					) );
					zermatt_metabox_input( 'contact_map_lat', __( 'Location Latitude.', 'zermatt' ), array(
						'input_class' => 'widefat gllpLatitude',
						'default'     => '36'
					) );
					zermatt_metabox_input( 'contact_map_lon', __( 'Location Longitude.', 'zermatt' ), array(
						'input_class' => 'widefat gllpLongitude',
						'default'     => '-120'
					) );
				?>
				<p><input type="button" class="button gllpUpdateButton" value="<?php esc_attr_e( 'Update map', 'zermatt' ); ?>"></p>
			</fieldset>
			<?php

			zermatt_metabox_textarea( 'contact_map_tooltip', esc_html__( 'Tooltip text:', 'zermatt' ) );
		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-contact', 'template-contact.php', 'tpl_contact_form' );
}

function ci_add_cpt_page_gallery_meta_box( $object, $box ) {
	zermatt_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( false );
			zermatt_metabox_guide( __( "You can create a gallery by pressing the <em>Add Images</em> button below. You should also set a featured image that will be used as this Page's cover.", 'zermatt' ) );
			zermatt_metabox_gallery();
		zermatt_metabox_close_tab();
	?></div><?php

	zermatt_bind_metabox_to_page_template( 'zermatt-tpl-page-gallery', 'template-page-gallery.php', 'tpl_page_gallery' );
}

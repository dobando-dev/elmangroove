<?php
if ( ! class_exists( 'CI_Widget_Contact' ) ):
	class CI_Widget_Contact extends WP_Widget {

		protected $defaults = array(
			'title'  => '',
			'text'   => '',
			'postid' => '',

			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
		);

		function __construct(){
			$widget_ops  = array( 'description' => esc_html__( 'Displays the contents of a Contact Page template.', 'zermatt' ) );
			$control_ops = array( /*'width' => 300, 'height' => 400*/ );
			parent::__construct( 'ci-contact', $name = esc_html__( 'Theme - Contact', 'zermatt' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
		}

		function widget( $args, $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$postid = $instance['postid'];
			$text   = $instance['text'];

			if ( empty( $postid ) ) {
				return;
			}

			$page = get_post( $postid );
			if ( empty( $page ) || is_wp_error( $page ) ) {
				return;
			}

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? get_the_title( $page ) : $instance['title'], $instance, $this->id_base );

			$form_action = get_permalink( $postid );

			$before_widget = $args['before_widget'];
			$after_widget  = $args['after_widget'];

			$background_color = $instance['background_color'];
			$background_image = $instance['background_image'];

			if ( ! empty( $background_color ) || ! empty( $background_image ) ) {
				preg_match( '/class=(["\']).*?widget.*?\1/', $before_widget, $match );
				if ( ! empty( $match ) ) {
					$attr_class    = preg_replace( '/\bwidget\b/', 'widget widget-padded', $match[0], 1 );
					$before_widget = str_replace( $match[0], $attr_class, $before_widget );
				}
			}

			echo $before_widget;

			?><div class="widget-wrap"><?php

			if ( in_array( $args['id'], zermatt_get_fullwidth_sidebars() ) ) {
				?>
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
				<?php
			}


			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( ! empty( $form_action ) ) {
				?>
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<?php
							$map_lon  = get_post_meta( $postid, 'contact_map_lon', true );
							$map_lat  = get_post_meta( $postid, 'contact_map_lat', true );
							$map_zoom = get_post_meta( $postid, 'contact_map_zoom', true );
							$map_tip  = get_post_meta( $postid, 'contact_map_tooltip', true );
						?>
						<?php if ( ! empty( $map_lat ) && ! empty( $map_lon ) ): ?>
							<div class="ci-map-wrap">
								<div id="ci-map-<?php the_ID(); ?>" class="ci-map" data-lat="<?php echo esc_attr( $map_lat ); ?>" data-lng="<?php echo esc_attr( $map_lon ); ?>" data-zoom="<?php echo esc_attr( $map_zoom ); ?>" data-tooltip-txt="<?php echo esc_attr( $map_tip ); ?>" title="<?php the_title_attribute(); ?>"></div>
							</div>
						<?php endif; ?>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="row">
							<div class="col-sm-6">
								<h4><?php esc_html_e( 'Address', 'zermatt' ); ?></h4>

								<?php
									$contact_address   = get_post_meta( $postid, 'contact_address', true );
									$contact_region    = get_post_meta( $postid, 'contact_region', true );
									$contact_locality  = get_post_meta( $postid, 'contact_locality', true );
									$contact_postcode  = get_post_meta( $postid, 'contact_postcode', true );
									$contact_country   = get_post_meta( $postid, 'contact_country', true );
									$contact_telephone = get_post_meta( $postid, 'contact_telephone', true );
									$contact_fax       = get_post_meta( $postid, 'contact_fax', true );

									$address_elements = array();

									if ( ! empty( $contact_address ) ) {
										$address_elements[] = sprintf( '<span class="street-address">%s</span>', $contact_address );
									}
									if ( ! empty( $contact_region ) ) {
										$address_elements[] = sprintf( '<span class="region">%s</span>', $contact_region );
									}
									if ( ! empty( $contact_locality ) ) {
										$address_elements[] = sprintf( '<span class="locality">%s</span>', $contact_locality );
									}
									if ( ! empty( $contact_postcode ) ) {
										$address_elements[] = sprintf( '<span class="postal-code">%s</span>', $contact_postcode );
									}
									if ( ! empty( $contact_country ) ) {
										$address_elements[] = sprintf( '<span class="country-name">%s</span>', $contact_country );
									}
								?>
								<div class="vcard ci-address">
									<p class="adr">
										<?php echo implode( '<br>', $address_elements ); ?>
									</p>
									<?php if ( ! empty( $contact_telephone ) ): ?>
										<p class="tel"><?php echo esc_html( $contact_telephone ); ?></p>
									<?php endif; ?>
									<?php if ( ! empty( $contact_fax ) ): ?>
										<p class="tel"><?php echo esc_html( $contact_fax ); ?></p>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-sm-6">
								<?php dynamic_sidebar( 'contact-form' ); ?>
							</div>

							<?php if ( ! empty( $text ) ): ?>
								<div class="col-xs-12">
									<h4><?php esc_html_e( 'Contact', 'zermatt' ); ?></h4>
									<?php echo wpautop( do_shortcode( $text ) ); ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
				<?php
			}

			if ( in_array( $args['id'], zermatt_get_fullwidth_sidebars() ) ) {
				?>
						</div>
					</div>
				</div>
				<?php
			}


			?></div><?php

			echo $after_widget;

		} // widget

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']  = sanitize_text_field( $new_instance['title'] );
			$instance['text']   = wp_kses_post( $new_instance['text'] );
			$instance['postid'] = intval( $new_instance['postid'] );

			$instance['color']             = zermatt_sanitize_hex_color( $new_instance['color'] );
			$instance['background_color']  = zermatt_sanitize_hex_color( $new_instance['background_color'] );
			$instance['background_image']  = intval( $new_instance['background_image'] );
			$instance['background_repeat'] = in_array( $new_instance['background_repeat'], array( 'repeat', 'no-repeat', 'repeat-x', 'repeat-y' ) ) ? $new_instance['background_repeat'] : 'repeat';

			return $instance;
		} // save

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title  = $instance['title'];
			$text   = $instance['text'];
			$postid = $instance['postid'];

			$color             = $instance['color'];
			$background_color  = $instance['background_color'];
			$background_image  = $instance['background_image'];
			$background_repeat = $instance['background_repeat'];

			?>
			<p><label><?php _e( 'Title (optional):', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>
			<p><?php _e( "The widget will display the map and address that you've set from the specified Contact page below. If you also want a contact form displayed, you'll need to also provide the contact form shortcode in the Text field below.", 'zermatt' ); ?></p>
			<p>
				<label><?php _e( 'Contact form page:', 'zermatt' ); ?>
					<?php
						wp_dropdown_pages( array(
							'name'                 => $this->get_field_name( 'postid' ),
							'id'                   => $this->get_field_id( 'postid' ),
							'selected'             => $postid,
							'class'                => 'widefat',
							'show_option_none'     => '&nbsp;',
							'select_even_if_empty' => true,
						) );
					?>
				</label>
			</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text (contact form shortcode):', 'zermatt' ); ?></label><textarea id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" class="widefat"><?php echo esc_textarea( $text ); ?></textarea></p>

			<fieldset class="ci-collapsible">
				<legend><?php esc_html_e( 'Custom Colors', 'zermatt' ); ?> <i class="dashicons dashicons-arrow-down"></i></legend>
				<div class="elements">
					<p><label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php esc_html_e( 'Foreground Color:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo esc_attr( $color ); ?>" class="colorpckr widefat"/></p>
					<p><label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo esc_attr( $background_color ); ?>" class="colorpckr widefat"/></p>

					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>"><?php _e( 'Background Image:', 'zermatt' ); ?></label>
						<div class="ci-upload-preview">
							<div class="upload-preview">
								<?php if ( ! empty( $background_image ) ): ?>
									<?php
										$image_url = zermatt_get_image_src( $background_image, 'zermatt_featgal_small_thumb' );
										echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
											$image_url,
											esc_attr( __('Remove image', 'zermatt') )
										);
									?>
								<?php endif; ?>
							</div>
							<input type="hidden" class="ci-uploaded-id" name="<?php echo esc_attr( $this->get_field_name( 'background_image' ) ); ?>" value="<?php echo esc_attr( $background_image ); ?>" />
							<input id="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>" type="button" class="button ci-media-button" value="<?php esc_attr_e( 'Select Image', 'zermatt' ); ?>" />
						</div>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'background_repeat' ); ?>"><?php esc_html_e( 'Background Repeat:', 'zermatt' ); ?></label>
						<select id="<?php echo $this->get_field_id( 'background_repeat' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'background_repeat' ); ?>">
							<option value="repeat" <?php selected( 'repeat', $background_repeat ); ?>><?php esc_html_e( 'Repeat', 'zermatt' ); ?></option>
							<option value="repeat-x" <?php selected( 'repeat-x', $background_repeat ); ?>><?php esc_html_e( 'Repeat Horizontally', 'zermatt' ); ?></option>
							<option value="repeat-y" <?php selected( 'repeat-y', $background_repeat ); ?>><?php esc_html_e( 'Repeat Vertically', 'zermatt' ); ?></option>
							<option value="no-repeat" <?php selected( 'no-repeat', $background_repeat ); ?>><?php esc_html_e( 'No Repeat', 'zermatt' ); ?></option>
						</select>
					</p>
				</div>
			</fieldset>
			<?php
		} // form


		function enqueue_custom_css() {
			$settings = $this->get_settings();

			if ( empty( $settings ) ) {
				return;
			}

			foreach ( $settings as $instance_id => $instance ) {
				$id = $this->id_base . '-' . $instance_id;

				if ( ! is_active_widget( false, $id, $this->id_base ) ) {
					continue;
				}

				$sidebar_id      = false; // Holds the sidebar id that the widget is assigned to.
				$sidebar_widgets = wp_get_sidebars_widgets();
				if ( ! empty( $sidebar_widgets ) ) {
					foreach ( $sidebar_widgets as $sidebar => $widgets ) {
						// We need to check $widgets for emptiness due to https://core.trac.wordpress.org/ticket/14876
						if ( ! empty( $widgets ) && array_search( $id, $widgets ) !== false ) {
							$sidebar_id = $sidebar;
						}
					}
				}

				$instance = wp_parse_args( (array) $instance, $this->defaults );

				$color             = $instance['color'];
				$background_color  = $instance['background_color'];
				$background_image  = $instance['background_image'];
				$background_repeat = $instance['background_repeat'];

				$css         = '';
				$padding_css = '';

				if ( ! empty( $color ) ) {
					$css .= 'color: ' . $color . '; ';
				}
				if ( ! empty( $background_color ) ) {
					$css .= 'background-color: ' . $background_color . '; ';
				}
				if ( ! empty( $background_image ) ) {
					$css .= 'background-image: url(' . esc_url( zermatt_get_image_src( $background_image ) ) . ');';
					$css .= 'background-repeat: ' . $background_repeat . ';';
				}

				if ( ! empty( $css ) || ! empty( $padding_css ) ) {
					$css = '#' . $id . ' .widget-wrap { ' . $css . $padding_css . ' } ' . PHP_EOL;
					wp_add_inline_style( 'zermatt-style', $css );
				}

			}

		}

	} // class

	register_widget( 'CI_Widget_Contact' );

endif;
<?php
if ( ! class_exists( 'CI_Widget_Booking_Form' ) ):
	class CI_Widget_Booking_Form extends WP_Widget {

		protected $defaults = array(
			'title'  => '',
			'button' => '', // This is initialized in the constructor.

			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
		);

		function __construct(){
			$this->defaults['button'] = esc_html__( 'Check Availability', 'zermatt' );

			$widget_ops  = array( 'description' => esc_html__( 'Displays a Booking Form that redirects to the booking page.', 'zermatt' ) );
			$control_ops = array( /*'width' => 300, 'height' => 400*/ );
			parent::__construct( 'ci-booking-form', $name = esc_html__( 'Theme - Booking Form', 'zermatt' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
		}

		function widget( $args, $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$button = $instance['button'];

			$form_action = get_theme_mod( 'booking_page' ) ? get_permalink( get_theme_mod( 'booking_page' ) ) : false;

			$before_widget = $args['before_widget'];
			$after_widget  = $args['after_widget'];

			$background_color = $instance['background_color'];
			$background_image = $instance['background_image'];

			preg_match( '/class=(["\']).*?widget.*?\1/', $before_widget, $match );
			if ( ! empty( $match ) ) {
				$attr_class    = preg_replace( '/\bwidget\b/', 'widget widget-padded', $match[0], 1 );
				$before_widget = str_replace( $match[0], $attr_class, $before_widget );
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
				<form class="booking-form booking-form-inline" method="post" action="<?php echo esc_url( $form_action ); ?>">
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="arrival">
								<label for="arrive" class="sr-only"><?php echo esc_html_x( 'Arrival', 'booking form label', 'zermatt' ); ?></label>
								<input type="text" name="arrive" id="arrive" class="datepicker" placeholder="<?php echo esc_attr_x( 'Arrive', 'booking form placeholder', 'zermatt' ); ?>">
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="departure">
								<label for="depart" class="sr-only"><?php echo esc_html_x( 'Departure', 'booking form label', 'zermatt' ); ?></label>
								<input type="text" name="depart" id="depart" class="datepicker" placeholder="<?php echo esc_attr_x( 'Depart', 'booking form placeholder', 'zermatt' ); ?>">
							</div>
						</div>
						<div class="col-md-2 col-sm-6">
							<div class="adults">
								<label for="adults" class="sr-only"><?php echo esc_html_x( 'Adults', 'booking form label', 'zermatt' ); ?></label>
								<div class="ci-select">
									<select name="adults" id="adults" class="dk">
										<option selected disabled><?php echo esc_attr_x( 'Adults', 'booking form placeholder', 'zermatt' ); ?></option>
										<?php for ( $i = 1; $i <= 4; $i ++ ): ?>
											<option value="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></option>
										<?php endfor; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6">
							<div class="room">
								<label for="room" class="sr-only"><?php echo esc_html_x( 'Room', 'booking form label', 'zermatt' ); ?></label>
								<div class="ci-select">
									<select name="room_select" id="room" class="dk">
										<option selected disabled><?php echo esc_attr_x( 'Room', 'booking form placeholder', 'zermatt' ); ?></option>
										<?php
											$selected = is_singular( 'cpt_room' ) ? get_the_ID() : '';

											$q = new WP_Query( array(
												'post_type'      => 'zermatt_room',
												'post_status'    => 'publish',
												'posts_per_page' => - 1,
											) );
										?>
										<?php foreach ( $q->posts as $room ): ?>
											<option value="<?php echo esc_attr( $room->ID ); ?>" <?php selected( $selected, $room->ID ); ?>><?php echo esc_html( strip_tags( $room->post_title ) ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-12">
							<div class="bookbtn">
								<button type="submit" class="btn btn-white btn-transparent"><?php echo esc_html( $button ); ?></button>
							</div>
						</div>
					</div>
				</form>
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
			$instance['button'] = sanitize_text_field( $new_instance['button'] );

			$instance['color']             = zermatt_sanitize_hex_color( $new_instance['color'] );
			$instance['background_color']  = zermatt_sanitize_hex_color( $new_instance['background_color'] );
			$instance['background_image']  = intval( $new_instance['background_image'] );
			$instance['background_repeat'] = in_array( $new_instance['background_repeat'], array( 'repeat', 'no-repeat', 'repeat-x', 'repeat-y' ) ) ? $new_instance['background_repeat'] : 'repeat';

			return $instance;
		} // save

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title  = $instance['title'];
			$button = $instance['button'];

			$color             = $instance['color'];
			$background_color  = $instance['background_color'];
			$background_image  = $instance['background_image'];
			$background_repeat = $instance['background_repeat'];

			?>
			<p><?php _e( "The widget will display a booking form which will redirect on the theme's booking page selected via Appearance > Customize > Booking Options.", 'zermatt' ); ?></p>
			<p><label><?php _e( 'Title (optional):', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>
			<p><label><?php _e( 'Button text:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" type="text" value="<?php echo esc_attr( $button ); ?>" class="widefat" /></p>

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

	register_widget( 'CI_Widget_Booking_Form' );

endif;
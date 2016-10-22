<?php
if ( ! class_exists( 'CI_Widget_Book_Room' ) ):
	class CI_Widget_Book_Room extends WP_Widget {

		protected $defaults = array(
			'title'    => '',
			'text'     => '', // This is initialized in the constructor.
			'subtext'  => '', // This is initialized in the constructor.
			'button'   => '', // This is initialized in the constructor.
			'image_id' => '',

			'color'             => '',
			'background_color'  => '',
		);

		function __construct(){
			$this->defaults['text']    = esc_html__( 'Book This Room', 'zermatt' );
			/* translators: :price: is a placeholder. Do not translate into your language.  */
			$this->defaults['subtext'] = esc_html__( 'From :price: / night', 'zermatt' );
			$this->defaults['button']  = esc_html__( 'Book Now', 'zermatt' );

			$widget_ops  = array( 'description' => esc_html__( 'Displays a Booking call to action, for the currently viewed room. Only displayed in single room pages.', 'zermatt' ) );
			$control_ops = array( /*'width' => 300, 'height' => 400*/ );
			parent::__construct( 'ci-book-room', $name = esc_html__( 'Theme - Book Room', 'zermatt' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
		}

		function widget( $args, $instance ) {

			if ( ! is_singular( 'zermatt_room' ) ) {
				return;
			}

			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$price    = get_post_meta( get_the_ID(), 'price', true );
			$text     = str_replace( ':price:', $price, $instance['text'] );
			$subtext  = str_replace( ':price:', $price, $instance['subtext'] );
			$button   = str_replace( ':price:', $price, $instance['button'] );
			$image_id = $instance['image_id'];

			$form_action = get_theme_mod( 'booking_page' ) ? get_permalink( get_theme_mod( 'booking_page' ) ) : false;

			$before_widget = $args['before_widget'];
			$after_widget  = $args['after_widget'];


			if ( ! empty( $form_action ) ) {

				echo $before_widget;

				if ( ! empty( $title ) ) {
					echo $args['before_title'] . $title . $args['after_title'];
				}

				?>
				<div class="offer-cta">
					<div class="offer-cta-inner">
						<?php if ( ! empty( $image_id ) ): ?>
							<?php $details = wp_prepare_attachment_for_js( $image_id ); ?>
							<img src="<?php echo esc_url( zermatt_get_image_src( $image_id, 'full' ) ); ?>" alt="<?php echo esc_attr( $details['alt'] ); ?>">
						<?php endif; ?>

						<div class="cta-content">
							<?php if ( ! empty( $text ) ): ?>
								<h3><?php echo esc_html( $text ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $subtext ) ): ?>
								<p class="text-styled"><?php echo esc_html( $subtext ); ?></p>
							<?php endif; ?>

							<a class="btn btn-white btn-transparent" href="<?php echo esc_url( add_query_arg( 'room_select', get_the_ID(), $form_action ) ); ?>">
								<?php echo esc_html( $button ); ?>
							</a>
						</div>
					</div>
				</div>
				<?php

				echo $after_widget;

			}

		} // widget

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']    = sanitize_text_field( $new_instance['title'] );
			$instance['text']     = sanitize_text_field( $new_instance['text'] );
			$instance['subtext']  = sanitize_text_field( $new_instance['subtext'] );
			$instance['button']   = sanitize_text_field( $new_instance['button'] );
			$instance['image_id'] = intval( $new_instance['image_id'] );

			$instance['color']            = zermatt_sanitize_hex_color( $new_instance['color'] );
			$instance['background_color'] = zermatt_sanitize_hex_color( $new_instance['background_color'] );

			return $instance;
		} // save

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title    = $instance['title'];
			$text     = $instance['text'];
			$subtext  = $instance['subtext'];
			$button   = $instance['button'];
			$image_id = $instance['image_id'];

			$color            = $instance['color'];
			$background_color = $instance['background_color'];

			?>
			<p><?php _e( "The widget will display a booking form which will redirect on the theme's booking page selected via Appearance > Customize > Booking Options.", 'zermatt' ); ?></p>
			<p><label><?php _e( 'Title (optional):', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>
			<p><?php _e( "Use <code>:price:</code> anywhere below, to substitute with the actuall room's price being shown.", 'zermatt' ); ?></p>
			<p><label><?php _e( 'Text:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" class="widefat" /></p>
			<p><label><?php _e( 'Subtext:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'subtext' ); ?>" name="<?php echo $this->get_field_name( 'subtext' ); ?>" type="text" value="<?php echo esc_attr( $subtext ); ?>" class="widefat" /></p>
			<p><label><?php _e( 'Button text:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" type="text" value="<?php echo esc_attr( $button ); ?>" class="widefat" /></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>"><?php _e( 'Image:', 'zermatt' ); ?></label>
				<div class="ci-upload-preview">
					<div class="upload-preview">
						<?php if ( ! empty( $image_id ) ): ?>
							<?php
								$image_url = zermatt_get_image_src( $image_id, 'zermatt_featgal_small_thumb' );
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
									$image_url,
									esc_attr( __('Remove image', 'zermatt') )
								);
							?>
						<?php endif; ?>
					</div>
					<input type="hidden" class="ci-uploaded-id" name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>" value="<?php echo esc_attr( $image_id ); ?>" />
					<input id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>" type="button" class="button ci-media-button" value="<?php esc_attr_e( 'Select Image', 'zermatt' ); ?>" />
				</div>
			</p>

			<fieldset class="ci-collapsible">
				<legend><?php esc_html_e( 'Custom Colors', 'zermatt' ); ?> <i class="dashicons dashicons-arrow-down"></i></legend>
				<div class="elements">
					<p><label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php esc_html_e( 'Foreground Color:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo esc_attr( $color ); ?>" class="colorpckr widefat"/></p>
					<p><label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo esc_attr( $background_color ); ?>" class="colorpckr widefat"/></p>
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

				$css         = '';
				$padding_css = '';

				if ( ! empty( $color ) ) {
					$css .= 'color: ' . $color . '; ';
				}
				if ( ! empty( $background_color ) ) {
					$css .= 'background-color: ' . $background_color . '; ';
				}

				if ( ! empty( $css ) || ! empty( $padding_css ) ) {
					$css = '#' . $id . ' .offer-cta-inner { ' . $css . $padding_css . ' } ' . PHP_EOL;
					wp_add_inline_style( 'zermatt-style', $css );
				}

			}

		}

	} // class

	register_widget( 'CI_Widget_Book_Room' );

endif;
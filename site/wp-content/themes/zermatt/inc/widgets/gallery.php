<?php
if ( ! class_exists( 'CI_Widget_Gallery' ) ):
	class CI_Widget_Gallery extends WP_Widget {

		protected $defaults = array(
			'title'  => '',
			'postid' => '',

			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
		);

		function __construct() {
			$widget_ops  = array( 'description' => esc_html__( 'Displays a single gallery.', 'zermatt' ) );
			$control_ops = array( 'width' => 300, 'height' => 400 );
			parent::__construct( 'ci-gallery', $name = esc_html__( 'Theme - Gallery', 'zermatt' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
		}


		function widget( $args, $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$postid = $instance['postid'];

			$background_color = $instance['background_color'];
			$background_image = $instance['background_image'];

			$before_widget = $args['before_widget'];
			$after_widget  = $args['after_widget'];

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

			$q = new WP_Query( array(
				'post_type'      => 'zermatt_gallery',
				'p'              => $postid,
				'posts_per_page' => 1,
			) );

			foreach ( $q->posts as $gallery_post ) {

				$alt_title = get_the_title( $gallery_post );
				$title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? $alt_title : $instance['title'], $instance, $this->id_base );

				if ( ! empty( $title ) ) {
					echo $args['before_title'] . $title . $args['after_title'];
				}

				$gallery = zermatt_featgal_get_attachments( $gallery_post->ID );

				if ( $gallery->have_posts() ) {
					?>
					<div class="justified-gallery ci-lightbox-gallery" data-height="280">
						<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
							<?php $details = wp_prepare_attachment_for_js( get_the_ID() ); ?>
							<div>
								<a href="<?php echo esc_url( zermatt_get_image_src( get_the_ID(), 'large' ) ); ?>" title="<?php echo esc_attr( $details['caption'] ); ?>">
									<img
										src="<?php echo esc_url( zermatt_get_image_src( get_the_ID(), 'zermatt_height_limit' ) ); ?>"
										alt="<?php echo esc_attr( $details['alt'] ); ?>">
								</a>
							</div>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
					<?php
				}
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

		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']  = sanitize_text_field( $new_instance['title'] );
			$instance['postid'] = absint( $new_instance['postid'] );

			$instance['color']             = zermatt_sanitize_hex_color( $new_instance['color'] );
			$instance['background_color']  = zermatt_sanitize_hex_color( $new_instance['background_color'] );
			$instance['background_image']  = intval( $new_instance['background_image'] );
			$instance['background_repeat'] = in_array( $new_instance['background_repeat'], array( 'repeat', 'no-repeat', 'repeat-x', 'repeat-y' ) ) ? $new_instance['background_repeat'] : 'repeat';

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title  = $instance['title'];
			$postid = $instance['postid'];

			$color             = $instance['color'];
			$background_color  = $instance['background_color'];
			$background_image  = $instance['background_image'];
			$background_repeat = $instance['background_repeat'];

			?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title (optional):', 'zermatt' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p>

			<label><?php esc_html_e( 'Gallery:', 'zermatt' ); ?>
				<?php zermatt_dropdown_posts( array(
					'post_type'            => 'zermatt_gallery',
					'selected'             => $postid,
					'class'                => 'widefat posts_dropdown',
					'show_option_none'     => '&nbsp;',
					'select_even_if_empty' => true,
				), $this->get_field_name( 'postid' ) ); ?>
			</label>

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

		}

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

	register_widget( 'CI_Widget_Gallery' );

endif;
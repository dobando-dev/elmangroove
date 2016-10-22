<?php 
if ( ! class_exists( 'CI_Widget_Rooms' ) ):
	class CI_Widget_Rooms extends WP_Widget {

		protected $defaults = array(
			'title'    => '',
			'category' => '',
			'random'   => '',
			'count'    => 3,
			'layout'   => '',
		);

		function __construct() {
			$widget_ops  = array( 'description' => esc_html__( 'Displays a number of rooms from a specific category, using a layout.', 'zermatt' ) );
			$control_ops = array();
			parent::__construct( 'ci-rooms', esc_html__( 'Theme - Rooms', 'zermatt' ), $widget_ops, $control_ops );
		}

		function widget( $args, $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$before_widget = $args['before_widget'];
			$after_widget  = $args['after_widget'];

			$category = intval( $instance['category'] );
			$random   = $instance['random'];
			$count    = $instance['count'];
			$layout   = $instance['layout'];

			$term = false;
			$alt_title = '';
			if ( ! empty( $category ) ) {
				$term = get_term( $category, 'zermatt_room_category' );
				if( ! empty( $term ) && ! is_wp_error( $term ) ) {
					$alt_title = $term->name;
				}
			}

			if ( empty( $alt_title ) ) {
				if ( 1 == $random ) {
					$alt_title = esc_html__( 'Random Rooms', 'zermatt' );
				} else {
					$alt_title = esc_html__( 'Rooms', 'zermatt' );
				}
			}

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? $alt_title : $instance['title'], $instance, $this->id_base );

			if ( 0 == $count ) {
				return;
			}

			$query_args = array(
				'post_type'      => 'zermatt_room',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $count
			);

			if ( 1 == $random ) {
				$query_args['orderby'] = 'rand';
				unset( $query_args['order'] );
			}

			if ( ! empty( $category ) && $category > 0 ) {
				$query_args = array_merge( $query_args, array(
					'tax_query' => array(
						array(
							'taxonomy' => 'zermatt_room_category',
							'terms'    => $category
						)
					)
				) );
			}

			$q = new WP_Query( $query_args );

			if ( $q->have_posts() ) {
				echo $before_widget;

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

				global $wp_query;
				$old_wp_query = $wp_query;
				$wp_query = $q;
				get_template_part( 'widget-rooms-layout', $layout );
				$wp_query = $old_wp_query;

				if ( in_array( $args['id'], zermatt_get_fullwidth_sidebars() ) ) {
					?>
							</div>
						</div>
					</div>
					<?php
				}

				echo $after_widget;
			}

		} // widget

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']    = sanitize_text_field( $new_instance['title'] );
			$instance['category'] = zermatt_sanitize_intval_or_empty( $new_instance['category'] );
			$instance['random']   = zermatt_sanitize_checkbox( $new_instance['random'] );
			$instance['count']    = intval( $new_instance['count'] ) > 0 ? intval( $new_instance['count'] ) : $this->defaults['count'];
			$instance['layout']   = zermatt_sanitize_room_widget_layout_choices( $new_instance['layout'] );

			return $instance;
		} // save

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title    = $instance['title'];
			$category = $instance['category'];
			$random   = $instance['random'];
			$count    = $instance['count'];
			$layout   = $instance['layout'];

			?>
			<p><?php echo wp_kses( __( 'Please assign this widget <strong>only</strong> in the <em>Homepage</em> widget area.', 'zermatt' ), array( 'strong' => array(), 'em' => array() ) ); ?></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'zermatt' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category to display the latest posts from (optional):', 'zermatt' ); ?></label>
			<?php wp_dropdown_categories( array(
				'taxonomy'          => 'zermatt_room_category',
				'show_option_all'   => '',
				'show_option_none'  => ' ',
				'option_none_value' => '',
				'show_count'        => 1,
				'echo'              => 1,
				'selected'          => $category,
				'hierarchical'      => 1,
				'name'              => $this->get_field_name( 'category' ),
				'id'                => $this->get_field_id( 'category' ),
				'class'             => 'postform widefat',
			) ); ?>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>"><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'random' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>" value="1" <?php checked( $random, 1 ); ?> /><?php esc_html_e( 'Show random posts.', 'zermatt' ); ?></label></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'zermatt' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="1" step="1" value="<?php echo esc_attr( $count ); ?>" class="widefat"/></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'zermatt' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
					<option value=""></option>
					<?php $choices = zermatt_get_room_widget_layout_choices(); ?>
					<?php foreach( $choices as $value => $description ): ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $layout ); ?>><?php echo strip_tags( $description ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php

		} // form


	} // class

	register_widget( 'CI_Widget_Rooms' );

endif;
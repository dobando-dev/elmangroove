<?php
/**
 * Customize FlexSlider Control class.
 *
 * @see WP_Customize_Control
 */
class Zermatt_Customize_Flexslider_Control extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'flexslider';

	public function __construct( $manager, $id, $args = array() ) {
		if ( ! isset( $args['settings'] ) ) {
			$manager->add_setting( $id . '_slideshow', array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );
			$manager->add_setting( $id . '_slideshowSpeed', array(
				'default'           => 3000,
				'sanitize_callback' => 'absint',
			) );
			$manager->add_setting( $id . '_animationSpeed', array(
				'default'           => 600,
				'sanitize_callback' => 'absint',
			) );
			$this->settings = array(
				'slideshow'      => $id . '_slideshow',
				'slideshowSpeed' => $id . '_slideshowSpeed',
				'animationSpeed' => $id . '_animationSpeed',
			);
		}
		parent::__construct( $manager, $id, $args );
	}

	protected function render_content() {
		if ( ! empty( $this->label ) ) :
			?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
		endif;

		if ( ! empty( $this->description ) ) :
			?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php
		endif;

		?>
		<ul>
			<li>
				<label>
					<input type="checkbox" value="1" <?php $this->link( 'slideshow' ); ?> <?php checked( $this->value( 'slideshow' ), 1 ); ?> />
					<?php _e( 'Auto slide.', 'zermatt' ); ?>
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php _e( 'Pause between slides (in milliseconds):', 'zermatt' ); ?></span>
					<input type="number" min="100" step="100" value="<?php echo esc_attr( $this->value( 'slideshowSpeed' ) ); ?>" <?php $this->link( 'slideshowSpeed' ); ?> />
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php _e( 'Duration of animation (in milliseconds):', 'zermatt' ); ?></span>
					<input type="number" min="100" step="100" value="<?php echo esc_attr( $this->value( 'animationSpeed' ) ); ?>" <?php $this->link( 'animationSpeed' ); ?> />
				</label>
			</li>
		</ul>
		<?php

	}

	public static function sanitize_animation( $input ) {
		return in_array( $input, array( 'fade', 'slide' ) ) ? $input : 'fade';
	}

	public static function sanitize_direction( $input ) {
		return in_array( $input, array( 'horizontal', 'vertical' ) ) ? $input : 'horizontal';
	}

	public static function sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		}

		return '';
	}

	public static function sanitize_positive_or_minus_one( $input ) {
		if ( intval( $input ) > 0 ) {
			return intval( $input );
		}

		return - 1;
	}

}

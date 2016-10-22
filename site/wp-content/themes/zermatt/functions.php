<?php
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/sanitization.php';
require get_template_directory() . '/inc/functions.php';
require get_template_directory() . '/inc/helpers-post-meta.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-styles.php';

require get_template_directory() . '/inc/custom-fields-page.php';
require get_template_directory() . '/inc/custom-fields-slide.php';
require get_template_directory() . '/inc/custom-fields-gallery.php';
require get_template_directory() . '/inc/custom-fields-video.php';
require get_template_directory() . '/inc/custom-fields-attraction.php';
require get_template_directory() . '/inc/custom-fields-service.php';
require get_template_directory() . '/inc/custom-fields-testimonial.php';
require get_template_directory() . '/inc/custom-fields-room.php';

require get_template_directory() . '/inc/WP_OAuth.php';

add_action( 'after_setup_theme', 'zermatt_content_width', 0 );
function zermatt_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'zermatt_content_width', 750 );
}

add_action( 'after_setup_theme', 'zermatt_setup' );
if ( ! function_exists( 'zermatt_setup' ) ) :
function zermatt_setup() {

	if ( ! defined( 'CI_THEME_NAME' ) ) {
		define( 'CI_THEME_NAME', 'zermatt' );
	}
	if ( ! defined( 'CI_WHITELABEL' ) ) {
		// Set the following to true, if you want to remove any user-facing CSSIgniter traces.
		define( 'CI_WHITELABEL', false );
	}

	load_theme_textdomain( 'zermatt', get_template_directory() . '/languages' );

	/*
	 * Theme supports.
	 */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'custom-background' );

	add_theme_support( 'custom-header', array(
		'default-image' => '',
		'width'         => 1920,
		'height'        => 370,
		'uploads'       => true,
		'header-text'   => false,
	) );

	/*
	 * Image sizes.
	 */
	set_post_thumbnail_size( 750, 400, true );
	add_image_size( 'zermatt_hero', 1920, 370, true );
	add_image_size( 'zermatt_fullwidth', 1140, 590, true );
	add_image_size( 'zermatt_height_limit', 0, 300, false );
	add_image_size( 'zermatt_slider', 1920, 800, true );
	add_image_size( 'zermatt_item', 750, 750, true );
	add_image_size( 'zermatt_item_wide', 750, 371, true );


	// Add excerpts to pages.
	add_post_type_support( 'page', 'excerpt' );

	/*
	 * Navigation menus.
	 */
	register_nav_menus( array(
		'main_menu' => esc_html__( 'Main Menu', 'zermatt' ),
	) );



	/*
	 * Default hooks
	 */
	// Prints the inline JS scripts that are registered for printing, and removes them from the queue.
	add_action( 'admin_footer', 'zermatt_print_inline_js' );
	add_action( 'wp_footer', 'zermatt_print_inline_js' );

	// Handle the dismissible sample content notice.
	add_action( 'admin_notices', 'zermatt_admin_notice_sample_content' );
	add_action( 'wp_ajax_zermatt_dismiss_sample_content', 'zermatt_ajax_dismiss_sample_content' );

	// Wraps post counts in span.ci-count
	// Needed for the default widgets, however more appropriate filters don't exist.
	add_filter( 'get_archives_link', 'zermatt_wrap_archive_widget_post_counts_in_span', 10, 2 );
	add_filter( 'wp_list_categories', 'zermatt_wrap_category_widget_post_counts_in_span', 10, 2 );
}
endif;

add_action( 'wp_enqueue_scripts', 'zermatt_enqueue_scripts' );
function zermatt_enqueue_scripts() {

	/*
	 * Styles
	 */
	$theme = wp_get_theme();

	$font_url = '';
	/* translators: If there are characters in your language that are not supported by Lora, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Lora font: on or off', 'zermatt' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lora:400,400italic,700,700italic' ), '//fonts.googleapis.com/css' );
	}
	wp_register_style( 'zermatt-google-font', esc_url( $font_url ) );

	wp_register_style( 'zermatt-base', get_template_directory_uri() . '/css/base.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), '2.5.0' );
	wp_register_style( 'mmenu', get_template_directory_uri() . '/css/mmenu.css', array(), '5.2.0' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.6.3' );
	wp_register_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific.css', array(), '1.0.0' );
	wp_register_style( 'jquery-ui-datepicker', get_template_directory_uri() . '/css/jquery-ui-1.10.4.datepicker.min.css', array(), '1.10.4' );
	wp_register_style( 'justifiedGallery', get_template_directory_uri() . '/css/justifiedGallery.min.css', array(), '3.6.0' );
	wp_register_style( 'weather-icons', get_template_directory_uri() . '/css/weather-icons.css', array(), '2.0.8' );
	wp_register_style( 'slick-slider', get_template_directory_uri() . '/css/slick.css', array(), '1.5.7' );


	wp_register_style( 'zermatt-style', get_template_directory_uri() . '/style.css', array(
		'zermatt-google-font',
		'zermatt-base',
		'flexslider',
		'mmenu',
		'font-awesome',
		'magnific-popup',
		'jquery-ui-datepicker',
		'justifiedGallery',
		'weather-icons',
		'slick-slider'
	), $theme->get( 'Version' ) );

	if ( is_child_theme() ) {
		wp_register_style( 'zermatt-style-child', get_stylesheet_directory_uri() . '/style.css', array(
			'zermatt-style',
		), $theme->get( 'Version' ) );
	}


	/*
	 * Scripts
	 */
	wp_register_script( 'zermatt-google-maps', zermatt_get_google_maps_api_url(), array(), null, false );

	wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.7.5', true );
	wp_register_script( 'mmenu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), '5.2.0', true );
	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '2.5.0', true );
	wp_register_script( 'fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
	wp_register_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'slick-slider', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.5.7', true );
	wp_register_script( 'justifiedGallery', get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js', array( 'jquery' ), '3.6.0', true );

	wp_register_script( 'zermatt-front-scripts', get_template_directory_uri() . '/js/scripts.js', array(
		'jquery',
		'jquery-ui-datepicker',
		'superfish',
		'mmenu',
		'flexslider',
		'fitVids',
		'magnific-popup',
		'slick-slider',
		'justifiedGallery'
	), $theme->get( 'Version' ), true );

	$vars = array(
		'ajaxurl'       => admin_url( 'admin-ajax.php' ),
		'weather_nonce' => wp_create_nonce( 'weather-check' ),
	);
	wp_localize_script( 'zermatt-front-scripts', 'zermatt_vars', $vars );


	/*
	 * Enqueue
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'zermatt-style' );
	if ( is_child_theme() ) {
		wp_enqueue_style( 'zermatt-style-child' );
	}

	if ( get_theme_mod( 'google_maps_api_enable' ) ) {
		wp_enqueue_script( 'zermatt-google-maps' );
	}

	wp_enqueue_script( 'zermatt-front-scripts' );


}

add_action( 'admin_enqueue_scripts', 'zermatt_admin_enqueue_scripts' );
function zermatt_admin_enqueue_scripts( $hook ) {
	$theme = wp_get_theme();

	/*
	 * Styles
	 */
	wp_register_style( 'zermatt-repeating-fields', get_template_directory_uri() . '/css/admin/repeating-fields.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'zermatt-widgets', get_template_directory_uri() . '/css/admin/widgets.css', array(
		'wp-color-picker',
		'zermatt-repeating-fields',
		'zermatt-post-meta'
	), $theme->get( 'Version' ) );

	wp_register_style( 'zermatt-post-edit', get_template_directory_uri() . '/css/admin/post-edit.css', array(), $theme->get( 'Version' ) );

	/*
	 * Scripts
	 */
	wp_register_script( 'zermatt-google-maps', zermatt_get_google_maps_api_url(), array(), null, false );

	wp_register_script( 'jquery-gmaps-latlon-picker', get_template_directory_uri() . '/js/admin/jquery-gmaps-latlon-picker.js', array(
		'jquery',
	), $theme->get( 'Version' ), true );

	wp_register_script( 'zermatt-repeating-fields', get_template_directory_uri() . '/js/admin/repeating-fields.js', array(
		'jquery',
		'jquery-ui-sortable'
	), $theme->get( 'Version' ), true );

	wp_register_script( 'zermatt-widgets', get_template_directory_uri() . '/js/admin/widgets.js', array(
		'jquery',
		'wp-color-picker',
		'zermatt-repeating-fields',
		'zermatt-post-meta',
	), $theme->get( 'Version' ), true );

	$params = array(
		'no_posts_found' => esc_html__( 'No posts found.', 'zermatt' ),
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
	);
	wp_localize_script( 'zermatt-widgets', 'ThemeWidget', $params );



	/*
	 * Enqueue
	 */
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'zermatt-post-meta' );
		wp_enqueue_script( 'zermatt-post-meta' );

		wp_enqueue_style( 'zermatt-repeating-fields' );
		wp_enqueue_script( 'zermatt-repeating-fields' );

		if ( get_theme_mod( 'google_maps_api_enable' ) ) {
			wp_enqueue_script( 'zermatt-google-maps' );
		}

		wp_enqueue_script( 'jquery-gmaps-latlon-picker' );

		wp_enqueue_style( 'zermatt-post-edit' );
	}

	if ( in_array( $hook, array( 'widgets.php', 'customize.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'zermatt-widgets' );
		wp_enqueue_script( 'zermatt-widgets' );
	}

}


add_action( 'widgets_init', 'zermatt_widgets_init' );
function zermatt_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html_x( 'Blog', 'widget area', 'zermatt' ),
		'id'            => 'blog',
		'description'   => esc_html__( 'This is the main sidebar.', 'zermatt' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pages', 'widget area', 'zermatt' ),
		'id'            => 'page',
		'description'   => esc_html__( 'This sidebar appears on your static pages. If empty, the Blog sidebar will be shown instead.', 'zermatt' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Homepage', 'widget area', 'zermatt' ),
		'id'            => 'frontpage',
		'description'   => esc_html__( 'This widget area appears on your front page template.', 'zermatt' ),
		'before_widget' => '<section id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pre-footer site-wide', 'widget area', 'zermatt' ),
		'id'            => 'prefoot',
		'description'   => esc_html__( 'This widget area appears before the footer on every page except the frontpage template.', 'zermatt' ),
		'before_widget' => '<section id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Rooms', 'widget area', 'zermatt' ),
		'id'            => 'room',
		'description'   => esc_html__( 'This sidebar appears on your room pages.', 'zermatt' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Services', 'widget area', 'zermatt' ),
		'id'            => 'service',
		'description'   => esc_html__( 'This sidebar appears on your services pages.', 'zermatt' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Attractions', 'widget area', 'zermatt' ),
		'id'            => 'attraction',
		'description'   => esc_html__( 'This sidebar appears on your attraction pages.', 'zermatt' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Contact form', 'widget area', 'zermatt' ),
		'id'            => 'contact-form',
		'description'   => esc_html__( 'This sidebar appears along with your contact form (either on page or on widget).', 'zermatt' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}

add_action( 'widgets_init', 'zermatt_load_widgets' );
function zermatt_load_widgets() {
	require get_template_directory() . '/inc/widgets/hero.php';
	require get_template_directory() . '/inc/widgets/text.php';
	require get_template_directory() . '/inc/widgets/rooms.php';
	require get_template_directory() . '/inc/widgets/gallery.php';
	require get_template_directory() . '/inc/widgets/latest-posts.php';
	require get_template_directory() . '/inc/widgets/socials.php';
	require get_template_directory() . '/inc/widgets/booking-form.php';
	require get_template_directory() . '/inc/widgets/book-room.php';
	require get_template_directory() . '/inc/widgets/contact.php';
	require get_template_directory() . '/inc/widgets/testimonial.php';
	require get_template_directory() . '/inc/widgets/page-gallery.php';
}


add_filter( 'excerpt_length', 'zermatt_excerpt_length' );
function zermatt_excerpt_length( $length ) {
	return get_theme_mod( 'excerpt_length', 55 );
}

add_filter( 'the_content', 'zermatt_lightbox_rel', 12 );
add_filter( 'get_comment_text', 'zermatt_lightbox_rel' );
add_filter( 'wp_get_attachment_link', 'zermatt_lightbox_rel' );
if ( ! function_exists( 'zermatt_lightbox_rel' ) ):
function zermatt_lightbox_rel( $content ) {
	global $post;
	$attr = 'data-lightbox="gal[' . esc_attr( $post->ID ) . ']"';

	$matched = preg_match( '/<a.*?' . preg_quote( $attr ) . '.*?>.*<\/a>/i', $content, $matches );
	if ( ! $matched ) {
		$pattern     = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 ' . $attr . '$6>$7</a>';
		$content     = preg_replace( $pattern, $replacement, $content );
	}

	return $content;
}
endif;

function zermatt_get_google_maps_api_url() {
	$args = array(
		'v' => '3',
	);

	$key = trim( get_theme_mod( 'google_maps_api_key' ) );

	if ( $key ) {
		$args['key'] = $key;
	}

	return esc_url_raw( add_query_arg( $args, '//maps.googleapis.com/maps/api/js' ) );
}


add_action( 'wp_head', 'zermatt_print_google_analytics_tracking' );
if ( ! function_exists( 'zermatt_print_google_analytics_tracking' ) ):
function zermatt_print_google_analytics_tracking() {
	if ( is_admin() || ! get_theme_mod( 'google_anaytics_tracking_id' ) ) {
		return;
	}
	?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo get_theme_mod( 'google_anaytics_tracking_id' ); ?>', 'auto');
		ga('send', 'pageview');
	</script>
	<?php
}
endif;


add_filter( 'get_archives_link', 'zermatt_remove_archive_widget_nbsp', 15 );
function zermatt_remove_archive_widget_nbsp( $output ) {
	$output = str_replace( '&nbsp;<span class="ci-count">', '<span class="ci-count">', $output );

	return $output;
}


if ( ! function_exists( 'zermatt_get_social_networks' ) ):
function zermatt_get_social_networks() {
	return apply_filters( 'zermatt_get_social_networks', array(
		array(
			'name'  => 'facebook',
			'label' => esc_html__( 'Facebook', 'zermatt' ),
			'icon'  => 'fa-facebook'
		),
		array(
			'name'  => 'twitter',
			'label' => esc_html__( 'Twitter', 'zermatt' ),
			'icon'  => 'fa-twitter'
		),
		array(
			'name'  => 'pinterest',
			'label' => esc_html__( 'Pinterest', 'zermatt' ),
			'icon'  => 'fa-pinterest'
		),
		array(
			'name'  => 'instagram',
			'label' => esc_html__( 'Instagram', 'zermatt' ),
			'icon'  => 'fa-instagram'
		),
		array(
			'name'  => 'gplus',
			'label' => esc_html__( 'Google Plus', 'zermatt' ),
			'icon'  => 'fa-google-plus'
		),
		array(
			'name'  => 'linkedin',
			'label' => esc_html__( 'LinkedIn', 'zermatt' ),
			'icon'  => 'fa-linkedin'
		),
		array(
			'name'  => 'tumblr',
			'label' => esc_html__( 'Tumblr', 'zermatt' ),
			'icon'  => 'fa-tumblr'
		),
		array(
			'name'  => 'flickr',
			'label' => esc_html__( 'Flickr', 'zermatt' ),
			'icon'  => 'fa-flickr'
		),
		array(
			'name'  => 'bloglovin',
			'label' => esc_html__( 'Bloglovin', 'zermatt' ),
			'icon'  => 'fa-heart'
		),
		array(
			'name'  => 'youtube',
			'label' => esc_html__( 'YouTube', 'zermatt' ),
			'icon'  => 'fa-youtube'
		),
		array(
			'name'  => 'vimeo',
			'label' => esc_html__( 'Vimeo', 'zermatt' ),
			'icon'  => 'fa-vimeo'
		),
		array(
			'name'  => 'dribbble',
			'label' => esc_html__( 'Dribbble', 'zermatt' ),
			'icon'  => 'fa-dribbble'
		),
		array(
			'name'  => 'wordpress',
			'label' => esc_html__( 'WordPress', 'zermatt' ),
			'icon'  => 'fa-wordpress'
		),
		array(
			'name'  => '500px',
			'label' => esc_html__( '500px', 'zermatt' ),
			'icon'  => 'fa-500px'
		),
		array(
			'name'  => 'soundcloud',
			'label' => esc_html__( 'Soundcloud', 'zermatt' ),
			'icon'  => 'fa-soundcloud'
		),
		array(
			'name'  => 'spotify',
			'label' => esc_html__( 'Spotify', 'zermatt' ),
			'icon'  => 'fa-spotify'
		),
		array(
			'name'  => 'vine',
			'label' => esc_html__( 'Vine', 'zermatt' ),
			'icon'  => 'fa-vine'
		),
	) );
}
endif;


if ( ! function_exists( 'zermatt_get_columns_classes' ) ):
function zermatt_get_columns_classes( $columns ) {
	switch ( intval( $columns ) ) {
		case 1:
			$classes = 'col-xs-12';
			break;
		case 3:
			$classes = 'col-md-4 col-sm-6 col-xs-12';
			break;
		case 4:
			$classes = 'col-md-3 col-sm-6 col-xs-12';
			break;
		case 2:
		default:
			$classes = 'col-sm-6 col-xs-12';
			break;
	}

	return apply_filters( 'zermatt_get_columns_classes', $classes, $columns );
}
endif;


if ( ! function_exists( 'zermatt_get_fullwidth_sidebars' ) ):
function zermatt_get_fullwidth_sidebars() {
	return apply_filters( 'zermatt_get_fullwidth_sidebars', array(
		'frontpage',
		'prefoot',
	) );
}
endif;


if ( ! function_exists( 'zermatt_get_default_footer_text' ) ) :
function zermatt_get_default_footer_text() {
	if ( ! defined( 'CI_WHITELABEL' ) || ! CI_WHITELABEL ) {
		$text = sprintf( '<a href="%1$s">%2$s</a>', esc_url( 'http://www.cssigniter.com/ignite/themes/zermatt/' ), __( 'Zermatt &ndash; A Hotel WordPress theme', 'zermatt' ) );
	} else {
		$text = sprintf( '<a href="%1$s">%2$s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ) );
	}

	return $text;
}
endif;

if ( ! function_exists( 'zermatt_get_default_footer_text_right' ) ) :
function zermatt_get_default_footer_text_right() {
	if ( ! defined( 'CI_WHITELABEL' ) || ! CI_WHITELABEL ) {
		$text = sprintf( 'Made by <a href="%1$s">CSSIgniter.com</a>', esc_url( 'http://www.cssigniter.com/ignite/' ) );
	} else {
		$text = sprintf( 'Powered by <a href="%1$s">WordPress</a>', esc_url( 'https://wordpress.org/' ) );
	}

	return $text;
}
endif;

if ( ! function_exists( 'zermatt_sanitize_footer_text' ) ) :
function zermatt_sanitize_footer_text( $text ) {
	return wp_kses( $text, zermatt_get_allowed_tags( 'guide' ) );
}
endif;

if ( ! function_exists( 'zermatt_sanitize_video_url_embed_code' ) ) :
function zermatt_sanitize_video_url_embed_code( $input ) {
	$input  = trim( wp_kses( $input, array( 'iframe' => array( 'src' => array() ) ) ) );
	$output = array(
		'type'    => '',
		'content' => '',
	);

	if ( preg_match( '#^<iframe.*src=(["\'])(https?://.*)\1#', $input, $matches ) && ! empty( $matches[2] ) ) {
		$output = array(
			'type'    => 'iframe',
			'content' => $input,
		);
	} elseif ( preg_match( '#^https?://.*\.mp4$#', $input, $matches ) && ! empty( $matches[0] ) ) {
		$output = array(
			'type'    => 'fileurl',
			'content' => esc_url_raw( $matches[0] ),
		);
	} elseif ( preg_match( '#^https?://.*$#', $input, $matches ) && ! empty( $matches[0] ) ) {
		$output = array(
			'type'    => 'url',
			'content' => esc_url_raw( $matches[0] ),
		);
	}

	return $output;
}
endif;


function zermatt_add_auto_thumb_video_field( $field ) {
	return 'zermatt_video_url';
}


add_action( 'wpiw_before_widget', 'zermatt_wpiw_before_widget' );
function zermatt_wpiw_before_widget() {
	?><div data-auto="<?php echo esc_attr( get_theme_mod( 'instagram_auto', 1 ) ); ?>" data-speed="<?php echo esc_attr( get_theme_mod( 'instagram_speed', 300 ) ); ?>"><?php
}
add_action( 'wpiw_after_widget', 'zermatt_wpiw_after_widget' );
function zermatt_wpiw_after_widget() {
	?></div><?php
}


function zermatt_page_header_meta_box( $post ) {
	zermatt_prepare_metabox( get_post_type( $post ) );

	?><div class="ci-cf-wrap"><?php
		zermatt_metabox_open_tab( '' );
			zermatt_metabox_input( 'subtitle', esc_html__( 'Page Subtitle (optional):', 'zermatt' ) );

			zermatt_metabox_guide( esc_html__( 'You can replace the default header image with a different one, applied only on this specific page.', 'zermatt' ) );

			$image_id = get_post_meta( $post->ID, 'header_image_id', true );
			?>
			<div class="ci-upload-preview">
				<div class="upload-preview">
					<?php if ( ! empty( $image_id ) ): ?>
						<?php
							$image_url = zermatt_get_image_src( $image_id, 'zermatt_featgal_small_thumb' );
							echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
								$image_url,
								esc_attr( __( 'Remove image', 'zermatt' ) )
							);
						?>
					<?php endif; ?>
				</div>
				<input type="hidden" class="ci-uploaded-id" name="header_image_id" value="<?php echo esc_attr( $image_id ); ?>" />
				<input type="button" class="button ci-media-button" value="<?php esc_attr_e( 'Select Image', 'zermatt' ); ?>" />
			</div>
			<?php
		zermatt_metabox_close_tab();
	?></div><?php
}


if ( ! function_exists( 'zermatt_get_slides' ) ):
function zermatt_get_slides( $base_category = false, $post_id = false, $return_ids = false ) {

	if( $base_category === false && $post_id === false && get_option( 'show_on_front' ) == 'page' ) {
		$front = get_option( 'page_on_front' );
		if ( ! empty( $front ) ) {
			$base = get_post_meta( $front, 'front_slider_base_category', true );
			if ( ! empty( $base ) ) {
				$base_category = $base;
			}
		}
	} elseif( $base_category === false && $post_id !== false ) {
		$base = get_post_meta( $post_id, 'front_slider_base_category', true );
		if ( ! empty( $base ) ) {
			$base_category = $base;
		}
	}

	$args = array(
		'post_type'      => 'zermatt_slide',
		'posts_per_page' => - 1,
	);

	if ( ! empty( $base_category ) && $base_category > 0 ) {
		$args = array_merge( $args, array(
			'tax_query' => array(
				array(
					'taxonomy' => 'zermatt_slide_category',
					'terms'    => intval( $base_category ),
				)
			)
		) );
	}

	if( $return_ids === true ) {
		$args['fields'] = 'ids';
	}

	return new WP_Query( $args );
}
endif;


function zermatt_excerpt_trip_characters( $max_characters, $excerpt, $content ) {
	// this cleanup is based on wp_trim_excerpt() and wp_trim_words()
	$text = $excerpt;
	if ( empty( $text ) ) {
		$text = $content;
		$text = strip_shortcodes( $text );
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]&gt;', $text );
		$text = wp_strip_all_tags( $text );

		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );

		if ( mb_strlen( $text ) > $max_characters ) {
			$text = mb_substr( $text, 0, $max_characters );
			$text = $text . $excerpt_more;
		}
	}

	return $text;
}

add_filter( 'body_class', 'zermatt_alt_menu_body_class' );
function zermatt_alt_menu_body_class( $classes ) {
	// We need this class on the alternative menu, i.e. horizontal menu.
	if ( false == get_theme_mod( 'header_alt_menu', 1 ) ) {
		$classes[] = 'header-alt';
	}

	return $classes;
}


if ( ! function_exists( 'zermatt_get_weather_unit_choices' ) ):
function zermatt_get_weather_unit_choices() {
	return apply_filters( 'zermatt_weather_unit_choices', array(
		'c' => esc_html__( 'Celsius', 'zermatt' ),
		'f' => esc_html__( 'Fahrenheit', 'zermatt' ),
	) );
}
endif;

if ( ! function_exists( 'zermatt_sanitize_weather_unit' ) ):
function zermatt_sanitize_weather_unit( $value ) {
	$choices = zermatt_get_weather_unit_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return 'c';
}
endif;

if ( ! function_exists( 'zermatt_get_room_widget_layout_choices' ) ):
function zermatt_get_room_widget_layout_choices() {
	return apply_filters( 'zermatt_room_widget_layout_choices', array(
		'left'  => esc_html__( 'Big left (3 rooms max)', 'zermatt' ),
		'right' => esc_html__( 'Big right (3 rooms max)', 'zermatt' ),
		'2col'  => esc_html__( '2 Columns', 'zermatt' ),
		'3col'  => esc_html__( '3 Columns', 'zermatt' ),
	) );
}
endif;

if ( ! function_exists( 'zermatt_sanitize_room_widget_layout_choices' ) ):
function zermatt_sanitize_room_widget_layout_choices( $value ) {
	$choices = zermatt_get_room_widget_layout_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return 'left';
}
endif;


//
// Inject valid GET parameters as theme_mod values
//
add_filter( 'theme_mod_header_alt_menu', 'zermatt_handle_url_theme_mod_header_alt_menu' );
function zermatt_handle_url_theme_mod_header_alt_menu( $value ) {

	if ( ! empty( $_GET['header_alt_menu'] ) && intval( $_GET['header_alt_menu'] ) == 0 ) {
		$value = 0;
	} elseif ( ! empty( $_GET['header_alt_menu'] ) && intval( $_GET['header_alt_menu'] ) == 1 ) {
		$value = 1;
	}
	return $value;
}




add_action( 'wp_ajax_zermatt_get_weather_conditions', 'zermatt_get_yahoo_weather_conditions' );
add_action( 'wp_ajax_nopriv_zermatt_get_weather_conditions', 'zermatt_get_yahoo_weather_conditions' );
function zermatt_get_yahoo_weather_conditions() {
	$valid_nonce = check_ajax_referer( 'weather-check', 'weather_nonce', false );
	if ( false === $valid_nonce ) {
		$response = array(
			'error'        => true,
			'errors'       => array( 'Invalid nonce' ),
			'weather_data' => new stdClass(),
		);

		wp_send_json( $response );
	}

	$key    = trim( get_theme_mod( 'yahoo_weather_api_key' ) );
	$secret = trim( get_theme_mod( 'yahoo_weather_api_secret' ) );

	$woeid = trim( get_theme_mod( 'header_weather_woeid', '784766' ) );
	$unit  = get_theme_mod( 'header_weather_unit', 'c' );

	if ( empty( $key ) || empty( $secret ) || empty( $woeid ) ) {
		$response = array(
			'error'  => true,
			'errors' => array( 'Missing API key/secret or location.' ),
			'data'   => new stdClass(),
		);

		wp_send_json( $response );
	}

	$query = sprintf( "SELECT * FROM weather.forecast WHERE woeid='%s' AND u='%s'",
		$woeid, $unit
	);


	$weather = zermatt_do_yahoo_weather_query( $key, $secret, $query );

	if ( is_wp_error( $weather ) ) {
		$response = array(
			'error'  => true,
			'errors' => $weather->get_error_messages(),
			'data'   => new stdClass(),
		);
	} elseif ( ! empty( $weather ) && isset( $weather['response']['code'] ) && $weather['response']['code'] == 200 ) {
		$response = array(
			'error'  => false,
			'errors' => array(),
			'data'   => json_decode( $weather['body'] ),
		);
	} else {
		$response = array(
			'error'  => true,
			'errors' => array( 'Yahoo! Weather Error' ),
			'data'   => new stdClass(),
		);
	}

	wp_send_json( $response );
}
function zermatt_do_yahoo_weather_query( $key, $secret, $query ) {
	$query_hash = md5( $key . $secret . $query );
	$trans_name = "zermatt_yahoo_weather_{$query_hash}";

	if ( false === ( $response = get_transient( $trans_name ) ) ) {
		$url = 'http://query.yahooapis.com/v1/yql';

		$signatureMethod = new WP_OAuthSignatureMethod_HMAC_SHA1();
		$httpMethod      = 'GET';
		$requestFields   = array(
			'q'      => $query,
			'format' => 'json',
		);

		$oauthConsumer = new WP_OAuthConsumer( $key, $secret, null );
		$oauthRequest  = WP_OAuthRequest::from_consumer_and_token( $oauthConsumer, null, $httpMethod, $url, $requestFields );
		$oauthRequest->sign_request( $signatureMethod, $oauthConsumer, null );

		$response = wp_remote_get( $oauthRequest->to_url() );
		set_transient( $trans_name, $response, apply_filters( 'zermatt_weather_query_cache_time', 20 * MINUTE_IN_SECONDS ) );
	}

	return $response;
}

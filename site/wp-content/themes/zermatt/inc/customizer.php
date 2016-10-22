<?php
add_action( 'customize_register', 'zermatt_customize_register', 100 );
/**
 * Registers all theme-related options to the Customizer.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function zermatt_customize_register( $wpc ) {
	$wpc->add_section( 'header', array(
		'title'    => esc_html_x( 'Header', 'customizer section title', 'zermatt' ),
		'priority' => 1
	) );

	// The following line doesn't work in a some PHP versions. Apparently, get_panel( 'nav_menus' ) returns an array,
	// therefore a cast to object is needed. http://wordpress.stackexchange.com/questions/160987/warning-creating-default-object-when-altering-customize-panels
	//$wpc->get_panel( 'nav_menus' )->priority = 2;
	$panel_menus = (object) $wpc->get_panel( 'nav_menus' );
	$panel_menus->priority = 2;

	$wpc->add_section( 'layout', array(
		'title'    => esc_html_x( 'Layout Options', 'customizer section title', 'zermatt' ),
		'priority' => 20
	) );

	$wpc->add_section( 'homepage', array(
		'title'    => esc_html_x( 'Front Page Carousel', 'customizer section title', 'zermatt' ),
		'priority' => 30
	) );

	$wpc->add_section( 'typography', array(
		'title'    => _x( 'Typography Options', 'customizer section title', 'zermatt' ),
		'priority' => 40
	) );

	$wpc->get_section( 'colors' )->title    = esc_html__( 'Content Colors', 'zermatt' );
	$wpc->get_section( 'colors' )->priority = 50;

	$wpc->add_section( 'sidebar_colors', array(
		'title'    => _x( 'Sidebar Colors', 'customizer section title', 'zermatt' ),
		'priority' => 60
	) );

	// The following line doesn't work in a some PHP versions. Apparently, get_panel( 'widgets' ) returns an array,
	// therefore a cast to object is needed. http://wordpress.stackexchange.com/questions/160987/warning-creating-default-object-when-altering-customize-panels
	//$wpc->get_panel( 'widgets' )->priority = 70;
	$panel_widgets = (object) $wpc->get_panel( 'widgets' );
	$panel_widgets->priority = 70;

	$wpc->add_section( 'social', array(
		'title'       => esc_html_x( 'Social Networks', 'customizer section title', 'zermatt' ),
		'description' => esc_html__( 'Enter your social network URLs. Leaving a URL empty will hide its respective icon.', 'zermatt' ),
		'priority'    => 80
	) );

	$wpc->add_section( 'rooms', array(
		'title'       => esc_html_x( 'Rooms Options', 'customizer section title', 'zermatt' ),
		'priority'    => 90
	) );

	$wpc->add_section( 'booking', array(
		'title'       => esc_html_x( 'Booking - Contact Options', 'customizer section title', 'zermatt' ),
		'description' => esc_html__( 'Global options affecting your booking forms.', 'zermatt' ),
		'priority'    => 100
	) );

	$wpc->add_section( 'footer', array(
		'title'    => esc_html_x( 'Footer', 'customizer section title', 'zermatt' ),
		'priority' => 110
	) );

	// Section 'static_front_page' is not defined when there are no pages.
	if ( get_pages() ) {
		$wpc->get_section( 'static_front_page' )->priority = 120;
	}

	if ( class_exists( 'null_instagram_widget' ) ) {
		$wpc->add_section( 'instagram_widget', array(
			'title'       => esc_html_x( 'Instagram widget', 'customizer section title', 'zermatt' ),
			'description' => esc_html__( 'Options affecting the WP Instagram widget.', 'zermatt' ),
			'priority'    => 130
		) );
	}

	$wpc->add_section( 'weather', array(
		'title'    => esc_html_x( 'Weather', 'customizer section title', 'zermatt' ),
		'priority' => 110
	) );

	$wpc->add_section( 'other', array(
		'title'       => esc_html_x( 'Other', 'customizer section title', 'zermatt' ),
		'description' => esc_html__( 'Other options affecting the whole site.', 'zermatt' ),
		'priority'    => 140
	) );


	//
	// Group options by registering the setting first, and the control right after.
	//

	//
	// Homepage
	//
	$wpc->add_control( new Zermatt_Customize_Flexslider_Control( $wpc, 'home_slider', array(
		'section'     => 'homepage',
		'label'       => esc_html__( 'Home Carousel', 'zermatt' ),
		'description' => esc_html__( 'Fine-tune the homepage carousel.', 'zermatt' ),
	) ) );


	//
	// Layout
	//
	$wpc->add_setting( 'excerpt_length', array(
		'default'           => 55,
		'sanitize_callback' => 'absint',
	) );
	$wpc->add_control( 'excerpt_length', array(
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 10,
			'step' => 1,
		),
		'section'     => 'layout',
		'label'       => esc_html__( 'Automatically generated excerpt length (in words)', 'zermatt' ),
	) );

	$wpc->add_setting( 'pagination_method', array(
		'default'           => 'numbers',
		'sanitize_callback' => 'zermatt_sanitize_pagination_method',
	) );
	$wpc->add_control( 'pagination_method', array(
		'type'    => 'select',
		'section' => 'layout',
		'label'   => esc_html__( 'Pagination method', 'zermatt' ),
		'choices' => array(
			'numbers' => esc_html_x( 'Numbered links', 'pagination method', 'zermatt' ),
			'text'    => esc_html_x( '"Previous - Next" links', 'pagination method', 'zermatt' ),
		),
	) );


	//
	// Header Bar
	//
	$wpc->get_control( 'header_image' )->section = 'header';

	$wpc->add_setting( 'header_bg_color', array(
		'default'           => '#252525',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bg_color', array(
		'section' => 'header',
		'label'   => esc_html__( 'Background Color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'header_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_text_color', array(
		'section' => 'header',
		'label'   => esc_html__( 'Main Color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'header_nav_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_nav_color', array(
		'section' => 'header',
		'label'   => esc_html__( 'Subnav text color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'header_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_hover_color', array(
		'section' => 'header',
		'label'   => esc_html__( 'Hover/Active Color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'header_tagline', array(
		'default'           => 1,
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_tagline', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => esc_html__( 'Show tagline.', 'zermatt' ),
	) );

	$wpc->add_setting( 'header_alt_menu', array(
		'default'           => 1,
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_alt_menu', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => esc_html__( 'Menu always appears mobile-like.', 'zermatt' ),
	) );

	$wpc->add_setting( 'header_booking_button', array(
		'default'           => 1,
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_booking_button', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => esc_html__( 'Show Booking button.', 'zermatt' ),
	) );

	$wpc->add_setting( 'header_weather', array(
		'default'           => 1,
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_weather', array(
		'type'        => 'checkbox',
		'section'     => 'header',
		'label'       => esc_html__( 'Show weather widget.', 'zermatt' ),
		'description' => wp_kses( sprintf( __( 'In order for the weather widget to work, you need to provide more information in the <a href="%s">Weather Section</a>.', 'zermatt' ), esc_url( admin_url( 'customize.php?autofocus[section]=weather' ) ) ), array( 'a' => array( 'href' => true ) ) ),
	) );



	//
	// Typography
	//
	$wpc->add_setting( 'h1_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h1_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H1 size', 'zermatt' ),
	) );

	$wpc->add_setting( 'h2_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h2_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H2 size', 'zermatt' ),
	) );

	$wpc->add_setting( 'h3_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h3_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H3 size', 'zermatt' ),
	) );

	$wpc->add_setting( 'h4_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h4_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H4 size', 'zermatt' ),
	) );

	$wpc->add_setting( 'h5_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h5_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H5 size', 'zermatt' ),
	) );

	$wpc->add_setting( 'h6_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h6_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H6 size', 'zermatt' ),
	) );

	$wpc->add_setting( 'body_text_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'body_text_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'Body text size', 'zermatt' ),
	) );

	$wpc->add_setting( 'widgets_title_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'widgets_title_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'Widgets title size', 'zermatt' ),
	) );

	$wpc->add_setting( 'widgets_text_size', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'widgets_text_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'Widgets text size', 'zermatt' ),
	) );

	$wpc->add_setting( 'lowercase_content_headings', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'lowercase_content_headings', array(
		'type'        => 'checkbox',
		'section'     => 'typography',
		'label'       => esc_html__( 'Lowercase content headings', 'zermatt' )
	) );

	$wpc->add_setting( 'lowercase_widget_titles', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'lowercase_widget_titles', array(
		'type'        => 'checkbox',
		'section'     => 'typography',
		'label'       => esc_html__( 'Lowercase widget titles', 'zermatt' )
	) );


	//
	// Content colors
	//
	$wpc->get_control( 'background_image' )->section      = 'colors';
	$wpc->get_control( 'background_repeat' )->section     = 'colors';
	$wpc->get_control( 'background_position_x' )->section = 'colors';
	$wpc->get_control( 'background_attachment' )->section = 'colors';

	$wpc->add_setting( 'global_body_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_body_bg_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Body Background Color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_primary_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_primary_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Primary color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_text_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Text Color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_link_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Content Link Color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_link_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_link_hover_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Content Link Hover Color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_btn_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_btn_text_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Button Text Color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_btn_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_btn_bg_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Button Background Color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_btn_hover_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_btn_hover_bg_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Button Hover Background Color', 'zermatt' )
	) ) );

	$wpc->add_setting( 'global_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'global_border_color', array(
		'section'     => 'colors',
		'label'       => esc_html__( 'Global Border Color', 'zermatt' )
	) ) );


	//
	// Sidebar colors
	//
	$wpc->add_setting( 'sidebar_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_bg_color', array(
		'section'     => 'sidebar_colors',
		'label'       => esc_html__( 'Background color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'sidebar_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_text_color', array(
		'section'     => 'sidebar_colors',
		'label'       => esc_html__( 'Text color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'sidebar_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_link_color', array(
		'section'     => 'sidebar_colors',
		'label'       => esc_html__( 'Link color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'sidebar_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_hover_color', array(
		'section'     => 'sidebar_colors',
		'label'       => esc_html__( 'Link Hover color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'sidebar_title_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_title_color', array(
		'section'     => 'sidebar_colors',
		'label'       => esc_html__( 'Widget titles color', 'zermatt' ),
	) ) );

	$wpc->add_setting( 'sidebar_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_border_color', array(
		'section'     => 'sidebar_colors',
		'label'       => esc_html__( 'Border color', 'zermatt' ),
	) ) );

	//
	// Social
	//
	$networks = zermatt_get_social_networks();

	foreach ( $networks as $network ) {
		$wpc->add_setting( 'social_' . $network['name'], array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wpc->add_control( 'social_' . $network['name'], array(
			'type'    => 'url',
			'section' => 'social',
			'label'   => sprintf( _x( '%s URL', 'social network url', 'zermatt' ), $network['label'] ),
		) );
	}

	$wpc->add_setting( 'rss_feed', array(
		'default'           => get_bloginfo( 'rss2_url' ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'rss_feed', array(
		'type'    => 'url',
		'section' => 'social',
		'label'   => esc_html__( 'RSS Feed', 'zermatt' ),
	) );



	//
	// Rooms
	//
	$wpc->add_setting( 'single_room_testimonial_title', array(
		'default'           => esc_html__( 'What they say about us', 'zermatt' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'single_room_testimonial_title', array(
		'type'        => 'text',
		'section'     => 'rooms',
		'label'       => esc_html__( 'Random testimonial title', 'zermatt' ),
		'description' => esc_html__( 'Title for the random testimonial that appears on room pages. Leave empty to disable.', 'zermatt' ),
	) );

	$wpc->add_setting( 'single_room_random_testimonial', array(
		'default'           => 1,
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_room_random_testimonial', array(
		'type'    => 'checkbox',
		'section' => 'rooms',
		'label'   => esc_html__( "Show a random testimonial after the room's title.", 'zermatt' ),
	) );

	$wpc->add_setting( 'room_price_text', array(
		/* translators: :price: is a placeholder. Do not translate into your language.  */
		'default'           => esc_html__( 'From :price: / Night', 'zermatt' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'room_price_text', array(
		'type'        => 'text',
		'section'     => 'rooms',
		'label'       => esc_html__( 'Price text', 'zermatt' ),
		'description' => __( "The text that appears wherever the room price is shown. Use <code>:price:</code> to substitute with the actuall room's price being shown.", 'zermatt' ),
	) );


	//
	// Booking
	//
	$wpc->add_setting( 'booking_page', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'booking_page', array(
		'type'        => 'dropdown-pages',
		'section'     => 'booking',
		'label'       => esc_html__( 'Booking page', 'zermatt' ),
		'description' => __( 'Select the page that you have assigned the <strong>Booking Page</strong> template. This is required for the booking widget and header button to function properly.', 'zermatt' ),
	) );

	$wpc->add_setting( 'booking_email', array(
		'default'           => get_option( 'admin_email' ),
		'sanitize_callback' => 'sanitize_email',
	) );
	$wpc->add_control( 'booking_email', array(
		'type'        => 'email',
		'section'     => 'booking',
		'label'       => esc_html__( 'Booking email address', 'zermatt' ),
		'description' => esc_html__( 'The email address that booking requests will be delivered to. This is required for the booking form to function properly.', 'zermatt' ),
	) );

	$wpc->add_setting( 'contact_email', array(
		'default'           => get_option( 'admin_email' ),
		'sanitize_callback' => 'sanitize_email',
	) );
	$wpc->add_control( 'contact_email', array(
		'type'        => 'email',
		'section'     => 'booking',
		'label'       => esc_html__( 'Contact email address', 'zermatt' ),
		'description' => esc_html__( 'The email address that contact form messages will be delivered to. This is required for the contact form to function properly.', 'zermatt' ),
	) );


	//
	// Footer
	//
	$wpc->add_setting( 'footer_text', array(
		'default'           => zermatt_get_default_footer_text(),
		'sanitize_callback' => 'zermatt_sanitize_footer_text',
	) );
	$wpc->add_control( 'footer_text', array(
		'type'        => 'text',
		'section'     => 'footer',
		'label'       => esc_html__( 'Footer text left', 'zermatt' ),
		'description' => esc_html__( 'Allowed tags: a, abbr, acronym, b, br, code, em, i, img, li, ol, pre, span, strong, ul.', 'zermatt' ),
	) );

	$wpc->add_setting( 'footer_text_right', array(
		'default'           => zermatt_get_default_footer_text_right(),
		'sanitize_callback' => 'zermatt_sanitize_footer_text',
	) );
	$wpc->add_control( 'footer_text_right', array(
		'type'        => 'text',
		'section'     => 'footer',
		'label'       => esc_html__( 'Footer text right', 'zermatt' ),
		'description' => esc_html__( 'Allowed tags: a, abbr, acronym, b, br, code, em, i, img, li, ol, pre, span, strong, ul.', 'zermatt' ),
	) );



	//
	// Instagram Widget
	//
	if ( class_exists( 'null_instagram_widget' ) ) {
		$wpc->add_setting( 'instagram_auto', array(
			'default'           => 1,
			'sanitize_callback' => 'zermatt_sanitize_checkbox',
		) );
		$wpc->add_control( 'instagram_auto', array(
			'type'    => 'checkbox',
			'section' => 'instagram_widget',
			'label'   => esc_html__( 'WP Instagram: Slideshow.', 'zermatt' ),
		) );

		$wpc->add_setting( 'instagram_speed', array(
			'default'           => 300,
			'sanitize_callback' => 'zermatt_sanitize_intval_or_empty',
		) );
		$wpc->add_control( 'instagram_speed', array(
			'type'    => 'number',
			'section' => 'instagram_widget',
			'label'   => esc_html__( 'WP Instagram: Slideshow Speed.', 'zermatt' ),
		) );
	}


	//
	// Weather
	//
	$wpc->add_setting( 'yahoo_weather_text', array(
		'default' => '',
	) );
	$wpc->add_control( new Zermatt_Customize_Static_Text_Control( $wpc, 'yahoo_weather_text', array(
		'section'     => 'weather',
		'label'       => esc_html__( 'Weather', 'zermatt' ),
		'description' => array(
			wp_kses( sprintf( __( 'In order to show the current weather conditions on your site, you need an API key/secret from Yahoo! You can obtain a free API key/secret by visiting the <a href="%s" target="_blank">Yahoo! Developer Network</a>. Make sure to <strong>Create an App</strong>, enter an <strong>Application Name</strong> and set the <strong>Application Type</strong> to <strong>Web Application</strong>.', 'zermatt' ), 'https://developer.yahoo.com/apps/create' ), zermatt_get_allowed_tags( 'guide' ) ),
			wp_kses( sprintf( __( 'To find out the weather code of your area, <a href="%s" target="_blank">go to this website</a>, enter your location and press search. Copy and paste the code in the <strong>Weather Code</strong> field. For example, for Zermatt, Switzerland the code is <strong>784766</strong>.', 'zermatt' ), 'http://woeid.rosselliot.co.nz' ), zermatt_get_allowed_tags( 'guide' ) ),
		),
	) ) );

	$wpc->add_setting( 'header_weather_woeid', array(
		'default'           => '784766',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'header_weather_woeid', array(
		'type'        => 'text',
		'section'     => 'weather',
		'label'       => esc_html__( 'Weather Code', 'zermatt' ),
	) );

	$wpc->add_setting( 'header_weather_unit', array(
		'default'           => 'c',
		'sanitize_callback' => 'zermatt_sanitize_weather_unit',
	) );
	$wpc->add_control( 'header_weather_unit', array(
		'type'    => 'select',
		'section' => 'weather',
		'label'   => esc_html__( 'Weather Unit', 'zermatt' ),
		'choices' => zermatt_get_weather_unit_choices(),
	) );

	$wpc->add_setting( 'yahoo_weather_api_key', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'yahoo_weather_api_key', array(
		'type'    => 'text',
		'section' => 'weather',
		'label'   => esc_html__( 'Yahoo Weather API Key', 'zermatt' ),
	) );

	$wpc->add_setting( 'yahoo_weather_api_secret', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'yahoo_weather_api_secret', array(
		'type'    => 'password',
		'section' => 'weather',
		'label'   => esc_html__( 'Yahoo Weather API Secret', 'zermatt' ),
	) );



	//
	// Other
	//
	$wpc->add_setting( 'custom_css', array(
		'default'              => '',
		'sanitize_callback'    => 'zermatt_sanitize_custom_css',
		'sanitize_js_callback' => 'zermatt_sanitize_custom_css',
	) );
	$wpc->add_control( 'custom_css', array(
		'type'    => 'textarea',
		'section' => 'other',
		'label'   => esc_html__( 'Custom CSS', 'zermatt' ),
	) );

	$wpc->add_setting( 'google_anaytics_tracking_id', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'google_anaytics_tracking_id', array(
		'type'        => 'text',
		'section'     => 'other',
		'label'       => esc_html__( 'Google Analytics Tracking ID', 'zermatt' ),
		'description' => wp_kses( sprintf( __( 'Tracking is enabled only for the non-admin portion of your website. If you need fine-grained control of the tracking code, you are strongly adviced to <a href="%s" target="_blank">use a specialty plugin</a> instead.', 'zermatt' ), 'https://wordpress.org/plugins/search.php?q=analytics' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
	) );

	$wpc->add_setting( 'google_maps_api_enable', array(
		'default'           => '',
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'google_maps_api_enable', array(
		'type'        => 'checkbox',
		'section'     => 'other',
		'label'       => esc_html__( 'Enable Google Maps API.', 'zermatt' ),
		'description' => esc_html__( 'The Google Maps API must only be loaded once in each page. Since many plugins may try to load it as well, you might want to disable it from the theme to avoid potential errors.', 'zermatt' ),
	) );

	$wpc->add_setting( 'google_maps_api_key', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'google_maps_api_key', array(
		'type'        => 'text',
		'section'     => 'other',
		'label'       => esc_html__( 'Google Maps API key', 'zermatt' ),
		'description' => sprintf( __( 'Paste here your Google Maps API Key. Maps will <strong>not</strong> be displayed without an API key. You need to issue a key from <a href="%1$s" target="_blank">Google Accounts</a>, and make sure the <strong>Google Maps JavaScript API</strong> is enabled. For instructions on issuing an API key, <a href="%2$s" target="_blank">read this article</a>.', 'zermatt' ),
			'https://code.google.com/apis/console/',
			'http://www.cssigniter.com/docs/article/generate-a-google-maps-api-key/'
		),
	) );

	$wpc->add_setting( 'show_preloader', array(
		'default'           => 1,
		'sanitize_callback' => 'zermatt_sanitize_checkbox',
	) );
	$wpc->add_control( 'show_preloader', array(
		'type'        => 'checkbox',
		'section'     => 'other',
		'label'       => esc_html__( 'Show animated pre-loader.', 'zermatt' ),
		'description' => esc_html__( 'The pre-loader is shown while a page loads, reducing the perceived loading time and showing the complete rendered page at once.', 'zermatt' ),
	) );



	//
	// site_tagline Section
	//
	$wpc->add_setting( 'logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( new WP_Customize_Image_Control( $wpc, 'logo', array(
		'section'     => 'title_tagline',
		'label'       => esc_html__( 'Logo', 'zermatt' ),
		'description' => esc_html__( 'If an image is selected, it will replace the default textual logo (site name) on the header.', 'zermatt' ),
	) ) );
}

add_action( 'customize_register', 'zermatt_customize_register_custom_controls', 9 );

/**
 * Registers custom Customizer controls.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function zermatt_customize_register_custom_controls( $wpc ) {
	require get_template_directory() . '/inc/customizer-controls/flexslider.php';
	require get_template_directory() . '/inc/customizer-controls/static-text.php';
}

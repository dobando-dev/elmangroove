<?php

/* Convert hexdec color string to rgb(a) string */
function zermatt_hex2rgba( $color, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if ( empty( $color ) ) {
		return $default;
	}

	//Sanitize $color if "#" is provided
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb = array_map( 'hexdec', $hex );

	//Check if opacity is set(rgba or rgb)
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ",", $rgb ) . ')';
	}

	//Return rgb(a) color string
	return $output;
}

add_action( 'wp_head', 'zermatt_customizer_css' );
if ( ! function_exists( 'zermatt_customizer_css' ) ):
function zermatt_customizer_css() {
	?><style type="text/css"><?php

	//
	// Header Colors
	//
	if ( get_theme_mod( 'header_nav_color') ) {
		?>
		.navigation > li ul a,
		.header .ci-dropdown-menu ul li a {
			color: <?php echo get_theme_mod( 'header_nav_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'header_text_color') ) {
		?>
		.header,
		.header a,
		.header .ci-dropdown-toggle,
		.header .btn,
		.page-title {
			color: <?php echo get_theme_mod( 'header_text_color' ); ?>;
		}

		.header .ci-dropdown-toggle,
		.header .btn,
		.header .ci-dropdown-menu ul,
		.navigation ul {
			border-color: <?php echo get_theme_mod( 'header_text_color' ); ?>;
		}

		.header .ci-dropdown-toggle:hover,
		.header .btn:hover,
		.header .btn:active,
		.header .btn:focus,
		.header .ci-dropdown-menu ul li a:hover,
		.header .ci-dropdown .sfHover > a,
		.header .ci-dropdown .sfHover > button,
		.header .ci-dropdown .current_page_item > a,
		.header .ci-dropdown .current-menu-item > a,
		.header .ci-dropdown .current-menu-ancestor > a,
		.header .ci-dropdown .current-menu-parent > a,
		.navigation > li ul a:hover,
		.navigation > li ul .sfHover > a {
			background-color: <?php echo get_theme_mod( 'header_text_color' ); ?>;
		}

		.header .ci-dropdown-menu ul li a,
		.navigation ul li a {
			background-color: <?php echo zermatt_hex2rgba( get_theme_mod( 'header_text_color' ), 0.5 ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'header_hover_color') ) {
		?>
		.header .ci-dropdown-toggle:hover,
		.header .btn:hover,
		.header .btn:active,
		.header .btn:focus,
		.header .ci-dropdown-menu ul li a:hover,
		.header .ci-dropdown .sfHover > a,
		.header .ci-dropdown .sfHover > button,
		.header .ci-dropdown .current_page_item > a,
		.header .ci-dropdown .current-menu-item > a,
		.header .ci-dropdown .current-menu-ancestor > a,
		.header .ci-dropdown .current-menu-parent > a,
		.navigation > li ul a:hover,
		.navigation > li ul .sfHover > a {
			color: <?php echo get_theme_mod( 'header_hover_color' ); ?>;
		}
		<?php
	}


	//
	// Global Colors
	//
	if ( get_theme_mod( 'global_primary_color' ) ) {
		?>
		a, a:hover,
		.item-title a:hover,
		.btn-white.btn-transparent:hover,
		.mobile-trigger:hover {
			color: <?php echo get_theme_mod( 'global_primary_color' ); ?>;
		}

		.ui-datepicker .ui-datepicker-header,
		.ui-datepicker .ui-datepicker-header .ui-state-hover,
		.ui-datepicker thead,
		.ui-datepicker td .ui-state-hover,
		.ui-datepicker td .ui-state-active,
		#paging .current,
		#paging a:hover,
		.room-slide-controls a:hover span,
		.booking-cta-inner,
		.item-tag {
			background-color: <?php echo get_theme_mod( 'global_primary_color' ); ?>;
		}

		.booking-form-inline input:focus,
		.room-slide-controls a:hover span {
			border-color: <?php echo get_theme_mod( 'global_primary_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'global_text_color' ) ) {
		?>
		body,
		option,
		.text-emphasiss a:hover,
		.room-slide-controls a span,
		#paging a:hover,
		#paging .current,
		.social-icon,
		.social-icon:hover,
		.widget-title,
		.entry-meta ,
		h1, h2, h3, h4, h5, h6{
			color: <?php echo get_theme_mod( 'global_text_color' ); ?>;
		}

		#paging a,
		#paging > span,
		#paging li span {
			background-color: <?php echo get_theme_mod( 'global_text_color' ); ?>;
		}

		input:focus,
		textarea:focus,
		.text-emphasis a,
		.entry-content blockquote:after,
		.social-icon {
			border-color: <?php echo get_theme_mod( 'global_text_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'global_link_color' ) ) {
		?>
		.entry-content a,
		.entry-content a:hover {
			color: <?php echo get_theme_mod( 'global_link_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'global_link_hover_color' ) ) {
		?>
		.entry-content a:hover {
			color: <?php echo get_theme_mod( 'global_link_hover_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'global_btn_text_color' ) ) {
		?>
		.btn,
		input[type="button"],
		input[type="submit"],
		input[type="reset"],
		button,
		.comment-reply-link {
			color: <?php echo get_theme_mod( 'global_btn_text_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'global_btn_bg_color' ) ) {
		?>
		.btn,
		input[type="button"],
		input[type="submit"],
		input[type="reset"],
		button,
		.comment-reply-link {
			background-color: <?php echo get_theme_mod( 'global_btn_bg_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'global_btn_hover_bg_color' ) ) {
		?>
		.btn:hover,
		input[type="button"]:hover,
		input[type="submit"]:hover,
		input[type="reset"]:hover,
		button:hover,
		.comment-reply-link:hover{
			background-color: <?php echo get_theme_mod( 'global_btn_hover_bg_color' ); ?>;

			<?php if ( get_theme_mod( 'global_btn_text_color' ) ) { ?>
				color: <?php echo get_theme_mod( 'global_btn_text_color' ); ?>
			<?php } ?>
		}
		<?php
	}

	if ( get_theme_mod( 'global_border_color' ) ) {
		?>
		.widget select,
		.room-slide-controls a span,
		.item-inset:hover:after,
		.justified-gallery > div:hover:after,
		.entry-thumb,
		main .ci-dropdown-menu > li ul,
		.ci-map-wrap,
		.booking-cta,
		.offer-cta {
			border-color: <?php echo get_theme_mod( 'global_border_color' ); ?>;
		}

		.page-title,
		.entry-navigation,
		.entry-rating {
			border-top-color: <?php echo get_theme_mod( 'global_border_color' ); ?>;
		}

		.widget_meta ul li a,
		.widget_pages ul li a,
		.widget_categories ul li a,
		.widget_archive ul li a,
		.widget_nav_menu ul li a,
		.widget_recent_entries ul li a,
		.widget_recent_comments ul li {
			border-bottom-color: <?php echo get_theme_mod( 'global_border_color' ); ?>;
		}
		<?php
	}

	//
	// Sidebar
	//
	if ( get_theme_mod( 'sidebar_bg_color' ) ) {
		?>
		.sidebar {
			padding: 15px;
			background-color: <?php echo get_theme_mod( 'sidebar_bg_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'sidebar_text_color' ) ) {
		?>
		.sidebar {
			color: <?php echo get_theme_mod( 'sidebar_text_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'sidebar_link_color' ) ) {
		?>
		.sidebar a,
		.sidebar a:hover {
			color: <?php echo get_theme_mod( 'sidebar_link_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'sidebar_hover_color' ) ) {
		?>
		.sidebar a:hover {
			color: <?php echo get_theme_mod( 'sidebar_hover_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'sidebar_title_color' ) ) {
		?>
		.sidebar .widget-title {
			color: <?php echo get_theme_mod( 'sidebar_title_color' ); ?>;
		}
		<?php
	}

	if ( get_theme_mod( 'sidebar_border_color' ) ) {
		?>
		.widget_meta ul li a,
		.widget_pages ul li a,
		.widget_categories ul li a,
		.widget_archive ul li a,
		.widget_nav_menu ul li a,
		.widget_recent_entries ul li a,
		.widget_recent_comments ul li {
			border-bottom-color: <?php echo get_theme_mod( 'sidebar_border_color' ); ?>;
		}
		<?php
	}

	//
	// Typography
	//
	if ( get_theme_mod( 'h1_size' ) ) {
		?>
		h1:not(.site-logo) {
			font-size: <?php echo get_theme_mod( 'h1_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'h2_size' ) ) {
		?>
		h2 {
			font-size: <?php echo get_theme_mod( 'h2_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'h3_size' ) ) {
		?>
		h3 {
			font-size: <?php echo get_theme_mod( 'h3_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'h4_size' ) ) {
		?>
		h4 {
			font-size: <?php echo get_theme_mod( 'h4_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'h5_size' ) ) {
		?>
		h5 {
			font-size: <?php echo get_theme_mod( 'h5_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'h6_size' ) ) {
		?>
		h6 {
			font-size: <?php echo get_theme_mod( 'h6_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'body_text_size' ) ) {
		?>
		body,
		.entry-content {
			font-size: <?php echo get_theme_mod( 'body_text_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'widgets_text_size' ) ) {
		?>
		.sidebar .widget {
			font-size: <?php echo get_theme_mod( 'widgets_text_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'widgets_title_size' ) ) {
		?>
		.sidebar .widget-title {
			font-size: <?php echo get_theme_mod( 'widgets_title_size' ); ?>px;
		}
		<?php
	}

	if ( get_theme_mod( 'lowercase_widget_titles' ) ) {
		?>
		.sidebar .widget-title,
		.section-title,
		.slide-title {
			text-transform: none;
		}
		<?php
	}

	if ( get_theme_mod( 'lowercase_content_headings' ) ) {
		?>
		.entry-content h1,
		.entry-content h2,
		.entry-content h3,
		.entry-content h4,
		.entry-content h5,
		.entry-content h6 {
			text-transform: none;
		}
		<?php
	}

	if ( get_theme_mod( 'custom_css' ) ) {
		echo get_theme_mod( 'custom_css' );
	}
	?></style><?php
}
endif;
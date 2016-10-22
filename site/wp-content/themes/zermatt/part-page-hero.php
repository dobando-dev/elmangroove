<?php
	$title = '';
	if ( is_archive() ) {
		$title = get_the_archive_title();
	} elseif ( is_singular( 'post' ) ) {
		$title = esc_html__( 'From the blog', 'zermatt' );
	} elseif ( is_page_template( 'template-frontpage.php' ) ) {
		$title = '';
	} elseif ( is_singular() ) {
		$title = single_post_title( '', false );
	} elseif ( is_404() ) {
		$title = esc_html__( 'Page not found', 'zermatt' );
	} elseif ( is_search() ) {
		$title = esc_html__( 'Search results', 'zermatt' );
	} else {
		$title = esc_html__( 'From the blog', 'zermatt' );
	}

	$subtitle = '';
	$image_id = false;
	if ( is_singular() ) {
		$subtitle = get_post_meta( get_queried_object_id(), 'subtitle', true );
		$image_id = get_post_meta( get_queried_object_id(), 'header_image_id', true );
	}

	$hero_style = '';

	$bg_color = get_theme_mod( 'header_bg_color', '#252525' );
	if ( ! empty( $bg_color ) ) {
		$hero_style .= sprintf( 'background-color: %s;',
			$bg_color
		);
	}

	$image_url         = get_header_image();
	$custom_image_url  = zermatt_get_image_src( $image_id, 'zermatt_hero' );

	if ( ! empty( $custom_image_url ) ) {
		$image_url = $custom_image_url;
	}

	if ( ! empty( $image_url ) ) {
		$hero_style .= sprintf( 'background-image: url(%s);',
			esc_url( $image_url )
		);
	}
?>
<div class="hero-wrap">
	<div class="page-hero" style="<?php echo esc_attr( $hero_style ); ?>">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="page-title"><?php echo $title; ?></h2>

					<?php if ( ! empty( $subtitle ) ): ?>
						<p class="page-subtitle"><?php echo $subtitle; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
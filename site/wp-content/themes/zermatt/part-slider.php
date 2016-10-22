<?php
	$layout = get_post_meta( get_queried_object_id(), 'front_layout', true );

	$attributes = sprintf( 'data-slideshow="%s" data-slideshowspeed="%s" data-animationspeed="%s"',
		esc_attr( get_theme_mod( 'home_slider_slideshow', 1 ) ),
		esc_attr( get_theme_mod( 'home_slider_slideshowSpeed', 3000 ) ),
		esc_attr( get_theme_mod( 'home_slider_animationSpeed', 600 ) )
	);

	if ( is_page() ) {
		$q = zermatt_get_slides( false, get_queried_object_id() );
	} else {
		$q = zermatt_get_slides();
	}
?>

<?php if ( $q->have_posts() ): ?>
	<div class="hero-wrap <?php echo esc_attr( $layout ); ?>">
		<div class="home-slider ci-slider loading" <?php echo $attributes; ?>>

			<ul class="slides">
				<?php while ( $q->have_posts() ) : $q->the_post(); ?>

					<?php
						$text_off    = get_post_meta( get_the_ID(), 'zermatt_slide_text_off', true );
						$url         = get_post_meta( get_the_ID(), 'zermatt_slide_button_url', true );
						$subtitle    = get_post_meta( get_the_ID(), 'zermatt_slide_subtitle', true );
						$button_text = get_post_meta( get_the_ID(), 'zermatt_slide_button_text', true );
						$img         = zermatt_get_image_src( get_post_thumbnail_id(), 'zermatt_slider' );
						$video_url   = get_post_meta( get_the_ID(), 'zermatt_slide_video_url', true );
						$video_data  = zermatt_sanitize_video_url_embed_code( $video_url );
					?>

					<li style="background-image: url(<?php echo esc_url( $img ); ?>)">
						<?php if ( ! wp_is_mobile() ) : ?>
							<?php if ( ! empty( $video_url ) && ! empty( $video_data['type'] ) ) : ?>
								<div class="slide-video-wrap">
									<?php if ( 'iframe' == $video_data['type'] ): ?>
										<?php echo $video_data['content']; ?>
									<?php elseif ( 'fileurl' == $video_data['type'] ): ?>
										<video autoplay muted preload loop>
											<source src="<?php echo esc_url( $video_data['content'] ); ?>" type="video/mp4">
										</video>
									<?php
									elseif ( 'url' == $video_data['type'] ): ?>
										<?php echo wp_oembed_get( $video_data['content'] ); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( ! $text_off ) : ?>
							<div class="slide-content">
								<div class="container">
									<div class="row">
										<div class="col-xs-12">
											<p class="slide-title"><?php the_title(); ?></p>

											<?php if ( ! empty( $subtitle ) ) : ?>
												<p class="slide-subtitle"><?php echo esc_html( $subtitle ); ?></p>
											<?php endif; ?>

											<?php if ( ! empty( $url ) ) : ?>
												<a href="<?php echo esc_url( $url ); ?>"
												   class="btn btn-white btn-transparent"><?php echo esc_html( $button_text ); ?></a>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</li>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</ul>
		</div>

		<?php if ( $layout !== 'fullscreen' ) : ?>
		<a href="#main" class="main-content-scroll content-scroll">
			<i class="fa fa-angle-down"></i>
		</a>
		<?php endif; ?>
	</div>
<?php endif; ?>
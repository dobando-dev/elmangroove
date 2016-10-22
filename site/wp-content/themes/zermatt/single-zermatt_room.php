<?php get_header(); ?>

<main class="main">

	<?php if ( get_theme_mod( 'single_room_random_testimonial', 1 ) ) {
		get_template_part( 'part', 'random-testimonial' );
	} ?>

	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<article class="entry">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php $gallery = zermatt_featgal_get_attachments(); ?>
						<?php if ( $gallery->have_posts() ) : ?>
							<figure class="entry-thumb">
								<div class="ci-slider room-slider">
									<ul class="slides ci-lightbox-gallery">
										<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
											<?php $details = wp_prepare_attachment_for_js( get_the_ID() ); ?>
											<li>
												<a href="<?php echo esc_url( zermatt_get_image_src( get_the_ID(), 'large' ) ); ?>" title="<?php echo esc_attr( $details['caption'] ); ?>">
													<img
														src="<?php echo esc_url( zermatt_get_image_src( get_the_ID(), 'zermatt_fullwidth' ) ); ?>"
														alt="<?php echo esc_attr( $details['alt'] ); ?>"/>
												</a>
											</li>
										<?php endwhile; ?>
										<?php wp_reset_postdata(); ?>
									</ul>

									<div class="room-slide-controls">
										<a href="#" class="room-slide-prev">
											<div class="room-slide-img">
												<img src="" alt="">
											</div>
											<span><i class="fa fa-angle-left"></i></span>
										</a>
										<a href="#" class="room-slide-next">
											<div class="room-slide-img">
												<img src="" alt="">
											</div>
											<span><i class="fa fa-angle-right"></i></span>
										</a>
									</div>
								</div>
							</figure>
						<?php endif; ?>
					<?php endwhile; ?>

					<?php rewind_posts(); ?>

					<div class="row">
						<?php
							$show_sidebar = get_post_meta( get_queried_object_id(), 'show_sidebar', true );
							$col_class = 'col-xs-12';
							if( 1 == $show_sidebar ) {
								$col_class = 'col-md-8';
							}
						?>
						<div class="<?php echo esc_attr( $col_class ); ?>">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="entry-content">
									<?php
										$amenities       = get_post_meta( get_the_ID(), 'amenities', true );
										$amenities_title = get_post_meta( get_the_ID(), 'amenities_title', true );
									?>

									<?php if ( ! empty( $amenities ) ): ?>
										<?php if ( ! empty( $amenities_title ) ): ?>
											<h3><?php echo $amenities_title; ?></h3>
										<?php endif; ?>
										<ul class="list-amenities">
											<?php foreach ( $amenities as $amenity ): ?>
												<li><?php echo $amenity['title']; ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>

									<?php the_content(); ?>
									<?php wp_link_pages(); ?>
								</div>
							<?php endwhile; ?>
						</div>

						<?php if ( 1 == $show_sidebar ): ?>
							<div class="col-md-4">
								<?php get_sidebar(); ?>
							</div>
						<?php endif; ?>
					</div>
				</article>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>

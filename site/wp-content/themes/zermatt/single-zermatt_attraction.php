<?php get_header(); ?>

<main class="main">
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
						<div class="col-md-8">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="entry-content">
									<?php the_content(); ?>
									<?php wp_link_pages(); ?>
								</div>
							<?php endwhile; ?>
						</div>

						<div class="col-md-4">
							<?php get_sidebar(); ?>
						</div>
					</div>

				</article>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>

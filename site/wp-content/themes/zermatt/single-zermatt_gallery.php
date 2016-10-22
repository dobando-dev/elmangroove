<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php global $post; ?>
					<?php if ( $post->post_content ) : ?>
						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>
					<?php endif; ?>

					<?php $gallery = zermatt_featgal_get_attachments(); ?>
					<?php if ( $gallery->have_posts() ) : ?>
						<div class="justified-gallery ci-lightbox-gallery" data-height="300">
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
					<?php endif; ?>

				<?php endwhile; ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
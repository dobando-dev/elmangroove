<?php
/*
* Template Name: Page with gallery
*/
?>

<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

						<?php $gallery = zermatt_featgal_get_attachments(); ?>
						<?php if ( $gallery->have_posts() ) : ?>
							<div class="justified-gallery ci-lightbox-gallery" data-height="140">
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
						<?php elseif ( has_post_thumbnail() ): ?>
							<figure class="entry-thumb">
								<a class="ci-lightbox" href="<?php echo esc_url( zermatt_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>">
									<?php the_post_thumbnail(); ?>
								</a>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>
					</article>

					<?php comments_template(); ?>
				<?php endwhile; ?>
			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
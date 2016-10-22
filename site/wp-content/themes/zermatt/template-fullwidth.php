<?php
/**
 * Template Name: Fullwidth Page
 */
?>

<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<?php if ( has_post_thumbnail() ): ?>
							<figure class="entry-thumb">
								<a class="ci-lightbox" href="<?php echo esc_url( zermatt_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>">
									<?php the_post_thumbnail( 'zermatt_fullwidth' ); ?>
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
		</div>
	</div>
</main>

<?php get_footer(); ?>
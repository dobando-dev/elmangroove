<?php
/**
 * Template Name: Videos Listing
 */
?>
<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<main class="main">
		<div class="container">
			<div class="row">

				<?php $post = get_post(); ?>
				<?php if ( ! empty( $post->post_content ) ) : ?>
					<div class="col-xs-12">
						<div class="row">
							<div class="col-xs-12">
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
									<div class="entry-content">
										<?php the_content(); ?>
									</div>
								</article>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php
					$cpt_taxonomy   = 'zermatt_video_category';
					$base_category  = get_post_meta( get_the_ID(), 'video_listing_base_category', true );
					$columns        = get_post_meta( get_the_ID(), 'video_listing_columns', true );
					$posts_per_page = get_post_meta( get_the_ID(), 'video_listing_posts_per_page', true );
					$column_classes = zermatt_get_columns_classes( $columns );

					$args = array(
						'post_type' => 'zermatt_video',
						'paged'     => zermatt_get_page_var(),
					);

					if ( $posts_per_page >= 1 ) {
						$args['posts_per_page'] = $posts_per_page;
					} elseif ( $posts_per_page <= - 1 ) {
						$args['posts_per_page'] = - 1;
					} else {
						$args['posts_per_page'] = get_option( 'posts_per_page' );
					}

					if ( ! empty( $base_category ) and $base_category >= 1 ) {
						$args['tax_query'] = array(
							array(
								'taxonomy'         => $cpt_taxonomy,
								'field'            => 'term_id',
								'terms'            => intval( $base_category ),
								'include_children' => true
							)
						);
					}

					$q = new WP_Query( $args );
				?>

				<?php if ( $q->have_posts() ): ?>
					<div class="col-xs-12">
						<div class="row row-items">

							<?php while ( $q->have_posts() ): $q->the_post(); ?>
								<?php $video_url = get_post_meta( get_the_ID(), 'zermatt_video_url', true ); ?>
								<?php if ( ! empty( $video_url ) ): ?>
									<div class="<?php echo esc_attr( $column_classes ); ?>">
										<div class="item item-inset item-inset-featured">
											<?php echo wp_oembed_get( esc_url( $video_url ) ); ?>
										</div>
									</div>
								<?php endif; ?>
							<?php endwhile; ?>

						</div>

						<?php zermatt_pagination( array(), $q ); ?>

					</div>
				<?php endif; ?>
			</div>
		</div>
	</main>
<?php endwhile; ?>

<?php get_footer(); ?>
<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="row row-items">

					<?php
						global $wp_query;
						$taxonomy  = get_query_var( 'taxonomy' );
						$term_name = get_query_var( 'term' );
						$term_id   = get_queried_object_id();

						$columns    = apply_filters( 'zermatt_taxonomy_archive_columns', 2, $taxonomy, $term_name, $term_id );
						$first_full = apply_filters( 'zermatt_taxonomy_archive_first_full', true, $taxonomy, $term_name, $term_id );

						$column_classes = zermatt_get_columns_classes( $columns );
					?>
					<?php while ( have_posts() ): the_post(); ?>
						<?php
							$template = 'item';
							$classes  = $column_classes;

							if ( $wp_query->current_post == 0 && $first_full ) {
								$template = 'item-full';
								$classes  = zermatt_get_columns_classes( 1 );
							}
						?>
						<div class="<?php echo esc_attr( $classes ); ?>">
							<?php get_template_part( $template, get_post_type() ); ?>
						</div>
					<?php endwhile; ?>

				</div>

				<?php zermatt_pagination(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
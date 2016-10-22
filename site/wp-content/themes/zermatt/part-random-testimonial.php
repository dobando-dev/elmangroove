<?php
	$args = array(
		'post_type'      => 'zermatt_testimonial',
		'posts_per_page' => 1,
		'order_by'       => 'rand'
	);

	$testimonial = new WP_Query( $args );
?>
<?php while ( $testimonial->have_posts() ) : $testimonial->the_post(); ?>
	<section class="widget widget_ci-testimonial widget_ci-testimonial-inset">
		<div class="widget-wrap">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">

						<?php if ( get_theme_mod( 'single_room_testimonial_title', esc_html__( 'What they say about us', 'zermatt' ) ) ): ?>
							<h3 class="section-title"><?php echo get_theme_mod( 'single_room_testimonial_title', esc_html__( 'What they say about us', 'zermatt' ) ); ?></h3>
						<?php endif; ?>
						<blockquote class="ci-testimonial">
							<div class="text-center text-emphasis text-lg">
								<?php the_content(); ?>
							</div>
							<cite><?php the_title(); ?></cite>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endwhile; ?>
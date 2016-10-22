<?php
/*
* Template Name: Contact Page
*/
?>

<?php get_header(); ?>

<main class="main">
	<div class="container">
		<?php
			$map_lon  = get_post_meta( get_queried_object_id(), 'contact_map_lon', true );
			$map_lat  = get_post_meta( get_queried_object_id(), 'contact_map_lat', true );
			$map_zoom = get_post_meta( get_queried_object_id(), 'contact_map_zoom', true );
			$map_tip  = get_post_meta( get_queried_object_id(), 'contact_map_tooltip', true );
		?>
		<?php if ( ! empty( $map_lat ) && ! empty( $map_lon ) ): ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="ci-map-wrap">
						<div id="ci-map-<?php the_ID(); ?>" class="ci-map" data-lat="<?php echo esc_attr( $map_lat ); ?>" data-lng="<?php echo esc_attr( $map_lon ); ?>" data-zoom="<?php echo esc_attr( $map_zoom ); ?>" data-tooltip-txt="<?php echo esc_attr( $map_tip ); ?>" title="<?php the_title_attribute(); ?>"></div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-8">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="col-md-4">
				<div class="sidebar">
					<?php dynamic_sidebar( 'contact-form' ); ?>
				</div>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>

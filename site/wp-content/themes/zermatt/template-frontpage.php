<?php
/**
* Template Name: Frontpage
*/
?>

<?php get_header(); ?>

<?php $layout = ''; ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php
		$layout = get_post_meta( get_the_ID(), 'front_layout', true );
		get_template_part( 'part', 'slider' );
	?>
	<?php if ( $layout != 'fullscreen' ) : ?>
		<main id="main" class="main main-sections">
			<?php dynamic_sidebar( 'frontpage' ); ?>
		</main>
	<?php endif; ?>

<?php endwhile; ?>

<?php
	if ( $layout == 'fullscreen' ) {
		get_footer( 'fullscreen' );
	} else {
		get_footer();
	}
?>

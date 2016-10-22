<?php global $wp_query; ?>
<?php if ( have_posts() ): ?>
	<div class="layout-grid">
		<div class="box box-tall">
			<?php the_post(); ?>
			<?php get_template_part( 'item-wide', get_post_type() ); ?>

			<?php if ( have_posts() ): ?>
				<?php the_post(); ?>
				<?php get_template_part( 'item-wide', get_post_type() ); ?>
			<?php endif; ?>
		</div>
		<div class="box box-tall">
			<?php
			//
			// This $wp_query->current_post != -1 check is needed for cases when only 1 or 2 posts exist.
			// Due to the way have_posts() operates, the query rewinds and the same (first) post gets displayed again.
			//
			?>
			<?php if ( have_posts() && $wp_query->current_post != -1 ): ?>
				<?php the_post(); ?>
				<?php get_template_part( 'item', get_post_type() ); ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

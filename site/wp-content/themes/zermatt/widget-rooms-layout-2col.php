<?php if ( have_posts() ): ?>
	<div class="row row-items">
		<?php while ( have_posts() ): the_post(); ?>
			<div class="col-sm-6">
				<?php get_template_part( 'item', get_post_type() ); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif; ?>

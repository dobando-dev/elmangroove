<?php if ( have_posts() ): ?>
	<div class="layout-grid">
		<div class="box box-tall">
			<?php the_post(); ?>
			<?php get_template_part( 'item', get_post_type() ); ?>
		</div>

		<?php if ( have_posts() ): ?>
			<div class="box box-tall">
				<?php the_post(); ?>
				<?php get_template_part( 'item-wide', get_post_type() ); ?>

				<?php if ( have_posts() ): ?>
					<?php the_post(); ?>
					<?php get_template_part( 'item-wide', get_post_type() ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>

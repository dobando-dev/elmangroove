<div class="item item-inset item-inset-featured">

	<?php the_post_thumbnail( 'zermatt_item' ); ?>

	<div class="item-inset-inner">
		<div class="item-inset-content">
			<h3><?php the_title(); ?></h3>

			<?php $subtitle = get_post_meta( get_the_ID(), 'subtitle', true ); ?>
			<?php if ( ! empty( $subtitle ) ): ?>
				<p class="text-styled">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="btn btn-white btn-transparent">
				<?php echo esc_html_x( 'View More', 'attraction button', 'zermatt' ); ?>
			</a>
		</div>
	</div>
</div>

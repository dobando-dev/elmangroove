<div class="item item-inset item-inset-featured">
	<?php $offer = get_post_meta( get_the_ID(), 'on_offer', true ); ?>
	<?php if ( $offer ): ?>
		<div class="item-tag-wrap">
			<span class="item-tag"><?php esc_html_e( 'Special Offer', 'zermatt' ); ?></span>
		</div>
	<?php endif; ?>

	<?php the_post_thumbnail( 'zermatt_item' ); ?>

	<div class="item-inset-inner">
		<div class="item-inset-content">
			<h3><?php the_title(); ?></h3>

			<?php $price = get_post_meta( get_the_ID(), 'price', true ); ?>
			<?php if ( ! empty( $price ) ): ?>
				<p class="text-styled">
					<?php
						/* translators: :price: is a placeholder. Do not translate into your language.  */
						$text = get_theme_mod( 'room_price_text', esc_html__( 'From :price: / Night', 'zermatt' ) );
						$text = str_replace( ':price:', $price, $text );
						echo esc_html( $text );
					?>
				</p>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="btn btn-white btn-transparent">
				<?php echo esc_html_x( 'Learn More', 'room button', 'zermatt' ); ?>
			</a>
		</div>
	</div>
</div>

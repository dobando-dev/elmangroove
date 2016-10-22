<div class="item">
	<?php if ( has_post_thumbnail() ): ?>
		<figure class="item-thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
		</figure>
	<?php endif; ?>

	<div class="item-content">
		<p class="item-title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</p>

		<?php
			global $post;
			$max_chars = apply_filters( 'zermatt_item_excerpt_max_characters', 200, get_the_ID() );
			$text      = zermatt_excerpt_trip_characters( $max_chars, $post->post_excerpt, get_the_content( '' ) );

			echo apply_filters( 'the_excerpt', $text );
		?>
	</div>
</div>

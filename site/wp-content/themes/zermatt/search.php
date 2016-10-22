<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-8">

				<article class="entry">
					<?php
						global $wp_query;

						$found = $wp_query->found_posts;
						$none  = esc_html__( 'No results found. Please broaden your terms and search again.', 'zermatt' );
						$one   = esc_html__( 'Just one result found. We either nailed it, or you might want to broaden your terms and search again.', 'zermatt' );
						$many  = esc_html( sprintf( _n( '%d result found.', '%d results found.', $found, 'zermatt' ), $found ) );
					?>
					<div class="entry-content">
						<p><?php zermatt_e_inflect( $found, $none, $one, $many ); ?></p>
						<?php if ( $found < 2 ) {
							get_search_form();
						} ?>
					</div>
				</article>

				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

						<?php if ( 'post' == get_post_type() ): ?>
							<div class="entry-meta">
								<time class="entry-time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
								&bull;
								<span class="entry-categories"><?php the_category( ', ' ); ?></span>
							</div>
						<?php endif; ?>

						<?php if ( has_post_thumbnail() ): ?>
							<figure class="entry-thumb">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div>
						<a href="<?php the_permalink(); ?>" class="entry-read-more btn">
							<?php echo esc_html_x( 'Read More', 'post button', 'zermatt' ); ?>
						</a>
					</article>
				<?php endwhile; ?>

				<?php zermatt_pagination(); ?>
			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
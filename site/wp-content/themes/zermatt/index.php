<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

						<div class="entry-meta">
							<time class="entry-time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
							&bull;
							<span class="entry-categories"><?php the_category( ', ' ); ?></span>
						</div>

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
<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<article class="entry">
					<div class="entry-content">
						<p><?php esc_html_e( 'The page you were looking for can not be found! Perhaps try searching?', 'zermatt' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				</article>
			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
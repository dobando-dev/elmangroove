	<?php if ( is_active_sidebar( 'prefoot' ) && ! is_page_template( 'template-frontpage.php' ) ) : ?>
		<div class="sections-inner">
			<?php dynamic_sidebar( 'prefoot' ); ?>
		</div>
	<?php endif; ?>

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<p>
						<?php echo get_theme_mod( 'footer_text', zermatt_get_default_footer_text() ); ?>
					</p>
				</div>
				<div class="col-sm-6 text-right">
					<p>
						<?php echo get_theme_mod( 'footer_text_right', zermatt_get_default_footer_text_right() ); ?>
					</p>
				</div>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
<?php
	$networks = zermatt_get_social_networks();
	$user     = array();
	$global   = array();
	$used     = array();
	$has_rss  = get_theme_mod( 'rss_feed', get_bloginfo( 'rss2_url' ) ) ? true : false;

	foreach ( $networks as $network ) {
		if ( get_theme_mod( 'social_' . $network['name'] ) ) {
			$global[ $network['name'] ] = get_theme_mod( 'social_' . $network['name'] );
		}
	}

	$used = $global;

	if ( ( in_the_loop() && count( $used ) > 0 ) || ( ! in_the_loop() && ( count( $used ) > 0 || $has_rss ) ) ) {
		?>
		<ul class="social-icons">
			<?php
				foreach ( $networks as $network ) {
					if ( ! empty( $used[ $network['name'] ] ) ) {
						echo sprintf( '<li><a target="_blank" href="%s" class="social-icon"><i class="fa %s"></i></a></li>',
							esc_url( $used[ $network['name'] ] ),
							esc_attr( $network['icon'] )
						);
					}
				}
			?>
			<?php if( ! in_the_loop() && $has_rss ): ?>
				<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'rss_feed', get_bloginfo( 'rss2_url' ) ) ); ?>" class="social-icon"><i class="fa fa-rss"></i></a></li>
			<?php endif; ?>
		</ul>
		<?php
	}

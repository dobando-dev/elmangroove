<?php
	$multilang    = false;
	$current_lang = '';
	$langlist     = array();

	if ( function_exists( 'icl_get_languages' ) || ( function_exists( 'pll_the_languages' ) ) ) {
		$multilang = true;
	}

	if ( class_exists( 'Polylang' ) && function_exists( 'pll_current_language' ) ) {
		$current_lang = pll_current_language();
		$languages    = pll_the_languages( array(
			'hide_if_empty' => true,
			'hide_current'  => true,
			'raw'           => true,
		) );

		foreach ( $languages as $key => $value ) {
			$lang_list[] = sprintf( '<li><a href="%s">%s</a></li>',
				esc_url( $value['url'] ),
				$value['slug']
			);
		}

	} elseif ( class_exists( 'SitePress' ) ) {
		$current_lang = apply_filters( 'wpml_current_language', null );
		$languages    = apply_filters( 'wpml_active_languages', null, array(
			'skip_missing' => false,
		) );

		foreach ( $languages as $key => $value ) {
			if ( $current_lang != $value['language_code'] ) {
				$lang_list[] = sprintf( '<li><a href="%s">%s</a></li>',
					esc_url( $value['url'] ),
					$value['language_code']
				);
			}
		}
	}

	if ( ! empty( $lang_list ) ) {
		?>
		<div class="ci-dropdown ci-dropdown-left ci-dropdown-language">
			<ul class="ci-dropdown-menu">
				<li>
					<button class="ci-dropdown-toggle" type="button">
						<?php echo $current_lang; ?>
					</button>
					<ul>
						<?php echo implode( '', $lang_list ); ?>
					</ul>
				</li>
			</ul>
		</div><!-- .ci-dropdown-language -->
		<?php
	}

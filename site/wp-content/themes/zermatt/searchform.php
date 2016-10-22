<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get" role="search">
	<div>
		<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'zermatt' ); ?></label>
		<input type="text" placeholder="<?php echo esc_attr_x( 'Search', 'search box placeholder', 'zermatt' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
		<button class="searchsubmit" type="submit"><i class="fa fa-search"></i><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'zermatt' ); ?></span></button>
	</div>
</form>
<div class="sidebar">
	<?php
		if ( is_page() ) {
			dynamic_sidebar( 'page' );
		} elseif ( is_singular( 'zermatt_room' ) ) {
			dynamic_sidebar( 'room' );
		} elseif ( is_singular( 'zermatt_attraction' ) ) {
			dynamic_sidebar( 'attraction' );
		} elseif ( is_singular( 'zermatt_service' ) ) {
			dynamic_sidebar( 'service' );
		} else {
			dynamic_sidebar( 'blog' );
		}
	?>
</div>

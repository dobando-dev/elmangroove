<?php
	$woeid = get_theme_mod( 'header_weather_woeid', '784766' );
	$unit  = get_theme_mod( 'header_weather_unit', 'c' );
?>
<?php if ( ! empty( $woeid ) && ! empty( $unit ) ): ?>
	<div class="resort-info">
		<div class="resort-weather">
			<span class="resort-temperature"></span>
			<i class="wi"></i>
		</div>
		<div class="resort-location">
			<span class="resort-town"></span>
			<span class="resort-country"></span>
		</div>
	</div>
<?php endif; ?>

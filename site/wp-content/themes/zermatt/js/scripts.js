jQuery(function($) {
	'use strict';

	/* -----------------------------------------
	 Responsive Menus Init with mmenu
	 ----------------------------------------- */
	var $mainNav = $('.nav-clone');
	var $mobileNav = $('#mobilemenu');

	$mainNav.clone().removeAttr('id').removeClass().appendTo($mobileNav);
	$mobileNav.find('li').removeAttr('id');

	$mobileNav.mmenu({
		offCanvas: {
			position: 'top',
			zposition: 'front'
		},
		"autoHeight": true,
		"navbars": [
			{
				"position": "top",
				"content": [
					"prev",
					"title",
					"close"
				]
			}
		]
	});

	/* -----------------------------------------
	 Main Navigation Init
	 ----------------------------------------- */
	$mainNav.superfish({
		delay: 300,
		animation: {opacity: 'show', height: 'show'},
		speed: 'fast',
		dropShadows: false
	});

	$('.ci-dropdown-menu').superfish({
		delay: 150,
		animation: {opacity: 'show', height: 'show'},
		speed: 'fast',
		dropShadows: false
	});

	/* -----------------------------------------
	 Smooth scroll to content
	 ----------------------------------------- */
	$(".content-scroll").click(function(e) {
		e.preventDefault();
		$('html, body').animate({scrollTop: $(this.hash).offset().top - 60 }, 500);
	});

	/* -----------------------------------------
	 Responsive Videos with fitVids
	 ----------------------------------------- */
	$('main').fitVids();

	/* -----------------------------------------
	 Image Lightbox
	 ----------------------------------------- */
	var $lightbox = $(".ci-lightbox, .entry-content a[rel~='attachment']");
	var $lighboxGallery = $('.ci-lightbox-gallery, .entry-content .gallery');


	if ( $lightbox.length ) {
		$lightbox.magnificPopup({
			type: 'image',
			mainClass: 'mfp-with-zoom',
			gallery: {
				enabled: true
			},
			zoom: {
				enabled: true
			}
		});
	}

	if ( $lighboxGallery.length ) {
		$lighboxGallery.each(function() {
			$(this).magnificPopup({
				type: 'image',
				delegate: 'a',
				mainClass: 'mfp-with-zoom',
				gallery: {
					enabled: true
				},
				zoom: {
					enabled: true
				}
			});
		});
	}


	/* -----------------------------------------
	 Datepickers
	 ----------------------------------------- */
	// Makes sure arrival date is not after departure date, and vice versa.
	var $depart = $('#depart');
	var $arrive = $('#arrive');

	$arrive.datepicker({
		showOn: 'both',
		buttonText: '<i class="fa fa-calendar"></i>',
		dateFormat: 'yy/mm/dd',
		minDate: new Date(),
		onSelect: function(dateText, dateObj) {
			var minDate = new Date(dateObj.selectedYear, dateObj.selectedMonth, dateObj.selectedDay);
			minDate.setDate(minDate.getDate() + 1);
			$depart.datepicker("option", "minDate", minDate);
		}
	});

	$depart.datepicker({
		showOn: 'both',
		buttonText: '<i class="fa fa-calendar"></i>',
		dateFormat: 'yy/mm/dd',
		minDate: new Date(),
		onSelect: function(dateText, dateObj) {
			var maxDate = new Date(dateObj.selectedYear, dateObj.selectedMonth, dateObj.selectedDay);
			maxDate.setDate(maxDate.getDate() - 1);
			$arrive.datepicker("option", "maxDate", maxDate);
		}
	});

	/* -----------------------------------------
	 Map Init
	 ----------------------------------------- */
	var mapStyle = [
		{
			"featureType": "administrative",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#444444"
				}
			]
		},
		{
			"featureType": "landscape",
			"elementType": "all",
			"stylers": [
				{
					"color": "#f2f2f2"
				}
			]
		},
		{
			"featureType": "landscape.natural.landcover",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "on"
				}
			]
		},
		{
			"featureType": "landscape.natural.landcover",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"visibility": "on"
				},
				{
					"saturation": "27"
				},
				{
					"lightness": "-4"
				}
			]
		},
		{
			"featureType": "landscape.natural.terrain",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "on"
				},
				{
					"lightness": "44"
				},
				{
					"gamma": "1.22"
				},
				{
					"weight": "1.73"
				}
			]
		},
		{
			"featureType": "poi",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "poi.attraction",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "on"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "all",
			"stylers": [
				{
					"saturation": - 100
				},
				{
					"lightness": 45
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "simplified"
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"hue": "#ff0000"
				}
			]
		},
		{
			"featureType": "road.highway.controlled_access",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "on"
				}
			]
		},
		{
			"featureType": "road.arterial",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "on"
				},
				{
					"saturation": "-9"
				},
				{
					"color": "#ba5252"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "all",
			"stylers": [
				{
					"color": "#b4e6fb"
				},
				{
					"visibility": "on"
				}
			]
		}
	];

	function map_init(lat, lng, zoom, tipText, titleText, map_id) {
		if ( typeof google === 'object' && typeof google.maps === 'object' ) {
			var myLatlng = new google.maps.LatLng(lat, lng);
			var mapOptions = {
				styles: mapStyle,
				zoom: zoom,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			var map = new google.maps.Map(document.getElementById(map_id), mapOptions);

			var contentString = tipText ? '<div class="tip-content">' + tipText + '</div>' : '';

			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: titleText || ''
			});

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
			});
		}
	}

	var $cmap = $(".ci-map");
	if ( $cmap.length ) {
		$cmap.each(function() {
			var that = $(this),
				lat = that.data('lat'),
				lng = that.data('lng'),
				zoom = that.data('zoom'),
				tipText = that.data('tooltip-txt'),
				titleText = that.attr('title'),
				mapid = that.attr('id');

			map_init(lat, lng, zoom, tipText, titleText, mapid);
		})
	}


	/* -----------------------------------------
	Weather Code
	----------------------------------------- */
	var $weather = $( '.resort-weather' );

	function getWeatherData() {
		return $.ajax({
			url: zermatt_vars.ajaxurl,
			data: {
				action: 'zermatt_get_weather_conditions',
				weather_nonce: zermatt_vars.weather_nonce
			},
			dataType: 'json',
			cache: false
		});
	}

	if ( $weather.length ) {
		var weatherData = getWeatherData();

		weatherData.done( function( res ) {
			if ( res.error ) {
				if ( res.errors && res.errors.length ) {
					res.errors.forEach( function(error) {
						console.warn( error );
					} );
				}
				return false;
			}

			var data = res.data.query.results.channel;

			if ( ! data.item || ! data.location ) {
				return false;
			}

			var info    = data.item.condition;
			var city    = data.location.city;
			var country = data.location.country;
			var unit    = data.units.temperature;

			$( '.wi' ).addClass( 'wi-yahoo-' + info['code'] );
			$( '.resort-town' ).html( city ) ;
			$( '.resort-country' ).html( country );
			$( '.resort-temperature' ).html( info.temp + '<span>' + '&deg;' + ( unit.toUpperCase() ) + '</span>' );
		});
	}


	/* -----------------------------------------
	 Instagram Widget
	 ----------------------------------------- */
	var $instagramWidget = $('section').find('.instagram-pics');
	var $instagramWrap = $instagramWidget.parent('div');

	if ( $instagramWidget.length ) {
		var auto = $instagramWrap.data('auto'),
			speed = $instagramWrap.data('speed');

		$instagramWidget.slick({
			slidesToShow: 10,
			slidesToScroll: 3,
			arrows: false,
			autoplay: auto === 1,
			speed: speed,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 6
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 4
					}
				}
			]
		});
	}

	/* -----------------------------------------
	 Justified Galleries
	 ----------------------------------------- */
	var windowWidth = $(window).width();
	var isScreenXs = windowWidth < 768;
	var isScreenSm = windowWidth > 767 && windowWidth < 992;

	var $galleryJustified = $('.justified-gallery');
	if ( $galleryJustified.length ) {
		$galleryJustified.each(function() {
			var rowHeight = $(this).data('height');

			$(this).justifiedGallery({
				rowHeight: isScreenXs ? 100 : isScreenSm ? 140 : rowHeight,
				margins: isScreenXs || isScreenSm ? 15 : 20,
				lastRow: 'nojustify',
				captions: false,
				border: 0
			});
		});
	}


	$(window).on('load', function() {

		/* -----------------------------------------
		 FlexSlider Init
		 ----------------------------------------- */
		var homeSlider = $('.home-slider');

		if ( homeSlider.length ) {
			var animation = homeSlider.data('animation') || 'fade';
			var slideshow = homeSlider.data('slideshow');
			var slideshowSpeed = homeSlider.data('slideshowspeed') || 3000;
			var animationSpeed = homeSlider.data('animationspeed') || 600;

			homeSlider.flexslider({
				animation: animation,
				slideshow: slideshow,
				slideshowSpeed: slideshowSpeed,
				animationSpeed: animationSpeed,
				controlNav: false,
				namespace: 'ci-',
				prevText: '',
				nextText: '',
				start: function(slider) {
					slider.removeClass('loading');
				}
			});
		}

		$('.preloader').fadeOut(400);
	});

	var roomSlider = $('.room-slider');

	if ( roomSlider.length ) {
		var roomNext  = roomSlider.find('.room-slide-next');
		var roomPrev  = roomSlider.find('.room-slide-prev');
		var controlNextImg = roomNext.find('img');
		var controlPrevImg = roomPrev.find('img');

		var setSlideThumbnails = function(slider) {
			var slideNo = slider.slides.length - 1;
			var nextSlideIndex = slider.currentSlide === slideNo ? 0 : slider.currentSlide + 1;
			var prevSlideIndex = slider.currentSlide === 0 ? slideNo : slider.currentSlide - 1;

			controlNextImg.attr('src', slider.slides.find('img').eq(nextSlideIndex).attr('src'));
			controlPrevImg.attr('src', slider.slides.find('img').eq(prevSlideIndex).attr('src'));
		};

		roomSlider.flexslider({
			controlNav: false,
			directionNav: false,
			namespace: 'ci-',
			start: function(slider) {
				setSlideThumbnails(slider);
			},
			after: function(slider) {
				setSlideThumbnails(slider);
			}
		});

		roomPrev.on('click', function(e) {
			e.preventDefault();
			roomSlider.flexslider('prev');
		});

		roomNext.on('click', function(e) {
			e.preventDefault();
			roomSlider.flexslider('next');
		});
	}

});

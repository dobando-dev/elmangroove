<?php
/*
 * Template Name: Booking Page
 */
?>
<?php
	// Sanitize data, or initialize if they don't exist.
	$clientname = isset( $_POST['ci_name'] ) ? esc_html( trim( $_POST['ci_name'] ) ) : '';
	$email      = isset( $_POST['ci_email'] ) ? esc_html( trim( $_POST['ci_email'] ) ) : '';
	$arrive     = isset( $_POST['arrive'] ) ? esc_html( trim( $_POST['arrive'] ) ) : '';
	$depart     = isset( $_POST['depart'] ) ? esc_html( trim( $_POST['depart'] ) ) : '';
	$guests     = isset( $_POST['adults'] ) ? intval( $_POST['adults'] ) : '';
	$children   = isset( $_POST['children'] ) ? intval( $_POST['children'] ) : '';
	$message    = isset( $_POST['ci_comments'] ) ? sanitize_text_field( stripslashes( $_POST['ci_comments'] ) ) : '';

	if ( ! empty( $_POST['room_select'] ) ) {
		$room_id = intval( $_POST['room_select'] );
	} elseif ( ! empty( $_GET['room_select'] ) ) {
		$room_id = intval( $_GET['room_select'] );
	} else {
		$room_id = '';
	}

	$errorString = '';
	$emailSent   = false;

	if ( isset( $_POST['send_booking'] ) ) {
		// We are here because the form was submitted. Let's validate!

		if ( empty( $clientname ) or mb_strlen( $clientname ) < 2 ) {
			$errorString .= '<li>' . __( 'Your <b>name</b> is required.', 'zermatt' ) . '</li>';
		}

		if ( empty( $email ) or ! is_email( $email ) ) {
			$errorString .= '<li>' . __( 'A valid <b>email</b> is required.', 'zermatt' ) . '</li>';
		}

		if ( empty( $arrive ) or strlen( $arrive ) != 10 ) {
			$errorString .= '<li>' . __( 'A complete <b>arrival date</b> is required.', 'zermatt' ) . '</li>';
		}

		if ( ! checkdate( substr( $arrive, 5, 2 ), substr( $arrive, 8, 2 ), substr( $arrive, 0, 4 ) ) ) {
			$errorString .= '<li>' . __( 'The <b>arrival date</b> must be in the <b>form yyyy/mm/dd</b>.', 'zermatt' ) . '</li>';
		}

		if ( empty( $depart ) or strlen( $depart ) != 10 ) {
			$errorString .= '<li>' . __( 'A complete <b>departure date</b> is required.', 'zermatt' ) . '</li>';
		}

		if ( ! checkdate( substr( $depart, 5, 2 ), substr( $depart, 8, 2 ), substr( $depart, 0, 4 ) ) ) {
			$errorString .= '<li>' . __( 'The <b>departure date</b> must be in the form <b>yyyy/mm/dd</b>.', 'zermatt' ) . '</li>';
		}

		if ( empty( $guests ) or ! is_numeric( $guests ) or $guests < 1 ) {
			$errorString .= '<li>' . __( 'A number of one or more <b>adults</b> is required.', 'zermatt' ) . '</li>';
		}

		if ( empty( $room_id ) or ! is_numeric( $room_id ) or $room_id < 1 ) {
			$errorString .= '<li>' . __( 'You must select the <b>room</b> you are interested in.', 'zermatt' ) . '</li>';
		} else {
			$room = get_post( $room_id );
			if ( $room === null or get_post_type( $room ) != 'zermatt_room' ) {
				// Someone tried to pass a post id that isn't a room. Kinky.
				$errorString .= '<li>' . __( 'You must select the <b>room</b> you are interested in.', 'zermatt' ) . '</li>';
			}
		}

		// Message is optional, so, no check.


		// Alright, lets send the email already!
		if ( empty( $errorString ) ) {
			$mailbody = __( 'Name:', 'zermatt' ) . ' ' . $clientname . "\n";
			$mailbody .= __( 'Email:', 'zermatt' ) . ' ' . $email . "\n";
			$mailbody .= __( 'Arrival:', 'zermatt' ) . ' ' . $arrive . "\n";
			$mailbody .= __( 'Departure:', 'zermatt' ) . ' ' . $depart . "\n";
			$mailbody .= __( 'Adults:', 'zermatt' ) . ' ' . $guests . "\n";
			$mailbody .= __( 'Children:', 'zermatt' ) . ' ' . $children . "\n";
			$mailbody .= __( 'Room:', 'zermatt' ) . ' ' . $room->post_title . "\n";
			$mailbody .= __( 'Message:', 'zermatt' ) . ' ' . $message . "\n";

			// If you want to receive the email using the address of the sender, comment the next $emailSent = ... line
			// and uncomment the one after it.
			// Keep in mind the following comment from the wp_mail() function source:
			/* If we don't have an email from the input headers default to wordpress@$sitename
			* Some hosts will block outgoing mail from this address if it doesn't exist but
			* there's no easy alternative. Defaulting to admin_email might appear to be another
			* option but some hosts may refuse to relay mail from an unknown domain. See
			* http://trac.wordpress.org/ticket/5007.
			*/
			$emailSent = wp_mail( get_theme_mod( 'booking_email', get_option( 'admin_email' ) ), get_option( 'blogname' ) . ' - ' . esc_html__( 'Booking form', 'zermatt' ), $mailbody );
			//$emailSent = wp_mail( get_theme_mod( 'booking_email', get_option( 'admin_email' ) ), get_option( 'blogname' ) . ' - ' . esc_html__( 'Booking form', 'zermatt' ), $mailbody, 'From: "' . $clientname . '" <' . $email . '>' );
		}

	}
?>

<?php get_header(); ?>

<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php while ( have_posts() ): the_post(); ?>
					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

						<?php if ( ! empty( $errorString ) ): ?>
							<div class="form-error">
								<div class="form-box-icon"><i class="fa fa-warning"></i></div>
								<p><?php _e( 'There have been some errors with your submission:', 'zermatt' ); ?></p>
								<ul class="form-errors">
									<?php echo $errorString; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php if ( $emailSent === true ): ?>
							<div class="form-success">
								<div class="form-box-icon"><i class="fa fa-check"></i></div>
								<p><?php _e( 'Thank you for your interest! We have received your e-mail and will get back to you as soon as possible!', 'zermatt' ); ?></p>
							</div>

						<?php elseif ( $emailSent === false && isset( $_POST['send_booking'] ) && $errorString == '' ): ?>
							<div class="form-error">
								<div class="form-box-icon"><i class="fa fa-warning"></i></div>
								<p><?php _e( 'There was a problem while sending the email. Please try again later.', 'zermatt' ); ?></p>
							</div>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>

							<?php if ( ! isset( $_POST['send_booking'] ) || ( isset( $_POST['send_booking'] ) && ! empty( $errorString ) ) ): ?>
								<?php
									$form_action = get_theme_mod( 'booking_page' ) ? get_permalink( get_theme_mod( 'booking_page' ) ) : false;
									if ( empty( $form_action ) ) {
										$form_action = get_permalink();
									}
								?>

								<form class="booking-form" action="<?php echo esc_url( $form_action ); ?>" method="post">
									<div class="row">
										<div class="col-md-6">
											<label for="ci_name"><?php _ex( 'Your Name', 'booking form label', 'zermatt' ); ?></label>
											<input type="text" name="ci_name" id="ci_name" value="<?php echo esc_attr( $clientname ); ?>" required>
										</div>

										<div class="col-md-6">
											<label for="ci_email"><?php _ex( 'Your E-mail', 'booking form label', 'zermatt' ); ?></label>
											<input type="email" name="ci_email" id="ci_email" value="<?php echo esc_attr( $email ); ?>" required>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<label for="arrive"><?php _ex( 'Arrival', 'booking form label', 'zermatt' ); ?></label>

											<div class="arrival">
												<input type="text" name="arrive" id="arrive" class="datepicker" value="<?php echo esc_attr( $arrive ); ?>" required>
											</div>
										</div>

										<div class="col-md-6">
											<label for="depart"><?php _ex( 'Departure', 'booking form label', 'zermatt' ); ?></label>

											<div class="departure">
												<input type="text" name="depart" id="depart" class="datepicker" value="<?php echo esc_attr( $depart ); ?>" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<label for="adults"><?php _ex( 'Adults', 'booking form label', 'zermatt' ); ?></label>
											<div class="ci-select">
												<div class="ci-select">
													<select name="adults" id="adults" class="dk">
														<?php for ( $i = 1; $i <= 4; $i ++ ) {
															echo sprintf( '<option value="%s" %s>%s</option>', esc_attr( $i ), selected( $guests, $i, false ), $i );
														} ?>
													</select>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<label for="children"><?php _ex( 'Children', 'booking form label', 'zermatt' ); ?></label>
											<div class="ci-select">
												<select name="children" id="children" class="dk">
													<?php for ( $i = 0; $i <= 4; $i ++ ) {
														echo sprintf( '<option value="%s" %s>%s</option>', esc_attr( $i ), selected( $children, $i, false ), $i );
													} ?>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12">
											<label for="room_select"><?php _ex( 'Room', 'booking form label', 'zermatt' ); ?></label>
											<div class="ci-select">
												<?php zermatt_dropdown_posts( array(
													'id'                   => 'room_select',
													'post_type'            => 'zermatt_room',
													'selected'             => $room_id,
													'class'                => 'dk',
													'select_even_if_empty' => true,
												), 'room_select' ); ?>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12">
											<label for="ci_comments"><?php _ex( 'Comments', 'booking form label', 'zermatt' ); ?></label>
											<textarea name="ci_comments" id="ci_comments" cols="30" rows="10"><?php echo esc_textarea( $message ); ?></textarea>
										</div>
									</div>

									<input type="submit" name="send_booking" value="<?php echo esc_attr_x( 'Send', 'booking form label', 'zermatt' ); ?>">
								</form>
							<?php endif; ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>

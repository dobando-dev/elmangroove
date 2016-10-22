<?php
	if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
		die ( esc_html__('Please do not load this page directly. Thanks!', 'zermatt'));

	if ( post_password_required() )
		return;
?>

<?php if( have_comments() || comments_open() ): ?>
	<div id="comments">
<?php endif; ?>

<?php if ( have_comments() ): ?>
	<div class="post-comments group">
		<h3><?php comments_number(); ?></h3>
		<div class="comments-pagination"><?php paginate_comments_links(); ?></div>
		<ol id="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'type'        => 'comment',
					'avatar_size' => 64
				) );
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'type'       => 'pings'
				) );
			?>
		</ol>
		<div class="comments-pagination"><?php paginate_comments_links(); ?></div>
	</div><!-- .post-comments -->
<?php endif; ?>

<?php if ( comments_open() ): ?>
	<section id="respond">
		<div id="form-wrapper" class="group">
			<?php comment_form(); ?>
		</div><!-- #form-wrapper -->
	</section>
<?php endif; ?>

<?php if( have_comments() || comments_open() ): ?>
	</div><!-- #comments -->
<?php endif; ?>

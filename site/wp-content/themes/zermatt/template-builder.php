<?php
/**
 * Template Name: Page builder
 */
?>

<?php get_header(); ?>

<main class="main">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
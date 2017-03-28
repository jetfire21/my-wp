<?php
/**
 * Single Job
 *
 * @since Jobify 3.0.0
 */

get_header();
?>

    <?php while( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

    <?php endwhile; ?>

<?php get_footer(); ?>

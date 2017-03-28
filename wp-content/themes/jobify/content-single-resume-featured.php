<?php
/**
 * Featured Resume
 *
 * @package Jobify
 * @since Jobify 3.2.0
 */
?>

<div class="resume-spotlight">
	<div class="resume-spotlight__featured-image">
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php the_candidate_photo( 'fullsize' ); ?>
		</a>
	</div>

	<div class="resume-spotlight__content">
		<p><a href="<?php the_permalink(); ?>" rel="bookmark" class="resume-spotlight__title"><?php the_title(); ?></a></p>

		<div class="resume-spotlight__actions">
			<span class="resume_listing-location"><?php the_candidate_location(false); ?></span>
		</div>

		<?php the_excerpt(); ?>
	</div>
</div>

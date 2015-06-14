<?php get_header(); ?>

	<section class="grid_12"> <!-- Full width grid -->
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
	endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
	</section>

<?php get_footer(); ?>
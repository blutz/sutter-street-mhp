<?php
/*
Template Name: List Parks
*/
?>
<?php get_header(); ?>

	<section class="grid_12"> <!-- Full width grid -->
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
	endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
	</section>
	
	<?php $parks = get_terms('park');
	foreach($parks as $park) { ?>
	<a href="<?php echo get_term_link($park); ?>" class="grid_6 parkselect">
		<h5><?php echo $park->name; ?></h5>
	</a>
	<div class="clear"></div>
	<?php } ?>
	
	<div class="grid_12 spaceabove">
		<h5>Not finding the manufactured home or mobile home you are looking for here?</h5>
		<p>For used homes in Placer and Nevada Counties try <a href="http://amhsales.net/">Affordable Mobile Home Sales</a>. You can also search listings both local and nationwide at <a href="http://www.mhvillage.com/">MH Village</a>, <a href="http://www.seniormobiles.com/index.php">Seniormobiles</a>, and the <a href="http://mfdhousing.com/portal/fsbo/listing_browse.php">Manufactured Housing Global Network</a>.</p>
	</div>
<?php get_footer(); ?>
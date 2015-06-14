<?php get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
	$parks = get_the_terms($post->ID,'park');
	foreach ($parks as $park) {
		$park_name = $park->name;
	}
	$space_number = get_post_meta($post->ID,'sigrist_space',true);
	$park_website = '';
	switch($park_name) {
		case 'Rocklin Estates':
			$park_website = 'http://rocklinestates.com/';
			break;
		case 'Rocklin Estates II':
			$park_website = 'http://rocklinestates.com/';
			break;
		case 'Sutter Street':
			$park_website = 'http://sutterstreetmhp.com/';
			break;
	}
	$home_info = Array();
	$home_bedrooms = get_post_meta($post->ID,'sigrist_bedrooms',true);
	$home_bathrooms = get_post_meta($post->ID,'sigrist_bathrooms',true);
	$home_price = get_post_meta($post->ID,'sigrist_price',true);
	$home_status = get_post_meta($post->ID,'sigrist_status',true);
	
	$home_info['Park'] = $park_name;
	$home_info['Space Number'] = $space_number;
	$home_info['Serial number'] = get_post_meta($post->ID,'sigrist_serial',true);
	$home_info['Manufacturer'] = get_post_meta($post->ID,'sigrist_manufacurer',true);
	$home_info['Model'] = get_post_meta($post->ID,'sigrist_model',true);
	$home_info['Model year'] = get_post_meta($post->ID,'sigrist_year',true);
	$home_info['Length'] = get_post_meta($post->ID,'sigrist_length',true);
	$home_info['Width'] = get_post_meta($post->ID,'sigrist_width',true);
	$home_info['Square feet'] = get_post_meta($post->ID,'sigrist_squarefeet',true);
?>

	<div class="grid_12">
		<a href="<?php echo get_term_link(end($parks)); ?>">&larr;More homes from this park</a>
	</div>
	<div class="grid_12">
		<h1 class="hometitle"><?php echo $park_name; ?> #<?php echo $space_number; ?>
		<?php if($park_name == 'Rocklin Estates' || $park_name == 'Rocklin Estates II') { ?>
			<span class="homeflag">55+ only</span>
		<?php } ?></h1>
		<?php if($park_website): ?>
		<a href="<?php echo $park_website; ?>" class="parklink">Go to park website</a> <?php endif; ?>
	</div>
	
	<div class="infowrapper grid_12">
	<div class="homeinfo grid_4">
	<p>
		<?php foreach($home_info as $label => $value) { if($value):?>
		<strong><?php echo $label; ?>: </strong> <?php echo $value; ?><br />
		<?php endif; } ?>
	</p>
	</div>
	
	<div class="bedbathinfo grid_2 align_right">
		<h3 class="bedbath"><?php echo $home_bedrooms; ?></h3>
		<h4 class="homeinfolabel">Bedroom<?php if($home_bedrooms > 1){ echo "s"; }?></h4>
		<hr />
		<h3 class="bedbath"><?php echo $home_bathrooms; ?></h3>
		<h4 class="homeinfolabel">Bathroom<?php if($home_bathrooms > 1){ echo "s"; }?></h4>
	</div>

	
	<div class="priceinfo grid_6">
		<?php 
		switch($home_status) {
			case '1':
				// Coming Soon ?>
				<h3 class="label_comingsoon">Coming Soon</h3>
				<?php if($home_price): ?>
					<span class="comingsoonprice">$<?php echo money_format('%!.0i',$home_price); ?></span>
				<?php endif;

				break;
			case '2':
				// Available
				if($home_price): ?>
					<h3 class="label_availableprice">$<?php echo money_format('%!.0i',$home_price); ?></h3>
					<span class="availableinfo">Available now! <a href="/contact-us/">Contact us</a> for more information.</span>
				<?php else: ?>
					<h3 class="label_availableprice">Available Now!</h3>
					<span class="availableinfo"><a href="/contact-us/">Contact us</a> for more information.</span>
				<?php endif;
				break;
			case '3':
				// Sale Pending ?>
				<h3 class="label_salepending">Sale Pending</h3>
				<?php if($home_price): ?>
					<span class="salependingprice">$<?php echo money_format('%!.0i',$home_price); ?></span>
				<?php endif;
				break;
			case '4':
				// Sold ?>
				<h3 class="label_sold">Sold</h3>
				<?php if($home_price): ?>
					<span class="soldprice">$<?php echo money_format('%!.0i',$home_price); ?></span>
				<?php endif;
				break;
		}?>
	</div>
	</div>
	
	<div class="clear"></div>

<?php
	echo the_content();
endwhile; else: ?>
<p><?php _e('Sorry, no homes matched your criteria.'); ?></p>
<?php endif; ?>

	<div class="grid_12" id="homenote">
	Please note: Although we make every effort to ensure the accuracy of specifications, representations, and features attributed to specific homes and parks on our website, changes and errors can occur.   Materials contained on this website and other websites linked to this one shall not be construed as a part of any contract, agreement, or other binding obligation.  We do encourage the use of these materials for reference, clarification, and written agreement, before actually entering into a purchase contract.  "No Surprises" is how we try to approach each purchase agreement.
	</div>

<?php get_footer(); ?>
<?php get_header(); 
$park_name = single_cat_title('',false);
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

?>
<div class="grid_12">
	<a href="<?php echo get_permalink(270); ?>">&larr;More homes for sale</a>
</div>
	
<section class="grid_9">
	<h1 class="pagename">Homes in <?php echo $park_name; ?>
		<?php 
		if($park_name == 'Rocklin Estates' || $park_name == 'Rocklin Estates II') { ?>
			<span class="homeflag homeflag_page">55+ only</span>
		<?php } ?>
	</h1>		
	<?php echo category_description(); ?>
</section>
<div class="grid_3">
	<a class="parklink" href="<?php echo $park_website; ?>">Go to park website</a>
</div>
<div class="bigpadding clear"></div>

<?php 
$counter = 1;
$posts = query_posts($query_string .'&orderby=meta_value_num&meta_key=sigrist_status&order=asc&posts_per_page=-1');
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php $parks = get_the_terms($post->ID,'park');
	$space_number = get_post_meta($post->ID,'sigrist_space',true);
	$home_info = Array();
	$home_bedrooms = get_post_meta($post->ID,'sigrist_bedrooms',true);
	$home_bathrooms = get_post_meta($post->ID,'sigrist_bathrooms',true);
	$home_price = get_post_meta($post->ID,'sigrist_price',true);
	$home_status = get_post_meta($post->ID,'sigrist_status',true);
	
	$home_info['Manufacturer'] = get_post_meta($post->ID,'sigrist_manufacurer',true);
	$home_info['Year'] = get_post_meta($post->ID,'sigrist_year',true);
	$home_info['Square feet'] = get_post_meta($post->ID,'sigrist_squarefeet',true); 
	?>

	<section class="<?php if($counter % 2) { echo 'listgrey '; } ?>fullwidth<?php if($home_status == 1) {echo ' halfopaque'; } ?>">
	<section class="grid_4" style="height:180px">
		<a href="<?php echo the_permalink(); ?>">
			<?php 	the_post_thumbnail('post-image'); ?>
		</a>
		<p class="summarytext">
		<?php echo $home_info['Year'].' '.$home_info['Manufacturer'];	 ?>
		</p>
	</section>
	<section class="grid_5">
		<a class="nounderline" href="<?php echo the_permalink(); ?>"><h1 class="homename"><?php echo $park_name.' #'.$space_number; ?></h1></a> 
		<div class="bedbathinfo_summary">
			<h3 class="bedbath_summary"><?php echo $home_bedrooms; ?></h3>
			<h4 class="homeinfolabel_summary">Bed<?php if($home_bedrooms > 1){ echo "s"; }?></h4>
			<h3 class="bedbath_summary"><?php echo $home_bathrooms; ?></h3>
			<h4 class="homeinfolabel_summary">Bath<?php if($home_bathrooms > 1){ echo "s"; }?></h4>
			<?php if($home_info['Square feet']): ?>
			<div class="rightalign">
				<h3 class="bedbath_summary squarefeet_summary"><?php echo $home_info['Square feet']; ?></h3>
				<h4 class="homeinfolabel_summary">ft&sup2;</h4>
			</div>
			<?php endif; ?>
		</div>
	</section>

	<div class="grid_5"><a class="nounderline" href="<?php echo the_permalink(); ?>">
				<?php 
		switch($home_status) {
			case '1':
				// Coming Soon ?>
				<h3 class="label_comingsoon comingsoon_summary">Coming Soon</h3>
				<?php if($home_price): ?>
					<span class="comingsoonprice comingsoonprice_summary">$<?php echo money_format('%!.0i',$home_price); ?></span>
				<?php endif;

				break;
			case '2':
				// Available
				if($home_price): ?>
					<h3 class="label_availableprice available_summary">Available now!</h3>
					<span class="availableinfo availableinfo_summary">$<?php echo money_format('%!.0i',$home_price); ?></span>
				<?php else: ?>
					<h3 class="label_availableprice available_summary">Available Now!</h3>
				<?php endif;
				break;
			case '3':
				// Sale Pending ?>
				<h3 class="label_salepending salepending_summary">Sale Pending</h3>
				<?php if($home_price): ?>
					<span class="salependingprice salependingprice_summary">$<?php echo money_format('%!.0i',$home_price); ?></span>
				<?php endif;
				break;
			case '4':
				// Sold ?>
				<h3 class="summary_sold label_sold">Sold</h3>
				<?php if($home_price): ?>
					<span class="soldprice soldsummaryprice">$<?php echo money_format('%!.0i',$home_price); ?></span>
				<?php endif;
				break;
		}?>
	</div></a>
	<div class="grid_12" class="noheight">
		<a class="moreinfo" href="<?php echo the_permalink(); ?>">Click here for more info</a>
	</div>
	</section>


	<?php $counter++;
endwhile; endif; ?>
<?php get_footer(); ?>
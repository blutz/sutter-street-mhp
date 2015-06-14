<?php get_header(); ?>
<section class="grid_12">
<?php if ( have_posts() ) : ?>
				<h1 class="page-title"><?php printf('Search Results for: %s', get_search_query()) ; ?></h1>
				<hr />
				<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					if(get_post_type() == 'homes'):
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
						print_r($home_info);
					
					else:
						if(has_post_thumbnail()) { ?>
						<div class="searchimage grid_3">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-image'); ?></a>
						</div>
						<?php } ?>
						<div class="searchcontent grid_8">
							<a href="<?php the_permalink(); ?>"><h2 class="searchtitle"><?php the_title(); ?></h2></a>
							<p><?php the_excerpt(); ?></p>
						</div>
				<?php 
				endif;
					echo "<hr />";
				endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php endif; ?>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php printf('Nothing Found for: %s', get_search_query()); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.'); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php endif; ?>
			</div><!-- #content -->
		</div><!-- #container -->

</section>
<?php get_footer(); ?>

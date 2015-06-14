<?php get_header(); ?>


	<?php
		$page_id = 5; // This is the 'home' page
		$page_data = get_page($page_id);
		
		$content = apply_filters('the_content',$page_data->post_content);
		echo $content;
	?>

<?php get_footer(); ?>
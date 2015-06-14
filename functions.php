<?php 
$prefix = 'sigrist_';

$meta_box = array(
	'id' => 'home-meta-box-1',
	'title' => 'Home information',
	'page' => 'homes',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Space number',
			'id' => $prefix.'space',
			'type' => 'text',
		),
		array(
			'name' => 'Serial number',
			'desc' => 'This is required by California State law.',
			'id' => $prefix.'serial',
			'type' => 'text',
			'req' => true,
		),
		array(
			'name' => 'Manufacturer',
			'desc' => 'This is required by California State law.',
			'id' => $prefix.'manufacurer',
			'type' => 'text',
			'req' => true,
		),
		array(
			'name' => 'Model',
			'desc' => 'This is required by California State law',
			'id' => $prefix.'model',
			'type' => 'text',
			'req' => true,
		),
		array(
			'name' => 'Model year',
			'desc' => 'This is required by California State law.',
			'id' => $prefix.'year',
			'type' => 'text',
			'req' => true,
		),
		array(
			'name' => 'Bedrooms',
			'id' => $prefix.'bedrooms',
			'type' => 'select',
			'options' => array('1','2','3','4','5','6')
		),
		array(
			'name' => 'Bathrooms',
			'id' => $prefix.'bathrooms',
			'type' => 'select',
			'options' => array('1','1.5','2','2.5','3','3.5','4','4.5','5','5.5','6')
		),
		array(
			'name' => 'Length',
			'id'=> $prefix.'length',
			'type' => 'text'
		),
		array(
			'name' => 'Width',
			'id'=> $prefix.'width',
			'type' => 'text'
		),
		array(
			'name' => 'Status',
			'id' => $prefix.'status',
			'type' => 'radio',
			'options' => array(
				array('name'=>'Coming Soon','value'=>'1'),
				array('name'=>'Available','value'=>'2'),
				array('name'=>'Sale Pending','value'=>'3'),
				array('name'=>'Sold','value'=>'4')
			)
		),
		array(
			'name'=>'Price',
			'desc' => 'Cost in dollars. Do not include the dollar sign.',
			'id'=>$prefix.'price',
			'type' => 'text'
		),
		array(
			'name' => 'Square feet',
			'id' => $prefix.'squarefeet',
			'type' => 'text'
		),
	),
);

function post_type_homes() {
	register_post_type('homes',array(
		'labels' => array(
			'name' => __('Homes'),
			'singular name' => __('Home'),
			'add_new' => __('Add New'),
			'add_new_item' => __('Add New Home'),
			'edit' => __('Edit'),
			'edit_item' => __('Edit Home'),
			'new_item' => __('New Home'),
			'view' => __('View'),
			'view_item' => __('View Home'),
			'search_items' => __('Search Homes'),
			'not_found' => __('No homes found'),
			'not_found_in_trash' => __('No homes found in Trash')
		),
		'public' => true,
		'show_ui' => true,
		'query_var' => true,
		'supports' => array('title','editor','revisions','thumbnail','page-attributes'),
		'can_export' => true
	));
	
	register_taxonomy('park','homes', array(
		'label' => 'Park',
		'hierarchical' => true
	));
	
}

function homes_add_box() {
	global $meta_box;
	add_meta_box($meta_box['id'],$meta_box['title'],'home_show_box',$meta_box['page'],$meta_box['context'], $meta_box['priority']);
}

function home_show_box() {
	    global $meta_box, $post;

	    // Use nonce for verification
	    echo '<input type="hidden" name="sigristhomes_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	    echo '<table class="form-table">';

	    foreach ($meta_box['fields'] as $field) {
	        // get current post meta data
	        $meta = get_post_meta($post->ID, $field['id'], true);

	        echo '<tr>',
	                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
	                '<td>';
	        switch ($field['type']) {
	            case 'text':
	                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
	                break;
	            case 'textarea':
	                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
	                break;
	            case 'select':
	                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
	                foreach ($field['options'] as $option) {
	                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
	                }
	                echo '</select>';
	                break;
	            case 'radio':
	                foreach ($field['options'] as $option) {
	                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'],'<br />';
	                }
	                break;
	            case 'checkbox':
	                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
	                break;
	        }
	        echo     '<td>',
	            '</tr>';
	    }

	    echo '</table>';	
}

function homes_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['sigristhomes_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
function home_columns($columns) {
	$columns['space'] = 'Space Number';
	$columns['price'] = 'Price';
	$columns['bedrooms'] = 'Bedrooms';
	$columns['bathrooms'] = 'Bathrooms';
	$columns['status'] = 'Status';
	$columns['park'] = 'Park';
	return $columns;
}

function home_columns_sortable($columns) {
	$columns['space'] = 'space';
	$columns['bedrooms'] = 'bedrooms';
	$columns['bathrooms'] = 'bathrooms';
	$columns['status'] = 'status';
	$columns['price'] = 'price';
	return $columns;
}
function home_show_columns($name) {
	global $post;
	switch ($name) {
		case 'space':
			$space = get_post_meta($post->ID,'sigrist_space',true);
			echo $space;
			break;
		case 'bedrooms':
			$bedrooms = get_post_meta($post->ID,'sigrist_bedrooms',true);
			echo $bedrooms;
			break;
		case 'bathrooms':
			$bathrooms = get_post_meta($post->ID,'sigrist_bathrooms',true);
			echo $bathrooms;
			break;
		case 'price':
			$price = get_post_meta($post->ID,'sigrist_price',true);
			if($price) {
				echo "$".money_format('%!i',$price);
			}
			break;
		case 'status':
			$status = get_post_meta($post->ID,'sigrist_status',true);
			switch($status) {
				case 1:
					echo 'Coming Soon';
					break;
				case 2:
					echo 'Available';
					break;
				case 3:
					echo 'Sale Pending';
					break;
				case 4:
					echo 'Sold';
					break;
			}
			break;
		case 'park':
			$park = wp_get_post_terms($post->ID,'park',array("fields" => "names"));
			$parks = count($park);
			for($i = 0; $i < $parks; $i++) {
				echo $park[$i];
				if ($i != ($parks - 1)) {
					echo "<br />";
				}
			}
	}
}



function homes_column_orderby( $vars ) {
	if ( isset( $vars['orderby'] ) && 'space' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'sigrist_space',
			'orderby' => 'meta_value_num'
		) );
	}
	if ( isset( $vars['orderby'] ) && 'bedrooms' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'sigrist_bedrooms',
			'orderby' => 'meta_value_num'
		) );
	}
	if ( isset( $vars['orderby'] ) && 'bathrooms' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'sigrist_bathrooms',
			'orderby' => 'meta_value_num'
		) );
	}
	if ( isset( $vars['orderby'] ) && 'status' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'sigrist_status',
			'orderby' => 'meta_value_num'
		) );
	}
	if ( isset( $vars['orderby'] ) && 'price' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'sigrist_price',
			'orderby' => 'meta_value_num'
		) );
	}
	
	$current_url = substr( $GLOBALS['PHP_SELF'], -18);
	if (is_admin() && $current_url == '/wp-admin/edit.php' && isset($vars['post_type']) && $vars['post_type']=='homes') {
			$vars['term'] = get_term($vars['park'],'park')->name;
		}
 
	return $vars;
}

function my_restrict_manage_posts() {
    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'homes') {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('park');

        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
			$tax_name = $tax_name.'s';
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);

            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Show homes in all $tax_name</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
}

add_action('init', 'post_type_homes');
add_action('admin_menu','homes_add_box');
add_action('save_post','homes_save_data');
add_filter('manage_edit-homes_columns','home_columns');
add_filter('manage_edit-homes_sortable_columns', 'home_columns_sortable' );
add_action('manage_posts_custom_column','home_show_columns');
add_filter('request', 'homes_column_orderby' );
add_action('restrict_manage_posts','my_restrict_manage_posts');
add_theme_support('post-thumbnails');
add_theme_support( 'menus' );
register_nav_menu('primary', 'Primary Menu');
setlocale(LC_MONETARY, 'en_US');
add_image_size( 'post-image',  300, 180, true );
?>
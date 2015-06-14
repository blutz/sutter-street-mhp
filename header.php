<?php update_option('siteurl','http://sutterstreetmhp.com');
    update_option('home','http://sutterstreetmhp.com'); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title(''); if(!is_home()) { echo ' | '; } echo bloginfo('name').' '.bloginfo('description'); if(is_home()) { echo ', Yuba City, California'; } ?></title>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/min/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/min/text.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/min/960_12_col.css" />
	<link href='http://fonts.googleapis.com/css?family=Volkhov:400italic|Shanti' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Nobile:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />
	
	<?php wp_head(); ?>
</head>

<body class="container_12">
<a href="<?php bloginfo('url'); ?>" id="headerlink">
	<header id="top">
		<img class="grid_2 nostyle" src="<? bloginfo('template_directory'); ?>/img/logo.png" />
		<div id="titles" class="grid_7">
			<h1><?php bloginfo('name'); ?></h1>
			<h2><?php bloginfo('description'); ?></h2>
		</div> <!-- End titles  -->
		<div class="grid_2" id="outsideLinks">
			<ul>
				<li><a href="http://rocklinestates.com/">Rocklin Estates <span class="navComment">55+</span></a></li>
				<li><a href="http://sigristhomes.com/">Sigrist Homes</a></li>
			</ul>
		</div> <!-- End outsideLinks -->
	</header>
</a>
	
	<div id="mainbody">
	
	<nav>
			<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-header','theme_location'=>'primary','container'=>'false','fallback_cb'=>'') ); ?></footer>
		
			
	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	        <input class="searchinput" type="search"  placeholder="Search..." value="" name="s" id="s" />
	</form>
	</nav>
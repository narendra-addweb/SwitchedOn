<?php


	define( 'EWF_SETUP_PAGE'			, 'functions.php');				# page containing setup
	define( 'EWF_SETUP_THEME_DOMAIN'	, 'sapphire-wp');				# translation domain
	define( 'EWF_SETUP_THNAME'			, 'bitpub');					# theme options short name
	define( 'EWF_SETUP_TITLE'			, 'Sapphire Setup');			# wordpress menu title
	define( 'EWF_SETUP_THEME_NAME'		, 'Sapphire Wordpress');		# wordpress menu title
	define( 'EWF_SETUP_THEME_VERSION'	, '1.0.9');						# wordpress menu title
	
	
	include_once ('framework/framework-setup.php');

?>

<?php 
//widget area for custom blog post.

register_sidebar(array( // register left sidebar, this block may be repeat to add other sidebars
	'name' => 'Custom Blogs', // displaying name in admin panel
	'id' => "custom-blog", // identificator for calling sidebar in sidebar.php or another templates
	'description' => 'This sidebar is used in custom blog template', // displaying description in admin panel
	'before_widget' => '<div id="custom-blog-related-post" class="custom-related-post">', // markup before any widget
	'after_widget' => "</div>\n", // markup after any widget
	'before_title' => '<span class="blogtitile">', // markup before any title in widget
	'after_title' => "</span>\n", // markup after any title in widget
));
?>
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

//widget area for custom blog post side 1.

register_sidebar(array( // register left sidebar, this block may be repeat to add other sidebars
	'name' => 'Custom Blogs Sidebar 1', // displaying name in admin panel
	'id' => "custom-blog-side-1", // identificator for calling sidebar in sidebar.php or another templates
	'description' => 'This sidebar 1 is used in custom blog template', // displaying description in admin panel
	'before_widget' => '<div id="custom-blog-related-post-side-1" class="custom-related-post-side-1">', // markup before any widget
	'after_widget' => "</div>\n", // markup after any widget
	'before_title' => '<span class="blogtitile-side-1">', // markup before any title in widget
	'after_title' => "</span>\n", // markup after any title in widget
));

//widget area for custom blog post side 2.

register_sidebar(array( // register left sidebar, this block may be repeat to add other sidebars
	'name' => 'Custom Blogs Sidebar 2', // displaying name in admin panel
	'id' => "custom-blog-side-2", // identificator for calling sidebar in sidebar.php or another templates
	'description' => 'This sidebar 2 is used in custom blog template', // displaying description in admin panel
	'before_widget' => '<div id="custom-blog-related-post-side-2" class="custom-related-post-side-2">', // markup before any widget
	'after_widget' => "</div>\n", // markup after any widget
	'before_title' => '<span class="blogtitile-side-2">', // markup before any title in widget
	'after_title' => "</span>\n", // markup after any title in widget
));

/**
 * Generate custom pagination for blogs page for custom post
 * 
 * @uses paginate_links()
 * @uses get_option()
 */
function awsCustomPagination($arg_query, $paged){
	
	$total = $arg_query->max_num_pages;
	// only bother with the rest if we have more than 1 page!
	if ($total > 1)  {
	     // get the current page
	     if (!$current_page = $paged)
	          $current_page = 1;
	     // structure of "format" depends on whether we're using pretty permalinks
	     if(get_option('permalink_structure')) {
		     $format = '&paged=%#%';
	     } else {
		     $format = 'page/%#%/';
	     }

	     //Render pagination...
	     echo paginate_links(array(
	          //'base'     => get_pagenum_link(1) . '%_%',
	          //'format'   => $format,
	          'current'  => $current_page,
	          'total'    => $total,
	          'mid_size' => 4,
	          'type'     => 'list',
	          'prev_text' => '« Previous Page',
	          'next_text' => 'Next Page »'
	     ));
	}
}


/**
 * Get post excerpt out of post loop and trim it
 * 
 * @uses get_post()
 * @uses setup_postdata()
 * @uses get_the_excerpt()
 * @uses strip_shortcodes()
 * @uses strip_tags()
 * @uses get_post_permalink()
 * @uses wp_reset_postdata()
 */
function get_excerpt_out_loop($post_id, $excerpt_word_length = 9){
    global $post;
    $temp = $post;
    $post = get_post($post_id);
    
    setup_postdata($post);
    $the_excerpt = get_the_excerpt(); //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = $excerpt_word_length; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        $postLink = get_post_permalink($blogs_value->ID);//Main post url...
        $postTitle = $post->post_title;//Main post url...
      	$keepingLink = "...<a href='". $postLink ."' title='Keep Reading For ". $postTitle . "'><span class='keep-reading'>Keep Reading</span></a>";
        array_push($words, $keepingLink);
        $the_excerpt = implode(' ', $words);
    endif;

    wp_reset_postdata();
    $post = $temp;
    return $the_excerpt;

    
}
?>
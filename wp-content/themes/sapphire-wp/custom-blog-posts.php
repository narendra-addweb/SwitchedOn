<?php 
	/**
 * Template Name: Custom Blog Post
 */
get_header(); ?>

<div class="wrapper">
	<div class="custom-blog-header-image">
		<?php 
			while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
        	<div class="entry-content-page">
            	<?php the_content(); ?> <!-- Page Content -->
        	</div><!-- .entry-content-page -->
		<?php
		    endwhile; //resetting the page loop
		    wp_reset_query(); 
		?>
	</div>
	<div class="blog-content ewf-row"><?php 
			$the_query = new WP_Query( array(
																	'post_type' => 'blogs',
																	'order' => 'DESC',
																	'pagination'=> true, 
																	'posts_per_page' => '2',
																	'paged' => $paged,
																	'post_status'=> 'publish' 
																	)
																); 
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array('post_type' => 'blogs','order' => 'DESC','pagination'=> true,'posts_per_page' => '2','paged' => $paged,'post_status'=> 'publish');
			$custom_blog_post_data = get_posts($args);			
		?>

		<!-- **************************Custom Blog Post Data********************************** -->
		<div class="blog-posts wpb_column vc_column_container vc_col-sm-9 custom-blog-right-side">
			<div class="blog-post-lists">
				<h3 class="headline"><span>BLOGS</span></h3>
				<?php 
					foreach ($custom_blog_post_data as $blogs_key => $blogs_value) {
						$custom_field_data = get_post_custom($blogs_value->ID);
						$mainPostLink = get_post_permalink($blogs_value->ID);//Main post url...
						$mainPostTitle = $blogs_value->post_title;//Main post title...
						$mainPostPublishedDate = human_time_diff(get_post_time('U', false, $blogs_value), current_time('timestamp'));//Post published date interval
						$objAuthor = get_user_by( 'ID', $blogs_value->post_author );
						$post_author = $objAuthor->display_name;//Post author display name...
						$mainPostAuthor = $post_author;//Post author...
						?>
						<div class="custom-blog-post blog-post-list">
							<div class="blog-list-title">
								<h3><a href="<?php echo $mainPostLink;?>" title="<?php print($mainPostTitle);?>"><?php echo strtoupper($mainPostTitle); ?></a></h3>
							</div>
							<div class="blog-list-author">
								<h4><?php echo $mainPostAuthor; ?> | <?php echo $mainPostPublishedDate ." ".__('ago'); ?></h4>
							</div>
							<div class="blog-list-img"><?php
								//Get related post thumb in medium size...
								add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
								$related_thumb = get_the_post_thumbnail( $blogs_value->ID, 'medium' );
								print '<a href="'. $mainPostLink .'" title="'. $mainPostTitle . '">' . $related_thumb . '</a>';
								remove_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
								
							?></div>
							<div class="blog-list-desc">
								<p><?php
									//Get the excerpt... 
									echo  get_excerpt_out_loop($blogs_value->ID, 20) 
								?></p>
							</div>
						</div>
					<?php }
				//Pagination Start
				?><div class="blog-pagination">
					<nav>
						<div class="navigation"><?php
							awsCustomPagination($the_query, $paged);//Render pagination from function.php custom function...
						?></div>
					</nav>
				</div><?php
				//Pagination End
			?></div>
		</div>
		<!-- Remove 'Related Blog Post' code as per ticket #78 -->
		<div class="custom-blog-left-side vc_col-sm-3"><?php 
			dynamic_sidebar('custom-blogs');
			?><div class="parent-custom-blog-side-1"><?php
			dynamic_sidebar('custom-blog-side-1');
			?></div><?php
			dynamic_sidebar('custom-blog-side-2');
		?></div>
	</div>
	
</div>
<?php get_footer(); ?>
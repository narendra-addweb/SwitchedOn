
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
		?><!-- **************************Custom Blog Post Data********************************** -->
		<div class="blog-posts wpb_column vc_column_container vc_col-sm-8">
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
								$related_thumb = get_the_post_thumbnail( $blogs_value->ID, 'medium' );
								//Get the excerpt...
								print get_excerpt_out_loop($blogs_value->ID, 20);
							?></div>
							<div class="blog-list-desc">
								<p><?php echo  $custom_post_excerpt; ?></p>
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
		<!-- **************************Related Blog Post <DATA></DATA>ata********************************** -->
		<div class="blog-related-post wpb_column vc_column_container vc_col-sm-4">
			<div class="blog-post-lists related-post">
				<h3 class="headline"><span>RELATED BLOG</span></h3>
				<?php
					$chk_duplicate_key = array() ;
					// print_r($custom_blog_post_data);
					foreach ($custom_blog_post_data as $R_blogs_key => $R_blogs_value) {
						$R_custom_field_data = get_post_custom($R_blogs_value->ID);
						$objAuthor = get_user_by( 'ID', $R_blogs_value->post_author );
						$post_author = $objAuthor->display_name;//Post author display name...
						$serialize_post_data =  maybe_unserialize( $R_custom_field_data['crp_relations_to'][0] );
						
						if(!empty($serialize_post_data)) {
							$related_blog_post = $serialize_post_data; 
							//Get rendom two related post...
							if(COUNT($serialize_post_data) > 2){
								$random_blog_post = array_rand($serialize_post_data, 2);
								$related_blog_post	= $random_blog_post;
							}


							foreach($serialize_post_data as $related_post_id => $r_post_data) { 
								if(!in_array($related_post_id, $related_blog_post)) { 
									$objPostData = $post = get_post( $related_post_id );
									
									//Get related post thumb in medium size...
									$related_thumb = get_the_post_thumbnail( $related_post_id, 'medium' );
									$postLink = get_post_permalink($related_post_id);//Post link...
									$postTitle = $objPostData->post_title;//Post title...
									$postPublishedDate = human_time_diff(get_post_time('U', false, $objPostData), current_time('timestamp'));//Post published date interval
									$postAuthor = $post_author;//Post author...
									?>
									<div class="custom-blog-related-post blog-post-list">
										<div class="blog-list-img"><?php 
											echo '<a href="'.$postLink.'" title="'.$postTitle.'">';
											echo $related_thumb;
											echo '</a>';
										?></div>
										<div class="related-post-detail">
											<div class="blog-list-author">
												<h4><?php echo $postAuthor; ?> | <?php echo $postPublishedDate ." ".__('ago'); ?></h4>
											</div>
											<div class="blog-list-title">
												<h3><a href="<?php echo $postLink;?>" title="<?php echo $postTitle;?>"><?php echo strtoupper($postTitle); ?></a></h3>
											</div><?php
											//Get the excerpt...
											print get_excerpt_out_loop($related_post_id, 10);
											?><div class="blog-list-desc">
												<p><?php echo  $related_custom_post_excerpt; ?></p>
											</div>
										</div>
									</div><?php
					    	} 		
							} 
						}
					} ?>
				</div>
			</div>
	</div>
	
</div>
<?php get_footer(); ?>
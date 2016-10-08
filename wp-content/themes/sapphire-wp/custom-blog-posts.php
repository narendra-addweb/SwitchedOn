
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
	<div class="blog-content ewf-row">
		<?php 
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array('post_type' => 'blogs','order' => 'DESC','pagination'=> true,'posts_per_page' => '2','paged' => $paged,'post_status'=> 'publish');
			$the_query = new WP_Query( array('post_type' => 'blogs','order' => 'DESC','pagination'=> true, 'posts_per_page' => '2','paged' => $paged,'post_status'=> 'publish' )); 
			$custom_blog_post_data = get_posts($args);
		?>
		<!-- **************************Custom Blog Post Data********************************** -->
		<div class="blog-posts wpb_column vc_column_container vc_col-sm-8">
			<div class="blog-post-lists">
				<h3 class="headline"><span>BLOGS</span></h3>
				<?php 
					foreach ($custom_blog_post_data as $blogs_key => $blogs_value) {
						$custom_field_data = get_post_custom($blogs_value->ID);
						?>
						<div class="custom-blog-post blog-post-list">
							<div class="blog-list-title">
								<h3><a href="<?php echo get_post_permalink($blogs_value->ID);?>"><?php echo strtoupper($blogs_value->post_title); ?></a></h3>
							</div>
							<div class="blog-list-author">
								<h4><?php echo get_author_name($blogs_value->post_author) ?> | <?php echo human_time_diff(get_post_time('U',$blogs_value->ID), current_time('timestamp'))." ".__('ago'); ?></h4>
							</div>
							<div class="blog-list-img">
								<img src="<?php echo $custom_field_data['wpcf-set-featured-image'][0]; ?>" width="300px">
								<?php if(strlen($blogs_value->post_content) != 239) {
										$custom_post_excerpt = substr($blogs_value->post_content, 0, 239)."...<a href='".get_post_permalink($blogs_value->ID)."'><span class='keep-reading'>Keep Reading</span></a>";
									}
									else {
											$custom_post_excerpt = $blogs_value->post_content;
										}?>
							</div>
							<div class="blog-list-desc">
								<p><?php echo  $custom_post_excerpt; ?></p>
							</div>
						</div>
					<?php }
				?>
				<div class="blog-pagination">
					<nav>
						<?php 
							if($the_query->max_num_pages > 1 ) {
								$max   = intval( $the_query->max_num_pages );
								if($paged >= 1) {
									$links[] = $paged;
								}
								if($paged >= 3) {
									$links[] = $paged - 1;
									$links[] = $paged - 2;
								}
								if ( ( $paged + 2 ) <= $max ) {
									$links[] = $paged + 2;
									$links[] = $paged + 1;
								}

								echo '<div class="navigation"><ul>' . "\n";
								/** Previous Post Link */
								if ( get_previous_posts_link() ) {
									printf( '<li class="prev">%s</li>' . "\n", get_previous_posts_link() );
								}
								/** Link to first page, plus ellipses if necessary */
								if ( ! in_array( 1, $links ) ) {
									$class = 1 == $paged ? ' class="active"' : '';
									printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

									if( ! in_array( 2, $links )) {
										echo '<li>…</li>';
									}
								}
								/** Link to current page, plus 2 pages in either direction if necessary */
								sort( $links );
								foreach ( (array) $links as $link ) {
									$class = $paged == $link ? ' class="active"' : '';
									printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
								}
								/** Link to last page, plus ellipses if necessary */
								if ( ! in_array( $max, $links ) ) {
									echo '<li>…</li>' . "\n";
									$class = $paged == $max ? ' class="active"' : '';
									printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
								}
								/** Next Post Link */
								if ( get_next_posts_link() ) {
									printf( '<li class="next">%s</li>' . "\n", get_next_posts_link() );
								}
								echo '</ul></div>' . "\n";
							}
						?>
				  </nav>
				</div>
			</div>
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
						$serialize_post_data =  maybe_unserialize( $R_custom_field_data['crp_relations_to'][0] );
						$random_blog_post = array_rand($serialize_post_data, 2);
						if(!empty($serialize_post_data)) { 
							foreach($serialize_post_data as $related_post_id => $r_post_data) { 
								if(!in_array($related_post_id, $random_blog_post)) { 
									$relate_custom_field_data = get_post_custom($related_post_id);?>
									<div class="custom-blog-related-post blog-post-list">
										<div class="blog-list-img">
											<img src="<?php echo $relate_custom_field_data['wpcf-set-featured-image'][0]; ?>" width="250px">
										</div>
										<div class="related-post-detail">
											<div class="blog-list-author">
												<h4><?php echo get_author_name($r_post_data->post_author) ?> | <?php echo human_time_diff(get_post_time('U',$r_post_data->ID), current_time('timestamp'))." ".__('ago'); ?></h4>
											</div>
											<div class="blog-list-title">
												<h3><a href="<?php echo get_post_permalink($related_post_id);?>"><?php echo strtoupper($r_post_data['title']); ?></a></h3>
											</div>
											<?php if(strlen($R_blogs_value->post_content) != 150) {
													$related_custom_post_excerpt = substr($R_blogs_value->post_content, 0, 150)."...<a href='".	get_post_permalink($related_post_id)."'><span class='keep-reading'>Keep Reading</a>";
												}
												else {
												$related_custom_post_excerpt = $R_blogs_value->post_content;
											}?>
											<div class="blog-list-desc">
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
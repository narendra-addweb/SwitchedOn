
<?php 
	/**
 * Template Name: Custom Blog Post
 */
get_header(); ?>
<style type="text/css">
	.navigation li a,
.navigation li a:hover,
.navigation li.active a,
.navigation li.disabled {
	color: #fff;
	text-decoration:none;
}

.navigation li {
	display: inline;
}

.navigation li a,
.navigation li a:hover,
.navigation li.active a,
.navigation li.disabled {
	background-color: #6FB7E9;
	border-radius: 3px;
	cursor: pointer;
	padding: 12px;
	padding: 0.75rem;
}

.navigation li a:hover,
.navigation li.active a {
	background-color: #3C8DC5;
}

</style>
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
	<div class="blog-content" style="display: inline-block;">
	<?php 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array('post_type' => 'blogs','order' => 'DESC','pagination'=> true,'posts_per_page' => '2','paged' => $paged,'post_status'=> 'publish');
		$the_query = new WP_Query( array('post_type' => 'blogs','order' => 'DESC','pagination'=> true, 'posts_per_page' => '2','paged' => $paged,'post_status'=> 'publish' )); 
		$custom_blog_post_data = get_posts($args);
	?>
	<!-- **************************Custom Blog Post Data********************************** -->
		<div class="blog-posts">
			<h2>BLOGS</h2>
			<?php 
				foreach ($custom_blog_post_data as $blogs_key => $blogs_value) {
					$custom_field_data = get_post_custom($blogs_value->ID);
					?>
					<div class="custom-blog-post">
						<h3><a href="<?php echo get_post_permalink($blogs_value->ID);?>"><?php echo strtoupper($blogs_value->post_title); ?></a></h3>
						<h4><?php echo get_author_name($blogs_value->post_author) ?> | <?php echo human_time_diff(get_post_time('U',$blogs_value->ID), current_time('timestamp'))." ".__('ago'); ?></h4>
						<img src="<?php echo $custom_field_data['wpcf-set-featured-image'][0]; ?>" width="300px">
						<?php if(strlen($custom_field_data['wpcf-excerpt'][0]) != 239) {
								$custom_post_excerpt = substr($custom_field_data['wpcf-excerpt'][0], 0, 239)."...<a href='".get_post_permalink($blogs_value->ID)."'><span class='keep-reading'>Keep Reading</span></a>";
							}
							else {
									$custom_post_excerpt = $custom_field_data['wpcf-excerpt'][0];
								}?>
						<p><?php echo  $custom_post_excerpt; ?></p>
					</div>
				<?php }
			?>
		</div>
		<!-- **************************Related Blog Post Data********************************** -->
		<div class="blog-related-post">
			<h2>RELATED BLOG</h2>
			<?php
				$chk_duplicate_key = array() ;
				// print_r($custom_blog_post_data);
				foreach ($custom_blog_post_data as $R_blogs_key => $R_blogs_value) {
					$R_custom_field_data = get_post_custom($R_blogs_value->ID);
					$serialize_post_data =  maybe_unserialize( $R_custom_field_data['crp_relations_to'][0] );
					if(!empty($serialize_post_data)) { 
						foreach($serialize_post_data as $related_post_id => $r_post_data) { 
							if(!in_array($related_post_id, $chk_duplicate_key)) { 
								$relate_custom_field_data = get_post_custom($related_post_id);?>
								<div class="custom-blog-related-post">
									<img src="<?php echo $relate_custom_field_data['wpcf-set-featured-image'][0]; ?>" width="250px">
									<h4><?php echo get_author_name($r_post_data->post_author) ?> | <?php echo human_time_diff(get_post_time('U',$r_post_data->ID), current_time('timestamp'))." ".__('ago'); ?></h4>
									<h3><a href="<?php echo get_post_permalink($related_post_id);?>"><?php echo strtoupper($r_post_data['title']); ?></a></h3>
									<?php if(strlen($relate_custom_field_data['wpcf-excerpt'][0]) != 150) {
											$related_custom_post_excerpt = substr($relate_custom_field_data['wpcf-excerpt'][0], 0, 150)."...<a href='".	get_post_permalink($related_post_id)."'><span class='keep-reading'>Keep Reading</a>";
										}
										else {
										$related_custom_post_excerpt = $relate_custom_field_data['wpcf-excerpt'][0];
									}?>
									<p><?php echo  $related_custom_post_excerpt; ?></p>
								</div><?php
				    		} $chk_duplicate_key[] =  $related_post_id; 		
						} 
					}
				} ?>
		</div>
	</div>
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
					printf( '<li>%s</li>' . "\n", get_previous_posts_link() );
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
					printf( '<li>%s</li>' . "\n", get_next_posts_link() );
				}
				echo '</ul></div>' . "\n";
			}
		?>
    </nav>
</div>
<?php get_footer(); ?>
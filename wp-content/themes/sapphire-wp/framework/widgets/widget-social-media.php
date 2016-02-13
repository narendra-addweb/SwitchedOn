<?php 



	class ewf_widget_social_media extends WP_Widget {

		function ewf_widget_social_media() {
			$widget_ops = array( 'classname' => 'ewf_widget_social_media', 'description' => __('A widget that displays social media icons designed for header top', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_social_media' );
			parent::__construct( 'ewf_widget_social_media', __('EWF - Social Media', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
		}
		


		function widget( $args, $instance ) {
			extract( $args );
			global $post;

		#	Data Validation
		#


			echo $before_widget;

			$title 	= esc_html( apply_filters('widget_title', $instance['title'] ) );
			if ( $title ) 
				echo $before_title . $title . $after_title;
			
			
			echo '<div class="fixed">';

				
				$profile_facebook = esc_url( $instance['profile_facebook'] );
				if ($profile_facebook){
					echo '<a class="facebook-icon social-icon" href="'.$profile_facebook.'"><i class="fa fa-facebook"></i></a>';
				}
				
				
				$profile_twitter = esc_url( $instance['profile_twitter'] );
				if ($profile_twitter){
					echo '<a class="twitter-icon social-icon" href="'.$profile_twitter.'"><i class="fa fa-twitter"></i></a>';
				}
				
				
				$profile_plus = esc_url( $instance['profile_plus'] );
				if ($profile_plus){
					echo '<a class="googleplus-icon social-icon" href="'.$profile_plus.'"><i class="fa fa-google-plus"></i></a>';
				}
				
				
				$profile_linkedin = esc_url( $instance['profile_linkedin'] );
				if ($profile_linkedin){
					echo '<a class="linkedin-icon social-icon" href="'.$profile_linkedin.'"><i class="fa fa-linkedin"></i></a>';
				}
				
				
				$profile_instagram = esc_url( $instance['profile_instagram'] );
				if ($profile_instagram){
					echo '<a class="instagram-icon social-icon" href="'.$profile_instagram.'"><i class="fa fa-instagram"></i></a>';
				}
				
				
				$profile_flickr	= esc_url( $instance['profile_flickr'] );
				if ($profile_flickr){
					echo '<a class="flickr-icon social-icon" href="'.$profile_flickr.'"><i class="fa fa-flickr"></i></a>';
				}
				
				
				$profile_dribbble = esc_url( $instance['profile_dribbble'] );
				if ($profile_dribbble){
					echo '<a class="dribble-icon social-icon" href="'.$profile_dribbble.'"><i class="fa fa-dribbble"></i></a>';
				}
				
				
				$profile_pinterest = esc_url( $instance['profile_pinterest'] );
				if ($profile_pinterest){
					echo '<a class="pinterest-icon social-icon" href="'.$profile_pinterest.'"><i class="fa fa-pinterest"></i></a>';
				}
				
				
				$profile_tumblr = esc_url( $instance['profile_tumblr'] );
				if ($profile_tumblr){
					echo '<a class="tumblr-icon social-icon" href="'.$profile_tumblr.'"><i class="fa fa-tumblr"></i></a>';
				}	
				
				
				$profile_youtube = esc_url( $instance['profile_youtube'] );
				if ($profile_youtube){
					echo '<a class="youtube-icon social-icon" href="'.$profile_youtube.'"><i class="fa fa-youtube"></i></a>';
				}

				
				$profile_vimeo = esc_url( $instance['profile_vimeo'] );
				if ($profile_vimeo){
					echo '<a class="vimeo-icon social-icon" href="'.$profile_vimeo.'"><i class="fa fa-vimeo-square "></i></a>';
				}
				
				
				$profile_rss = esc_url( $instance['profile_rss'] );
				if ($profile_rss){
					echo '<a class="rss-icon social-icon" href="'.$profile_rss.'"><i class="fa fa-rss"></i></a>';
				}
				
			echo '</div>';
			

			
			echo $after_widget;
		}
	 
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] 				= sanitize_text_field( $new_instance['title'] );
			$instance['profile_facebook'] 	= esc_url( $new_instance['profile_facebook'] );
			$instance['profile_twitter'] 	= esc_url( $new_instance['profile_twitter'] );
			$instance['profile_plus'] 		= esc_url( $new_instance['profile_plus'] );
			$instance['profile_linkedin'] 	= esc_url( $new_instance['profile_linkedin'] );
			$instance['profile_instagram'] 	= esc_url( $new_instance['profile_instagram'] );
			$instance['profile_flickr'] 	= esc_url( $new_instance['profile_flickr'] );
			$instance['profile_dribbble'] 	= esc_url( $new_instance['profile_dribbble'] );
			$instance['profile_pinterest'] 	= esc_url( $new_instance['profile_pinterest'] );
			$instance['profile_tumblr'] 	= esc_url( $new_instance['profile_tumblr'] );
			$instance['profile_youtube'] 	= esc_url( $new_instance['profile_youtube'] );
			$instance['profile_vimeo'] 		= esc_url( $new_instance['profile_vimeo'] );
			$instance['profile_rss'] 		= esc_url( $new_instance['profile_rss'] );


			return $instance;
		}
		 

		function form( $instance ) {
			$defaults = array( 
				'title' => null, 
				'profile_facebook' => null, 
				'profile_twitter' => null, 
				'profile_plus' => null, 
				'profile_linkedin' => null, 
				'profile_instagram' => null,
				'profile_flickr' => null, 
				'profile_dribbble' => null,
				'profile_pinterest' => null, 
				'profile_tumblr' => null,
				'profile_youtube' => null,
				'profile_vimeo' => null,
				'profile_rss' => null
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			
			?>
			
			<div class="ewf-meta">
			
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_html( $instance['title'] ); ?>" style="width:100%;" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'profile_facebook' ); ?>"><?php _e('Facebook profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_facebook' ); ?>" name="<?php echo $this->get_field_name( 'profile_facebook' ); ?>" value="<?php echo esc_url( $instance['profile_facebook'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_twitter' ); ?>"><?php _e('Twitter profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_twitter' ); ?>" name="<?php echo $this->get_field_name( 'profile_twitter' ); ?>" value="<?php echo esc_url( $instance['profile_twitter'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_plus' ); ?>"><?php _e('Google Plus profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_plus' ); ?>" name="<?php echo $this->get_field_name( 'profile_plus' ); ?>" value="<?php echo esc_url( $instance['profile_plus'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_linkedin' ); ?>"><?php _e('LinkedIn profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_linkedin' ); ?>" name="<?php echo $this->get_field_name( 'profile_linkedin' ); ?>" value="<?php echo esc_url( $instance['profile_linkedin'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_instagram' ); ?>"><?php _e('Instagram profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_instagram' ); ?>" name="<?php echo $this->get_field_name( 'profile_instagram' ); ?>" value="<?php echo esc_url( $instance['profile_instagram'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_flickr' ); ?>"><?php _e('Flickr profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_flickr' ); ?>" name="<?php echo $this->get_field_name( 'profile_flickr' ); ?>" value="<?php echo esc_url( $instance['profile_flickr'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_dribbble' ); ?>"><?php _e('Dribbble profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_dribbble' ); ?>" name="<?php echo $this->get_field_name( 'profile_dribbble' ); ?>" value="<?php echo esc_url( $instance['profile_dribbble'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_pinterest' ); ?>"><?php _e('Pinterest profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_pinterest' ); ?>" name="<?php echo $this->get_field_name( 'profile_pinterest' ); ?>" value="<?php echo esc_url( $instance['profile_pinterest'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_tumblr' ); ?>"><?php _e('Tumblr profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_tumblr' ); ?>" name="<?php echo $this->get_field_name( 'profile_tumblr' ); ?>" value="<?php echo esc_url( $instance['profile_tumblr'] ); ?>" style="width:100%;" />
				</p>			
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_youtube' ); ?>"><?php _e('YouTube profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_youtube' ); ?>" name="<?php echo $this->get_field_name( 'profile_youtube' ); ?>" value="<?php echo esc_url( $instance['profile_youtube'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_vimeo' ); ?>"><?php _e('Vimeo profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_vimeo' ); ?>" name="<?php echo $this->get_field_name( 'profile_vimeo' ); ?>" value="<?php echo esc_url( $instance['profile_vimeo'] ); ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_rss' ); ?>"><?php _e('RSS Feed URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_rss' ); ?>" name="<?php echo $this->get_field_name( 'profile_rss' ); ?>" value="<?php echo esc_url( $instance['profile_rss'] ); ?>" style="width:100%;" />
				</p>
				
			</div>
			
		<?php
		}
	}


?>
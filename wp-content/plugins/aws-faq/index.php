<?php
/*
Plugin Name: AWS Tooltip FAQ
Plugin URI: 
Description: WordPress FAQ Plugin With Tooltip
Version: 0.0.1
Author: Addweb Solution Pvt. Ltd.
Author URI: http://addwebsolution.com/
*/

/*
* Create custom Post Type FAQ... 
*/
function aws_faq_post_type() {
    $labels = array(
        'name'               => _x( 'FAQ', 'post type general name' ),
        'singular_name'      => _x( 'FAQ', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'book' ),
        'add_new_item'       => __( 'Add New FAQ' ),
        'edit_item'          => __( 'Edit FAQ' ),
        'new_item'           => __( 'New FAQ Items' ),
        'all_items'          => __( 'All FAQ\'s' ),
        'view_item'          => __( 'View FAQ' ),
        'search_items'       => __( 'Search FAQ' ),
        'not_found'          => __( 'No FAQ Items found' ),
        'not_found_in_trash' => __( 'No FAQ Items found in the Trash' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'FAQ'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds FAQ specific data',
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'query_var'     => true,
        'rewrite'       => array('slug' => 'faq'),
        'capability_type'=> 'post',
        'has_archive'   => true,
        'hierarchical'  => false,
        'menu_position' => 5,
        'supports'      => array( 'title', 'editor'),
        /*'menu_icon' => 'dashicons-welcome-write-blog'*/
        'menu_icon' => plugins_url('aws-faq/nd.png')
    );
    //Register custom post type FAQ...
    register_post_type( 'faq', $args ); 

    // Add new taxonomy, make it hierarchical (like categories)....
    $labels = array(
        'name'              => _x( 'FAQ Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'FAQ Category', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search FAQ Categories' ),
        'all_items'         => __( 'All FAQ Category' ),
        'parent_item'       => __( 'Parent FAQ Category' ),
        'parent_item_colon' => __( 'Parent FAQ Category:' ),
        'edit_item'         => __( 'Edit FAQ Category' ),
        'update_item'       => __( 'Update FAQ Category' ),
        'add_new_item'      => __( 'Add New FAQ Category' ),
        'new_item_name'     => __( 'New FAQ Category Name' ),
        'menu_name'         => __( 'FAQ Category' ),
    );
    //For categorized FAQ...
   /* register_taxonomy('faq_cat',array('faq'), array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
        'query_var'    => true,
        'rewrite'      => array( 'slug' => 'faq_cat' ),
    ));*/
}
add_action( 'init', 'aws_faq_post_type' );


/*
* This function will include style as well script...
*/
function aws_faq_enqueue_scripts(){
     if(!is_admin()){
        wp_register_style('aws-bootstrap-ui-style',plugins_url('css/bootstrap.min.css', __FILE__ ));
        wp_enqueue_style('aws-bootstrap-ui-style');
        /*
        * Register and Enqueue a Script
        * get_stylesheet_directory_uri will look up child theme location
        */
        wp_register_script( 'aws-bootstrap-script', plugins_url('/js/bootstrap.min.js', __FILE__ ), array('jquery'), false, true);
        wp_enqueue_script( 'aws-bootstrap-script' );
    }   
}
add_action( 'wp_enqueue_scripts', 'aws_faq_enqueue_scripts' );


/*
*Load tooltip script for FAQ answer...
*/
function aws_faq_tooltip_scripts() {
    ?><script type="text/javascript">

    jQuery(document).ready(function($) {
        jQuery(function () { 
            jQuery("[data-toggle='aws_tooltip']").tooltip(); 
        });
    });
    </script><?php
}
add_action( 'wp_footer', 'aws_faq_tooltip_scripts', 9999 );


/*
* Rander data while shortcode call...
*/
function aws_faq_shortcode($atts, $content= null) { 
    
    extract( shortcode_atts(
        array(
           'id' => '',
            'content'  => '',
            "cat_id" => '',
            "image" => '',
            ), $atts )
    );


    //WP_Query arguments... 
    //If no passed category id...
    if( $cat_id == '' ) :
        $args = array (
            'posts_per_page'        => -1,
            'post_type'             => 'faq',
            'p'                     => $id,
            'order' =>"DESC"
            );
    //For categorized FAQ
    else:
        $args = array (
            'posts_per_page'        => -1,
            'post_type'             => 'faq',
            'p'                     => $id,
            'tax_query' => array(
                array(
                    'taxonomy' => 'faq_cat',
                    'field'    => 'id',
                    'terms'    => array( $cat_id ),
                    ),
                ),

            'order' =>"DESC"
            );
    endif;

    //Call WP_QUERY with args...
    $query = new WP_Query( $args );

    ob_start();

    global $faq;    
    //Rander structure for FAQ question and answer...
    ?><div class="aws-faq"><?php 
        //Atleast single post...
        if( $query->have_posts() ) { 
            //Until FAQ post records exists...
            while ( $query->have_posts() ) { 
                $query->the_post();
                $strContent = get_the_content();
                $strAnswer = str_replace('<p>','', $strContent);
                $strAnswer = str_replace('</p>','',$strAnswer);
                ?><h3 class="aws_faq_question" title="<?php print $strAnswer;?>" data-toggle="aws_tooltip"><?php the_title();?></h3><?php 
            } //end while...
        } 
    ?></div><?php
    
    //Reset the query...
    wp_reset_query();
    wp_reset_postdata();
    $output = ob_get_contents(); // end output buffering...
    ob_end_clean(); // grab the buffer contents and empty the buffer...
    return $output;
}
add_shortcode('faq', 'aws_faq_shortcode');



/*
* Manage Category Shortcode Columns...
*/
add_filter("manage_faq_cat_custom_column", 'aws_faq_cat_columns', 10, 3);
add_filter("manage_edit-faq_cat_columns", 'aws_faq_cat_manage_columns'); 
function aws_faq_cat_manage_columns($theme_columns) {
    $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Name'),
            'faq_category_shortcode' => __( 'Category Shortcode', 'awsfaq' ),
            'slug' => __('Slug'),
            'posts' => __('Posts')
        );
    return $new_columns;
}

/*
* Manage Category Shortcode Columns...
*/
function aws_faq_cat_columns($out, $column_name, $theme_id) {
    $theme = get_term($theme_id, 'faq_cat');
    switch ($column_name) {
        
        case 'title':
            echo get_the_title();
        break;

        case 'faq_category_shortcode':             
             echo '[faq cat_id="' . $theme_id. '"]';
        break;
 
        default:
            break;
    }
    return $out;    
}


/*
* Add button with default editor...
*/
add_action('admin_head', 'aws_faq_tinymce_button');
function aws_faq_tinymce_button() {
    global $typenow;
    
    // check user permissions...
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    
    // verify the post type...
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;

    // check if WYSIWYG is enabled...
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "aws_faq_tinymce_plugin");
        add_filter('mce_buttons', 'aws_faq_register_tinymce_button');
    }
}

/*
* This function will retuen array for button...
*/
function aws_faq_tinymce_plugin($plugin_array) {
    $plugin_array['awsfaq_faq_button'] = plugins_url( '/js/editor-button.js', __FILE__ ); 
    return $plugin_array;
}


/*
* This function will return FAQ button
*/
function aws_faq_register_tinymce_button($buttons) {
   array_push($buttons, "awsfaq_faq_button");
   return $buttons;
}


/*
* Add custom style for FAQ button...
*/
function admin_inline_js(){ ?>
    <style>
        i.mce-ico.mce-i-faq-icon {
            background-image: url('<?php echo  plugins_url( 'aws_faq.png', __FILE__ );?>');
        }
    </style><?php 
}
add_action( 'admin_print_scripts', 'admin_inline_js' );


/*
* Custom FAQ Settings Fields...
*/

//add_action('admin_menu', 'aws_faq_options');
//add_action('admin_init', 'aws_faq_settings_store');

/*
* Add options page...
*/
function aws_faq_options() {
    add_submenu_page( 'edit.php?post_type=faq', esc_html__('Addweb FAQ Admin Options', 'awsfaq'), esc_html__('FAQ Settings', 'awsfaq'), 'edit_posts', 'faq_options', 'aws_faq_setting_functions');

   register_setting( 'faq_settings', 'plugin_options' );
}

/*
* Register Settings Page...
*/
function aws_faq_settings_store() {
    register_setting('awsfaq_faq_settings', 'awsfaq_faq_collapse');   
}

/*
* This page will rander admin option page content...
*/
function aws_faq_setting_functions(){
    ?><div class="wrap">
        <div class="icon32" id="icon-options-general"><br></div>
        <h2><?php echo esc_html__('Addweb FAQ Settings', 'awsfaq');?></h2>
        <p><?php echo esc_html__('Settings sections for Addweb FAQ Options', 'awsfaq');?></p>
        <form method="post" action="options.php">
            <?php settings_fields('awsfaq_faq_settings'); ?>
            <table class="form-table">       
                <tr>
                    <th>
                        <label><?php echo esc_html__('Collapse/Toggle Options', 'awsfaq');?></label>
                    </th>
                    <td><?php 
                        $options = get_option('awsfaq_faq_collapse');
                        $items = array("Close All", "Open All","1st Item Open");
                        echo "<select id='layout' name='awsfaq_faq_collapse[layout]'>";
                        foreach($items as $item) {
                            $selected = ($options['layout']==$item) ? 'selected="selected"' : '';
                            echo "<option value='$item' $selected>$item</option>";
                        }
                        echo "</select>";
                    ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" class="button-primary" value="Save Changes" />
                    </td>
                </tr>
            </table>
        </form>
    </div><?php
}

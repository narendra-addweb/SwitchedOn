<?php
function crp_admin_premium_not_installed()
{
    return !CustomRelatedPosts::is_premium_active();
}

function crp_admin_premium_installed()
{
    return CustomRelatedPosts::is_premium_active();
}

function crp_admin_post_types()
{
    $post_types = get_post_types( '', 'names' );
    $types = array();

    foreach( $post_types as $post_type ) {
        $types[] = array(
            'value' => $post_type,
            'label' => ucfirst( $post_type )
        );
    }

    return $types;
}

function crp_admin_import_xml()
{
    $example = '<a href="' . CustomRelatedPosts::get()->coreUrl . '/static/relations.xml" target="_blank">' . __( 'Example XML file', 'custom-related-posts' ) . '</a>';
    return '<a href="'.admin_url( 'options-general.php?page=crp_import_xml' ).'" class="button button-primary" target="_blank">'.__('Import XML', 'custom-related-posts').'</a><br/>' . $example;
}

VP_Security::instance()->whitelist_function( 'crp_admin_premium_not_installed' );
VP_Security::instance()->whitelist_function( 'crp_admin_premium_installed' );
VP_Security::instance()->whitelist_function( 'crp_admin_post_types' );
VP_Security::instance()->whitelist_function( 'crp_admin_import_xml' );
<?php

// Include part of site URL hash in HTML settings to update when site URL changes
$sitehash = substr( md5( CustomRelatedPosts::get()->coreUrl ), 0, 8 );

$admin_menu = array(
    'title' => 'Custom Related Posts ' . __('Settings', 'custom-related-posts'),
    'logo'  => CustomRelatedPosts::get()->coreUrl . '/img/logo.png',
    'menus' => array(
//=-=-=-=-=-=-= GENERAL =-=-=-=-=-=-=
	    array(
		    'title' => __('General', 'custom-related-posts'),
		    'name' => 'general',
		    'icon' => 'font-awesome:fa-link',
		    'controls' => array(
			    array(
				    'type' => 'section',
				    'title' => __('Post Types', 'custom-related-posts'),
				    'name' => 'general_section_post_types',
				    'fields' => array(
					    array(
						    'type' => 'multiselect',
						    'name' => 'general_post_types',
						    'label' => __('Post Types', 'custom-related-posts'),
						    'description' => __( 'Which post types do you want to enable the Related Posts for?', 'custom-related-posts' ),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'function',
									    'value' => 'crp_admin_post_types',
								    ),
							    ),
						    ),
						    'default' => array(
							    'post',
							    'page',
						    ),
					    ),
				    ),
			    ),
                array(
                    'type' => 'section',
                    'title' => __('Search', 'custom-related-posts'),
                    'name' => 'general_section_search',
                    'fields' => array(
                        array(
                            'type' => 'slider',
                            'name' => 'search_number_of_posts',
                            'label' => __('Number of Posts', 'custom-related-posts'),
                            'min' => '1',
                            'max' => '100',
                            'step' => '1',
                            'default' => '15',
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'search_post_status',
                            'label' => __('Post Status', 'custom-related-posts'),
                            'items' => array(
                                array(
                                    'value' => 'any',
                                    'label' => __('Any', 'custom-related-posts'),
                                ),
                                array(
                                    'value' => 'publish',
                                    'label' => __('Published only', 'custom-related-posts'),
                                ),
                            ),
                            'default' => array(
                                'any',
                            ),
                            'validation' => 'required',
                        ),
                    ),
                ),
		    ),
	    ),
//=-=-=-=-=-=-= IMPORT RELATIONS =-=-=-=-=-=-=
        array(
            'title' => __('Import Relations', 'custom-related-posts'),
            'name' => 'import_relations',
            'icon' => 'font-awesome:fa-upload',
            'controls' => array(
                array(
                    'type' => 'section',
                    'title' => __('Import From', 'custom-related-posts'),
                    'name' => 'secion_import_relations_from',
                    'fields' => array(
                        array(
                            'type' => 'html',
                            'name' => 'import_relations_xml_example' . $sitehash,
                            'binding' => array(
                                'field'    => '',
                                'function' => 'crp_admin_import_xml',
                            ),
                        ),
                    ),
                ),
            ),
        ),
//=-=-=-=-=-=-= ADVANCED =-=-=-=-=-=-=
        array(
            'title' => __('Advanced', 'custom-related-posts'),
            'name' => 'advanced',
            'icon' => 'font-awesome:fa-wrench',
            'controls' => array(
                array(
                    'type' => 'section',
                    'title' => __('Assets', 'custom-related-posts'),
                    'name' => 'advanced_section_assets',
                    'fields' => array(
                        array(
                            'type' => 'toggle',
                            'name' => 'assets_use_cache',
                            'label' => __('Cache Assets', 'custom-related-posts'),
                            'description' => __( 'Disable this while developing.', 'custom-related-posts' ),
                            'default' => '1',
                        ),
                    ),
                ),
            ),
        ),
//=-=-=-=-=-=-= CUSTOM CODE =-=-=-=-=-=-=
        array(
            'title' => __('Custom Code', 'custom-related-posts'),
            'name' => 'custom_code',
            'icon' => 'font-awesome:fa-code',
            'controls' => array(
                array(
                    'type' => 'codeeditor',
                    'name' => 'custom_code_public_css',
                    'label' => __('Public CSS', 'custom-related-posts'),
                    'theme' => 'github',
                    'mode' => 'css',
                ),
            ),
        ),
//=-=-=-=-=-=-= FAQ & SUPPORT =-=-=-=-=-=-=
        array(
            'title' => __('FAQ & Support', 'custom-related-posts'),
            'name' => 'faq_support',
            'icon' => 'font-awesome:fa-book',
            'controls' => array(
                array(
                    'type' => 'notebox',
                    'name' => 'faq_support_notebox',
                    'label' => __('Need more help?', 'custom-related-posts'),
                    'description' => '<a href="mailto:support@bootstrapped.ventures" target="_blank">Custom Related Posts ' .__('FAQ & Support', 'custom-related-posts') . '</a>',
                    'status' => 'info',
                ),
            ),
        ),
    ),
);
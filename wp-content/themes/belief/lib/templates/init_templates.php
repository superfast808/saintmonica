<?php
update_option( 'templates', array(
    'mainpage123' => array(
        'name' => __( 'Mainpage', 'cosmotheme' ),
        'id' => 'mainpage123',
        '_header_rows' => array(
            'delimiter_top' => array(
                'id' => 'delimiter_top123',
                'row_bottom_margin_removed' => 'yes',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'delimiter_top123',
                        'delimiter_margin' => 'margin_30px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'logo_sicons_search' => array (
                    'id' => 'logo_big',
                    'row_bottom_margin_removed' => 'yes',
                    '_elements' =>
                    array (
                       'the_logo' => array (
                            'id' => 'delimiter_top123',
                            'element_columns' => '4',
                            'type' => 'logo',
                            'vertical_align' => 'top',
                          ),
                       'socialicons12' =>array (
                            'id' => 'social_header',
                            'element_columns' => '4',
                            'type' => 'socialicons',
                            'text_align' => 'right',
                            'vertical_align' => 'middle',
                          ),
                       'searchbar32' =>array (
                            'id' => 'search_header',
                            'element_columns' => '4',
                            'type' => 'searchbar',
                            'text_align' => 'center',
                            'vertical_align' => 'middle',
                          ),
                    ),
                ),
            'delimiter_15px' => array(
                'id' => 'delimiter_first123',
                '_elements' => array(
                    'delimiter_top' => array(
                        'id' => 'delimiter_first123',
                        'delimiter_margin' => 'margin_15px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'mainmenu' => array(
                'id' => 'topmenu123',
                'row_bottom_margin_removed' => 'no',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'topmenu123',
                        'type' => 'menu',
                        'main_menustyles' => 'with_description',
                        'element_columns' => 12,
                        'numberposts' => 10
                    )
                )
            ),
            
        ),
        '_rows' => array(
            'latest' => array(
                'id' => 'default1',
                'is_additional' => 0,
                '_elements' => array(
                    'latest' => array(
                        'id' => 'latest',
                        'name' => __('Grid view sample','cosmotheme'),
                        'type' => 'latest',
                        'view' => 'grid_view',
                        'numberposts' => 12,
                        'enb_masonry' => 'yes',
                        'behaviour' => 'pagination'
                    )
                )
            ),
            'additional' => array(
                'id' => 'additional',
                'is_additional' => 1,
                '_elements' => array(
                    'default' => array(
                        'id' => 'default'
                    )
                )
            )
        ),
        '_footer_rows' => array(
            'delimiter_6545' => array(
                'id' => 'delimiter_top123',
                'row_bottom_margin_removed' => 'yes',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'delimiter_top123',
                        'delimiter_margin' => 'margin_30px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'widgets' => array(
                'id' => 'widgets',
                '_elements' => array(
                    'sidebar_1' => array(
                        'id' => '1360858203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-first',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_2' => array(
                        'id' => '13608582034136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-second',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_3' => array(
                        'id' => '13608658203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-third',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_4' => array(
                        'id' => '13608578203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-fourth',
                        'type' => 'widget_zone',
                    ),
                )
            ),
            'delimiter12323' => array(
                'id' => 'delimiter123',
                'row_bottom_margin_removed' => 'no',
                '_elements' => array(
                    'delimiter123' => array(
                        'id' => 'delimiter44',
                        'type' => 'delimiter',
                        'delimiter_margin' => 'margin_30px',
                        'delimiter_type' => 'line',
                        'delimiter_text_color' => '#272a32',
                        'element_columns' => 12
                    )
                )
            ),
            'copyright' => array(
                'id' => 'copyright',
                '_elements' => array(
                    'copyright' => array(
                        'id' => 'copyright',
                        'type' => 'copyright',
                        'element_columns' => 6
                    ),
                    'social_footer' => array(
                        'id' => 'social_footer',
                        'type' => 'socialicons',
                        'element_columns' => 6,
                        'text_align' => 'right',
                    )
                )
            )
        )
    ),

    'default123' => array(
        'name' => __( 'Default', 'cosmotheme' ),
        'id' => 'default123',
        '_header_rows' => array(

            'delimiter_top' => array(
                'id' => 'delimiter_top123',
                'row_bottom_margin_removed' => 'yes',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'delimiter_top123',
                        'delimiter_margin' => 'margin_30px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'logo_sicons_search' => array (
                    'id' => 'logo_big',
                    'row_bottom_margin_removed' => 'yes',
                    '_elements' =>
                    array (
                       'the_logo' => array (
                            'id' => 'delimiter_top123',
                            'element_columns' => '4',
                            'type' => 'logo',
                            'vertical_align' => 'top',
                          ),
                       'socialicons12' =>array (
                            'id' => 'social_header',
                            'element_columns' => '4',
                            'type' => 'socialicons',
                            'text_align' => 'right',
                            'vertical_align' => 'middle',
                          ),
                       'searchbar32' =>array (
                            'id' => 'search_header',
                            'element_columns' => '4',
                            'type' => 'searchbar',
                            'text_align' => 'center',
                            'vertical_align' => 'middle',
                          ),
                    ),
                ),
            'delimiter_15px' => array(
                'id' => 'delimiter_first123',
                '_elements' => array(
                    'delimiter_top' => array(
                        'id' => 'delimiter_first123',
                        'delimiter_margin' => 'margin_15px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'mainmenu' => array(
                'id' => 'topmenu123',
                'row_bottom_margin_removed' => 'no',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'topmenu123',
                        'type' => 'menu',
                        'main_menustyles' => 'with_description',
                        'element_columns' => 12,
                        'numberposts' => 10
                    )
                )
            ),
        ),
        '_rows' => array(
            'additional' => array(
                'id' => 'additional',
                'is_additional' => 1,
                '_elements' => array(
                    'default' => array(
                        'id' => 'default',
                        'behaviour' => 'pagination'

                    )
                )
            )
        ),
        '_footer_rows' => array(
            'delimiter_6545' => array(
                'id' => 'delimiter_top123',
                'row_bottom_margin_removed' => 'yes',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'delimiter_top123',
                        'delimiter_margin' => 'margin_30px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'widgets' => array(
                'id' => 'widgets',
                '_elements' => array(
                    'sidebar_1' => array(
                        'id' => '1360858203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-first',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_2' => array(
                        'id' => '13608582034136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-second',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_3' => array(
                        'id' => '13608658203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-third',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_4' => array(
                        'id' => '13608578203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-fourth',
                        'type' => 'widget_zone',
                    ),
                )
            ),
            'delimiter12323' => array(
                'id' => 'delimiter123',
                'row_bottom_margin_removed' => 'no',
                '_elements' => array(
                    'delimiter123' => array(
                        'id' => 'delimiter44',
                        'type' => 'delimiter',
                        'delimiter_margin' => 'margin_30px',
                        'delimiter_type' => 'line',
                        'delimiter_text_color' => '#272a32',
                        'element_columns' => 12
                    )
                )
            ),
            'copyright' => array(
                'id' => 'copyright',
                '_elements' => array(
                    'copyright' => array(
                        'id' => 'copyright',
                        'type' => 'copyright',
                        'element_columns' => 6
                    ),
                    'social_footer' => array(
                        'id' => 'social_footer',
                        'type' => 'socialicons',
                        'element_columns' => 6,
                        'text_align' => 'right',
                    )
                )
            )
        )
           
    ),

    'posts123' => array(
        'name' => __( 'Posts', 'cosmotheme' ),
        'id' => 'posts123',
        '_header_rows' => array(

            'delimiter_top' => array(
                'id' => 'delimiter_top123',
                'row_bottom_margin_removed' => 'yes',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'delimiter_top123',
                        'delimiter_margin' => 'margin_30px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'logo_sicons_search' => array (
                    'id' => 'logo_big',
                    'row_bottom_margin_removed' => 'yes',
                    '_elements' =>
                    array (
                       'the_logo' => array (
                            'id' => 'delimiter_top123',
                            'element_columns' => '4',
                            'type' => 'logo',
                            'vertical_align' => 'top',
                          ),
                       'socialicons12' =>array (
                            'id' => 'social_header',
                            'element_columns' => '4',
                            'type' => 'socialicons',
                            'text_align' => 'right',
                            'vertical_align' => 'middle',
                          ),
                       'searchbar32' =>array (
                            'id' => 'search_header',
                            'element_columns' => '4',
                            'type' => 'searchbar',
                            'text_align' => 'center',
                            'vertical_align' => 'middle',
                          ),
                    ),
                ),
            'delimiter_15px' => array(
                'id' => 'delimiter_first123',
                '_elements' => array(
                    'delimiter_top' => array(
                        'id' => 'delimiter_first123',
                        'delimiter_margin' => 'margin_15px',
                        'type' => 'delimiter'
                    )
                )
            ),
            'mainmenu' => array(
                'id' => 'topmenu123',
                'row_bottom_margin_removed' => 'no',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'topmenu123',
                        'type' => 'menu',
                        'main_menustyles' => 'with_description',
                        'element_columns' => 12,
                        'numberposts' => 10
                    )
                )
            ),
        ),
        '_rows' => array(
            'additional' => array(
                'id' => 'additional',
                'is_additional' => 1,
                '_elements' => array(
                    'default' => array(
                        'id' => 'default',
                        'behaviour' => 'pagination'
                    )
                )
            )
        ),
        '_footer_rows' => array(
            'delimiter_6545' => array(
                'id' => 'delimiter_top123',
                'row_bottom_margin_removed' => 'yes',
                '_elements' => array(
                    
                    'delimiter_top' => array(
                        'id' => 'delimiter_top123',
                        'delimiter_margin' => 'margin_30px',
                        'type' => 'delimiter'
                    )
                )
            ),
            
            'widgets' => array(
                'id' => 'widgets',
                '_elements' => array(
                    'sidebar_1' => array(
                        'id' => '1360858203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-first',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_2' => array(
                        'id' => '13608582034136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-second',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_3' => array(
                        'id' => '13608658203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-third',
                        'type' => 'widget_zone',
                    ),
                    'sidebar_4' => array(
                        'id' => '13608578203136',
                        'element_columns' => '3',
                        'sidebar' => 'footer-fourth',
                        'type' => 'widget_zone',
                    ),
                )
            ),
            'delimiter12323' => array(
                'id' => 'delimiter123',
                'row_bottom_margin_removed' => 'no',
                '_elements' => array(
                    'delimiter123' => array(
                        'id' => 'delimiter44',
                        'type' => 'delimiter',
                        'delimiter_margin' => 'margin_30px',
                        'delimiter_type' => 'line',
                        'delimiter_text_color' => '#272a32',
                        'element_columns' => 12
                    )
                )
            ),
            'copyright' => array(
                'id' => 'copyright',
                '_elements' => array(
                    'copyright' => array(
                        'id' => 'copyright',
                        'type' => 'copyright',
                        'element_columns' => 6
                    ),
                    'social_footer' => array(
                        'id' => 'social_footer',
                        'type' => 'socialicons',
                        'element_columns' => 6,
                        'text_align' => 'right',
                    )
                )
            )
        )
    )
));

update_option( 'front_page_layout', array(
                'layout_type' => 'full_width',
                'elements' => array(
                    'first' => array(
                'id' => 'first',
                'columns' => 3,
                'disabled' => true,
                'sidebar' => 'main'
            ),
            'main' => array(
                'id' => 'main',
                'columns' => 12,
                'disabled' => false
            ),
            'second' => array(
                'id' => 'second',
                'columns' => 3,
                'disabled' => true,
                'sidebar' => 'main'
            )
        ),
        'template' => 'mainpage123'
    )
);

$archive_layout = array(
    'layout_type' => 'full_width',
    'elements' => array(
        'first' => array(
            'id' => 'first',
            'columns' => 3,
            'disabled' => true,
            'sidebar' => 'main'
        ),
        'main' => array(
            'id' => 'main',
            'columns' => 12,
            'disabled' => false
        ),
        'second' => array(
            'id' => 'second',
            'columns' => 3,
            'disabled' => true,
            'sidebar' => 'main'
        )
    ),
    'template' => 'default123'
);

update_option('archive_layout', $archive_layout);
update_option('archive_format_layout', $archive_layout);
update_option('archive_post_type_layout', $archive_layout);
update_option('author_layout', $archive_layout);
update_option('category_layout', $archive_layout);
update_option('index_layout', $archive_layout);
update_option('tag_layout', $archive_layout);
update_option('search_layout', $archive_layout);
update_option('404_layout', $archive_layout);
update_option('attachment_layout', $archive_layout);
update_option('event_category_layout', $archive_layout);



/*-------------------*/
$posts_layout = array(
    'layout_type' => 'one_right_sidebar',
    'elements' => array(
        'first' => array(
            'id' => 'first',
            'columns' => 3,
            'disabled' => true,
            'sidebar' => 'main'
        ),
        'main' => array(
            'id' => 'main',
            'columns' => 9,
            'disabled' => false
        ),
        'second' => array(
            'id' => 'second',
            'columns' => 3,
            'disabled' => false,
            'sidebar' => 'main'
        )
    ),
    'template' => 'posts123'
);


update_option('single_layout', $posts_layout);
update_option('page_layout', $posts_layout);
update_option('event_layout', $posts_layout);
/*Fix for cache ------------------- */
$builder = new LBTemplateBuilder();
$builder->load_all();

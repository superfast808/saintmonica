<?php
    /* register pages */
	
    $current_theme_name = wp_get_theme();
    

    options::$menu[ 'cosmothemes' ][ 'general' ]        = array( 'label' => __( 'General' , 'cosmotheme' ) , 'title' => __( 'General settings' , 'cosmotheme' ) , 'description' => __( 'General page description.' , 'cosmotheme' ) , 'type' => 'main' , 'main_label' => $current_theme_name );
        options::$menu[ 'cosmothemes' ][ 'settings' ]       = array( 'label' => __( 'Settings', 'cosmotheme' ), 'title' => __( 'Setttings', 'cosmotheme' ), 'description' => __( 'General theme settings', 'cosmotheme' ) );
            //options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'welcome' ] = array( 'label' => __( 'Welcome' , 'cosmotheme' ) , 'title' => __( 'Welcome' , 'cosmotheme' ), 'update' => false );
            options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'general' ] = array( 'label' => __( 'General' , 'cosmotheme' ) , 'title' => __( 'General settings' , 'cosmotheme' ) , 'description' => '' );
            options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'styling' ] = array( 'label' => __( 'Styling' , 'cosmotheme' )  , 'title' => __( 'Styling settings' , 'cosmotheme' )  , 'description' => __( 'The basic layout structure for color and background effects' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'typography' ] = array( 'label' => __( 'Typography' , 'cosmotheme' )  , 'title' => __( 'Typography settings' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'likes' ] = array( 'label' => __( 'Likes' , 'cosmotheme' ) , 'title' => __( 'Likes settings' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'blog_post' ] = array( 'label' => __( 'Post settings' , 'cosmotheme' ) , 'title' => __( 'Post settings' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'social' ] = array( 'label' => __( 'Social' , 'cosmotheme' ) , 'title' => __( 'Social' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'settings' ][ 'contains' ][ 'tooltips' ] = array( 'label' => __( 'Tooltips' , 'cosmotheme' )  , 'title' => __( 'Tooltips manager' , 'cosmotheme' ) );
        options::$menu[ 'cosmothemes' ][ 'templates' ]      = array( 'label' => __( 'Templates', 'cosmotheme' ), 'title' => __( 'Templates', 'cosmotheme' ), 'description' => __( 'Templates settings', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'mainpage' ] = array( 'label' => __( 'Main page' , 'cosmotheme' )  , 'title' => __( 'Main page' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'blogpage' ] = array( 'label' => __( 'Blog page' , 'cosmotheme' )  , 'title' => __( 'Blog page' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'archive' ] = array( 'label' => __( 'Archive' , 'cosmotheme' )  , 'title' => __( 'Archive' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'category' ] = array( 'label' => __( 'Category' , 'cosmotheme' )  , 'title' => __( 'Category' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'searchpage' ] = array( 'label' => __( 'Search results' , 'cosmotheme' )  , 'title' => __( 'Search results' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'tag' ] = array( 'label' => __( 'Tag listing' , 'cosmotheme' )  , 'title' => __( 'Tag listing' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'author' ] = array( 'label' => __( 'Author posts' , 'cosmotheme' )  , 'title' => __( 'Author posts' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ '404' ] = array( 'label' => __( '404' , 'cosmotheme' )  , 'title' => __( '404' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'single' ] = array( 'label' => __( 'Single page' , 'cosmotheme' )  , 'title' => __( 'Single page' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'templates' ][ 'contains' ][ 'page' ] = array( 'label' => __( 'Page' , 'cosmotheme' )  , 'title' => __( 'Page' , 'cosmotheme' ) );

        options::$menu[ 'cosmothemes' ][ 'layouts' ] = array( 'label' => __( 'Layouts', 'cosmotheme' ), 'title' => __( 'Layouts', 'cosmotheme' ), 'description' => __( 'Layouts', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ '404_layout' ] = array( 'label' => __( '404', 'cosmotheme' ), 'title' => __( '404', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'archive_layout' ] = array( 'label' => __( 'Archives by date', 'cosmotheme' ), 'title' => __( 'Archive', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'archive_format_layout' ] = array( 'label' => __( 'Post format archive', 'cosmotheme' ), 'title' => __( 'Post format archive', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'archive_post_type_layout' ] = array( 'label' => __( 'Post type archive', 'cosmotheme' ), 'title' => __( 'Post type archive', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'attachment_layout' ] = array( 'label' => __( 'Attachment', 'cosmotheme' ), 'title' => __( 'Attachment', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'author_layout' ] = array( 'label' => __( 'Author archives', 'cosmotheme' ), 'title' => __( 'Author archives', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'category_layout' ] = array( 'label' => __( 'Categories', 'cosmotheme' ), 'title' => __( 'Categories', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'event_category_layout' ] = array( 'label' => __( 'Event categories', 'cosmotheme' ), 'title' => __( 'Event categories', 'cosmotheme' ) );            
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'front_page_layout' ] = array( 'label' => __( 'Front page', 'cosmotheme' ), 'title' => __( 'Front page', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'index_layout' ] = array( 'label' => __( 'Index', 'cosmotheme' ), 'title' => __( 'Index', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'tag_layout' ] = array( 'label' => __( 'Tags', 'cosmotheme' ), 'title' => __( 'Tags', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'search_layout' ] = array( 'label' => __( 'Search', 'cosmotheme' ), 'title' => __( 'Search', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'page_layout' ] = array( 'label' => __( 'Pages', 'cosmotheme' ), 'title' => __( 'Pages', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'single_layout' ] = array( 'label' => __( 'Posts', 'cosmotheme' ), 'title' => __( 'Posts', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'layouts' ][ 'contains' ][ 'event_layout' ] = array( 'label' => __( 'Events', 'cosmotheme' ), 'title' => __( 'Events', 'cosmotheme' ) );

        options::$menu[ 'cosmothemes' ][ 'extra' ]          = array( 'label' => __( 'Extra', 'cosmotheme' ), 'title' => __( 'Extra', 'cosmotheme' ), 'description' => __( 'Extra settings', 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'extra' ][ 'contains' ][ '_sidebar' ] = array( 'label' => __( 'Sidebars' , 'cosmotheme' )  , 'title' => __( 'Sidebar manager' , 'cosmotheme' ), 'update' => false );
            options::$menu[ 'cosmothemes' ][ 'extra' ][ 'contains' ][ 'custom_css' ] = array( 'label' => __( 'Custom CSS' , 'cosmotheme' )  , 'title' => __( 'Custom CSS' , 'cosmotheme' ) , 'update' => true );
            options::$menu[ 'cosmothemes' ][ 'extra' ][ 'contains' ][ 'cosmothemes' ] = array( 'label' => __( 'Notifications' , 'cosmotheme' )  , 'title' => __( 'Notifications' , 'cosmotheme' ) );
            options::$menu[ 'cosmothemes' ][ 'extra' ][ 'contains' ][ 'io' ] = array( 'label' => __( 'Import / Export' , 'cosmotheme' )  , 'title' => __( 'Import/Export' , 'cosmotheme' ) );
            //options::$menu[ 'cosmothemes' ][ 'extra' ][ 'contains' ][ 'themes' ] = array( 'label' => __( 'Themes' , 'cosmotheme' )  , 'title' => __( 'Themes' , 'cosmotheme' ), 'update' => false );

    /*
        options::$menu['cosmothemes']['menu']               = array( 'label' => __( 'Menus' , 'cosmotheme' )  , 'title' => __( 'Menu settings' , 'cosmotheme' )  , 'description' => __( 'Menu page description.' , 'cosmotheme' ) );
    */;


    options::$fields[ 'mainpage' ][ 'mainpage' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'blogpage' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'archive' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'category' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'searchpage' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'tag' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'author' ][ 'mainpage' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ '404' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'single' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );
    options::$fields[ 'page' ][ 'builder' ] = array( 'type' => 'no--layout-builder' );

    /* OPTIONS */
    /* GENERAL DEFAULT VALUE */
    options::$default['likes']['enb_likes']             = 'yes';
    options::$default['likes']['min_likes']             =  50;
    //options::$default[ 'likes' ][ 'icons' ]             = 'heart';
    options::$default[ 'likes' ][ 'show_count' ]        = 'yes';
//    options::$default[ 'likes' ][ 'label' ]        = __('Like','cosmotheme');
    options::$default['general']['user_register']       = 'yes';
    
    options::$default['general']['time']                = 'yes';
    options::$default['general']['fb_comments']         = 'no';
	options::$default['general']['show_admin_bar']      = 'yes';

    /* GENERAL OPTIONS */
    
    options::$fields['general']['time']                 = array( 'type' => 'st--logic-radio' , 'label' => __( 'Use human time' , 'cosmotheme') ,  'hint' => __( 'If set No will use WordPress time format'  , 'cosmotheme' ) );
    options::$fields['general']['fb_comments']          = array( 'type' => 'st--logic-radio' , 'label' => __( 'Use Facebook comments' , 'cosmotheme' ), 'action' => "act.check( this , { 'yes' : '.fb_app_id ' , 'no' : '' } , 'sh' );" );
	options::$fields['general']['fb_app_id_note']       = array( 'type' => 'st--hint' , 'value' => __( 'You can set Facebook application ID' , 'cosmotheme' ) . ' <a href="admin.php?page=cosmothemes__settings&tab=social">' . __( 'here' , 'cosmotheme') . '</a> ' );
	options::$fields['general']['show_admin_bar']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show WordPress admin bar' , 'cosmotheme' ));

	
	if( options::logic( 'general' , 'fb_comments' ) ){
        options::$fields['general']['fb_app_id_note']['classes']     = 'fb_app_id';
    }else{
        options::$fields['general']['fb_app_id_note']['classes']     = 'fb_app_id hidden';
    }

    options::$fields['general']['tracking_code']        = array('type' => 'st--textarea' , 'label' => __( 'Tracking code' , 'cosmotheme' ) , 'hint' => __( 'Paste your Google Analytics or other tracking code here.<br />It will be added into the footer of this theme' , 'cosmotheme' ) );
    options::$fields['general']['copy_right']   	    = array('type' => 'st--textarea' , 'label' => __( 'Copyright text' , 'cosmotheme' ) , 'hint' => __( 'Type here the Copyright text that will appear in the footer.<br />To display the current year use "%year%"' , 'cosmotheme' ) );
    
    options::$default['general']['copy_right'] 			= 'Copyright &copy; %year% <a href="http://cosmothemes.com" target="_blank">CosmoThemes</a>. All rights reserved.';


    /*LIKES OPTIONS*/
    options::$fields['likes']['enb_likes']            = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable Likes for posts' , 'cosmotheme') , 'action' => "act.check( this , { 'yes' : '.g_like , .g_l_register' , 'no' : '' } , 'sh' );" , 'iclasses' => 'g_e_likes');
    options::$fields['likes']['min_likes']            = array( 'type' => 'st--digit-like' , 'label' => __( 'Minimum number of Likes to set Featured' , 'cosmotheme' ) , 'hint' => __( 'Set minimum number of post likes to change it into a featured post' , 'cosmotheme' ) , 'id' => 'nr_min_likes' ,'action' => "act.min_likes(  jQuery( '#nr_min_likes').val() , 1 );"  );
    options::$fields['likes']['sim_likes']            = array( 'type' => 'st--button' , 'value' => __( 'Generate' , 'cosmotheme' ) , 'label' => __( 'Generate random number of Likes for posts' , 'cosmotheme' ) , 'action' => "act.sim_likes( 1 );" , 'hint' => __( 'WARNING! This will reset all current Loves.' , 'cosmotheme' ) );
    options::$fields['likes']['reset_likes']          = array( 'type' => 'st--button' , 'value' => __( 'Reset' , 'cosmotheme' ) , 'label' => __( 'Reset Likes' , 'cosmotheme' ) , 'action' =>"act.reset_likes(1);" , 'hint' => __( 'WARNING! This will reset all the likes for all the posts!', 'cosmotheme'  ) );
    options::$fields['likes'][ 'show_count' ]         = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show votes count?' , 'cosmotheme') );
/*    options::$fields['likes'][ 'icons' ]            = array(
        'type' => 'st--preview-select', 'value' => array(
            'heart' => __( 'Heart', 'cosmotheme' ),
            'star' => __( 'Star', 'cosmotheme' ),
            'thumb' => __( 'Thumb', 'cosmotheme' )
        ),
        'label' => __( 'Icon style', 'cosmotheme' ),
        'action' => 'act.preview_select( this );',
        'hint' => __( 'You may choose between a heart, a star or a thumb up for "like it" icon','cosmotheme' )
    );*/

/*    options::$fields['likes'][ 'label' ]            = array(
        'type' => 'st--text', 
        'label' => __( 'Label for votes', 'cosmotheme' ),
        'hint' => __( 'This is used on single post page.','cosmotheme' )
    );*/
    
    if( options::logic( 'likes' , 'enb_likes' ) ){
        options::$fields['likes']['min_likes']['classes']     = 'g_like';
        options::$fields['general']['like_register']['classes'] = 'g_l_register';
        options::$fields['likes']['sim_likes']['classes']     = 'g_like generate_likes';
        options::$fields['likes']['reset_likes']['classes']   = 'g_like reset_likes';
        //options::$fields[ 'likes' ][ 'icons' ][ 'classes' ]   = 'like_icon';
    }else{
        options::$fields['likes']['min_likes']['classes']     = 'g_like hidden';
        options::$fields['general']['like_register']['classes'] = 'g_l_register hidden';
        options::$fields['likes']['sim_likes']['classes']     = 'g_like generate_likes hidden';
        options::$fields['likes']['reset_likes']['classes']   = 'g_like reset_likes hidden';
        //options::$fields[ 'likes' ][ 'icons' ][ 'classes' ]   = 'like_icon hidden';
    }

  	/*Front end tabs settings*/
	$subcategories = get_categories( array( 'hide_empty' => false ) );
    $select_subcategories = array();
    $all_categ = array();
    foreach( $subcategories as $subcategory ){
        $select_subcategories[ $subcategory -> cat_ID ] = $subcategory -> name;
        $all_categ[] = $subcategory -> cat_ID;
    }

    
    /* LAYOUT DEFAULT VALUE */
    options::$default['layout']['front_page']           = 'right';
    options::$default['layout']['v_front_page']         = 'list_view';
    options::$default['layout']['404']                  = 'right';
    options::$default['layout']['author']               = 'right';
    options::$default['layout']['v_author']             = 'list_view';
    options::$default['layout']['page']                 = 'full';
    options::$default['layout']['single']               = 'right';
    options::$default['layout']['blog_page']            = 'right';
    options::$default['layout']['v_blog_page']          = 'list_view';

    $post_layout = meta::get_meta( options::get_value( 'general' , 'my_liked_posts' ) , 'layout' ); 
    if(isset($post_layout['type'])){
        options::$default['layout']['my_likes']               = $post_layout['type'];    
    }
    options::$default['layout']['v_my_likes']             = 'list_view';
    options::$default['layout']['my_likes_thumb_size']             = 'small_thumb';
    options::$default['layout']['my_likes_title_position']             = 'above_excerpt';
    /*options::$default['layout']['columns_my_likes_sidebar']             = 'above_excerpt';
    options::$default['layout']['columns_my_likes_no_sidebar']             = 'above_excerpt';
*/

    options::$default['layout']['search']               = 'right';
    options::$default['layout']['v_search']             = 'list_view';
    options::$default['layout']['archive']              = 'right';
    options::$default['layout']['v_archive']            = 'list_view';
    options::$default['layout']['category']             = 'right';
    options::$default['layout']['v_category']           = 'list_view';
    options::$default['layout']['tag']                  = 'right';
    options::$default['layout']['v_tag']                = 'list_view';
    options::$default['layout']['attachment']           = 'right';

    /* LAYOUT OPTIONS */
    $layouts                                            = array('left' => __( 'Left sidebar' , 'cosmotheme' ) , 'right' => __( 'Right sidebar' , 'cosmotheme' ) , 'full' => __( 'Full width' , 'cosmotheme' ) );
    $view                                               = array('list_view' => __( 'List view' , 'cosmotheme' ) , 'grid_view' => __( 'Grid view' , 'cosmotheme' ), 'thumbnails_view' => __( 'Thumbnails view' , 'cosmotheme' ) ); 
    $sidebars_record = options::get_value( '_sidebar' );
    if( !is_array( $sidebars_record ) || empty( $sidebars_record ) ){
        $sidebar = array( '' => 'main' );
    }else{
        foreach( $sidebars_record as $sidebars ){
            $sidebar[ trim( strtolower( str_replace( ' ' , '-' , $sidebars['title'] ) ) ) ] = $sidebars['title'];
        }
        $sidebar[''] = 'main';
    }

    $sidebar_columns = array(
        3 => __( 'Three columns' , 'cosmotheme' ),
        9 => __( 'Nine columns' , 'cosmotheme' )
    );

    $no_sidebar_columns = array(
        2 => __( 'Two columns' , 'cosmotheme' ),
        3 => __( 'Three columns' , 'cosmotheme' ),
        4 => __( 'Four columns' , 'cosmotheme' ),
        6 => __( 'Six columns' , 'cosmotheme' )
    );


    $thumbs_options = array(
        'no_thumb' => __( 'No thumbnail' , 'cosmotheme' ),
        'small_thumb' => __( 'Small thumbnail' , 'cosmotheme' ),
        'large_thumb' => __( 'Large thumbnail' , 'cosmotheme' ),
        'full_width_thumb' => __( 'Full-width thumbnail' , 'cosmotheme' )  
    );

    $title_options = array(
        'above_content' => __( 'Title above content' , 'cosmotheme' ),
        'above_excerpt' => __( 'Title above excerpt' , 'cosmotheme' )
    );

    options::$fields['layout']['title0']                = array('type' => 'ni--title' , 'title' => __( 'Front page' , 'cosmotheme' ) );

    $hint = '<div class="template-description">';
        $hint.= '<div class="align-left">';
            $hint.= __( "This page lets you assign custom templates for your site's sections.", 'cosmotheme' );
            $hint.= '<br>';
            $hint.= __( "Please, select from the list the custom template you have created. To create a new template visit ", 'cosmotheme' );
            $hint.= '<a href="?page=cosmothemes__templates">' . __( 'Templates', 'cosmotheme' ) . '</a> ' . __( 'page.', 'cosmotheme' );
        $hint .= '</div>';
    $hint.= '</div>';

    options::$fields[ 'front_page_layout' ][ 'hint' ] = array( 'type' => 'cd--whatever', 'content' => $hint );
    options::$fields[ 'front_page_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'front_page' );

    options::$fields[ 'category_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'category_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'category' );

    options::$fields[ 'tag_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'tag_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'tag' );

    options::$fields[ 'author_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'author_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'author' );

    options::$fields[ 'search_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'search_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'search' );

    options::$fields[ 'single_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'single_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'single' );

    options::$fields[ 'event_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'event_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'event' );

    options::$fields[ 'page_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'page_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'page' );

    options::$fields[ 'archive_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'archive_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'archive' );

    options::$fields[ 'archive_format_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'archive_format_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'archive_format' ); /*for post format archive*/

    options::$fields[ 'archive_post_type_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'archive_post_type_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'archive_post_type' );

    options::$fields[ 'event_category_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'event_category_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'event_category' );

    options::$fields[ '404_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ '404_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => '404' );

    options::$fields[ 'attachment_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'attachment_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'attachment' );

    options::$fields[ 'index_layout' ][ 'hint' ] = options::$fields[ 'front_page_layout' ][ 'hint' ];
    options::$fields[ 'index_layout' ][ 'sidebars' ] = array( 'type' => 'st--sidebar-resizer', 'templatename' => 'index' );

    options::$fields['layout']['front_page']            = array('type' => 'st--select' , 'label' => __( 'Layout for front page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.front_page_layout' , { 'left' : '.front_page_sidebar' , 'right' : '.front_page_sidebar' } , 'sh_' )" , 'iclasses' => 'front_page_layout' );
    options::$fields['layout']['front_page_sidebar']    = array('type' => 'st--select' , 'label' => __( 'Select sidebar for front page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'front_page_sidebar' );
    if( options::get_value( 'layout' , 'front_page' ) == 'full' ){
        options::$fields['layout']['front_page_sidebar']['classes'] = 'front_page_sidebar hidden';
    }

    options::$fields['layout']['title1']                = array('type' => 'ni--title' , 'title' => __( '404' , 'cosmotheme' ) );
    options::$fields['layout']['404']                   = array('type' => 'st--select' , 'label' => __( 'Layout for 404 page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.layout_404' , { 'left' : '.sidebar_404' , 'right' : '.sidebar_404' } , 'sh_' )" , 'iclasses' => 'layout_404'  );
    options::$fields['layout']['404_sidebar']           = array('type' => 'st--select' , 'label' => __( 'Select sidebar for 404 template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'sidebar_404' );
    if( options::get_value( 'layout' , '404' ) == 'full' ){
        options::$fields['layout']['404_sidebar']['classes'] = 'sidebar_404 hidden';
    }


    options::$fields['layout']['title2']                = array('type' => 'ni--title' , 'title' => __( 'Author' , 'cosmotheme' ) );
    options::$fields['layout']['author']                = array('type' => 'st--select' , 'label' => __( 'Layout for author page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.author_layout' , { 'left' : '.author_sidebar' , 'right' : '.author_sidebar' } , 'sh_' ); act.sh.columns( 'author' )" , 'iclasses' => 'author_layout' );
    options::$fields['layout']['author_sidebar']        = array('type' => 'st--select' , 'label' => __( 'Select sidebar for author template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'author_sidebar' );
    if( options::get_value( 'layout' , 'author' ) == 'full' ){
        options::$fields['layout']['author_sidebar']['classes'] = 'author_sidebar hidden';
    }
    options::$fields['layout']['v_author']              = array('type' => 'st--select' , 'label' => __( 'View type for author page' , 'cosmotheme') , 'value' => $view, 'action' => "act.select('.author_view' , { 'list_view' : '.author-thumb-size, .author-title-position'  } , 'sh_' ); act.sh.columns( 'author' );", 'iclasses' => 'author_view' );
    options::$fields[ 'layout' ][ 'columns_author_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for author page', 'cosmotheme' ), 'value' => $sidebar_columns, 'classes' => 'author-sidebar-columns' );
    options::$fields[ 'layout' ][ 'columns_author_no_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for author page', 'cosmotheme' ), 'value' => $no_sidebar_columns, 'classes' => 'author-no-sidebar-columns' );
    options::$fields[ 'layout' ][ 'author_thumb_size' ] = array( 'type' => 'st--select', 'label' => __( 'Thumbnail size', 'cosmotheme' ), 'value' => $thumbs_options, 'classes' => 'author-thumb-size' );
    options::$fields[ 'layout' ][ 'author_title_position' ] = array( 'type' => 'st--select', 'label' => __( 'Title position', 'cosmotheme' ), 'value' => $title_options, 'classes' => 'author-title-position' );

    options::$fields['layout']['title3']                = array('type' => 'ni--title' , 'title' => __( 'Pages / single post' , 'cosmotheme' ) );
    options::$fields['layout']['page']                  = array('type' => 'st--select' , 'label' => __( 'Layout for pages' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.page_layout' , { 'left' : '.page_sidebar' , 'right' : '.page_sidebar' } , 'sh_' )" , 'iclasses' => 'page_layout' );
    options::$fields['layout']['page_sidebar']          = array('type' => 'st--select' , 'label' => __( 'Select sidebar for page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'page_sidebar' );
    if( options::get_value( 'layout' , 'page' ) == 'full' ){
        options::$fields['layout']['page_sidebar']['classes'] = 'page_sidebar hidden';
    }
    options::$fields['layout']['single']                = array('type' => 'st--select' , 'label' => __( 'Layout for single post' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.single_layout' , { 'left' : '.single_sidebar' , 'right' : '.single_sidebar' } , 'sh_' )" , 'iclasses' => 'single_layout' );
    options::$fields['layout']['single_sidebar']        = array('type' => 'st--select' , 'label' => __( 'Select sidebar for single page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'single_sidebar' );
    if( options::get_value( 'layout' , 'single' ) == 'full' ){
        options::$fields['layout']['single_sidebar']['classes'] = 'single_sidebar hidden';
    }
    options::$fields['layout']['title13']               = array('type' => 'ni--title' , 'title' => __( 'Blog page' , 'cosmotheme' ) );
    options::$fields['layout']['blog_page']             = array('type' => 'st--select' , 'label' => __( 'Layout for blog page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.blog_page_layout' , { 'left' : '.blog_page_sidebar' , 'right' : '.blog_page_sidebar' } , 'sh_' ); act.sh.columns( 'blog_page' )" , 'iclasses' => 'blog_page_layout' );
    options::$fields['layout']['blog_page_sidebar']     = array('type' => 'st--select' , 'label' => __( 'Select sidebar for blog page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'blog_page_sidebar' );
    if( options::get_value( 'layout' , 'blog_page' ) == 'full' ){
        options::$fields['layout']['blog_page_sidebar']['classes'] = 'blog_page_sidebar hidden';
    }
    options::$fields['layout']['v_blog_page']           = array('type' => 'st--select' , 'label' => __( 'View type for blog page' , 'cosmotheme') , 'value' => $view, 'action' => "act.select('.blog_page_view' , { 'list_view' : '.blog-page-thumb-size, .blog-page-title-position'  } , 'sh_' ); act.sh.columns( 'blog_page' );", 'iclasses' => 'blog_page_view' );
    options::$fields[ 'layout' ][ 'columns_blog_page_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for blog page', 'cosmotheme' ), 'value' => $sidebar_columns, 'classes' => 'blog_page-sidebar-columns' );
    options::$fields[ 'layout' ][ 'columns_blog_page_no_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for blog page', 'cosmotheme' ), 'value' => $no_sidebar_columns, 'classes' => 'blog_page-no-sidebar-columns' );
    options::$fields[ 'layout' ][ 'blog_page_thumb_size' ] = array( 'type' => 'st--select', 'label' => __( 'Thumbnail size', 'cosmotheme' ), 'value' => $thumbs_options, 'classes' => 'blog-page-thumb-size' );
    options::$fields[ 'layout' ][ 'blog_page_title_position' ] = array( 'type' => 'st--select', 'label' => __( 'Title position', 'cosmotheme' ), 'value' => $title_options, 'classes' => 'blog-page-title-position' );

    options::$fields['layout']['title4']                = array('type' => 'ni--title' , 'title' => __( 'Search' , 'cosmotheme' ) );
    options::$fields['layout']['search']                = array('type' => 'st--select' , 'label' => __( 'Layout for search page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.search_layout' , { 'left' : '.search_sidebar' , 'right' : '.search_sidebar' } , 'sh_' ); act.sh.columns( 'search' )" , 'iclasses' => 'search_layout' );
    options::$fields['layout']['search_sidebar']        = array('type' => 'st--select' , 'label' => __( 'Select sidebar for search template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'search_sidebar' );
    if( options::get_value( 'layout' , 'search' ) == 'full' ){
        options::$fields['layout']['search_sidebar']['classes'] = 'search_sidebar hidden';
    }
    options::$fields['layout']['v_search']              = array('type' => 'st--select' , 'label' => __( 'View type for search page' , 'cosmotheme') , 'value' => $view, 'action' => "act.select('.search_view' , { 'list_view' : '.search-thumb-size, .search-title-position'  } , 'sh_' ); act.sh.columns( 'search' );", 'iclasses' => 'search_view' );
    options::$fields[ 'layout' ][ 'columns_search_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for search page', 'cosmotheme' ), 'value' => $sidebar_columns, 'classes' => 'search-sidebar-columns' );
    options::$fields[ 'layout' ][ 'columns_search_no_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for search page', 'cosmotheme' ), 'value' => $no_sidebar_columns, 'classes' => 'search-no-sidebar-columns' );
    options::$fields[ 'layout' ][ 'search_thumb_size' ] = array( 'type' => 'st--select', 'label' => __( 'Thumbnail size', 'cosmotheme' ), 'value' => $thumbs_options, 'classes' => 'search-thumb-size' );
    options::$fields[ 'layout' ][ 'search_title_position' ] = array( 'type' => 'st--select', 'label' => __( 'Title position', 'cosmotheme' ), 'value' => $title_options, 'classes' => 'search-title-position' );

    options::$fields['layout']['title5']                = array('type' => 'ni--title' , 'title' => __( 'Archive' , 'cosmotheme' ) );
    options::$fields['layout']['archive']               = array('type' => 'st--select' , 'label' => __( 'Layout for archive page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.archive_layout' , { 'left' : '.archive_sidebar' , 'right' : '.archive_sidebar' } , 'sh_' );act.sh.columns( 'archive' );" , 'iclasses' => 'archive_layout' );
    options::$fields['layout']['archive_sidebar']       = array('type' => 'st--select' , 'label' => __( 'Select sidebar for archive template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'archive_sidebar' );
    if( options::get_value( 'layout' , 'archive' ) == 'full' ){
        options::$fields['layout']['archive_sidebar']['classes'] = 'archive_sidebar hidden';
    }
    options::$fields['layout']['v_archive']             = array('type' => 'st--select' , 'label' => __( 'View type for archive page' , 'cosmotheme') , 'value' => $view, 'action' => "act.select('.archive_view' , { 'list_view' : '.archive-thumb-size, .archive-title-position'  } , 'sh_' ); act.sh.columns( 'archive' );", 'iclasses' => 'archive_view' );
    options::$fields[ 'layout' ][ 'columns_archive_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for search page', 'cosmotheme' ), 'value' => $sidebar_columns, 'classes' => 'archive-sidebar-columns' );
    options::$fields[ 'layout' ][ 'columns_archive_no_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for search page', 'cosmotheme' ), 'value' => $no_sidebar_columns, 'classes' => 'archive-no-sidebar-columns' );
    options::$fields[ 'layout' ][ 'archive_thumb_size' ] = array( 'type' => 'st--select', 'label' => __( 'Thumbnail size', 'cosmotheme' ), 'value' => $thumbs_options, 'classes' => 'archive-thumb-size' );
    options::$fields[ 'layout' ][ 'archive_title_position' ] = array( 'type' => 'st--select', 'label' => __( 'Title position', 'cosmotheme' ), 'value' => $title_options, 'classes' => 'archive-title-position' );

    options::$fields['layout']['title6']                = array('type' => 'ni--title' , 'title' => __( 'Category' , 'cosmotheme' ) );
    options::$fields['layout']['category']              = array('type' => 'st--select' , 'label' => __( 'Layout for category page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.category_layout' , { 'left' : '.category_sidebar' , 'right' : '.category_sidebar' } , 'sh_' );act.sh.columns( 'category' );" , 'iclasses' => 'category_layout' );
    options::$fields['layout']['category_sidebar']      = array('type' => 'st--select' , 'label' => __( 'Select sidebar for category template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'category_sidebar' );
    if( options::get_value( 'layout' , 'category' ) == 'full' ){
        options::$fields['layout']['category_sidebar']['classes'] = 'category_sidebar hidden';
    }
    options::$fields['layout']['v_category']            = array('type' => 'st--select' , 'label' => __( 'View type for category page' , 'cosmotheme') , 'value' => $view, 'action' => "act.select('.category_view' , { 'list_view' : '.category-thumb-size, .category-title-position'  } , 'sh_' ); act.sh.columns( 'category' );", 'iclasses' => 'category_view' );
    options::$fields[ 'layout' ][ 'columns_category_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for category page', 'cosmotheme' ), 'value' => $sidebar_columns, 'classes' => 'category-sidebar-columns' );
    options::$fields[ 'layout' ][ 'columns_category_no_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for category page', 'cosmotheme' ), 'value' => $no_sidebar_columns, 'classes' => 'category-no-sidebar-columns' );
    options::$fields[ 'layout' ][ 'category_thumb_size' ] = array( 'type' => 'st--select', 'label' => __( 'Thumbnail size', 'cosmotheme' ), 'value' => $thumbs_options, 'classes' => 'category-thumb-size' );
    options::$fields[ 'layout' ][ 'category_title_position' ] = array( 'type' => 'st--select', 'label' => __( 'Title position', 'cosmotheme' ), 'value' => $title_options, 'classes' => 'category-title-position' );

    options::$fields['layout']['title7']                = array('type' => 'ni--title' , 'title' => __( 'Tags' , 'cosmotheme' ) );
    options::$fields['layout']['tag']                   = array('type' => 'st--select' , 'label' => __( 'Layout for tags page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.tag_layout' , { 'left' : '.tag_sidebar' , 'right' : '.tag_sidebar' } , 'sh_' );act.sh.columns( 'tag' );" , 'iclasses' => 'tag_layout' );
    options::$fields['layout']['tag_sidebar']           = array('type' => 'st--select' , 'label' => __( 'Select sidebar for tags template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'tag_sidebar' );
    if( options::get_value( 'layout' , 'tag' ) == 'full' ){
        options::$fields['layout']['tag_sidebar']['classes'] = 'tag_sidebar hidden';
    }
    options::$fields['layout']['v_tag']                 = array('type' => 'st--select' , 'label' => __( 'View type for tags page' , 'cosmotheme') , 'value' => $view, 'action' => "act.select('.tag_view' , { 'list_view' : '.tag-thumb-size, .tag-title-position'  } , 'sh_' ); act.sh.columns( 'tag' );", 'iclasses' => 'tag_view' );
    options::$fields[ 'layout' ][ 'columns_tag_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for tags page', 'cosmotheme' ), 'value' => $sidebar_columns, 'classes' => 'tag-sidebar-columns' );
    options::$fields[ 'layout' ][ 'columns_tag_no_sidebar' ] = array( 'type' => 'st--select', 'label' => __( 'Number of columns for tags page', 'cosmotheme' ), 'value' => $no_sidebar_columns, 'classes' => 'tag-no-sidebar-columns' );
    options::$fields[ 'layout' ][ 'tag_thumb_size' ] = array( 'type' => 'st--select', 'label' => __( 'Thumbnail size', 'cosmotheme' ), 'value' => $thumbs_options, 'classes' => 'tag-thumb-size' );
    options::$fields[ 'layout' ][ 'tag_title_position' ] = array( 'type' => 'st--select', 'label' => __( 'Title position', 'cosmotheme' ), 'value' => $title_options, 'classes' => 'tag-title-position' );

    
    if( options::get_value( 'layout', 'author' ) == 'full' ){
        options::$fields[ 'layout' ][ 'columns_author_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'columns_author_no_sidebar' ][ 'classes' ] .= ' hidden';
    }
    if( options::get_value( 'layout', 'v_author' ) == 'list_view' ){
        options::$fields[ 'layout' ][ 'columns_author_sidebar' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'columns_author_no_sidebar' ][ 'classes' ] .= ' hidden';

    }else{
        options::$fields[ 'layout' ][ 'author_thumb_size' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'author_title_position' ][ 'classes' ] .= ' hidden';
    }

    if( options::get_value( 'layout', 'blog_page' ) == 'full' ){
        options::$fields[ 'layout' ][ 'columns_blog_page_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'columns_blog_page_no_sidebar' ][ 'classes' ] .= ' hidden';
    }
    if( options::get_value( 'layout', 'v_blog_page' ) == 'list_view' ){
        options::$fields[ 'layout' ][ 'columns_blog_page_sidebar' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'columns_blog_page_no_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'blog_page_thumb_size' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'blog_page_title_position' ][ 'classes' ] .= ' hidden';
    }

    if( options::get_value( 'layout', 'search' ) == 'full' ){
        options::$fields[ 'layout' ][ 'columns_search_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'columns_search_no_sidebar' ][ 'classes' ] .= ' hidden';
    }
    if( options::get_value( 'layout', 'v_search' ) == 'list_view' ){
        options::$fields[ 'layout' ][ 'columns_search_sidebar' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'columns_search_no_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'search_thumb_size' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'search_title_position' ][ 'classes' ] .= ' hidden';
    }

    if( options::get_value( 'layout', 'archive' ) == 'full' ){
        options::$fields[ 'layout' ][ 'columns_archive_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'columns_archive_no_sidebar' ][ 'classes' ] .= ' hidden';
    }
    if( options::get_value( 'layout', 'v_archive' ) == 'list_view' ){
        options::$fields[ 'layout' ][ 'columns_archive_sidebar' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'columns_archive_no_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'archive_thumb_size' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'archive_title_position' ][ 'classes' ] .= ' hidden';
    }

    if( options::get_value( 'layout', 'category' ) == 'full' ){
        options::$fields[ 'layout' ][ 'columns_category_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'columns_category_no_sidebar' ][ 'classes' ] .= ' hidden';
    }

    if( options::get_value( 'layout', 'v_category' ) == 'list_view' ){
        options::$fields[ 'layout' ][ 'columns_category_sidebar' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'columns_category_no_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'category_thumb_size' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'category_title_position' ][ 'classes' ] .= ' hidden';
    }

    if( options::get_value( 'layout', 'tag' ) == 'full' ){
        options::$fields[ 'layout' ][ 'columns_tag_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'columns_tag_no_sidebar' ][ 'classes' ] .= ' hidden';
    }
    if( options::get_value( 'layout', 'v_tag' ) == 'list_view' ){
        options::$fields[ 'layout' ][ 'columns_tag_sidebar' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'columns_tag_no_sidebar' ][ 'classes' ] .= ' hidden';
    }else{
        options::$fields[ 'layout' ][ 'tag_thumb_size' ][ 'classes' ] .= ' hidden';
        options::$fields[ 'layout' ][ 'tag_title_position' ][ 'classes' ] .= ' hidden';
    }

    
    options::$default[ 'layout' ][ 'columns_author_sidebar' ] = 3;
    options::$default[ 'layout' ][ 'columns_author_no_sidebar' ] = 4;
    options::$default[ 'layout' ][ 'columns_blog_page_sidebar' ] = 3;
    options::$default[ 'layout' ][ 'columns_blog_page_no_sidebar' ] = 4;
    options::$default[ 'layout' ][ 'columns_search_sidebar' ] = 3;
    options::$default[ 'layout' ][ 'columns_search_no_sidebar' ] = 4;
    options::$default[ 'layout' ][ 'columns_archive_sidebar' ] = 3;
    options::$default[ 'layout' ][ 'columns_archive_no_sidebar' ] = 4;
    options::$default[ 'layout' ][ 'columns_category_sidebar' ] = 3;
    options::$default[ 'layout' ][ 'columns_category_no_sidebar' ] = 4;
    options::$default[ 'layout' ][ 'columns_tag_sidebar' ] = 3;
    options::$default[ 'layout' ][ 'columns_tag_no_sidebar' ] = 4;
    options::$default[ 'layout' ][ 'author_title_position' ] = 'above_content';
    options::$default[ 'layout' ][ 'author_thumb_size' ] = 'small_thumb';
    options::$default[ 'layout' ][ 'blog_page_title_position' ] = 'above_content';
    options::$default[ 'layout' ][ 'blog_page_thumb_size' ] = 'small_thumb';
    options::$default[ 'layout' ][ 'search_title_position' ] = 'above_content';
    options::$default[ 'layout' ][ 'search_thumb_size' ] = 'small_thumb';
    options::$default[ 'layout' ][ 'archive_title_position' ] = 'above_content';
    options::$default[ 'layout' ][ 'archive_thumb_size' ] = 'small_thumb';
    options::$default[ 'layout' ][ 'category_title_position' ] = 'above_content';
    options::$default[ 'layout' ][ 'category_thumb_size' ] = 'small_thumb';
    options::$default[ 'layout' ][ 'tag_title_position' ] = 'above_content';
    options::$default[ 'layout' ][ 'tag_thumb_size' ] = 'small_thumb';


    options::$fields['layout']['title8']                = array('type' => 'ni--title' , 'title' => '' );
    options::$fields['layout']['attachment']            = array('type' => 'st--select' , 'label' => __( 'Layout for attachment page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.attachment_layout' , { 'left' : '.attachment_sidebar' , 'right' : '.attachment_sidebar' } , 'sh_' )" , 'iclasses' => 'attachment_layout' );
    options::$fields['layout']['attachment_sidebar']    = array('type' => 'st--select' , 'label' => __( 'Select sidebar for attachment template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'attachment_sidebar' );
    if( options::get_value( 'layout' , 'attachment' ) == 'full' ){
        options::$fields['layout']['attachment_sidebar']['classes'] = 'attachment_sidebar hidden';
    }

    if( !isset( $_GET[ 'settings-updated' ] ) ){
        $layout = get_option( 'front_page' );
        $layout[ 'layout' ] = options::get_value( 'layout', 'front_page' );
        $layout[ 'sidebar' ] = options::get_value( 'layout', 'front_page_sidebar' );
        update_option( 'front_page', $layout );
    }

    options::$fields[ 'front_page' ][ 'layout' ] = array(
        'type' => 'st--select',
        'label' => __( 'Layout for front page' , 'cosmotheme' ),
        'value' => $layouts,
        'ivalue' => options::get_value( 'layout', 'front_page' ),
        'action' => "act.select('.front_page_layout' , { 'left' : '.front_page_sidebar' , 'right' : '.front_page_sidebar' } , 'sh_' );jQuery( '.options-columns').trigger('show-hide')",
        'iclasses' => 'front_page_layout'
    );

    options::$fields[ 'front_page' ][ 'sidebar' ] = array(
        'type' => 'st--select',
        'label' => __( 'Select sidebar for front page template' , 'cosmotheme' ),
        'value' =>  $sidebar,
        'ivalue' => options::get_value( 'layout', 'front_page_sidebar' ),
        'classes' => 'front_page_sidebar'
    );

    if( options::get_value( 'front_page' , 'layout' ) == 'full' ){
        options::$fields['front_page']['sidebar']['classes'] = 'front_page_sidebar hidden';
    }

	/* STYLING DEFAULT VALUES */
    
    options::$default['styling']['viewport_width']              = '1170px';
    options::$default['styling']['front_end']           = 'no';
    options::$default['styling']['background']          = 's.pattern.paper.png';
    
	//options::$default['styling']['background_color']    = '#ffffff';
    options::$default['styling']['footer_bg_color']     = '#414B52';
   // options::$default[ 'styling' ][ 'boxed_bg_color' ]  = '#ffffff';

    options::$default[ 'styling' ][ 'footer_bg_color' ]  = '#494a4a';
    options::$default[ 'styling' ][ 'footer_text_color' ]  = '#ffffff';

    options::$default[ 'styling' ][ 'headings_color' ]  = '#A93064';
    options::$default[ 'styling' ][ 'links_color' ]  = '#000';
    options::$default[ 'styling' ][ 'labels_bg_color' ]  = '#97AD59';
    options::$default[ 'styling' ][ 'labels_text_color' ]  = '#ffffff';
    
    options::$default['styling']['stripes']             = 'yes';

    //options::$default[ 'styling' ][ 'boxed' ]                   = 'yes';
    options::$default[ 'styling' ][ 'logo_type' ]               = 'text';
    options::$default[ 'styling' ][ 'enb_site_description' ]    = 'no';
    options::$default[ 'styling' ][ 'logo_text_color' ]         = '#EB4C4C';
    
    /* STYLING OPTIONS */
    
    $viewport_width_options = array('1170px'=>'1170px', '960px'=>'960px', '800px' =>'800px');
    options::$fields['styling']['viewport_width']   = array('type' => 'st--select' , 'label' => __( 'Choose viewport width' , 'cosmotheme' ), 'value' => $viewport_width_options );
    
    $pattern_path = 'pattern/s.pattern.';
    $pattern = array(
        "dots2"=>"dots2.png" , "squares3"=>"squares3.png" , "pluses"=>"pluses.png" , "opacity"=>"opacity.png" ,"circles"=>"circles.png","dots"=>"dots.png","grid"=>"grid.png","noise"=>"noise.png",
        "paper"=>"paper.png","rectangle"=>"rectangle.png","squares_1"=>"squares_1.png","squares_2"=>"squares_2.png","thicklines"=>"thicklines.png","thinlines"=>"thinlines.png" , "none"=>"none.png"
    );

    options::$fields['styling']['bg_title']             = array( 'type' => 'ni--title' , 'title' => __( 'Select body background' , 'cosmotheme' ) );
    options::$fields['styling']['background']           = array( 'type' => 'ni--radio-icon' ,  'value' => $pattern , 'path' => $pattern_path , 'in_row' => 5 );
    
    options::$fields['styling']['background_image']     = array( 'type' => 'st--hint' , 'value' => __( 'To set a background image go to' , 'cosmotheme' ) . ' <a href="themes.php?page=custom-background">' . __( 'Appearence - Background'  , 'cosmotheme' ) . '</a>' );


/*    options::$fields['styling']['menu_delimiter_demo_img']             = array( 'type' => 'ni--delimiter'  );
    options::$fields['styling'][ 'demo_img' ]         = array(
        'type' => 'cd--whatever',
        'content' => '<div class="demo_boxed"></div>'
    );
    options::$fields['styling']['boxed']              = array('type' => 'st--logic-radio' , 'label' => __( 'Enable boxed layout' , 'cosmotheme' ), 'action' => "act.check( this , { 'yes' : ' .boxed-bg-color' , 'no' : '' } , 'sh' );" );
    options::$fields[ 'styling' ][ 'boxed_bg_color' ] = array(
        'label' => __( "Content background color" , 'cosmotheme' ),
        'type' => 'st--color-picker'
    );*/

/*    if( !options::logic( 'styling' , 'boxed' ) ){
        options::$fields['styling']['boxed_bg_color']['classes']     = 'boxed-bg-color hidden';
    }else{
        options::$fields['styling']['footer_bg_color']['classes']     = 'footer-bg-color hidden';
    }*/

    /* color */
    /* background */
   // options::$fields['styling']['background_color']     = array('type' => 'st--color-picker' , 'label' => __( 'Body background color' , 'cosmotheme' ) );
    
    options::$fields['styling']['menu_delimiter_bottom']             = array( 'type' => 'ni--delimiter' );

    options::$fields['styling'][ 'footer_bg_color' ] = array(
        'label' => __( "Footer background color" , 'cosmotheme' ),
        'type' => 'st--color-picker',
        'hint' => __('The selected color will be used as background color for footer.','cosmotheme')
    );    

    options::$fields['styling'][ 'footer_text_color' ] = array('label' => __( "Footer text color" , 'cosmotheme' ),'type' => 'st--color-picker');  

    options::$fields[ 'styling' ][ 'headings_color' ] = array(
        'label' => __( "Headings color" , 'cosmotheme' ),
        'type' => 'st--color-picker',
        'hint' => __('This color will be used for headings (H1, H2, H3...)','cosmotheme')
    );

    options::$fields[ 'styling' ][ 'links_color' ] = array(
        'label' => __( "Links color" , 'cosmotheme' ),
        'type' => 'st--color-picker'
    );

    options::$fields[ 'styling' ][ 'labels_bg_color' ] = array(
        'label' => __( "Labels background color" , 'cosmotheme' ),
        'type' => 'st--color-picker',
        'hint' => __( "This color will be used for the following elements: Labels, Widget labels, Tags, Load more button, Related tabs, Pagination buttons, Timeline lines and format background" , 'cosmotheme' ),
    );

    options::$fields[ 'styling' ][ 'labels_text_color' ] = array(
        'label' => __( "Labels text color" , 'cosmotheme' ),
        'type' => 'st--color-picker',
        'hint' => __( "This color will be used for the following elements: Labels, Widget labels, Tags, Load more button, Related tabs, Pagination buttons, Timeline lines and format background" , 'cosmotheme' ),
    );
  

    options::$fields['styling']['colors_delimiter_bottom']             = array( 'type' => 'ni--delimiter' );
    //options::$fields['styling']['footer_bg_color']      = array('type' => 'st--color-picker' , 'label' => __( 'Set footer background color' , 'cosmotheme' ) );
    

    

    $path_parts = pathinfo( options::get_value( 'styling' , 'favicon' ) );
    if( strlen( options::get_value( 'styling' , 'favicon' ) ) && $path_parts['extension'] != 'ico' ){
        $ico_hint = '<span style="color:#cc0000;">' . __( 'Error, please select "ico" type media file' , 'cosmotheme' ) . '</span>';
    }else{
        $ico_hint = __( "Please select 'ico' type media file. Make sure you allow uploading 'ico' type in General Settings -> Upload file types" , 'cosmotheme' );
    }

    options::$fields['styling']['favicon']              = array('type' => 'st--upload' , 'label' => __( 'Custom favicon' , 'cosmotheme' ) , 'id' => 'favicon_path' , 'hint' => $ico_hint );
    options::$fields['styling']['stripes']              = array('type' => 'st--logic-radio' , 'label' => __( 'Enable stripes effect for post images' , 'cosmotheme' ) );
    options::$fields['styling']['logo_type']            = array('type' => 'st--select' , 'label' => __( 'Logo type ' , 'cosmotheme' ) , 'value' => array( 'text' => 'Text logo' , 'image' => 'Image logo' ) , 'hint' => __( 'Enable text-based site title and tagline.' , 'cosmotheme' ) , 'action' => "act.select( '.g_logo_type' , { 'text':'.g_logo_text' , 'image':'.g_logo_image' } , 'sh_' );" , 'iclasses' => 'g_logo_type' );

    options::$fields['styling']['enb_site_description'] = array('type' => 'st--logic-radio' , 'label' => __( 'Enable site description' , 'cosmotheme' ), 'hint' => __( 'This will add the blog description bellow the logo.' , 'cosmotheme' ) );
    options::$fields[ 'styling' ][ 'logo_text_color' ] = array(
        'label' => __( "Logo text color" , 'cosmotheme' ),
        'type' => 'st--color-picker'
    ); 

    /* fields for general -> logo_type */
    options::$fields['styling']['logo_url']             = array('type' => 'st--upload' , 'label' => __( 'Custom logo URL' , 'cosmotheme' ) , 'id' => 'logo_path' );

    /* hide not used fields */
	if( options::get_value( 'styling' , 'logo_type') == 'image' ){
        options::$fields['styling']['logo_url']['classes'] 	= 'g_logo_image';
        options::$fields['styling']['enb_site_description']['classes']  = 'generic-hint g_logo_text hidden';
        options::$fields['styling']['logo_text_color']['classes']  = 'generic-hint g_logo_text hidden';
        text::fields( 'styling' , 'logo' ,  'g_logo_text hidden' , get_option( 'blogname' ) );
        options::$fields['styling']['hint']                 = array('type' => 'st--hint' , 'classes' => 'g_logo_text hidden' ,'value' => __( 'To change blog title go to <a href="options-general.php">General settings</a> ' , 'cosmotheme') );
    }else{
		options::$fields['styling']['logo_url']['classes'] 	= 'generic-hint g_logo_image hidden';
        options::$fields['styling']['enb_site_description']['classes']  = 'g_logo_text';
        options::$fields['styling']['logo_text_color']['classes']  = 'g_logo_text';
        text::fields( 'styling' , 'logo' ,  'g_logo_text' , get_option( 'blogname' ) );
        options::$fields['styling']['hint']                 = array('type' => 'st--hint' , 'classes' => 'generic-hint g_logo_text' , 'value' => __( 'To change blog title go to <a href="options-general.php">General settings </a> ' , 'cosmotheme') );
    }
    
    /*TYPOGRAPHY OPTIONS*/
    options::$fields['typography']['headings_title']             = array( 'type' => 'ni--title' , 'title' => __( 'Headings ' , 'cosmotheme' ), 'hint' => __( 'Select and style your site\'s heading tags (H1, H2, H3...)' , 'cosmotheme' ) );
    text::fields( 'typography' , 'headings_font' ,  'g_headings_text' , 'Lorem ipsum dolor sit amet',  $default = array( '' , 24 , 'normal' ), $show_font_weight = false, $show_font_size = false  );

    options::$fields['typography']['primary_title']             = array( 'type' => 'ni--title' , 'title' => __( 'Primary text ' , 'cosmotheme' ), 'hint' => __( 'Select and style the standard font used in your site (body)' , 'cosmotheme' ) );
    text::fields( 'typography' , 'primary_font' ,  'g_primary_text' , 'Lorem ipsum dolor sit amet',  $default = array( '' , 24 , 'normal' ), $show_font_weight = false, $show_font_size = false  );

/*    options::$fields['typography']['secondary_title']             = array( 'type' => 'ni--title' , 'title' => __( 'Secondary text ' , 'cosmotheme' ), 'hint' => __( 'Select and style your site\'s secondary or sub title text (metabar, sub titles, etc.)' , 'cosmotheme' ) );
    text::fields( 'typography' , 'secondary_font' ,  'g_secondary_text' , 'Lorem ipsum dolor sit amet',  $default = array( '' , 24 , 'normal' ), $show_font_weight = false, $show_font_size = false  );
*/
	/* MENU DEFAULT VALUES */
    options::$default['menu']['header']                 = 8;
    options::$default['menu']['footer']                 = 4;
    
            
    /* MENU OPTIONS */
    
    options::$fields['menu']['custom_menu']             = array('type' => 'ni--title' , 'title' => __( 'Custom menu' , 'cosmotheme' ) );
    options::$fields['menu']['header']                  = array('type' => 'st--select' , 'value' => fields::digit_array( 20 ) , 'label' => __( 'Set limit for main menu' , 'cosmotheme' ) , 'hint' => __( 'Set the number of visible menu items. Remaining menu items<br />will be shown in the drop down menu item "More"' , 'cosmotheme' ) );
    options::$fields['menu']['footer']                  = array('type' => 'st--select' , 'value' => fields::digit_array( 20 ) , 'label' => __( 'Set limit for footer menu' , 'cosmotheme' ) , 'hint' => __( 'Set the number of visible menu items' , 'cosmotheme' ) );
    
    /* POSTS OPTIONS */
    options::$fields['blog_post']['post_title0']        = array('type' => 'ni--title' , 'title' => __( 'General Posts Settings' , 'cosmotheme' ) );

    options::$fields['blog_post']['show_similar']       = array('type' => 'st--logic-radio' , 'label' => __( 'Enable similar posts' , 'cosmotheme' ), 'action' => "act.check( this , { 'yes' : '.similar_type_class ' , 'no' : '' } , 'sh' );" );
    
	$similar_type_options = array('same_author' => __('Same user','cosmotheme'), 'post_tag'=>__('Same tags','cosmotheme'), 'category'=> __('Same category','cosmotheme') );
    
    options::$fields['blog_post']['similar_type']       = array( 'type' => 'st--multiple-select' , 'value' => $similar_type_options ,  'label' => __( 'Similar posts criteria','cosmotheme' ) , 'hint' => __( 'Shift-click or CTRL-click to select multiple items. ','cosmotheme' ) );        
    $similar_type_view_options = array('grid_view' => __( 'Grid view' , 'cosmotheme' ), 'thumbnails_view' => __( 'Thumbnails view' , 'cosmotheme' ) ); 
    options::$fields['blog_post']['similar_view_type']  = array('type' => 'st--select' , 'value' => $similar_type_view_options , 'label' => __( 'Similar posts view type' , 'cosmotheme' ) );


    options::$fields['blog_post']['menu_delimiter_right_bottom']       = array( 'type' => 'ni--delimiter'  );
    
    options::$fields['blog_post']['post_sharing']       = array('type' => 'st--logic-radio' , 'label' => __( 'Enable social sharing for posts' , 'cosmotheme' ) );
    options::$fields['blog_post']['meta']               = array('type' => 'st--logic-radio' , 'label' => __( 'Show entry meta' , 'cosmotheme' ) );
    options::$fields['blog_post']['enb_featured']         = array('type' => 'st--logic-radio' , 'label' => __( 'Display featured image inside the post' , 'cosmotheme' ) , 'hint' => __( 'If enabled featured images will be displayed on post page' , 'cosmotheme' ) );
    options::$fields['blog_post']['enb_lightbox']         = array('type' => 'st--logic-radio' , 'label' => __( 'Enable pretty-photo ligthbox' , 'cosmotheme' ) , 'hint' => __( 'Images inside posts will open inside a fancy lightbox' , 'cosmotheme' ) );
    options::$fields['blog_post']['show_feat_on_archive'] = array('type' => 'st--logic-radio' , 'label' => __( 'Display featured image on archive pages' , 'cosmotheme' )  );
	options::$fields['blog_post']['use_cropp_on_single']  = array('type' => 'st--logic-radio' , 'label' => __( 'Use cropped thumbnail on single post page.' , 'cosmotheme' ), 'hint' => __( 'By default the original image is used. By enabling this option a cropped image of size 1140x500 px will be used.' , 'cosmotheme' )  );
    
    //options::$fields['blog_post']['enb-next-prev']      = array('type' => 'st--logic-radio' , 'label' => __( 'Enable navigation for posts' , 'cosmotheme' ) , 'hint' => __( 'If enabled the post will show links to the next and previous posts' , 'cosmotheme' ) );
    
    options::$fields['blog_post']['menu_delimiter_page_settings']       = array( 'type' => 'ni--delimiter'  );

    options::$fields['blog_post']['post_title1']        = array('type' => 'ni--title' , 'title' => __( 'General Page Settings' , 'cosmotheme' ) );
    options::$fields['blog_post']['page_sharing']       = array('type' => 'st--logic-radio' , 'label' => __( 'Enable social sharing for page' , 'cosmotheme' ) );
    options::$fields['blog_post']['page_meta']          = array('type' => 'st--logic-radio' , 'label' => __( 'Show entry meta for pages' , 'cosmotheme' ) );

    options::$fields['blog_post']['post_title2']        = array('type' => 'ni--title' , 'title' => __( 'General Archive Settings' , 'cosmotheme' ) );
    options::$fields['blog_post']['excerpt_lenght_grid']= array('type' => 'st--digit' , 'label' => __( 'Excerpt length (grid view)' , 'cosmotheme' ), 'hint' => __('Set number of characters that will be displayed on archive pages for each post','cosmotheme') );
    options::$fields['blog_post']['excerpt_lenght_list']= array('type' => 'st--digit' , 'label' => __( 'Excerpt length (timeline view)' , 'cosmotheme' ) , 'hint' => __('Set number of characters that will be displayed on archive pages for each post','cosmotheme') );
    
    /* POSTS DEFAULT VALUE */
    options::$default['blog_post']['show_similar']      = 'yes';
    options::$default['blog_post']['post_sharing']      = 'yes';
    options::$default['blog_post']['meta']      = 'yes'; /*enable meta for posts */
    options::$default['blog_post']['post_author_box']   = 'no';
	options::$default['blog_post']['show_source'] 		= 'yes';
	options::$default['blog_post']['show_feat_on_archive'] = 'yes';
    options::$default['blog_post']['use_cropp_on_single'] = 'no';
    //options::$default['blog_post']['enb-next-prev']     = 'yes';
    options::$default['blog_post']['page_sharing']      = 'yes';
    options::$default['blog_post']['page_meta']      = 'yes';
    options::$default['blog_post']['page_author_box']   = 'no';
    options::$default['blog_post']['similar_type']= array('post_tag');
    options::$default['blog_post']['similar_type_right']= 'post_tag';
    options::$default['blog_post']['similar_view_type'] = 'thumbnails_view';
    options::$default['blog_post' ][ 'navigation_posts' ]= 'yes';
    options::$default['blog_post']['enb_featured']        = 'yes';
    options::$default['blog_post']['enb_lightbox']        = 'yes';

    

	if( options::logic( 'blog_post' , 'show_similar' ) ){
		options::$fields['blog_post']['similar_type']['classes']     = 'similar_type_class';
	}else{ 
		options::$fields['blog_post']['similar_type']['classes']     = 'similar_type_class hidden';
	}

    options::$default[ 'blog_post' ][ 'excerpt_lenght_grid' ]= '120';
    options::$default[ 'blog_post' ][ 'excerpt_lenght_list' ]= '300';

    
    /* SOCIAL OPTIONS */
    
    options::$fields['social']['facebook_app_id']       = array('type' => 'st--text' , 'label' => __( 'Facebook Application ID' , 'cosmotheme' ) , 'hint' => __( 'You can create a fb application from <a href="https://developers.facebook.com/apps">here</a>' , 'cosmotheme' ) );
    options::$fields['social']['facebook_secret']       = array('type' => 'st--text' , 'label' => __( 'Facebook Secret key' , 'cosmotheme' ) , 'hint' => __( 'Needed for Facebook Connect' , 'cosmotheme' ) );

    options::$default[ 'social' ][ 'rss' ]              = 'yes';


    options::$fields[ 'social' ][ 'rss' ]               = array('type' => 'st--logic-radio' , 'label' => __( 'Show RSS icon' , 'cosmotheme' )  );
    options::$fields['social']['facebook']              = array('type' => 'st--text' , 'label' => __( 'Facebook profile ID' , 'cosmotheme' ), 'hint' => __( '(i.e. cosmo.theme)' , 'cosmotheme' )  );
    options::$fields['social']['twitter']               = array('type' => 'st--text' , 'label' => __( 'Twitter ID' , 'cosmotheme' ), 'hint' => __( '(i.e. cosmothemes)' , 'cosmotheme' ) );

    options::$fields['social']['gplus']                 = array('type' => 'st--text' , 'label' => __( 'G+ public profile URL' , 'cosmotheme' ), 'hint' => __( '(i.e. https://plus.google.com/u/0/b/103218861385999897717/)' , 'cosmotheme' ) );
    options::$fields['social']['yahoo']                 = array('type' => 'st--text' , 'label' => __( 'Yahoo public profile URL' , 'cosmotheme' ), 'hint' => __( '(i.e. http://profile.yahoo.com/56W6RBFOFVLLSUQBHREPTDQW4U/)' , 'cosmotheme' ) );
    options::$fields['social']['dribbble']              = array('type' => 'st--text' , 'label' => __( 'Dribbble public profile URL' , 'cosmotheme' ), 'hint' => __( '(i.e. http://dribbble.com/cosmothemes)' , 'cosmotheme' ) );
    options::$fields['social']['linkedin']              = array('type' => 'st--text' , 'label' => __( 'LinkedIn public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. http://www.linkedin.com/company/cosmothemes)' , 'cosmotheme' ) );

    options::$fields['social']['vimeo']                 = array('type' => 'st--text' , 'label' => __( 'Vimeo public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. http://vimeo.com/user10929709)' , 'cosmotheme' ) );
    options::$fields['social']['youtube']               = array('type' => 'st--text' , 'label' => __( 'Youtube public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. http://www.youtube.com/user/vasilerusnac)' , 'cosmotheme' ) );
    options::$fields['social']['tumblr']                = array('type' => 'st--text' , 'label' => __( 'Tumblr public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. http://virusnac.tumblr.com/)' , 'cosmotheme' ) );
    options::$fields['social']['delicious']             = array('type' => 'st--text' , 'label' => __( 'Delicious public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. https://delicious.com/cosmothemes)' , 'cosmotheme' ) );
    options::$fields['social']['flickr']                = array('type' => 'st--text' , 'label' => __( 'Flickr public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. http://www.flickr.com/photos/cosmothemes/)' , 'cosmotheme' ) );
    options::$fields['social']['pinterest']             = array('type' => 'st--text' , 'label' => __( 'Pinterest public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. http://pinterest.com/cosmothemes)' , 'cosmotheme' ) );

    options::$fields['social']['email']                 = array('type' => 'st--text' , 'label' => __( 'Contact email' , 'cosmotheme' )  );
    options::$fields['social']['skype']                 = array('type' => 'st--text' , 'label' => __( 'Skype Name' , 'cosmotheme' )  );
    
    /* sidebar manager */
    $struct = array(
        'layout' => 'A',
        'check-column' => array(
            'name' => 'idrow[]',
            'type' => 'hidden'
        ),
        'info-column-0' => array(
            0 => array(
                'name' => 'title',
                'type' => 'text',
                'label' => 'Sidebar Title',
                'classes' => 'sidebar-title'
            )
        ),
        'select' => 'title',
        'actions' => array( 'sortable' => true )
    );

    /* delete_option( '_sidebar' ); */
    /* SOCIAL OPTIONS */
    $hint = '<div class="template-description">';
        $hint.= '<div class="align-left">';
            $hint .= __( 'This page lets you create new sidebar areas and assign them for your templates or posts.', 'cosmotheme' );
            $hint .= '<br>';
            $hint .= __( "The newly created sidebar will be available at ", 'cosmotheme' );
            $hint .= '<a href="widgets.php">' . __( 'Appearence - Widgets', 'cosmotheme' ) . '</a> ';
            $hint .= __( 'and', 'cosmotheme' ) . ' ';
            $hint .= '<a href="?page=cosmothemes__layouts">' . __( 'Layouts', 'cosmotheme' ) . '</a> ';
        $hint .= '</div>';
    $hint.= '</div>';
    options::$fields['_sidebar']['idrow']               = array('type' => 'st--m-hidden' , 'value' => 1 , 'id' => 'sidebar_title_id' , 'single' => true );
    options::$fields[ '_sidebar' ][ 'hinsat' ]            = array(
        'type' => 'cd--whatever',
        'content' => $hint
    );
    options::$fields['_sidebar']['title']               = array('type' => 'st--text' , 'label' => __( 'Set title for new sidebar','cosmotheme' ) , 'id' => 'sidebar_title' , 'single' => true );
    options::$fields['_sidebar']['save']                = array('type' => 'st--button' , 'value' => 'Add new sidebar' , 'action' => "extra.add( '_sidebar' , { 'input' : [ 'sidebar_title_id' , 'sidebar_title'] })" );

    options::$fields['_sidebar']['struct']              = $struct;
    options::$fields['_sidebar']['hint']                = __( 'List of generic dynamic sidebars<br />Drag and drop blocks to rearrange position' , 'cosmotheme' );

    options::$fields['_sidebar']['list']                = array( 'type' => 'ex--extra' , 'cid' => 'container__sidebar');
    
    /* Custom css */
    options::$fields['custom_css']['css']               = array('type' => 'st--textarea' , 'label' => __( 'Add your custom CSS' , 'cosmotheme' )  );
    

    /*Cosmothemes options*/

	options::$default['cosmothemes']['show_new_version']      = 'yes';
	options::$default['cosmothemes']['show_cosmo_news']      = 'yes';
	options::$fields['cosmothemes']['show_new_version'] = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable notification about new theme version' , 'cosmotheme' ) );
	options::$fields['cosmothemes']['show_cosmo_news']  = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable Cosmothemes news notification' , 'cosmotheme' ) );

    /* tooltips */
    $type = array( 'left' => __( 'Left' , 'cosmotheme' ) , 'right' => __( 'Right' , 'cosmotheme' ) , 'top' => __( 'Top' , 'cosmotheme' ) );
    $res_type = array( 'front_page' => __( 'On front page' , 'cosmotheme' ) , 'single' => __( 'On single post' , 'cosmotheme' ) , 'page' => __( 'On simple page' , 'cosmotheme' ) );
    $res_pages = get__pages( __( 'Select Page' , 'cosmotheme' ) );
    $tooltips = array(
        'layout' => 'A',
        'check-column' => array(
            'name' => 'idrow',
            'type' => 'hidden',
            'classes' => 'idrow'
        ),
        'info-column-0' => array(
            0 => array(
                'name' => 'title',
                'type' => 'text',
                'label' => 'Tooltip title',
                'classes' => 'tooltip-title',
                'before' => '<strong>',
                'after' => '</strong>',
            ),
            1 => array(
                'name' => 'description',
                'type' => 'textarea',
                'label' => 'Tooltip description',
                'classes' => 'tooltip-description'
            ),

            3 => array(
                'name' => 'res_posts',
                'type' => 'search',
                'query' => array( 'post_type' => 'post' , 'post_status' => 'publish' ),
                'label' => '',
                'lvisible' => false,
                'classes' => 'tooltip-res-posts',
                'linked' => array( 'res_type' , 'single' ),
            ),
            4 => array(
                'name' => 'res_pages',
                'type' => 'select',
                'assoc' => $res_pages,
                'label' => '',
                'lvisible' => false,
                'classes' => 'tooltip-res-pages',
                'linked' => array( 'res_type' , 'page' ),
            ),
            5 => array(
                'name' => 'top',
                'type' => 'text',
                'label' => 'Top position',
                'lvisible' => false,
                'classes' => 'tooltip-top'
            ),
            6 => array(
                'name' => 'left',
                'type' => 'text',
                'label' => 'Left position',
                'lvisible' => false,
                'classes' => 'tooltip-left'
            ),
            7 => array(
                'name' => 'type',
                'type' => 'select',
                'assoc' => $type,
                'label' => 'Arrow position',
                'lvisible' => false,
                'classes' => 'tooltip-type'
            ),
        ),
        'actions' => array( 'sortable' => true )
    );
    
    $res_action = "act.select( '#tooltip_res_type' , { 'single' : '.res_posts' , 'page': '.res_pages'  } , 'sh_' )";

    options::$fields[ 'tooltips' ][ 'builder' ]         = array(
        'type' => 'cd--whatever',
        'content' => new TooltipBuilder()
    );
    if( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'cosmothemes__extra' && isset( $_GET[ 'tab' ] ) && 'io' == $_GET['tab'] ){
        $export = array();
        foreach( options::$menu['cosmothemes'] as $option_group_name => $option_group ){
            if( isset($option_group[ 'contains' ] )){
                if( 'templates' == $option_group_name ){
                    $export[$option_group_name] = get_option($option_group_name);
                } else {
                    foreach($option_group[ 'contains' ] as $option_name => $option) {
                        $export[$option_group_name][$option_name] = get_option($option_name);
                    }
                }
            }
        }
        $exportdata = base64_encode( json_encode( $export ) );
    }else{
        $exportdata = '';
    }

    options::$fields[ 'io' ][ 'warning' ] = array(
        'type' => 'cd--whatever',
        'content' => '<h2 class="import-warning">' . __( 'Warning! You WILL lose all your current settings FOREVER', 'cosmotheme' ) . '<br>'
                            . __( 'if you paste the import data and click "Update settings".', 'cosmotheme' ) . '<br>'
                            . __( 'Double check everything!', 'cosmotheme' ) . '</h2><b class="import-warning">' . __( 'Please check settings where pages are assigned. If there is something wrong set them manually.', 'cosmotheme' ) . '</b><div class="clear">&nbsp;</div>'
    );

    options::$fields[ 'io' ][ 'export' ] = array(
        'label' => __( 'This is the export data', 'cosmotheme' ),
        'hint' => __( 'Just copy-paste it', 'cosmotheme' ),
        'type' => 'st--textarea',
        'value' => $exportdata
    );

    options::$fields[ 'io' ][ 'import' ] = array(
        'label' => __( 'This is the import zone', 'cosmotheme' ),
        'hint' => __( 'Paste the import data here', 'cosmotheme' ),
        'type' => 'st--textarea',
        'value' => ''
    );

    if( isset( $_POST[ 'io' ] ) && isset( $_POST[ 'io' ][ 'import' ] ) && strlen( trim( $import = $_POST[ 'io' ][ 'import' ] ) ) ){
        $import = json_decode( base64_decode( $import ), true );
        if( is_array( $import ) && count( $import ) ){
            foreach($import as $option_group_name => $option_group){
                if( 'templates' == $option_group_name ){
                    update_option($option_group_name, $option_group);
                    $builder = new LBTemplateBuilder();
                    $builder->load_all();
                } else {
                    foreach($option_group as $option_name => $option) {
                        update_option( $option_name, $option );
                    }
                }
            }
        }
    }

    ob_start(); 
    ob_clean();
    get_template_part( '/lib/templates/our_themes' );
    $our_themes = ob_get_clean();
    options::$fields['themes']['list_themes'] = array(
        'type' => 'no--our_themes'
        
    );
    
    options::$register['cosmothemes']                   = options::$fields;
?>
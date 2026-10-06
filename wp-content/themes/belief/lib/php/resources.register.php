<?php
    $sidebar_value = extra::select_value( '_sidebar' );

    if(!( is_array( $sidebar_value ) || !empty( $sidebar_value ) ) ){
        $sidebar_value = array();
    }

    /* hide if is full width */
    $classes = 'sidebar_list';

    $position = array( 'left' => __( 'Align Left' , 'cosmotheme' ) , 'right' => __( 'Align Right' , 'cosmotheme' ) );

    /* BOF post type slideshow */
    $res[ 'slideshow' ][ 'labels' ] = array(
        'name' => _x('Slideshow', 'post type general name','cosmotheme'),
        'singular_name' => _x(__('Slideshow','cosmotheme'), 'post type singular name'),
        'add_new' => _x('Add New', __('Slideshow','cosmotheme')),
        'add_new_item' => __('Add New Slideshow','cosmotheme'),
        'edit_item' => __('Edit Slideshow','cosmotheme'),
        'new_item' => __('New Slideshow','cosmotheme'),
        'view_item' => __('View Slideshow','cosmotheme'),
        'search_items' => __('Search Slideshow','cosmotheme'),
        'not_found' =>  __('Nothing found','cosmotheme'),
        'not_found_in_trash' => __('Nothing found in Trash','cosmotheme')
    );
    $res[ 'slideshow' ][ 'args' ] = array(
        'public' => true,
        'hierarchical' => false,
        'menu_position' => 3,
        'supports' => array('title'),
        'exclude_from_search' => true,
        '__on_front_page' => true,
        'menu_icon' => get_template_directory_uri() . '/lib/images/custom.slideshow.png'
    );

    /*=====================================================*/
    /*================------Slideshow-----=================*/
    /*=====================================================*/
    $title_position = array('left' => __( 'On the left' , 'cosmotheme' ), 'right' => __( 'On the right' , 'cosmotheme' ));
    $boxed_layout = array('yes' => __( 'Yes' , 'cosmotheme' ), 'no' => __( 'No' , 'cosmotheme' ));
    $struct[ 'slideshow' ][ 'box' ] = array(
        'layout' => 'B',
        'field-style' => 'line',
        'check-column' => array(
            'name' => 'idrow',
            'type' => 'hidden',
            'evisible' => false,
            'lvisible' => false,
        ),
        'icon-column' => array(
            'name' => 'slide',
            'type' => 'attachment',
            'attach_type' => 'image',
            'width' => 100,
            'height' => 100,
            'evisible' => false,
            'lvisible' => false,
        ),
        'info-column-0' => array(
            array(
                'name' => 'resources',
                'type' => 'hidden',
                'evisible' => true,
                'lvisible' => false,
                'post_link' => true,
            ),
            array(
                'name' => 'type_res',
                'type' => 'hidden',
                'evisible' => false,
                'lvisible' => false,
            ),
            array(
                'name' => 'title',
                'type' => 'text',
                'label' => __( 'Slide title' , 'cosmotheme' ),
                'before' => '<h2>',
                'after' => '</h2>',
                'evisible' => false,
                'lvisible' => true,
            ),
            array(
                'name' => 'title_color',
                'type' => 'color-picker',
                'label' => __( 'Title text color' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => true
            ),
            array(
                'name' => 'title_position',
                'type' => 'select',
                'label' => __( 'Title position' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => false,
                'assoc' => $title_position
            ),  
            array(
                'name' => 'description',
                'type' => 'textarea',
                'label' => __( 'Description' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => true,
                'classes' => 'not-text-slide-option'
            ),
            array(
                'name' => 'description_color',
                'type' => 'color-picker',
                'label' => __( 'Description text color' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => true,
                'classes' => 'not-text-slide-option'
            ),
            array(
                'name' => 'url',
                'type' => 'text',
                'label' => __( 'Custom URL' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => false,
            ),  
            array(
                'name' => 'label',
                'type' => 'text',
                'label' => __( 'Text label for Custom URL (Default value is "Take a tour)' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => false,
            ),  
            array(
                'name' => 'boxed_layout',
                'type' => 'select',
                'label' => __( 'Enable boxed layout' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => false,
                'assoc' => $boxed_layout
            )                                        
        ),
        'actions' => array(
            0 => array( 'slug' => 'edit' , 'label' => 'edit' ,  'args' => array( 'res' => 'slideshow' , 'box' => 'box' , 'post_id' => '' , 'index' => '' , 'selector' => 'div#slideshow_box div.inside div#box_slideshow_box' ) ),
            1 => array( 
                'slug' => 'update' , 
                'label' => 'update' , 
                'args' => array( 
                    'res' => 'slideshow' , 
                    'box' => 'box' , 
                    'post_id' => '' , 
                    'index' => '' , 
                    'data' => array( 
                        'input' =>  "['slideshow-box-slide_id' ,
                                    'slideshow-box-slide' ,
                                    'slideshow-box-title',
                                    'slideshow-box-title_color',
                                    'slideshow-box-first_line',
                                    'slideshow-box-second_line',
                                    'slideshow-box-slider_caption',
                                    'slideshow-box-title_position',
                                    'slideshow-box-description',
                                    'slideshow-box-description_color',
                                    'slideshow-box-url',
                                    'slideshow-box-label',
                                    'slideshow-box-boxed_layout' ]"
                        ),
                        'selector' => 'div#slideshow_box div.inside div#box_slideshow_box'
                 )
            ),
            2 => array( 'slug' => 'del' , 'label' => 'delete' , 'args' => array( 'res' => '' , 'box' => '' , 'post_id' => '' , 'index' => '' , 'selector' => 'div#slideshow_box div.inside div#box_slideshow_box' ) )
        )
    );

    $sl_res = array('none' => __( 'Simple image' , 'cosmotheme' ) , 
                    'post' => __( 'Post' , 'cosmotheme' )
                    );
    

    $form['slideshow']['box']['type_res'] = array(
        'type' => 'st--m-select' ,
        'label' => __( 'Select slider type' , 'cosmotheme') ,
        'value' =>  $sl_res ,
        'action' => "act.select('#type_resource' , {  'post' : '.mis-hint .generic-hint , .slider_resources' }, 'sh_');" ,
        'id' => 'type_resource'
    );
    $form['slideshow']['box'][ 'resources' ]  = array( 'type' => 'st--m-search' , 'label' => __( 'Select a post' , 'cosmotheme' ) , 'classes' => 'slider_resources hidden' , 'query' => array( 'post_type' => 'post' , 'post_status' => 'publish' ) , 'action' => "act.search( this , '-');", 'hint'=>__('Start typing the post title','cosmotheme') );
    $form['slideshow']['box']['slide' ]      = array( 'type' => 'st--m-upload-id' , 'label' => __( 'Upload an image or choose one from media library' , 'cosmotheme') , 'id' => 'box_slide' , 'hint' =>  __( 'If not uploaded will use post\'s Featured image for post sliders.' , 'cosmotheme' ) , 'classes' => 'mis-hint' , 'hclass' => 'hidden' );
    $form['slideshow']['box']['title']      = array(
        'type' => 'st--m-text' ,
        'label' =>  __( 'Slide title' , 'cosmotheme' ) ,
        'hint' => __( 'If not completed will use post title' , 'cosmotheme'  ) ,
        'classes' => 'mis-hint image-slide' ,
        'hclass' => 'hidden'
    );

    $form[ 'slideshow' ][ 'box' ][ 'title_color' ]= array(
        'type' => 'st--m-color-picker',
        'label' => __( 'Title text color' , 'cosmotheme' ),
        'set' => 'slider-title_color',
    );

    $form['slideshow']['box']['title_position'] = array(
        'type' => 'st--m-select' ,
        'label' => __( 'Title position' , 'cosmotheme') ,
        'value' =>  $title_position ,
        'id' => 'title_position'
    );
    $form[ 'slideshow' ][ 'box' ][ 'description' ] = array(
        'type' => 'st--m-textarea',
        'label' => __( 'Description' , 'cosmotheme' ),
        'id' => 'slider_caption',
        //'classes' => 'slider_resources image-slide' ,
    );
    $form[ 'slideshow' ][ 'box' ][ 'description_color' ] = array(
        'type' => 'st--m-color-picker',
        'label' => __( 'Description text color' , 'cosmotheme' ),
        'set' => 'slider-description_color',
        //'classes' => 'slider_resources image-slide' ,
    );
    $form['slideshow']['box']['url']        = array( 'type' => 'st--m-text' , 'label' =>  __( 'Custom URL' , 'cosmotheme' ) , 'hint' => __( 'If not completed then Title will link to the selected post' , 'cosmotheme'  ) , 'classes' => 'mis-hint' , 'hclass' => 'hidden' );
    $form['slideshow']['box']['label']      = array( 'type' => 'st--m-text' , 'label' =>  __( 'Text label for Custom URL' , 'cosmotheme' ) , 'hint' => __( 'Default value is "Take a tour"' , 'cosmotheme'  )  );
    $form['slideshow']['box']['boxed_layout']      = array( 'type' => 'st--m-select' , 'label' =>  __( 'Enable boxed layout' , 'cosmotheme' ), 'value' =>  $boxed_layout , );

    $form['slideshow']['box']['submit']     = array( 'type' => 'st--meta-save' ,  'value' => __( 'Add to slideshow' ,'cosmotheme' ) , 'selector' => 'div#slideshow_box div.inside div#box_slideshow_box'  );

    if(isset($_GET['post'])){
        $slideshow_settings = meta::get_meta( $_GET['post'], 'slidesettings' );
        //var_dump($slideshow_settings['slideshowSource']);
        if( (isset($slideshow_settings['slideshowSource']) && $slideshow_settings['slideshowSource'] == 'none') || !isset($slideshow_settings['slideshowSource'])){
            $add_manual_hint = 'add-manual-hint';
            $add_automat_hint = 'add-automat-hint hidden';
            $number_posts = 'number_posts hidden';    
        }else{
            $add_manual_hint = 'add-manual-hint hidden';
            $add_automat_hint = 'add-automat-hint ';
            $number_posts = 'number_posts ';
        }
    }else{
        $add_manual_hint = 'add-manual-hint';
        $add_automat_hint = 'add-automat-hint hidden';
        $number_posts = 'number_posts hidden';
    }

    $form[ 'slideshow' ][ 'slidesettings' ]      = array(
        
        'slideshowSource' => array(
            'type' => 'st--select',
            'label' => __( 'Slides source' ,   'cosmotheme' ),
            'value' => array(
                'none' => __( 'None(user defined)' ,   'cosmotheme' ),
                'latest_posts' => __( 'Latest posts' ,   'cosmotheme'  ),
                'featured_posts' => __( 'Latest featured posts' ,   'cosmotheme'  )
            ),
            'classes' => 'slide_source', 
            'action' => "act.select('#slide_source' , {  'none' : '.add-manual-hint', 'latest_posts' : '.add-automat-hint, .number_posts' , 'featured_posts' : '.add-automat-hint, .number_posts' }, 'sh_');" ,
            'id' => 'slide_source'
        ),

        'hint-manual' => array(
            'type' => 'st--hint',
            'value' => __( 'Use Additional slideshow items box below to populate your slideshow manualy.' , 'cosmotheme' ),
            'classes' => $add_manual_hint
        ),
        'hint-automat' => array(
            'type' => 'st--hint',
            'value' => __( 'Select this value if you wish to automatically populate your slideshow. Use Additional slideshow items box below to add additional images.' , 'cosmotheme' ),
            'classes' => $add_automat_hint
        ),
        'numberOfPosts' => array(
            'type' => 'st--digit',
            'label' => __( 'Number of posts' ,   'cosmotheme'  ),
            'hint' => __( 'Select number of posts that will be inserted automatically in the slideshow' ,   'cosmotheme'  ),
            'classes' => $number_posts,
            'cvalue' => 5
        ),

    );

    if( isset( $_GET[ 'post' ] ) ){
        $post = get_post( $_GET[ 'post' ] );
    }

    $box[ 'slideshow' ][ 'slidesettings' ]       = array( __( 'Slideshow Settings' , 'cosmotheme' ) , 'normal' , 'low' , 'content' => $form[ 'slideshow' ][ 'slidesettings' ] , 'box' => 'slidesettings' , 'update' => true  );
    $box['slideshow']['box']                = array( __('Additional slideshow items. Compose slideshow (drag and drop items to rearange position)' , 'cosmotheme' ) , 'normal' , 'low' , 'content' => $form['slideshow']['box'] , 'box' => 'box' , 'struct' => $struct['slideshow']['box'] , 'callback' => array( 'get_meta_records' , array( 'slideshow' , 'box' , 'box' ) ) , 'records-title' => __('Slideshow items' , 'cosmotheme' ) );
    $form['slideshow']['manager']['link']   = array( 'type' => 'sh--post-upload' , 'title' => __( 'Manage Slideshow' , 'cosmotheme' ) );

    $box['slideshow']['manager']            = array( __('Manage Slideshow' , 'cosmotheme' ) , 'side' , 'low' , 'content' => $form['slideshow']['manager'] , 'box' => 'manager' );


    resources::$labels['slideshow']         = $res['slideshow']['labels'];
    resources::$type['slideshow']           = $res['slideshow']['args'];
    resources::$box['slideshow']            = $box['slideshow'];

    /* EOF slideshow */


    /* post type event */
    $res[ 'event' ][ 'labels' ] = array(
        'name' => _x('Events', 'post type general name','cosmotheme'),
        'singular_name' => _x(__('Event','cosmotheme'), 'post type singular name'),
        'add_new' => _x('Add New', __('Event','cosmotheme')),
        'add_new_item' => __('Add New Event','cosmotheme'),
        'edit_item' => __('Edit Event','cosmotheme'),
        'new_item' => __('New Event','cosmotheme'),
        'view_item' => __('View Event','cosmotheme'),
        'search_items' => __('Search Event','cosmotheme'),
        'not_found' =>  __('Nothing found','cosmotheme'),
        'not_found_in_trash' => __('Nothing found in Trash','cosmotheme')
    );
    $res[ 'event' ][ 'args' ] = array(
        'public' => true,
        'hierarchical' => false,
        'menu_position' => 4,
        'rewrite' => array( 'slug' => __('event','cosmotheme'), 'with_front' => true ),
        '__on_front_page' => true,
        'supports' => array('title','editor','thumbnail','comments','custom-fields','excerpt'),
        'menu_icon' => get_template_directory_uri() . '/lib/images/custom.event.png',
        'has_archive' => true
    );

    $repeating_options = array('day' => __('Every day','cosmotheme'), 'week' => __('Every week','cosmotheme') ,'month' => __('Every month','cosmotheme') ,'year' => __('Every year','cosmotheme') );

    
    $form[ 'event' ][ 'date' ]['start_date_time']     = array( 
            'type' => 'st--datetimepicker' , 
            'label' => __( '  Event start date' , 'cosmotheme' )
    );
    $form[ 'event' ][ 'date' ]['end_date_time']          = array( 'type' => 'st--datetimepicker' , 'label' => __( '  Event end date' , 'cosmotheme' )  );
    $form[ 'event' ][ 'date' ]['is_repeating']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Is repeating?' , 'cosmotheme' ) , 'cvalue' => 'no', 'action' => "act.check( this , { 'yes' : '.repeating'  } , 'sh');" );
    $form[ 'event' ][ 'date' ]['repeating']         = array( 'type' => 'st--select' , 'label' => __( 'Repeat every' , 'cosmotheme' ) , 'value' => $repeating_options  );

    if( isset( $_GET['post'] ) &&  meta::logic( get_post( $_GET['post']  ) , 'date' , 'is_repeating' ) ){
        $form['event']['date']['repeating']['classes'] = 'repeating';
    }else{
        $form['event']['date']['repeating']['classes'] = 'hidden repeating'; 
    }
    
    $box[ 'event' ][ 'date' ]                   = array( __( 'Event date' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form[ 'event' ][ 'date' ] , 'box' => 'date', 'update' => true );

    $form[ 'event' ][ 'map' ]['map_code']       = array( 'type' => 'st--textarea' , 'label' => __( 'Add map embedded code' , 'cosmotheme' ), 'hint' => sprintf(__( 'For example if you are using google maps, then you can get the embedded code like %s this %s and paste it in the box above. Also make sure to adjust the width and height of the provided embedded code according to your needs.' , 'cosmotheme' ), '<a href="'.get_template_directory_uri().'/lib/images/help_screens/google_maps.png" rel="prettyPhoto">','</a>')   );
    $box[ 'event' ][ 'map' ]                   = array( __( 'Map' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form[ 'event' ][ 'map' ] , 'box' => 'map', 'update' => true );

    $form[ 'event' ][ 'info' ]['venue']          = array( 'type' => 'st--text' , 'label' => __( 'Venue' , 'cosmotheme' )  );
    $form[ 'event' ][ 'info' ]['place']          = array( 'type' => 'st--text' , 'label' => __( 'Place' , 'cosmotheme' )  );
    $form[ 'event' ][ 'info' ]['custominfometa']    = array( 'type' => 'stcm--user_defined_text' , 'label' => __( 'Custom meta' , 'cosmotheme' )  ); /*stcm - standard custom meta (we use this to have a container before the input in which the added alements will be appended)*/
    
    $box[ 'event' ][ 'info' ]                   = array( __( 'Event additional info' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form[ 'event' ][ 'info' ] , 'box' => 'info', 'update' => true );

    

    resources::$labels['event']         = $res['event']['labels'];
    resources::$type['event']           = $res['event']['args'];
    /*=====================================================*/
    
    /* post type testimonials */
    $res['testimonial']['labels'] = array(
        'name' => _x('Testimonials', 'post type general name','cosmotheme'),
        'singular_name' => _x('Testimonial', 'post type singular name','cosmotheme'),
        'add_new' => _x('Add New', __('Testimonial','cosmotheme')),
        'add_new_item' => __('Add New Testimonial','cosmotheme'),
        'edit_item' => __('Edit Testimonial','cosmotheme'),
        'new_item' => __('New Testimonial','cosmotheme'),
        'view_item' => __('View Testimonial','cosmotheme'),
        'search_items' => __('Search Testimonial','cosmotheme'),
        'not_found' =>  __('Nothing found','cosmotheme'),
        'not_found_in_trash' => __('Nothing found in Trash','cosmotheme')
    );
    $res['testimonial']['args'] = array(
        'menu_icon' => get_template_directory_uri() . '/lib/images/custom.testimonial.png',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => __('testimonial','cosmotheme'), 'with_front' => true ),
        'menu_position' => 7,
        'supports' => array('title','editor','thumbnail'),
        '__on_front_page' => true
    );

    /* box for testimonial */
    $form['testimonial']['info']['name']                = array( 'type' => 'st--text' , 'label' => '<strong>' . __( 'Author name' , 'cosmotheme') . '</strong>' );
    $form['testimonial']['info']['title']               = array( 'type' => 'st--text' , 'label' => '<strong>' . __( 'Author title' , 'cosmotheme') . '</strong>' );
    
    $box['testimonial']['info']                         = array( __('Add testimoniall additional info' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['testimonial']['info'] , 'box' => 'info', 'update' => true );
    $box['testimonial']['shcode']                  = array( __('Shortcodes' , 'cosmotheme' ) , 'normal' , 'high'  , 'box' => 'shcode' , 'includes' => 'shcode/main.php' );


    resources::$labels['testimonial']         = $res['testimonial']['labels'];
    resources::$type['testimonial']           = $res['testimonial']['args'];
    resources::$box['testimonial']            = $box['testimonial'];

    /*---------------------BOF "banner" post type--------------------------*/
    $res['banner']['labels'] = array( 
        'name' => _x('Banners', 'post type general name','cosmotheme'),
        'singular_name' => _x('Banner', 'post type singular name','cosmotheme'),
        'add_new' => _x('Add New', __('Banner','cosmotheme')),
        'add_new_item' => __('Add New Banner','cosmotheme'),
        'edit_item' => __('Edit Banner','cosmotheme'),
        'new_item' => __('New Banner','cosmotheme'),
        'view_item' => __('View Banner','cosmotheme'),
        'search_items' => __('Search Banner','cosmotheme'),
        'not_found' =>  __('Nothing found','cosmotheme'),
        'not_found_in_trash' => __('Nothing found in Trash','cosmotheme')
    );
    $res['banner']['args'] = array(
        'menu_icon' => get_template_directory_uri() . '/lib/images/custom.banners.png',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => __('banner','cosmotheme'), 'with_front' => true ),
        'menu_position' => 8,
        'supports' => array('title'),
        'exclude_from_search' => true,
        '__on_front_page' => false
    );

    /* box for banner */
    $form['banner']['info']['script']            = array( 'type' => 'st--textarea' , 'label' => __( 'Banner code' , 'cosmotheme'), 'hint' => __('You can insert your advertisement code here, or just any text or HTML code.','cosmotheme') );

    $form['banner']['info']['banner_img']       = array( 'type' => 'st--upload' , 'label' => __( 'Banner image' , 'cosmotheme') , 'id' => 'post_background' , 'hint' => __( 'Upload or choose image from media library.' , 'cosmotheme' ) );
    $form['banner']['info']['img_link']         = array( 'type' => 'st--text' , 'label' => __( 'Banner image link' , 'cosmotheme') , 'hint' => __('This URL is used if the above image is uploaded, and if available, the image will link to it.','cosmotheme') );
    $form['banner']['info']['class']            = array( 'type' => 'st--text' , 'label' => __( 'Banner class' , 'cosmotheme') , 'hint' => __('Add custom css class if you need it.','cosmotheme') );
    
    $box['banner']['info']                      = array( __('Banner content' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['banner']['info'] , 'box' => 'info', 'update' => true );
    //$box['banner']['shcode']                  = array( __('Shortcodes' , 'cosmotheme' ) , 'normal' , 'high'  , 'box' => 'shcode' , 'includes' => 'shcode/main.php' );


    resources::$labels['banner']         = $res['banner']['labels'];
    resources::$type['banner']           = $res['banner']['args'];
    resources::$box['banner']            = $box['banner'];

    /*---------------------EOF banner post type--------------------------*/


    /*---------------------BOF "boxes" post type--------------------------*/
    $res['box']['labels'] = array(
        'name' => _x('Boxes', 'post type general name','cosmotheme'),
        'singular_name' => _x('Box', 'post type singular name','cosmotheme'),
        'add_new' => _x('Add New', __('Box','cosmotheme')),
        'add_new_item' => __('Add New Box','cosmotheme'),
        'edit_item' => __('Edit Box','cosmotheme'),
        'new_item' => __('New Box','cosmotheme'),
        'view_item' => __('View Box','cosmotheme'),
        'search_items' => __('Search Box','cosmotheme'),
        'not_found' =>  __('Nothing found','cosmotheme'),
        'not_found_in_trash' => __('Nothing found in Trash','cosmotheme')
    );
    $res['box']['args'] = array(
        'menu_icon' => get_template_directory_uri() . '/lib/images/custom.boxes.png',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => __('box','cosmotheme'), 'with_front' => true ),
        'menu_position' => 9,
        'supports' => array('title','editor', 'thumbnail'),
        'exclude_from_search' => true,
        '__on_front_page' => false
    );

    /* box for box */

    $form['box']['info']['box_link']         = array( 'type' => 'st--text' , 'label' => __( 'Box link (optional)' , 'cosmotheme') , 'hint' => __('Make the box image and title clickable by adding a link here (optional)...','cosmotheme') );
    $form['box']['info']['custom_css']            = array( 'type' => 'st--text' , 'label' => __( 'Custom CSS class' , 'cosmotheme'), 'hint' => __('Add a custom CSS class to this box only.','cosmotheme') );
    
    $box['box']['info']                      = array( __('Box options' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['box']['info'] , 'box' => 'info', 'update' => true );
    //$box['box']['shcode']                  = array( __('Shortcodes' , 'cosmotheme' ) , 'normal' , 'high'  , 'box' => 'shcode' , 'includes' => 'shcode/main.php' );


    resources::$labels['box']         = $res['box']['labels'];
    resources::$type['box']           = $res['box']['args'];
    resources::$box['box']            = $box['box'];

    /*---------------------EOF boxes post type--------------------------*/


    /*---------------------BOF teams post type--------------------------*/
    $res[ 'people' ][ 'labels' ] = array(
        'name' => __( 'People', 'cosmotheme' ),
        'singular_name' => __( 'Member', 'cosmotheme' ),
        'add_new' => __( 'Add New Member', 'cosmotheme' ),
        'add_new_item' => __( 'Add New Member', 'cosmotheme' ),
        'edit_item' => __( 'Edit Member', 'cosmotheme' ),
        'new_item' => __( 'New Member', 'cosmotheme' ),
        'view_item' => __( 'View Member', 'cosmotheme' ),
        'search_items' => __( 'Search Member', 'cosmotheme' ),
        'not_found' =>  __( 'Nothing found', 'cosmotheme' ),
        'not_found_in_trash' => __( 'Nothing found in Trash', 'cosmotheme' ),
    );
    $res[ 'people' ][ 'args' ] = array(
        'menu_icon' => get_template_directory_uri() . '/lib/images/custom.team.png',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => __('people','cosmotheme'), 'with_front' => true ),
        'menu_position' => 9,
        'supports' => array( 'title', 'editor','thumbnail','post-formats' ),
        '__on_front_page' => false
    );

    $form[ 'people' ][ 'settings' ][ 'title' ]         = array( 'type' => 'st--text' , 'label' => __( 'Title' , 'cosmotheme') );
    $form[ 'people' ][ 'settings' ][ 'facebook' ]         = array( 'type' => 'st--text' , 'label' => __( 'Facebook' , 'cosmotheme') , 'id' => 'team_facebook', 'hint' => '(i.e. cosmo.themes)' );
    $form[ 'people' ][ 'settings' ][ 'twitter' ]         = array( 'type' => 'st--text' , 'label' => __( 'Twitter' , 'cosmotheme') , 'id' => 'team_twitter', 'hint' => '(i.e. cosmothemes)' );
    $form[ 'people' ][ 'settings' ][ 'linkedin' ]         = array( 'type' => 'st--text' , 'label' => __( 'LinkedIn' , 'cosmotheme') , 'id' => 'team_linkedin', 'hint' => '(i.e. http://www.linkedin.com/company/cosmothemes)' );

    $form['people']['settings']['post_bg']    = array( 'type' => 'st--upload' , 'label' => __( 'Upload or choose image from media library' , 'cosmotheme') , 'id' => 'post_background' , 'hint' => __( 'This will be the background image for this post' , 'cosmotheme' ) );
    $form['people']['settings']['position']   = array( 'type' => 'st--select' , 'label' => __( 'Image background position' , 'cosmotheme' ) , 'value' => array( 'left' => __( 'Left' , 'cosmotheme' ) , 'center' => __( 'Center' , 'cosmotheme' ) , 'right' => __( 'Right' , 'cosmotheme' ) ) );
    $form['people']['settings']['repeat']     = array( 'type' => 'st--select' , 'label' => __( 'Image background repeat' , 'cosmotheme' ) , 'value' => array( 'no-repeat' => __( 'No Repeat' , 'cosmotheme' ) , 'repeat' => __( 'Tile' , 'cosmotheme' ) , 'repeat-x' => __( 'Tile Horizontally' , 'cosmotheme' ) , 'repeat-y' => __( 'Tile Vertically' , 'cosmotheme' ) ) );
    $form['people']['settings']['attachment'] = array( 'type' => 'st--select' , 'label' => __( 'Image background attachment type' , 'cosmotheme' ) , 'value' => array( 'scroll' => __( 'Scroll' , 'cosmotheme' ) , 'fixed' => __( 'Fixed' , 'cosmotheme' ) ) );
    $form['people']['settings']['color']      = array( 'type' => 'st--color-picker' , 'label' => __( 'Set background color for this post' , 'cosmotheme' ) );


    $box[ 'people' ][ 'settings' ]                   = array( __( 'Member settings' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form[ 'people' ][ 'settings' ] , 'box' => 'info', 'update' => true );


    resources::$labels[ 'people' ]         = $res[ 'people' ][ 'labels' ];
    resources::$type[ 'people' ]           = $res[ 'people' ][ 'args' ];
    resources::$box[ 'people' ]            = $box[ 'people' ];

    /*---------------------EOF teams post type--------------------------*/

    /*get post type*/
    if( isset($_GET['post']) && is_numeric($_GET['post']) ) {
        $this_post_type = get_post_type($_GET['post']);
    }elseif(isset($_GET['post_type'])){
        $this_post_type = $_GET['post_type'];
    }else{
        $this_post_type = '';
    }

    $sliders = get__posts( array( 'post_status' => 'publish' , 'post_type' => 'slideshow' ) , '' );

    $form['post']['settings']['featured']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Display featured image inside the post' , 'cosmotheme' ) , 'hint' => __( 'If enabled featured images will be displayed on post page' , 'cosmotheme' ) , 'cvalue' => options::get_value(  'blog_post' , 'enb_featured' ) );
    $form['post']['settings']['related']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show related posts' , 'cosmotheme' ) , 'hint' => __( 'Show related posts on this post' , 'cosmotheme' ) , 'cvalue' => options::get_value(  'blog_post' , 'show_similar' ) );
    
    if (options::logic( 'blog_post' , 'meta' )) {
        $form['post']['settings']['meta']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show post meta' , 'cosmotheme' ) , 'hint' => __( 'Show post meta on this post' , 'cosmotheme' ) , 'cvalue' => options::get_value(  'blog_post' , 'meta' ), 'action' => "act.check( this , { 'yes' : '.post_love'  } , 'sh');" );
        $meta_view_type = array('horizontal' => __('Horizontal','cosmotheme'), 'vertical' => __('Vertical','cosmotheme') );  
        if (isset($_GET['post']) && is_admin()) {
            $settings = meta::get_meta( $_GET['post'] , 'settings' );

            if(isset($settings['meta']) && $settings['meta'] == 'yes'){
                $form['post']['settings']['love']       = array( 'type' => 'st--logic-radio' , 'classes' => 'post_love', 'label' => __( 'Show post like' , 'cosmotheme' ) , 'hint' => __( 'Show post like on this post' , 'cosmotheme' )  , 'cvalue' => options::get_value(  'likes' , 'enb_likes' ) );
            }else{
                $form['post']['settings']['love']       = array( 'type' => 'st--logic-radio' , 'classes' => 'post_love hidden', 'label' => __( 'Show post like' , 'cosmotheme' ) , 'hint' => __( 'Show post like on this post' , 'cosmotheme' )  , 'cvalue' => options::get_value(  'likes' , 'enb_likes' ) );
            }
        } elseif(!isset($_GET['post']) && is_admin()){
             $form['post']['settings']['love']       = array( 'type' => 'st--logic-radio' , 'classes' => 'post_love', 'label' => __( 'Show post like' , 'cosmotheme' ) , 'hint' => __( 'Show post like on this post' , 'cosmotheme' )  , 'cvalue' => options::get_value(  'likes' , 'enb_likes' ) );
        }
    }
    $form['post']['settings']['sharing']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show social sharing' , 'cosmotheme' ) , 'hint' => __( 'Show social sharing on this post'  , 'cosmotheme' ) , 'cvalue' => options::get_value( 'blog_post' , 'post_sharing' ) );
    //$form['post']['settings']['author']     = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show author box' , 'cosmotheme' ) , 'hint' => __( 'Show author box on this post'  , 'cosmotheme' ) , 'cvalue' => options::get_value( 'blog_post' , 'post_author_box' ) );
    $form['post']['settings']['show_feat_on_archive'] = array( 'type' => 'st--logic-radio' , 'label' => __( 'Display featured image on archive pages' , 'cosmotheme' ) ,  'cvalue' => options::get_value( 'blog_post' , 'show_feat_on_archive' ) );
    //$form[ 'post' ][ 'settings' ][ 'enb_navigation' ] = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable navigation for this post' , 'cosmotheme' ) , 'hint' => __( 'If enabled, this post will show links to the next and previous posts.' , 'cosmotheme' )  ,  'cvalue' => options::get_value( 'blog_post', 'enb-next-prev' ) );
    
    
    $form['post']['settings']['post_bg']    = array( 'type' => 'st--upload' , 'label' => __( 'Upload or choose image from media library' , 'cosmotheme') , 'id' => 'post_background' , 'hint' => __( 'This will be the background image for this post' , 'cosmotheme' ) );
    $form['post']['settings']['position']   = array( 'type' => 'st--select' , 'label' => __( 'Image background position' , 'cosmotheme' ) , 'value' => array( 'left' => __( 'Left' , 'cosmotheme' ) , 'center' => __( 'Center' , 'cosmotheme' ) , 'right' => __( 'Right' , 'cosmotheme' ) ) );
    $form['post']['settings']['repeat']     = array( 'type' => 'st--select' , 'label' => __( 'Image background repeat' , 'cosmotheme' ) , 'value' => array( 'no-repeat' => __( 'No Repeat' , 'cosmotheme' ) , 'repeat' => __( 'Tile' , 'cosmotheme' ) , 'repeat-x' => __( 'Tile Horizontally' , 'cosmotheme' ) , 'repeat-y' => __( 'Tile Vertically' , 'cosmotheme' ) ) );
    $form['post']['settings']['attachment'] = array( 'type' => 'st--select' , 'label' => __( 'Image background attachment type' , 'cosmotheme' ) , 'value' => array( 'scroll' => __( 'Scroll' , 'cosmotheme' ) , 'fixed' => __( 'Fixed' , 'cosmotheme' ) ) );
    $form['post']['settings']['color']      = array( 'type' => 'st--color-picker' , 'label' => __( 'Set background color for this post' , 'cosmotheme' ) );

    if( isset( $_GET['post'] ) ){
        $post_format = get_post_format( $_GET['post'] );
    }else{
        $post_format = 'standard';
    }

    $form['post']['format']['type']         = array( 'type' => 'st--select' , 'label' => __( 'Select post format' , 'cosmotheme' ) , 'value' => array(  'standard' => __( 'Standard' , 'cosmotheme' ) , 'video' => __( 'Video' , 'cosmotheme' ) , 'image' => __( 'Image' , 'cosmotheme' ) , 'audio' => __( 'Audio' , 'cosmotheme' )  , 'link' => __( 'Attachment' , 'cosmotheme' ), 'gallery' => __( 'Gallery' , 'cosmotheme' ), 'quote' => __( 'Quote' , 'cosmotheme' ) )  , 'action' => "act.select( '.post_format_type' , { 'video' : '.post_format_video' , 'image' : '.post_format_image' , 'audio' : '.post_format_audio' , 'link' : '.post_format_link', 'gallery' : '.post_format_gallery' } , 'sh_' );" , 'iclasses' => 'post_format_type' , 'ivalue' =>  $post_format );

    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'video' ){
        $form['post']['format']['video']=array('type'=>'ni--form-upload', 'format'=>'video', 'classes'=>"post_format_video", 'post_id'=>$_GET['post']);
    }else{
        $form['post']['format']['video']=array('type'=>'ni--form-upload', 'format'=>'video', 'classes'=>"hidden post_format_video");
    }

    
    $form['post']['format']['init']=array('type'=>"no--form-upload-init");

    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'image' ){
        $form['post']['format']['image']=array('type'=>'ni--form-upload', 'format'=>'image', 'classes'=>"post_format_image", 'post_id'=>$_GET['post']);
    }else{
        $form['post']['format']['image']=array('type'=>'ni--form-upload', 'format'=>'image', 'classes'=>"post_format_image hidden");
    }

    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'gallery' ){
        $form['post']['format']['gallery']=array('type'=>'ni--form-upload', 'format'=>'gallery', 'classes'=>"post_format_gallery", 'post_id'=>$_GET['post']);
    }else{
        $form['post']['format']['gallery']=array('type'=>'ni--form-upload', 'format'=>'gallery', 'classes'=>"post_format_gallery hidden");
    }


    $form['post']['format']['init']=array('type'=>"no--form-upload-init");

    

    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'audio' ){
        $form['post']['format']['audio']=array('type'=>'ni--form-upload', 'format'=>'audio', 'classes'=>"post_format_audio", 'post_id'=>$_GET['post']);
    }else{
        $form['post']['format']['audio']=array('type'=>'ni--form-upload', 'format'=>'audio', 'classes'=>"post_format_audio hidden");
    }
    
    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'link' ){
        $form['post']['format']['link']=array('type'=>'ni--form-upload', 'format'=>'link', 'classes'=>"post_format_link", 'post_id'=>$_GET['post']);
    }else{
        $form['post']['format']['link']=array('type'=>'ni--form-upload', 'format'=>'link', 'classes'=>"post_format_link hidden");
    }

    $box['post']['shcode']                  = array( __('Shortcodes' , 'cosmotheme' ) , 'normal' , 'high'  , 'box' => 'shcode' , 'includes' => 'shcode/main.php' );
    $box['post']['settings']                = array( __('Post Settings' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['post']['settings'] , 'box' => 'settings' , 'update' => true  );
    $box['post']['format']                  = array( __('Post Format' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['post']['format'] , 'box' => 'format' , 'update' => true );
    
        

    $box['post']['layout']                 = array(
        __( 'Page Builder' , 'cosmotheme' ),
        'normal',
        'high',
        'content' => array(
            array(
                'type' => 'cd--whatever',
                'content' => new LBPageResizer()
            )
        ) ,
        'box' => 'builder',
        'update' => true
    );
    
    resources::$type['post']                = array();
    resources::$box['post']                 = $box['post'];

    
    //Create a copy for post box
    $box_copy = array_merge($box['post'], $box[ 'event' ]) ;
    unset($box_copy['format']); //we don't need format for events
    
    resources::$box[ 'event' ]          = $box_copy; /*add boxes for event posts*/


    //Create a copy for post box
    $box_copy_for_team = array_merge($box['post'], $box[ 'people' ]) ;
    /*EDIT THE FORMAT -  WE NEED ONLY STANDARD AND GALLEY   */
    $box_copy_for_team['format']['content']['type']['value'] = array(  'standard' => __( 'Standard' , 'cosmotheme' ) , 'gallery' => __( 'Gallery' , 'cosmotheme' ) );
    
    resources::$box[ 'people' ]          = $box_copy_for_team; /*add boxes for event posts*/



    if(isset($_GET['post'])){
        $the_source = post::get_source($_GET['post']);
    }
    
    
    if (options::logic( 'blog_post' , 'meta' )) {
        $form['post']['settings']['meta']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show post meta' , 'cosmotheme' ) , 'hint' => __( 'Show post meta on this post' , 'cosmotheme' ) , 'cvalue' => options::get_value(  'blog_post' , 'meta' ), 'action' => "act.check( this , { 'yes' : '.post_love'  } , 'sh');" );
        $meta_view_type = array('horizontal' => __('Horizontal','cosmotheme'), 'vertical' => __('Vertical','cosmotheme') );  
        if (isset($_GET['post']) && is_admin()) {
            $settings = meta::get_meta( $_GET['post'] , 'settings' );

            if(isset($settings['meta']) && $settings['meta'] == 'yes'){
                $form['post']['settings']['love']       = array( 'type' => 'st--logic-radio' , 'classes' => 'post_love', 'label' => __( 'Show post like' , 'cosmotheme' ) , 'hint' => __( 'Show post like on this post' , 'cosmotheme' )  , 'cvalue' => options::get_value(  'likes' , 'enb_likes' ) );
            }else{
                $form['post']['settings']['love']       = array( 'type' => 'st--logic-radio' , 'classes' => 'post_love hidden', 'label' => __( 'Show post like' , 'cosmotheme' ) , 'hint' => __( 'Show post like on this post' , 'cosmotheme' )  , 'cvalue' => options::get_value(  'likes' , 'enb_likes' ) );
            }
        } elseif(!isset($_GET['post']) && is_admin()){
             $form['post']['settings']['love']       = array( 'type' => 'st--logic-radio' , 'classes' => 'post_love', 'label' => __( 'Show post like' , 'cosmotheme' ) , 'hint' => __( 'Show post like on this post' , 'cosmotheme' )  , 'cvalue' => options::get_value(  'likes' , 'enb_likes' ) );
        }
    }

    if (options::logic( 'blog_post' , 'page_meta' )) {
        $form['page']['settings']['meta']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show page meta' , 'cosmotheme' ) , 'hint' => 'Show post meta on this page' , 'cvalue' => options::get_value(  'blog_post' , 'page_meta' ), 'action' => "act.check( this , { 'yes' : '.page_love'  } , 'sh');" );
        
        if (isset($_GET['post']) && is_admin()) {
            $settings = meta::get_meta( $_GET['post'] , 'settings' );

            if(isset($settings['meta']) && $settings['meta'] == 'yes'){
                $form[ 'page' ][ 'settings' ][ 'love' ] = array( 
                    'type' => 'st--logic-radio' , 
                    'label' => __( 'Show post like' , 'cosmotheme' ) , 
                    'hint' => __( 'Show post like on this post' , 'cosmotheme' )  ,
                    'cvalue' => options::get_value(  'likes' , 'enb_likes' ),
                    'classes' => 'page_love'
                ); 
            }else{
                $form[ 'page' ][ 'settings' ][ 'love' ] = array( 
                    'type' => 'st--logic-radio' , 
                    'label' => __( 'Show post like' , 'cosmotheme' ) , 
                    'hint' => __( 'Show post like on this post' , 'cosmotheme' )  ,
                    'cvalue' => options::get_value(  'likes' , 'enb_likes' ),
                    'classes' => 'page_love hidden'
                );                 
            }
        } elseif(!isset($_GET['post']) && is_admin()){
            $form[ 'page' ][ 'settings' ][ 'love' ] = array( 
                'type' => 'st--logic-radio' , 
                'label' => __( 'Show post like' , 'cosmotheme' ) , 
                'hint' => __( 'Show post like on this post' , 'cosmotheme' )  ,
                'cvalue' => options::get_value(  'likes' , 'enb_likes' ),
                'classes' => 'page_love'
            );            
        }
      
    }
    $form['page']['settings']['sharing']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show social sharing' , 'cosmotheme' ) , 'hint' => 'Show social sharing on this page' , 'cvalue' => options::get_value( 'blog_post' , 'page_sharing' ) );
    //$form[ 'page' ][ 'settings' ][ 'enb_navigation' ] = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable navigation for this page' , 'cosmotheme' ) , 'hint' => __( 'If enabled, this page will show links to the next and previous pages.' , 'cosmotheme' )  ,  'cvalue' => options::get_value( 'blog_post', 'navigation_page' ) );
    //$form['page']['settings']['author']     = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show author box' , 'cosmotheme' ) , 'hint' => 'Show author box on this page' , 'cvalue' => options::get_value( 'blog_post' , 'page_author_box' ) );
    $form['page']['settings']['post_bg']    = array( 'type' => 'st--upload' , 'label' => __( 'Upload image, or choose from media library.' , 'cosmotheme') , 'id' => 'post_background' , 'hint' => __( 'This will be the background image for this page' , 'cosmotheme' ) );
    $form['page']['settings']['position']   = array( 'type' => 'st--select' , 'label' => __( 'Background position' , 'cosmotheme' ) , 'value' => array( 'left' => __( 'Left' , 'cosmotheme' ) , 'center' => __( 'Center' , 'cosmotheme' ) , 'right' => __( 'Right' , 'cosmotheme' ) ) );
    $form['page']['settings']['repeat']     = array( 'type' => 'st--select' , 'label' => __( 'Background repeat' , 'cosmotheme' ) , 'value' => array( 'no-repeat' => __( 'No Repeat' , 'cosmotheme' ) , 'repeat' => __( 'Tile' , 'cosmotheme' ) , 'repeat-x' => __( 'Tile Horizontally' , 'cosmotheme' ) , 'repeat-y' => __( 'Tile Vertically' , 'cosmotheme' ) ) );
    $form['page']['settings']['attachment'] = array( 'type' => 'st--select' , 'label' => __( 'Background attachment type' , 'cosmotheme' ) , 'value' => array( 'scroll' => __( 'Scroll' , 'cosmotheme' ) , 'fixed' => __( 'Fixed' , 'cosmotheme' ) ) );
    $form['page']['settings']['color']      = array( 'type' => 'st--color-picker' , 'label' => __( 'Set background color for this post' , 'cosmotheme' ) );

    $box['page']['shcode']                  = array( __('Shortcodes' , 'cosmotheme' ) , 'normal' , 'high'  , 'box' => 'shcode' , 'includes' => 'shcode/main.php' );
    $box['page']['settings']                = array( __('Page Settings' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['page']['settings'] , 'box' => 'settings' , 'update' => true  );
    $box['page']['builder']                 = array(
        __( 'Page Builder' , 'cosmotheme' ) ,
        'normal' ,
        'high' ,
        'content' => array(
            array(
                'type' => 'cd--whatever',
                'content' => new LBPageResizer()
            )
        ) ,
        'box' => 'builder' ,
        'update' => true
    );
    
    
    resources::$type['page']                = array();
    resources::$box['page']                 = $box['page'];


?>
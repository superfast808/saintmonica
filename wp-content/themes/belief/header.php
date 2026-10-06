<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 oldie" lang="en"> <![endif]-->
<?php
    function is_facebook(){
        if(!(stristr($_SERVER["HTTP_USER_AGENT"],'facebook') === FALSE)) {
            return true;
        }
    }
?>
<!--[if gt IE 8]><!--> <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> <?php if(is_facebook()){ echo ' xmlns:fb="http://ogp.me/ns/fb#" ';} ?> ><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="robots"  content="index, follow" />
    
    <?php  
        $template = LBTemplate::figure_out_template(); /*initialize template*/
    ?>
    

    <?php 
        if( options::logic( 'blog_post' , 'post_sharing' ) || options::logic( 'blog_post' , 'page_sharing' ) || options::logic( 'general' , 'fb_comments' ) ){ 
            /*BOF if sharing or FB comments are enebled*/
    ?>
    <?php if( is_single() || is_page() ){ ?>
    <meta name="description" content="<?php echo strip_tags(post::get_excerpt($post, $ln=150, false)); ?>" /> 
    <?php }else{ ?>
    <meta name="description" content="<?php echo get_bloginfo('description'); ?>" /> 
    <?php } ?>

    <?php if( is_single() || is_page() ){ ?>
        <meta property="og:title" content="<?php the_title() ?>" />
        <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
        <meta property="og:url" content="<?php the_permalink() ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:locale" content="en_US" /> 
        <meta property="og:description" content="<?php echo get_bloginfo('description'); ?>"/>
        <?php 
            if(options::get_value( 'social' , 'facebook_app_id' ) != ''){
                ?><meta property='fb:app_id' content='<?php echo options::get_value( 'social' , 'facebook_app_id' ); ?>'><?php
            }
            
            global $post;
            $src  = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'thumbnail' );
            if(strlen($src[0])){
                echo '<meta property="og:image" content="'.$src[0].'"/>';     
            }else{
                echo '<meta property="og:image" content="'.get_template_directory_uri().'/fb_screenshot.png"/>';
            }
            
            if(strlen($src[0])){ 
                echo ' <link rel="image_src" href="'.$src[0].'" />';           
            }

            wp_reset_query();   
        }else{ ?>
            <meta property="og:title" content="<?php echo get_bloginfo('name'); ?>"/>
            <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>"/>
            <meta property="og:url" content="<?php echo home_url() ?>/"/>
            <meta property="og:type" content="blog"/>
            <meta property="og:locale" content="en_US"/>
            <meta property="og:description" content="<?php echo get_bloginfo('description'); ?>"/>
            <meta property="og:image" content="<?php echo get_template_directory_uri()?>/fb_screenshot.png"/> 
    <?php
            }

        } /*EOF if sharing or FB comments are enebled*/
    ?>

    <title><?php bloginfo('name'); ?> &raquo; <?php bloginfo('description'); ?><?php if ( is_single() ) { ?><?php } ?><?php wp_title(); ?></title>

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

    <?php
        if( strlen( options::get_value( 'styling' , 'favicon' ) ) ){
            $path_parts = pathinfo( options::get_value( 'styling' , 'favicon' ) );
            if( $path_parts['extension'] == 'ico' ){
    ?>
                <link rel="shortcut icon" href="<?php echo options::get_value( 'styling' , 'favicon' ); ?>" />
    <?php
            }else{
    ?>
                <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
    <?php
            }
        }else{
    ?>
            <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
    <?php
        }
    ?>

    <link rel="profile" href="http://gmpg.org/xfn/11" />

    <!-- ststylesheet -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
        
    <?php
        echo load_google_fonts();
    ?>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <!--[if lt IE 9]>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/autoinclude/ie.css">
    <![endif]-->

        <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->  
    
		<?php if ( options::logic( 'styling' , 'front_end' ) ){ ?>  
		<link rel="stylesheet" type="text/css" href="<?php echo home_url()?>/wp-admin/css/farbtastic.css" />
		<?php } ?>

    <?php if ( options::logic( 'styling' , 'front_end' ) ){ ?>  
    <link rel="stylesheet" type="text/css" href="<?php echo home_url()?>/wp-admin/css/farbtastic.css" />
    <?php } ?>

    <?php             

/*        if( strlen(options::get_value( 'styling' , 'boxed_bg_color' ) ) ){
            $content_title_bg = "background-color: ".options::get_value( 'styling' , 'boxed_bg_color' )."!important";
        }else{
            $content_title_bg = '';
        }*/

        $template_directory_uri = get_template_directory_uri();
        
        $view_posrt_width = options::get_value( 'styling' , 'viewport_width' );
        echo <<<endhtml
            <style type="text/css">
                div.row{width:$view_posrt_width;}
                div.login-box-container{width:$view_posrt_width;}
            </style>
endhtml;

    global $slideshow_autoplay;
    if (isset($template->enable_slideshow) && $template->enable_slideshow == 'yes' && $template->slideshowID != 0){
        if ($template->slideshow_autoplay == 'yes') {
            $slideshow_autoplay = 'true';
            $slideSpeed = 'slideSpeed: ' . $template->slide_speed .', ' ;
        } else { 
            $slideshow_autoplay = 'false'; 
            $slideSpeed = $template->slide_speed;  
            $slideSpeed = '';          
        }
        $transitionSpeed = $template->transition_speed;

        echo '<script type="text/javascript">var slideshowSettings = {autoPlay:' . $slideshow_autoplay. ', '.$slideSpeed.' transitionSpeed: 0.'. $transitionSpeed .'}</script>';
    }

    ?>

    <?php wp_head(); ?>
</head>

<?php 

    $position   = '';
    $repeat     = '';
    $bgatt      = '';
    $background_color = '';
    $background_img ='';

    if( is_single() || is_page() ){
        if (get_post_type() == 'people') {
            $settings = meta::get_meta( $post -> ID , 'info' );
        }else{
            $settings = meta::get_meta( $post -> ID , 'settings' );
        }      

        if( ( isset( $settings['post_bg'] ) && !empty( $settings['post_bg'] ) ) || ( isset( $settings['color'] ) && !empty( $settings['color'] ) ) ){
            if( isset( $settings['post_bg'] ) && !empty( $settings['post_bg'] ) ){ 
                $background_img = "background-image: url('" . $settings['post_bg'] . "');";
            }

            if( isset( $settings['color'] ) && !empty( $settings['color'] ) ){
                $background_color = "background-color: " . $settings['color'] . "; ";
            }

            if( isset( $settings['position'] ) && !empty( $settings['position'] ) ){
                $position = 'background-position: '. $settings['position'] . ';';
            }
            if( isset( $settings['repeat'] ) && !empty( $settings['repeat'] ) ){
                $repeat = 'background-repeat: '. $settings['repeat'] . ';';
            }
            if( isset( $settings['attachment'] ) && !empty( $settings['attachment'] ) ){
                $bgatt = 'background-attachment: '. $settings['attachment'] . ';';
            }
        }else{
            if(get_background_image() == '' && get_bg_image() != ''){ 
                if(get_bg_image() != 'pattern.none.png'){
                    $background_img = 'background-image: url('.get_template_directory_uri().'/lib/images/pattern/'.get_bg_image().');';
                }else{
                    $background_img = '';
                }    
                /*if day or night images are set then we will add 'background-attachment:fixed'   */
                if(strpos(get_bg_image(),'.jpg')){
                    $background_img .= ' background-attachment:fixed';
                }
            }else{
                $background_img = '';
            }
            if(get_content_bg_color() != ''){
                $background_color = "background-color: " . get_content_bg_color() . "; ";
            }
        }
    }else{
        if(get_background_image() == '' && get_bg_image() != ''){
            if(get_bg_image() != 'pattern.none.png'){
                $background_img = 'background-image: url('.get_template_directory_uri().'/lib/images/pattern/'.get_bg_image().');';
            }else{
                $background_img = '';
            }    
            /*if day or night images are set then we will add 'background-attachment:fixed'   */
            if(strpos(get_bg_image(),'.jpg')){
                $background_img .= ' background-attachment:fixed;';
            }
        }else{
            $background_img = '';
        }
        if(get_content_bg_color() != ''){
            $background_color = "background-color: " . get_content_bg_color() . "; ";
        }

        if( strlen( get_background_image() ) ){
            $background_img = '';
        }

        if( strlen( get_background_color() ) ){
            $background_color = '';
        }
    }

    global $full_slideshow;
    if (isset($template->enable_slideshow) && $template->enable_slideshow == 'yes' && $template->slideshowID != 0){
        $slider_class = 'with-slider';
        if ($template -> slideshow_type == 'fullwidth') {
            $full_slideshow = true;
        } else { $full_slideshow = false; }
    } else {
        $slider_class = '';
    }
?>
<body <?php body_class($slider_class); ?> style="<?php echo $background_color ; ?> <?php echo $background_img ; ?>  <?php echo $position; ?> <?php echo $repeat; ?> <?php echo $bgatt; ?>">
   

    <?php  
    wp_localize_script( 'functions', 'mobile_menu_title', array( 'mobile_menu_title' => __('Navigate to...','cosmotheme') ) );

        if( options::logic( 'blog_post' , 'post_sharing' ) || options::logic( 'blog_post' , 'page_sharing' ) || options::logic( 'general' , 'fb_comments' ) || is_element_used($template -> _header_rows, 'login') ){
            /*BOF if sharing or FB comments are enebled, OR login element is used in the header*/
    ?>       
    <script src="http://connect.facebook.net/en_US/all.js#xfbml=1" type="text/javascript" id="fb_script"></script>
    <?php 
        } /*EOF if sharing or FB comments are enebled*/
    ?>

    <div id="page" class="container <?php //if( options::logic( 'styling', 'boxed' ) ) echo 'boxed';?>">
        <div id="fb-root"></div>
        <div class="relative row">
            <?php
                $tooltip_builder = new TooltipBuilder();
                $tooltip_builder -> render_frontend();
            ?>
        </div>
        <?php
            if( options::logic( 'general' , 'fb_comments' ) ){
                if(options::get_value( 'social' , 'facebook_app_id' ) != ''){
        ?>
                    <?php
                        if( is_user_logged_in () ){
                    ?>
                            <script type="text/javascript">
                                FB.getLoginStatus(function(response) {
                                    if( typeof response.status == 'unknown' ){
                                        jQuery(function(){
                                            jQuery.cookie('fbs_<?php echo options::get_value( 'social' , 'facebook_app_id' ); ?>' , null , {expires: 365, path: '/'} );
                                        });
                                    }else{
                                        if( response.status == 'connected' ){
                                            jQuery(function(){
                                                jQuery('#fb_script').attr( 'src' ,  document.location.protocol + '//connect.facebook.net/en_US/all.js#appId=<?php echo options::get_value( 'social' , 'facebook_app_id' ); ?>' );
                                            });
                                        }
                                    }
                                });
                            </script>
                    <?php
                        }
                }
            }
        ?> 
        
        
        <header id="header-container">
            <?php
                /*the following commented code was moved upper because we need this initialized
                 yearlyer to get the template header BG color and template heater text color*/
                /*$template = LBTemplate::figure_out_template();*/
                $template -> render_header();
            ?>
        </header>

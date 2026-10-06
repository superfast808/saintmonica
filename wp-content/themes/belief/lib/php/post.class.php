<?php

class post {
    static $post_id = 0;
    static function get_my_posts( $author){
        $wp_query = new WP_Query( array('post_status' => 'any', 'post_type' => 'post' , 'author' => $author ) );
        if( count( $wp_query -> posts ) > 0 ){
            return true;
        }else{
            return false;
        }
    }
    
    
    static function filter_where( $where = '' ) {
        global $wpdb;
        if( self::$post_id > 0 ){
            $where .= " AND  ".$wpdb->prefix."posts.ID < " . self::$post_id;
        }
        return $where;
    }
        
        
        
    static function search(){ 
        /*used for search inputs to search for posts when user types something*/
        
        $query = isset( $_GET['params'] ) ? (array)json_decode( stripslashes( $_GET['params'] )) : exit;
        $query['s'] = isset( $_GET['query'] ) ? $_GET['query'] : exit;
        
        global $wp_query;
        $result = array();
        $result['query'] = $query['s'];
        
        $wp_query = new WP_Query( $query );
        
        if( $wp_query -> have_posts() ){
            foreach( $wp_query -> posts as $post ){
                $result['suggestions'][] = $post -> post_title;
                $result['data'][] =  $post -> ID;
            }
        }
        
        echo json_encode( $result );
        exit();
    }

    
    static function list_view($post, $template = 'blog_page', $additional_hidden_class_for_load_more = '', $list_view_thumbs_size = '', $show_full_content = false, $hide_excerpt = false, $is_timeline = false, $show_meta = 'yes' ) {
            
            $current_post_format = get_post_format($post->ID);
            if( !post::is_feat_enabled($post->ID)  || !has_post_thumbnail($post->ID)){
                /*if thumbs are disabled for this particular post, it will act the same as 'no_thumb' option*/
                if($current_post_format!="gallery") $list_view_thumbs_size = 'no_thumb';
            }
            $arabic_to_word = array( 0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve' );
            
            $thumb_sizes = array( 'no_thumb' => 0, 'small_thumb' => 2, 'large_thumb' => 4, 'full_width_thumb' => 6 );
            $text_sizes = array( 'no_thumb' => 12, 'small_thumb' => 10, 'large_thumb' => 8, 'full_width_thumb' => 6 );

            $content_class = $arabic_to_word[ $text_sizes[ $list_view_thumbs_size ] ] . ' columns';
            if( $thumb_sizes[ $list_view_thumbs_size ] == 0 || !self::is_feat_enabled($post->ID)){
                $header_class = '';

                $content_class = 'twelve columns';
            }else{
                $header_class = $arabic_to_word[ $thumb_sizes[ $list_view_thumbs_size ] ] . ' columns';
            }
                    

            /*for timeline hardcode the content class*/            
            if($is_timeline && strlen($header_class)){
                $content_class = 'eight columns';
            }

            $size = 'tlist';     
            
            $onclick = self::video_post_click($post);

            /* Set the class for different image sizes */

            if($list_view_thumbs_size == 'small_thumb'){
                $list_image_class = 'list-small-image';
            } elseif($list_view_thumbs_size == 'large_thumb' || $is_timeline){
                $list_image_class = 'list-medium-image';
            } elseif($list_view_thumbs_size == 'full_width_thumb'){
                $list_image_class = 'list-large-image';
            } elseif ($list_view_thumbs_size) {
                $list_image_class = 'list-no-image';
            }
            

            if( $current_post_format=="gallery" ){
                    /* for gallery posts we will show a slidedhow if there are more than 1 images  */
                    ob_start();
                    ob_clean();
                    self::get_post_img_slideshow( $post -> ID, $size );
                    $single_slideshow = ob_get_clean();
                    if(isset($single_slideshow) && strlen($single_slideshow)){
                        $gallery_class = "cosmo-gallery";
                    }else{
                        $gallery_class = "";        
                    }
            }else{
                $gallery_class = "";
            }
        ?>
        <article class="<?php  echo $list_image_class; echo ' '.$additional_hidden_class_for_load_more.' '.$gallery_class.' ' ;?>" >
            
                <?php if( strlen( $header_class ) || $is_timeline ){ 
                        if($is_timeline ){
                            $header_class = 'four columns';
                        }
                    ?>
                <div class="<?php echo $header_class; ?>">
                    <?php  
                        if($is_timeline){
                    ?>
                            <ul class="timeline-elem-meta"> 
                                <li class="timeline-elem-meta-date">
                                    <?php if ($post -> post_type == 'event') { ?>
                                    <a href="<?php echo get_permalink($post->ID); ?>"><span class="number"> <?php echo date_i18n('j', strtotime(self::getRepeatingDateLabel($post, $timeline = true )) ); ?></span><span class="month"> <?php echo date_i18n('M', strtotime(self::getRepeatingDateLabel($post, $timeline = true )) ); ?></span></a>
                                     <?php   } else {?>
                                    <a href="<?php echo get_permalink($post->ID); ?>"><span class="number"> <?php echo date_i18n('j', strtotime($post -> post_date) ); ?></span><span class="month"> <?php echo date_i18n('M', strtotime($post -> post_date) ); ?></span></a> 
                                        <?php } ?>
                                </li>
                                <li class="timeline-elem-meta-format">
                                    <?php echo post::get_post_format_link($post->ID); ?>
                                </li>
                                <li class="time-line-elem-horizontal-line">
                                    
                                </li>
                            </ul>
                    <?php        
                        }
                    ?>
                        <?php if( self::is_feat_enabled($post->ID) && $list_view_thumbs_size != 'no_thumb' ){ ?>
                            <div class="featimg">
                                <?php if ( $current_post_format!="gallery")  { echo '<a href="'. get_permalink($post->ID) .'">'; } ?>
                                <?php
                                    if (has_post_thumbnail($post->ID) || $current_post_format=="gallery") {
                                        if( $current_post_format =="gallery" ){
                                                
                                                if(isset($single_slideshow) && strlen($single_slideshow)){
                                                    echo $single_slideshow;
                                                }
                                        }else{

                                        $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) ,  $size ); 
                                        
                                        ?>

                                        <img src="<?php echo $src[0]; ?>" alt="<?php echo $post->post_title; ?>" />

                                        <?php
                                        
                                    }}

                                ?>
                                <?php if (options::logic('styling', 'stripes')) {  ?>
                                    <div class="stripes" >&nbsp;</div>
                                <?php }?>
                                <?php if ( $current_post_format != "gallery")  { echo '</a>'; } ?> 

                                <?php
                                if ( $current_post_format == 'video') {
                                    echo '<div class="video-post">';
                                    if(isset($onclick)){
                                        $click = "onclick=".$onclick;
                                    }else{
                                        $click = '';
                                    }
                                        
                                    echo '<a href="javascript:void(0);" '.$click.' ><i class="icon-play"></i></a>';
                                    echo '</div>';
                                }
                                ?>
                            </div>

                        <?php } ?>  
                    
                </div>
                <?php } ?>  

                <div class="<?php echo $content_class; ?>">
                    <div class="entry-content">
                        <?php  
                            if(get_post_type($post -> ID) == 'post'){
                                $cat_tax = 'category';    
                            }elseif(get_post_type( $post -> ID) == 'event') {
                                $cat_tax = 'event-category';   
                            }
                            if(isset($cat_tax)){
                                $the_categories = post::get_post_categories($post->ID, $only_first_cat = false, $taxonomy = $cat_tax, $margin_elem_start = '<li>', $margin_elem_end = '</li> ', $delimiter = ''); 
                            }else{
                                $the_categories = '';
                            }
                        ?>                    

                        <ul>
                            <li class="entry-content-title row">
                                <?php  
                                    $eventDateLabel = post::getRepeatingDateLabel($post);
                                    if(strlen($eventDateLabel)){
                                        $the_title_width = ' nine ';
                                        
                                    }else{
                                        $the_title_width = ' twelve ';      
                                    }
                                ?>
                                <div class=" <?php echo $the_title_width; ?>  columns">
                                    <h4>
                                        <a href="<?php echo get_permalink($post->ID); ?>" title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a>
                                    </h4>
                                </div>
                                <?php  
                                    if(strlen($eventDateLabel)){
                                        
                                ?>
                                <div class=" three columns">
                                    <div class="event-date-label"><?php echo $eventDateLabel; ?></div>
                                </div>
                                <?php        
                                    }
                                ?>

                            </li>

                            <?php 
                                if(options::logic( 'blog_post' , 'meta' ) && meta::logic( $post , 'settings' , 'meta' ) && $show_meta == 'yes'){
                            ?>
                            <?php if(strlen(trim($the_categories))){ ?>
                            <li class="entry-content-category">
                                <ul class="category-list">
                                    <?php echo $the_categories; ?>
                                </ul>
                            </li>
                            <?php } ?> 
                            
                            <li class="entry-content-date">
                                <a href="<?php echo get_permalink($post->ID); ?>"><?php echo post::get_post_date($post -> ID);?></a> 
                            </li>
                            <?php } ?>
                            <?php if(!$hide_excerpt ){?>
                                <li class="entry-content-excerpt"> 
                            <?php } ?>
                                <?php
                                    if(!$hide_excerpt ){
                                        if ( $current_post_format == 'audio') {
                                            $audio = new AudioPlayer(); 
                                             echo $audio->processContent( self::get_audio_file( $post -> ID ) );
                                        }
                                    

                                    if ($show_full_content || $current_post_format == "quote") {
                                        echo apply_filters('the_content', filterThePostContent($post->post_content,$post -> ID ) );
                                    }else{ /*show the excerpt (first 400 characters)*/
                                        $ln = options::get_value( 'blog_post' , 'excerpt_lenght_list' );
                                        post::get_excerpt($post, $ln = $ln);
                                    }
                                }
                                
                                ?>
                            <?php if(!$hide_excerpt ){?>
                                </li>
                            <?php } ?>

                            <?php 
                                if(options::logic( 'blog_post' , 'meta' ) && meta::logic( $post , 'settings' , 'meta' ) && $show_meta == 'yes'){
                            ?>
                            <li class="entry-content-meta">
                                <ul class="entry-content-meta-list">
                                    <?php
                                        if( options::logic( 'likes' , 'enb_likes' ) ){
                                    ?>
                                            <li class=" entry-content-meta-likes">
                                                <?php like::content($post->ID,$return = false, $show_icon = false, $show_label = false, $additional_class = 'icon-like');  ?>
                                            </li>
                                    <?php       
                                        }

                                        post::get_post_comment_number($post->ID,$show_label = false);
                                        post::get_views_number_html($post->ID,$show_label = false);
                                    ?>
                                </ul>
                            </li>
                            <?php        
                                }
                            ?>
                        </ul>                           
                    </div>
                </div>        
                <div class="clear"></div>
            
        </article>          
        
        <?php
    }

/*    function news_view($post, $template = 'blog_page', $additional_hidden_class_for_load_more = '', $list_view_thumbs_size = '', $show_full_content = false, $hide_excerpt = false, $show_resized_image = false ) {
            
            if( !post::is_feat_enabled($post->ID)  || !has_post_thumbnail($post->ID)){
                //if thumbs are disabled for this particular post, it will act the same as 'no_thumb' option
                if(get_post_format($post->ID)!="gallery") $list_view_thumbs_size = 'no_thumb';
            }
            $arabic_to_word = array( 0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve' );
            
            $thumb_sizes = array( 'no_thumb' => 0, 'small_thumb' => 4, 'large_thumb' => 6, 'full_width_thumb' => 12 , 'full_width_thumb_news' => 12 );
            $text_sizes = array( 'no_thumb' => 12, 'small_thumb' => 8, 'large_thumb' => 6, 'full_width_thumb' => 12 , 'full_width_thumb_news' => 7);

            $content_class = $arabic_to_word[ $text_sizes[ $list_view_thumbs_size ] ] . ' columns';
            if( $thumb_sizes[ $list_view_thumbs_size ] == 0 || !self::is_feat_enabled($post->ID)){
                $header_class = '';
                $content_class = 'twelve columns';
            }else{
                $header_class = $arabic_to_word[ $thumb_sizes[ $list_view_thumbs_size ] ] . ' columns';
            }
            
            
            if($thumb_sizes[ $list_view_thumbs_size ] != 0 && $thumb_sizes[ $list_view_thumbs_size ] != 12){
                $content_class .= ' lps'; 
            }

            if($show_resized_image && get_post_format($post->ID)!="gallery"){ //show resized image
                $size = 'tlarge';
            }else{ //show cropped image
                $size = 'tlist';    
            }
            
            $onclick = self::video_post_click($post);

            // Set the class for different image sizes 

            if($list_view_thumbs_size == 'small_thumb'){
                $list_image_class = 'small-thumb';
            } elseif($list_view_thumbs_size == 'large_thumb'){
                $list_image_class = 'full-thumb';
            } elseif($list_view_thumbs_size == 'full_width_thumb'){
                $list_image_class = 'full-width';
            } elseif ($list_view_thumbs_size) {
                $list_image_class = 'no_thumb';
            }

        ?>
            <?php
            if( 'above_content' == $list_view_title_position ){?>
                <div class="twelve columns above_image">
                    <h4 class="list-heading">
                        <a href="<?php echo get_permalink($post->ID); ?>" title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a>
                    </h4>
                    
                    <?php post::list_meta($post); ?>
                </div>

            <?php
            }
            ?>

            <?php if( strlen( $header_class ) ){ ?>
            <div class=" <?php echo $header_class . ' ' . $list_image_class ?>">
                    <?php if( self::is_feat_enabled($post->ID) ){ ?>
                        <div class="featimg ">
                            <?php
                                if (has_post_thumbnail($post->ID) || get_post_format($post->ID)=="gallery") {
                                    if( get_post_format($post->ID)=="gallery" ){
                                            // for gallery posts we will show a slidedhow if there are more than 1 images  
                                            ob_start();
                                            ob_clean();
                                            self::get_post_img_slideshow( $post -> ID, $size );
                                            $single_slideshow = ob_get_clean();
                                            if(isset($single_slideshow) && strlen($single_slideshow)){
                                                echo $single_slideshow;
                                            }
                                    }else{

                                    $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) ,  $size ); 
                                    
                                    $caption = image::caption($post->ID);
                                    
                                    ?>

                                    <img src="<?php echo $src[0]; ?>" alt="<?php echo $caption; ?>" />

                                    <?php
                                    
                                }} else{
                                    
                                    ?>

                                    <img src="<?php echo get_template_directory_uri() ?>/images/no.image.570x380.png" alt="" />

                                    <?php
                                    
                                }

                            ?>
                            <?php if (options::logic('styling', 'stripes')) {  ?>
                                <div class="stripes" >&nbsp;</div>
                            <?php }?>                                                        
                            <?php if( get_post_format($post->ID)!="gallery" ) {?>
                            <?php
                            if (get_post_format($post->ID) == 'video') {
                                echo '<div class="item-overlay">';
                                if(isset($onclick)){
                                    $click = "onclick=".$onclick;
                                }else{
                                    $click = '';
                                }
                                    
                                echo '<a href="javascript:void(0);" '.$click.' class="format-video">&nbsp;</a>';
                                echo '</div>';
                            }
                            ?>
                            <?php } ?>  
                        </div>

                    <?php } ?>  
                    
                
            </div>
            <?php } ?>
            <?php if( 'above_excerpt' == $list_view_title_position ){ 
                if('large_thumb' == $list_view_thumbs_size ){
                    $title_width = ' six ';
                }else{
                    $title_width = ' twelve ';
                }
            ?>
                <div class="<?php echo $title_width; ?> columns above_excerpt <?php if($list_view_thumbs_size == 'full_width_thumb'){echo 'full-width-title';}elseif ($list_view_thumbs_size == 'no_thumb') { echo 'full-thumb-title nothumb';} ?>">
                    <h4 class="list-heading">
                        <a href="<?php echo get_permalink($post->ID); ?>" title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a>
                    </h4>
                    
                    <?php post::list_meta($post); ?>
                </div>
            <?php } ?>
            <div class=" <?php echo $content_class; ?>">
                
                <?php if(!$hide_excerpt){?><div class="excerpt <?php if ($list_view_thumbs_size == 'no_thumb') { echo 'nothumb';} ?>"> <?php } ?>
                    <?php
                        if (get_post_format($post->ID) == 'audio') {
                            $audio = new AudioPlayer(); 
                             echo $audio->processContent( self::get_audio_file( $post -> ID ) );
                        }
                    ?>
                    <?php
                    if(!$hide_excerpt){
                        if ($show_full_content || get_post_format($post->ID)=="quote") {
                            echo apply_filters('the_content', $post->post_content);
                            //echo $post -> post_content;
                        }else{ //show the excerpt (first 400 characters)
                            $ln = options::get_value( 'blog_post' , 'excerpt_lenght_list' );
                            post::get_excerpt($post, $ln = $ln);   
                        }
                    }
                    else {}  
                    ?>
                <?php if(!$hide_excerpt){?></div><?php } ?>
            </div>
            
        <?php
    }*/

    static function grid_view_thumbnails($post,  $width = 'three columns', $additiona_class = '', $filter_type = '', $taxonomy = 'category',$element_type = 'article', $is_masonry = false, $show_meta = 'yes') {
        $nofeat_article_class = '';
        if(!post::is_feat_enabled($post->ID) ){
            $nofeat_article_class = 'nofeat';    
        }

        $post_id = $post->ID;
        $formatclass = custom_get_post_format($post->ID);

    ?>
        <?php if(strlen($filter_type)){?>
        <div class=" all-elements masonry_elem <?php echo $width; echo get_distinct_post_terms( $post->ID, $taxonomy, $return_names = true, $filter_type ); ?> " data-id="id-<?php echo $post->ID; ?>" >
        <?php } ?>
        <?php  

            $thumb_view_type = post::get_post_setting($post_id, 'thumb_view_type', ' thumb-image-main ');
            
            if( !(has_post_thumbnail($post->ID) && post::is_feat_enabled($post->ID)) ){
                /*if post has no thumbnail or featured image is not enabled we will have text bu default  and add class 'text-only' that will disable anu hover effect */
                $thumb_view_type = '  thumb-text-main  text-only ';
            }
        ?>
        <<?php echo $element_type; ?>  class=" <?php echo $additiona_class. ' '; ?> thumb-elem ">
            

                <header>
                    <?php  
                        $eventDateLabel = post::getRepeatingDateLabel($post);
                        if(strlen($eventDateLabel)){
                    ?>
                        <div class="event-date-label  ">
                            <?php echo $eventDateLabel; ?>
                        </div>
                    <?php        
                        }
                    ?>
                    <div class="featimg <?php if (!(has_post_thumbnail($post->ID) && post::is_feat_enabled($post->ID) )) echo 'z_index_neg'; ?>">
                        
                        <?php    
                        if (has_post_thumbnail($post->ID) && post::is_feat_enabled($post->ID) ) {
                            
                            $size = 'thumbnails_view';
                            
                            $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) , $size );
                        
                        ?>
                            <img src="<?php echo $img_src[0]; ?>" alt="<?php echo $post->post_title; ?>" />
                                   
                        <?php } else{ ?>
                            <img src="<?php echo get_template_directory_uri() ?>/images/no.image.570x380.png" alt="<?php echo $post->post_title; ?>" />
                        <?php } ?>

                        <?php 
                        if (options::logic('styling', 'stripes') && has_post_thumbnail($post->ID) && post::is_feat_enabled($post->ID)) {
                            ?><div class="stripes">&nbsp;</div><?php
                        }
                        
                        ?>
                        
                    </div>
                </header> 

                <div class="entry-content">
                    <ul>
                        <li class="entry-content-title">
                            <h4><a href="<?php echo get_permalink($post->ID); ?>"  title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a></h4>
                        </li>
                        <?php  
                            if(get_post_type($post -> ID) == 'post'){
                                $cat_tax = 'category';    
                            } elseif(get_post_type( $post -> ID) == 'event') {
                                $cat_tax = 'event-category';   
                            }

                            if(isset($cat_tax)){
                                $the_categories = post::get_post_categories($post->ID, $only_first_cat = false, $taxonomy = $cat_tax, $margin_elem_start = '<li> ', $margin_elem_end = '</li> ', $delimiter = ''); 
                            }else{
                                $the_categories = '';
                            }
                            
                            if(options::logic( 'blog_post' , 'meta' ) && meta::logic( $post , 'settings' , 'meta' ) && $show_meta == 'yes'){
                            
                            if(strlen(trim($the_categories))){
                        ?>
                        <li class="entry-content-category">
                            <ul class="category-list">
                                <?php echo $the_categories; ?>
                            </ul>
                        </li>
                        <?php  
                            }
                        ?>

                        <li class="entry-content-meta">
                            <ul class="entry-content-meta-list">
                                <?php
                                    if( options::logic( 'likes' , 'enb_likes' ) ){
                                ?>
                                        <li class=" entry-content-meta-likes">
                                            <?php like::content($post->ID,$return = false, $show_icon = false, $show_label = false, $additional_class = 'icon-like');  ?>
                                        </li>
                                <?php       
                                    }

                                    post::get_post_comment_number($post->ID,$show_label = false);
                                    post::get_views_number_html($post->ID,$show_label = false);
                                ?>
                            </ul>
                        </li>
                        <?php        
                            }
                        ?>
                        
                    </ul>
                </div>

                
        </<?php echo $element_type; ?>>
        <?php if(strlen($filter_type)){?>
        </div>
        <?php } ?>
    <?php    
    }

    static function timeline_view($post, $hide_excerpt = false, $show_meta = 'yes', $hide_img = false){

        $post_id = $post->ID;
        $formatclass = custom_get_post_format($post->ID);

    ?>
        
            <div class="timeline-elem" >
                <div class="row">
                    
                    <?php  
                        //$additional_hidden_class_for_load_more = 'element';
                        //if( $this -> is_ajax ){
                            $additional_hidden_class_for_load_more = 'element hidden';
                        //}

                        if($hide_img){
                            $list_view_thumbs_size = 'no_thumb';
                        }else{
                            $list_view_thumbs_size = 'large_thumb';
                        }
                        post::list_view( $post, 'front_page', $additional_hidden_class_for_load_more,$list_view_thumbs_size, false, $hide_excerpt, $is_timeline = true, $show_meta );
                    ?>
                    
                    
                </div>
            </div>

        
    <?php    

    }

/*    function news_view_title_list($post){

    ?>  
        <li>
            <span class="date"><?php echo post::get_post_date($post -> ID);?></span>
             <h5><a href="<?php echo get_permalink($post->ID); ?>" title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a></h5>
        </li>
    <?php    
    }*/

    static function banner_view($post){


        $info_meta = meta::get_meta( $post -> ID , 'info' );
        
        if( (isset($info_meta['script']) && strlen($info_meta['script']) ) || (isset($info_meta['banner_img']) && strlen($info_meta['banner_img']) ) ){
            $custom_class = '';    
            if(isset($info_meta['class']) && strlen($info_meta['class'])){
                $custom_class = $info_meta['class'];    
            }

            if(isset($info_meta['img_link']) && strlen($info_meta['img_link'])){
                $start_link = '<a href="'.$info_meta['img_link'].'">';
                $end_link = '</a>';
            }else{
                $start_link = '';
                $end_link = '';
            }

            $banner_script = '';
            if(isset($info_meta['script']) && strlen($info_meta['script'])){
                $banner_script = $info_meta['script'];
            }
            $banner_image = '';
            if(isset($info_meta['banner_img']) && strlen($info_meta['banner_img'])){
                $banner_image = $start_link . '<img src="'.$info_meta['banner_img'].'"/>' . $end_link;
            }

    ?>
        <div class="<?php echo $custom_class; ?>">
            <?php
                echo $banner_script;
                echo $banner_image;   
            ?>
        </div>
    <?php    
        } /*EOF if exists script or image*/
    }

    static function grid_view($post,  $width = 'three columns', $additiona_class = '', $hide_excerpt = false, $element_type = 'article', $is_masonry = false, $is_carousel = false, $show_meta = 'yes') {
            $nofeat_article_class = '';
            if(!post::is_feat_enabled($post->ID)){
                $nofeat_article_class = 'nofeat';    
            }
            $post_id = $post->ID;
            $onclick = self::video_post_click($post);
            
            

            $current_post_format = get_post_format($post->ID);

            $size = 'tlist';     
            
            if( $current_post_format=="gallery" ){
                    /* for gallery posts we will show a slidedhow if there are more than 1 images  */
                    ob_start();
                    ob_clean();
                    self::get_post_img_slideshow( $post -> ID, $size );
                    $single_slideshow = ob_get_clean();
                    if(isset($single_slideshow) && strlen($single_slideshow)){
                        $gallery_class = "cosmo-gallery";
                    }else{
                        $gallery_class = "";        
                    }
            }else{
                $gallery_class = "";
            }
        ?>

        <div data-id="id-<?php echo $post->ID; ?>" class="masonry_elem <?php echo $width.' '.$additiona_class; ?>">
            <<?php echo $element_type; ?> class="grid-elem <?php echo $gallery_class; ?>">
                <?php if(post::is_feat_enabled($post->ID) && (has_post_thumbnail($post->ID) || $current_post_format == "gallery")  ){ ?>  
                <header>   
                    <?php  
                        $eventDateLabel = post::getRepeatingDateLabel($post);
                        if(strlen($eventDateLabel)){
                    ?>
                        <div class="event-date-label  ">
                            <?php echo $eventDateLabel; ?>
                        </div>
                    <?php        
                        }
                    ?>           
                    <div class="featimg">

                        <?php
                        
                        
                        if ( (has_post_thumbnail($post->ID) || $current_post_format == "gallery") ) {
                            if( $current_post_format == "gallery" && !$is_carousel ){
                                   
                                    if(isset($single_slideshow) && strlen($single_slideshow)){
                                        echo $single_slideshow;
                                    }
                            }else{
                                

                                        
                                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , $size );
                                
                                ?>
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <img src="<?php echo $img_src[0]; ?>" alt="<?php echo $post->post_title; ?>" />                                
                                      
                                <?php 
                                    if (options::logic('styling', 'stripes')) {
                                        ?><div class="stripes"></div><?php
                                    } 
                                ?>
                                </a>
                            <?php if ( $current_post_format != 'video'){
                                    echo  post::get_post_format_link($post -> ID);    
                                }
                            }               
                        }
                        ?>
                        
                        <?php
                        if ( $current_post_format == 'video') {
                            echo '<div class="video-post">';
                            if(isset($onclick)){
                                $click = "onclick=".$onclick;
                            }else{
                                $click = '';
                            }
                                
                            echo '<a href="javascript:void(0);" '.$click.' ><i class="icon-play"></i></a>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </header>
                <?php } ?>

                <div class="entry-content">
                    <ul>
                        
                        <li class="entry-content-title"><h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h4></li>
                        
                        <?php  
                            if(get_post_type($post -> ID) == 'post'){
                                $cat_tax = 'category';    
                            } elseif(get_post_type( $post -> ID) == 'event') {
                                $cat_tax = 'event-category';   
                            }else{
                                $cat_tax = '';
                            }
                            
                            if(isset($cat_tax)){
                                $the_categories = post::get_post_categories($post->ID, $only_first_cat = false, $taxonomy = $cat_tax, $margin_elem_start = ' <li>', $margin_elem_end = '</li> ', $delimiter = ''); 
                            }else{
                                $the_categories = '';
                            }

                            if(options::logic( 'blog_post' , 'meta' ) && meta::logic( $post , 'settings' , 'meta' ) && $show_meta == 'yes'){

                            if(strlen(trim($the_categories))){
                        ?>
                        <li class="entry-content-category">
                            <ul class="category-list">
                                <?php echo $the_categories; ?>
                            </ul>
                        </li>
                        <?php  
                            }
                        ?>                           
                        
                        <li class="entry-content-date"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo post::get_post_date($post -> ID);?></a> </li>
                        <?php 
                        }
                            if( $current_post_format == "audio" ){
                        ?>        
                            <li class="entry-content-audio"> 
                                <?php 
                                if( $current_post_format == 'audio' ){
                                    $audio = new AudioPlayer(); 
                                    echo $audio->processContent( self::get_audio_file( $post -> ID ) );
                                }
                                ?>
                            </li>
                        <?php    
                            }
                        ?>
                        <?php if(!$hide_excerpt) {?>
                        <li class="entry-content-excerpt">
                            

                            <?php
                                if( $current_post_format == "quote" ){ /*for 'quote' posts we show the entire content*/
                                    echo apply_filters('the_content', $post->post_content);
                                }else{
                                    $ln = options::get_value( 'blog_post' , 'excerpt_lenght_grid' );
                                    post::get_excerpt($post, $ln = $ln);
                                }   
                            ?>
                        </li>
                        <?php 
                        }
                            if(options::logic( 'blog_post' , 'meta' ) && meta::logic( $post , 'settings' , 'meta' ) && $show_meta == 'yes'){
                        ?>
                        <li class="entry-content-meta">
                            <ul class="entry-content-meta-list">
                                <?php
                                    if( options::logic( 'likes' , 'enb_likes' ) ){
                                ?>
                                        <li class=" entry-content-meta-likes">
                                            <?php like::content($post->ID,$return = false, $show_icon = false, $show_label = false, $additional_class = 'icon-like');  ?>
                                        </li>
                                <?php       
                                    }

                                    post::get_post_comment_number($post->ID,$show_label = false);
                                    post::get_views_number_html($post->ID,$show_label = false);
                                ?>
                            </ul>
                        </li>
                        <?php        
                            }
                        ?>
                    </ul>
                    <div class="clear"></div>
                </div>
    
            </<?php echo $element_type; ?>>

        </div>
        <?php
    }

    static function show_meta_author_box($post){
		$meta = meta::get_meta( $post -> ID , 'settings' );

		  
		if( isset( $meta[ 'author' ] ) && strlen( $meta[ 'author' ] ) && !is_author() ){
			$show_author = meta::logic( $post , 'settings' , 'author' );
		}else{
			if( is_single() ){
				$show_author = options::logic( 'blog_post' , 'post_author_box' );
			}

			if( is_page() ){
				$show_author = options::logic( 'blog_post' , 'page_author_box' );
			}

			if( !( is_single() || is_page() ) ){
				$show_author = true;
			}
		}
        if(1==2){ the_tags(); }
		return $show_author;
	}
  
    
        
        static function get_embeded_video($video_id,$video_type,$autoplay = 0,$width = 570,$height = 414){
        	
        	$embeded_video = '';
        	if($video_type == 'youtube'){
        		$embeded_video	= '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_id.'?wmode=transparent&autoplay='.$autoplay.'" wmode="opaque" frameborder="0" allowfullscreen></iframe>';
        	}elseif($video_type == 'vimeo'){
        		$embeded_video	= '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;autoplay='.$autoplay.'&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';
        	}
        	
        	return $embeded_video;
        }
        
		static function get_local_video($video_url, $width = 570, $height = 414, $autoplay = false ){
			
            $result = '';    
			
            if($autoplay){
                $auto_play = 'true';
            }else{
                $auto_play = 'false';
            }
            
			$result = do_shortcode('[video mp4="'.$video_url.'" width="'.$width.'" height="'.$height.'"  autoplay="'.$auto_play.'"]');
			
			return $result;	
		}
  
        static function get_video_thumbnail($video_id,$video_type){
        	$thumbnail_url = '';
        	if($video_type == 'youtube'){
				$thumbnail_url = 'http://i1.ytimg.com/vi/'.$video_id.'/hqdefault.jpg';
        	}elseif($video_type == 'vimeo'){
        		
				$hash = wp_remote_get("http://vimeo.com/api/v2/video/$video_id.php");
				$hash = unserialize($hash['body']);
				
				$thumbnail_url = $hash[0]['thumbnail_large'];  
        	}
        	
        	return $thumbnail_url;
        }
        
    	static function get_youtube_video_id($url){
	        /*
	         *   @param  string  $url    URL to be parsed, eg:  
	 		*  http://youtu.be/zc0s358b3Ys,  
	 		*  http://www.youtube.com/embed/zc0s358b3Ys
	 		*  http://www.youtube.com/watch?v=zc0s358b3Ys 
	 		*  
	 		*  returns
	 		*  */	
        	$id=0;
        	
        	/*if there is a slash at the en we will remove it*/
        	$url = rtrim($url, " /");
        	if(strpos($url, 'youtu')){
	        	$urls = parse_url($url); 
	     
			    /*expect url is http://youtu.be/abcd, where abcd is video iD*/
			    if(isset($urls['host']) && $urls['host'] == 'youtu.be'){  
			        $id = ltrim($urls['path'],'/'); 
			    } 
			    /*expect  url is http://www.youtube.com/embed/abcd*/ 
			    else if(strpos($urls['path'],'embed') == 1){  
			        $id = end(explode('/',$urls['path'])); 
			    } 
			     
			    /*expect url is http://www.youtube.com/watch?v=abcd */
			    else if( isset($urls['query']) ){ 
			        parse_str($urls['query']); 
			        $id = $v; 
			    }else{
					$id=0;
				} 
        	}	
			
			return $id;
        }
        
        static function  get_vimeo_video_id($url){
        	/*if there is a slash at the en we will remove it*/
        	$url = rtrim($url, " /");
        	$id = 0;
        	if(strpos($url, 'vimeo')){
				$urls = parse_url($url); 
				if(isset($urls['host']) && $urls['host'] == 'vimeo.com'){  
					$id = ltrim($urls['path'],'/'); 
					if(!is_numeric($id) || $id < 0){
						$id = 0;
					}
				}else{
					$id = 0;
				} 
        	}	
			return $id;
		}
        

	    static function isValidURL($url)
		{
			return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
		}


		static function remove_post(){
			if(isset($_POST['post_id']) && is_numeric($_POST['post_id'])){
				$post = get_post($_POST['post_id']);
				if(get_current_user_id() == $post->post_author){
					wp_delete_post($_POST['post_id']);
				}
			}  

			exit;
		}
        
        static function get_source($post_id){
        	/*returns 'post_source' meta data*/
        	$source = '';
  			$source_meta = meta::get_meta( $post_id , 'source' );
  			
  			if(is_array($source_meta) && sizeof($source_meta) && isset($source_meta['post_source']) && trim($source_meta['post_source']) != ''){
  				$source = $source_meta['post_source'];
        		
  			}else{
  				$source = ''; //'<div class="source no_source"><p>'.__('Unknown source','cosmotheme').'</p></div>';
  			}
  			
        
        			
  			return $source;      	
        }



		static function get_attached_file($post_id){
        	
        	$attached_file = '';
  			$attached_file_meta = meta::get_meta( $post_id , 'format' );

            $attached_file = '<div class="attached-files">';
  			
			if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['link_id']) && is_array($attached_file_meta['link_id'])){
				foreach($attached_file_meta['link_id'] as $file_id)
				  {
					$attachment_url = explode('/',wp_get_attachment_url($file_id));
					$file_name = '';
					if(sizeof($attachment_url)){
					  $file_name = $attachment_url[sizeof($attachment_url) - 1];
					}	
					$attached_file .= '<div class="attached-files-elem">';
					$attached_file .= '<a href="'.wp_get_attachment_url($file_id).'">';
                    $attached_file .= '<div class="attached-files-elem-icon"><i class="icon-attachment"></i></div>';
                    $attached_file .= '<div class="attached-files-elem-title">'. $file_name .'</div>';
                    $attached_file .= '</a>';
					$attached_file .= '</div>';
				  }
			}else if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['link_id']))
			  {
				$file_id=$attached_file_meta['link_id'];
				$attachment_url = explode('/',wp_get_attachment_url($file_id));
					$file_name = '';
					if(sizeof($attachment_url)){
					  $file_name = $attachment_url[sizeof($attachment_url) - 1];
					}	
					$attached_file .= '<div class="attached-files-elem">';
                    $attached_file .= '<a href="'.wp_get_attachment_url($file_id).'">';
                    $attached_file .= '<div class="attached-files-elem-icon"><i class="icon-attachment"></i></div>';
                    $attached_file .= '<div class="attached-files-elem-title">'. $file_name .'</div>';
                    $attached_file .= '</a>';
					$attached_file .= '</div>';
			  }
  			$attached_file .= '</div>';

  			return $attached_file;      	
        }

		static function get_audio_file($post_id){
        	$attached_file = '';
  			$attached_file_meta = meta::get_meta( $post_id , 'format' );
  			
			if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['audio']) && is_array($attached_file_meta['audio'])){

				foreach($attached_file_meta['audio'] as $audio_id)
				  {
					$attached_file .= '[audio:'.wp_get_attachment_url($audio_id).']';
				  }				
			}else if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['audio']) && $attached_file_meta['audio'] != '' ){
			  $attached_file .= '[audio:'.$attached_file_meta['audio'].']';
			}
  					
  			return $attached_file;      	
        }
        
        static function play_video($width=570, $height=414){
            $result = '';   

            if(isset($_POST['width']) && is_numeric($_POST['width']) && isset($_POST['height']) && is_numeric($_POST['height'])){
                $width = $_POST['width'];
                $height = $_POST['height'];
            }

            if(isset($_POST['video_id']) && isset($_POST['video_type']) && $_POST['video_type'] != 'self_hosted'){  
                $result = self::get_embeded_video($_POST['video_id'],$_POST['video_type'],1,$width, $height);
            }else{
                $video_url = urldecode($_POST['video_id']);
                $result = self::get_local_video($video_url, $width, $height, true );
            }   
            
            echo $result;
            exit;
        }        
        

         /*check if showing featured image on archive pages is enabled*/
        public static function is_feat_enabled($post_id){
            
            if(options::get_value( 'blog_post' , 'show_feat_on_archive' ) == 'no'){
                return false;
            }else{
                $meta = meta::get_meta( $post_id , 'settings' );
                if(isset($meta['show_feat_on_archive']) && $meta['show_feat_on_archive'] == 'yes'){
            
                    return true;
                }elseif(isset($meta['show_feat_on_archive']) && $meta['show_feat_on_archive'] == 'no'){
                    return false;
                }else{
                    return true;
                }
            }

        }

        static function get_post_date($post_id){
            if (options::logic('general', 'time')) {
                 $post_date = human_time_diff(get_the_time('U', $post_id), current_time('timestamp')) . ' ' . __('ago', 'cosmotheme'); 
            } else {
                $post_date = __('on','cosmotheme'). ' '.date_i18n(get_option('date_format'), get_the_time('U', $post_id)); 
            }

            return $post_date .' ';
        }

        
        static function get_post_categories($post_id, $only_first_cat = false, $taxonomy = 'category', $margin_elem_start = '', $margin_elem_end = '', $delimiter = ', ',  $a_class = '', $no_link = false){

            
                            
            $cat = '';
            $categories = wp_get_post_terms($post_id, $taxonomy );
            if (!empty($categories)) {
                
                $ind = 1;
                foreach ($categories as $category) {
                    $categ = $category;
                    if($ind != count($categories) && !$only_first_cat){
                        $cat_delimiter = $delimiter;   
                    }else{
                        $cat_delimiter = '';   
                    }

                    if($no_link){
                        $cat .= $margin_elem_start . $categ->name . $cat_delimiter  . $margin_elem_end;
                    }else{
                        $cat .= $margin_elem_start . '<a href="' . get_category_link($category) . '" class="'.$a_class.'">' . $categ->name . $cat_delimiter . '</a>' . $margin_elem_end;    
                    }
                    
                    
                    if($only_first_cat){
                        break;    
                    }
                    

                    $ind ++;
                }
                
                
                //$cat = __('in','cosmotheme').' '.   $cat;   
            }
                            
              return $cat .' ' ;
        }

        
        static function load_more(){
            $response = array();
            if(isset($_POST['action']) ){

                $id = $_POST[ 'id' ];
                $row_id = $_POST[ 'row_id' ];
                $template_id = $_POST[ 'template_id' ];

                $all_templates = get_option( 'templates' );
                $data = $all_templates[$template_id];

                $template = new LBTemplate( $data );
                $element = $template -> rows[ $row_id ] -> elements[ $id ];

                $is_ajax = true;

                $nonce = $_POST['getMoreNonce'];

                // check to see if the submitted nonce matches with the
                // generated nonce we created earlier
                if ( ! wp_verify_nonce( $nonce, 'myajax-getMore-nonce' ) )
                    die ( 'Busted! Wrong Nonce');

                /*Done with check, now let's do some real work*/

                $element -> view = $_POST['view']; 
                $element -> carousel = 'no'; 
                $element ->  paged = $_POST['current_page'] + 1;
                $element ->  is_ajax = true;

                if(isset($_POST['timeline_class']) && strlen(trim($_POST['timeline_class']))){ /*this is the class of the last elem from timeleine*/
                    $element -> timeline_class = $_POST['timeline_class']; 
                }

                $type = $_POST['type'];
                global $wp_query;
                ob_start();
                ob_clean();
                if( $element -> row -> is_additional ){
                    $element -> restore_query();
                    $element -> render_frontend_posts( $wp_query -> posts );
                }else{
                    call_user_func( array ( $element, "render_frontend_$type" ) );
                }
                $content = ob_get_clean();
                $response['content'] = $content;
                $response['current_page'] = $element ->  paged;
                $response['need_load_more'] = ( $wp_query -> query_vars[ 'paged' ] < $wp_query -> max_num_pages );
                wp_reset_query();
            }

            echo json_encode($response);
            exit;    
        }

        static function get_post_img_slideshow($post_id, $size="tlist_tlarge"){
            $attachments = get_children(array('post_parent' => $post_id,
                        'post_status' => 'inherit',
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'order' => 'ASC',
                        'orderby' => 'menu_order ID'));


            
            if(count($attachments) > 0){
            ?>

                    <div class="es-carousel-wrapper single_carousel <?php if(count($attachments) == 1){ echo 'one-img'; } ?>">    
                        <div class="es-carousel">
                            <ul class="elastislide">

                       

                        
            <?php          
                $pretty_colection_id = mt_rand(0,9999);
                $current_slide = 1;
                foreach($attachments as $att_id => $attachment) {
                    $full_img_url = wp_get_attachment_url($attachment->ID);
                    $thumbnail_url= wp_get_attachment_image_src( $attachment->ID, $size);

                    if($current_slide > 1){ $hide_element = "display:none;"; }else{ $hide_element = ''; }
            ?>            
                    <li style="<?php echo $hide_element; ?>">
                        <div class="relative">
                            
                                <img src="<?php echo $thumbnail_url[0]; ?>" alt="" />
                            
                            <?php if( options::logic( 'blog_post' , 'enb_lightbox' )){ ?>
                            <div class="zoom-image">
                                <a href="<?php echo $full_img_url; ?>" rel="prettyPhoto[<?php echo $pretty_colection_id; ?>]" title="">&nbsp;</a>
                            </div>
                            <?php } if (options::logic('styling', 'stripes')) {  ?>
                                <div class="stripes" >&nbsp;</div>
                            <?php }?>
                        </div>
                    </li>
            <?php    
                    $current_slide++;
                }
            ?>
                            </ul>
                        </div>
                    </div>
            <?php    
            }    
        }
        
        static function get_excerpt($post, $ln, $output = true){
            if (!empty($post->post_excerpt)) {
                if (strlen(strip_tags(strip_shortcodes($post->post_excerpt))) > $ln) {
                    $excerpt = mb_substr(strip_tags(strip_shortcodes($post->post_excerpt)), 0, $ln) . '<a href="' . get_permalink($post->ID) . '">... ['.__('read more','cosmotheme').']</a>';
                } else {
                    $excerpt = strip_tags(strip_shortcodes($post->post_excerpt));
                }
            } else {
                if (strlen(strip_tags(strip_shortcodes($post->post_content))) > $ln) {
                    $excerpt = mb_substr(strip_tags(strip_shortcodes($post->post_content)), 0, $ln) . '<a href="' . get_permalink($post->ID) . '">... ['.__('read more','cosmotheme').']</a>';
                } else {
                    $excerpt = strip_tags(strip_shortcodes($post->post_content));
                }
            }
            if ($output == true) {
                echo $excerpt;
            }else{
                return $excerpt;
            }
            
        }

        static function get_post_views($post_id){
            /*if if stats module from JetPak plugin is enabled, we save number of views in a meta data for the given post */
            if ( function_exists('stats_get_csv')   ){ 
                
                $post_stats = stats_get_csv( 'postviews' , "&post_id=" . $post_id);    
                
                if ( is_array( $post_stats ) && sizeof( $post_stats ) ) { 
                    foreach ( $post_stats as $post ){ 
                        if( isset($post['views']) ){
                            update_post_meta($post_id, 'nr_views', $post['views']);
                        }
                    }
                }
            }
        }


        /*outputs the number of comments for a given post */
        static function get_post_comment_number($post_id,$show_label = false){
            if (comments_open($post_id)) {
                $comments_label = __('replies','cosmotheme');
                if (options::logic('general', 'fb_comments')) {
                    ?>
                            <li class="entry-content-meta-comments" title="">
                                <a href="<?php echo get_comments_link($post_id); ?>" >
                                    <span class="count">
                                        <i class="icon-comments"></i>
                                        <fb:comments-count href="<?php echo get_permalink($post_id) ?>"></fb:comments-count>
                                    </span>
                                    <?php if($show_label){ ?>
                                    <span><?php echo $comments_label; ?></span>
                                    <?php } ?>
                                </a>
                            </li>
                    <?php
                } else {
                    if(get_comments_number($post_id) == 1){
                        $comments_label = __('reply','cosmotheme');    
                    }
                    ?>
                            <li class="entry-content-meta-comments" title="<?php echo get_comments_number($post_id); ?> Comments">
                                <a href="<?php echo get_comments_link($post_id); ?>" >
                                    <span class="count"><i class="icon-comments"></i><?php echo get_comments_number($post_id) ?></span>
                                    <?php if($show_label){ ?>
                                    <span class="comments_label"><?php echo $comments_label; ?></span>
                                    <?php } ?>
                                </a>
                            </li>
                    <?php
                }
            }
        }

        /*outputs the number of views for a given post */
        static function get_views_number_html($post_id,$show_label = false){

            if ( function_exists( 'stats_get_csv' ) ){  
            $views = stats_get_csv( 'postviews' , "&post_id=" . $post_id);    
        ?>
            <li class="entry-content-meta-views">
                <a href="<?php echo get_permalink($post_id); ?>" class="views">    
                    <span class="count"><i class="icon-views"></i>
                    <?php echo (int)$views[0]['views']; ?>
                    </span>
                    <?php if($show_label){ ?>
                    <span class="views_label">
                    <?php
                        if( (int)$views[0]['views'] == 1) {
                            _e( 'view' , 'cosmotheme');
                        }else{
                            _e( 'views' , 'cosmotheme' );
                        } 
                    ?>
                    </span>
                    <?php } ?>
                </a>
            </li>
        <?php }
        }

        static function box_view($post,  $width = 'three columns', $additiona_class = '') {

            $info_meta = meta::get_meta( $post -> ID , 'info' );

            if( has_post_thumbnail( $post -> ID  ) ){ 
                $box_img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ), 'tlist' );
                $box_img_src = $box_img_src[0];
            }else{
                $box_img_src = '';
            }

            /*skin - the bg color for the box*/
            if(isset($info_meta['skin']) && strlen(trim($info_meta['skin'])) ){
                $skin = $info_meta['skin'];
            }else{
                $skin = ' skin-0 ';
            }

            $link_start = '';
            $link_end = '';
            if(isset($info_meta['box_link']) && post::isValidURL($info_meta['box_link']) ){
                $link_start = '<a href="'.$info_meta['box_link'].'" target="_blank">';
                $link_end = '</a>';
            }

            $custom_class = '';
            if(isset($info_meta['custom_css']) && strlen(trim($info_meta['custom_css'])) ){
                $custom_class = $info_meta['custom_css'];
            }
        ?>
        <div class="cosmobox <?php echo $width .' '.$additiona_class.' '.$custom_class; ?>">
            <article class="box ">
                <?php if(strlen($box_img_src)){ ?>
                    <header>
                        <div class="featimg">
                            <?php
                            echo $link_start;
                            ?>
                            <img src="<?php echo $box_img_src; ?>" alt="<?php echo $post->post_title; ?>"/>
                            <?php
                            echo $link_end;
                            ?>
                        </div>
                    </header>
                
                <?php } ?>
                <div class="entry-content">
                    <ul>
                        <li class="entry-content-title"><h4><?php echo $link_start . $post -> post_title . $link_end; ?></h4></li>
                        <li class="entry-content-excerpt"><p><?php echo do_shortcode($post -> post_content); ?></p></li>
                    </ul>
                </div>
            </article>
        </div>

        <?php
        }


    static function render_team( $team, $options, $is_first_child ){
        extract( $options );
        $default_meta = array(
            'img_id' => 0,
            'title' => '',
            'facebook' => '',
            'twitter' => '',
            'linkedin' => ''
        );
        $meta = meta::get_meta( $team -> ID, 'info' );
        foreach( $meta as $entry_key => $entry_value ){
            if( strlen( $entry_value ) ){
                $default_meta[ $entry_key ] = $entry_value;
            }
        }

        extract( $default_meta );
        
        if( has_post_thumbnail( $team -> ID  ) ){ 
            $img = wp_get_attachment_image_src( get_post_thumbnail_id( $team -> ID ), 'team' );
            $img = $img[0];
        }else{
            $img = get_template_directory_uri() . '/images/default_avatar_100.jpg';
        }

        ?>
        <div class="<?php echo $columns;?> columns">
            <article class="team-elem">
                <header>
                    <div class="featimg">
                        <a href="<?php echo get_permalink($team->ID); ?>" title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $team->post_title; ?>" rel="bookmark">
                            <img src="<?php echo $img;?>" alt="<?php echo $team -> post_title;?>" />
                        
                        <?php if (options::logic('styling', 'stripes')) {  ?>
                            <div class="stripes" >&nbsp;</div>
                        <?php }?>
                        </a>
                        <div class="entry-content-category">
                            <?php  
                                echo post::get_post_categories($team -> ID, $only_first_cat = true, $taxonomy = 'people-group', $margin_elem_start = '', $margin_elem_end = '', $delimiter = '',  $a_class = '', $no_link = true);
                            ?>
                        </div>
                        
                    </div>
                </header>
                <div class="entry-content">
                    <ul>
                        <li class="entry-content-title">
                            <h4>
                                <a href="<?php echo get_permalink($team->ID); ?>" title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $team->post_title; ?>" rel="bookmark">
                                    <?php echo $team -> post_title;?>
                                </a>
                            </h4>
                        </li>
                        <?php if( strlen( $title ) ){ ?>
                        <li class="entry-content-subtitle"><h5><?php echo $title; ?></h5></li>
                        <?php } ?>
                        <li class="entry-content-excerpt">
                            <?php 
                                $ln = options::get_value( 'blog_post' , 'excerpt_lenght_grid' );
                                post::get_excerpt($team, $ln = $ln);
                            ?>
                        </li>
                        <?php if( strlen( $facebook ) || strlen( $twitter ) || strlen( $linkedin ) ){ ?>
                            <li class="entry-content-social">
                                <div class="socialicons">
                                    <ul class="cosmo-social">
                                        <?php if( strlen( $twitter ) ){ ?>
                                        <li>
                                            <a href="http://twitter.com/<?php echo $twitter;?>" class="twitter"><i class="icon-twitter"></i></a>
                                        </li>
                                        <?php } ?>
                                        <?php if( strlen( $facebook ) ){ ?>
                                        <li>
                                            <a href="http://facebook.com/people/@/<?php echo $facebook;?>" class="fb"><i class="icon-facebook"></i></a>
                                        </li>
                                        <?php } ?>
                                        <?php if( strlen( $linkedin ) ){ ?>
                                        <li>
                                            <a href="<?php echo $linkedin;?>" class="linkedin"><i class="icon-linkedin"></i></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>

                            
                        <?php } ?>
                        
                    </ul>
                </div>
            </article>
        </div>
        <?php
        }

        static function list_meta($post){
            ?>
            <div class="entry-meta">
                <ul>
                    <li>
                        <ul class="category st">
                            <?php 
                                $cat_tax = 'category';
                                echo post::get_post_categories($post->ID, $only_first_cat = false, $taxonomy = $cat_tax, $margin_elem_start = '<li>', $margin_elem_end = '</li>', $delimiter = ''); 
                            ?>
                        </ul>
                    </li>
                    <li class="author st"><a href="<?php echo get_author_posts_url($post->post_author) ?>"><?php echo sprintf(__('by %s','cosmotheme'),get_the_author_meta('display_name', $post->post_author)); ?></a></li>
                    <li class="entry-date st"><?php echo post::get_post_date($post -> ID); ?></li>
                </ul>
            </div>
            <?php
        }

        static function list_meta_single($post){
            $post_id = $post -> ID;
            if (comments_open($post -> ID) || function_exists( 'stats_get_csv' ) || options::logic( 'likes' , 'enb_likes' ) ) {
            ?>    
            <div class="entry-info">
                <ul class="">
                    <?php
                        if (comments_open($post_id)) {
                            if (options::logic('general', 'fb_comments')) {
                                ?>
                                        <li class="metas-big" title="">
                                            <a href="<?php echo get_comments_link($post_id); ?>" >
                                                <span class="comments">
                                                    <em><?php _e('Comments','cosmotheme'); ?></em>
                                                    <i><fb:comments-count href="<?php echo get_permalink($post_id) ?>"></fb:comments-count></i>
                                                </span>
                                            </a>
                                        </li>
                                <?php
                            } else {
                                if(get_comments_number($post_id) == 1){
                                    $comments_label = __('reply','cosmotheme');    
                                }
                                ?>
                                    <li class="metas-big" title="">
                                        <a href="<?php echo get_comments_link($post_id); ?>" >
                                            <span class="comments">
                                                <em><?php _e('Comments','cosmotheme'); ?></em>
                                                <i><?php echo get_comments_number($post_id) ?></i>
                                            </span>
                                        </a>
                                    </li>    
                                <?php
                            }
                        }
                    ?>
                    
                    <?php
                        if ( function_exists( 'stats_get_csv' ) ){  
                        $views = stats_get_csv( 'postviews' , "&post_id=" . $post_id);    
                    ?>
                    <li class="metas-big">
                        <a href="<?php echo get_permalink($post_id); ?>" >
                            <span class="views">
                                <em><?php _e('Views','cosmotheme'); ?></em>
                                <i><?php echo (int)$views[0]['views']; ?></i>
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php 
                        if( options::logic( 'likes' , 'enb_likes' ) ){ 
                        //$icon_type = options::get_value( 'likes' , 'icons' ); /*for example heart, star or thumbs*/  
                    ?>
                    
                    <li class="metas-big <?php //echo $icon_type; ?>">
                        <?php like::content($post->ID,$return = false, $show_icon = true, $show_label = true);  ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <?php                            
            }
        }

        
        /**
         * This function will receive the skin name entered by user and will return a 'clean'  name
         * that can be used as a css class
         *
         * @param int $post_id - the ID of the option  -> will be used to create class name
         * @param string $setting_name - the name of the setting you want to receive
         * @param string $default_value - the default value that will be returned if the needed setting was not saved yet (posts were created before installing the theme)
         *      
         * @return various - the value of the requested option
         */
        static function get_post_setting($post_id, $setting_name, $default_value){
            $meta = meta::get_meta( $post_id, 'settings' );
            if(isset($meta[$setting_name]) && strlen($meta[$setting_name])){
                return $meta[$setting_name];
            }else{
                return $default_value;
            }
        }

        static function get_post_format_link($post_id){
            
            $result = '';    
            $format = get_post_format( $post_id );
            $format_link = get_post_format_link($format);
            if(!strlen($format_link)){
                $format_link = "javascript:void(0);";
            }

            $result = '<div class="post-type">';
            switch ($format) {
                case 'video':
                    $result .= '<a class="entry-format" href="'.$format_link.'"><i class="icon-video"></i></a>';
                    break;
                case 'image':
                    $result .= '<a class="entry-format" href="'.$format_link.'"><i class="icon-image"></i></a>';
                    break;
                case 'audio':
                    $result .= '<a class="entry-format" href="'.$format_link.'"><i class="icon-audio"></i></a>';
                    break;
                case 'link':
                    $result .= '<a class="entry-format" href="'.$format_link.'"><i class="icon-attachment"></i></a>';
                    break;    
                case 'gallery':
                    $result .= '<a class="entry-format" href="'.$format_link.'"><i class="icon-gallery"></i></a>';
                    break;  
                case 'quote':
                    $result .= '<a class="entry-format" href="'.$format_link.'"><i class="icon-quote"></i></a>';
                    break;                            
                default:
                    $result .= '<a class="entry-format" href="'.$format_link.'"><i class="icon-standard"></i></a>';
                    break;
            }
            $result .= '</div>';
            
            return $result;
        }  

        
        static function video_post_click($post){
            /* check and initialize play action for video posts, if not video post the function will return false */

            if( get_post_format( $post -> ID ) == 'video' ){
                $format = meta::get_meta( $post -> ID , 'format' );

                if( isset( $format['feat_id'] ) && !empty( $format['feat_id'] ) )
                  {
                    $video_id = $format['feat_id'];
                    $video_type = 'self_hosted';
                    if(isset($format['feat_url']) && post::isValidURL($format['feat_url']))
                      {
                        $vimeo_id = post::get_vimeo_video_id( $format['feat_url'] );
                        $youtube_id = post::get_youtube_video_id( $format['feat_url'] );
                        
                        if( $vimeo_id != '0' ){
                          $video_type = 'vimeo';
                          $video_id = $vimeo_id;
                        }

                        if( $youtube_id != '0' ){
                          $video_type = 'youtube';
                          $video_id = $youtube_id;
                        }
                      }
    
                    if($video_type == 'self_hosted'){
                        $onclick = '\'playVideo("'.urlencode(wp_get_attachment_url($video_id)).'","'.$video_type.'",jQuery(this).parents(".featimg"),jQuery(this).parent().width(),jQuery(this).parent().width()/1.5)\'';
                    }else{
                        $onclick = '\'playVideo("'.$video_id.'","'.$video_type.'",jQuery(this).parents(".featimg"),jQuery(this).parent().width(),jQuery(this).parent().width()/1.5)\'';
                    }    
                    
                }
            }

            if(isset($onclick)){
                return  $onclick;
            }else{
                return  false;
            }
        }

        static function getRepeatingDateLabel($post, $timeline = false ){
            if(isset($post -> post_type ) && $post -> post_type == 'event'){
                $event_program = meta::get_meta( $post->ID, 'date' );
                $start_date = $event_program['start_date_time']; 
                $end_date = $event_program['end_date_time']; 

                $repeating_options = array('day' => __('Every day','cosmotheme'), 'week' => __('Every week','cosmotheme') ,'month' => __('Every month','cosmotheme') ,'year' => __('Every year','cosmotheme') );

                 if ($timeline == false ){
                    if($start_date != '' || $end_date != ''){
                        if( $event_program['is_repeating'] == 'yes') { 
                            return  $repeating_options[$event_program['repeating']]; 
                        } else {
                            return dateDiff(time(), $start_date, $end_date);
                        }
                    }
                } else if ($timeline == true && ($start_date != '' || $end_date != '') && $event_program['is_repeating'] != 'yes') {
                    return $start_date;
                } else if ($timeline == true && ($start_date != '' || $end_date != '') && $event_program['is_repeating'] == 'yes') {
                   
                    $now = time();
                    $start = strtotime($start_date);

                    if ($start > $now ) {
                        return $start_date;
                    } else if ($event_program['repeating'] == 'day') {
                        return date(get_option('date_format'), $now + 86400); 
                    }
                    else if ($event_program['repeating'] == 'week') {
                        $next_start = $start;
                        do { 
                            $next_start = $next_start + 604800;   
                           }
                        while ($next_start < $now);
                            return date (get_option('date_format') , $next_start);
                        }
                        else if ($event_program['repeating'] == 'month') {
                            $now_month = date ('m' , time()); 
                            $now_day = date ('j' , time()); 
                            $event_day = date ('j' , $start); 
                            if ($now_day > $event_day) {
                                $next_month =  $now_month + 1;
                            } else { 
                                $next_month =  $now_month ;
                            }
                            $next_month_full = mktime(date ('H' , $start), date ('i' , $start), date ('s' , $start), $next_month, date ('j' , $start), date ('Y' , $start));
                            return date(get_option('date_format') , $next_month_full);
                         }
                         else if ($event_program['repeating'] == 'year') {
                          return $start_date;
                         }
                
                }
               
            }
        }

    }
  
?>
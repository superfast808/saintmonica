<?php            
global $full_slideshow;
if($full_slideshow) {
    $full_slideshow_class = 'full-width';
    $slideshow_image_size = 'full';
} else { 
    $full_slideshow_class = ''; 
    $slideshow_image_size = 'tslideshow'; 
}
?>
<div class="header-slideshow <?php echo $full_slideshow_class; ?>">
    <ul class="header-slideshow-list">
            <?php 
                foreach( $slideshow as $i => $slide ){ 

                    if( isset( $slide[ 'type_res' ] ) && ($slide[ 'type_res' ] == 'post' || $slide[ 'type_res' ]=='slideshow' )){
                        $sliderPostID = $slide[ 'resources' ];
                        
                        if( has_post_thumbnail( $sliderPostID ) ){
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $sliderPostID ), $slideshow_image_size );
                
                        }else{
                            $image = array();
                            $image[ 0 ] = '';
                            echo 'hi';
                        }

                        if( isset( $slide[ 'slide_id' ] ) && is_numeric( $slide[ 'slide_id' ] ) ){
                            $image = wp_get_attachment_image_src( $slide[ 'slide_id' ] , $slideshow_image_size );
                            $image_id = $slide[ 'slide_id' ];
                            
                        }
                    }else{
$slideid = isset( $slide[ 'slide' ] ) ? $slide[ 'slide' ] : '';
                        $image = wp_get_attachment_image_src($slide['slide_id'], $slideshow_image_size );                       
                        $image_id = $slide[ 'slide_id' ];
			//echo $image[0];
$imgx=$slideid;

                    }

                    
                ?>
                <li data-slide="<?php echo $i; ?>" class="header-slideshow-elem">
                    <div class="slide-container">
                        <?php 
                        if ($imgx) {?>
                     
				<img src="<?php echo $imgx;?>" alt="" />


                        <?php } if (options::logic('styling', 'stripes')) { ?><div class="stripes"></div><?php } ?>
                    </div>
                </li>
            <?php } ?>
        </ul>

    <?php //if(isset($this -> controlNav) && $this -> controlNav == 'yes' ){ ?>
        <ul class="header-slideshow-navigation">
            <?php 
                foreach( $slideshow as $i => $slide ){
            ?>
            <li data-slide="<?php echo $i; ?>" class="header-slideshow-navigation-elem"></li>
            <?php } ?>
        </ul>
    <?php //} ?>
            

    <ul class="header-slideshow-captions">
        <?php foreach( $slideshow as $i => $slide ){ 
            if( isset( $slide[ 'type_res' ] ) && $slide[ 'type_res' ] == 'post' ){
                $sliderPostID = $slide[ 'resources' ];
                $sliderPost = get_post( $sliderPostID );                        
                if(isset( $slide[ 'title' ] ) && strlen($slide[ 'title' ])){
                    $title = $slide[ 'title' ];
                }else{
                    $title = $sliderPost -> post_title;    
                }
                if(strlen($slide[ 'description' ])){
                    $description = $slide[ 'description' ];
                }else if( strlen( $sliderPost -> post_excerpt ) ){
                    if( strlen( $sliderPost -> post_excerpt ) > 180 ){
                        $description = mb_substr( strip_tags( strip_shortcodes( $sliderPost -> post_excerpt ) ), 0, 180 ) . '..';
                    }else if(strlen($sliderPost -> post_excerpt)){
                        $description = strip_tags( strip_shortcodes( $sliderPost -> post_excerpt ) );
                    }
                }else{
                    if( strlen( $sliderPost -> post_content ) > 180 ){
                        $description = mb_substr( strip_tags( strip_shortcodes( $sliderPost -> post_content ) ), 0, 180 ) . '..';
                    }else{
                        $description = strip_tags( strip_shortcodes( $sliderPost -> post_content ) );
                    }
                }

                $link = get_permalink( $sliderPostID );
                if( isset( $slide[ 'url' ] ) && strlen( $slide[ 'url' ] ) ){
                    $link = $slide[ 'url' ];
                }
                $label = __('Take a tour','cosmotheme');
                if( isset( $slide[ 'label' ] ) && strlen( $slide[ 'label' ] ) ){
                    $label = $slide[ 'label' ];
                }                
            }
            else{
                $title = isset( $slide[ 'title' ] ) ? $slide[ 'title' ] : '';
                $description = isset( $slide[ 'description' ] ) ? $slide[ 'description' ] : '';
                $link = isset( $slide[ 'url' ] ) ? $slide[ 'url' ] : '';
                $label = isset( $slide[ 'label' ] ) ? $slide[ 'label' ] : '';
            }

           // if( (isset($title) && strlen(trim($title) ))){
                if (isset($slide['title_position']) && strlen($slide['title_position'])) {
                    $title_position = $slide[ 'title_position' ];
                }else{
                    $title_position = 'right';
                }
                //}

            if (isset($slide['boxed_layout']) && $slide['boxed_layout'] == 'no') {
                $boxed_class = 'non-boxed-layout';
            }else{
                $boxed_class = '';
            }
        ?>

        <li data-slide="<?php echo $i; ?>" class="header-slideshow-elem-content <?php echo $boxed_class . ' '; echo $title_position; if(strlen($slide['title']) == '' && strlen($slide['description']) == '' && strlen($link) == '') { echo ' no-text-description'; }?>">
            <ul>
                <li class="elem-content-container"><h2 <?php if(strlen($slide[ 'title_color' ])) { echo 'style="color:'. $slide[ 'title_color' ] .';"'; } ?> ><?php echo $title;?></h2></li>
                <li class="elem-content-container"><p <?php if(strlen($slide[ 'description_color' ])) { echo 'style="color:'. $slide[ 'description_color' ] . ';"'; } ?> ><?php echo $description; ?></p></li>
                <li class="elem-content-container"> 
                    <?php if(strlen($link)){ echo '<a class="slide-button" href="'. $link .'">';  
                        if (strlen($label)) {
                            echo $label;
                        }else{
                            echo __('Take a tour','cosmotheme');
                        }
                        echo '</a>'; } 
                    ?>
                </li>
            </ul>
        </li>
        <?php } ?>
    </ul>

</div>
<div id="spinner"></div>

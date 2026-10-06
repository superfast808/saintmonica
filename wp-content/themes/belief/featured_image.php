<?php
    $zoom = false; 
    
    if( options::logic( 'blog_post' , 'enb_featured' ) ){
        if ( has_post_thumbnail( $post -> ID ) && get_post_format( $post -> ID ) != 'video' ) {
            $src        = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'full' );
            $src_       = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'full' );
            $caption    = image::caption( $post -> ID );
            $zoom       = true;
        }
    }

if( options::logic( 'blog_post' , 'enb_featured' ) && ( has_post_thumbnail( $post -> ID ) )  ){
    if (get_post_type() == 'page' || get_post_type() == 'people' || ( (get_post_type() == 'post' || get_post_type() == 'event') && meta::logic( $post , 'settings' , 'featured' ) )) {
?>

    <div class="featimg">
        <?php if(get_post_format( $post -> ID ) != 'video' && get_post_format( $post -> ID ) != 'gallery') echo '<div class="featbg">'; ?>
                <?php $caption = get_post(get_post_thumbnail_id($post -> ID))->post_excerpt; ?>

                <?php if ( ( has_post_thumbnail( $post -> ID ) || get_post_format($post->ID)=="gallery" ) && get_post_format( $post -> ID ) != 'video' ) {
                        $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'full' );
                        if( options::logic( 'blog_post' , 'use_cropp_on_single' )  ){
                            $featimg_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'single_crop' );    
                        }else{
                            $featimg_src = $src;
                        }
                        

                        $size = 'tlist_tlarge'; 

                        if( get_post_format($post->ID)=="gallery" ){
                            /* for gallery posts we will show a slidedhow if there are more than 1 images  */
                            ob_start();
                            ob_clean();
                            post::get_post_img_slideshow( $post -> ID, $size );
                            $single_slideshow = ob_get_clean();
                        }

                        if(isset($single_slideshow) && strlen($single_slideshow)){
                            echo $single_slideshow;
                        }else{ /*we show featured image only when */
                ?>          
                        

                                <?php
                                    echo '<img src="' . $featimg_src[0] . '" alt="' . $caption . '" >';
                                ?>

                                <?php if($zoom && options::logic( 'blog_post' , 'enb_lightbox' )){ ?>
                                    <div class="zoom-image">
                                        <a href="<?php echo $src_[0]; ?>" rel="prettyPhoto-<?php echo $post -> ID; ?>" title="<?php echo  $post -> post_title;  ?>">&nbsp;</a>
                                    </div>
                                <?php } ?>    

                                <div class="format">&nbsp;</div>
                                <?php if (options::logic('styling', 'stripes')) { ?>
                                    <div class="stripes">&nbsp;</div>
                                <?php } ?>
                            
                               
                        
                <?php
                        } /*EOF if exists single slideshow*/
                    }else if(get_post_format( $post -> ID ) == 'video'){

                        $video_format = meta::get_meta( $post -> ID , 'format' );

                          
                        $format=$video_format;
                        
                    
                        echo '<div class="embedded_videos">';
                          
                        if( isset( $format['video'] ) && !empty( $format['video'] ) && post::isValidURL( $format['video'] ) ){
                            $vimeo_id = post::get_vimeo_video_id( $format['video'] );
                            $youtube_id = post::get_youtube_video_id( $format['video'] );
                            $video_type = '';
                            if( $vimeo_id != '0' ){
                                $video_type = 'vimeo';
                                $video_id = $vimeo_id;
                            }

                            if( $youtube_id != '0' ){
                                $video_type = 'youtube';
                                $video_id = $youtube_id;
                            }

                            if( !empty( $video_type ) ){
                                echo post::get_embeded_video( $video_id , $video_type );
                            }

                        }else if( isset( $video_format["feat_url"] ) && strlen($video_format["feat_url"])>1){

                              $video_url=$video_format["feat_url"];
                              if(post::get_youtube_video_id($video_url)!="0")
                                {
                                  echo post::get_embeded_video(post::get_youtube_video_id($video_url),"youtube");
                                }
                              else if(post::get_vimeo_video_id($video_url)!="0")
                                {
                                  echo post::get_embeded_video(post::get_vimeo_video_id($video_url),"vimeo");
                                }
                        }else if(isset( $video_format["feat_id"] ) && strlen($video_format["feat_id"])>1){
                            echo do_shortcode('[video mp4="'.wp_get_attachment_url($video_format["feat_id"]).'" width="610" height="443"]');
                            //echo post::get_local_video( urlencode(wp_get_attachment_url($video_format["feat_id"])));
                        }
                        
                        echo '</div>';
                        
                    }
            ?> 
        <?php
            if(isset($caption) && strlen($caption) && (get_post_format( $post -> ID ) != 'gallery' && get_post_format( $post -> ID ) != 'video' ) ){
                echo '<div class="post-caption"><h5>'.$caption.'</h5></div>';
            }
        ?>       
        <?php if(get_post_format( $post -> ID ) != 'video' && get_post_format( $post -> ID ) != 'gallery') echo '</div>'; ?>
    </div>

<?php
    }
}

?>
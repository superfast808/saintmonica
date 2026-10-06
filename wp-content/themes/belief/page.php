<?php
get_header(); 

    $no_feat_class = '';
    if( !options::logic( 'blog_post' , 'enb_featured' ) || !has_post_thumbnail( $post -> ID ) ){
        $no_feat_class = ' no_feat ';
    }

    $post_id = $post -> ID;
                    
      
    /*---------------------*/
    $post_format = get_post_format( $post -> ID );
    if(!strlen($post_format)){ $post_format = 'standard';}
?>

<section id="main">

    <div class="main-container">  
        <div class="row">
            <div class="twelve columns main-container-wrapper">      
                <?php
                    while( have_posts () ){ 
                        the_post();
                        $meta = meta::get_meta( $post -> ID, 'settings' );
                        $meta_enb = options::logic( 'blog_post' , 'meta' );             
                    } /*EOF while( have_posts () ) */
                ?>
                <?php
                    $resizer = new LBPageResizer('page');
                    $resizer -> render_frontend();
                ?>
            </div>
        </div> 
    </div>
</section>    
 
<?php get_footer(); ?>

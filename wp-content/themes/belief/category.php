<?php get_header(); ?>


<?php
    $template = 'category';
?>

<section id="main">

    <div class="main-container">
        <div class="row">
            <div class="twelve columns main-container-wrapper">  
                <div class="row">      
                    <div class="twelve columns  ">
                        <?php
                            if( have_posts () ){
                                ?><h2 class="content-title"><span><?php _e( 'Category archives: ' , 'cosmotheme' ); echo get_cat_name( get_query_var('cat') ); ?></span></h2><?php
                            }else{
                                ?><h2 class="content-title"><span><?php _e( 'Sorry, no posts found' , 'cosmotheme' ); ?></span></h2><?php
                            }
                        ?> 
                    </div>
                </div>
                <?php
                    $layout = new LBSidebarResizer( 'category' );
                    $layout -> render_frontend();
                ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>

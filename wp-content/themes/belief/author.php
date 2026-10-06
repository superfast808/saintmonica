<?php get_header(); ?>
<?php
    $template = 'author';
?>
<section id="main">

    <div class="main-container">
        <div class="row">
            <div class="twelve columns main-container-wrapper">        
                <div class="row">
                    <div class="twelve columns ">
                        <?php
                            if( have_posts () ){
                        ?>
                                <h2 class="content-title">
                                    <span>
                                    <?php 
                                        _e( 'Author archives: ' , 'cosmotheme' );  
                                        echo get_the_author_meta( 'display_name' , $post-> post_author );
                                    ?>
                                    </span>
                                </h2>
                        <?php
                            }else{
                                ?><h2 class="content-title"><?php _e( 'Sorry, no posts found' , 'cosmotheme' ); ?></h2><?php
                            }
                        ?> 
                    </div>
                </div>
                <?php
                    $layout = new LBSidebarResizer( 'author' );
                    $layout -> render_frontend();
                ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
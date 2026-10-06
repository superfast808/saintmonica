<?php get_header(); ?>


<?php
    $template = 'event_category';
?>

<section id="main">

    <div class="main-container">
        <div class="row">
            <div class="twelve columns main-container-wrapper">
                <div class="row">
                    <div class="twelve columns  ">
                        <?php
                            if( have_posts () ){
                                ?><h2 class="content-title"><span><?php _e( 'Event category archives: ' , 'cosmotheme' ); echo  get_query_var('event-category') ; ?></span></h2><?php
                            }else{
                                ?><h2 class="content-title"><span><?php _e( 'Sorry, no posts found' , 'cosmotheme' ); ?></span></h2><?php
                            }
                        ?>
                    </div>
                </div>
                <?php
                    $layout = new LBSidebarResizer( 'event_category' );
                    $layout -> render_frontend();
                ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>

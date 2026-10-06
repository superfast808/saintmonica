<?php get_header(); ?>
<section id="main">

    <div class="main-container">
        <div class="row">
            <div class="twelve columns main-container-wrapper">        
                <div class="row">
                    <div class="twelve columns ">
                        <h2 class="content-title"><span><?php _e( 'Error 404, page, post or resource can not be found' , 'cosmotheme' ); ?></span></h2>
                    </div>
                </div>

                <?php
                    function show_404( $sender ){
                        get_template_part( 'loop' , '404' );
                    }
                    $layout = new LBSidebarResizer( '404' );
                    $layout -> render_frontend( 'show_404' );
                ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
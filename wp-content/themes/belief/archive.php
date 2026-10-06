<?php get_header(); ?>
<?php
    $template = 'archive';
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
                                <h2 class="content-title"><span>
                                    <?php
                                        if ( is_day() ) {
                                            echo __( 'Daily archives' , 'cosmotheme' ) . ':' . get_the_date();
                                        }else if ( is_month() ) {
                                            echo __( 'Monthly archives' , 'cosmotheme' ) . ':' . get_the_date( 'F Y' );
                                        }else if ( is_year() ) {
                                            echo __( 'Yearly archives' , 'cosmotheme' ) . ':' . get_the_date( 'Y' );
                                        }else if (is_tax( 'post_format' )){
                                            echo __( 'Post format archives' , 'cosmotheme' ) . ':' . get_post_format(); 
                                        }else if (get_post_type() == 'event'){
                                            echo __( 'Event archives' , 'cosmotheme' ); 
                                        }else if(is_post_type_archive()){    
                                            echo sprintf(__( '%s archives' , 'cosmotheme' ), post_type_archive_title());
                                        }else {
                                            echo __( 'Blog archives' , 'cosmotheme' );
                                        }
                                    ?>

                                </span></h2><?php
                            }else{
                                ?><h2 class="content-title"><?php _e( 'Sorry, no posts found' , 'cosmotheme' ); ?></h2><?php

                            }
                        ?>
                    </div>
                </div>
                <?php
                    add_filter( 'pre_get_posts', 'namespace_add_custom_types' ); /*add folter that will show all post types on archive pages*/
                    if (is_tax( 'post_format' )){
                        $layout = new LBSidebarResizer( 'archive_format' ); /*for post format archive*/   
                    }else if(is_post_type_archive()){                
                        $layout = new LBSidebarResizer( 'archive_post_type' ); /*for post type 'Portfolio' archive*/   
                    }else{
                        $layout = new LBSidebarResizer( 'archive' );    
                    }
                    
                    $layout -> render_frontend();

                    remove_filter( 'pre_get_posts', 'namespace_add_custom_types' ); /*remove folter that will show all post types on archive pages*/

                ?>
            </div>
        </div>                
    </div>
</section>
<?php get_footer(); ?>
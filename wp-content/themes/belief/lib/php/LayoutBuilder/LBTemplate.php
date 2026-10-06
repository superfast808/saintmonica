<?php
    class LBTemplate{
        public $callback = false;
        function __construct( $data = array() ){
            $this -> id = '__template__';
            $this -> _rows = array();
            $this -> rows = array();
            $this -> _header_rows = array();
            $this -> header_rows = array();
            $this -> _footer_rows = array();
            $this -> footer_rows = array();
            $this -> example = "Example value";
            $this -> enable_slideshow = 'yes';
            $this -> slideshowID = 0;
            $this -> slideshow_type = 'limited';
            $this -> slideshow_autoplay = 'yes';
            $this -> slide_speed = 5; 
            $this -> transition_speed = 7;            
            $this -> header_bg_color = '#A93064';
            $this -> header_bg_opacity = '55';
            $this -> header_text_color = '#ffffff';
            $this -> name = __( 'New template', 'cosmotheme' );
            foreach( $data as $identifier => $value ){
                $this ->{ $identifier } = $value;
            }

            foreach( $this -> _header_rows as $data ){
                $row = new LBHeaderRow( $data );
                $row -> template =& $this;
                $this -> header_rows[] = $row;
            }

            foreach( $this -> _rows as $data ){
                $row = new LBRow( $data );
                $row -> template =& $this;
                $this -> rows[ $row -> id ] = $row;
            }

            foreach( $this -> _footer_rows as $data ){
                $row = new LBFooterRow( $data );
                $row -> template =& $this;
                $this -> footer_rows[] = $row;
            }
        }

        function slideshows_list($name, $checked){
            $slideshow = new LBTemplateBuilder();
            $slideshow->list_slideshows($name, $checked);
        }

        function render_frontend_slideshow(){
            $slideshow = meta::get_meta( $this -> slideshowID, 'box' ); 
            //var_dump($slideshow);

            $slideshow_settings = meta::get_meta( $this -> slideshowID, 'slidesettings' );
            
            $slideshow_source = 'none'; /*by default there is no source: the use must add slides manually*/
            if(isset($slideshow_settings['slideshowSource'])){
                $slideshow_source = $slideshow_settings['slideshowSource'];
            }

            if(isset($slideshow_settings['numberOfPosts'])){
                $numberOfPosts = $slideshow_settings['numberOfPosts'];
            }else{
                $numberOfPosts = 5; /*in case this value is not defined*/
            }

            $latest_slideshow_posts = array(); /*initialize an empty array where latest/featured posts/posrtfolios will be added*/

            switch ($slideshow_source) {
                case 'latest_posts':
                    $query_args = array('post_type' => 'post', 'posts_per_page' => $numberOfPosts);
                    
                    break;
                
                case 'featured_posts':
                    $query_args = array(
                                        'post_type' => array( 'post'),
                                        'post_status' => 'publish',
                                        'posts_per_page' => $numberOfPosts,
                                        'meta_query' => array(
                                            array(
                                                'key' => 'nr_like',
                                                'value' => trim(options::get_value('likes', 'min_likes') ),
                                                'compare' => '>=',
                                                'type' => 'numeric',
                                            )
                                        )
                                    );

                    break;

                default:
                    # code...
                    break;
            }

            if(isset($query_args)){
                $latest_posts = new WP_Query( $query_args ); 
                    
                if(isset($latest_posts -> posts) and sizeof($latest_posts -> posts)){
                    foreach ($latest_posts -> posts as $post) {
                        /*add the post to the array*/
                        $latest_slideshow_posts[] = array('type_res' => 'post',
                                                          'resources' => $post -> ID,
                                                          'slide' => '',
                                                          'slide_id' => '',
                                                          'title' => $post -> post_title,
                                                          'title_color' => '',
                                                          'title_position' => 'right',
                                                          'description' => $post -> post_excerpt,
                                                          'description_color' => '',
                                                          'idrow' => '', 
                                                          );
                    }
                }

            }

            if(!empty($latest_slideshow_posts)){

                if(!empty( $slideshow ) && is_array( $slideshow )){
                    $slideshow = array_merge($latest_slideshow_posts, $slideshow);
                }else{
                    $slideshow = $latest_slideshow_posts;
                }

                
            }

            if( !( isset( $slideshow ) && is_array( $slideshow ) && count( $slideshow ) ) ){
                return;   
            }
        ?>

            <?php
                if ( !empty( $slideshow ) && is_array( $slideshow ) && is_array( $slideshow_settings )  && count( $slideshow_settings ) ) {
                    extract( $slideshow_settings );
                    include_once('slideshow/slideshow.php');            
            }    
            
        }
        function get_prefix(){
            return $this -> builder -> get_prefix() . "[$this->id]";
        }

        function render_backend(){
            include get_template_directory() . '/lib/templates/layouttemplate.php';
        }

        static function figure_out_template(){
            if( is_front_page() ){
                return self::get_template( 'front_page' );
            }else if( is_404() ){
                return self::get_template( '404' );
            }else if( is_category() ){
                return self::get_template( 'category' );
            }else if( is_tag() ){
                return self::get_template( 'tag' );
            }else if( is_attachment() ){
                return self::get_template( 'attachment' );
            }else if( is_author() ){
                return self::get_template( 'author' );
            }else if( is_search() ){
                return self::get_template( 'search' );    
            }else if( is_archive() ){
                return self::get_template( 'archive' );
            }else if( is_home() ){
                return self::get_template( 'index' );
            }else if( is_singular() ){
                $resizer = new LBPageResizer();
                $resizer -> load_all();
                return $resizer -> get_builder();
            }
        }

        static function get_template( $template ){

            /* we use this for update action for default templates */

            if($template == 'people'){ $template = 'single'; } /* for team we want to use the template for posts */

            $templateID = options::get_value( $template . '_layout', 'template' );
            $all_templates = get_option( 'templates' );
            $data = $all_templates[$templateID];
            
            if( is_array( $data ) && isset( $data[ 'id' ] ) ){
                return new LBTemplate( $data );
            }else{
                $defaults = array(
                    'id' => 'default',
                    '_rows' => array(
                        array(
                            'id' => 'default',
                            'is_additional' => true,
                            '_elements' => array(
                                array(
                                    'id' => 'default'
                                )
                            )
                        )
                    )
                );
                if( 'front_page' == $template ){
                    $defaults[ '_rows' ][ 1 ] = array();
                    $defaults[ '_rows' ][ 1 ][ '_elements' ] = array(
                        array(
                            'id' => 'default',
                            'type' => 'latest'
                        )
                    );
                }
                return new LBTemplate( $defaults );
            }
        }

        static function get_template_by_id( $id ){
            /* we use this for update action for new created templates */
            $all_templates = get_option( 'templates' );
            if(isset($all_templates[$id])){
                $data = $all_templates[$id];    
            }else{
                $data = '';
            }
            
            if( is_array( $data ) && isset( $data[ 'id' ] ) ){
                return new LBTemplate( $data );
            }else{
                $defaults = array(
                    'id' => 'default',
                    '_rows' => array(
                        array(
                            'id' => 'default',
                            'is_additional' => true,
                            '_elements' => array(
                                array(
                                    'id' => 'default'
                                )
                            )
                        )
                    )
                );
                
                return new LBTemplate( $defaults );
            }
        }

        function render_header(){
            echo '<div class="row">';
            echo '<div class="twelve columns header-container-wrapper">';
            foreach( $this -> header_rows as $index => $row ){ //deb::e($row);
                $row -> render_content();
            }
            echo '</div>';
            echo '</div>';
            if ($this -> enable_slideshow == 'yes') { 
                $this->render_frontend_slideshow(); 
            }            
        }

        function render_footer(){
            foreach( $this -> footer_rows as $index => $row ){
                $row -> render_content();
            }
        }

        function render_content(){
            foreach( $this -> rows as $row ){
                $row -> render_content();
            }
        }
    }
?>
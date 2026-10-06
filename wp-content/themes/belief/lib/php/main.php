<?php
    
	function ilove__autoload( $class_name ){
        if( substr( $class_name , 0 , 6 ) == 'widget'){
            $class_name = str_replace( 'widget_' , '' ,  $class_name );
            if( is_file( get_template_directory() . '/lib/php/widget/' . $class_name . '.php' ) ){
                include get_template_directory() . '/lib/php/widget/' . $class_name . '.php';

            }
        }
		if( is_file( get_template_directory() . '/lib/php/' . $class_name . '.class.php' ) ){
			include_once get_template_directory() . '/lib/php/' . $class_name . '.class.php';
            if( is_file( get_template_directory() . '/lib/php/' . $class_name . '.register.php' ) ){
				include_once get_template_directory() . '/lib/php/' . $class_name . '.register.php';
			}
		}else if( substr( $class_name, 0, 2 ) == 'LB' ){
            include_once get_template_directory() . '/lib/php/LayoutBuilder/' . $class_name . '.php';
        }
    }

     
	spl_autoload_register ("ilove__autoload");
	
	include_once get_template_directory() . '/lib/php/audio-player.php';

    /*register categories taxonomies for event posts*/
    $event_category = array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x( 'Category', 'taxonomy general name' ,'cosmotheme' ),
            'singular_name' => _x( 'Category', 'taxonomy singular name','cosmotheme' ),
            'search_items' =>  __( 'Search Categories', 'cosmotheme' ),
            'all_items' => __( 'All Categories', 'cosmotheme' ),
            'parent_item' => __( 'Parent Category', 'cosmotheme' ),
            'parent_item_colon' => __( 'Parent Category:', 'cosmotheme' ),
            'edit_item' => __( 'Edit Category', 'cosmotheme' ), 
            'update_item' => __( 'Update Category', 'cosmotheme' ),
            'add_new_item' => __( 'Add New Category', 'cosmotheme' ),
            'new_item_name' => __( 'New Category Name', 'cosmotheme' ),
            'menu_name' => __( 'Category', 'cosmotheme' ),
        ),  
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'event-category' ),
    );

    register_taxonomy('event-category', 'event', $event_category);

    /* EOF register  categories taxonomies for event posts */

    $labels = array(
        'name' => _x( 'Box Sets', 'taxonomy general name', 'cosmotheme' ),
        'singular_name' => _x( 'Box Set', 'taxonomy singular name', 'cosmotheme' ),
        'search_items' =>  __( 'Search Box Set', 'cosmotheme' ),
        'all_items' => __( 'All Box Sets', 'cosmotheme' ),
        'parent_item' => __( 'Parent Box Set', 'cosmotheme' ),
        'parent_item_colon' => __( 'Parent Box Set:', 'cosmotheme' ),
        'edit_item' => __( 'Edit Box Set', 'cosmotheme' ), 
        'update_item' => __( 'Update Box Set', 'cosmotheme' ),
        'add_new_item' => __( 'Add New Box Set', 'cosmotheme' ),
        'new_item_name' => __( 'New Box Set Name', 'cosmotheme' ),
        'menu_name' => __( 'Box Sets', 'cosmotheme' ),
      );    


    register_taxonomy(
        
    'box-sets',
        'box',
        array(
            'labels' => $labels,
            'rewrite' => array( 'slug' => 'box-sets' ),
            'hierarchical' => true
        )
    );


     $labels = array(
        'name' => _x( 'Groups', 'taxonomy general name', 'cosmotheme' ),
        'singular_name' => _x( 'Group', 'taxonomy singular name', 'cosmotheme' ),
        'search_items' =>  __( 'Search group', 'cosmotheme' ),
        'all_items' => __( 'All group', 'cosmotheme' ),
        'parent_item' => __( 'Parent group', 'cosmotheme' ),
        'parent_item_colon' => __( 'Parent group:', 'cosmotheme' ),
        'edit_item' => __( 'Edit group', 'cosmotheme' ),
        'update_item' => __( 'Update group', 'cosmotheme' ),
        'add_new_item' => __( 'Add new group', 'cosmotheme' ),
        'new_item_name' => __( 'New new Name', 'cosmotheme' ),
        'menu_name' => __( 'Groups', 'cosmotheme' ),
    );

    register_taxonomy(
        'people-group',
        'people',
        array(
            'labels' => $labels,
            'rewrite' => array( 'slug' => 'people-grup' ),
            'hierarchical' => true
        )
    );
                
	    
    
    function get_item_label( $item ){
        $item = basename( $item );
        $item = str_replace( '-' , ' ' , $item );
        return $item;
    }

    function get_item_slug( $item ){
        $item = basename( $item );
        $item = str_replace( '-', '_' , str_replace( ' ', '__' , $item ) );
        return $item;
    }

    function get_subitem_slug( $item , $subitem ){
        $item = get_item_slug( $item );
        $subitem = get_item_slug( $subitem );
        $subitem = $item . FN_DELIM . $subitem;
        return $subitem;
    }

    function get_items( $slug ){
        $items = explode( FN_DELIM , $slug );
        $result = array();
        if( is_array( $items ) ){
            foreach( $items as $item ){
                $result[] = str_replace( '_', '-' , str_replace( '__', ' ' , $item ) );
            }
        }else{
            $result = str_replace( '_', '-' , str_replace( '__', ' ' , $item ) );
        }

        return $result;
    }

    function get_item( $slug ){
        $item = str_replace( '_', '-' , str_replace( '__', ' ' , $slug ) );
        return $item;
    }

    function get_path( $slug ){
        $item = str_replace( '_', '-' , str_replace( '__', ' ' , str_replace( FN_DELIM, '/' , $slug ) ) );
        return $item;
    }

    
    function get__pages( $first_label = 'Select item' ){
        $pages = get_pages();
        $result = array();
        if( is_array( $first_label ) ){
            $result = $first_label;
        }else{
            if( strlen( $first_label ) ){
                $result[] = $first_label;
            }
        }
        foreach($pages as $page){
            $result[ $page -> ID ] = $page -> post_title;
        }

        return $result;
    }

    function get_testimonials($get_testimonials = array()){

        $args = array('post_type' => 'testimonial', 'post__in' => $get_testimonials);
        $testimonials = new WP_Query($args);
        $rand = mt_rand(0,9999); /*will use this val to avoid having duplicated IDs if 2 testimonials elements are used on the page*/
        if(count($testimonials -> posts)){

            $result =  '<ul class="testimonials-carousel">';
            $first_avatar = '';
            
            foreach( $testimonials -> posts as $key => $post ){
                if( has_post_thumbnail( $post -> ID  ) ){ 
                    $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ), 'tsmall' );
                    $img_url = $img_url[0];
                }else{
                    $img_url = DEFAULT_AVATAR;
                }

                $testimonial_info = meta::get_meta( $post->ID, 'info' );

                if(!strlen($first_avatar)){
                    $first_avatar = $img_url;
                }
                if($key == 0) {
                    $first_elem_active = 'active';
                }else {
                    $first_elem_active = '';
                }

                $result .= '<li class="testimonials-carousel-elem '. $first_elem_active. '">';
                $result .= '<article class="testimonials-elem ">';
                    $result .= '<div class="testimonials-elem-wrapper">';

                        $result .= '<div class="entry-content">';
                            $result .= '<div class="featimg"><img src="'. $img_url .'" alt="'. $post->post_title.'" /></div>';
                            $result .= '<ul class="entry-content-list">';                        
                                $result .= '<li class="entry-content-name"><h4>' . $testimonial_info['name'] . '</h4></li>';
                                $result .= '<li class="entry-content-function">' . $testimonial_info['title'] . '</li>';
                            $result .= '</ul>';
                        $result .= '</div>';

                        $result .= '<div class="entry-content-excerpt">';
                        $result .= $post -> post_content;
                        $result .= '</div>';

                    $result .= '</div>';
                $result .= '<div class="clear"></div></article>'; 
                $result .= '</li>';                 
            }            

            $result .= '</ul>';
            if (count($testimonials -> posts) > 1 ) {
                $result .= '<ul class="testimonials-carousel-nav">';
                $result .= '<li class="testimonials-carousel-nav-left">&larr;</li> ';
                $result .= '<li class="testimonials-carousel-nav-right">&rarr;</li>';
                $result .= '</ul>';
            } else {}

            
            echo $result;    
        }else{
            echo '<p class="select">' . __( 'There are no testimonials' , 'cosmotheme' ) . '</p>';
        }
    }

    function get__posts( $args = array() , $first_label = 'Select item' ){
        $posts = get_posts( $args );
        $result = array();
        
        if( is_array( $first_label ) ){
            $result = $first_label;
        }else{
            if( strlen( $first_label ) ){
                $result[] = $first_label;
            }
        }
        if( is_array( $posts ) && !empty( $posts ) ){
            foreach( $posts as $post ){
                $result[ $post -> ID  ] = $post -> post_title;
            }
        }

        return $result;
    }

    function menu( $id ,  $args = array() ){

        $menu = new menu( $args );
        if ($args['container_class'] == 'top-menu cosmo-menu') {
            $container_class = 'top-menu cosmo-menu';
        }elseif ($args['container_class'] == 'top-menu cosmo-menu align-top') {
            $container_class = 'top-menu cosmo-menu align-top';
        }elseif ($args['container_class'] == 'top-menu cosmo-menu align-middle') {
            $container_class = 'top-menu cosmo-menu align-middle';
        }elseif ($args['container_class'] == 'top-menu cosmo-menu align-bottom') {
            $container_class = 'top-menu cosmo-menu align-bottom';
        }elseif ($args['container_class'] == 'main-menu cosmo-menu align-top') {
            $container_class = 'main-menu cosmo-menu align-top';
        }elseif ($args['container_class'] == 'main-menu cosmo-menu align-middle') {
            $container_class = 'main-menu cosmo-menu align-middle';
        }elseif ($args['container_class'] == 'main-menu cosmo-menu align-bottom') {
            $container_class = 'main-menu cosmo-menu align-bottom';
        }elseif ($args['container_class'] == 'footer-menu cosmo-menu') {
            $container_class = 'footer-menu cosmo-menu';
        }

        $vargs = array(
            'menu'            => '',
            'container'       => 'nav',
            'container_class' => $container_class,
            'container_id'    => '',
            'menu_class'      => isset( $args['class'] ) ? $args['class'] : '',
            'menu_id'         => '',
            'echo'            => false,
            'fallback_cb'     => '',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'depth'           => 0,
            'walker'          => $menu,
            'theme_location'  => $id ,
            'menu_style' =>  isset( $args['menu_style'] ) ? $args['menu_style'] : 'default', /*menu style from template (default, with_description or vertical) */
            'nr_columns' =>  isset( $args['nr_columns'] ) ? $args['nr_columns'] : '', /*1,2,3 or 4 columns  Defined in the template*/
        );

        $result = wp_nav_menu( $vargs );
        $result = str_replace('</ul>', '</ul><div class="clear"></div>', $result);

        if(!strlen($result)){

            $result = $menu -> get_terms_menu();
            
            //var_dump($result);
        }

        // if( $menu -> need_more &&  $id != 'megusta' ){
        //         $result .="</li></ul>".$menu -> aftersubm ;
        // }
        
        return $result;
    }

    
    function page(){
        if( (int)get_query_var('paged') > (int)get_query_var('page') ){
            $result = (int)get_query_var('paged');
        }else{

            if( (int)get_query_var('page') == 0 ){
                $result = 1;
            }else{
                $result = (int)get_query_var('page');
            }
        }

        return $result;
    }

   
	function dimox_breadcrumbs() {

	  $delimiter = '';
	  $home = __('Home','cosmotheme'); // text for the 'Home' link

      $start_container = '<ul>';
      $end_container = '</ul>';
	  $before = '<li class="icon-next">'; // tag before the current crumb
	  $after = '</li>'; // tag after the current crumb

	  if (  !is_front_page() || is_paged() ) {

	    /*echo '<div id="crumbs">';*/

	    global $post;
	    $homeLink = home_url();
        echo $start_container;
	    echo '<li><a href="' . $homeLink . '">' . $home . '</a> </li>' . $delimiter . ' ';

	    if ( is_category() ) {
	      global $wp_query;
	      $cat_obj = $wp_query->get_queried_object();
	      $thisCat = $cat_obj->term_id;
	      $thisCat = get_category($thisCat);
	      $parentCat = get_category($thisCat->parent);
	      if ($thisCat->parent != 0) echo($before .get_category_parents($parentCat, TRUE, ' ' . '</li><li  class="icon-next">' . ' '). $after);
	      echo $before . __('Archive by category','cosmotheme').' "' . single_cat_title('', false) . '"' . $after;

	    } elseif ( is_day() ) {
	      echo $before.'<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> '. $after . $delimiter . ' ';
	      echo $before.'<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> '. $after . $delimiter . ' ';
	      echo $before . get_the_time('d') . $after;

	    } elseif ( is_month() ) {
	      echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> '. $after . $delimiter . ' ';
	      echo $before . get_the_time('F') . $after;

	    } elseif ( is_year() ) {
	      echo $before . get_the_time('Y') . $after;

	    } elseif ( is_single() && !is_attachment() ) {
	      if ( get_post_type() != 'post' ) {

	        $post_type = get_post_type_object(get_post_type());
	        $slug = $post_type->rewrite;
	        echo $before . '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> '. $after . $delimiter . ' ';
	        echo $before . get_the_title() . $after;
	      } else {
	        $cat = get_the_category(); $cat = $cat[0];
	        //echo $before . get_category_parents($cat, TRUE, ' ' . '</li><li>' . ' ') . $after;
            echo $before . get_category_parents($cat, TRUE, ' ' ) . $after;
	        echo $before . get_the_title() . $after;
	      }

	    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
	      $post_type = get_post_type_object(get_post_type()); 
          if($post_type){
            echo $before . $post_type->labels->singular_name . $after;
          }  

	    } elseif ( is_attachment() ) {
	      $parent = get_post($post->post_parent);
	      /*$cat = get_the_category($parent->ID); $cat = $cat[0];*/
	      /*echo $before . get_category_parents($cat, TRUE, ' ' . $delimiter . ' ') . $after;*/
	      echo $before . '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> '. $after . $delimiter . ' ';
	      echo $before . get_the_title() . $after;

	    } elseif ( is_page() && !$post->post_parent ) {
	      echo $before . get_the_title() . $after;

	    } elseif ( is_page() && $post->post_parent ) {
	      $parent_id  = $post->post_parent;
	      $breadcrumbs = array();
	      while ($parent_id) {
	        $page = get_page($parent_id);
	        $breadcrumbs[] = $before .'<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>'.$after ;
	        $parent_id  = $page->post_parent;
	      }
	      $breadcrumbs = array_reverse($breadcrumbs);
	      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
	      echo $before . get_the_title() . $after;

	    } elseif ( is_search() ) {
	      echo $before . __('Search results for','cosmotheme').' "' . get_search_query() . '"' . $after;

	    } elseif ( is_tag() ) {
	      echo $before . __('Posts tagged','cosmotheme').' "' . single_tag_title('', false) . '"' . $after;

	    } elseif ( is_author() ) {
	       global $author;
	      $userdata = get_userdata($author);
	      echo $before . __('Articles posted by ','cosmotheme') . $userdata->display_name . $after;

	    } elseif ( is_404() ) {
	      echo $before . __('Error 404','cosmotheme') . $after;
	    }

	    if ( get_query_var('paged') ) {
	      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
	      echo __('Page','cosmotheme') . ' ' . get_query_var('paged');
	      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
	    }

	  	if(is_home()){
			echo $before . __('Blog','cosmotheme'). $after;
		}
        echo $end_container;
	    /*echo '</div>';*/

	  }
	} /* end dimox_breadcrumbs()*/

    function remove_post_custom_fields() {
        remove_meta_box( 'postcustom' , 'post' , 'normal' );
    }
	
	function get_bg_image(){
            $pattern = explode( '.' , options::get_value( 'styling' , 'background' ) ) ; 
            if( isset( $pattern[ count( $pattern ) - 1 ] ) && $pattern[ count( $pattern ) - 1 ] == 'none'  || get_background_image() != '' ){
                $background_img = '';
            }else{
                $background_img_url = str_replace( 's.pattern.' , 'pattern.' , options::get_value( 'styling' , 'background' ) );
                if(strpos($background_img_url,'day') || strpos($background_img_url,'night')) { 
                    $background_img_url = str_replace( '.jpg' , '.png' , $background_img_url );  
                }
                $pieces = explode("/", $background_img_url);
                $background_img = $pieces[count($pieces) -1 ];
                    if (strpos($background_img, 'none')) {
                        $background_img = '' ;
                    }   	
            }
            
			/*if cookies are set we overite the settings*/ 
			if( isset($_COOKIE[ZIP_NAME."_bg_image"]) ){  
				$background_img = 'pattern.'.trim($_COOKIE[ZIP_NAME."_bg_image"].'.png');  
			}
			
			return $background_img;
	}
	
	function get_content_bg_color(){

            $background_color = options::get_value( 'styling' , 'background_color' );
            
			/*if cookies are set we ovewrite the settings*/
			if(isset($_COOKIE[ZIP_NAME."_content_bg_color"])){ 
				$background_color = trim($_COOKIE[ZIP_NAME."_content_bg_color"]); 
			}
			
			return $background_color;
	}
	
	function get_footer_bg_color(){
		if(isset($_COOKIE[ZIP_NAME."_footer_bg_color"])){ 
			$footer_background_color = trim($_COOKIE[ZIP_NAME."_footer_bg_color"]);
		}else{
			$footer_background_color = options::get_value( 'styling' , 'footer_bg_color' );
		}
		
		return $footer_background_color;
	}

	function cosmo_avatar( $user_info, $size, $default = DEFAULT_AVATAR ) {
		
		$avatar = '';
        if( is_numeric( $user_info ) ){
            if( get_user_meta( $user_info , 'custom_avatar' , true ) == -1 ){
                $avatar = '<img src="' . $default . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
            }else{
                if(  get_user_meta( $user_info , 'custom_avatar' , true ) > 0 ){
                    $cusom_avatar = wp_get_attachment_image_src( get_user_meta( $user_info , 'custom_avatar' , true ) , array( $size , $size ) );
                    $avatar = '<img src="' . $cusom_avatar[0] . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
                }else{
                    $avatar = get_avatar( $user_info , $size , $default );
                }
            }
            
        }else{
            if( is_object( $user_info ) ){
                if( isset( $user_info -> user_id ) && is_numeric( $user_info -> user_id ) && $user_info -> user_id > 0 ){
                    if( get_user_meta( $user_info -> user_id , 'custom_avatar' , true ) == -1 ){
                        $avatar = '<img src="' . $default . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
                    }else{
                        if( get_user_meta( $user_info -> user_id , 'custom_avatar' , true ) > 0 ){
                            $cusom_avatar = wp_get_attachment_image_src( get_user_meta( $user_info -> user_id , 'custom_avatar' , true ) , array( $size , $size ) );
                            $avatar = '<img src="' . $cusom_avatar[0] . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
                        }else{
                            $avatar = get_avatar( $user_info , $size , $default );
                        }
                    }
                }else{
                    $avatar = get_avatar( $user_info , $size , $default );
                }
            }else{
                $avatar = get_avatar( $user_info , $size , $default );
            }
        }
		
        return $avatar;
	}

    
    function get_distinct_post_terms($post_id, $taxonomy, $return_names = false, $filter_type = '' ){
        /*
            Returns distinct taxonomies for a given post, or nothig if nothing found.
        */
        $ids = array();
        $names = '';

        $terms = wp_get_post_terms( $post_id , $taxonomy );

        if(is_array($terms)){
            foreach ($terms as $term) {
                if(!in_array($term->term_id, $ids) ){
                    $ids[] = $term->term_id;

                    $names .= ' '.$term->slug.'-'.$filter_type.' ';
                }
            }
        }

        if($return_names){
            return $names;
        }else{
            return $ids;    
        }
    }

     function get_distinct_terms($posts,$taxonomy ){
        /*
            Returns distinct taxonomies for given posts, or empty array if nothing found.
        */
        $ids = array();
        
        foreach ($posts as $post) { 
            $portfolios = '';            
            
            if(isset($post -> ID)){

                $portfolios = wp_get_post_terms( $post -> ID , $taxonomy );
            }
            
            if(is_array($portfolios)){
                foreach ($portfolios as $portfolio) {
                    if(!in_array($portfolio->term_id, $ids) ){
                        $ids[] = $portfolio->term_id;
                        
                    }
                }
            }
        }
    
        return $ids;    
        
    }

    function get_filters($term_ids,$taxonomy, $filter_type = 'thumbs', $title = ''){
        /*
            this function returns the filter by taxonomy 
            Params:
            $term_ids - and array or term IDs
            $taxonomy -  for example 'category' or 'portfolio'
            $filter_type - we need that to have distinct data-value, to not affect other filters
        */
        $result = '';    
        if(is_array($term_ids) && sizeof($term_ids)){
            $result .= $title;
            $result .= '<ul class="thumbs-splitter" data-option-key="filter">';
            $result .= '    <li class="segment-0 selected-0 selected">
                                <a href="#filter" data-option-value="*" class="selected">'.__('All','cosmotheme').'</a>
                            </li> ';
            $i = 0;
            foreach ($term_ids as $term_id) {
                $i++;
                $term = get_term( $term_id, $taxonomy );
                
                $result .= '<li class="segment-'.$i.'">
                                <a href="#filter" data-option-value=".'.$term->slug.'-'.$filter_type.'">'.$term->name.'</a>
                            </li> ';
            }
            $result .= '</ul>';
        }

        return $result;
    }

    function link_souce($text){
        /*if gicen text is a valid URL we will return the linked url
            else we will return the given text
        */

        if(post::isValidURL($text)){
            $text = '<a href="'.$text.'">'.$text.'</a>';
        }    
        return $text;
    }
  
    function custom_get_post_format($post_id){
        if(strlen(get_post_format($post_id) )){
            return 'format-'.get_post_format($post_id);
        }else{
            return 'format-standard';
        }
    }      

    function load_google_fonts(){
        $result = '';
        $fonts = array();
        $settings_fonts = array(
            options::get_value( 'typography' , 'headings_font_font_family' ),
            options::get_value( 'typography' , 'primary_font_font_family' ),
            //options::get_value( 'typography' , 'secondary_font_font_family' )

        );
        if( options::get_value( 'styling' , 'logo_type' ) == 'text' ) { 
            $settings_fonts[] = options::get_value( 'styling' , 'logo_font_family' );
        }

        foreach ($settings_fonts as $font) {
            if(!in_array($font, $fonts)){
                $fonts[] = $font; /*append each font only 1 time*/
            }
        }

        foreach ($fonts as $g_font) {
            if(!empty($g_font)){
                $result .= " " . "<link href='http://fonts.googleapis.com/css?family=" .str_replace(' ' , '+' , trim( $g_font ) ). "' rel='stylesheet' type='text/css' />";
            }
        }

        return $result;
    }

    /*function to set automatically first attached image as featured image on image format post*/
    function autoset_featured() {
        if(is_admin()){
          global $post;
          if (isset($post->ID)) {
          $already_has_thumb = has_post_thumbnail($post->ID);
              if (!$already_has_thumb)  {
              $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
                          if ($attached_image && get_post_format() == 'image') {
                                foreach ($attached_image as $attachment_id => $attachment) {
                                set_post_thumbnail($post->ID, $attachment_id);
                                }
                           } else {}
              }          
          }
        }
    }  //end function

    /*modify_attachment_link function add prettyPhoto to wordpress galleries*/
    function modify_attachment_link( $markup, $id, $size, $permalink ) {
        global $post;
        if ( ! $permalink ) {
            $markup = str_replace( '<a href', '<a class="view" rel="prettyPhoto[slides]-'. $post->ID .'" href', $markup );
        }
        return $markup;
    }

    function hex2rgb($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       //$rgb = array($r, $g, $b);
       $rgb = $r.','. $g.','. $b.', ';

       //return implode(",", $rgb); // returns the rgb values separated by commas
       return $rgb; // returns an array with the rgb values
    }

    /*
     * this function checks if a given element is used in the passed Rows
     * params:
      $rows: array -> that contains the rows information
      $element_name: string -> the element that we are looking for
      return: boolean - true if the element is used and false if it is not used
     */
    function is_element_used($rows, $element_name){
        $result = false;
        foreach ($rows as $key => $template_part) {
            foreach ($template_part['_elements'] as $key => $element) {
                # code...
                //var_dump($element['type'] );
                if($element['type'] == $element_name){
                    $result = true;
                    break;
                }
            }
    
        }

        return $result;
    }

    /*
     * this function returns the current URL
     */
    function curPageURL() {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }



    /*
     * this function checks for the "more" tags in the content
     * params:
     * $content: string -> the post content
     * $post_id: string -> the post ID
     * return: string - the altered content
     */
    function filterThePostContent($content,$post_id='') {

        if ($post_id=='') {
            global $post;
            $post_id = $post->ID;
        }

        // Check for the "more" tags
        $more_pos = strpos($content, '<!--more-->');
        if ($more_pos && !is_single()) {
            $content = substr($content, 0, $more_pos);

            $replace_by = '<a href="' . get_permalink($post_id) . '#more-' . $post_id 
                    . '" class="more-link">'. __('Read More','cosmotheme') .'<span class="meta-nav">&rarr;</span></a>';

            $content = $content . $replace_by;
        }

        return $content;
    }


    function get_meta($the_categories, $post ) {?>
    <div class="meta">
        
        <?php if(strlen(trim($the_categories))){ ?>
        <ul class="meta-list">
            <li class="meta-category">
                <ul class="meta-category-list">
                    <?php echo $the_categories; ?>
                </ul>
            </li>
        </ul>
        <?php } ?> 

        <?php 
            if(options::logic( 'blog_post' , 'meta' ) && meta::logic( $post , 'settings' , 'meta' )){
        ?>
            <ul class="entry-content-meta-list">
                <?php
                    if( options::logic( 'likes' , 'enb_likes' ) && meta::logic( $post , 'settings' , 'love' )){
                ?>
                        <li class=" entry-content-meta-likes">
                            <?php like::content($post->ID,$return = false, $show_icon = false, $show_label = false, $additional_class = 'icon-like');  ?>
                        </li>
                <?php       
                    }

                    post::get_post_comment_number($post->ID,$show_label = false);
                    post::get_views_number_html($post->ID,$show_label = false);
                ?>
                <li class="meta-details-author"><?php echo '<a href="'.get_author_posts_url($post->post_author).'"><span class="count"><i class="icon-author"></i>'.get_the_author_meta('display_name', $post->post_author).'</span></a>'; ?></li>    
                <li class="meta-details-date"><span class="meta_det"><i class="icon-date"></i><?php echo post::get_post_date($post -> ID); ?> </span> </li>

            </ul>
        <?php        
            }
        ?> 

    </div> 
    <?php }

    /*
    * @d1- date to compare with
    * @d2- start date
    * @d3- end date
    */
    function dateDiff ($d1, $d2, $d3) {
    // Return the number of days between the two dates:

        /*days from now till the start of the event*/
        $diff_start_event = round((strtotime($d2)-$d1)/86400);  /*86400 is 24h (1 day)  in secconds*/

        /*days from now till the end of the event*/
        $diff_end_event = round((strtotime($d3)-$d1)/86400);  /*86400 is 24h (1 day)  in secconds*/
        $date_format = get_option( 'date_format' );
        //date()

        if($diff_start_event > 0 && $d2 != '' && strtotime($d2) > $d1) {  /*future*/
            if (abs($diff_start_event) == 1) {
                return abs($diff_start_event) . ' ' . __('day left', 'cosmotheme'); //one day, singular
            } else {
                return abs($diff_start_event) . ' ' . __('days left', 'cosmotheme'); //more than one day, plural
            }
           
        }else if( $diff_start_event <= 0 && $d2 != '' && $diff_end_event >= 0 && $d3 != ''){
            return __('Ongoing','cosmotheme');
        }elseif ($diff_start_event < 0 && $d2 != '' && ( ($diff_end_event < 0 && $d3 != '') || $d3 == '' ) ) {
           // return __('Expired','cosmotheme');
        }else if($d2 == '' && $d3 != ''){
            
            if($diff_end_event > 0){
                if ( abs($diff_end_event) == 1 ) {
                    return abs($diff_end_event) . ' ' . __('day left', 'cosmotheme'); //one day, singular
                } else {
                    return abs($diff_end_event) . ' ' . __('days left', 'cosmotheme'); //more than one day, plural
                }
                

            }elseif($diff_end_event == 0){
                return __('Ongoing','cosmotheme');
            }else{
                //return __('Expired','cosmotheme');
            }
        }


    }  // end function dateDiff


    /*
    * This function shows the corect dates for repeating events
    *Params:
    *@timestamp - string. The date of the event
    *@repeating - string. Possible values: day, week, month, year
    *
    *Return: - string. The time, days, dates, month of the event. It depends  on the @repeating parameter 
    */
    function getRepeatingDate($timestamp, $repeating ){
        $unix_time = strtotime($timestamp);

        switch ($repeating) {
            case 'day':
                $date_time_format = get_option( 'time_format' );
                break;
            case 'week':
                $date_time_format = 'l, '. get_option( 'time_format' ); /*Day of the week + time*/
                break;
            case 'month':
                return date('jS', $unix_time) . ' ' . __('day of the month','cosmotheme').', ' . date(get_option( 'time_format' ), $unix_time); /*Day of the month + time*/
                
                break;
            case 'year':
                $date_time_format = 'F d, ' .get_option( 'time_format' ); /*Month, Date and time*/
                break;            
            
            default:
                $date_time_format = get_option( 'date_format' ) . ', ' . get_option( 'time_format' );
                break;
        }

        return date_i18n($date_time_format, $unix_time);

    }

    /* this function will render the PayPal donate button */
    function render_paypal_btn($paypal_email, $item_name, $currency_code = 'USD', $btn_type='btn_donate_LG', $amount='', $country_language='en_US', $checkout_languages='US'){
        
        if(is_email($paypal_email)){

           if(strlen($item_name)){
                echo '<p class="donation-purpose">'.$item_name.'</p>';
           }
        ?>    
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        
            <input type="hidden" name="cmd" value="_donations">
            <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
            <input type="hidden" name="lc" value="<?php echo $checkout_languages; ?>">
            <input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
            <?php if (strlen($amount)){ ?>
            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
            <?php } ?>
            <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
            <input type="hidden" name="no_note" value="0">
            
            <input type="hidden" name="bn" value="PP-DonationsBF:<?php echo $btn_type; ?>.gif:NonHostedGuest">
            <input type="image" src="https://www.paypalobjects.com/<?php echo $country_language; ?>/i/btn/<?php echo $btn_type; ?>.gif"  name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">

            </form>
        <?php

        }else{
            _e('Please enter a valid paypal email','cosmotheme');
        }

    }

    function get_custom_css() { ?>
            <!--Custom CSS-->
        <style type="text/css">
            <?php if (strlen(options::get_value( 'typography' , 'headings_font_font_family' ))){ ?>
            /*headings*/
            h1, h2, h3, h4, h5, h6{font-family: "<?php echo str_replace('&v1','', str_replace('+' , ' ' , trim( options::get_value( 'typography' , 'headings_font_font_family' ) ) ) ); ?>" !important;  }
            <?php } ?>
            <?php if (strlen(options::get_value( 'typography' , 'primary_font_font_family' ))){ ?>
            /*primary text*/
            article, .post > .excerpt, .widget, p{font-family: "<?php echo str_replace('&v1','', str_replace('+' , ' ' , trim( options::get_value( 'typography' , 'primary_font_font_family' ) ) ) ); ?>" !important;}
            <?php } ?>
/*            <?php if (strlen(options::get_value( 'typography' , 'secondary_font_font_family' ))){ ?>
            /* secondary text that has class 'st' */
            /*.st{font-family: "<?php echo str_replace('&v1','', str_replace('+' , ' ' , trim( options::get_value( 'typography' , 'secondary_font_font_family' ) ) ) ); ?>";}
            <?php } ?>*/
            
            <?php

                if( strlen(options::get_value( 'styling' , 'headings_color' ) ) ){
                    echo 'h1, h2, h3, h4, h5, h6, .grid-view article.grid-elem > .entry-content > ul > li.entry-content-title h4,
                    .team-view article.team-elem > .entry-content > ul > li.entry-content-title h4,
                    .list-view .entry-content > ul > li.entry-content-title h4,
                    .box-view article.box .entry-content ul > li.entry-content-title h4,
                    .thumb-view div.entry-content ul > li.entry-content-title h4,
                    .list-view .entry-content > ul > li.entry-content-title h4 {color:'.options::get_value( 'styling' , 'headings_color' ).';}';
                    echo '.content-title:after, .widget .widget-delimiter, #reply-title:after, #comments-title:after { border-left: 30px solid '.options::get_value( 'styling' , 'headings_color' ).'; }';
                    echo '.post ul.entry-content-tag-list > li.entry-content-tag-elem a:before, .tabs-container > ul.entry-content-tag-list > li.entry-content-tag-elem a:before
                    { border-right: 10px solid '.options::get_value( 'styling' , 'headings_color' ).';}';
                    echo '.post ul.entry-content-tag-list > li.entry-content-tag-elem a, .tabs-container > ul.entry-content-tag-list > li.entry-content-tag-elem a { background-color: '.options::get_value( 'styling' , 'headings_color' ).';}';
                }

                if( strlen(options::get_value( 'styling' , 'links_color' ) ) ){
                    echo 'article.post a{color:'.options::get_value( 'styling' , 'links_color' ).';}';
                }

                if( strlen(options::get_value( 'styling' , 'labels_bg_color' ) ) ){
                    $labels_bg_color = options::get_value( 'styling' , 'labels_bg_color' );
                    $labels_text_color = options::get_value( 'styling' , 'labels_text_color' );
                    $labels_bg_color_rgb = hex2rgb(options::get_value( 'styling','labels_bg_color' ));

                    echo '.load-more-wrapper .load-more, 
                    .pag ul li .page-numbers,
                    .splitter li a.selected, .thumbs-splitter li a.selected,
                    .tabment ul.tabment-tabs li a.active, 
                    .header-slideshow-elem-content .slide-button, 
                    .thumb-view div.entry-content ul>li.entry-content-category>ul.category-list>li a, 
                    .list-view .entry-content>ul>li.entry-content-category>ul>li a, 
                    .testimonials-view ul.testimonials-carousel-nav > li, 
                    .widget ul.testimonials-carousel-nav > li, 
                    .grid-view article.grid-elem > .entry-content > ul > li.entry-content-category > ul > li a, 
                    .timeline-view .timeline-elem article.list-medium-image ul.timeline-elem-meta > li, 
                    .team-view article .featimg .entry-content-category, 
                    .team-view article.team-elem > .entry-content > ul > li.entry-content-category > ul > li a, 
                    .post>.meta>ul.meta-list>li.meta-category>ul.meta-category-list>li>a,
                    .single_carousel > .es-nav > li:hover,
                    ul.related-tabs li, .carousel-wrapper ul.carousel-nav > li, .event-date-label
                    { background-color: ' . $labels_bg_color . '; color: ' . $labels_text_color . '; }';

                    echo '.timeline-view .timeline-elem article.list-medium-image{
                        border-left: 3px solid ' . $labels_bg_color . ';
                    }';

                    echo '.post .featimg .post-caption{
                        border-left: 5px solid ' . $labels_bg_color . ';
                    }';
                    echo '.splitter, .thumbs-splitter, ul.related-tabs {
                        border-bottom: 1px solid ' . $labels_bg_color . ';
                    }';
                    echo '.splitter li a, .thumbs-splitter li a, .tabment ul.tabment-tabs li a, .carousel-wrapper ul.carousel-nav > li:hover
                    {
                        background-color: '. $labels_bg_color .';
                        background-color: rgba(' . $labels_bg_color_rgb . 'x0.7);
                    }';
                    echo '.fountainG{background-color: '.$labels_bg_color.' !important;}';  
                    echo 'input[type="submit"], button, input[type="button"], input[type="submit"]:hover, button:hover, input[type="button"]:hover{background-color: '.$labels_bg_color.'; color: '.$labels_text_color.' !important;}';                  
                }
            ?>
            <?php echo options::get_value( 'custom_css' , 'css' ); ?>    

            <?php  
                $template = LBTemplate::figure_out_template(); /*initialize template*/
                if (strlen($template->header_bg_color)) {
                    $rgb = hex2rgb($template->header_bg_color);
                    if(strlen($template->header_bg_opacity)){
                        $rgb = $rgb.' '. 0.01*(int)$template->header_bg_opacity;
                    }
                }
           
                $rgba_bachground = "background-color: rgba(".$rgb.") !important; ";
                if (strlen($template->header_text_color)) {
                    $header_text_color = "color:" . $template->header_text_color;
                }

                $slideshow_bullet_color = ' background-color: '. $template->header_bg_color .';';

                $rgb_footer = options::get_value( 'styling','footer_bg_color' ) ;
                $footer_text_color = options::get_value( 'styling','footer_text_color' ) ;
            ?>

            /*set background color and text for header*/
            header#header-container .header-container-wrapper{ 
                <?php echo $rgba_bachground; ?>
                <?php echo $header_text_color; ?>
            }

            .post-event .time-left, .time-left, .event-date-label { background-color: <?php echo $template->header_bg_color; ?>;  <?php echo $header_text_color; ?>; }

            ul.header-slideshow-navigation > li.header-slideshow-navigation-elem.active { <?php echo $slideshow_bullet_color; ?> }

            /*set background color and text for footer*/
            footer#colophon .footer-styles { 
                background-color: <?php echo $rgb_footer; ?>;
                color: <?php echo $footer_text_color; ?>;
            }
            .popular-tags ul.entry-content-tag-list > li.entry-content-tag-elem a:before { border-right: 10px solid <?php echo options::get_value( 'styling','header_bg_color' ); ?>; }
            .popular-tags ul.entry-content-tag-list > li.entry-content-tag-elem a { background-color: <?php echo options::get_value( 'styling','header_bg_color' ); ?>; }

        </style>

        <?php if( options::get_value( 'styling' , 'logo_type' ) == 'text' ) {
            $logo_font_family = explode('&',options::get_value('styling' , 'logo_font_family'));
            $logo_font_family = $logo_font_family[0];
            $logo_font_family = str_replace( '+',' ',$logo_font_family );

            if( strlen(options::get_value( 'styling' , 'logo_text_color' ) ) ){
                $logo_color = options::get_value( 'styling' , 'logo_text_color' );
            }
        ?>
            <style type="text/css">
                header#header-container .header-container-wrapper .logo h1{
                    font-family: '<?php echo $logo_font_family ?>','Helvetica', 'Helvetica Neue', arial, serif;
                    font-weight: <?php echo options::get_value('styling' , 'logo_font_weight')?>;
                    color: <?php echo $logo_color; ?>; 
                    font-size: <?php echo options::get_value('styling' , 'logo_font_size')?>px;
                }
                .logo a span{color: <?php echo $logo_color; ?>; }
            </style>
        <?php } 
   }
?>
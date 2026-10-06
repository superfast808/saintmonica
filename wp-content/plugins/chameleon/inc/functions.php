<?php defined( 'ABSPATH' ) or die( __('No script kiddies please!', 'chameleon') );



	function chameleon_valid_layouts(){
		global $wpc_supported, $wpdb;
		
		$ret = array();
		
		if(!empty($wpc_supported)){
			//wpc_pree($wpc_supported);
			foreach($wpc_supported as $key=>$arr){
				$forms_array = array();
				
				if($arr['installed']==1 && $arr['activated']==1){}else{ continue; }
				
				$ret[$key]['list'] = array();
				switch($key){
					
					case 'cf7':
						$args = array(
							'posts_per_page'   => -1,
							'offset'           => 0,
							'orderby'          => 'title',
							'order'            => 'ASC',
							'post_type'        => 'wpcf7_contact_form',
							'post_status'      => 'publish',
							'suppress_filters' => true 
						);
						$forms_array = get_posts( $args );

						
						
					break;
					
					case 'gf':
						
						$res = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."rg_form WHERE is_active=1");
						
						if(!empty($res)){
			
							foreach($res as $garr){
								$obj = new stdClass;
								$obj->post_title = $garr->title;
								$obj->ID = $garr->id;
								$forms_array[] = $obj;
							}
				
						}

					break;
					
					
				}
				
				$ret[$key]['action_txt'] = $arr['action_txt'];
				$ret[$key]['link'] = $arr['link'];
				$ret[$key]['list'] = $forms_array;
			}
		}
		
		return $ret;
	}
	
	function sanitize_wpc_data( $input ) {

		if(is_array($input)){
		
			$new_input = array();
	
			foreach ( $input as $key => $val ) {
				$new_input[ $key ] = (is_array($val)?sanitize_wpc_data($val):sanitize_text_field( $val ));
			}
			
		}else{
			$new_input = sanitize_text_field($input);
		}
		
		return $new_input;
	}
	
	function wpc_third_party_support(){
		
		global $wpc_plugins_activated, $wpc_all_plugins;
		
		if(
				array_key_exists('alphabetic-pagination/index.php', $wpc_all_plugins)
			&&
				in_array('alphabetic-pagination/index.php', $wpc_plugins_activated)
		){
		
			$wp_chameleon = get_option( 'wp_chameleon', array());
			$wp_chameleon = (is_array($wp_chameleon)?$wp_chameleon:array());
			$wp_chameleon['ap'] = isset($wp_chameleon['ap'])?$wp_chameleon['ap']:array();
			$wp_chameleon['apt'] = isset($wp_chameleon['apt'])?$wp_chameleon['apt']:array();
			
			if(isset($_REQUEST['ap_style']) && !empty($_REQUEST['ap_style'])){		
				$wp_chameleon['ap'] = array($_REQUEST['ap_style']=>array('enabled'));
			}	
			if(isset($_REQUEST['ap_template']) && !empty($_REQUEST['ap_template'])){		
				$wp_chameleon['apt'] = array($_REQUEST['ap_template']=>array('enabled'));
			}	
			
			update_option( 'wp_chameleon', sanitize_wpc_data($wp_chameleon));
			
				
		}
	}
	
	function chameleon_filter_data($data) {
		
		$ret = array();
		if(!empty($data)){
			global $wpc_supported, $wpc_assets_loaded;
			$chameleon_valid_layouts = chameleon_valid_layouts();

			foreach($data as $key=>$arr){
				
				$last_node = $wpc_supported[$key]['last_node'];				
				$arr['forms'] = (is_array($arr['forms'])?$arr['forms']:array());
				if(array_key_exists($key, $wpc_supported)){
					$valid_ids = array();
					if(!empty($chameleon_valid_layouts[$key]['list'])){
						foreach($chameleon_valid_layouts[$key]['list'] as $obj){
							$valid_ids[] = $obj->ID;
						}
					}
					
					$ret[$key] = array();
					$style = $arr['styles'];
					if(array_key_exists($style, $wpc_assets_loaded[$key])){
						$ret[$key]['styles'] = $style;
						$ret[$key]['forms'] = array();
						$arr['forms']= array_map('intval', $arr['forms']);
						
						if(!empty($arr['forms'])){
							if($last_node){
								$ret[$key]['forms'] = array('enabled');
							}else{
								$matching = array_intersect($valid_ids, $arr['forms']);
								$ret[$key]['forms'] = $matching;
							}
						}
					}
					
					
				}
			}
			//pree($ret);exit;
		}
	 
		return $ret;
	}	



	function wpc_pre($data){
		if(isset($_GET['debug'])){
			wpc_pree($data);
		}
	}	 
		

	function wpc_pree($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';	
		
	}	 




	function chameleon_menu()
	{


		global $wpc_data, $wpc_pro;
		$pname = $wpc_data['Name'].' '.($wpc_pro?__('Pro', 'chameleon'):'').' ('.$wpc_data['Version'].')';
		add_options_page($pname, $pname, 'install_plugins', 'wpc', 'wpc');
		


	}
	
	function chameleon_search($needle,$haystack) {
		foreach($haystack as $key=>$value) {
			$current_key=$key;
			if($needle===$value OR (is_array($value) && chameleon_search($needle,$value) !== false)) {
				return $current_key;
			}
		}
		return false;
	}
		
	function chameleon_recursive_removal(&$array, $val)
	{
		if(is_array($array))
		{
			foreach($array as $key=>&$arrayElement)
			{
				if(is_array($arrayElement))
				{
					chameleon_recursive_removal($arrayElement, $val);
				}
				else
				{
					if($arrayElement == $val)
					{
						unset($array[$key]);
					}
				}
			}
		}
	}	
	
	function chameleon_super_unique($array)
	{
		$result = array();
		
		if(!is_array($array))
		return $result;
		
		$serialize = array_map("serialize", $array);

		if(!is_array($serialize))
		return $result;
		
		$for_unserialize = array_unique($serialize);
		
		if(!is_array($for_unserialize))
		return $result;		
		
		$result = array_map("unserialize", $for_unserialize);
		
		foreach ($result as $key => $value)
		{
			if ( is_array($value) )
			{
				$result[$key] = chameleon_super_unique($value);
			}
		}
		
		return $result;
	}

	function wpc(){ 
	
		if ( !current_user_can( 'install_plugins' ) )  {

			wp_die( __( 'You do not have sufficient permissions to access this page.', 'chameleon' ) );

		}

		global $wpdb, $wpc_dir, $wpc_pro, $wpc_data; 

		
		include($wpc_dir.'inc/wpc_settings.php');
		
	}	



	
	

	function chameleon_plugin_links($links) { 
		global $wpc_premium_link, $wpc_pro;
		
		$settings_link = '<a href="options-general.php?page=wpc">'.__('Settings', 'chameleon').'</a>';
		
		if($wpc_pro){
			array_unshift($links, $settings_link); 
		}else{
			 
			$wpc_premium_link = '<a href="'.$wpc_premium_link.'" title="'.__('Go Premium', 'chameleon').'" target=_blank>'.__('Go Premium', 'chameleon').'</a>'; 
			array_unshift($links, $settings_link, $wpc_premium_link); 
		
		}
		
		
		return $links; 
	}
	
	function register_wpc_scripts() {
		
			
		if (is_admin ()){
		
			wp_enqueue_media ();
		
			wp_enqueue_style( 'wpc-style', plugins_url('css/admin-styles.css', dirname(__FILE__)), array(), date('Yhmi'));
		
		}else{
					
			wp_enqueue_style( 'wpc-style', plugins_url('css/front-styles.css', dirname(__FILE__)), array(), date('Yhmi'));
			
			
			
		}

		wp_enqueue_script(
			'wpc-scripts',
			plugins_url('js/scripts.js', dirname(__FILE__)),
			array('jquery'),
			date('Yhmi'),
			true
		);	
		
	
	} 
		
	function wp_chameleon(){
		global $wpc_assets_loaded, $wpc_supported;
		//pree($wpc_assets_loaded);
		$wp_chameleon = get_option( 'wp_chameleon');
		$wp_chameleon = loading_addon_personalization($wp_chameleon);
		$link_css = array();
		//pre($wp_chameleon);
		//pree($wpc_assets_loaded);
		//pree($wpc_supported);
		$css = array();
		if(is_array($wp_chameleon) && !empty($wp_chameleon)){
			foreach($wp_chameleon as $key=>$data){
						
				if(!empty($data)){
					foreach($data as $style=>$forms){					
						//pree($forms);
						
						if(!empty($forms)){
							foreach($forms as $form){
								if(is_numeric($form) || in_array($form, array('enabled')))
								$css[$key][$form] = ($wpc_assets_loaded[$key][$style]['styles']);
							}
						}elseif($wpc_supported[$key]['last_node']){
							//pree($key);
							//$css[$key][$style] = $wpc_assets_loaded[$key][$style]['styles'];
						}
				
					}
				}
			}
		}
		//exit;
		//pree($css);exit;
		
		if(!empty($css)): ?>
<style type="text/css" media="all">
<?php				
			//pree($css);
			foreach($css as $key=>$forms): 
				if(!empty($forms)){
					//pree($forms);
					foreach($forms as $form_id=>$styles){
						if(!empty($styles)){
							foreach($styles as $name=>$path){
								
								
								
								if($form_id>0){
									switch($key){
										case 'cf7':
										
											echo str_replace(array('body', '.wpcf7{', 'div.wpcf7 '), array('.ignore_it body', 'div[id^="wpcf7-f'.$form_id.'"].wpcf7{', 'div[id^="wpcf7-f'.$form_id.'"]div.wpcf7 '), file_get_contents($path));
											
										break;
										case 'gf':
											
											echo str_replace(array('body', '.gform_wrapper'), array('.ignore_it body', '#gform_wrapper_'.$form_id.'.gform_wrapper'), file_get_contents($path));
											
										break;
									}
								}elseif($wpc_supported[$key]['last_node']){
									//pree($wpc_supported);
									//pree($key);
									switch($key){
										case 'wc':
										case 'twentyseventeen':
										case 'twentysixteen':
										case 'twentyfifteen':
										case 'twentyfourteen':
										case 'twentythirteen':
										case 'twentytwelve':
										case 'twentyeleven':
										case 'twentyten':
										case 'ap':
										case 'apt':
										case 'bp':
											$link_css[] = $path;
										break;
									}									
								}
							}
						}
					}
				}					
			endforeach; //exit;?>
</style>			
<?php		endif;

			//pree($link_css);exit;
			
			if(!empty($link_css)){
				$dir = plugin_dir_path( dirname(__FILE__) );
				$purl = plugin_dir_url( dirname(__FILE__) );
				//pree($dir);
				//pree($purl);
				foreach($link_css as $link){
					$link = str_replace($dir, $purl, $link);
					//pree($link);
?>
<link href="<?php echo $link; ?>" type="text/css" rel="stylesheet" />
<?php					
				}
			}
?>
<style type="text/css">

</style>
<?php			
			


	}
	
	function get_chameleon(){

	}
	
	function loading_addon_personalization($wp_chameleon){
		
		global $wpc_supported, $wpc_assets_loaded;
		
		if($wpc_supported['bp']['activated']){
			//pree($wpc_assets_loaded['bp']);
			if(
				bp_displayed_user_id()
			){
				$bpc_selected = get_user_meta(bp_displayed_user_id(), 'bpc_theme', true);
				if($bpc_selected!=''){
					$wp_chameleon['bp'] = array($bpc_selected=>array('enabled'));					
				}								
			}
				
		}
		
		return $wp_chameleon;
	}
	
    function bpc_user_nav_item() {
        global $bp;
     
        $args = array(
                'name' => __('Themes', 'chameleon'),
                'slug' => 'bpc',
                'default_subnav_slug' => 'bpc',
                'position' => 100,
                'show_for_displayed_user' => false,
                'screen_function' => 'bpc_user_nav_item_screen',
                'item_css_id' => 'bpc'
        );
     
        bp_core_new_nav_item( $args );
    }
    add_action( 'bp_setup_nav', 'bpc_user_nav_item', 99 );
	
    function bpc_user_nav_item_screen() {
        add_action( 'bp_template_content', 'bpc_screen_content' );
        bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    }
	
    function bpc_screen_content() {
		
		global $wpc_assets_loaded, $wpc_dir, $wpc_url;
		
		$slug = 'buddypress';
		$short = 'bp';
		$bp = $wpc_assets_loaded[$short];
		$bpc_selected = get_user_meta(bp_displayed_user_id(), 'bpc_theme', true);
		
		
		if(!empty($bp)){
?>
		<ul class="bpc_list">
<?php			
			foreach($bp as $style=>$assets){  $cap = wpc_capitalize($style); 
			
			$wpc_previews = wpc_previews($slug, $style, $assets, $short);
			extract($wpc_previews);
				
?>
		<li <?php echo ($bpc_selected==$style?'class="bpc_activated"':''); ?>>
        	<a title="Click here to activate <?php echo $cap; ?> theme" href="?bpc=<?php echo $style; ?>">
            	<img src="<?php echo $thumb; ?>" alt="<?php echo $cap; ?>" />
                <h4><?php echo $cap; ?></h4>
            </a>
        </li>
<?php							
				
			}
?>
		</ul>
<?php			
		}
     
     
    }			
	
	function personalizing_addons(){
		
		global $wpc_supported, $wpc_assets_loaded;
		
		if($wpc_supported['bp']['activated']){
			//pree($wpc_assets_loaded['bp']);
			if(
						is_user_logged_in() 
					&&
						bp_displayed_user_id()==get_current_user_id()	
					&& 
						isset($_GET['bpc']) 
					&& 
						array_key_exists($_GET['bpc'], $wpc_assets_loaded['bp'])
			){
				
				

				
				update_user_meta(get_current_user_id(), 'bpc_theme', sanitize_wpc_data($_GET['bpc']));
				//exit;
			}
			
		}
		
	}
	
    function chameleon_loading_assets(){
		global $wpc_supported, $wpc_assets, $wpc_assets_loaded, $wpc_pro;
		
		
		
		//pree($wpc_supported);pree($wpc_assets);
		if(!empty($wpc_supported)){
			foreach($wpc_supported as $key=>$data){
				$dir = $wpc_assets.$key;
				if(is_dir($dir)){
					//pree($dir);
					$dir_iterator = new RecursiveDirectoryIterator($dir);
					//pree($dir_iterator);
					foreach ($dir_iterator as $name=>$obj) {
						//pree($name);
						if(!in_array($obj->getfileName(), array('.', '..'))){
							if(is_dir($obj->getpathName())){
								$for_version_dir = $dir.'/'.$obj->getfileName();
								//pree($for_version_dir);exit;
								$folders = array();
								//pree($for_version_dir);
								if ($dh = opendir($for_version_dir)) {
									while (($file = readdir($dh)) !== false) {
										//pree($file);
										if(!in_array($file, array('.', '..')) && is_dir($for_version_dir.'/'.$file)){
											$folders[] = $file;	
										}
									}
									closedir($dh);
								}							
								//pree($folders);exit;
								//pree($folders);
								$styles = $images = $scripts = $fonts = $templates = array();
								
								if(!empty($folders)){
									foreach($folders as $folder){
										//pree($folder);
										$style_dir = $dir.'/'.$obj->getfileName().'/'.$folder;
										
										
			
										if(is_dir($style_dir)){
											$gd = $style_dir.'/*.*';
											
											foreach(glob($gd) as $file){
												$name = basename($file);
												$ext = explode('.', $name);
												$name_only = current($ext);
												$ext = end($ext);
												$ext = strtolower($ext);
												$pro_file = str_replace('/assets/', '/pro/assets/', $file);
												switch($ext){
													case 'jpg':
													case 'jpeg':
													case 'png':
													case 'gif':
													case 'bmp':
														$images[$name_only] = $file;
													break;
													case 'js':
														$scripts[$name_only] = $file;
													break;
													case 'css':
														
														$styles[$name_only] = ($wpc_pro && file_exists($pro_file)?$pro_file:$file);
													break;
													case 'ttf':
														$fonts[$name_only] = $file;
													break;
													case 'html':
														$templates[$name_only] = $file;
													break;													
													
													
												}
											}
										}
									}
								}
								
								$wpc_assets_loaded[$key][$obj->getfileName()] = array(
									'styles' => $styles,
									'images' => $images,
									'scripts' => $scripts,
									'fonts' => $fonts,
									'templates' => $templates
								);
								//pree($wpc_assets_loaded);exit;
							}
							
						}
					}
					
				}
				//pree($wpc_assets_loaded);
				//exit;
				
			}
			
			//pree($wpc_assets_loaded);
			personalizing_addons();
		}
	}
	function wpc_capitalize($name){
		return ucwords(str_replace(array('-'), ' ', $name)); 
	}
	
	function wpc_slug_to_short($slug){
		
		$ret = array();
		
		global $wpc_supported;
		
		if(!empty($wpc_supported)){
			foreach($wpc_supported as $short=>$data){
				if($slug==$data['slug']){
					$ret[] = $short;
				}
			}
		}
		
		return $ret;
	}
	
	function wpc_previews($slug, $name, $data, $short=''){
		global $wpc_dir, $wpc_url, $wpc_counter, $wpc_supported;
		
		//pree($slug.' > '.$name.' > '.$short.' > '.$wpc_supported[$short]['activated']);
		
		$github_slug = (array_key_exists('github', $wpc_supported[$short])?$wpc_supported[$short]['github']:$slug);
		
		//pree("$slug, $name");
		//pree($data);
		
		
		//$shorts = wpc_slug_to_short($slug);
		//pree($shorts);
		
		
		/*if(!empty($shorts)){
			foreach($shorts as $key){
				pree($slug.' > '.$key.' > '.$wpc_supported[$key]['activated']);
			}
		}*/

		
		
		$preview = 'https://raw.githubusercontent.com/uxglow/'.$github_slug.'/master/'.$name.'/1.0/';
		//pree($preview);
		$remote_screenshot = $preview.'screenshot.png';
		$remote_thumb = $preview.'thumb.png';
		//wpc_pree($data);
		
		if(isset($data['images']['thumb']) && file_exists($data['images']['thumb'])){
			$thumb = str_replace($wpc_dir, $wpc_url, $data['images']['thumb']);
		}elseif(isset($data['images']['screenshot']) && file_exists($data['images']['screenshot'])){
			$thumb = str_replace($wpc_dir, $wpc_url, $data['images']['screenshot']);
		}elseif($wpc_supported[$short]['activated']){
			$thumb = $remote_screenshot;
			
			$path = str_replace($name.'/css/'.$name.'.css', $name.'/images/', $data['styles'][$name]);
			$data['images']['thumb'] = $path.'thumb.png';
			$data['images']['screenshot'] = $path.'screenshot.png';
			
			if($wpc_counter<20){
				
				if(!file_exists($data['images']['thumb'])){
					@copy($remote_thumb, $data['images']['thumb']);				
				}
				if(!file_exists($data['images']['screenshot'])){
					@copy($remote_screenshot, $data['images']['screenshot']);				
				}
				$wpc_counter++;
			}
		}		
		$ret = array('remote_screenshot'=>$remote_screenshot, 'remote_thumb'=>$remote_thumb, 'thumb'=>$thumb);
		
		//pree($ret);
		
		return $ret;
	}
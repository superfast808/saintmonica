<?php defined( 'ABSPATH' ) or die( __('No script kiddies please!', 'chameleon') );
	if ( !current_user_can( 'install_plugins' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'chameleon' ) );
	}
	
	
	global $wpc_supported, $wpc_assets_loaded, $wpc_url, $wpc_plugins_activated, $wpc_pro, $wpc_premium_link;
	$youtube = array ( 'L9azlLO3-rE', '-FuZt32IUqM', 'Wy9CnWZZCO0' );
	
	
	$chameleon_valid_layouts = chameleon_valid_layouts();
	
	$wpc = isset( $_POST['wpc'] ) ? (array) $_POST['wpc'] : array();
	
	
	if (!empty($wpc)) {
				
		
		$wpc = chameleon_filter_data($wpc);
		
		if ( 
				! isset( $_POST['wpc_valid_f'] ) 
				|| ! wp_verify_nonce( $_POST['wpc_valid_f'], 'wpc_valid_a' ) 
			) {
			
			   print __('Sorry, your nonce did not verify.');
			   exit;
			
			} else {
			
				$wpc_reset_action = $_POST['wpc_reset_action'];
				//wpc_pree($wpc);	
				$wp_chameleon = get_option( 'wp_chameleon');
		
				
				foreach($wpc as $key=>$data){
					$wpc[$key][$wpc[$key]['styles']] = array();
					
					if(!empty($wpc[$key]['forms'])){
						foreach($wpc[$key]['forms'] as $form){
							chameleon_recursive_removal($wp_chameleon[$key], $form);
						}
					}
					
					
					$wpc[$key][$wpc[$key]['styles']] = $wpc[$key]['forms'];
					
					unset($wpc[$key]['styles']);
					unset($wpc[$key]['forms']);
		
				}
				//pree($wp_chameleon);exit;
				$wp_chameleon = chameleon_super_unique($wp_chameleon);
				
				//pree($wp_chameleon);exit;
				$result = array_merge_recursive($wp_chameleon, $wpc);
				
				
				if(!empty($wpc_reset_action)){
					foreach($wpc_reset_action as $key=>$bool){
						if($bool=='true'){
							$result[$key] = array();
						}
					}
				}
				//wpc_pree($result);//wpc_pree($wpc_reset_action);
				//exit;				
				
				//
				update_option( 'wp_chameleon', sanitize_wpc_data($result));
			}
		
		
	}
	
	//pree($wpc_assets_loaded);
	
	$wp_chameleon = get_option( 'wp_chameleon');
	$wpc_theme = wp_get_theme();
	//pree($wpc_dir);
	//pree($wpc_data);
	//pree($wp_chameleon);
	//pree($wpc_supported);
	
?>	




<div class="wrap wpch">
        
	<?php if(!$wpc_pro): ?>
    <a title="<?php _e('Click here to download pro version', 'chameleon'); ?>" style="background-color: #333;    color: #fff !important;    padding: 2px 30px;    cursor: pointer;    text-decoration: none;    font-weight: bold;    right: 0;    position: absolute;    top: 0;    box-shadow: 1px 1px #ddd;" href="http://shop.androidbubbles.com/download/" target="_blank"><?php _e('Already a Pro Member?', 'chameleon'); ?></a>
    <?php endif; ?>       
    
  
    <div class="head_area">
    <h2><span class="dashicons dashicons-welcome-widgets-menus"></span><?php echo $wpc_data['Name'].' '.($wpc_pro?__('Pro', 'chameleon'):''); ?> (<?php echo $wpc_data['Version']; ?>) - <?php _e('Settings', 'chameleon'); ?> </h2>
    
    </div>
  
    
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-active"><?php _e("Styles","chameleon"); ?></a>        
        <a class="nav-tab"><?php _e("How it works?","chameleon"); ?></a>
    </h2>              
        
        
        
        
     
        
	
    <form class="nav-tab-content wpch_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
     <div class="wpch_primary">
    	<h6 class="sub_heading" style="float:right"><?php _e('Supported Plugins', 'chameleon'); ?></h6>
        
        <?php //pree($wpc_plugins_activated); ?>
        <?php //pree($wpc_supported); ?>
        <?php if(!empty($wpc_supported)): ksort($wpc_supported); ?>
        <ul> 
        	<?php foreach($wpc_supported as $key=>$data): ?>
            <?php //if($data['installed']): ?>
            <li class="wpc_supported <?php echo ($data['installed']?__('installed'):'').' '.(isset($data['class'])?$data['class']:'').' '.($data['active']?'available':'upcoming'); ?>">
                <a data-key="<?php echo $key; ?>">
                	<span><?php echo $data['active']?'':__('Coming Soon!', 'chameleon'); ?></span>
                    <img src="<?php echo plugins_url( 'images/'.$data['icon'], dirname(__FILE__) ); ?>"  alt="<?php echo $data['name']; ?>" />
                    <h4><?php echo $data['name']; ?></h4>
                </a>
            </li> 
            <?php //endif; ?>
            <?php endforeach; ?>
        </ul>
        
        <?php endif; ?>   
        
    <div class="wpch_form_wrap">
		<?php wp_nonce_field( 'wpc_valid_a', 'wpc_valid_f' ); ?>
        
        
        
        
        
        
        
	
                
        	<?php if(!empty($wpc_assets_loaded)): //pree($wpc_assets_loaded);?>
           
            <?php 
			//pree($wpc_assets_loaded);
			foreach($wpc_assets_loaded as $item=>$types): //pree($data['styles']);
				//pree($types);
				$slug = $wpc_supported[$item]['slug'];
			 ?>            
             <a data-grid="<?php echo $item; ?>" href="//guavapattern.com/chameleon/?load=<?php echo $item; ?>" title="<?php _e('Click here to view all styles', 'chameleon'); ?>" class="wpch_grid" target="_blank"></a>
             
             <input title="<?php _e('Click here to reset to default', 'chameleon'); ?>" data-item="<?php echo $item; ?>" name="wpc_reset[<?php echo $item; ?>]" type="button" value="<?php _e('Reset', 'chameleon'); ?>" class="wpch_btn_reset hide" />
             <input name="wpc_reset_action[<?php echo $item; ?>]" type="hidden" value="" />
             <select class="wpch_form_style" name="wpc[<?php echo $item; ?>][styles]" size="2" data-obj="<?php echo $item; ?>">
             
            <?php if(!empty($types)): ?>
            
            <?php foreach($types as $name=>$data): $cap = wpc_capitalize($name);
			
			$wpc_previews = wpc_previews($slug, $name, $data, $item);
			extract($wpc_previews);
			
			?>            
            <option data-css="<?php echo (isset($data['styles'][$name])?'yes':'no'); ?>" data-cap="<?php echo $cap; ?>" value="<?php echo $name; ?>" data-forms="<?php echo (isset($wp_chameleon[$item][$name])?implode('|', $wp_chameleon[$item][$name]):''); ?>" data-url="<?php echo $thumb; ?>" data-full="<?php echo $remote_screenshot; ?>"><?php echo $cap.' '.(isset($wp_chameleon[$item][$name])?'('.count($wp_chameleon[$item][$name]).')':''); ?></option>
            <?php endforeach; ?>
			<?php endif; ?>
            </select>
            <?php endforeach; ?>
             
            <?php endif; ?>
            
           
            <div class="wpch_thumbnail">
                <span class="title">&nbsp;</span>
                <img src="" />
                <span class="preview"></span>
            </div>
            
       		<?php if(!empty($wpc_supported)): //pree($wpc_supported); ?>       
        	<?php foreach($wpc_supported as $key=>$data): //pree($data); ?>
            <div class="wpch_cf7_wrap wpch_<?php echo $key; ?>_form">
            <?php if($data['installed'] && $data['activated']): ?>
           

                
<?php

	
	$forms_array = $chameleon_valid_layouts[$key]['list'];
	$create_form = $chameleon_valid_layouts[$key]['link'];
	$create_form_label = $chameleon_valid_layouts[$key]['action_txt'];
	$items = $wpc_supported[$key]['items'];
	$last_node = $wpc_supported[$key]['last_node'];


	if($items){
		if(!empty($forms_array)): ?>
					<span><a href="<?php echo $create_form; ?>" target="_blank"><?php echo $create_form_label; ?></a></span>
					<b><?php _e('or', 'chameleon'); ?></b>
					<h3><?php _e('Select Forms', 'chameleon'); ?></h3>
					<select class="wpch_cf7 wpch_forms_selection" name="wpc[<?php echo $key; ?>][forms][]" multiple="multiple">
	<?php foreach($forms_array as $form): $cap = ucwords(str_replace(array('-'), ' ', $form->post_title));  ?>                
					  <option value="<?php echo $form->ID; ?>" data-cap="<?php echo $cap; ?>"><?php echo $cap; ?></option>
	<?php endforeach; ?>                  
					</select><br />
	<small><?php _e('Hold ctrl key for multiple selection', 'chameleon'); ?>.</small>
	<div class="wpch_buton">
						<input class="button button-primary wpch_apply" type="submit" name="apply" value="<?php _e('Apply', 'chameleon'); ?>"/>
					</div>                
	<?php else: ?>       
	<center><?php _e('No items found.', 'chameleon'); ?><br /><br />
	
	   
	<span><a href="<?php echo $create_form; ?>" target="_blank"><?php echo $create_form_label; ?></a></span>      
	</center>
<?php 
		endif;
	}else{
?>
 
    	<?php if($last_node): ?>
        <input type="hidden" name="wpc[<?php echo $key; ?>][forms][]" value="enabled" />
        <div class="wpch_buton">
            <input class="button button-primary wpch_apply" type="submit" name="apply" value="<?php echo $create_form_label; ?>"/>
        </div>  
		<?php else: ?>
		<center>        
			<span><a href="<?php echo $create_form; ?>" target="_blank"><?php echo $create_form_label; ?></a></span>      
	    </center>
        <?php endif; ?>
<?php		
	}
?>
            
                  
			<?php elseif($data['installed']): ?>         
<center>
<?php echo $data['name']; ?> <?php _e('is not activated.', 'chameleon'); ?><br /><br />

   
<span><a href="<?php echo ($data['activate'].$data['slug']); ?>" target="_blank"><?php _e('Activate', 'chameleon'); ?><?php echo $data['name']; ?></a></span>      
</center>            
            <?php else: ?>        
            
<center>
<?php echo $data['name']; ?> <?php _e('is not installed.', 'chameleon'); ?><br /><br />

   
<span><a href="<?php echo $data['install'].urlencode( $data['name']); ?>" target="_blank"><?php _e('Install'); ?> <?php echo $data['name']; ?></a></span>      
</center>                
			<?php endif; ?>  
            </div>        
			<?php endforeach; ?> 
			<?php endif; ?>
                 
           	
        
    </div>
    </div>
    </form>
    
    
    
    
    
    
    
    
    <form class="nav-tab-content hide" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<span class="wpch_help"><a href="https://wordpress.org/support/plugin/chameleon" target="_blank"><?php _e('need help?', 'chameleon'); ?></a></span>
        


   
   <?php if(!empty($youtube)){ ?>
   
        <ul class="wpch_v_tutorials">

      <?php foreach( $youtube as $id ) { ?>
   
            <li>
            	<iframe width="150" height="100" src="https://www.youtube.com/embed/<?php echo $id; ?>" frameborder="0" allowfullscreen></iframe>
            </li>		
		
		<?php } ?>
        
        </ul>
   
   <?php } ?>
   
        <ul class="wpch_tutorials">
        	<li>
            	<h3><?php _e('Resources', 'chameleon'); ?></h3>
            </li>
        	<li>
            	<a href="https://plugins.svn.wordpress.org/chameleon/assets/guide.pdf" target="_blank"><?php _e('About Chameleon', 'chameleon'); ?></a>
            </li>
            <?php if(!$wpc_pro): ?>
        	<li>
            	<a href="<?php echo $wpc_premium_link; ?>" target="_blank"><?php _e('Get Premium Styles', 'chameleon'); ?></a>
            </li>
            <?php endif; ?>

        </ul> 
        
    
	</form>
    <p class="description"><?php echo $wpc_data['Description']; ?></p>

</div>
<script type="text/javascript" language="javascript">
	jQuery(document).ready(function($){
		<?php if(isset($_GET['s']) && $_GET['s']!=''): ?>
		if($('.wpc_supported').length>0){
			var wp_intv = setInterval(function(){
				$('.wpc_supported a[data-key="<?php echo $_GET['s']; ?>"]').click();
				clearInterval(wp_intv);
			}, 1000);
		}
		<?php endif; ?>
	});
</script>
<style type="text/css">
	#wpcontent {
		background-color: maroon;
	}
	.wp-submenu.wp-submenu-wrap li.current{
		background-color: maroon;
	}
	.wp-submenu.wp-submenu-wrap li.current a.current{
		color:#fff;
	}
	#footer-thankyou{
		display:none;
	}
</style>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
	global $rfw_pro, $rfw_data, $rfw_chameleon_installed, $rfw_chameleon_activated;

	$rfw_rss_image_size = get_option('rfw_rss_image_size', 'thumbnail');	
	$rfw_mutes = get_option('rfw_mutes', '');
	$rfw_sc_ids = get_option('rfw_sc_ids', '');
	
	
?>	
<style type="text/css">
.form-table.noborder td, .form-table.noborder th{ border:none;}
.notice-warning, .update-nag{ display:none; }
.rfw-esettings{
	
}
.rfw-esettings > .ecolumns{
	width:50%;
	float:left;
	
}
.rfw-esettings > .ecolumns th{
	text-align:center;
}
.rfw-esettings > .ecolumns th h5{
	text-align:left;
	margin:0 0 10px 0;
	font-size:14px;
}
.rfw-esettings > .ecolumns th pre {
	
	margin: 0;
	background-color: rgba(255,255,0,0.4);
	padding: 6px 20px;
	border-radius: 12px;
	white-space: pre-wrap;
}
</style>
<div class="wrap rfw-esettings">
<h2><?php echo $rfw_data['Name'].' ('.$rfw_data['Version'].($rfw_pro?') Pro':')').''; ?> - <?php _e('Settings'); ?></h2><br/>



<div class="ecolumns">

<table>
	<tr>
    	<td valign="top">          
        
        <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th><h5><?php _e('Instructions'); ?></h5></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    	<ol>
                        	<li><?php _e('Select image size which you want to use in your rss feeds.'); ?></li>
                            
                            <li><?php _e('Save Changes'); ?></li>

							<li><?php _e("That's it."); ?></li>
                            
                            <li>If you still have any query visit my <a href="<?php echo $rfw_data['PluginURI']; ?>" target="_blank">website</a> and contact me.</li>
                            
                        </ol>
                        
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            
            <br/>
        
        </td>
    </tr>
</table>



<table width="100%">
	<tr>
    	<td valign="top">          
        
        <table class="wp-list-table widefat fixed styles">
            	<thead>
                <tr>
                	<th><h5><?php _e('Styles'); ?></h5></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    
                    <?php 
						if($rfw_chameleon_installed){
							if($rfw_chameleon_activated){
								
								global $wpc_assets_loaded, $wpc_dir, $wpc_url;
								$styles = array();
								
								
						
					?>								
                    	<form method="post" action="">
                        <?php wp_nonce_field( 'rfw_styles_act', 'rfw_styles' ); ?>
                        
                        <?php
						if(!empty($wpc_assets_loaded) && array_key_exists('rfw', $wpc_assets_loaded) && !empty($wpc_assets_loaded['rfw'])){
							$rfw_style = get_option('rfw_style');
						?>
                        <input type="hidden" name="rfw_style" value="<?php echo $rfw_style; ?>" />
                        <ul>
                        <?php
							foreach($wpc_assets_loaded['rfw'] as $name=>$data){
						?>
                        	<li <?php echo ($rfw_style==$name?'class="selected"':''); ?> title="<?php echo $name; ?>" data-id="<?php echo $name; ?>"><img src="<?php echo str_replace($wpc_dir, $wpc_url, $data['images']['screenshot']); ?>" alt="<?php echo $name; ?>" /><span><?php echo ucwords($name); ?></span></li>
								
						<?php
                            }
						?>
                        </ul>
                        <div style="float:left; width:100%;">
                        <input type="submit" value="Apply Style" class="button-primary" />
                        </div>
                        
                        <?php
						}else{
						?>
                        <?php _e('No styles found.'); ?>
						<?php							
						}
						?>
                    	
                        	
                            
                        </form>
					<?php
							}else{
					?>
                    		Wow, you have installed <a href="https://downloads.wordpress.org/plugin/chameleon.zip" target="_blank">Chameleon</a> already. <a href="plugins.php?s=chameleon&plugin_status=inactive" target="_blank">Click here</a> to activate styles for <?php echo $rfw_data['Name']; ?>.
                    <?php								
							}
						}else{
					?>
                    		Good news, now you can install <a href="https://downloads.wordpress.org/plugin/chameleon.zip" target="_blank">Chameleon</a> to get awesome styles for for <?php echo $rfw_data['Name']; ?>.
                    <?php								
						}
					?>						
                   
                        
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            
            <br/>
        
        </td>
    </tr>
</table>



<table width="100%">
	<tr>
    	<td valign="top">          
        
        <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th><h5><?php _e('Filter RSS Feeds'); ?></h5></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    <form method="post" action="">
                    	<?php wp_nonce_field( 'rfw_mutes_action', 'rfw_mutes_field' ); ?>
                    	<textarea name="rfw_mutes" style="width:100%; height:200px"><?php echo $rfw_mutes; ?></textarea>
                        <br />
						<p><?php _e('Enter text/words/sentences which you want to filter or mute. One per line.'); ?></p>
                    
					

                        <input type="submit" name="submit-bpu" class="button-primary" value="<?php _e('Save Changes') ?>" />
                    </form>
                        
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            
            <br/>
        
        </td>
    </tr>
</table>


<table width="100%">
	<tr>
    	<td valign="top">          
<table class="wp-list-table widefat fixed bookmarks">
    <thead>
        <tr>
            <th><h5><?php _e('Select Image Size For Rss Feed'); ?></h5></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td>
			<form method="post" action="options.php">
			<?php settings_fields( 'rfw_settings_group' ); ?>
            <table class="form-table noborder">
                <tr valign="top">
                    <th scope="row"><?php _e('Image Size'); ?></th>
                    <td>
                        
                        <?php $image_sizes = get_intermediate_image_sizes(); ?>
                        <select name="rfw_rss_image_size">
                          <?php foreach ($image_sizes as $size_name => $size_attrs): //var_dump($size_attrs);?>
                            <option value="<?php echo $size_attrs ?>" <?php echo $rfw_rss_image_size == $size_attrs?'selected="selected"':''; ?>><?php echo ucwords(str_replace(array('-','_'),' ',$size_attrs)); ?></option>                    
                          <?php endforeach; ?>
                          <option value="full" <?php echo $rfw_rss_image_size == 'full'?'selected="selected"':''; ?>><?php _e('Full Size'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">&nbsp;</th>
                    <td bordercolor="red">
                        <input type="submit" name="submit-bpu" class="button-primary" value="<?php _e('Save Changes') ?>" />
                    </td>
                </tr>
               
            </table><br />
<br />

            <p><?php echo $rfw_data['Description']; ?></p>
        </form><br />

            
</td>

</tr>
</tbody>
</table>
</td>
    </tr>
</table>

</div>

<div class="ecolumns">

<table width="100%">
	<tr>
    	<td valign="top">          
        
        <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th><h5><?php _e('Create Shortcode Based Page'); ?></h5> <pre>[rfw-youtube-videos height=&quot;300px&quot; width=&quot;32%&quot; bgcolor=&quot;black&quot; fullscreen=&quot;false&quot; margin=&quot;1px 1px 1px 1px&quot;]</pre></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    <form method="post" action="">
                    	<?php wp_nonce_field( 'rfw_sc_action', 'rfw_sc_field' ); ?>
                    	<textarea name="rfw_sc_ids" style="width:100%; height:200px"><?php echo $rfw_sc_ids; ?></textarea>
                        <br />
						<p><?php _e('Enter Youtube Video/Channel URL or ID'); ?>. <?php _e('One per line'); ?>.</p>
                    
					

                        <input type="submit" name="submit-bpu" class="button-primary" value="<?php _e('Save Changes') ?>" />
                    </form>
                        
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            
            <br/>
        
        </td>
    </tr>
</table>
</div>

</div>        
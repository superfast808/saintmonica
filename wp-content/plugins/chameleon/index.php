<?php defined( 'ABSPATH' ) or die( __('No script kiddies please!', 'chameleon') );
/*
Plugin Name: Chameleon
Plugin URI: http://androidbubble.com/blog/wordpress/plugins/chameleon
Description: Chameleon is a great WordPress plugin which helps you to choose a unique theme for your favorite plugins and themes.
Version: 1.2.6
Author: Fahad Mahmood 
Author URI: https://profiles.wordpress.org/fahadmahmood/#content-plugins
Text Domain: chameleon
Domain Path: /languages/
License: GPL2

This WordPress Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
This free software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this software. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/ 


        
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        

	global $wpc_premium_link, $wpc_dir, $wpc_url, $wpc_pro, $wpc_data, $wpc_counter;
	global $wpc_supported, $wpc_assets, $wpc_assets_loaded, $wpc_plugins_activated, $wpc_all_plugins;
	$wpc_counter = 0;
	$wpc_all_plugins = get_plugins();
	$wpc_plugins_activated = apply_filters( 'active_plugins', get_option( 'active_plugins' ));
	
	
	//print_r($wpc_all_plugins);
	//print_r($wpc_plugins_activated);
	$wpc_dir = plugin_dir_path( __FILE__ );
	$wpc_url = plugin_dir_url( __FILE__ ); 
	$rendered = FALSE;
	$wpc_data = get_plugin_data(__FILE__);
	$wpc_premium_link = 'http://shop.androidbubbles.com/product/chameleon-pro';
	$wpc_assets = $wpc_dir.'assets/';
	$wp_themes = wp_get_themes();
	$wp_theme = wp_get_theme();
	$wp_theme_series = array('twentyseventeen', 'twentysixteen', 'twentyfifteen', 'twentyfourteen', 'twentythirteen', 'twentytwelve', 'twentyeleven', 'twentyten');
	//pree($wp_theme->template);
	//pree(wp_get_themes());
	//pree($wp_themes);

	$wpc_supported = $wpc_assets_loaded = array();
	
	foreach($wp_theme_series as $theme){
		$icon_exists = $dir = plugin_dir_path( __FILE__ ).'images/'.$theme.'.png';		
		if(file_exists($icon_exists)){
			$wpc_supported[$theme] = array('name'=>ucwords(str_replace(array('_'), ' ', str_replace('twenty', 'twenty_', $theme))), 'slug'=>$theme, 'icon'=> $theme.'.png', 'installed'=>array_key_exists($theme, $wp_themes), 'activated'=>($wp_theme->template==$theme), 'active'=>true, 'activate'=>'themes.php', 'install'=>'theme-install.php?search=', 'action_txt'=>'Apply Style', 'link'=>'', 'items'=>false, 'last_node'=>true);
		}
	}	
	
	$wpc_supported['cf7'] = array('name'=>'Contact Form 7', 'slug'=>'contact-form-7', 'icon'=> 'cf7.png', 'installed'=>array_key_exists('contact-form-7/wp-contact-form-7.php', $wpc_all_plugins), 'activated'=>in_array('contact-form-7/wp-contact-form-7.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Create Form', 'link'=>'admin.php?page=wpcf7-new', 'items'=>true, 'last_node'=>false);
	
	$wpc_supported['gf'] = array('name'=>'Gravity Forms', 'slug'=>'gravity-forms', 'icon'=> 'gravityforms.png', 'installed'=>array_key_exists('gravityforms/gravityforms.php', $wpc_all_plugins), 'activated'=>in_array('gravityforms/gravityforms.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Create Form', 'link'=>'admin.php?page=gf_new_form', 'items'=>true, 'last_node'=>false);
	
	$wpc_supported['bp'] = array('name'=>'BuddyPress', 'slug'=>'buddypress', 'icon'=> 'buddypress.png', 'installed'=>array_key_exists('buddypress/bp-loader.php', $wpc_all_plugins), 'activated'=>in_array('buddypress/bp-loader.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Apply Theme', 'link'=>'', 'items'=>false, 'last_node'=>true);
	
	$wpc_supported['acf'] = array('name'=>'Advanced Custom Fields', 'slug'=>'advanced-custom-fields', 'icon'=> 'acf.png', 'installed'=>array_key_exists('advanced-custom-fields/acf.php', $wpc_all_plugins), 'activated'=>in_array('advanced-custom-fields/acf.php', $wpc_plugins_activated), 'active'=>false, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Create Form', 'link'=>'', 'items'=>true, 'last_node'=>false);
	
	$wpc_supported['wc'] = array('name'=>'WooCommerce', 'slug'=>'woocommerce', 'icon'=> 'woocommerce.png', 'installed'=>array_key_exists('woocommerce/woocommerce.php', $wpc_all_plugins), 'activated'=>in_array('woocommerce/woocommerce.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Select Style', 'link'=>'', 'items'=>false, 'last_node'=>true);
	
	$wpc_supported['rfw'] = array('name'=>'RSS Feed Widget', 'slug'=>'rss-feed-widget', 'icon'=> 'rfw.png', 'installed'=>array_key_exists('rss-feed-widget/index.php', $wpc_all_plugins), 'activated'=>in_array('rss-feed-widget/index.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Settings Page', 'link'=>'options-general.php?page=rfw_options', 'items'=>false, 'last_node'=>false);
	
	$wpc_supported['whi'] = array('name'=>'WP Header Images', 'slug'=>'wp-header-images', 'icon'=> 'whi.png', 'installed'=>array_key_exists('wp-header-images/index.php', $wpc_all_plugins), 'activated'=>in_array('wp-header-images/index.php', $wpc_plugins_activated), 'active'=>false, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Settings Page', 'link'=>'', 'items'=>true, 'last_node'=>false);
	
	$wpc_supported['ap'] = array('name'=>'Alphabetic Pagination', 'slug'=>'alphabetic-pagination', 'icon'=> 'ap.png', 'installed'=>array_key_exists('alphabetic-pagination/index.php', $wpc_all_plugins), 'activated'=>in_array('alphabetic-pagination/index.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Apply Style', 'link'=>'', 'items'=>false, 'last_node'=>true);
		
	$wpc_supported['apt'] = array('name'=>'Alphabetic Pagination Templates', 'slug'=>'alphabetic-pagination', 'icon'=> 'ap.png', 'installed'=>array_key_exists('alphabetic-pagination/index.php', $wpc_all_plugins), 'activated'=>in_array('alphabetic-pagination/index.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Apply Style', 'link'=>'', 'items'=>false, 'last_node'=>true, 'class'=>'hide', 'github'=>'alphabetic-pagination-templates');
		
	$wpc_supported['htk'] = array('name'=>'How to\'s kit', 'slug'=>'htk', 'icon'=> 'htk.png', 'installed'=>array_key_exists('alphabetic-pagination/index.php', $wpc_all_plugins), 'activated'=>in_array('alphabetic-pagination/index.php', $wpc_plugins_activated), 'active'=>true, 'activate'=>'plugins.php?plugin_status=inactive&s=', 'install'=>'plugin-install.php?tab=search&s=', 'action_txt'=>'Apply Style', 'link'=>'', 'items'=>false, 'last_node'=>true);
	
	
	//print_r($wpc_all_plugins);
	//print_r($wpc_plugins_activated);
	
	//exit;
	
	$wpc_data = get_plugin_data(__FILE__);
	
	$wpc_premium_scripts = $wpc_dir.'pro/wpc-premium.php';

	$wpc_pro = file_exists($wpc_premium_scripts);

	if($wpc_pro){
		
		
		include($wpc_premium_scripts);

	}


	
	include('inc/functions.php');
	//pree($wpc_all_plugins); exit;
	//pree($wpc_plugins_activated);exit;
 	add_action('init', 'chameleon_loading_assets');

	add_action( 'admin_enqueue_scripts', 'register_wpc_scripts' );
	add_action( 'wp_enqueue_scripts', 'register_wpc_scripts' );
	

		
		
	if(is_admin()){
		add_action( 'admin_menu', 'chameleon_menu' );		
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'chameleon_plugin_links' );	
		add_action('admin_init', 'wpc_third_party_support');
		
	}else{
		//add_action( 'wp_head', 'wp_chameleon' );
		add_action( 'wp_footer', 'wp_chameleon', 99 );
		//add_action('apply_chameleon', 'get_chameleon');		
		//add_shortcode('CHAMELEON', 'get_chameleon');		
	}


	
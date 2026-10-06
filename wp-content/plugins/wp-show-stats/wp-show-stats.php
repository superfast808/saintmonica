<?php
/*
  Plugin Name: WP Show Stats
  Plugin URI: http://wordpress.org/extend/plugins/wp-show-stats/
  Description: Very useful plugin to see stats related to Pages, Posts, Comments, Categories, Users, Custom post types at one place.
  Author: Ashish Ajani
  Version: 1.4.2
  Author URI: http://freelancer-coder.com/
  License: GPLv2 or later
 */

// Security: Considered blocking direct access to PHP files by adding the following line.
defined('ABSPATH') or die("No script kiddies please!");

// including required files
include_once('includes/wp-show-stats-pages.php');
include_once('includes/wp-show-stats-posts.php');
include_once('includes/wp-show-stats-custom-posts.php');
include_once('includes/wp-show-stats-comments.php');
include_once('includes/wp-show-stats-categories.php');
include_once('includes/wp-show-stats-tags.php');
include_once('includes/wp-show-stats-users.php');
include_once('includes/wp-show-stats-intro.php');
include_once('includes/wp-show-stats-settings.php');

// add menu items and actions for church donation plugin
function show_stats_add_menu_items() {
    add_menu_page('WP Show Stats', 'WP Show Stats', 'wp_show_stats_visibility', 'wp_show_stats', 'wp_show_stats_home_page','dashicons-chart-pie');
    add_submenu_page('wp_show_stats', 'Categories Stats', 'Categories Stats', 'wp_show_stats_visibility', 'wp_show_stats_categories', 'wp_show_stats_categories');
    add_submenu_page('wp_show_stats', 'Posts Stats', 'Posts Stats', 'wp_show_stats_visibility', 'wp_show_stats_posts', 'wp_show_stats_posts');
    add_submenu_page('wp_show_stats', 'Comments Stats', 'Comments Stats', 'wp_show_stats_visibility', 'wp_show_stats_comments', 'wp_show_stats_comments');
    add_submenu_page('wp_show_stats', 'Users Stats', 'Users Stats', 'wp_show_stats_visibility', 'wp_show_stats_users', 'wp_show_stats_users');
    add_submenu_page('wp_show_stats', 'Tags Stats', 'Tags Stats', 'wp_show_stats_visibility', 'wp_show_stats_tags', 'wp_show_stats_tags');
    add_submenu_page('wp_show_stats', 'Custom Post Types Stats', 'Custom Post Types Stats', 'wp_show_stats_visibility', 'wp_show_stats_custom_post_types', 'wp_show_stats_custom_post_types');
	  add_submenu_page('wp_show_stats', 'Page Stats', 'Page Stats', 'wp_show_stats_visibility', 'wp_show_stats_pages', 'wp_show_stats_pages');
	  add_submenu_page('wp_show_stats', 'Settings', 'Settings', 'wp_show_stats_visibility', 'wp_show_stats_settings', 'wp_show_stats_settings');
}
add_action('admin_menu', 'show_stats_add_menu_items');

// load CSS for admin area interfaces
function load_wp_show_stats_admin_css() {
    wp_enqueue_style('wp-show-stats-admin-css', plugins_url( 'css/wp-show-stats-admin.css', __FILE__ ) );
}
add_action('admin_print_styles', 'load_wp_show_stats_admin_css');

// load JS for admin area interfaces
function load_wp_show_stats_admin_js() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jsapi', 'https://www.google.com/jsapi', 1 );
}
add_action('admin_print_scripts', 'load_wp_show_stats_admin_js');

function add_wpshowstats_caps() {
    $user = wp_get_current_user();
    if($user->ID != 0 ){
      $wp_show_stats_settings = unserialize(get_option('wp_show_stats_settings'));
      $wp_show_stats_roles_can_see = ( array ) $wp_show_stats_settings['roles_can_see'];
      $wp_show_stats_visibility = array_merge(array('administrator'), $wp_show_stats_roles_can_see );
      $role = ( array ) $user->roles;
      $role_details = get_role($role[0]);
      if(in_array($role[0] , $wp_show_stats_visibility)){
        $role_details->add_cap('wp_show_stats_visibility', true);
      } else {
        $role_details->remove_cap('wp_show_stats_visibility');
      }
    }

}
add_action( 'init', 'add_wpshowstats_caps');

/**
 * Enqueue the date picker
 */
 function wpss_enqueue_date_picker($hook){
   if($hook != 'wp-show-stats_page_wp_show_stats_users'){
     return true;
   }

   wp_enqueue_script(
     'field-date-js',
     'Field_Date.js',
     array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),
     time(),
     true
   );
   wp_register_style( 'wpss-jquery-ui', plugins_url('/css/jquery-ui.min.css', __FILE__));
   wp_enqueue_style( 'wpss-jquery-ui' );

 }
 add_action( 'admin_enqueue_scripts', 'wpss_enqueue_date_picker' );

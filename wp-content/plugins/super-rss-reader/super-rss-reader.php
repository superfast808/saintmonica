<?php
/*
 * Plugin Name: Super RSS Reader
 * Plugin URI: https://www.aakashweb.com/wordpress-plugins/super-rss-reader/
 * Author URI: https://www.aakashweb.com/
 * Description: Super RSS Reader is jQuery based RSS reader widget, which displays the RSS feeds in the widget in an attractive way. It uses the jQuery easy ticker plugin to add a news ticker like effect to the RSS feeds. Multiple RSS feeds can be added for a single widget and they get separated in tabs. <a href="https://www.youtube.com/watch?v=02aOG_-98Tg" target="_blank" title="Super RSS Reader demo video">Check out the demo video</a>.
 * Author: Aakash Chakravarthy
 * Version: 2.7
 */

define('SRR_VERSION', '2.7');
define('SRR_URL', plugin_dir_url( __FILE__ ));

// Include the required scripts & styles
function srr_public_scripts(){
    wp_enqueue_script('jquery-easy-ticker-js', 'https://cdn.rawgit.com/vaakash/jquery-easy-ticker/92e6e76c/jquery.easy-ticker.min.js', array( 'jquery', 'super-rss-reader-js' ));
    wp_enqueue_script('super-rss-reader-js', SRR_URL . 'public/js/script.min.js', array( 'jquery' ));
    wp_enqueue_style('super-rss-reader-css', SRR_URL . 'public/css/style.min.css');
}
add_action('wp_enqueue_scripts', 'srr_public_scripts');

// Default color styles
function srr_color_styles(){
    return array(
        'No style' => 'none',
        'Grey' => 'grey',
        'Dark' => 'dark',
        'Orange' => 'orange',
        'Simple modern' => 'smodern'
    );
}

function srr_defaults(){
    return array(
        'title' => '',
        'urls' => '',
        'tab_titles' => '',
        'count' => 5,
        'show_date' => 0,
        'show_desc' => 1,
        'show_author' => 0,
        'show_thumb' => 1,
        'open_newtab' => 1,
        'strip_desc' => 100,
        'add_nofollow' => 1,
        'read_more' => '[...]',
        'rich_desc' => 0 ,
        'color_style' => 'none',
        'enable_ticker' => 1,
        'visible_items' => 5,
        'strip_title' => 0,
        'ticker_speed' => 4,
    );
}

// The main RSS Parser
function srr_rss_parser($instance){
    
    $instance = wp_parse_args($instance, srr_defaults());
    
    $urls = stripslashes($instance['urls']);
    $tab_titles = stripslashes($instance['tab_titles']);
    $count = intval($instance['count']);
    
    $show_date = intval($instance['show_date']);
    $show_desc = intval($instance['show_desc']);
    $show_author = intval($instance['show_author']);
    $show_thumb = stripslashes($instance['show_thumb']);
    $open_newtab = intval($instance['open_newtab']);
    $add_nofollow = intval($instance['add_nofollow']);
    $strip_desc = intval($instance['strip_desc']);
    $strip_title = intval($instance['strip_title']);
    $read_more = htmlspecialchars($instance['read_more']);
    $rich_desc = intval($instance['rich_desc']);
    
    $color_style = stripslashes($instance['color_style']);
    $enable_ticker = intval($instance['enable_ticker']);
    $visible_items = intval($instance['visible_items']);
    $ticker_speed = intval($instance['ticker_speed']) * 1000;
    
    if(empty($urls)){
        return '';
    }
    
    $rand = array();
    $url = explode(',', $urls);
    $tab_title = explode(',', $tab_titles);
    $ucount = count($url);
    
    // Generate the Tabs
    if($ucount > 1){
        echo '<ul class="srr-tab-wrap srr-tab-style-' . $color_style . ' srr-clearfix">';
        for( $i=0; $i < $ucount; $i++ ){
            // Get the Feed URL
            $feedUrl = trim( $url[$i] );
            $rss = fetch_feed( $feedUrl );
            $rand[$i] = rand(0, 999);
            
            if (!is_wp_error($rss)){
                
                if( isset( $tab_title[$i] ) && !empty( $tab_title[$i]) ){
                    $rss_title = $tab_title[$i];
                }else{
                    $rss_title = esc_attr(strip_tags($rss->get_title()));
                }
                
                echo '<li data-tab="srr-tab-' . $rand[$i] . '">' . $rss_title . '</li>';
            }else{
                echo '<li data-tab="srr-tab-' . $rand[$i] . '">Error</li>';
            }
            
        }
        echo '</ul>';
    }
    
    for($i=0; $i<$ucount; $i++){
        // Get the Feed URL
        $feedUrl = trim($url[$i]);
        if(isset($url[$i])){
            $rss = fetch_feed($feedUrl);
        }else{
            return '';
        }
        
        if( method_exists( $rss, 'enable_order_by_date' ) ){
            $rss->enable_order_by_date(false);
        }
        
        // Check for feed errors
        if (!is_wp_error( $rss ) ){
            $maxitems = $rss->get_item_quantity($count);
            $rss_items = $rss->get_items(0, $maxitems); 
            $rss_title = esc_attr(strip_tags($rss->get_title()));
            $rss_desc = esc_attr(strip_tags($rss->get_description()));
        }else{
            echo '<div class="srr-wrap srr-style-' . $color_style .'" data-id="srr-tab-' . $rand[$i] . '"><p>RSS Error: ' . $rss->get_error_message() . '</p></div>';
            continue;
        }
        
        $randAttr = isset($rand[$i]) ? ' data-id="srr-tab-' . $rand[$i] . '" ' : '';
        
        // Outer Wrap start
        echo '<div class="srr-wrap ' . (($enable_ticker == 1 ) ? 'srr-vticker' : '' ) . ' srr-style-' . $color_style . '" data-visible="' . $visible_items . '" data-speed="' . $ticker_speed . '"' . $randAttr . '><div>';
        
        // Check feed items
        if ($maxitems == 0){
            echo '<div>No items.</div>';
        }else{
            $j=1;
            // Loop through each feed item
            foreach ($rss_items as $item){
                // Get the link
                $link = $item->get_link();
                while ( stristr($link, 'http') != $link ){ $link = substr($link, 1); }
                $link = esc_url(strip_tags($link));
                
                // Get the item title
                $title = esc_attr(strip_tags($item->get_title()));
                if ( empty($title) )
                    $title = __('No Title');
                
                if( $strip_title != 0 ){
                    $titleLen = strlen($title);
                    $title = wp_html_excerpt( $title, $strip_title );
                    $title = ($titleLen > $strip_title) ? $title . ' ...' : $title;
                }
                
                // Open links in new tab
                $newtab = ($open_newtab) ? ' target="_blank"' : '';
                
                // Add no follow attribute
                $nofollow = ($add_nofollow) ? ' rel="nofollow"' : '';
                
                // Get the date
                $date = $item->get_date('j F Y');
                
                // Get thumbnail if present @since v2.2
                $thumb = '';
                if ($show_thumb == 1 && $enclosure = $item->get_enclosure()){
                    $thumburl = $enclosure->get_thumbnail();
                    if(!empty($thumburl))
                    $thumb = '<img src="' . $thumburl . '" alt="' . $title . '" class="srr-thumb" align="left"/>';
                }
                
                // Get the description
                $desc = '';
                if( $rich_desc == 1 ){
                    $desc = strip_tags( str_replace( 'eval', '', $item->get_description() ) , '<p><a><img><em><strong><font><strike><s><u><i>');

                }else{
                    $rmore = '';
                    $desc = str_replace( array("\n", "\r"), ' ', esc_attr( strip_tags( @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option('blog_charset') ) ) ) );
                    if($strip_desc != 0){
                        $desc = wp_html_excerpt( $desc, $strip_desc );
                        $rmore = (!empty($read_more)) ?  '<a href="' . $link . '" title="Read more"' . $newtab . $nofollow . '>' . $read_more . '</a>' : '';
                        
                        if ( '[...]' == substr( $desc, -5 ) )
                            $desc = substr( $desc, 0, -5 );
                        elseif ( '[&hellip;]' != substr( $desc, -10 ) )
                            $desc .= '';
                            
                        $desc = esc_html( $desc );
                    }
                    
                    $desc = $thumb . $desc . ' ' . $rmore;
                    
                }
                
                // Get the author
                $author = $item->get_author();
                if ( is_object($author) ) {
                    $author = $author->get_name();
                    $author = esc_html(strip_tags($author));
                }
        
                echo "\n\n\t";
                
                // Display the feed items
                echo '<div class="srr-item ' . (($j%2 == 0) ? 'even' : 'odd') . '">';
                echo '<div class="srr-title"><a href="' . $link . '"' . $newtab . $nofollow . ' title="Posted on ' . $date . '">' . $title . '</a></div>';
                echo '<div class="srr-meta">';
                
                if($show_date && !empty($date))
                    echo '<time class="srr-date">' . $date . '</time>';
                    
                if($show_author && !empty($author))
                    echo ' - <cite class="srr-author">' . $author . '</cite>';
                
                echo '</div>';
                
                if($show_desc)
                    echo '<p class="srr-summary srr-clearfix">' . $desc . '</p>';
                    
                echo '</div>';
                // End display
                
                $j++;
            }
        }
        
        // Outer wrap end
        echo "\n\n</div>
        </div> \n\n" ;
        
        if ( ! is_wp_error($rss) )
            $rss->__destruct();
        
        unset($rss);
        
    }
}

class super_rss_reader_widget extends WP_Widget{
    // Initialize
    public function __construct(){
        $widget_ops = array(
            'classname' => 'widget_super_rss_reader',
            'description' => 'Enhanced RSS feed reader widget with advanced features.'
        );
        
        $control_ops = array('width' => 500, 'height' => 500);
        parent::__construct('super_rss_reader', 'Super RSS Reader', $widget_ops, $control_ops);
    }
    
    // Display the Widget
    public function widget($args, $instance){
        extract($args);
        if(empty($instance['title'])){
            $title = '';
        }else{
            $title = $before_title . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $after_title;
        }
        
        echo $before_widget . $title;
        echo "\n" . '
        <!-- Start - Super RSS Reader v' . SRR_VERSION . '-->
        <div class="super-rss-reader-widget">' . "\n";
        
        srr_rss_parser($instance);
        
        echo "\n" . '</div>
        <!-- End - Super RSS Reader -->
        ' . "\n";
        echo $after_widget;
    }
    
    // Save settings
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = stripslashes($new_instance['title']);
        $instance['urls'] = stripslashes($new_instance['urls']);
        $instance['tab_titles'] = stripslashes($new_instance['tab_titles']);
        
        $instance['count'] = intval($new_instance['count']);
        $instance['show_date'] = intval($new_instance['show_date']);
        $instance['show_desc'] = intval($new_instance['show_desc']);
        $instance['show_author'] = intval($new_instance['show_author']);
        $instance['show_thumb'] = stripslashes($new_instance['show_thumb']);
        $instance['open_newtab'] = intval($new_instance['open_newtab']);
        $instance['add_nofollow'] = intval($new_instance['add_nofollow']);
        $instance['strip_desc'] = intval($new_instance['strip_desc']);
        $instance['strip_title'] = intval($new_instance['strip_title']);
        $instance['read_more'] = stripslashes($new_instance['read_more']);
        $instance['rich_desc'] = stripslashes($new_instance['rich_desc']);
        
        $instance['color_style'] = stripslashes($new_instance['color_style']);
        $instance['enable_ticker'] = intval($new_instance['enable_ticker']);
        $instance['visible_items'] = intval($new_instance['visible_items']);
        $instance['ticker_speed'] = intval($new_instance['ticker_speed']);
        
        return $instance;
    }
    
    // HJA Widget form
    public function form($instance){
        
        $instance = wp_parse_args((array) $instance, srr_defaults());
        
        $title = htmlspecialchars($instance['title']);
        $urls = htmlspecialchars($instance['urls']);
        $tab_titles = htmlspecialchars($instance['tab_titles']);
        
        $count = intval($instance['count']);
        $show_date = intval($instance['show_date']);
        $show_desc = intval($instance['show_desc']);
        $show_author = intval($instance['show_author']);
        $show_thumb = intval($instance['show_thumb']);
        $open_newtab = intval($instance['open_newtab']);
        $add_nofollow = intval($instance['add_nofollow']);
        $strip_desc = intval($instance['strip_desc']);
        $strip_title = intval($instance['strip_title']);
        $read_more = htmlspecialchars($instance['read_more']);
        $rich_desc = htmlspecialchars($instance['rich_desc']);
        
        $color_style = stripslashes($instance['color_style']);
        $enable_ticker = intval($instance['enable_ticker']);
        $visible_items = intval($instance['visible_items']);
        $ticker_speed = intval($instance['ticker_speed']);
        
        ?>
        <div class="srr_settings">
        <table width="100%" height="72" border="0">
        <tr>
          <td width="13%" height="33"><label for="<?php echo $this->get_field_id('title'); ?>">Title: </label></td>
          <td width="87%"><input id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat"/></td>
        </tr>
        <tr>
            <td><label for="<?php echo $this->get_field_id('urls'); ?>">URLs: </label></td>
            <td><input id="<?php echo $this->get_field_id('urls');?>" name="<?php echo $this->get_field_name('urls'); ?>" type="text" value="<?php echo $urls; ?>" class="widefat"/>
            <small class="srr_smalltext">Can enter multiple RSS/atom feed URLs seperated by a comma.</small>
            </td>
        </tr>
        
        <tr>
            <td><label for="<?php echo $this->get_field_id('tab_titles'); ?>">Tab titles: </label></td>
            <td><input id="<?php echo $this->get_field_id('tab_titles');?>" name="<?php echo $this->get_field_name('tab_titles'); ?>" type="text" value="<?php echo $tab_titles; ?>" class="widefat"/>
            <small class="srr_smalltext">Enter corresponding tab titles seperated by a comma.</small>
            </td>
        </tr>
        
        </table>
        </div>
        
        <div class="srr_settings">
        <h4>Settings</h4>
        <table width="100%" border="0">
          <tr>
            <td width="7%" height="28"><input id="<?php echo $this->get_field_id('show_desc'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('show_desc'); ?>" value="1" <?php echo $show_desc == "1" ? 'checked="checked"' : ""; ?> /></td>
            <td width="40%"><label for="<?php echo $this->get_field_id('show_desc'); ?>">Show Description</label></td>
            <td width="28%"><label for="<?php echo $this->get_field_id('count');?>">Total items to show:</label></td>
            <td width="25%"><input id="<?php echo $this->get_field_id('count');?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo $count; ?>" class="widefat" title="No of feed items to parse"/></td>
          </tr>
          <tr>
            <td height="32"><input id="<?php echo $this->get_field_id('show_date'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('show_date'); ?>" value="1" <?php echo $show_date == "1" ? 'checked="checked"' : ""; ?> /></td>
            <td><label for="<?php echo $this->get_field_id('show_date'); ?>">Show Date</label></td>
            <td><label for="<?php echo $this->get_field_id('strip_desc');?>">Strip description characters:</label></td>
            <td><input id="<?php echo $this->get_field_id('strip_desc');?>" name="<?php echo $this->get_field_name('strip_desc'); ?>" type="number" value="<?php echo $strip_desc; ?>" class="widefat" title="The number of charaters to be displayed. Use 0 to disable stripping"/>          </td>
          </tr>
          <tr>
            <td height="29"><input id="<?php echo $this->get_field_id('show_author'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('show_author'); ?>" value="1" <?php echo $show_author == "1" ? 'checked="checked"' : ""; ?> /></td>
            <td><label for="<?php echo $this->get_field_id('show_author'); ?>">Show Author</label></td>
            <td><label for="<?php echo $this->get_field_id('strip_title'); ?>">Strip title characters:</label></td>
            <td><input id="<?php echo $this->get_field_id('strip_title');?>" name="<?php echo $this->get_field_name('strip_title'); ?>" type="number" value="<?php echo $strip_title; ?>" class="widefat" title="The number of charaters to be displayed. Use 0 to disable stripping"/></td>
          </tr>
          <tr>
            <td height="29"><input id="<?php echo $this->get_field_id('open_newtab'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('open_newtab'); ?>" value="1" <?php echo $open_newtab == "1" ? 'checked="checked"' : ""; ?> /></td>
            <td><label for="<?php echo $this->get_field_id('open_newtab'); ?>">Open links in new tab</label></td>
            <td><label for="<?php echo $this->get_field_id('read_more'); ?>">Read more text:</label></td>
            <td><input id="<?php echo $this->get_field_id('read_more'); ?>" name="<?php echo $this->get_field_name('read_more'); ?>" type="text" value="<?php echo $read_more; ?>" class="widefat" title="Leave blank to hide read more text"/></td>
          </tr>
          <tr>
            <td height="29"><input id="<?php echo $this->get_field_id('show_thumb'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('show_thumb'); ?>" value="1" <?php echo $show_thumb == "1" ? 'checked="checked"' : ""; ?> /></td>
            <td><label for="<?php echo $this->get_field_id('show_thumb'); ?>">Show thumbnail if present</label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td height="29"><input id="<?php echo $this->get_field_id('rich_desc'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('rich_desc'); ?>" value="1" <?php echo $rich_desc == "1" ? 'checked="checked"' : ""; ?> /></td>
            <td><label for="<?php echo $this->get_field_id('rich_desc'); ?>">Enable full or rich description</label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td height="29"><input id="<?php echo $this->get_field_id('add_nofollow'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('add_nofollow'); ?>" value="1" <?php echo $add_nofollow == "1" ? 'checked="checked"' : ""; ?> /></td>
            <td><label for="<?php echo $this->get_field_id('add_nofollow'); ?>">Add "no follow" attribute to links</label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
        </table>
        </div>
        
        <?php if( $rich_desc == 1 ): ?>
        <span class="srr_note">Note: You have enabled "Full/Rich HTML" Please make sure that the feed(s) are from trusted sources and do not contain any harmful scripts. If there are some aligment issues in the description, please use custom CSS to fix that. </span>
        <?php endif; ?>
        
        <div class="srr_settings">
        <h4>Other settings</h4>
        <table width="100%" height="109" border="0">
          <tr>
            <td height="32"><label for="<?php echo $this->get_field_id('color_style');?>">Color style: </label></td>
            <td>
            <?php
            $color_styles = srr_color_styles();
            echo '<select name="' . $this->get_field_name('color_style') . '" id="' . $this->get_field_id('color_style') . '">';
            foreach($color_styles as $k => $v){
                echo '<option value="' . $v . '" ' . ($color_style == $v ? 'selected="selected"' : "") .  '>' . $k . '</option>';
            }
            echo '</select>';
            ?>
            </td>
          </tr>
          <tr>
            <td height="36"><label for="<?php echo $this->get_field_id('visible_items');?>">Widget height:</label></td>
            <td><input id="<?php echo $this->get_field_id('visible_items');?>" name="<?php echo $this->get_field_name('visible_items'); ?>" type="number" value="<?php echo $visible_items; ?>" title="Height of the RSS feed."/><br/>
            <small>Set value less than 20 to show visible feed items. Example: <b>5</b> items</small></br>
            <small>Set value greater than 20 for fixed widget height. Example: <b>400</b> px</small></br>
            </td>
          </tr>
          <tr>
            <td height="33"><label for="<?php echo $this->get_field_id('enable_ticker'); ?>">Ticker animation:</label> </td>
            <td><input id="<?php echo $this->get_field_id('enable_ticker'); ?>" type="checkbox"  name="<?php echo $this->get_field_name('enable_ticker'); ?>" value="1" <?php echo $enable_ticker == "1" ? 'checked="checked"' : ""; ?> /></td>
          </tr>
          <tr>
            <td height="36"><label for="<?php echo $this->get_field_id('ticker_speed');?>">Ticker speed: </label></td>
            <td><input id="<?php echo $this->get_field_id('ticker_speed');?>" name="<?php echo $this->get_field_name('ticker_speed'); ?>" type="number" value="<?php echo $ticker_speed; ?>" title="Speed of the ticker in seconds"/> seconds
            </td>
          </tr>
        </table>
        </div>
        
        <div class="srr_coffee">
            <p>Thank you for using Super RSS Reader. If you found it useful, please buy me a coffee !</p>
            <div class="srr_coffee_wrap">
                <p><select class="srr_coffee_amt">
                <option value="2">$2</option>
                <option value="3">$3</option>
                <option value="4">$4</option>
                <option value="5" selected="selected">$5</option>
                <option value="6">$6</option>
                <option value="7">$7</option>
                <option value="8">$8</option>
                <option value="9">$9</option>
                <option value="10">$10</option>
                <option value="11">$11</option>
                <option value="12">$12</option>
                <option value="">Custom</option>
            </select></p>
            <a class="button button-primary srr_coffee_btn" href="https://www.paypal.me/vaakash/5" data-link="https://www.paypal.me/vaakash/" target="_blank">Buy me a coffee !</a>
            </div>
        </div>
        
        <p><a href="http://bit.ly/2PFMtvi" target="_blank">FAQ</a> | <a href="http://bit.ly/2S4fnaD" target="_blank">Report issue</a> | <a href="https://goo.gl/7gCKb8" target="_blank">Rate 5 stars & review</a> | v<?php echo SRR_VERSION; ?></p>
        
        <?php
    }
}

function super_rss_reader_init(){
    register_widget('super_rss_reader_widget');
}
add_action('widgets_init', 'super_rss_reader_init');


function srr_admin_scripts( $hook ){
    if( $hook == 'widgets.php' ){
        wp_enqueue_style( 'srr_admin_css', SRR_URL . 'admin/css/style.css' );
        wp_enqueue_script( 'srr_admin_js', SRR_URL . 'admin/js/script.js' );
    }
}
add_action( 'admin_enqueue_scripts', 'srr_admin_scripts' );

?>
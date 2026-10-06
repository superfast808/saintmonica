=== Super RSS Reader ===
Contributors: vaakash
Author URI: https://www.aakashweb.com/
Plugin URI: https://www.aakashweb.com/wordpress-plugins/super-rss-reader/
Tags: rss, feeds, widget, ticker, feed, twitter, admin, plugin, posts, page, thumbnail, atom, jquery
License: GPLv2 or later
Donate Link: https://www.paypal.me/vaakash
Requires at least: 2.8
Tested up to: 5.0.1
Stable tag: 2.7

An RSS widget plugin to display feeds with news ticker effect in multiple tabbed feeds, thumbnails, customizable color themes and more

== Description ==

Super RSS Reader is jQuery based RSS reader widget, which displays the RSS feeds in the widget in an attractive way. It uses the jQuery easy ticker plugin to add a news ticker like effect to the RSS feeds. Multiple RSS feeds can be added for a single widget and they get seperated in tabs.

The plugin is fully customizable with external styles and with some inbuilt color styles. It acts as a perfect replacement for the default RSS widget in WordPress.

[Check out the **LIVE DEMO** of the plugin](https://www.aakashweb.com/demos/super-rss-reader/)

= Features =

* jQuery [news ticker like effect](https://www.aakashweb.com/jquery-plugins/easy-ticker/) to the RSS feeds (can turn off or on)
* Display feeds in **multiple tabs**
* Display **thumbnail** to the feed items if available.
* Select **color themes** for widget. Customizable via CSS.
* Customizable ticker speed.
* Supports RSS or atom feed.
* Can strip title and description text of the feed item.

[youtube=https://www.youtube.com/watch?v=02aOG_-98Tg]

= Resources =

* [Documentation](https://www.aakashweb.com/wordpress-plugins/super-rss-reader/)
* [FAQs](https://www.aakashweb.com/wordpress-plugins/super-rss-reader/#faq)
* [Support](https://www.aakashweb.com/forum/)
* [Report Bugs](https://www.aakashweb.com/forum/)

== Installation ==

Download and upload the latest version of Super RSS Reader,

1. Unzip & upload it to your WordPress site.
1. Activate the plugin.
1. Drag and drop the "Super RSS Reader" widget in the "Widgets" page.
1. Input a RSS feed URL to the widget, tweak some settings and you are,
1. Done !

== Frequently Asked Questions ==

= RSS feed is not refreshing =

Super RSS Reader uses WordPress's default feed reading module. By default WordPress caches the RSS feed for 12 hours.

You can change this default value by adding the below code to your theme's function.php file.

`add_filter( 'wp_feed_cache_transient_lifetime', create_function('$a', 'return 600;') );`

Here 600 indicates 10 minutes in seconds. Please note that setting lower value will increase the load on the server to refresh the RSS cache.

You can also refer this post https://wordpress.org/support/topic/rss-not-updating-no-matter-which-plugin-i-try/#post-10123881 to change the refresh time for particular feed URL.

= How can I customize the RSS widget via CSS styles ? =

You can use the `super-rss-reader-widget` class in your stylesheet to control the widget styling. Other classes are,

1. `srr-tab-wrap` - the tab's class.
1. `srr-wrap` - the wrapper of the widget.
1. `srr-item.odd` - to control the odd feed items.
1. `srr-item.even` - to control the even feed items.

= Does this plugin support horizontal ticker ? =

No, Super RSS Reader only supports vertical support feature for now.

= How to create a tabbed mode or multiple feeds ? =

Just enter the RSS feed URLs seperated by comma in the widget, the plugin automatically renders the tab.

= What fields are shown in the feed output by default ? =

By default the plugin shows fields like title, author, description, thumbnail. Other fields are not supported for now.

= How big is the ticker library ? =

The size of the ticker library is only 2.74 KB.

== Screenshots ==

1. Example Super RSS Reader widgets shown in the sidebar, having a ticker effect and a tabbed mode.
1. Plugin working in different themes and RSS feeds.
1. Picture showing some possible ways of Customizing the widget.
1. The Super RSS Reader widget in the administration page.

[Live Working demo](https://www.aakashweb.com/demos/super-rss-reader/)

== Changelog ==

= 2.7 =
* New: Support for "no follow" attribute in links.
* Fix: Readme with updated FAQ.

= 2.6 =
* New: Ability to set fixed height for the RSS widget.
* New: Using minified JavaScript on frontend.
* Fix: Cleaned widget UI, reordered options.
* Fix: Code refactoring.

= 2.5 =
* Added feature to change individual tab titles/names.
* Added feature to enable rich or full description.
* Fixed feed ordering issues.
* Updated jQuery easy ticker plugin to v2.0.
* Minor code revisions.

= 2.4 =
* Added feature to cut down/strip feed titles.
* Added a new 'Simple modern' color style.

= 2.3 =
* Fixed imcompatibility of other jQuery plugins due to the usage of the latest version of jQuery.

= 2.2 =
* Displays "thumbnail" of the feed item if available.
* Added setting to change ticker speed.
* Added setting to edit the "Read more" text.
* Default styles are revised.
* Switched to full size ticker code.
* Core code revised.

= 2.1 =
* Added option to open links in new window.
* Changed the method to include the scripts and styles.
* Added a new 'Orange' color style.

= 2.0 =
* Core code is completely rewritten.
* Flash RSS Reader is removed and instead jQuery is used.
* Administration panel used in the previous version is removed and settings are configured in the widget itself.

= 0.8 =
* Second version with included CSS and Proxy file (loadXML.php).

= 0.5 =
* Initial version with a flash RSS Reader

== Upgrade Notice ==

Version 2.0 is a major and recommended upgrade for previous version users.

== Credits ==

* RSS feed reading engine is the inbuilt WordPress's engine
* The news ticker effect is powered by the [jQuery Easy ticker plugin](https://www.aakashweb.com/jquery-plugins/easy-ticker/)
* Default color styles by Aakash Chakravarthy.
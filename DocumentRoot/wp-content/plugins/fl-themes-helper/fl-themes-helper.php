<?php
/**
 * Plugin Name: Fl Themes Helper
 * Plugin URI:: https://fl-theme.com/
 * Description: Helper plugin for ForasLab themes.Don't delete this plugin.
 * Version: 1.0
 * Author: ForasLab
 * Author URI: https://fl-theme.com/
 * License: GPL v2
 */

/**====================================================================
==  Make sure we don't expose any info if called directly
====================================================================*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

/**====================================================================
==  Load Text domain
====================================================================*/
add_action('plugins_loaded', 'fl_helper_load_textdomain');
function fl_helper_load_textdomain() {
    load_plugin_textdomain( 'fl-themes-helper', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

/**====================================================================
==  Require Fl theme
====================================================================*/
/** Social function */
require_once ('function/social-share/social.php');

/** Like */
require_once ('function/like/post-like.php');

/** Load MoreFunction */
require_once ('function/load-more-function/load-more-blog.php');
require_once ('function/load-more-function/load-more-work.php');

/** Custom taxonomies & post_type*/
require_once ('function/custom_function.php');

/** Visual Function */
require_once ('vc.php');

/** Dashboard*/
require_once ('dashboard/dashboard.php');

/** Work*/
require_once('custom_taxonomy/work.php');

/** Widget*/
require_once('widgets/widgets.php');


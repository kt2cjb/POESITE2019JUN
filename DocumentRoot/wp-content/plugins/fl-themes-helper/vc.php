<?php
/**====================================================================
==
==  Theme Shortcodes VC and Option
==
====================================================================*/


/**====================================================================
==  Sanitizes a html classname to ensure it only contains valid characters.
====================================================================*/

if (!function_exists( 'fl_sanitize_class' )) {
    function fl_sanitize_class($classes)
    {
        if (!is_array($classes)) {
            $classes = explode(' ', $classes);
        }

        foreach ($classes as $k => $v) {
            $classes[$k] = sanitize_html_class($v);
        }

        return join(' ', $classes);

        return $classes;
    }
}

/**====================================================================
==  Check if $var isset / true / 1.
====================================================================*/
if (!function_exists( 'fl_check_option' )) {
    function fl_check_option($var)
    {
        return !(!isset($var) || $var === false || $var === 'false' || $var === 0 || $var === "0" || $var === "");
    }
}


/**====================================================================
==  Return additional class from Visual Composer style tab
====================================================================*/

if (!function_exists( 'fl_get_css_tab_class' )) {
    function fl_get_css_tab_class ($atts = array()) {
        $result = ' ';
        if (function_exists('vc_shortcode_custom_css_class') && isset($atts['vc_css'])) {
            $result = ' ' . vc_shortcode_custom_css_class($atts['vc_css']) . ' ';
        }
        return $result;
    }
}

/**====================================================================
==  Shortcode return
====================================================================*/
if (!function_exists(' fl_js_remove_wpautop')) {
    function fl_js_remove_wpautop($content, $autop = false)
    {
        if ($autop) {
            $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content) . "\n");
        }
        return do_shortcode(shortcode_unautop($content));
    }
}

/**====================================================================
==  ICON VC
====================================================================*/
require 'vc_templates/icon/vc_icon.php';


/**====================================================================
==  Include all
==  shortcodes VC
====================================================================*/
/**
 * A
 */
require 'vc_templates/shortcode/vc_fl_accordion_parrent.php';
require 'vc_templates/shortcode/vc_fl_accordion_row.php';
require 'vc_templates/shortcode/vc_fl_alert.php';
/**
 * B
 */
require 'vc_templates/shortcode/vc_fl_button.php';
require 'vc_templates/shortcode/vc_fl_banners.php';
require 'vc_templates/shortcode/vc_fl_blog.php';
require 'vc_templates/shortcode/vc_fl_blog_home_page.php';

/**
 * C
 */
require 'vc_templates/shortcode/vc_fl_counters.php';
require 'vc_templates/shortcode/vc_fl_custom_text_block.php';
/**
 * D
 */
require 'vc_templates/shortcode/vc_fl_drops_caps.php';
/**
 * F
 */
require 'vc_templates/shortcode/vc_fl_functional_text_box.php';
/**
 * G
 */
require 'vc_templates/shortcode/vc_fl_google_map.php';
require 'vc_templates/shortcode/vc_fl_gif.php';
require 'vc_templates/shortcode/vc_fl_gallery.php';
/**
 * I
 */
require 'vc_templates/shortcode/vc_fl_image_single.php';
require 'vc_templates/shortcode/vc_fl_image_slider.php';
require 'vc_templates/shortcode/vc_fl_icon_box.php';
require 'vc_templates/shortcode/vc_fl_icon_single.php';
/**
 * L
 */
require 'vc_templates/shortcode/vc_fl_list_row.php';
require 'vc_templates/shortcode/vc_fl_list_table.php';
/**
 * P
 */
require 'vc_templates/shortcode/vc_fl_partner_block.php';
require 'vc_templates/shortcode/vc_fl_partner_row.php';
require 'vc_templates/shortcode/vc_fl_partner_slider.php';
require 'vc_templates/shortcode/vc_fl_pie.php';
require 'vc_templates/shortcode/vc_fl_pricing_row.php';
require 'vc_templates/shortcode/vc_fl_pricing_table.php';
require 'vc_templates/shortcode/vc_fl_progress_bar.php';
/**
 * S
 */
require 'vc_templates/shortcode/vc_fl_separator.php';
require 'vc_templates/shortcode/vc_fl_share.php';
require 'vc_templates/shortcode/vc_fl_social_link.php';
require 'vc_templates/shortcode/vc_fl_sticky_box.php';

/**
 * T
 */
require 'vc_templates/shortcode/vc_fl_team.php';
require 'vc_templates/shortcode/vc_fl_testimonial_parent.php';
require 'vc_templates/shortcode/vc_fl_testimonial_row.php';
require 'vc_templates/shortcode/vc_fl_time_line_block.php';
require 'vc_templates/shortcode/vc_fl_time_line_block_row.php';
require 'vc_templates/shortcode/vc_fl_time_line_slider.php';
require 'vc_templates/shortcode/vc_fl_time_line_slider_row.php';
require 'vc_templates/shortcode/vc_fl_title.php';
/**
 * V
 */
require 'vc_templates/shortcode/vc_fl_video_box.php';
/**
 * W
 */
require 'vc_templates/shortcode/vc_fl_works.php';
require 'vc_templates/shortcode/vc_fl_work_info_table.php';
require 'vc_templates/shortcode/vc_fl_work_info_row.php';



/**====================================================================
==  End Include shortcodes VC
====================================================================*/

/**====================================================================
==  Shortcode_extend
====================================================================*/

add_action('vc_before_init', 'fl_shortcode_extend');

if(!function_exists('fl_shortcode_extend')){
    function fl_shortcode_extend(){

        vc_add_shortcode_param('fl_number', 'fl_number_settings_field');

        if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
            class WPBakeryShortCode_Vc_Fl_Accordion_Parent      extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Alert                 extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_List_Table            extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Partner_Block         extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Partner_Slider        extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Pricing_Table         extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Sticky_Box            extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Testimonial_Parent    extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Time_Line_Block       extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Time_Line_Slider      extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Work_Info_Table       extends WPBakeryShortCodesContainer {}
        }


        if ( class_exists( 'WPBakeryShortCode' ) ) {
            class WPBakeryShortCode_Vc_Fl_Accordion_Row         extends WPBakeryShortCodesContainer {}

        }
    }
}

/**====================================================================
==  Include
==  New Params VC
====================================================================*/
require 'vc_templates/params/number.php';


/**====================================================================
==  VC Plugin Scripts
====================================================================*/
add_action('wp_enqueue_scripts', 'fl_shortcodes_scripts');
if ( !function_exists( 'fl_shortcodes_scripts' ) ) {
    function fl_shortcodes_scripts() {
        wp_enqueue_script('fl_vc_custom',plugin_dir_url( __FILE__ ).'vc_templates/js/vc_custom.js', false, null , true);
    }
};
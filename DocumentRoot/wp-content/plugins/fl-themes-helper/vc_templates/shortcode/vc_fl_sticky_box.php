<?php

add_shortcode('vc_fl_sticky_box', 'vc_fl_sticky_box_function');

function vc_fl_sticky_box_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'class'                 => '',
        'vc_css'                => '',
    ), $atts));

    $result = '';


    $class .= fl_get_css_tab_class($atts);

    $result .= '<div class="fl_sticky_box sidebar-sticky'. fl_sanitize_class($class) .' ">';

        $result .= '<div class="fl-sticky-container cf">';

            $result .=  do_shortcode($content);

        $result .= '</div>';

    $result .= '</div>';


    return $result;
}
add_action('vc_before_init', 'vc_fl_sticky_box_shortcode');

function vc_fl_sticky_box_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'                      => esc_html__('Sticky Box', 'fl-themes-helper'),
            'base'                      => 'vc_fl_sticky_box',
            'category'                  => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'                      => 'fl-icon icon-fl-share',
            'controls'                  => 'full',
            'weight'                    => 200,
            "is_container"              => true,
            "show_settings_on_create"   => false,
            "js_view"                   => 'VcColumnView',
            'params' => array(
                array(
                    'type'                  => 'textfield',
                    'heading'               => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'            => 'class',
                    'value'                 => '',
                    'description'           => '',
                ),
                array(
                    'type'                  => 'css_editor',
                    'heading'               => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'            => 'vc_css',
                    'group'                 => esc_html__('Design Options', 'fl-themes-helper'),
                )
            ),
        ));
    }
}
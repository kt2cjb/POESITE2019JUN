<?php
/*
 * Shortcode Alert
 * */

add_shortcode('vc_fl_alert', 'vc_fl_alert_function');

function vc_fl_alert_function($atts, $content = null) {

    extract(shortcode_atts(array(
       'icon_style'                 => 'fa fa-exclamation',
       'alert_icon_color'           => '#ffffff',
       'alert_text_color'           => '#ffffff',
       'alert_background_color'     => '#C0392B',
       'button_close'               => 'off',
       'button_close_icon_style'    => 'demo-icon icon-cancel',
       'icon_type_alert'            => 'default',
       'icon_type_close'            => 'none',
       'class'                      => '',
       'vc_css'                     => '',
    ), $atts));


    $result = '';

    $class .= fl_get_css_tab_class($atts);

    switch ($icon_type_alert) {
        case 'flalert':
            $icon_alert = $atts['icon_flalert'];
            break;
    }

    vc_icon_element_fonts_enqueue($icon_type_alert);

    switch ($icon_type_close) {
        case 'flclose':
            $icon_alert_close = $atts['icon_flclose'];
            break;
    }

    vc_icon_element_fonts_enqueue($icon_type_close);


    if ($icon_type_alert == 'flalert') {
        $vc_icon_alert = '<i class="icon-alert  ' . $icon_alert . '" style="color:'.$alert_icon_color.';"></i>';
    } else {
        $vc_icon_alert = '<i class="icon-alert fa fa-info" style="color:'.$alert_icon_color.';"></i>';
    }

    if ($icon_type_close !== 'none') {
        $vc_icon_close = '<i class="fl-alert_close ' . $icon_alert_close . '" style="color:'.$alert_icon_color.';"></i>';
    } else {
        $vc_icon_close = '';
    }

    $result .= '<div class="fl-alert alert-padding'.esc_attr( fl_sanitize_class($class) ).'" style="background:'.esc_attr($alert_background_color).' ;color: '.$alert_text_color.'">';

    $result .= '<span class="fl-alert_icon">';

    $result .= $vc_icon_alert;

    $result .= '</span>';

    $result .= do_shortcode($content);

    $result .= $vc_icon_close;

    $result.= '</div>';

    return $result;
}
add_action('vc_before_init', 'vc_fl_alert_shortcode');

function vc_fl_alert_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'                  => esc_html__('Alert info box', 'fl-themes-helper'),
            'base'                  => 'vc_fl_alert',
            'category'              => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'                  => 'fl-icon icon-fl-alert',
            'controls'              => 'full',
            'weight'                => 1000,
            "is_container"          => true,
            "js_view"               => 'VcColumnView',
            'params'                => array(
                array(
                    'type'          => 'colorpicker',
                    'param_name'    => 'alert_text_color',
                    'heading'       => esc_html__('Alert text Color', 'test'),
                    'value'         => '',
                    'std'           => '#ffffff',
                ),
                array(
                    'type'          => 'colorpicker',
                    'param_name'    => 'alert_icon_color',
                    'heading'       => esc_html__('Alert Icon Color', 'test'),
                    'value'         => '',
                    'std'           => '#ffffff',
                ),
                array(
                    'type'          => 'colorpicker',
                    'param_name'    => 'alert_background_color',
                    'heading'       => esc_html__('Alert Background Color', 'test'),
                    'value'         => '',
                    'std'           => '#C0392B',
                ),

                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Alert icon', 'fl-themes-helper'),
                    "description"   => esc_html__( "Select you icon.", "fl-themes-helper" ),
                    'value'         => array(
                            esc_attr__('Default', 'fl-themes-helper')   => 'default',
                            esc_attr__('Custom', 'fl-themes-helper')    => 'flalert',
                    ),
                    'param_name'    => 'icon_type_alert',
                    'std'           => 'default',
                    'group'         => 'Icon'
                ),

                array(
                    'type'          => 'iconpicker',
                    'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'    => 'icon_flalert',
                    'settings'      => array(
                            'emptyIcon'    => false,
                            'type'         => 'flalert',
                            'iconsPerPage' => 300
                    ),
                    'dependency'    => array(
                            'element'      => 'icon_type_alert',
                            'value'        => 'flalert'
                    ),
                    'group'        => 'Icon'
                ),

                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Alert close icon', 'fl-themes-helper'),
                    "description"   => esc_html__( "Select you icon.", "fl-themes-helper" ),
                    'value'         => array(
                            esc_attr__('None', 'fl-themes-helper')   => 'none',
                            esc_attr__('Custom', 'fl-themes-helper') => 'flclose',
                    ),
                    'param_name'    => 'icon_type_close',
                    'std'           => 'none',
                    'group'         => 'Icon'
                ),

                array(
                    'type'          => 'iconpicker',
                    'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'    => 'icon_flclose',
                    'settings'      => array(
                            'emptyIcon'     => false,
                            'type'          => 'flclose',
                            'iconsPerPage'  => 300
                    ),
                    'dependency'    => array(
                            'element'       => 'icon_type_close',
                            'value'         => 'flclose'
                    ),
                    'group'        => 'Icon'
                ),

                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'    => 'class',
                    'value'         => '',
                    'description'   => '',
                ),

                array(
                    'type'          => 'css_editor',
                    'heading'       => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'    => 'vc_css',
                    'group'         => esc_html__('Design Options', 'fl-themes-helper'),
                )
            ),
        ));
    }
}
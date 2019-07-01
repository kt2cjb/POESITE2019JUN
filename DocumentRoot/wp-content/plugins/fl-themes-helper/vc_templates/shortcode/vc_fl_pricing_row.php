<?php

/*
 * Shortcode Partner Row
 * */

add_shortcode('vc_fl_pricing_row', 'vc_fl_pricing_row_function');

function vc_fl_pricing_row_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'content_row'   => '10 hours of support',
        'class'         => '',
        'vc_css'        => '',
    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    $result = '';

    $result .= '<li class="fl-pricing_feature '.fl_sanitize_class($class).'">';

    $result .= $content_row;

    $result .= '</li>';


    return $result;

}

add_action('vc_before_init', 'vc_fl_pricing_row_shortcode');

function vc_fl_pricing_row_shortcode() {

    vc_map(array(
        'name'          => esc_html__('Pricing Row', 'fl-themes-helper'),
        'base'          => 'vc_fl_pricing_row',
        'icon'          => 'fl-icon icon-fl-partner-row',
        'as_child'      => array(
            'only' => 'vc_fl_pricing_table'
        ),
        'params'        => array(
            array(
                'type'              => 'textarea',
                'heading'           => esc_html__( 'Content', 'fl-themes-helper'),
                'param_name'        => 'content_row',
                'std'               => '10 hours of support'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Custom Classes', 'fl-themes-helper'),
                'param_name'        => 'class',
                'value'             => '',
                'description'       => '',
            ),
            array(
                'type'              => 'css_editor',
                'heading'           => esc_html__( 'CSS', 'fl-themes-helper'),
                'param_name'        => 'vc_css',
                'group'             => esc_html__( 'Design Options', 'fl-themes-helper'),
            )
        ),
    ));


}
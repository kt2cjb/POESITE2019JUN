<?php

/*
 * Shortcode team
 * */

add_shortcode('vc_fl_accordion_parent', 'vc_fl_accordion_parent_function');

function vc_fl_accordion_parent_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'class'     => '',
        'vc_css'    => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

    $return = '';

    $return .= '<div class="fl-accordion-box '.fl_sanitize_class($class).' cf">';

    $return .= '<ul class="fl-accordion-ul cf">';

    $return .= do_shortcode($content);

    $return .= '</ul>';

    $return .= '</div>';

    return $return;
}

add_action('vc_before_init', 'vc_fl_accordion_parent_shortcode');

function vc_fl_accordion_parent_shortcode() {

	vc_map(array(
		'name'                      => esc_html__('Accordion', 'fl-themes-helper'),
		'base'                      => 'vc_fl_accordion_parent',
        'icon'                      => 'fl-icon icon-fl-accordion',
        'as_parent'                 => array(
                'only' => 'vc_fl_accordion_row'
        ),
		'category'                  => esc_html__('Fl Theme', 'fl-themes-helper'),
        'weight'                    => 1000,
        'js_view'                   => 'VcColumnView',
        'controls'                  => 'full',
        "is_container"              => true,
        'show_settings_on_create'   => false,
		'params'                    => array(
             array(
                 'type'             => 'textfield',
                 'heading'          => esc_html__('Custom Classes', 'fl-themes-helper'),
                 'param_name'       => 'class',
                 'value'            => '',
                 'description'      => '',
             ),
             array(
                 'type'             => 'css_editor',
                 'heading'          => esc_html__( 'CSS', 'fl-themes-helper'),
                 'param_name'       => 'vc_css',
                 'group'            => esc_html__( 'Design Options', 'fl-themes-helper'),
             )
		),
	));
}
<?php

/*
 * Shortcode Partner
 * */

add_shortcode('vc_fl_list_table', 'vc_fl_list_table_function');

function vc_fl_list_table_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'table_style'       => 'fl-list_table_one',
        'class'             => '',
        'vc_css'            => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

    $result = '';

    $result .= '<div class="fl-list '.fl_sanitize_class($class).'">';

    $result .= '<ul class="fl-list-ul">'.do_shortcode($content).'</ul>';

    $result .= '</div>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_list_table_shortcode');

function vc_fl_list_table_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('List', 'fl-themes-helper'),
		'base'          => 'vc_fl_list_table',
        'icon'          => 'fl-icon icon-fl-list',
        'as_parent'     => array(
            'only' => 'vc_fl_list_row'
        ),
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'controls'      => 'full',
        'weight'        => 400,
        'js_view'       => 'VcColumnView',
		'params' => array(
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
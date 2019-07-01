<?php

/*
 * Shortcode Partner
 * */

add_shortcode('vc_fl_work_info_table', 'vc_fl_work_info_table_function');

function vc_fl_work_info_table_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'table_style'       => 'fl-list_table_one',
        'class'             => '',
        'vc_css'            => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

    $result = '';

    $result .= '<div class="fl-work-info '.fl_sanitize_class($class).'">';

    $result .= '<ul class="fl-list-work-info">'.do_shortcode($content).'</ul>';

    $result .= '</div>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_work_info_table_shortcode');

function vc_fl_work_info_table_shortcode() {
	
	vc_map(array(
		'name'                      => esc_html__('Work Info', 'fl-themes-helper'),
		'base'                      => 'vc_fl_work_info_table',
        'icon'                      => 'fl-icon icon-fl-list',
        'as_parent'                 => array(
                    'only' => 'vc_fl_work_info_row'
        ),
		'category'                  => esc_html__('Fl Theme', 'fl-themes-helper'),
        'controls'                  => 'full',
        'weight'                    => 80,
        'js_view'                   => 'VcColumnView',
        "show_settings_on_create"   => false,
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
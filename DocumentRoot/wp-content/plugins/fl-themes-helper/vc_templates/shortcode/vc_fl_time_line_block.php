<?php

/*
 * Shortcode testimonial Parent
 * */

add_shortcode('vc_fl_time_line_block', 'vc_fl_time_line_block_function');

function vc_fl_time_line_block_function($atts, $content = null)
{
    extract(shortcode_atts(array(
        'class'         => '',
        'vc_css'        => ''
    ), $atts));

    $class .= fl_get_css_tab_class($atts);


    $result = '';

    $result .= '<div class="fl-time-line-block '.fl_sanitize_class($class).' cf">';

    $result .= '<div class="fl-time-line-box-padding">';

    $result .= '<div class="fl-time-line-body">'.do_shortcode($content).'</div>';

    $result .= '</div>';

    $result .= '</div>';
    return $result;

}

add_action('vc_before_init', 'vc_fl_time_line_block_shortcode');

function vc_fl_time_line_block_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Time Line block', 'fl-themes-helper'),
		'base'          => 'vc_fl_time_line_block',
        'as_parent' => array(
            'only' => 'vc_fl_time_line_block_row',
        ),
        'icon'          => 'fl-icon icon-fl-time-line-block',
        'js_view'       => 'VcColumnView',
        'weight'        => 100,
        'controls'      => 'full',
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
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
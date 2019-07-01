<?php

/*
 * Shortcode Partner
 * */

add_shortcode('vc_fl_partner_block', 'vc_fl_partner_block_function');

function vc_fl_partner_block_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'item_to_show'          => 'fl_three_partner',
        'class'                 => '',
        'vc_css'                => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

    $idf = uniqid('fl_partner_block_');

    $result = '';


    $result .= '<div class="fl-partner_block cf '.$item_to_show.' '.fl_sanitize_class($class).' id="'.$idf.'">';

    $result .= do_shortcode($content);

    $result .= '</div>';
    
    return $result;

}

add_action('vc_before_init', 'vc_fl_partner_block_shortcode');

function vc_fl_partner_block_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Partner Block', 'fl-themes-helper'),
		'base'          => 'vc_fl_partner_block',
        'icon'          => 'fl-icon icon-fl-partner',
        'as_parent'     => array(
            'only' => 'vc_fl_partner_row'
        ),
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'js_view'       => 'VcColumnView',
        'controls'      => 'full',
        'weight'        => 300,
		'params' => array(
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Partner show on block', 'fl-themes-helper'),
                'param_name'        => 'item_to_show',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Three Default', 'fl-themes-helper')         => 'fl_three_partner',
                        esc_attr__('Four', 'fl-themes-helper')                  => 'fl_four_partner',
                ),
                'std'               => 'fl_three_partner',
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
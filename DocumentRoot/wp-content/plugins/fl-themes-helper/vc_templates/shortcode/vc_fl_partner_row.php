<?php

/*
 * Shortcode Partner Row
 * */

add_shortcode('vc_fl_partner_row', 'vc_fl_partner_row_function');

function vc_fl_partner_row_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'img_size'              => 'size_partner_190x',
        'partner_img_style'     => 'standard',
        'img'                   => '',
        'link'                  => '',
        'class'                 => '',
        'vc_css'                => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

    $idf = uniqid('fl_partner_img_');
    $link_start = '';
    $link_str_end = '';
    $link_atts = '';

    if($partner_img_style =='standard'){
        $attachment = fl_get_attachment($img, $img_size);
        $img = '<img src="' . esc_url($attachment['src']) . '" alt=" ' . esc_attr($attachment['alt']) . ' " class="fl_partner_img">';
    }  else {
        $attachment = fl_get_attachment($img, $img_size);
        $img = '<img src="' . esc_url($attachment['src']) . '" alt=" ' . esc_attr($attachment['alt']) . ' " class="fl_partner_img">';
        if ( fl_check_option($link) && function_exists('vc_build_link')) {
            $link = vc_build_link($link);
            if(isset($link['title']) && $link['url']) {

                $link_atts .= ' href="' . esc_attr($link['url']) . '"';

                if(isset($link['title']) && $link['title']) {
                    $link_atts .= ' title="' . esc_attr($link['title']) . '"';
                }
                if(isset($link['target']) && $link['target']) {
                    $link_atts .= ' target="' . esc_attr(trim($link['target'])) . '"';
                }
                if(isset($link['rel']) && $link['rel']) {
                    $link_atts .= ' rel="' . esc_attr(trim($link['rel'])) . '"';
                }
            }
            if (fl_check_option($link)) {
                $link_start =' <a class="img_single " '.$link_atts.' >';
                $link_str_end = '</a>';
            }
        }
    }



    $result = '';

    $result .= '<div class="fl-partner-slider_img fl_slick_slide '.fl_sanitize_class($class).' cf" id="'.$idf.'">';

    $result .= $link_start;

    $result .= $img;

    $result .= $link_str_end;

    $result .= '</div>';


    return $result;

}

add_action('vc_before_init', 'vc_fl_partner_row_shortcode');

function vc_fl_partner_row_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Partner Row', 'fl-themes-helper'),
		'base'          => 'vc_fl_partner_row',
        'icon'          => 'fl-icon icon-fl-partner-row',
        'as_child' => array(
            'only' => 'vc_fl_partner_slider','vc_fl_partner_block'
        ),
		'params'        => array(
            array(
                'type'                  => 'attach_image',
                'heading'               => esc_html__('Select Images', 'fl-themes-helper'),
                'param_name'            => 'img',
                'admin_label'           => false,
                'description'           => '<strong style="color:#B5122C">Attention: Use the same sizes for all upload images.</strong>'
            ),
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Images Size', 'fl-themes-helper'),
                'param_name'            => 'img_size',
                'std'                   => 'size_partner_190x',
                'value'                 => fl_get_image_sizes(),
                'description'           => ''
            ),
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Partner img style', 'fl-themes-helper'),
                'param_name'            => 'partner_img_style',
                'admin_label'           => true,
                'value' => array(
                        esc_attr__('Default Standard', 'fl-themes-helper')      => 'standard',
                        esc_attr__('Link', 'fl-themes-helper')                  => 'link',
                ),
                'std'                   => 'standard',
            ),
            array(
                'type'                  => 'vc_link',
                'heading'               => esc_html__('Link', 'fl-themes-helper'),
                'param_name'            => 'link',
                'dependency' => array(
                        'element'                                   => 'partner_img_style',
                        'value'                                     => array( 'link' ),
                ),
            ),
            array(
                'type'                  => 'textfield',
                'heading'               => esc_html__('Custom Classes', 'fl-themes-helper'),
                'param_name'            => 'class',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'                  => 'css_editor',
                'heading'               => esc_html__( 'CSS', 'fl-themes-helper'),
                'param_name'            => 'vc_css',
                'group'                 => esc_html__( 'Design Options', 'fl-themes-helper'),
            )
		),
	));
	
	
}
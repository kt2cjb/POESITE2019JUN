<?php

/*
 * Shortcode Partner
 * */

add_shortcode('vc_fl_partner_slider', 'vc_fl_partner_slider_function');

function vc_fl_partner_slider_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'partner_show'          => '4',
        'autoplay_slider'       => 'true',
        'slider_speed'          => '800',
        'auto_pay_slider_time'  => '2000',
        'infinite_slider'       =>'true',
        'class'                 => '',
        'vc_css'                => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

    $idf = uniqid('fl_partner_slider_');


    $result = '';

    $result .= '<script type="text/javascript">
    jQuery.noConflict()(document).ready( function() {
      var partner_slider = jQuery("#'.$idf.'");
        partner_slider.imagesLoaded(function() {
            partner_slider.slick({
               autoplay: '.$autoplay_slider.',      
               autoplaySpeed: '.$auto_pay_slider_time.',
               speed: '.$slider_speed.',    
               infinite: '.$infinite_slider.',
               slidesToShow: '.$partner_show.',
               slidesToScroll: 2,
               arrows: false,
               responsive: [
                        {
                            breakpoint: 1170,
                            settings: {
                                slidesToShow: '.$partner_show.',
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },

                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        }
                    ]      
            });
        });    
    });
    </script>';

    $result .= '<div class="fl-partner-slider fl_slick_box '.fl_sanitize_class($class).' cf" id="'.$idf.'">';

    $result .= do_shortcode($content);;

    $result .= '</div>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_partner_slider_shortcode');

function vc_fl_partner_slider_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Partner slider', 'fl-themes-helper'),
		'base'          => 'vc_fl_partner_slider',
        'icon'          => 'fl-icon icon-fl-partner-slider',
        'as_parent' => array(
            'only' => 'vc_fl_partner_row'
        ),
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'js_view'       => 'VcColumnView',
        'weight'        => 300,
        'controls'      => 'full',
		'params'        => array(
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Partner show on pages', 'fl-themes-helper'),
                'param_name'            => 'partner_show',
                'admin_label'           => true,
                'value' => array(
                        esc_attr__('Four Default', 'fl-themes-helper')          => '4',
                        esc_attr__('Three', 'fl-themes-helper')                 => '3',
                        esc_attr__('Five', 'fl-themes-helper')                  => '5',
                        esc_attr__('Six', 'fl-themes-helper')                   => '6',
                ),
                'std'                   => 'four',
            ),
            array(
                'type'                  => 'textfield',
                'heading'               => esc_html__('Slider speed', 'fl-themes-helper'),
                'param_name'            => 'slider_speed',
                'admin_label'           => false,
                'value'                 => '',
                'std'                   => '800',
                'group'                 => 'Slider setting',
            ),
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Infinite slider', 'fl-themes-helper'),
                'param_name'            => 'infinite_slider',
                'admin_label'           => false,
                'value' => array(
                        esc_attr__('True Default', 'fl-themes-helper')          => 'true',
                        esc_attr__('False', 'fl-themes-helper')                 => 'false',
                ),
                'std'                   => 'true',
                'group'                 => 'Slider setting',
            ),
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Auto play slider', 'fl-themes-helper'),
                'param_name'            => 'autoplay_slider',
                'admin_label'           => false,
                'value' => array(
                        esc_attr__('True Default', 'fl-themes-helper')          => 'true',
                        esc_attr__('False', 'fl-themes-helper')                 => 'false',
                ),
                'std'                   => 'true',
                'group'                 => 'Slider setting',
            ),
            array(
                'type'                  => 'textfield',
                'heading'               => esc_html__('Auto play speed', 'fl-themes-helper'),
                'param_name'            => 'auto_pay_slider_time',
                'admin_label'           => false,
                'value'                 => '',
                'std'                   => '2000',
                'group'                 => 'Slider setting',
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
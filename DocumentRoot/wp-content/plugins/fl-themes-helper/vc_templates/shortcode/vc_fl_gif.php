<?php



add_shortcode('vc_fl_gif', 'vc_fl_gif_function');


function vc_fl_gif_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'img_gif'       => '',
        'img_static'    => '',
        'type'          => 'default',
        'class'         => '',
        'vc_css'        => ''
    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    $static_image_path = '';

    $gif_path = '';
    if($img_gif){
        $gif_path = fl_get_attachment($img_gif, 'full');
    }

    if($img_static){
        $static_image_path = fl_get_attachment($img_static, 'full');
    }

        switch ($type) {
            case 'mouse-over':
                if($img_gif and $img_static) {
                    $class_animation = 'fl-hover-gif';
                    $gif_str = '<img src="' . esc_url($static_image_path['src']) . '" data-gif="' . esc_url($gif_path['src']) . '" data-static="' . esc_url($static_image_path['src']) . '" alt="' . esc_url($gif_path['alt']) . '">';
                } else {
                    $gif_str = '';
                }
                break;
            case 'click':
                if($img_gif and $img_static) {
                    $class_animation = 'fl-click-gif';
                    $gif_str = '<img src="' . esc_url($static_image_path['src']) . '" data-gif="' . esc_url($gif_path['src']) . '" data-static="' . esc_url($static_image_path['src']) . '" data-animate="static" alt="' . esc_url($gif_path['alt']) . '">';
                } else {
                    $gif_str = '';
                }
                break;
            case 'default':
                $class_animation = '';
                if($img_gif ) {
                    $gif_str = '<img src="' . esc_url($gif_path['src']) . '" data-gif="' . esc_url($gif_path['src']) . '" alt="' . esc_url($gif_path['alt']) . '">';
                } else {
                    $gif_str = '';
                }
         }


    $result = '';

    $result .= '<div class="fl-gif fl-click-gif '.$class_animation .' '.fl_sanitize_class($class).'">';

    $result .=  $gif_str;

    $result .= '</div>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_gif_shortcode');

function vc_fl_gif_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Gif', 'fl-themes-helper'),
            'base'          => 'vc_fl_gif',
            'icon'          => 'fl-icon icon-fl-gif',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'      => 'full',
            'weight'        => 500,
            'params' => array(
                array(
                    'type'        => 'attach_image',
                    'heading'     => esc_html__('Select GIF ', 'fl-themes-helper'),
                    'param_name'  => 'img_gif',
                    'value'       => '',
                ),
                array(
                    'type'        => 'attach_image',
                    'heading'     => esc_html__('Static Image', 'fl-themes-helper'),
                    'param_name'  => 'img_static',
                    'value'       => '',
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Play Type', 'fl-themes-helper'),
                    'param_name'  => 'type',
                    'std'         => 'default',
                    'value'       => array(
                            esc_html__('Default Autoplay', 'fl-themes-helper')      => 'default',
                            esc_html__('Mouse Over Play', 'fl-themes-helper')       => 'mouse-over',
                            esc_html__('On Click Play', 'fl-themes-helper')         => 'click',
                    ),
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'  => 'class',
                    'value'       => '',
                    'description' => '',
                ),
                array(
                    'type'        => 'css_editor',
                    'heading'     => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'  => 'vc_css',
                    'group'       => esc_html__('Design Options', 'fl-themes-helper'),
                )
            )
        ));
    }
}
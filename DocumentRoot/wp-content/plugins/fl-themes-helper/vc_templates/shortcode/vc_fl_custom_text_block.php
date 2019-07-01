<?php



add_shortcode('vc_fl_custom_text_block', 'vc_fl_custom_text_block_function');


function vc_fl_custom_text_block_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'ft_size'       => '',
        'text_color'    => '',
        'class'         => '',
        'vc_css'        => ''
    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    $font_color = '';
    $font_size = '';
    if($ft_size){
        $font_size = 'font-size:'.$ft_size.';';
    }
    if($text_color){
        $font_color = 'color:'.$text_color.';';
    }

    $text_block_css = ( $font_color || $font_size) ? 'style='.$font_color.$font_size. '' : '';


    $result = '';

    $result .= '<div class="fl_custom_text_block '.fl_sanitize_class($class).'" '.$text_block_css.'>';

    $result .= fl_js_remove_wpautop($content, true);

    $result .= '</div>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_custom_text_block_shortcode');

function vc_fl_custom_text_block_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Custom text block', 'fl-themes-helper'),
            'base'          => 'vc_fl_custom_text_block',
            'icon'          => 'fl-icon icon-fl-custom_text_block',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'      => 'full',
            'weight'        => 500,
            'params' => array(
                array(
                    'type'              => 'textarea_html',
                    "heading"           => esc_html__( "Text", "fl-themes-helper" ),
                    'param_name'        => 'content',
                    'value'             => '',
                    'holder'            => 'div',
                    'std'               => 'Morbi sit amet leo quis dolor porta malesuada in a velit. Suspendisse sit amet nunc risus. Suspendisse consectetur lectus ut ullamcorper egestas. Integer aliquam tellus eros, vel gravida justo facilisis sed. Nunc egestas risus vel nulla lobortis volutpat.',
                    "description"       => esc_html__( "Enter your text.", "fl-themes-helper" )
                ),
                array(
                    'type'              => 'textfield',
                    'admin_label'       => true,
                    'heading'           => esc_html__('Font size', 'fl-themes-helper'),
                    'description'       => esc_html__('Enter text font size (Number + px).Example:14px', 'fl-themes-helper'),
                    'param_name'        => 'ft_size',
                    'value'             => '',
                    'group'             => 'Style Settings',
                    'std'               => ''
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__( 'Text color', 'fl-themes-helper' ),
                    'param_name'        => 'text_color',
                    'group'             => 'Style Settings',
                    'std'               => '',
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
                    'heading'           => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'        => 'vc_css',
                    'group'             => esc_html__('Design Options', 'fl-themes-helper'),
                )
            )
        ));
    }
}
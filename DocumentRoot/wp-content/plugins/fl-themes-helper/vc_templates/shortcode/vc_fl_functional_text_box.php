<?php



add_shortcode('vc_fl_functional_text_box', 'vc_fl_functional_text_box_function');


function vc_fl_functional_text_box_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'fun_text_st'                   => 'fl_fun_box_default',
        'align'                         => 'text-center',
        'fun_text_size'                 => 'fl_fun_box_small',
        'class'                         => '',
        'tl_mb'                         => '',
        'vc_css'                        => '',
        'first_text'                    => '',
        'second_text'                   => '',
        'third_text'                    => '',
        'first_title_style'             => 'h4',
        'first_title_fs'                => '24px',
        'first_text_color'              => '#363636',
        'second_title_style'            => 'h4',
        'second_title_fs'               => '19px',
        'second_text_line_height'       => '23px',
        'second_text_color'             => '#363636',

    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    $mb_tl = '';
    if($tl_mb){
        $mb_tl = 'margin-bottom:'.$tl_mb.';';
    }
    $tl_one_fz='';
    if($first_title_fs){
        $tl_one_fz='font-size:'.$first_title_fs.';';
    }
    $tl_one_cl= '';
    if($first_text_color){
        $tl_one_cl = 'color:'.$first_text_color.';';
    }

    $title_one_css    = ( $mb_tl || $tl_one_fz || $tl_one_cl) ? 'style='. $mb_tl. $tl_one_fz. $tl_one_cl.'' : '';

    $tl_two_fz ='';
    if($second_title_fs){
        $tl_two_fz ='font-size:'.$second_title_fs.';';
    }
    $tl_two_cl= '';
    if($second_text_color){
        $tl_two_cl = 'color:'.$second_text_color.';';
    }

    $tl_two_lh= '';
    if($second_text_line_height){
        $tl_two_lh = 'line-height:'.$second_text_line_height.';';
    }

    $title_two_css    = ( $tl_two_fz|| $tl_two_cl || $tl_two_lh) ? 'style='. $tl_two_fz. $tl_two_cl.$tl_two_lh.'' : '';





    $result = '';

    $result .= '<div class="fl-functional_text_box '.fl_sanitize_class($class).'">';

    if($fun_text_st == 'fl_fun_box_default'){
        $result .= '<div class="fl_fun_box_default">';

        $result .= '<div class="fl_fun_text_one '.$first_title_style.' '.$align.'" '.$title_one_css.'>'.$first_text.'</div>';

        $result .= '<div class="fl_fun_text_two '.$second_title_style.' '.$align.'" '.$title_two_css.'>'.$second_text.'</div>';
        $result .= '</div>';
    } elseif($fun_text_st == 'fl_fun_box_two'){

        $result .= '<div class="fl_fun_box_two">';

        $result .= '<div class="'.$fun_text_size.' cf">';

        $result .= '<div class="fl_fun_text_one '.$first_title_style.'" style="color:'.$first_text_color.';">'.$first_text.'</div>';

        $result .= '<div class="fl_fun_text_two '.$second_title_style.'" '.$title_two_css.'>'.$second_text.'</div>';

        $result .= '</div>';

        $result .= '</div>';
    }

    $result .= '</div>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_functional_text_box_shortcode');

function vc_fl_functional_text_box_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Functional text box', 'fl-themes-helper'),
            'base'          => 'vc_fl_functional_text_box',
            'icon'          => 'fl-icon icon-fl-functional_text_box',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'      => 'full',
            'weight'        => 600,
            'params' => array(
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'        => 'class',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Text Box Style', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('Style Default', 'fl-themes-helper')        => 'fl_fun_box_default',
                        esc_attr__('Style Two', 'fl-themes-helper')            => 'fl_fun_box_two',
                    ),
                    'param_name'        => 'fun_text_st',
                    'group'             => 'Style Setting',
                    'std'               => 'fl_fun_box_default',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Size', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('Ultra Small', 'fl-themes-helper')          => 'fl_fun_box_ultra_small',
                        esc_attr__('Small', 'fl-themes-helper')                => 'fl_fun_box_small',
                        esc_attr__('Medium', 'fl-themes-helper')               => 'fl_fun_box_medium',
                        esc_attr__('Large', 'fl-themes-helper')                => 'fl_fun_box_large',
                    ),
                    'param_name'        => 'fun_text_size',
                    'group'             => 'Style Setting',
                    'description'       => 'Select First Title size',
                    'std'               => 'fl_fun_box_small',
                    'dependency'        => array(
                        'element'       => 'fun_text_st',
                        'value'         => array( 'fl_fun_box_two' ),
                    ),
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__( 'Alignment', 'fl-themes-helper' ),
                    'param_name'        => 'align',
                    'description'       => esc_html__( 'Select text alignment.', 'fl-themes-helper' ),
                    'std'               => 'text-center',
                    'value'             => array(
                        esc_html__( 'Left', 'fl-themes-helper' ) => 'text-left',
                        esc_html__( 'Right', 'fl-themes-helper' ) => 'text-right',
                        esc_html__( 'Center', 'fl-themes-helper' ) => 'text-center',
                    ),
                    'dependency'        => array(
                        'element'       => 'fun_text_st',
                        'value'         => array( 'fl_fun_box_default' ),
                    ),
                    'group'             => 'Style Setting',
                ),
                array(
                    "type"              => "textarea",
                    "holder"            => "div",
                    "class"             => "",
                    "heading"           => esc_html__( "First Title Text", "fl-themes-helper" ),
                    "param_name"        => "first_text",
                    "value"             => '',
                    "description"       => esc_html__( "Enter your Text.", "fl-themes-helper" ),
                    'std'               => '',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('First Title style', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('H style', 'fl-themes-helper')                => 'h4',
                        esc_attr__('Standard text style', 'fl-themes-helper')    => '',
                    ),
                    'param_name'        => 'first_title_style',
                    'group'             => 'Title Setting',
                    'std'               => 'h4',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Text color', 'fl-themes-helper'),
                    'param_name'        => 'first_text_color',
                    'value'             => '',
                    'std'               => '#363636',
                    'group'             => 'Title Setting',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('First Title font size', 'fl-themes-helper'),
                    'param_name'        => 'first_title_fs',
                    'value'             => '',
                    'std'               => '24px',
                    'group'             => 'Title Setting',
                    'description'       => '',
                    'dependency'        => array(
                        'element'       => 'fun_text_st',
                        'value'         => array( 'fl_fun_box_default' ),
                    ),
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('First title Margin bottom', 'fl-themes-helper'),
                    'param_name'        => 'tl_mb',
                    'value'             => '',
                    'std'               => '',
                    'group'             => 'Title Setting',
                    'description'       => 'Type your margin number + px. Example: 10px.',
                    'dependency'        => array(
                        'element'       => 'fun_text_st',
                        'value'         => array( 'fl_fun_box_default' ),
                    ),
                ),

                array(
                    "type"              => "textarea",
                    "holder"            => "div",
                    "class"             => "",
                    "heading"           => esc_html__( "Second Title Text", "fl-themes-helper" ),
                    "param_name"        => "second_text",
                    "value"             => '',
                    "description"       => esc_html__( "Enter your Text.", "fl-themes-helper" ),
                    'std'               => '',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Second Title style', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('H style', 'fl-themes-helper')                => 'h4',
                        esc_attr__('Standard text style', 'fl-themes-helper')    => '',
                    ),
                    'param_name'        => 'second_title_style',
                    'group'             => 'Title Setting',
                    'std'               => 'h4',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Text color', 'fl-themes-helper'),
                    'param_name'        => 'second_text_color',
                    'value'             => '',
                    'std'               => '#363636',
                    'group'             => 'Title Setting',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Second Title font size', 'fl-themes-helper'),
                    'param_name'        => 'second_title_fs',
                    'value'             => '',
                    'std'               => '19px',
                    'group'             => 'Title Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Second Title line height', 'fl-themes-helper'),
                    'param_name'        => 'second_text_line_height',
                    'value'             => '',
                    'std'               => '23px',
                    'group'             => 'Title Setting',
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
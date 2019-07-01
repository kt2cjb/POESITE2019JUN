<?php



add_shortcode('vc_fl_drops_caps', 'vc_fl_drops_caps_function');


function vc_fl_drops_caps_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'letter'                    => 'A',
        'letter_style'              => 'fl_letter_bg',
        'rounding_style'            => '',
        'letter_style_text'         => 'h1',
        'letter_background'         => '#1f1f1f',
        'letter_color'              => '#ffffff',

        'letter_mb'                 => '',
        'letter_mt'                 => 5,
        'letter_ml'                 => '',
        'letter_mr'                 => 15,
        'letter_fz'                 => 30,
        'letter_wh'                 => 45,


        'class'                     => '',
        'vc_css'                    => ''
    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    $lt_bg = $lt_cl =$lt_h= $lt_w =$lt_ml =$lt_mr=$lt_mb=$lt_mt=$lt_fz='';


    switch ($letter_style) {
        case 'fl_letter_default' :
            $lt_bg = '';
            break;
        case 'fl_letter_bg' :
            if($letter_background){
                $lt_bg = 'background-color:'.$letter_background.';';
            }
            break;
        case 'fl_letter_border' :
            if($letter_background){
                $lt_bg = 'border-color:'.$letter_background.';';
            }
            break;
    }



    $line_height_matematic = $letter_wh+5;


    $lh = 'line-height:'.$letter_wh.'px;';

    if($letter_wh){
        $lt_w = 'width:'.$letter_wh.'px;';
        $lt_h = 'height:'.$letter_wh.'px;';
    }
    if($letter_wh){
        $lt_w = 'width:'.$letter_wh.'px;';
        $lt_h = 'height:'.$letter_wh.'px;';
    }
    if($letter_mb){
        $lt_mb = 'margin-bottom:'.$letter_mb.'px;';
    }
    if($letter_mt){
        $lt_mt = 'margin-top:'.$letter_mt.'px;';
    }
    if($letter_ml){
        $lt_ml = 'margin-left:'.$letter_ml.'px;';
    }
    if($letter_mr){
        $lt_mr = 'margin-right:'.$letter_mr.'px;';
    }
    if($letter_color){
        $lt_cl = 'color:'.$letter_color.';';
    }
    if($letter_fz){
        $lt_fz = 'font-size:'.$letter_fz.'px;';
    }

    $latter_style_css   = ( $lt_bg  || $lt_cl || $lt_w || $lt_h || $lt_ml || $lt_mr || $lt_mb || $lt_mt || $lt_fz||$lh) ? 'style='.$lt_bg.$lt_cl.$lt_w.$lt_h.$lt_ml.$lt_mr.$lt_mb.$lt_mt.$lt_fz.$lh.'' : '';

    $result = '';

    $result .= '<span class="fl_drops_caps '.$letter_style.' '.$letter_style_text.' '.$rounding_style.'" '.$latter_style_css.'>' . $letter . '</span>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_drops_caps_shortcode');

function vc_fl_drops_caps_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Drops caps', 'fl-themes-helper'),
            'base'          => 'vc_fl_drops_caps',
            'icon'          => 'fl-icon icon-fl-drops_caps',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'      => 'full',
            'weight'        => 700,
            'params' => array(
                array(
                    'type'          => 'textfield',
                    'param_name'    => 'letter',
                    'admin_label'   => true,
                    'heading'       => esc_html__('Letter', 'fl-themes-helper'),
                    'value'         => 'A',
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Font family', 'fl-themes-helper'),
                    'param_name'    => 'letter_style_text',
                    'admin_label'   => true,
                    'value' => array(
                            esc_attr__('H Style', 'fl-themes-helper')       => 'h1',
                            esc_attr__('Text style', 'fl-themes-helper')    => '',
                    ),
                    'std'           => 'h1',
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Style Background', 'fl-themes-helper'),
                    'param_name'    => 'letter_style',
                    'admin_label'   => true,
                    'value' => array(
                        esc_attr__('Without Background', 'fl-themes-helper')    => 'fl_letter_default',
                        esc_attr__('Background', 'fl-themes-helper')            => 'fl_letter_bg',
                        esc_attr__('Border', 'fl-themes-helper')                => 'fl_letter_border',
                    ),
                    'std'           => 'fl_letter_bg',
                    'group'         => 'Background setting'
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Rounding Background', 'fl-themes-helper'),
                    'param_name'    => 'rounding_style',
                    'value' => array(
                            esc_attr__('Square', 'fl-themes-helper')        => '',
                            esc_attr__('Round', 'fl-themes-helper')         => 'fl_style_round',
                            esc_attr__('Rounded', 'fl-themes-helper')       => 'fl_style_rounded',
                    ),
                    'std'           => '',
                    'group'         => 'Background setting'
                ),
                array(
                    'type'          => 'colorpicker',
                    'param_name'    => 'letter_background',
                    'heading'       => esc_html__('Letter Background Color', 'fl-themes-helper'),
                    'value'         => '',
                    'group'         => 'Background setting'
                ),


                array(
                    'type'              => 'fl_number',
                    'heading'           => esc_html__('Letter Font size', 'fl-themes-helper'),
                    'param_name'        => 'letter_fz',
                    'admin_label'       => true,
                    'value'             => 30,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'group'             => 'Style setting'
                ),

                array(
                    'type'              => 'fl_number',
                    'heading'           => esc_html__('Letter Width', 'fl-themes-helper'),
                    'param_name'        => 'letter_wh',
                    'admin_label'       => true,
                    'value'             => 45,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'group'             => 'Style setting'
                ),


                array(
                    'type'              => 'fl_number',
                    'heading'           => esc_html__('Letter Margin Bottom', 'fl-themes-helper'),
                    'param_name'        => 'letter_mb',
                    'admin_label'       => true,
                    'value'             => '',
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Style setting'
                ),
                array(
                    'type'              => 'fl_number',
                    'heading'           => esc_html__('Letter Margin Top', 'fl-themes-helper'),
                    'param_name'        => 'letter_mt',
                    'admin_label'       => true,
                    'value'             => 5,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Style setting'
                ),
                array(
                    'type'              => 'fl_number',
                    'heading'           => esc_html__('Letter Margin Left', 'fl-themes-helper'),
                    'param_name'        => 'letter_ml',
                    'admin_label'       => true,
                    'value'             => '',
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Style setting'
                ),
                array(
                    'type'              => 'fl_number',
                    'heading'           => esc_html__('Letter Margin Right', 'fl-themes-helper'),
                    'param_name'        => 'letter_mr',
                    'admin_label'       => true,
                    'value'             => 15,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Style setting'
                ),

                array(
                    'type'          => 'colorpicker',
                    'param_name'    => 'letter_color',
                    'heading'       => esc_html__('Letter color', 'fl-themes-helper'),
                    'value'         => '',
                    'std'           => '#ffffff'
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'    => 'class',
                    'value'         => '',
                    'description'   => '',
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'    => 'vc_css',
                    'group'         => esc_html__('Design Options', 'fl-themes-helper'),
                )
            )
        ));
    }
}
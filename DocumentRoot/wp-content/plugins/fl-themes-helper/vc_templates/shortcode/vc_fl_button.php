<?php
/*
 * Shortcode Button
 */
add_shortcode('vc_fl_btn', 'vc_fl_render_fl_btn');

function vc_fl_render_fl_btn( $atts, $content = null )
{
    extract( shortcode_atts( array(
        'link'                              => '',
        'title'                             => 'Text on the button',
        'button_block'                      => '',
        'btn_text_cl'                       => '#ffffff',
        'size'                              => 'fl_btn_medium',
        'btn_style'                         => 'fl_btn_bg',
        'shape'                             => 'fl_btn_square',
        'btn_border_sz'                     => '1px',
        'btn_border_cl'                     => '#1f1f1f',
        'btn_background_cl'                 => '#1f1f1f',
        'align'                             => 'text-center',
        'fl_btn_effects'                    => '',
        'fl_btn_hv_color_enable'            => '',
        'btn_hv_bg_cl'                      => '#1f1f1f',
        'btn_hv_text_cl'                    => '#1f1f1f',
        'i_align'                           => 'left',
        'icon_type'                         => 'none',
        'icon_fontawesome'                  => '',
        'icon_openiconic'                   => '',
        'icon_typicons'                     => '',
        'icon_entypo'                       => '',
        'icon_linecons'                     => '',
        'icon_elusive'                      => '',
        'icon_etline'                       => '',
        'icon_iconmoon'                     => '',
        'icon_linearicons'                  => '',
        'icon_flicon'                       => '',
        'icon_iconic'                       => '',
        'class'                             => '',
        'vc_css'                            => '',
    ), $atts ) );

    $class .= fl_get_css_tab_class($atts);


    $result = '';


    switch ($icon_type) {
        case 'fontawesome':
            $icon = $atts['icon_fontawesome'];
            break;
        case 'openiconic':
            $icon = $atts['icon_openiconic'];
            break;
        case 'typicons':
            $icon = $atts['icon_typicons'];
            break;
        case 'entypo':
            $icon = $atts['icon_entypo'];
            break;
        case 'linecons':
            $icon = $atts['icon_linecons'];
            break;
        case 'elusive':
            $icon = $atts['icon_elusive'];
            break;
        case 'etline':
            $icon = $atts['icon_etline'];
            break;
        case 'iconmoon':
            $icon = $atts['icon_iconmoon'];
            break;
        case 'linearicons':
            $icon = $atts['icon_linearicons'];
            break;
        case 'flicon':
            $icon = $atts['icon_flicon'];
            break;
        case 'iconic':
            $icon = $atts['icon_iconic'];
            break;
    }

    vc_icon_element_fonts_enqueue($icon_type);


    $link_btn = $link_atts = '';

    $link = vc_build_link($link);
    if (fl_check_option($link)) {
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

        $link_btn ='<a class="fl_btn_link " '.$link_atts.' ></a>';
    }

    $text_cl = '';
    if($btn_text_cl) {
       $text_cl = 'color:'.$btn_text_cl.';';
    }

    $btn_bg_cl = '';
    $btn_border_color = '';
    $btn_border_size = '';
    if($btn_style == 'fl_btn_bg'){
        if($btn_background_cl){
            $btn_bg_cl = 'background-color:'.$btn_background_cl.';';
        }

    } else {
        if($btn_border_sz) {
            $btn_border_size = 'border-width:'.$btn_border_sz.';';
        }
        if($btn_border_cl){
            $btn_border_color = 'border-color:'.$btn_border_cl.';';
        }

    }

    $text_position = '';
    if($button_block == 'fl_btn_full'){
        $text_position = $align;
    }
    $hover_bg = '';
    $hover_text = '';
    if($fl_btn_hv_color_enable =='enable'){
        if($btn_hv_bg_cl){
            $hover_bg = 'data-bg-hv="'.$btn_hv_bg_cl.'"';
        }
        if($btn_hv_text_cl){
            $hover_text = 'data-text-hv="'.$btn_hv_text_cl.'"';
        }
    }


    $style_btn_css = ( $text_cl || $btn_border_size || $btn_border_color || $btn_bg_cl ) ? 'style='. esc_attr($text_cl). $btn_border_size.$btn_border_color.$btn_bg_cl. '' : '';

    $result .= '<div class="fl_btn_box '.$button_block.' '.$size.' '.$btn_style.' '.$shape.' '.$text_position.' '.$fl_btn_effects.' ' .fl_sanitize_class($class).'" '.$style_btn_css.' '.$hover_text.' '.$hover_bg.'>';

    if($i_align == 'left'){
        if ($icon_type != 'none') {
            $result .= '<i class=" fl-btn-icon fl_left_icon ' . $icon . '"></i>';
        }
    }

    $result .= $title;

    if($i_align == 'right'){
        if ($icon_type != 'none') {
            $result .= '<i class=" fl-btn-icon fl_right_icon ' . $icon . '"></i>';
        }
    }

    $result .= $link_btn;

    $result .= '</div>';

    return $result;
}
add_action('vc_before_init', 'vc_fl_button_shortcode');
function vc_fl_button_shortcode()
{
    {
    if (function_exists('vc_map')) {
        vc_map(array(
           "name"                  => esc_html__("Button", 'fl-themes-helper'),
           "base"                  => "vc_fl_btn",
           "class"                 => "",
           "controls"              => "full",
           'icon'                  => 'fl-icon icon-fl-button',
           "category"              => esc_html__('Fl Theme', 'fl-themes-helper'),
           'weight'                => 900,
           "params"                => array(
             array(
                 'type'                   => 'dropdown',
                 'heading'                => esc_html__( 'Button width', 'fl-themes-helper' ),
                 'param_name'             => 'button_block',
                 'description'            => esc_html__( 'Select button width: Normal or Full Width.', 'fl-themes-helper' ),
                 'std'                    => '',
                 'value'                  => array(
                                esc_html__( 'Normal', 'fl-themes-helper' )      => '',
                                esc_html__( 'Full Width', 'fl-themes-helper' )  => 'fl_btn_full',
                 ),
             ),
               array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__( 'Text align', 'fl-themes-helper' ),
                   'param_name'             => 'align',
                   'description'            => esc_html__( 'Select button text align.', 'fl-themes-helper' ),
                   'std'                    => 'text-center',
                   'value'                  => array(
                       esc_html__( 'Left', 'fl-themes-helper' )        => 'text-left',
                       esc_html__( 'Right', 'fl-themes-helper' )       => 'text-right',
                       esc_html__( 'Center', 'fl-themes-helper' )      => 'text-center',
                   ),
                   'dependency'             => array(
                       'element'               => 'button_block',
                       'value'                 => 'fl_btn_full',
                   ),
               ),

             array(
                'type'                      => 'textfield',
                'heading'                   => esc_html__( 'Text', 'fl-themes-helper' ),
                'param_name'                => 'title',
                'value'                     => esc_html__( 'Text on the button', 'fl-themes-helper' ),
                'std'                       => 'Text on the button'
             ),
               array(
                   'type'              => 'vc_link',
                   'heading'           => esc_html__('Link', 'fl-themes-helper'),
                   'param_name'        => 'link',
                   'dependency' => array(
                       'element'           => 'img_style',
                       'value'             => array( 'link' ),
                   ),
               ),
               array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__( 'Size', 'fl-themes-helper' ),
                   'param_name'             => 'size',
                   'description'            => esc_html__( 'Select button display size.', 'fl-themes-helper' ),
                   'std'                    => 'fl_btn_medium',
                   'value'                  => array(
                       esc_html__( 'S', 'fl-themes-helper' )           => 'fl_btn_small',
                       esc_html__( 'M', 'fl-themes-helper' )           => 'fl_btn_medium',
                       esc_html__( 'L', 'fl-themes-helper' )           => 'fl_btn_large',
                   ),
               ),
             array(
                 'type'                   => 'colorpicker',
                 'heading'                => esc_html__( 'Text color', 'fl-themes-helper' ),
                 'param_name'             => 'btn_text_cl',
                 'description'            => esc_html__( 'Select Text color for your element.', 'fl-themes-helper' ),
                 'edit_field_class'       => 'vc_col-sm-6',
                 'std'                    => '#ffffff',
                 'group'                  => 'Style',
             ),

               array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__( 'Button Style', 'fl-themes-helper' ),
                   'description'            => esc_html__( 'Select button style.', 'fl-themes-helper' ),
                   'param_name'             => 'btn_style',
                   'std'                    => 'fl_btn_bg',
                   'value'                  => array(
                       esc_html__( 'Background', 'fl-themes-helper' )     => 'fl_btn_bg',
                       esc_html__( 'Border', 'fl-themes-helper' )         => 'fl_btn_br',
                   ),
                   'group'                  => 'Style'
               ),

               array(
                   'type'                      => 'colorpicker',
                   'heading'                   => esc_html__( 'Background color', 'fl-themes-helper' ),
                   'param_name'                => 'btn_background_cl',
                   'value'                     => '',
                   'dependency'             => array(
                       'element'               => 'btn_style',
                       'value'                 => 'fl_btn_bg',
                   ),
                   'std'                       => '#1f1f1f',
                   'group'                     => 'Style'
               ),

               array(
                   'type'                      => 'colorpicker',
                   'heading'                   => esc_html__( 'Border color', 'fl-themes-helper' ),
                   'param_name'                => 'btn_border_cl',
                   'value'                     => '',
                   'dependency'             => array(
                       'element'               => 'btn_style',
                       'value'                 => 'fl_btn_br',
                   ),
                   'std'                       => '#1f1f1f',
                   'group'                     => 'Style'
               ),
               array(
                   'type'                      => 'textfield',
                   'heading'                   => esc_html__( 'Border size', 'fl-themes-helper' ),
                   'description'               => esc_html__( 'Insert border size number and + px. Example:1px.', 'fl-themes-helper' ),
                   'param_name'                => 'btn_border_sz',
                   'value'                     => '',
                   'dependency'             => array(
                       'element'               => 'btn_style',
                       'value'                 => 'fl_btn_br',
                   ),
                   'std'                       => '1px',
                   'group'                     => 'Style'
               ),
               array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__( 'Shape', 'fl-themes-helper' ),
                   'description'            => esc_html__( 'Select button shape.', 'fl-themes-helper' ),
                   'param_name'             => 'shape',
                   'std'                    => 'fl_btn_square',
                   'value'                  => array(
                       esc_html__( 'Rounded', 'fl-themes-helper' )     => 'fl_btn_rounded',
                       esc_html__( 'Square', 'fl-themes-helper' )      => 'fl_btn_square',
                       esc_html__( 'Round', 'fl-themes-helper' )       => 'fl_btn_round',
                   ),
                   'group'                     => 'Style'
               ),
             array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__( 'Button hover effects', 'fl-themes-helper' ),
                   'description'            => esc_html__( 'Select button hover effects.', 'fl-themes-helper' ),
                   'param_name'             => 'fl_btn_effects',
                   'value'                  => array(
                                esc_html__( 'None', 'fl-themes-helper' )        => '',
                                esc_html__( 'ZoomOut', 'fl-themes-helper' )      => 'fl_btn_hr_style_1',
                                esc_html__( 'ZoomIn', 'fl-themes-helper' )     => 'fl_btn_hr_style_2',
                                esc_html__( 'MoveUP', 'fl-themes-helper' )      => 'fl_btn_hr_style_3',
                                esc_html__( 'Opacity', 'fl-themes-helper' )     => 'fl_btn_hr_style_4',
                   ),
                 'group'                     => 'Button Hover'
             ),
               array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__( 'Button hover color', 'fl-themes-helper' ),
                   'param_name'             => 'fl_btn_hv_color_enable',
                   'value'                  => array(
                       esc_html__( 'Disable', 'fl-themes-helper' )          => 'disable',
                       esc_html__( 'Enable', 'fl-themes-helper' )           => 'enable',
                   ),
                   'group'                     => 'Button Hover'
               ),
               array(
                   'type'                      => 'colorpicker',
                   'heading'                   => esc_html__( 'Hover text color', 'fl-themes-helper' ),
                   'param_name'                => 'btn_hv_text_cl',
                   'value'                     => '',
                   'dependency'             => array(
                       'element'               => 'fl_btn_hv_color_enable',
                       'value'                 => 'enable',
                   ),
                   'std'                       => '#1f1f1f',
                   'edit_field_class'          => 'vc_col-sm-4',
                   'group'                     => 'Button Hover'
               ),
               array(
                   'type'                      => 'colorpicker',
                   'heading'                   => esc_html__( 'Hover Background color', 'fl-themes-helper' ),
                   'param_name'                => 'btn_hv_bg_cl',
                   'value'                     => '',
                   'dependency'             => array(
                       'element'               => 'fl_btn_hv_color_enable',
                       'value'                 => 'enable',
                   ),
                   'edit_field_class'          => 'vc_col-sm-4',
                   'std'                       => '#1f1f1f',
                   'group'                     => 'Button Hover'
               ),
             array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__('Icon library', 'fl-themes-helper'),
                   'value'                  => array(
                                esc_attr__('None', 'fl-themes-helper')              => 'none',
                                esc_attr__('Font Awesome', 'fl-themes-helper')      => 'fontawesome',
                                esc_attr__('Open Iconic', 'fl-themes-helper')       => 'openiconic',
                                esc_attr__('Typicons', 'fl-themes-helper')          => 'typicons',
                                esc_attr__('Entypo', 'fl-themes-helper')            => 'entypo',
                                esc_attr__('Linecons', 'fl-themes-helper')          => 'linecons',
                                esc_attr__('Etline', 'fl-themes-helper')            => 'etline',
                                esc_attr__('Iconmoon', 'fl-themes-helper')          => 'iconmoon',
                                esc_attr__('Linearicons', 'fl-themes-helper')       => 'linearicons',
                                esc_attr__('Elusive', 'fl-themes-helper')           => 'elusive',
                                esc_attr__('Iconic', 'fl-themes-helper')            => 'iconic',
                                esc_attr__('Fl', 'fl-themes-helper')                => 'flicon',
                   ),
                   'param_name'             => 'icon_type',
                   'description'            => esc_html__('Select icon library', 'fl-themes-helper'),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'dropdown',
                   'heading'                => esc_html__( 'Icon Alignment', 'fl-themes-helper' ),
                   'description'            => esc_html__( 'Select icon alignment.', 'fl-themes-helper' ),
                   'param_name'             => 'i_align',
                   'value'                  => array(
                                esc_html__( 'Left', 'fl-themes-helper' )        => 'left',
                                esc_html__( 'Right', 'fl-themes-helper' )       => 'right',
                   ),
                   'std'                    => 'fl_ico_left',
                   'group'                  => 'Icon',
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_fontawesome',
                   'settings'               => array(
                                'emptyIcon'             => false,
                                'iconsPerPage'          => 300
                   ),
                   'dependency'             => array(
                                'element'               => 'icon_type',
                                'value'                 => 'fontawesome'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_openiconic',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'openiconic',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'openiconic'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_typicons',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'typicons',
                                'iconsPerPage'      => 300
                   ),
                   'dependency' => array(
                                'element'           => 'icon_type',
                                'value'             => 'typicons'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_entypo',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'entypo',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'entypo'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_linecons',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'linecons',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'linecons'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_etline',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'etline',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'etline'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_iconmoon',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'iconmoon',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'iconmoon'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_linearicons',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'linearicons',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'linearicons'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_elusive',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'elusive',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'elusive'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_flicon',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'flicon',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'flicon'
                   ),
                   'group'                  => 'Icon'
             ),
             array(
                   'type'                   => 'iconpicker',
                   'heading'                => esc_html__('Icon', 'fl-themes-helper'),
                   'param_name'             => 'icon_iconic',
                   'settings'               => array(
                                'emptyIcon'         => false,
                                'type'              => 'iconic',
                                'iconsPerPage'      => 300
                   ),
                   'dependency'             => array(
                                'element'           => 'icon_type',
                                'value'             => 'iconic'
                   ),
                   'group'                  => 'Icon'
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
    )
        );
    }
    }
}

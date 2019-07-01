<?php

/*
 * Shortcode Partner Row
 * */

add_shortcode('vc_fl_list_row', 'vc_fl_list_row_function');

function vc_fl_list_row_function($atts, $content = null) {

	extract(shortcode_atts(array(
    'style'                 => 'one',
    'li_content'            => 'Branding Design',
    'content_color'         => '#1f1f1f',
    'sufix_color'           => '#1f1f1f',
    'border_color'          => '#f1f1f1',
    'border_bt'             => 'disable',
    'icon_type'             => 'none',
    'icon_margin_right'     => '',
    'icon_margin_left'      => '',
    'icon_margin_bottom'    => '',
    'icon_margin_top'       => '',
    'icon_fontawesome'      => '',
    'icon_openiconic'       => '',
    'icon_typicons'         => '',
    'icon_entypo'           => '',
    'icon_linecons'         => '',
    'icon_elusive'          => '',
    'icon_etline'           => '',
    'icon_iconmoon'         => '',
    'icon_linearicons'      => '',
    'icon_flicon'           => '',
    'icon_iconic'           => '',
    'class'                 => '',
    'vc_css'                => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

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


    $br_color       = '';
    $color_ct       = '';
	if($border_bt =='enable'){
	    $bt_bord = 'fl_border_bottom_enable';
        if($border_color){
            $br_color = 'border-color:'.$border_color.';';
        }
    }  else {
        $bt_bord = '';
    }

    if($content_color){
	    $color_ct = 'color:'.$content_color.'';
    }

    $list_sufix ='';
    if($style=='one'){
        $list_sufix= '';
    } elseif ($style =='two'){
        $list_sufix= '<i class="fa fa-check" style="color:'.$sufix_color.';"></i>';
    } elseif ($style =='three'){
        $list_sufix= '<i class="fa fa-circle-thin" style="color:'.$sufix_color.';"></i>';
    } elseif ($style =='four'){
        $list_sufix= '<span class="fl-minus" style="background-color:'.$sufix_color.';"></span>';
    } elseif ($style =='five'){
        $list_sufix= '<i class="fa fa-dot-circle-o" style="color:'.$sufix_color.';"></i>';
    } else {
        if ($icon_type != 'none') {
            $list_sufix .= '<i class="' . $icon . '" style="color:'.$sufix_color.';"></i>';
        }
    }


    $list_style =  ( $br_color || $color_ct ) ? 'style='. $br_color . $color_ct . '' : '';

    $result = '';

    $result .= '<li class="fl-list-li '.$style.' '.$bt_bord.' '.$list_style.' '.fl_sanitize_class($class).'">'.$list_sufix.$li_content.'</li>';


    return $result;

}

add_action('vc_before_init', 'vc_fl_list_row_shortcode');

function vc_fl_list_row_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('List Row', 'fl-themes-helper'),
		'base'          => 'vc_fl_list_row',
        'icon'          => 'fl-icon icon-fl-list-row',
        'as_child' => array(
            'only' => 'vc_fl_list_table'
        ),
		'params'        => array(
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Style', 'fl-themes-helper'),
                'param_name'            => 'style',
                'admin_label'           => true,
                'value' => array(
                        esc_attr__('Style Default', 'fl-themes-helper')     => 'one',
                        esc_attr__('Two', 'fl-themes-helper')               => 'two',
                        esc_attr__('Three', 'fl-themes-helper')             => 'three',
                        esc_attr__('Four', 'fl-themes-helper')              => 'four',
                        esc_attr__('Five', 'fl-themes-helper')              => 'five',
                        esc_attr__('Six', 'fl-themes-helper')               => 'six',
                ),
                'std'                   => 'one',
            ),
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Border bottom', 'fl-themes-helper'),
                'param_name'            => 'border_bt',
                'admin_label'           => true,
                'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')            => 'enable',
                        esc_attr__('Disable', 'fl-themes-helper')           => 'disable',
                ),
                'std'                   => 'disable',
            ),
            array(
                'type'                  => 'textfield',
                'heading'               => esc_html__('Content', 'fl-themes-helper'),
                'param_name'            => 'li_content',
                'std'                   => 'Branding Design',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'                  => 'colorpicker',
                'heading'               => esc_html__('Content color', 'fl-themes-helper'),
                'param_name'            => 'content_color',
                'std'                   => '#1f1f1f',
                'edit_field_class'      => 'vc_col-sm-3',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'                  => 'colorpicker',
                'heading'               => esc_html__('Sufix color', 'fl-themes-helper'),
                'param_name'            => 'sufix_color',
                'std'                   => '#1f1f1f',
                'edit_field_class'      => 'vc_col-sm-3',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'                  => 'colorpicker',
                'heading'               => esc_html__('Border color', 'fl-themes-helper'),
                'param_name'            => 'border_color',
                'std'                   => '#f1f1f1',
                'dependency'  => array(
                        'element'                           => 'border_bt',
                        'value'                             => array( 'enable' ),
                ),
                'edit_field_class'      => 'vc_col-sm-3',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'                  => 'dropdown',
                'heading'               => esc_html__('Icon library', 'fl-themes-helper'),
                'value' => array(
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
                'dependency'  => array(
                        'element'                               => 'style',
                        'value'                                 => array( 'six' ),
                ),
                'param_name'            => 'icon_type',
                'description'           => esc_html__('Select icon library', 'fl-themes-helper'),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_fontawesome',
                'settings'              => array(
                        'emptyIcon'                     => false,
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'fontawesome'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_openiconic',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'openiconic',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'openiconic'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_typicons',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'typicons',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'typicons'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_entypo',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'entypo',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'entypo'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_linecons',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'linecons',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'linecons'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_etline',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'etline',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'etline'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_iconmoon',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'iconmoon',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'iconmoon'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_linearicons',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'linearicons',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'linearicons'
                ),
                'group' => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_elusive',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'elusive',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'elusive'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_flicon',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'flicon',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'flicon'
                ),
                'group' => 'Icon'
            ),
            array(
                'type'                  => 'iconpicker',
                'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'            => 'icon_iconic',
                'settings' => array(
                        'emptyIcon'                     => false,
                        'type'                          => 'iconic',
                        'iconsPerPage'                  => 300
                ),
                'dependency' => array(
                        'element'                       => 'icon_type',
                        'value'                         => 'iconic'
                ),
                'group'                 => 'Icon'
            ),
            array(
                'type'              => 'textfield',
                'param_name'        => 'slider_speed',
                'heading'           => esc_html__('Slider Speed', 'test'),
                'std'               => '900',
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
                'description'       => esc_html__( 'Standard Slider speed 900ms', 'fl-themes-helper'),
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
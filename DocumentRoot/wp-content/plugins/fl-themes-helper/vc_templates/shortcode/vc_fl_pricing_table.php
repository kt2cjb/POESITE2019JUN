<?php

/*
 * Shortcode Partner
 * */

add_shortcode('vc_fl_pricing_table', 'vc_fl_pricing_table_function');

function vc_fl_pricing_table_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'table_style'               => 'fl-pricing_table_one',
        'title'                     => 'Title',
        'price'                     => '29.99',
        'price_prefix'              => '$',
        'sentence'                  => 'Medium business solution',
        'pricing_period'            => '/ month',
        'icon_type'                 => 'none',
        'icon_fontawesome'          => '',
        'icon_openiconic'           => '',
        'icon_typicons'             => '',
        'icon_entypo'               => '',
        'icon_linecons'             => '',
        'icon_elusive'              => '',
        'icon_etline'               => '',
        'icon_iconmoon'             => '',
        'icon_linearicons'          => '',
        'icon_flicon'               => '',
        'icon_iconic'               => '',
        'btn_action_text'           => 'Choose plan',
        'link'                      => '',
        'btn_text_cl'               => '#ffffff',
        'btn_background_cl'         => '#1f1f1f',
        'fl_btn_hover_color_effect' => '',
        'btn_hv_text_cl'            => '#1f1f1f',
        'btn_hv_background_cl'      => '#f1f1f1',
        'fl_btn_effects'            => '',
        'class'                     => '',
        'vc_css'                    => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);

    $idf = uniqid('fl_table_');


    $vc_icon_box_output =$bg_btn_cl=$text_btn_cl=$hover_bg_btn=$hover_cl_btn=$result=$style_css= '';


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


    if ($icon_type != 'none') {
        $vc_icon_box_output .= '<div class="fl-icom-box"><i class="fl-pricing_icon  ' . $icon . '"></i></div>';
    }

    if($btn_text_cl){
        $text_btn_cl = 'color:'.$btn_text_cl.';';
    }
    if($btn_background_cl){
        $bg_btn_cl = 'background:'.$btn_background_cl.';';
    }


    $style_btn_css = ( $text_btn_cl || $bg_btn_cl  ) ? 'style='. esc_attr($text_btn_cl).$bg_btn_cl. '' : '';


    if($fl_btn_hover_color_effect){
        if($btn_hv_text_cl) {
            $hover_cl_btn = 'color:'.$btn_hv_text_cl.'!important;';
        }
        if($btn_hv_background_cl) {
            $hover_bg_btn = 'background:'.$btn_hv_background_cl.'!important;';
        }

    }

    if($hover_cl_btn && $hover_bg_btn){
        $style_css = '<style type="text/css" data-type="vc_custom-css">
        #'.$idf .'-btn:hover{
         '.$hover_bg_btn.''.$hover_cl_btn.'  
        }</style>';

    }


    $link_atts = '';
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
    }


    $pricing_action = '<a class="fl-pricing_action '.$fl_btn_effects.'" id="'.$idf .'-btn" '.$link_atts.' '.$style_btn_css .'>'.$btn_action_text.'</a>';


    $result .= '<div class="fl-pricing_table '.$table_style.' '.fl_sanitize_class($class).'" id="'.$idf.'">';

    if($table_style == 'fl-pricing_table_one'){

    $result .= '<h2 class="fl-pricing_title">'.$title.'</h2>';

     $result .= '<h2 class="fl-pricing_price"><span class="fl-pricing_prefix" >'.$price_prefix.'</span>'.$price.'<span class="fl-pricing_period">'.$pricing_period.'</span></h2>';

    $result .= '<p class="fl-pricing_sentence">'.$sentence.'</p>';

    $result .= '<ul class="fl-pricing_feature-list">'.do_shortcode($content).'</ul>';

    $result .= $pricing_action;

    } elseif($table_style == 'fl-pricing_table_two'){

        $result .= '<h2 class="fl-pricing_title">'.$title.'</h2>';

        $result .= '<p class="fl-pricing_sentence">'.$sentence.'</p>';

        $result .= '<h2 class="fl-pricing_price"><span class="fl-pricing_prefix" >'.$price_prefix.'</span>'.$price.'</br><span class="fl-pricing_period">'.$pricing_period.'</span></h2>';

        $result .= '<ul class="fl-pricing_feature-list">'.do_shortcode($content).'</ul>';

        $result .= $pricing_action;

    } elseif($table_style == 'fl-pricing_table_three'){

        $result .= $vc_icon_box_output;

        $result .= '<h2 class="fl-pricing_title">'.$title.'</h2>';

        $result .= '<p class="fl-pricing_sentence">'.$sentence.'</p>';

        $result .= '<h2 class="fl-pricing_price"><span class="fl-pricing_prefix" >'.$price_prefix.'</span>'.$price.'<span class="fl-pricing_period">'.$pricing_period.'</span></h2>';

        $result .= '<ul class="fl-pricing_feature-list">'.do_shortcode($content).'</ul>';

        $result .= '<div class="fl-pricing_action_div">
                    '.$pricing_action.'
                    </div>';

    } elseif($table_style == 'fl-pricing_table_four'){

        $result .= $vc_icon_box_output;

        $result .= '<h2 class="fl-pricing_title">'.$title.'</h2>';

        $result .= '<h2 class="fl-pricing_price"><span class="fl-pricing_prefix" >'.$price_prefix.'</span>'.$price.'<span class="fl-pricing_period">'.$pricing_period.'</span></h2>';

        $result .= '<ul class="fl-pricing_feature-list">'.do_shortcode($content).'</ul>';

        $result .= '<div class="fl-pricing_action_div">
                      '.$pricing_action.'
                    </div>';

    } else {
        $result .= '<div class="fl-header-pricing">';

        $result .= '<h2 class="fl-pricing_price">
            <div class="fl-pricing-box"> <span class="fl-pricing_prefix" >'.$price_prefix.'</span>'.$price.'<span class="fl-pricing_period">'.$pricing_period.'</span></div>';

        $result .= '<p class="fl-pricing_title h2">'.$title.'</p></h2>';

        $result .= '</div>';

        $result .= '<ul class="fl-pricing_feature-list">'.do_shortcode($content).'</ul>';

        $result .= '<div class="fl-pricing_action_div">
                    '.$pricing_action.'
                    </div>';

    }

    $result .= '</div>';

    $result .= $style_css;

    return $result;
}

add_action('vc_before_init', 'vc_fl_pricing_table_shortcode');

function vc_fl_pricing_table_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Pricing Table', 'fl-themes-helper'),
		'base'          => 'vc_fl_pricing_table',
        'icon'          => 'fl-icon icon-fl-pricing-table',
        'as_parent' => array(
            'only' => 'vc_fl_pricing_row'
        ),
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'js_view'       => 'VcColumnView',
        'weight'        => 300,
        'controls'      => 'full',
		'params' => array(
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Pricing Table Style', 'fl-themes-helper'),
                'param_name'    => 'table_style',
                'admin_label'   => true,
                'value' => array(
                        esc_attr__('Style One', 'fl-themes-helper')         => 'fl-pricing_table_one',
                        esc_attr__('Style Two', 'fl-themes-helper')         => 'fl-pricing_table_two',
                        esc_attr__('Style Three', 'fl-themes-helper')       => 'fl-pricing_table_three',
                        esc_attr__('Style Four', 'fl-themes-helper')        => 'fl-pricing_table_four',
                        esc_attr__('Style Five', 'fl-themes-helper')        => 'fl-pricing_table_five',
                ),
                'std'           => 'fl-pricing_table_one'
            ),


            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Title', 'fl-themes-helper'),
                'param_name'    => 'title',
                'std'           => 'Title',
                'value'         => '',
                'description'   => '',
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Price Prefix', 'fl-themes-helper'),
                'param_name'    => 'price_prefix',
                'std'           => '$',
                'description'   => '',
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Price', 'fl-themes-helper'),
                'param_name'    => 'price',
                'std'           => '29.99',
                'value'         => '',
                'description'   => '',
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Pricing period', 'fl-themes-helper'),
                'param_name'    => 'pricing_period',
                'std'           => '/ month',
                'value'         => '',
                'description'   => '',
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Sentence', 'fl-themes-helper'),
                'param_name'    => 'sentence',
                'std'           => 'Medium business solution',
                'value'         => '',
                'description'   => '',
            ),

            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Icon library', 'fl-themes-helper'),
                'value' => array(
                        esc_attr__('None', 'fl-themes-helper')          => 'none',
                        esc_attr__('Font Awesome', 'fl-themes-helper')  => 'fontawesome',
                        esc_attr__('Open Iconic', 'fl-themes-helper')   => 'openiconic',
                        esc_attr__('Typicons', 'fl-themes-helper')      => 'typicons',
                        esc_attr__('Entypo', 'fl-themes-helper')        => 'entypo',
                        esc_attr__('Linecons', 'fl-themes-helper')      => 'linecons',
                        esc_attr__('Etline', 'fl-themes-helper')        => 'etline',
                        esc_attr__('Iconmoon', 'fl-themes-helper')      => 'iconmoon',
                        esc_attr__('Linearicons', 'fl-themes-helper')   => 'linearicons',
                        esc_attr__('Elusive', 'fl-themes-helper')       => 'elusive',
                        esc_attr__('Iconic', 'fl-themes-helper')        => 'iconic',
                        esc_attr__('Fl', 'fl-themes-helper')            => 'flicon',

                ),
                'param_name'    => 'icon_type',
                'dependency'   => array(
                        'element'           => 'table_style',
                        'value'             => array( 'fl-pricing_table_three','fl-pricing_table_four' ),
                ),
                'description'   => esc_html__('Select icon library', 'fl-themes-helper'),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_fontawesome',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'fontawesome'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_openiconic',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'openiconic',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'openiconic'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_typicons',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'typicons',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'typicons'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_entypo',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'entypo',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'entypo'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_linecons',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'linecons',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'linecons'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_etline',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'etline',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'etline'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_iconmoon',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'iconmoon',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'iconmoon'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_linearicons',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'linearicons',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'linearicons'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_elusive',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'elusive',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'elusive'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_flicon',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'flicon',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'flicon'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'iconpicker',
                'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'    => 'icon_iconic',
                'settings' => array(
                        'emptyIcon'                         => false,
                        'type'                              => 'iconic',
                        'iconsPerPage'                      => 300
                ),
                'dependency' => array(
                        'element'                           => 'icon_type',
                        'value'                             => 'iconic'
                ),
                'group'         => 'Icon'
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Pricing Button Text', 'fl-themes-helper'),
                'param_name'    => 'btn_action_text',
                'std'           => 'Choose plan',
                'value'         => '',
                'description'   => '',
                'group'         => 'Button'
            ),
            array(
                'type'              => 'vc_link',
                'heading'           => esc_html__('Link', 'fl-themes-helper'),
                'param_name'        => 'link',
                'description'       =>  '',
                'group'             => 'Button'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Button text color', 'fl-themes-helper' ),
                'param_name'        => 'btn_text_cl',
                'value'             => '',
                'std'               => '#ffffff',
                'group'             => 'Button'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Button Background color', 'fl-themes-helper' ),
                'param_name'        => 'btn_background_cl',
                'value'             => '',
                'std'               => '#1f1f1f',
                'group'             => 'Button'
            ),
            array(
                'type'                   => 'dropdown',
                'heading'                => esc_html__( 'Button hover effects', 'fl-themes-helper' ),
                'description'            => esc_html__( 'Select button hover effects.', 'fl-themes-helper' ),
                'param_name'             => 'fl_btn_effects',
                'std'                    => '',
                'value'                  => array(
                    esc_html__( 'None', 'fl-themes-helper' )        => '',
                    esc_html__( 'ZoomOut', 'fl-themes-helper' )      => 'fl_btn_hr_style_1',
                    esc_html__( 'ZoomIn', 'fl-themes-helper' )     => 'fl_btn_hr_style_2',
                    esc_html__( 'MoveUP', 'fl-themes-helper' )      => 'fl_btn_hr_style_3',
                    esc_html__( 'Opacity', 'fl-themes-helper' )     => 'fl_btn_hr_style_4',
                ),
                'group'             => 'Button'
            ),
            array(
                'type'                   => 'dropdown',
                'heading'                => esc_html__( 'Button hover color', 'fl-themes-helper' ),
                'param_name'             => 'fl_btn_hover_color_effect',
                'std'                    => '',
                'value'                  => array(
                    esc_html__( 'None', 'fl-themes-helper' )        => '',
                    esc_html__( 'Custom', 'fl-themes-helper' )      => 'custom',
                ),
                'group'             => 'Button'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Button Hover text color', 'fl-themes-helper' ),
                'param_name'        => 'btn_hv_text_cl',
                'value'             => '',
                'std'               => '#1f1f1f',
                'dependency' => array(
                    'element'                           => 'fl_btn_hover_color_effect',
                    'value'                             => 'custom'
                ),
                'group'             => 'Button'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Button Hover Background color', 'fl-themes-helper' ),
                'param_name'        => 'btn_hv_background_cl',
                'value'             => '',
                'std'               => '#f1f1f1',
                'dependency' => array(
                    'element'                           => 'fl_btn_hover_color_effect',
                    'value'                             => 'custom'
                ),
                'group'             => 'Button'
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
                'heading'       => esc_html__( 'CSS', 'fl-themes-helper'),
                'param_name'    => 'vc_css',
                'group'         => esc_html__( 'Design Options', 'fl-themes-helper'),
            )
		),
	));
	
	
}
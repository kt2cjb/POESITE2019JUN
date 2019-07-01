<?php



add_shortcode('vc_fl_banners', 'vc_fl_banners_function');


function vc_fl_banners_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'banner_st'                     => 'fl_banner_st_default',
        'img'                           => '',
        'img_size'                      => 'size_1170x668_crop',
        'img_hover_effects'             => 'fl_img_zoom_in',
        'banner_button'                 => 'enable',
        'banner_btn_st'                 => 'fl_btn_default',
        'banner_btn_text'               => 'Button text',
        'banner_bt_st'                  => 'fl_banner_btn_bg',
        'link'                          => '',
        'btn_cl'                        => '#1f1f1f',
        'button_fz'                     => '13px',
        'button_bg'                     => '#ffffff',
        'title'                         => '',
        'bn_content'                    => '',
        'title_style'                   => 'h4',
        'title_cl'                      => '#ffffff',
        'title_fz'                      => '20px',
        'title_mb'                      => '10px',
        'content_mb'                    => '10px',
        'content_fz'                    => '14px',
        'content_cl'                    => '#ffffff',
        'banner_bg'                     => 'rgba(0,0,0,0.7)',
        'fl_btn_effects'                => '',
        'fl_btn_hv_color_enable'        => '',
        'btn_hv_bg_cl'                  => '#1f1f1f',
        'btn_hv_text_cl'                => '#1f1f1f',
        'class'                         => '',
        'vc_css'                        => ''
    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    $link_start = '';
    $link_end = '';
    if ( fl_check_option($link)) {
        $link = vc_build_link($link);
        if (fl_check_option($link)) {
            $link_start = ' <a class="fl_banner_link " href="' . $link['url'] . '" title="' . $link['title'] . '"  target="' . $link['target'] . '" >';
            $link_end = '</a>';
        }
    }

    $bg_banner_cl ='';
    if($banner_bg){
        $bg_banner_cl ='background-color:'.$banner_bg.';';
    }

    $banner_mask_style   = ( $bg_banner_cl  ) ? 'style='. $bg_banner_cl .'' : '';
    $tl_cl = '';
    if($title_cl){
        $tl_cl = 'color:'.$title_cl.';';
    }

    $mb_title = '';
    if($title_mb){
        $mb_title = 'margin-bottom:'.$title_mb.';';
    }

    $title_size = '';
    if($title_fz){
        $title_size = 'font-size:'.$title_fz.';';
    }

    $title_style_css  = ( $tl_cl || $title_size || $mb_title ) ? 'style='. $tl_cl . $title_size . $mb_title .'' : '';


    $mb_content = '';
    if($content_mb){
        $mb_content = 'margin-bottom:'.$content_mb.';';
    }

    $cn_cl = '';
    if($content_cl){
        $cn_cl = 'color:'.$content_cl.';';
    }

    $cn_fz = '';
    if($content_fz){
        $cn_fz = 'font-size:'.$content_fz.';';
    }

    $content_style  = ( $cn_cl || $mb_content || $cn_fz  ) ? 'style='. $cn_cl . $mb_content . $cn_fz .'' : '';


    $cl_btn = '';
    if($btn_cl){
        $cl_btn = 'color:'.$btn_cl.';';
    }

    $bt_fz = '';
    if($button_fz){
        $bt_fz = 'font-size:'.$content_fz.';';
    }

    $bt_background = '';

    switch ($banner_bt_st) {
        case 'fl_banner_btn_bg' :
            if($button_bg){
                $bt_background = 'background-color:'.$button_bg.';';
            }
            break;
        case 'fl_banner_btn_br' :
            if($button_bg){
                $bt_background = 'border-color:'.$button_bg.';';
            }
            break;
    }


    $bnt_style_css  = ( $cl_btn || $bt_fz || $bt_background ) ? 'style='. $cl_btn . $bt_fz  . $bt_background. '' : '';

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


    if($img){
        $attachment = fl_get_attachment($img, $img_size);
        $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_banner-img">';
    } else {
        $image = '';
    }


    $btn ='';
    if($banner_button !='disable'){
        $btn ='fl_button_enable';
    }

    $result = '';

    $result .= '<div class="fl_banner  '.fl_sanitize_class($class).' '.$banner_st.' '.$btn.' '.$img_hover_effects.'">';

    $result .= '<div class="fl_banner_img_box">';

    $result .= $image;

    $result .= '</div>';

    $result .= '<div class="fl_banner_mask" '.$banner_mask_style.'>';

    $result .= '<div class="fl_banner_content">';

    $result .= '<div class="fl_banner_title '.$title_style.'" '.$title_style_css.'>'.$title.'</div>';

    $result .= '<div class="fl_banner_text" '.$content_style.'>'.$bn_content.'</div>';

    if($banner_button !='disable'){

        $result .= '<div class="fl_banner_button '.$banner_bt_st.' '.$fl_btn_effects.'" '.$bnt_style_css.' '.$hover_bg.' '.$hover_text.'>';

        $result .= $link_start ;

        $result .= $banner_btn_text;

        $result .= $link_end ;

        $result .= '</div>';
    }

    $result .= '</div>';

    $result .= '</div>';

    $result .= '</div>';

    return $result;
}

add_action('vc_before_init', 'vc_fl_banners_shortcode');

function vc_fl_banners_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'                  => esc_html__('Banners', 'fl-themes-helper'),
            'base'                  => 'vc_fl_banners',
            'icon'                  => 'fl-icon icon-fl-banners',
            'controls'              => 'full',
            'category'              => esc_html__('Fl Theme', 'fl-themes-helper'),
            'weight'                => 900,
            'params' => array(
                array(
                    'type'              => 'attach_image',
                    'heading'           => esc_html__('Select Images', 'fl-themes-helper'),
                    'param_name'        => 'img',
                    'admin_label'       => false
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Title', 'fl-themes-helper'),
                    'param_name'        => 'title',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    'type'              => 'textarea',
                    'heading'           => esc_html__('Text content', 'fl-themes-helper'),
                    'param_name'        => 'bn_content',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Banner Style', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('Default', 'fl-themes-helper')               => 'fl_banner_st_default',
                        esc_attr__('Two', 'fl-themes-helper')                   => 'fl_banner_st_two',
                        esc_attr__('Three', 'fl-themes-helper')                 => 'fl_banner_st_three',
                    ),
                    'param_name'        => 'banner_st',
                    'group'             => 'Style Setting',
                    'std'               => 'fl_banner_st_default',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__( 'Image effects', 'fl-themes-helper' ),
                    'description'       => esc_html__( 'Select image hover effects.', 'fl-themes-helper' ),
                    'param_name'        => 'img_hover_effects',
                    'value' => array(
                        esc_html__( 'None', 'fl-themes-helper' )                        => '',
                        esc_html__( 'ZoomIn', 'fl-themes-helper' )                      => 'fl_img_zoom_in',
                        esc_html__( 'ZoomOut', 'fl-themes-helper' )                     => 'fl_img_zoom_out',
                        esc_html__( 'GrayScaleIn', 'fl-themes-helper' )                 => 'fl_img_gray',
                        esc_html__( 'GrayScaleOut', 'fl-themes-helper' )                => 'fl_img_gray_out',
                        esc_html__( 'BrightnessIn', 'fl-themes-helper' )                => 'fl_img_brightness_in',
                        esc_html__( 'BrightnessOut', 'fl-themes-helper' )               => 'fl_img_brightness_out',
                        esc_html__( 'Blur', 'fl-themes-helper' )                        => 'fl_img_blur',

                    ),
                    'group'             => 'Style Setting',
                    'std'               => 'fl_img_zoom_in'
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Images Size', 'fl-themes-helper'),
                    'param_name'        => 'img_size',
                    'std'               => 'size_1170x668_crop',
                    'value'             => fl_get_image_sizes(),
                    'group'             => 'Style Setting',
                    'description'       => ''
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Banner button', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('Enable', 'fl-themes-helper')                => 'enable',
                        esc_attr__('Disable', 'fl-themes-helper')               => 'disable',
                    ),
                    'param_name'        => 'banner_button',
                    'group'             => 'Style Setting',
                    'std'               => 'enable',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Title style', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('H style', 'fl-themes-helper')                => 'h4',
                        esc_attr__('Standard text style', 'fl-themes-helper')    => '',
                    ),
                    'param_name'        => 'title_style',
                    'group'             => 'Content Setting',
                    'std'               => 'h4',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Title font size', 'fl-themes-helper'),
                    'param_name'        => 'title_fz',
                    'value'             => '',
                    'std'               => '20px',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Title margin bottom', 'fl-themes-helper'),
                    'param_name'        => 'title_mb',
                    'value'             => '',
                    'std'               => '10px',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),

                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Title color', 'fl-themes-helper'),
                    'param_name'        => 'title_cl',
                    'value'             => '',
                    'std'               => '#ffffff',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Content font size', 'fl-themes-helper'),
                    'param_name'        => 'content_fz',
                    'value'             => '',
                    'std'               => '14px',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Content color', 'fl-themes-helper'),
                    'param_name'        => 'content_cl',
                    'value'             => '',
                    'std'               => '#ffffff',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),

                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Content margin bottom', 'fl-themes-helper'),
                    'param_name'        => 'content_mb',
                    'value'             => '',
                    'std'               => '10px',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Button text', 'fl-themes-helper'),
                    'param_name'        => 'banner_btn_text',
                    'value'             => '',
                    'std'               => 'Button Text',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Button style', 'fl-themes-helper'),
                    'value'             => array(
                        esc_attr__('Background Button', 'fl-themes-helper')                 => 'fl_banner_btn_bg',
                        esc_attr__('Border Button', 'fl-themes-helper')                     => 'fl_banner_btn_br',
                    ),
                    'param_name'        => 'banner_bt_st',
                    'group'             => 'Content Setting',
                    'std'               => 'fl_banner_btn_bg',
                ),
                array(
                    'type'              => 'vc_link',
                    'heading'           => esc_html__('Button Link', 'fl-themes-helper'),
                    'group'             => 'Content Setting',
                    'param_name'        => 'link',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Banner button text color', 'fl-themes-helper'),
                    'param_name'        => 'btn_cl',
                    'value'             => '',
                    'std'               => '#1f1f1f',
                    'edit_field_class'  => 'vc_col-sm-4',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Banner button background or border color', 'fl-themes-helper'),
                    'param_name'        => 'button_bg',
                    'value'             => '',
                    'std'               => '#ffffff',
                    'edit_field_class'  => 'vc_col-sm-8',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Button hover effects', 'fl-themes-helper' ),
                    'description'            => esc_html__( 'Select button hover effects. Attention: Full Width Button not working with MovingText effect!', 'fl-themes-helper' ),
                    'param_name'             => 'fl_btn_effects',
                    'value'                  => array(
                        esc_html__( 'None', 'fl-themes-helper' )        => '',
                        esc_html__( 'ZoomIn', 'fl-themes-helper' )      => 'fl_btn_hr_style_1',
                        esc_html__( 'ZoomOut', 'fl-themes-helper' )     => 'fl_btn_hr_style_2',
                        esc_html__( 'MoveUP', 'fl-themes-helper' )      => 'fl_btn_hr_style_3',
                        esc_html__( 'Opacity', 'fl-themes-helper' )     => 'fl_btn_hr_style_4',
                    ),
                    'group'             => 'Content Setting',
                ),
                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Button hover color', 'fl-themes-helper' ),
                    'param_name'             => 'fl_btn_hv_color_enable',
                    'value'                  => array(
                        esc_html__( 'Disable', 'fl-themes-helper' )          => 'disable',
                        esc_html__( 'Enable', 'fl-themes-helper' )           => 'enable',
                    ),
                    'group'             => 'Content Setting',
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
                    'group'             => 'Content Setting',
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
                    'group'             => 'Content Setting',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Banner button font size', 'fl-themes-helper'),
                    'param_name'        => 'button_fz',
                    'value'             => '',
                    'std'               => '13px',
                    'group'             => 'Content Setting',
                    'description'       => '',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Banner mask color', 'fl-themes-helper'),
                    'param_name'        => 'banner_bg',
                    'value'             => '',
                    'std'               => 'rgba(0,0,0,0.7)',
                    'group'             => 'Mask Setting',
                    'description'       => '',
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
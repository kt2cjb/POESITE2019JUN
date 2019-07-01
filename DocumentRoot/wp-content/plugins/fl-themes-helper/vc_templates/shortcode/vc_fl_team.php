<?php

/*
 * Shortcode Team Row
 * */

add_shortcode('vc_fl_team', 'vc_fl_team_function');

function vc_fl_team_function($atts, $content = null) {

	extract(shortcode_atts(array(

        'team_img_style'            => 'standard',
        'img'                       => '',
        'fl_tm_img_effects'         => '',
        'link'                      => '',
        'alignment_icon'            => 'fl_center_icon',
        'icon_color'                => '#ffffff',
        'tm_icon_size'              => 'tm_icon_size_small',
        'icon_animation'            => 'icon_animation_1',
        'tm_icon_background'        => 'icon_bg_disable',
        'icon_bg_color'             => '',
        'tm_icon_background_type'   => '',
        'fb_link'                   => '',
        'tw_link'                   => '',
        'inst_link'                 => '',
        'in_link'                   => '',
        'gplus_link'                => '',
        'yt_link'                   => '',
        'vm_link'                   => '',
        'pn_link'                   => '',
        'bh_link'                   => '',
        'mail_link'                 => '',
        'text_animation'            => '',
        'tm_name'                   => 'Name',
        'align'                     => 'left',
        'style_variants'            => 'default_align',
        'tm_name_color'             => '#363636',
        'tm_name_font_size'         => '26px',
        'tm_desc'                   => 'Description',
        'tm_desc_color'             => '#908f8f',
        'tm_desc_font_size'         => '16px',
        'team_style'                => 'style_team_one',
        'bg_tm_color'               => 'rgba(0, 0, 0, 0.5)',
        'class'                     => '',
        'vc_css'                    => '',
        ), $atts));


    $result = '';

    $class .= fl_get_css_tab_class($atts);

    $idf = uniqid('fl_team_img_');
    $link_start = '';
    $link_str_end = '';

    $attachment = fl_get_attachment($img, 'size_500x700_crop');

    if($attachment['alt']){
        $attachment_alt = $attachment['alt'];
    } else {
        $attachment_alt = ' ';
    }

    if($team_img_style =='standard'){
        $img = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment_alt) . '" class="fl_team_img">';
    }  else {

        $img = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment_alt) . '" class="fl_team_img">';
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
            } else {
                $link_atts = '';
            }
            if (fl_check_option($link)) {
                $link_start =' <a class="team_link " '.$link_atts.' >';
                $img = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment_alt) . '" class="fl_team_img">';
                $link_str_end = '</a>';
            }
        }
    }

    $tm_cl_name=$tm_ft_sz=$tm_ds_cl=$tm_ds_fz=$tm_bg_cl=$i_cl=$i_bg= '';
    if($icon_color){
        $i_cl = 'color:'.$icon_color.';';
    }

    if($tm_icon_background == 'icon_bg_enable'){
        if($icon_bg_color){
            $i_bg = 'background-color:'.$icon_bg_color.';';
        }
    } 


    if($tm_name_color){
        $tm_cl_name = 'color:'.$tm_name_color.';';
    }
    if($tm_name_font_size){
        $tm_ft_sz = 'font-size:'.$tm_name_font_size.';';
    }
    if($tm_desc_color){
        $tm_ds_cl = 'color:'.$tm_desc_color.';';
    }
    if($tm_desc_font_size){
        $tm_ds_fz= 'font-size:'.$tm_desc_font_size.'';
    }

    if($bg_tm_color){
        $tm_bg_cl = 'background-color:'.$bg_tm_color.';';
    }
    $team_mane_style_css = ( $tm_cl_name  || $tm_ft_sz) ? 'style='. $tm_cl_name. $tm_ft_sz .'' : '';

    $team_desc_style_css = ( $tm_ds_cl  || $tm_ds_fz) ? 'style='. $tm_ds_cl. $tm_ds_fz .'' : '';

    $team_bg_style_css = ( $tm_bg_cl ) ? 'style='. $tm_bg_cl .'' : '';

    $icon_style_css = ( $i_cl  || $i_bg) ? 'style='. $i_cl. $i_bg .'' : '';

    $fb_icon = $tw_icon = $inst_icon = $in_icon = $gplus_icon = $yt_icon = $vm_icon = $pn_icon = $bh_icon = $mail_icon ='';
    if($fb_link){$fb_icon = '<a class="fb_icon" href="'.$fb_link.'"><i class="fa fa-facebook '.$tm_icon_background_type.'" '.$icon_style_css.'></i></a>';}
    if($tw_link){$tw_icon = '<a class="tw_icon" href="'.$tw_link.'"><i class="fa fa-twitter '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($inst_link){$inst_icon = '<a class="inst_icon" href="'.$inst_link.'"><i class="fa fa-instagram '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($in_link){$in_icon = '<a class="in_icon" href="'.$in_link.'"><i class="fa fa-linkedin '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($gplus_link){$gplus_icon = '<a class="gplus_icon" href="'.$gplus_link.'"><i class="fa fa-google '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($yt_link){$yt_icon = '<a class="yt_icon" href="'.$yt_link.'"><i class="fa fa-youtube '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($vm_link){ $vm_icon = '<a class="vm_icon" href="'.$vm_link.'"><i class="fa fa-vimeo '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($pn_link){ $pn_icon = '<a class="pn_icon" href="'.$pn_link.'"><i class="fa fa-pinterest-p '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($bh_link){$bh_icon = '<a class="bh_icon" href="'.$bh_link.'"><i class="fa fa-behance '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}
    if($mail_link){$mail_icon = '<a class="mail_icon" href="mailto:'.$mail_link.'"><i class="fa fa-envelope '.$tm_icon_background_type.' " '.$icon_style_css.'></i></a>';}



    $s_links = ''.$fb_icon.''.$tw_icon.''.$inst_icon.''.$in_icon.''.$gplus_icon.''.$yt_icon.''.$vm_icon.''.$pn_icon.''.$bh_icon.''.$mail_icon.'';


    $result .= '<div class="fl-team-img fl-image-team '.fl_sanitize_class($class).' cf" id="'.$idf.'">';

    if($team_style == 'style_team_one'){
        $result .= '<div class="fl_team_img_box '.$fl_tm_img_effects.'">';

        $result .= $link_start;

        $result .= '<div class="fl_team_img">'.$img.'</div>';

        $result .= $link_str_end;

        $result .= '</div>';

        $result .= '<div class="fl_team_text '.$align.'">';

        $result .= '<div class="fl_tm_name h4" '.$team_mane_style_css.'>'.$tm_name.'</div>';

        $result .= '<div class="fl_tm_desc" '.$team_desc_style_css.'>'.$tm_desc.'</div>';

        $result .= '</div>';

    } elseif($team_style == 'style_team_two'){

        $result .= '<div class="fl_team_img_box '.$fl_tm_img_effects.' '.$alignment_icon.'">';

        $result .= '<div class="fl_team_img">'.$img.'</div>';

        $result .= '<div class="fl_img_mask" '.$team_bg_style_css.'>';

        $result .= '<div class="fl_icon_box '.$icon_animation.' '.$tm_icon_size.'">';

        $result .= $s_links;

        $result .= '</div>';

        $result .= '</div>';

        $result .= '</div>';

        $result .= '<div class="fl_team_text '.$align.'">';

        $result .= '<div class="fl_tm_name h4" '.$team_mane_style_css.'>'.$tm_name.'</div>';

        $result .= '<div class="fl_tm_desc" '.$team_desc_style_css.'>'.$tm_desc.'</div>';

        $result .= '</div>';

    } elseif($team_style == 'style_team_three'){

        $result .= '<div class="fl_team_img_box_three '.$fl_tm_img_effects.'">';

        $result .= '<div class="fl_team_img">'.$img.'</div>';

        $result .= '<div class="fl_img_mask '.$style_variants.'" '.$team_bg_style_css.'>';

        $result .= '<div class="fl_team_text '.$align.' '.$text_animation.' ">';

        $result .= '<div class="fl_tm_name h4" '.$team_mane_style_css.'>'.$tm_name.'</div>';

        $result .= '<div class="fl_tm_desc" '.$team_desc_style_css.'>'.$tm_desc.'</div>';

        $result .= '</div>';

        $result .= '<div class="fl_icon_box '.$icon_animation.' '.$tm_icon_size.'">';

        $result .= $s_links;

        $result .= '</div>';

        $result .= '</div>';

        $result .= '</div>';

    }

    $result .= '</div>';


    return $result;

}

add_action('vc_before_init', 'vc_fl_team_shortcode');

function vc_fl_team_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Team Box', 'fl-themes-helper'),
        'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
		'base'          => 'vc_fl_team',
        'weight'        => 100,
        'controls'      => 'full',
        'icon'          => 'fl-icon icon-fl-team',
		'params' => array(
            array(
                'type'              => 'attach_image',
                'heading'           => esc_html__('Select Images', 'fl-themes-helper'),
                'param_name'        => 'img',
                'admin_label'       => false,
                'description'       => '<strong style="color:#B5122C">Attention: Use the same sizes for all upload images.</strong>'
            ),

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Team img style', 'fl-themes-helper'),
                'param_name'        => 'team_style',
                'admin_label'       => false,
                'value' => array(
                        esc_attr__('Team with link on image', 'fl-themes-helper')       => 'style_team_one',
                        esc_attr__('Team with social links', 'fl-themes-helper')        => 'style_team_two',
                        esc_attr__('Style three', 'fl-themes-helper')                   => 'style_team_three',
                ),
                'std'               => 'standard',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Style variants', 'fl-themes-helper' ),
                'param_name'        => 'style_variants',
                'std'               => 'default_align',
                'dependency' => array(
                        'element'                                           => 'team_style',
                        'value'                                             => 'style_team_three',
                ),
                'value' => array(
                        esc_html__( 'Default', 'fl-themes-helper' )                     => 'fl_default_align',
                        esc_html__( 'Text top, vertical icon', 'fl-themes-helper' )     => 'fl_align_variant_two',
                ),
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Icon alignments', 'fl-themes-helper' ),
                'param_name'        => 'alignment_icon',
                'std'               => 'fl_center_icon',
                'dependency' => array(
                        'element'                                           => 'team_style',
                        'value'                                             => 'style_team_two',
                ),
                'value' => array(
                        esc_html__( 'Center', 'fl-themes-helper' )                      => 'fl_center_icon',
                        esc_html__( 'Bottom', 'fl-themes-helper' )                      => 'fl_bottom_icon',
                        esc_html__( 'Vertical Right', 'fl-themes-helper' )              => 'fl_vertical_icon',
                ),
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Hover mask color on image', 'fl-themes-helper'),
                'param_name'        => 'bg_tm_color',
                'value'             => '',
                'std'               => 'rgba(0, 0, 0, 0.5)',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Image effects', 'fl-themes-helper' ),
                'description'       => esc_html__( 'Select image hover effects.', 'fl-themes-helper' ),
                'param_name'        => 'fl_tm_img_effects',
                'value' => array(
                        esc_html__( 'None', 'fl-themes-helper' )                        => '',
                        esc_html__( 'ZoomIn', 'fl-themes-helper' )                      => 'fl_tm_img_zoom_in',
                        esc_html__( 'ZoomOut', 'fl-themes-helper' )                     => 'fl_tm_img_zoom_out',
                        esc_html__( 'GrayScaleIn', 'fl-themes-helper' )                 => 'fl_tm_img_gray',
                        esc_html__( 'GrayScaleOut', 'fl-themes-helper' )                => 'fl_tm_img_gray_out',
                        esc_html__( 'BrightnessIn', 'fl-themes-helper' )                => 'fl_tm_img_brightness_in',
                        esc_html__( 'BrightnessOut', 'fl-themes-helper' )               => 'fl_tm_img_brightness_out',
                        esc_html__( 'Blur', 'fl-themes-helper' )                        => 'fl_tm_img_blur',
                ),
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Add link to image', 'fl-themes-helper'),
                'param_name'        => 'team_img_style',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Disable', 'fl-themes-helper')                       => 'standard',
                        esc_attr__('Enable', 'fl-themes-helper')                        => 'link',
                ),
                'std'               => 'standard',
                'dependency' => array(
                        'element'                                           => 'team_style',
                        'value'                                             => 'style_team_one',
                ),
            ),
            array(
                'type'              => 'vc_link',
                'heading'           => esc_html__('Link', 'fl-themes-helper'),
                'param_name'        => 'link',
                'dependency' => array(
                        'element'                                           => 'team_img_style',
                        'value'                                             => array( 'link' ),
                ),

            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Animation text', 'fl-themes-helper' ),
                'param_name'        => 'text_animation',
                'description'       => esc_html__( 'Select text animation.', 'fl-themes-helper' ),
                'std'               => '',
                'dependency' => array(
                        'element'                                           => 'team_style',
                        'value'                                             => 'style_team_three',
                ),
                'value' => array(
                        esc_html__( 'Disable', 'fl-themes-helper' )                     => '',
                        esc_html__( 'Style One', 'fl-themes-helper' )                   => 'fl_text_animation_one',
                        esc_html__( 'Style Two', 'fl-themes-helper' )                   => 'fl_text_animation_two',
                ),
                'group'             => 'Text',
            ),


            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Alignment', 'fl-themes-helper' ),
                'param_name'        => 'align',
                'description'       => esc_html__( 'Select text alignment.', 'fl-themes-helper' ),
                'std' => 'left',
                'value' => array(
                        esc_html__( 'Left', 'fl-themes-helper' )                        => 'text-left',
                        esc_html__( 'Right', 'fl-themes-helper' )                       => 'text-right',
                        esc_html__( 'Center', 'fl-themes-helper' )                      => 'text-center',
                ),
                'group'             => 'Text',
            ),

            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Name text color', 'fl-themes-helper'),
                'param_name'        => 'tm_name_color',
                'value'             => '',
                'std'               => '#363636',
                'group'             => 'Text',
            ),
            array(
                "type"              => "textfield",
                'heading'           => esc_html__('Font size', 'fl-themes-helper'),
                "param_name"        => "tm_name_font_size",
                "value"             => esc_html__("", 'fl-themes-helper'),
                "description"       => esc_html__("", 'fl-themes-helper'),
                'std'               => '26px',
                'group'             => 'Text',
            ),
            array(
                "type"              => "textarea",
                "holder"            => "div",
                "class"             => "",
                "heading"           => esc_html__( "Name", "fl-themes-helper" ),
                "param_name"        => "tm_name",
                'admin_label'       => true,
                "value"             => '',
                "description"       => esc_html__( "Enter your content.", "fl-themes-helper" ),
                'std'               => 'Name',
                'group'             => 'Text',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Description text color', 'fl-themes-helper'),
                'param_name'        => 'tm_desc_color',
                'value'             => '',
                'std'               => '#363636',
                'group'             => 'Text',
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Font size', 'test'),
                'param_name'        => 'tm_desc_font_size',
                'value'             => '',
                'std'               => '16px',
                'group'             => 'Text',
            ),

            array(
                "type"              => "textarea",
                "holder"            => "div",
                "class"             => "",
                "heading"           => esc_html__( "Description", "fl-themes-helper" ),
                "param_name"        => "tm_desc",
                'admin_label'       => true,
                "value"             => '',
                "description"       => esc_html__( "Enter your content.", "fl-themes-helper" ),
                'std'               => 'Description',
                'group'             => 'Text',
            ),

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon Background', 'fl-themes-helper'),
                'param_name'        => 'tm_icon_background',
                'value' => array(
                        esc_attr__('Disable', 'fl-themes-helper')                   => '',
                        esc_attr__('Enable', 'fl-themes-helper')                    => 'icon_bg_enable',
                ),
                'std'               => 'icon_bg_disable',
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon background color', 'fl-themes-helper'),
                'param_name'        => 'icon_bg_color',
                'value'             => '',
                'std'               => '',
                'dependency' => array(
                        'element'                                       => 'tm_icon_background',
                        'value'                                         => 'icon_bg_enable',
                ),
                'group'             => 'Social Icons'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon Background Type', 'fl-themes-helper'),
                'param_name'        => 'tm_icon_background_type',
                'value' => array(
                        esc_attr__('Square', 'fl-themes-helper')                    => '',
                        esc_attr__('Round', 'fl-themes-helper')                     => 'icon_bg_round',
                ),
                'dependency' => array(
                        'element'                                       => 'tm_icon_background',
                        'value'                                         => 'icon_bg_enable',
                ),
                'group'             => 'Social Icons',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon color', 'fl-themes-helper'),
                'param_name'        => 'icon_color',
                'value'             => '',
                'std'               => '#ffffff',
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Social icon size', 'test'),
                'param_name'        => 'tm_icon_size',
                'value' => array(
                        esc_attr__('Small', 'fl-themes-helper')                     => 'tm_icon_size_small',
                        esc_attr__('Medium', 'fl-themes-helper')                    => 'tm_icon_size_medium',
                ),
                'std'               => 'tm_icon_size_small',
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon animation', 'fl-themes-helper'),
                'param_name'        => 'icon_animation',
                'admin_label'       => true,
                'value' => array(
                        '1'                                             => 'icon_animation_1',
                        '2'                                             => 'icon_animation_2',
                        '3'                                             => 'icon_animation_3',
                        '4'                                             => 'icon_animation_4',
                        '5'                                             => 'icon_animation_5',
                ),
                'std'               => 'standard',
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons',
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to Facebook page",'fl-themes-helper'),
                "param_name"        => "fb_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to Twitter page",'fl-themes-helper'),
                "param_name"        => "tw_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to Instagram page",'fl-themes-helper'),
                "param_name"        => "inst_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to LinkedIn page",'fl-themes-helper'),
                "param_name"        => "in_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to Google+ page",'fl-themes-helper'),
                "param_name"        => "gplus_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to YouTube page",'fl-themes-helper'),
                "param_name"        => "yt_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to Vimeo page",'fl-themes-helper'),
                "param_name"        => "vm_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to Pinterest page",'fl-themes-helper'),
                "param_name"        => "pn_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("URL to Behance page",'fl-themes-helper'),
                "param_name"        => "bh_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
            ),
            array(
                "type"              => "textfield",
                "class"             => "",
                "heading"           => esc_html__("e-mail",'fl-themes-helper'),
                "param_name"        => "mail_link",
                "value"             => esc_html__("",'fl-themes-helper'),
                'dependency' => array(
                        'element'                                       => 'team_style',
                        'value'                                         => array( 'style_team_two','style_team_three' ),
                ),
                'group'             => 'Social Icons'
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
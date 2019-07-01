<?php

class Fl{

    const DASHBOARD_DIRECTORY_URI = '/dashboard/';
    const DASHBOARD_DIRECTORY = '/dashboard/';


    public function __construct(){
        $this->dashboard_init_data();
        $this->dashboard_init_action();
        $this->dashboard_init_menu_action();

    }

    public function dashboard_init_data(){

        $this->dashboard_dir = (dirname(__FILE__)) . self::DASHBOARD_DIRECTORY;

        $theme_info = wp_get_theme();
        $theme_parent = $theme_info->parent();

        if(!empty($theme_parent)) {
            $theme_info = $theme_parent;
        }

        $this->theme_name = $theme_info['Name'];
        $this->theme_version = $theme_info['Version'];
        $this->theme_is_child = !empty($theme_parent);
        $this->theme_slug = $theme_info->get_stylesheet();
        $this->dashboard_slug = 'theme-dashboard';
        $this->demoimportslug = 'theme-demo-import';
        $this->tgmslug = 'theme-plugin-install';

        $this->strings = array(
            'dashboard_title' => esc_html__('Welcome to %1$s %2$s', 'fl-themes-helper'),
            'dashboard_subtitle' => esc_html__('Thanks for purchasing %1$s. We really appreciate your choice. If you like our theme and support, please rate it 5 stars. More information can be found below.', 'fl-themes-helper'),
            'footer_thank_you' => esc_html__('Thank you for buying %s!', 'fl-themes-helper'),
            'widget_requirements_title' => esc_html__('Requirements', 'fl-themes-helper'),
            'widget_requirements_problems' => esc_html__('Some Problems', 'fl-themes-helper'),
            'widget_requirements_noproblems' => esc_html__('No Problems', 'fl-themes-helper'),
            'widget_more_info_text' => esc_html__('More Info', 'fl-themes-helper'),
        );


    }

    public function dashboard_init_action(){
        if (is_admin()){
            add_action('admin_print_styles', array($this, 'dashboard_print_styles'));
        }
    }

    public function dashboard_print_styles(){
        wp_enqueue_style('fl_dashboard_css', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->theme_version);
    }



    public function dashboard_init_menu_action(){
        add_action('admin_menu', array($this, 'dashboard_admin_menu'));
        add_action('admin_bar_menu', array($this, 'dashboard_admin_bar_menu'), 80);
    }

    public function dashboard_admin_menu(){
       	call_user_func('add_menu_page', $this->theme_name, $this->theme_name, 'edit_theme_options', $this->dashboard_slug, array($this, 'dashboard_print_welcome'), 'dashicons-dashboard-icon', 3);
    }

    public function dashboard_admin_bar_menu($wp_admin_bar){

        if ( ! is_object( $wp_admin_bar ) ) {
            global $wp_admin_bar;
        }
        $wp_admin_bar->add_menu(array(
            'id' => 'dashboard-admin-bar', 
            'title' => '<i class="dashboard-icon"></i>' . $this->theme_name, 
            'href' => admin_url('admin.php?page=' . fl_dashboard()->dashboard_slug),
            'meta' => array( 'class' => 'fl_link_admin' ),
        ));

    }

    public function dashboard_print_welcome(){
        require_once (dirname(__FILE__).'/welcome.php');
    }


};


function fl_dashboard(){
    return new Fl();
}


fl_dashboard();

global $pagenow;




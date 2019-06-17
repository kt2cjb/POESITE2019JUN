<?php

require_once('includes/post_types.php');
require_once('includes/ajax.php');


// AJAX URLをブローバル変数に出力
function add_my_ajaxurl() {
?>
    <script>
        var ajax_url = '<?php echo admin_url( 'admin-ajax.php'); ?>';
    </script>
<?php
}

add_action( 'wp_head', 'add_my_ajaxurl', 1 );

function shortcode_tp() {
    return get_template_directory_uri();
}
add_shortcode('template', 'shortcode_tp');

remove_filter('the_content', 'wpautop');

function my_admin_style() {
echo '<style>
    
</style>'.PHP_EOL;
}
add_action('admin_print_styles', 'my_admin_style');


function my_admin_footer_script() {
echo "<script>
jQuery(function ($) {
$('#work_cat-all #work_cat-3').find('#in-work_cat-3').parents('label').css({'font-weight':'bold'}).find('input').remove();
$('#work_cat-all #work_cat-4').find('#in-work_cat-4').parents('label').css({'font-weight':'bold'}).find('input').remove();
$('#work_cat-all #work_cat-5').find('#in-work_cat-5').parents('label').css({'font-weight':'bold'}).find('input').remove();
});
</script>".PHP_EOL;
}
add_action('admin_print_footer_scripts', 'my_admin_footer_script');
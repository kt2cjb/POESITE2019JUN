<div class="wrap about-wrap fl-dashboard cf">

    <img class="fl-dashboard-img" src="<?php echo plugin_dir_url( __FILE__ ). 'img/dashboard.png'; ?>" alt="<?php echo fl_dashboard()->theme_name; ?>">

    <div class="fl-dashboard-info-box">
        <h3 class="fl-dashboard_title"><?php printf(fl_dashboard()->strings['dashboard_title'], fl_dashboard()->theme_name ,'<span class="fl_theme_version">V'.fl_dashboard()->theme_version).'</span>'; ?> </h3>
        <div class="fl-dashboard-about"><?php printf(fl_dashboard()->strings['dashboard_subtitle'], fl_dashboard()->theme_name); ?></div>
        <p>

        </p>
    </div>


    <div class="clear"></div>

    <?php

    $php_min_requirements = array(
        'php_version' => '5.3.0',
        'memory_limit' => '256',
        'max_execution_time' => 180,
    );

    $php_memory_limit = preg_replace("/[^0-9]/", '', ini_get('memory_limit'));
    $min_memory = $php_min_requirements['memory_limit'];
    $req_memory_limit = $php_memory_limit >= $min_memory;

    $req_php_version = true;

    if(function_exists('phpversion')) {
        $php_ver = phpversion();
        $req_php_version = version_compare($php_ver, $php_min_requirements['php_version'], '>=');
    }

    $req_max_exec_time = true;

    if(function_exists('ini_get')) {
        $time_limit = ini_get('max_execution_time');
        $req_max_exec_time = $time_limit >= $php_min_requirements['max_execution_time'];
    }

    $requirements_all_is_well = $req_memory_limit && $req_php_version && $req_max_exec_time;

    ?>

    <div class="fl-dashboard-box">

        <div class="fl-dashboard-widget--title">
            <?php if($requirements_all_is_well) { ?>

                <mark class="true"><?php echo fl_dashboard()->strings['widget_requirements_title']; ?></mark>
                <span class="fl-dashboard-widget--title-badge true"><?php echo fl_dashboard()->strings['widget_requirements_noproblems']; ?></span>

            <?php } else { ?>

                <mark class="false"><?php echo fl_dashboard()->strings['widget_requirements_title']; ?></mark>
                <span class="fl-dashboard-widget--title-badge false"><?php echo fl_dashboard()->strings['widget_requirements_problems']; ?></span>

            <?php } ?>
        </div>

        <div class="fl-dashboard-widget--content">
            <div class="fl-widget-requirements">
                <table class="widefat" cellspacing="0">
                    <tbody>
                    <tr>
                        <td><?php esc_html_e('PHP Version:', 'dreamy'); ?></td>
                        <td>
                            <?php
                            if(function_exists('phpversion')) {
                                if($req_php_version) {
                                    echo '<mark class="true"><i class="fa fa-check"></i> ' . esc_attr($php_ver) . '</mark>';
                                } else {
                                    echo '<mark class="false fl-drop-parent">';
                                    echo '<i class="fa fa-times"></i> ' . esc_attr($php_ver);
                                    echo ' <small>[' . fl_dashboard()->strings['widget_more_info_text'] . ']</small>';
                                    echo '<span class="fl-drop-content">';
                                    echo sprintf(esc_html__('We recommend upgrade php version to at least %s.', 'dreamy'), $php_min_requirements['php_version']);
                                    echo '</span>';
                                    echo '</mark>';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('WP Memory Limit:', 'dreamy'); ?></td>
                        <td>
                            <?php

                            if ($req_memory_limit) {
                                echo '<mark class="true"><i class="fa fa-check"></i> ' . esc_attr($php_memory_limit . 'M') . '</mark>';
                            } else {
                                echo '<mark class="false fl-drop-parent"><i class="fa fa-times"></i> ' . esc_attr($php_memory_limit . 'M') . ' ';
                                echo '<small>[' . fl_dashboard()->strings['widget_more_info_text'] . ']</small>';
                                echo '<span class="fl-drop-content">';
                                echo sprintf(esc_html__('For normal usage will be enough 128M, but for importing demo we recommend setting memory to at least %s.', 'dreamy'),
                                    '<strong>' . esc_attr($php_min_requirements['memory_limit'] . 'M') . '</strong><br>'
                                );
                                echo sprintf(esc_html__('Read more: %s', 'dreamy'), sprintf('<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">%s</a>', esc_html__('Increasing memory allocated to PHP.', 'dreamy'))
                                );
                                echo '</span>';
                                echo '</mark>';
                            }
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('PHP Time Limit:', 'dreamy'); ?></td>
                        <td>
                            <?php if(function_exists('ini_get')):
                                if($req_max_exec_time) {
                                    echo '<mark class="true"><i class="fa fa-check"></i> ' . esc_attr($time_limit) . '</mark>';
                                } else {
                                    echo '<mark class="false fl-drop-parent">';
                                    echo '<i class="fa fa-times"></i> ' . esc_attr($time_limit);
                                    echo ' <small>[' . fl_dashboard()->strings['widget_more_info_text'] . ']</small>';
                                    echo '<span class="fl-drop-content">';
                                    echo sprintf(esc_html__('We recommend setting max execution time to at least %s.', 'dreamy'), esc_attr($php_min_requirements['max_execution_time']));
                                    echo ' <br> ';
                                    echo sprintf(esc_html__('See more: %s', 'dreamy'), sprintf('<a href="http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded" target="_blank">%s</a>', esc_html__('Increasing max execution to PHP', 'dreamy'))
                                    );
                                    echo '</span>';
                                    echo '</mark>';
                                }
                            endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Child Theme:', 'dreamy'); ?></td>
                        <td>
                            <?php
                            if(fl_dashboard()->theme_is_child) {
                                echo '<mark class="true"><i class="fa fa-check"></i></mark>';
                            } else {
                                echo '<mark class="fl-drop-parent"><i class="fa fa-times"></i> ';
                                echo '<small>[' . fl_dashboard()->strings['widget_more_info_text'] . ']</small>';
                                echo '<span class="fl-drop-content">'.esc_html__('We recommend use child theme to prevent loosing your customizations after theme update.', 'dreamy')
                                    .'</span>';
                                echo '</mark>';
                            }?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    </div>

    <div class="clear"></div>



    <p class="fl-thank-you">
        <?php printf(fl_dashboard()->strings['footer_thank_you'], fl_dashboard()->theme_name); ?>
    </p>


</div>
<!--end .wrap-->

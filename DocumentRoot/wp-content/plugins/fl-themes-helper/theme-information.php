	<div class="wrap">
        <div class="fl_information">
        <h1 class="theme_name">
           <?php echo esc_html__('Welcome to','rest') ; ?>
            <?php
            $rest_current_theme = wp_get_theme();
            echo esc_attr($rest_current_theme->get( 'Name' )).' <sup class="small_version_sup">V<i class="small_version">'.esc_attr($rest_current_theme->get( 'Version' )); ?></i></sup></h1>
            <div class="welcome_information">
                <p><?php esc_html_e('Thank you very much for purchasing our theme.', 'rest'); ?></p>
            </div>
        </div>
        <div class="cf">

            <div class="fl-dashboard-widget">
                <?php
                $min_requirements = fl_theme()->theme_dashboard()->options['min_requirements'];
                // requirements check
                $memory = fl_theme()->let_to_num( WP_MEMORY_LIMIT );
                $min_memory = fl_theme()->let_to_num( $min_requirements['memory_limit'] );
                $req_memory_limit = $memory >= $min_memory;

                $req_php_ver = true;
                if(function_exists('phpversion')) {
                    $php_ver = phpversion();
                    $req_php_ver = version_compare($php_ver, $min_requirements['php_version'], '>=');
                }

                $req_max_exec_time = true;
                if(function_exists('ini_get')) {
                    $time_limit = ini_get('max_execution_time');
                    $req_max_exec_time = $time_limit >= $min_requirements['max_execution_time'];
                }

                $req_all_ok = $req_memory_limit && $req_php_ver && $req_max_exec_time;

                ?>

                <div class="fl-dashboard-widget-title">
                    <?php
                    if($req_all_ok) {
                        ?>
                        <mark class="yes"><?php esc_html_e('Recommendations', 'rest'); ?></mark>
                        <span class="fl-dashboard-widget-title-badge yes"><i class="fa fa-thumbs-up"></i><?php esc_html_e('No Problems', 'rest'); ?></span>
                        <?php
                    } else {
                        ?>
                        <mark class="error"><?php esc_html_e('Recommendations', 'rest'); ?></mark>
                        <span class="fl-dashboard-widget-title-badge error"><?php esc_html_e('Some Problems', 'rest'); ?></span>
                        <?php
                    }
                    ?>
                </div>
                <div class="fl-dashboard-widget-content">
                    <div class="fl-theme-requirements">
                        <table class="widefat" cellspacing="0">
                            <tbody>

                            <tr>
                                <td><?php esc_html_e( 'PHP Version:', 'rest' ); ?></td>
                                <td><?php
                                    if (function_exists('phpversion')) {
                                        if ($req_php_ver) {
                                            echo '<mark class="yes no_problem"><i class="fa fa-check"></i> ' . $php_ver . '</mark>';
                                        } else {
                                            echo '<mark class="error fl-drop some_problem">';
                                            echo '<i class="fa fa-times"></i> ' . $php_ver;
                                            echo ' <small>' . esc_html__('[more info]', 'rest') . '</small>';
                                            echo '<span class="fl-drop-cont"><span class="drop-info">';
                                            echo sprintf( esc_html__( 'We recommend upgrade php version to at least %s.', 'rest' ), $min_requirements['php_version'] );
                                            echo '</span></span>';
                                            echo '</mark>';
                                        }
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e( 'PHP Time Limit:', 'rest' ); ?></td>
                                <td>
                                    <?php if (function_exists('ini_get')) :
                                        if ($req_max_exec_time) {
                                            echo '<mark class="yes no_problem"><i class="fa fa-check"></i> ' . $time_limit . '</mark>';
                                        } else {
                                            echo '<mark class="error fl-drop some_problem">';
                                            echo '<i class="fa fa-times"></i> ' . $time_limit;
                                            echo ' <small>' . esc_html__('[more info]', 'rest') . '</small>';
                                            echo '<span class="fl-drop-cont"><span class="drop-info">';
                                            echo sprintf( esc_html__( 'We recommend setting max execution time to at least %s.', 'rest' ), $min_requirements['max_execution_time'] );
                                            echo ' <br> ';
                                            echo sprintf(
                                                esc_html__('See more: %s', 'rest'),
                                                sprintf('<a href="http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded" target="_blank">%s</a>', esc_html__('Increasing max execution to PHP', 'rest'))
                                            );
                                            echo '</span></span>';
                                            echo '</mark>';
                                        }
                                    endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e( 'WP Memory Limit:', 'rest' ); ?></td>
                                <td><?php
                                    if ($req_memory_limit) {
                                        echo '<mark class="yes no_problem"><i class="fa fa-check"></i> ' . size_format($memory) . '</mark>';
                                    } else {
                                        echo '<mark class="error fl-drop some_problem"><i class="fa fa-times" aria-hidden="true"></i> ' . size_format($memory) . ' ';
                                        echo '<small>' . esc_html__('[more info]', 'rest') . '</small>';
                                        echo '<span class="fl-drop-cont"><span class="drop-info">';
                                        echo sprintf(
                                            esc_html__( 'We recommend setting memory to at least %s.', 'rest' ),
                                            '<strong>' . size_format($min_memory) . '</strong>'
                                        );
                                        echo ' <br> ';
                                        echo sprintf(
                                            esc_html__( 'See more: %s', 'rest' ),
                                            sprintf('<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">%s</a>', esc_html__('Increasing memory allocated to PHP.', 'rest'))
                                        );
                                        echo '</span></span>';
                                        echo '</mark>';
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e( 'Child Theme:', 'rest' ); ?></td>
                                <td><?php
                                    if(fl_theme()->theme_dashboard()->theme_is_child) {
                                        echo '<mark class="yes no_problem some_problem"><i class="fa fa-check"></i></mark>';
                                    } else {
                                        ?>
                                        <mark class="fl-drop child-theme">
                                            <i class="fa fa-times"></i>
                                            <small><?php esc_html_e('[more info]', 'rest'); ?></small>
                                            <span class="fl-drop-cont">
                                                <span class="drop-info">
                                            <?php esc_html_e('We recommend use child theme to prevent loosing your customizations after theme update.', 'rest'); ?>
                                                 </span>
                                        </span>
                                        </mark>
                                        <?php
                                    }
                                    ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="fl-dashboard-information-widget-support">
                <div class="fl-dashboard-widget-title">
                    <mark><?php esc_html_e('Support', 'rest'); ?></mark>
                </div>
                <div class="fl-dashboard-widget-content">
                    <p><?php esc_html_e('Have troubles, found a bug or want to suggest something? Write in support system.', 'rest'); ?></p>
                    <p><em><?php esc_html_e('Make sure, you have a valid license, otherwise we don\'t provide support.', 'rest'); ?></em></p>
                    <?php
                    printf('<a href="%s" class="button button-primary" target="_blank">%s</a>', 'https://fl.ticksy.com/', esc_html__('Get Support', 'rest'));
                    ?>
                </div>
            </div>
        </div>
	</div>

<?php
function fl_number_settings_field($settings, $value) {
    $suffix     = isset($settings['suffix']) ? $settings['suffix'] : '';
    return '<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" type="number" min="'.intval($settings['min']).'" max="'.intval($settings['max']).'" step="'.intval($settings['step']).'" value="' . esc_attr($value) . '" style="max-width: calc(100% - 40px); margin-right: 10px;" />'.esc_html($suffix);
}
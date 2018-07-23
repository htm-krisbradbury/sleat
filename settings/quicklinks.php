<?php 

$page = new admin_settingpage("{$component}_fp_ql", new lang_string('fpqlsettings', $component));
// Toggle FP Quicklinks.
$name               = "{$component}/fp_ql_toggle";
$title              = new lang_string('fp_ql_toggle', $component);
$description        = new lang_string('fp_ql_toggledesc', $component);
$alwaysdisplay      = new lang_string('displayalways', $component);
$displaybeforelogin = new lang_string('displaybeforelogin', $component);
$displayafterlogin  = new lang_string('displayafterlogin', $component);
$dontdisplay        = new lang_string('displaynever', $component);
$default            = 0;
$choices            = array(0 => $dontdisplay, 1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin);
$setting            = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Number of quicklinks
$name        = "{$component}/fp_ql_count";
$title       = new lang_string('fp_ql_count', $component);
$description = new lang_string('fp_ql_countdesc', $component);
$default     = 6;
$choices     = range(0, 12);
unset($choices[0]);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

for ($i = 1; $i <= get_config($component, 'fp_ql_count'); $i++) {
    $name        = "{$component}/fp_ql_{$i}_header";
    $heading     = new lang_string('quicklinkheader', $component) . $i;
    $information = new lang_string('quicklinkinfo', $component) . $i;
    $setting     = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    $name        = "{$component}/fp_ql_{$i}_title";
    $title       = new lang_string('qltitle', $component);
    $description = new lang_string('qltitledesc', $component);
    $default     = '';
    $setting     = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name        = "{$component}/fp_ql_{$i}_url";
    $title       = new lang_string('qlurl', $component);
    $description = new lang_string('qlurldesc', $component);
    $default     = '';
    $setting     = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Image.
    $name        = "{$component}/fp_ql_{$i}_image";
    $title       = new lang_string('qlimg', $component);
    $description = new lang_string('qlimg', $component);
    $setting     = new admin_setting_configstoredfile($name, $title, $description, "fp_ql_{$i}_image");
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
}
$settings->add($page);

?>
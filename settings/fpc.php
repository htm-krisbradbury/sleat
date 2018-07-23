<?php 


$page = new admin_settingpage("{$component}_fp_content", new lang_string('fpcontentsettings', $component));

// Toggle frontpage content.
$name               = "{$component}/togglefrontpagecontent";
$title              = new lang_string('togglefrontpagecontent', $component);
$description        = new lang_string('togglefrontpagecontentdesc', $component);
$alwaysdisplay      = new lang_string('alwaysdisplay', $component);
$displaybeforelogin = new lang_string('displaybeforelogin', $component);
$displayafterlogin  = new lang_string('displayafterlogin', $component);
$dontdisplay        = new lang_string('dontdisplay', $component);
$default            = 0;
$choices            = array(0 => $dontdisplay, 1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin);
$setting            = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Content setting.
$name        = "{$component}/frontpagecontent";
$title       = new lang_string('frontpagecontent', $component);
$description = new lang_string('frontpagecontentdesc2', $component);
$default     = '';
$setting     = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);
?>
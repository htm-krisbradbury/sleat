<?php 

$page = new admin_settingpage("{$component}_advanced", new lang_string('advancedsettings', $component));

// Custom CSS file.
$name        = "{$component}/customcss";
$title       = new lang_string('customcss', $component);
$description = new lang_string('customcssdesc', $component);
$setting     = new admin_setting_configtextarea($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);

?>
<?php

$page = new admin_settingpage("{$component}_tiles", new lang_string('tilessettings', $component));

// Toggle course tiles.
$name        = "{$component}/course_tiles";
$title       = new lang_string('course_tiles', $component);
$description = new lang_string('course_tiles_desc', $component);
$default     = '0';
$setting     = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);


?>
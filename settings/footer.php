<?php 

$page = new admin_settingpage("{$component}_footer", new lang_string('footersettings', $component));

$name        = "{$component}/footer_bgcolour";
$title       = new lang_string('footer_bgcolour', $component);
$description = new lang_string('footer_bgcolour_desc', $component);
$setting     = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footnote
$name        = "{$component}/footnote";
$title       = new lang_string('footnote', $component);
$description = new lang_string('footnotedesc', $component);
$setting     = new admin_setting_confightmleditor($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Accreditation
$name        = "{$component}/accreditation";
$title       = new lang_string('accreditation', $component);
$description = new lang_string('accreditation_desc', $component);
$setting     = new admin_setting_configstoredfile($name, $title, $description, 'accreditation');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);

?>